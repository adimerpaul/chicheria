<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Material::with('compras')->with('recuentos')->get();

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
        $material=new Material;
        $material->nombre=strtoupper($request->nombre);
        $material->unid=strtoupper($request->unid);
        $material->min=$request->min;
        $material->stock=0;
        $material->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        //
        $material=Material::find($request->id);
        $material->nombre=strtoupper($request->nombre);
        $material->unid=strtoupper($request->unid);
        $material->min=$request->min;
        //$material->stock=0;
        $material->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $material=Material::find($id);
        $material->delete();
    }

    public function repalmacen(Request $request){
        return DB::SELECT("( select 'compra' tipo,p.razon,m.nombre,c.fecha,c.hora,c.costo,c.cantidad,c.fechaven,c.observacion 
                    from compras c inner join providers p on c.provider_id=p.id inner join materials m on c.material_id = m.id
                     where c.material_id=$request->id and c.fecha>='$request->fecha1' and c.fecha<='$request->fecha2') 
                     union ALL
             (SELECT 'retiro' tipo,'' razon,m.nombre,r.fecha,r.hora,'' costo,r.cantidad,'' fechaven,r.observacion 
             FROM recuentos r inner join materials m on r.material_id=m.id 
             where m.id=$request->id and r.fecha>='$request->fecha1' and r.fecha<='$request->fecha2') 
             order by fecha,hora;");
    }
}
