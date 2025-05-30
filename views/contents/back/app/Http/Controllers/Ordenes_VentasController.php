<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Ordenes_Ventas;
use Illuminate\Http\Request;

class Ordenes_VentasController extends Controller
{
    //

    public function guardar_ordenesventas($orden_data, $ventas_id){

        $orden_data->citas_id = intval($orden_data->citas_id);
        $object_reservaciones = Citas::find($orden_data->citas_id);
      
        $nueva_orden_ventas = new Ordenes_Ventas();
        $nueva_orden_ventas->citas_id = $orden_data->citas_id;
        $nueva_orden_ventas->ventas_id = intVal($ventas_id);
        $nueva_orden_ventas->estado = 'A';

        //Actualizar la orden a facturado
     /*    $object_reservaciones->status_facturado = 'S';
        $object_reservaciones->save();
 */
        $nueva_orden_ventas->save();
    }
}
