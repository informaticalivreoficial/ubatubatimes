<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fatura;
use App\Models\Gateway;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use WebMaster\PagHiper\PagHiper;

class FaturaController extends Controller
{
    public function faturas()
    {
        $faturas = Fatura::orderBy('created_at', 'DESC')->paginate(35);        
        return view('admin.faturas.faturas',[
            'faturas' => $faturas
        ]);
    }

    public function create()
    {
        return view('admin.faturas.create');
    }

    public function store(Request $request)
    {
        $mensagens = [
            'required'      => 'O :attribute é obrigatório!',
            'titulo.required'      => 'A descrição da Fatura é obrigatória!',
            'required_if'   => 'O campo :attribute é obrigatório quando o campo :other for selecionado!',            
        ];
    
        $request->validate([
            'nome' => 'required_if:pfpf,on',//|min:3|max:191
            'email' => 'required|email',
            'cpf' => 'required_if:pfpf,on',//|min:11|max:14
            'company' => 'required_if:pfpj,on',//|min:3|max:191
            'cnpj' => 'required_if:pfpj,on',//|min:14|max:18            
            'titulo' => 'required',
            'vencimento' => 'required',
            'valor' => 'required',
            'pedido' => (!empty($request->all()['id']) ? 'required|unique:faturas,pedido,' . $request->all()['id'] : 'required|unique:faturas,pedido'),
        ], $mensagens);

        $data = $request->all();
        $data['status'] = 'pending';
        $criarFatura = Fatura::create($data);
        $criarFatura->save();              
        return Redirect::route('faturas.edit', [
            'id' => $criarFatura->id,
        ])->with(['color' => 'success', 'message' => 'Fatura criada com sucesso!']);
    }

    public function edit($id)
    {
        $fatura = Fatura::where('id', $id)->first();
        return view('admin.faturas.edit',[
            'fatura' => $fatura
        ]);
    }

    public function show($id)
    {
        $fatura = Fatura::where('id', $id)->first();
        $gateways = Gateway::orderBy('created_at', 'ASC')->available()->get();
        return view('admin.faturas.show',[
            'fatura' => $fatura,
            'gateways' => $gateways
        ]);
    }

    public function pagar($fatura)
    {
        $fatura = Fatura::where('id', $fatura)->first();
        $data = [
            'order_id' => $fatura->id,
            'payer_name' => $fatura->getEmpresa->alias_name,
            'payer_email' => $fatura->getEmpresa->email,
            'payer_cpf_cnpj' => ($fatura->getEmpresa->document_company ? $fatura->getEmpresa->document_company : $fatura->getEmpresa->responsavel_cpf),
            'days_due_date' => Carbon::parse($fatura->vencimento)->diffInDays(Carbon::parse(Carbon::now())),
            'type_bank_slip' => 'boletoA4',
            'notification_url' => route('web.getTransaction'),
        ];

        $items['items'][] = [                    
            'description' => $fatura->getAnuncio->plano->name,
            'quantity' => 1,
            'item_id' => $fatura->getAnuncio->plano->id,
            'price_cents' => str_replace(',', '.', str_replace('.', '', $fatura->getAnuncio->plano->valor_mensal))                    
        ];
        
        $array = array_merge($data, $items);
        $this->gerarBoleto($array);
    }

    public function gerarBoleto($data)
    {
        $paghiper = new PagHiper(
            env('PAGHIPER_APIKEY'), 
            env('PAGHIPER_TOKEM')
        );
        $transaction = $paghiper->billet()->create($data);
    }

    public function retornoBoleto(Request $request)
    {        
        $fatura = Fatura::where('id', $request->create_request['order_id'])->first();
        $fatura->transaction_id = $request->create_request['transaction_id'];
        $fatura->status = $request->create_request['status'];
        $fatura->vencimento = $request->create_request['due_date'];
        $fatura->url_slip = $request->create_request['bank_slip']['url_slip'];
        $fatura->url_slip_pdf = $request->create_request['bank_slip']['url_slip_pdf'];
        $fatura->bar_code_number_to_image = $request->create_request['bank_slip']['bar_code_number_to_image'];
        $fatura->save();      
    }

    public function getTransaction(Request $request)
    {        
        $paghiper = new PagHiper(
            env('PAGHIPER_APIKEY'), 
            env('PAGHIPER_TOKEM')
        );
        
        $transaction = $paghiper->notification()->response(
            '041KPPVOSPLSV923', 
            '1'
        );
        //$fatura = Fatura::where('id', $_POST['idTransacao'])->first();
        //$fatura->transaction_id = $_POST['notification_id'];
        // $fatura->status = $request->create_request['status'];
        // $fatura->vencimento = $request->create_request['due_date'];
        // $fatura->url_slip = $request->create_request['bank_slip']['url_slip'];
        // $fatura->url_slip_pdf = $request->create_request['bank_slip']['url_slip_pdf'];
        // $fatura->bar_code_number_to_image = $request->create_request['bank_slip']['bar_code_number_to_image'];
        //$fatura->save(); 
    }

    public function cancelarBoleto($data)
    {
        $paghiper = new PagHiper(
            env('PAGHIPER_APIKEY'), 
            env('PAGHIPER_TOKEM')
        );
        $transaction = $paghiper->billet()->cancel($data);
    }

    public function statusBoleto(Request $request)
    {        
        $paghiper = new PagHiper(
            env('PAGHIPER_APIKEY'), 
            env('PAGHIPER_TOKEM')
        );

        $transaction = $paghiper->billet()->status($request->pedido);
        
        if($transaction['result'] === 'success'){
            $fatura = Fatura::where('pedido', $transaction['order_id'])->first();
            $fatura->status = $transaction['status'];
            $fatura->vencimento = $transaction['due_date'];
            $fatura->digitable_line = $transaction['bank_slip']['digitable_line'];
            $fatura->url_slip = $transaction['bank_slip']['url_slip'];
            $fatura->url_slip_pdf = $transaction['bank_slip']['url_slip_pdf'];
            $fatura->save();
            $json = ['success' => 'Fatura atualizada!'];
        }else{
            $json = ['error' => 'Erro ao Atualizar!'];
        }
        return response()->json($json);
    }

    public function pagarFaturaUnica(Request $request)
    {
        $fatura = Fatura::where('pedido', $request->id)->first();
        $data = [
            'order_id' => $fatura->pedido,
            'payer_name' => $fatura->company ?? $fatura->nome,
            'payer_email' => $fatura->email,
            'payer_phone' => $fatura->telefone ?? null,
            'payer_cpf_cnpj' => $fatura->cnpj ?? $fatura->cpf,
            'days_due_date' => Carbon::parse($fatura->vencimento)->diffInDays(Carbon::parse(Carbon::now())),
            'type_bank_slip' => 'boletoA4',
            //'notification_url' => route('web.getTransaction'),
        ];

        $items['items'][] = [                    
            'description' => $fatura->titulo,
            'quantity' => 1,
            'item_id' => $fatura->id,
            'price_cents' => str_replace(',', '.', str_replace('.', '', $fatura->valor))                    
        ];
        
        $array = array_merge($data, $items);
        $this->gerarBoleto($array);
    }
}
