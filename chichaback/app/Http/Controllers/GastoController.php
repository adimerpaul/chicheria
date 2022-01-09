<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GastoController extends Controller
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
    public function misgastos(Request  $request){
        if($request->user()->id==1)
        {
            if($request->id==0) return Gasto::with('user')->whereDate('fecha','>=',$request->fecha1)->whereDate('fecha','<=',$request->fecha2)->orderBy('id','desc')->get();
            else return Gasto::with('user')->where('user_id',$request->id)->whereDate('fecha','>=',$request->fecha1)->whereDate('fecha','<=',$request->fecha2)->orderBy('id','desc')->get();
        }
        else
        return Gasto::with('user')->where('user_id',$request->user()->id)->whereDate('fecha','>=',$request->fecha1)->whereDate('fecha','<=',$request->fecha2)->orderBy('id','desc')->get();
        //return Gasto::with('user')->whereDate('fecha','>=',$request->fecha1)->whereDate('fecha','<=',$request->fecha2)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gasto=new Gasto();
        $gasto->precio=$request->precio;
        $gasto->observacion=$request->observacion;
        $gasto->glosa=$request->glosa;
        $gasto->fecha=$request->fecha;
        $gasto->hora=date('H:i:s');
        $gasto->user_id=$request->user()->id;
        $gasto->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function show(Gasto $gasto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function edit(Gasto $gasto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gasto $gasto)
    {
        $gasto->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gasto $gasto)
    {
        $gasto->delete();
    }

    public function listglosa(){
        return DB::SELECT('SELECT glosa from gastos group by glosa');
    }
}
