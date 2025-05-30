<?php

namespace App\Http\Controllers;

use App\Models\Detalle_Venta;
use App\Models\Producto;
use Illuminate\Http\Request;

class Detalle_VentasController extends Controller
{
    //
    public function guardar_detalleVenta($ventas_id, $det_venta =[]){

        $response = [];
     
        if(count($det_venta) > 0){
            foreach($det_venta as $item){

                $IngresoNuevoDetalle_Venta = new Detalle_Venta();
                $IngresoNuevoDetalle_Venta->ventas_id = intval($ventas_id);
                $IngresoNuevoDetalle_Venta->producto_id = intval($item->producto_id);
                $IngresoNuevoDetalle_Venta->cantidad = intval($item->cantidad);
                $IngresoNuevoDetalle_Venta->precio_venta = floatval($item->precio_venta);
                $IngresoNuevoDetalle_Venta->total_general = floatval($item->total_general);
                $IngresoNuevoDetalle_Venta->es_orden = $item->es_orden;

                $IngresoNuevoDetalle_Venta->save();

                $stock = $IngresoNuevoDetalle_Venta->cantidad * (-1);
                $this->actualizar_producto($item->producto_id, $stock, $item->precio_venta);

            }


        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No ahi productos para guardar',
                'detalle_ventas' => null,
            ];

        }
         return $response;
    }

    protected function actualizar_producto($id_producto, $stock){
        $producto  = Producto::find($id_producto);
        $producto->stock += $stock;
        $producto->save();
    }
}
