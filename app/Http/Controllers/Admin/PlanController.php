<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->paginate(10);
        
        return view('admin.anuncios.plans.index',[
            'plans' => $plans
        ]);
    }

    public function create()
    {
        return view('admin.anuncios.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $criarPlano = Plan::create($data);
        
        return Redirect::route('plans.edit', [
            'id' => $criarPlano->id,
        ])->with(['color' => 'success', 'message' => 'Plano cadastrado com sucesso!']);
    }

    public function edit($id)
    {
        $plan = Plan::where('id', $id)->first();
        return view('admin.plans.edit',[
            'plan' => $plan
        ]);
    }

    public function update(Request $request, $id)
    {        
        $planUpdate = Plan::where('id', $id)->first();
        $planUpdate->fill($request->all());  
        $planUpdate->save();

        return Redirect::route('plans.edit', [
            'id' => $planUpdate->id,
        ])->with(['color' => 'success', 'message' => 'Plano atualizado com sucesso!']);
    } 

    public function planSetStatus(Request $request)
    {        
        $plan = Plan::find($request->id);
        $plan->status = $request->status;
        $plan->save();
        return response()->json(['success' => true]);
    }
}
