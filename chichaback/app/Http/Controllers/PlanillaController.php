<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Planilla;
use Illuminate\Http\Request;

class PlanillaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //return $request;
        $planilla= new Planilla;
        $planilla->fechainicio=$request->fechainicio;
        $planilla->fechafin=$request->fechafin;
        $planilla->fechapago=$request->fechapago;
        $planilla->monto=$request->monto;
        $planilla->adelanto=$request->adelanto;
        $planilla->descuento=$request->descuento;
        $planilla->bono=$request->bono;
        $planilla->restante=$request->restante;
        $planilla->total=$request->total;
        $planilla->empleado_id=$request->empleado_id;
        $planilla->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planilla  $planilla
     * @return \Illuminate\Http\Response
     */
    public function show($empleado_id)
    {
//        return $empleado_id;
        return Planilla::where('empleado_id',$empleado_id)->orderBy('id','desc')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planilla  $planilla
     * @return \Illuminate\Http\Response
     */
    public function edit(Planilla $planilla)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planilla  $planilla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Planilla $planilla)
    {
        $planilla->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planilla  $planilla
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planilla $planilla)
    {
        $planilla->delete();
    }
}
