<?php

namespace App\Http\Controllers;

use App\Models\Logcaja;
use App\Models\Caja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogcajaController extends Controller
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
    public function listcaja(Request $request){
        //return $request;
        if($request->user()->id==1)
        {
            if($request->user_id==0) return Logcaja::with('user')->whereDate('fecha','>=',$request->fecha1)->whereDate('fecha','<=',$request->fecha2)->get();
            else return Logcaja::with('user')->where('user_id',$request->user_id)->whereDate('fecha','>=',$request->fecha1)->whereDate('fecha','<=',$request->fecha2)->get();
        }
        else
        return Logcaja::with('user')->where('user_id',$request->user()->id)->whereDate('fecha','>=',$request->fecha1)->whereDate('fecha','<=',$request->fecha2)->get();
       
    }

    public function totalcaja(){
        return DB::SELECT('SELECT * from cajas where id=1')[0];
    }

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
        $log=new Logcaja ;
        $log->monto=$request->monto;
        $log->motivo=$request->motivo;
        $log->tipo=$request->tipo;
        $log->fecha=date('Y-m-d');
        $log->hora=date('H:i:s');
        $log->user_id=$request->user()->id;
        $log->save();
        $caja=Caja::find(1);

        if($request->tipo=='RETIRA')
            $caja->monto=floatval($caja->monto) - floatval($request->monto);
            
        else
            $caja->monto=floatval($caja->monto) + floatval($request->monto);
        
            $caja->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Logcaja  $logcaja
     * @return \Illuminate\Http\Response
     */
    public function show(Logcaja $logcaja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logcaja  $logcaja
     * @return \Illuminate\Http\Response
     */
    public function edit(Logcaja $logcaja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logcaja  $logcaja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logcaja $logcaja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logcaja  $logcaja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logcaja $logcaja)
    {
        //

        if($logcaja->tipo=='GASTO' || $logcaja->tipo=='RETIRO'){
            $caja=Caja::find(1);
            $caja->monto=floatval($caja->monto) + floatval($logcaja->monto);
            $caja->save();
        
        }
        if($logcaja->tipo=='AGREGA'){
            $caja=Caja::find(1);
            $caja->monto=floatval($caja->monto) - floatval($logcaja->monto);
            $caja->save();
        
        }
        $logcaja->delete();

    }
}
