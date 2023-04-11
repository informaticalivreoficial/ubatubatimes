<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fatura;
use App\Models\Gateway;
use Carbon\Carbon;
use Illuminate\Http\Request;
use WebMaster\PagHiper\PagHiper;

class FaturaController extends Controller
{
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
            $_POST['notification_id'], 
            $_POST['idTransacao']
        );
        $fatura = Fatura::where('id', $_POST['idTransacao'])->first();
        $fatura->transaction_id = $_POST['notification_id'];
        // $fatura->status = $request->create_request['status'];
        // $fatura->vencimento = $request->create_request['due_date'];
        // $fatura->url_slip = $request->create_request['bank_slip']['url_slip'];
        // $fatura->url_slip_pdf = $request->create_request['bank_slip']['url_slip_pdf'];
        // $fatura->bar_code_number_to_image = $request->create_request['bank_slip']['bar_code_number_to_image'];
        $fatura->save(); 
    }
}
