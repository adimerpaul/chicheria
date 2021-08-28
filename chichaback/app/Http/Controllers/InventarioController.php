<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Loginventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Inventario::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $inventario=Inventario::create($request->all());
        return $inventario;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Inventario $inventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventario $inventario)
    {
        //
        $inventario->update($request->all());
        return $inventario;
    }

    public function activarinv(Request $request)
    {
        //
        $inventario=Inventario::find($request->id);
        if($inventario->estado=='ACTIVO')
            $inventario->estado='INACTIVO';
        else {
            $inventario->estado='ACTIVO';
        }
        $inventario->save();
        return $inventario;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $inventario=Inventario::find($id);
        $inventario->delete();
        return response()->json(['res'=>'Borrado exitoso'],200);
    }

    public function productadd(Request $request){
//        return "a";
        $log=new Loginventario();
        $log->cantidad=$request->cantidad;
        $log->inventario_id=$request->id;
        $log->fecha=date('Y-m-d');
        $log->agregar=true;
        $log->user_id=$request->user()->id;
        $log->motivo=$request->motivo;
        $log->save();

        $inventario=Inventario::find($request->id);
        $inventario->cantidad+=$request->cantidad;
        return $inventario->save();
    }

    public function productsub(Request $request){
        $log=new Loginventario();
        $log->cantidad=$request->cantidad;
        $log->inventario_id=$request->id;
        $log->agregar=false;
        $log->fecha=date('Y-m-d');
        $log->user_id=$request->user()->id;
        $log->motivo=$request->motivo;
        $log->save();

        $inventario=Inventario::find($request->id);
        if($inventario->cantidad < $request->cantidad)
            $inventario->cantidad=0;
        else
            $inventario->cantidad-=$request->cantidad;
        return $inventario->save();
    }

    public function listainventario(){
        return Inventario::where('estado','ACTIVO')->get();
    } 
}
