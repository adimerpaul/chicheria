<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Sueldo;
use App\Models\Gasto;
use Illuminate\Http\Request;

class SueldoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sueldo::all();
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
//        return Sueldo::create($request->all());
        $sueldo=new Sueldo();
        $sueldo->fecha=$request->fecha;
        $sueldo->hora=date('H:i:s');
        $sueldo->monto=$request->monto;
        $sueldo->tipo=$request->tipo;
        $sueldo->empleado_id=$request->empleado_id;
        $sueldo->observacion=$request->observacion;
        $sueldo->user_id=$request->user()->id;
        $sueldo->save();
        if($request->tipo=='ADELANTO')
        {
            $gasto=new Gasto;
            $gasto->precio=$request->monto;
            $gasto->observacion=$request->observacion.' '.$request->empleado_nombre;
            $gasto->glosa='ADELANTO';
            $gasto->fecha=date('Y-m-d');
            $gasto->hora=date('H:i:s');
            $gasto->user_id=$request->user()->id;
            $gasto->save();
        }
        if($request->tipo=='EXTRA')
        {
            $gasto=new Gasto;
            $gasto->precio=$request->monto;
            $gasto->observacion=$request->observacion.' '.$request->empleado_nombre;
            $gasto->glosa='EXTRA';
            $gasto->fecha=date('Y-m-d');
            $gasto->hora=date('H:i:s');
            $gasto->user_id=$request->user()->id;
            $gasto->save();
        }
//        return $sueldo;
        return Empleado::with('sueldos')
            ->where('id',$request->empleado_id)
            ->firstOrFail();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sueldo  $sueldo
     * @return \Illuminate\Http\Response
     */
    public function show(Sueldo $sueldo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sueldo  $sueldo
     * @return \Illuminate\Http\Response
     */
    public function edit(Sueldo $sueldo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sueldo  $sueldo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sueldo $sueldo)
    {
        return $sueldo->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sueldo  $sueldo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sueldo $sueldo)
    {
        $sueldo->delete();
        return 1;
    }
}
