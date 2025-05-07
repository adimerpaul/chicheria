<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteController extends Controller{
    function cuentasCobrarDetalle(Request $request){
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $ventas= Venta::with('user')
            ->with('cliente')
            ->with('pagos')
            ->whereDate('fecha','>=',$fechaInicio)
            ->whereDate('fecha','<=',$fechaFin)
            ->where('tipo','DETALLE')
            ->whereRaw("(fechaentrega is null OR fechaentrega='')")
            //->where('saldo','>',0)
            ->whereRaw("total > acuenta")
            ->get();
        $pdf = Pdf::loadView('pdf.cuentascobrardetalle', [
            'ventas' => $ventas,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin
        ]);
        return $pdf->stream();
    }
}
