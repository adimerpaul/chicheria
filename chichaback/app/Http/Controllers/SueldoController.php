<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Sueldo;
use App\Models\Gasto;
use App\Models\Glosa;
use App\Models\Caja;
use App\Models\Logcaja;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Else_;

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
        //return $request;
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

        if($request->checkbox=='CAJA'){
        if($request->tipo=='ADELANTO' || $request->tipo=='EXTRA' ){
            $caja=Caja::find(1);
            $caja->monto= floatval($caja->monto) - floatval($request->monto);
            $caja->save();

            $log=new Logcaja ;
            $log->monto=$request->monto;
            $log->motivo=$request->observacion.' '.$request->empleado_nombre;;
            $log->tipo='GASTO';
            $log->fecha=date('Y-m-d');
            $log->hora=date('H:i:s');
            $log->user_id=$request->user()->id;
            $log->save();
        }}
        else{
        if($request->tipo=='ADELANTO' || $request->tipo=='EXTRA' ){
            $glosa=Glosa::where('nombre',$request->tipo)->get();

            $gasto=new Gasto();
            $gasto->precio=$request->monto;
            $gasto->observacion=$request->observacion.' '.$request->empleado_nombre;
            $gasto->glosa=$request->tipo;
            $gasto->glosa_id=$glosa[0]['id'];
            $gasto->fecha=date('Y-m-d');
            $gasto->hora=date('H:i:s');
            $gasto->user_id=$request->user()->id;
            $gasto->save();}
        }

//        return $sueldo;
        return Empleado::with('sueldos')
            ->where('id',$request->empleado_id)
            ->firstOrFail();
    }

    public function cancelacion(Request $request){
            //return $request;

            $sueldo=new Sueldo();
            $sueldo->fecha=$request->fecha;
            $sueldo->hora=date('H:i:s');
            $sueldo->monto=$request->monto;
            $sueldo->tipo='CANCELAR';
            $sueldo->empleado_id=$request->empleado_id;
            $sueldo->observacion='Cancelado';
            $sueldo->user_id=$request->user()->id;
            $sueldo->save();

              if($request->tipo=='CANCELAR'){

                $gasto=new Gasto();
                $gasto->precio=$request->monto;
                $gasto->observacion='Cancelado'.' '.$request->empleado_nombre;
                $gasto->glosa='CANCELAR';
                $gasto->fecha=$request->fecha;
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

    public function impade($id){
        $info=Sueldo::with('empleado')->find($id);
        $cadena="<center>$info->tipo</center>
        <div>Empleado: ".$info->empleado['nombre']."</div>
        <div>Fecha: $info->fecha</div>
        <div>Monto: $info->monto Bs.</div>
        <div>Obs: $info->observacion </div><br><br>
        <center>FIRMA</center>
        ";
        return $cadena;
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
