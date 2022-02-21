<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Cliente::with('prestamos')->get();
    }
    public function agregarcliente(Request $request){
        $cliente= new Cliente();
        $cliente->ci=$request->ci;
        $cliente->titular= strtoupper( $request->titular);
        $cliente->telefono=$request->telefono;
        $cliente->direccion= strtoupper($request->direccion);
        $cliente->tipocliente=$request->tipocliente;
        $cliente->save();
//        Cliente::create($request->all());
    }

    public function listacliente(){
        return Cliente::where('estado','ACTIVO')->orderBy('titular')->get();
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
        $cliente= new Cliente;
        $cliente->local=strtoupper($request->local);
        $cliente->ci=strtoupper($request->ci);
        $cliente->titular=strtoupper($request->titular);
        $cliente->tipo=$request->tipo;
        $cliente->telefono=strtoupper($request->telefono);
        $cliente->fechanac=$request->fechanac;
        $cliente->direccion=strtoupper($request->direccion);
        $cliente->legalidad=$request->legalidad;
        $cliente->categoria=$request->categoria;
        $cliente->razon=strtoupper($request->razon);
        $cliente->nit=strtoupper($request->nit);
        $cliente->observacion=strtoupper($request->observacion);
        $cliente->tipocliente=$request->tipocliente;
        $cliente->save();
        return $cliente;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Cliente::find($id)->get() ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
        $cliente=Cliente::find($request->id);
        $cliente->local=strtoupper($request->local);
        $cliente->titular=strtoupper($request->titular);
        $cliente->tipo=$request->tipo;
        $cliente->telefono=strtoupper($request->telefono);
        $cliente->fechanac=$request->fechanac;
        $cliente->direccion=strtoupper($request->direccion);
        $cliente->legalidad=$request->legalidad;
        $cliente->categoria=$request->categoria;
        $cliente->razon=strtoupper($request->razon);
        $cliente->nit=strtoupper($request->nit);
        $cliente->observacion=strtoupper($request->observacion);
        $cliente->save();
        return $cliente;
    }

    public function activar(Request $request)
    {
        //
        $cliente=Cliente::find($request->id);
        if($cliente->estado=='ACTIVO')
            $cliente->estado='INACTIVO';
        else {
            $cliente->estado='ACTIVO';
        }
        $cliente->save();
        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cliente=Cliente::find($id);
        $cliente->delete();
        return response()->json(['res'=>'Borrado exitoso'],200);
    }

    public function ordercumple(){

         $cliente=DB::select('(select *,MONTH(fechanac) as mes,DAY(fechanac) as dia from clientes
         where MONTH(fechanac)>=MONTH(CURDATE()) order by  mes asc, dia asc)
         ');
         return $cliente;
    }
    public function ordercumple2(){
        $cliente2=DB::select('
        (select *,MONTH(fechanac) as mes,DAY(fechanac) as dia from clientes
         where MONTH(fechanac)<MONTH(CURDATE()) order by  mes asc, dia asc)
         union (select *,"" as mes,"" as dia from clientes where fechanac is null)');
         return $cliente2;
    }

    public function aniver(){
        $cliente=DB::SELECT('SELECT *,MONTH(fechanac) as mes,DAY(fechanac) as dia from clientes
         where MONTH(fechanac)=MONTH(CURDATE()) and DAY(fechanac)>=DAY(CURDATE()) order by dia asc');
         return $cliente;
    }

    public function listado(){
        //return Cliente::where('tipocliente',$tipocliente)->get();
    }


    public function buscarci($request){
        return Cliente::where('tipocliente',$request->tipocliente)->where('ci',$request->ci)->get();
    }

    public function buscarnombre($request){
        return Cliente::where('tipocliente',$request->tipocliente)->where('titular',$request->titular)->get();
    }

    public function buscarlocal($request){
        return Cliente::where('tipocliente',$request->tipocliente)->where('local',$request->local)->get();
    }
}
