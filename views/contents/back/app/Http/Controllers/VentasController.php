<?php

namespace App\Http\Controllers;

use App\Models\Numeros_Ventas;
use App\Models\Ordenes_Ventas;
use App\Models\Paciente;
use App\Models\Producto;
use App\Models\Ventas;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    //


    public function generar_numeros_aleartorios($id_tablas){

        $numeros_venta = Numeros_Ventas::where('id_tablas', $id_tablas)->orderBy('id', 'DESC')->first();
        $response = [];

        if ($numeros_venta == null) {
            $response = [
                'estado' => true,
                'id_tablas' => $id_tablas,
                'mensaje' => 'Primera Serie',
                'numero' => '00000000001',
            ];
        } else {
            $numero = intval($numeros_venta->num_venta);

            $siguienteSerie = '0000000000' . ($numero += 1);
            $response = [
                'estado' => true,
                'id_tablas' => $id_tablas,
                'mensaje' => 'Proximo numero',
                'numero' => $siguienteSerie,
            ];
        }

        return response()->json($response, 200);
    }
    public function aumentarAleartoriosVenta(Request $request){

        $aux = json_decode($request['data']);
        $numLabsRequest = $aux->num_venta;
        $num_venta = $numLabsRequest->num_venta;
        $id_tablas = $numLabsRequest->id_tablas;
        $response = [];

        if ($numLabsRequest == null) {
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos para procesar',
            ];
        } else {
            $nuevoNumVentas = new Numeros_Ventas();
            $nuevoNumVentas->num_venta = $num_venta;
            $nuevoNumVentas->id_tablas = $id_tablas;
            $nuevoNumVentas->estado = 'A';
            $nuevoNumVentas->save();

            $response = [
                'estado' => true,
                'mensaje' => 'Guardando Datos',
                'numero_labs' => $nuevoNumVentas,
            ];
        }

        return response()->json($response, 200);
    }


    
    public function datatable_clientes(){

        $cliente = Paciente::where('estado', 'A')->get();
        $array = [];  $i = 1;

        foreach ($cliente as $dc) {
            $personas = $dc->persona;
        //    $sexo = $dc->persona->sexo;

            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="seleccionar(' . $dc->id . ')">
                                <i class="fa fa-check"></i>
                            </button>
                         
                        </div>';

            $array[] = [
                0 => $i,
                1 => $personas->cedula,
                2 => $personas->nombre .' '. $personas->apellido,
             /*    3 => $personas->apellido, */
                3 => $personas->telefono,
                4 => $personas->direccion,
                5 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($array),
            'iTotalDisplayRecords' => count($array),
            'aaData' => $array,
        ];

        return response()->json($result, 200);
    }

    public function datatable_producto()
    {

        $base = $_SERVER['APP_URL'] . ':' . $_SERVER['SERVER_PORT'] . '/';

        $dataProducto = Producto::where('estado', 'A')->get();
        $data = [];
        $i = 1;

        foreach ($dataProducto as $produc) {

            $url = $base . 'api/productos/productos/' . $produc->imagen;

            $icono = $produc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $produc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $produc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
            <button class="btn btn-primary btn-sm" onclick="seleccionar_prod(' . $produc->id . ')">
                <i class="fa fa-check"></i>
            </button>
         
        </div>';

            $data[] = [
                0 => $i,
                1 => '<div class="box-imagen-produc"><img src=' . "$url" . ' " style="width: 50px;"></div>', 
                2 => $produc->codigo,
                3 => $produc->categoria->nombre_categoria,
                4 => $produc->nombre_producto,
                5 => $produc->descripcion,
                6 => $produc->stock,
                7 => $produc->precio_venta,
                8 => $botones,


            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($result, 200);
    } //


    public function listarCliente_id($id){

        $id = intval($id);
        $cliente = Paciente::find($id);
        $response = [];

        if ($cliente) {
            $cliente->persona->sexo;

            $response = [
                'estado' => true,
                'mensaje' => 'Si hay datos',
                'cliente' => $cliente,
            ];
        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos',
                'cliente' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function listarProducto_id($id){

        $id = intval($id);
        $producto = Producto::find($id);
        $response = [];

        if ($producto) {
            $producto->categoria;
            $producto->presentacion;

            $response = [
                'estado' => true,
                'mensaje' => 'Si hay datos',
                'producto' => $producto,
            ];
        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos',
                'producto' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function listar_producto()
    {

        $productos = Producto::where('estado', 'A')
            ->orderBy('nombre_producto')
            ->get();

        $response = [];
        foreach ($productos as $pro) {
            $response[] = [
                'producto' => $pro,
                'categoria_id' => $pro->categoria->id,
            ];
        }
        return response()->json($productos);
    }


    private function MESES(){
        $m = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        return $m;
    }



    public function graficaventasmensual()
    {
      
        $meses = $this->MESES();
        $response = [];  $dataVenta = [];   $year = date('Y');  $data = [];

        for ($i=0; $i < count($meses); $i++) { 
            $ventas = Ventas::where('estado','A')->whereYear('fecha', '=', $year)
                            ->whereMonth('fecha','=',$i+1)->get()->sum('total');
            $dataVenta = ($ventas > 0) ? round($ventas,2) : 0;

            $aux = [
                $meses[$i],
                $dataVenta,
            ];
            array_push($data, $aux);
        }
        $response = [
            'data' =>$data,
            'anio' => $year
        ];
        echo json_encode($response);
    }


    public function guardar_ventas(Request $request){
        $aux = json_decode($request['data']);
        $ventaReq = $aux->venta;
        $detalleReq = $aux->detalle_venta;
        $dataOrdenesVentas = $aux->ordenes_ventas;

        $response = [];

        if ($ventaReq) {
            $num_venta = $ventaReq->num_venta;
            $ventaReq->usuario_id = intval($ventaReq->usuario_id);
            $ventaReq->paciente_id = intval($ventaReq->paciente_id);
            $ventaReq->subtotal = floatval($ventaReq->subtotal);
            $ventaReq->iva = floatval($ventaReq->iva);
            $ventaReq->descripcion1 = $ventaReq->descripcion1;
            $ventaReq->descripcion2 = $ventaReq->descripcion2;
            $ventaReq->descuento = floatval($ventaReq->descuento);
            $ventaReq->total = floatval($ventaReq->total);

            //Empieza
            $ingresoNuevaVenta = new Ventas();
            $ingresoNuevaVenta->num_venta = $num_venta;
            $ingresoNuevaVenta->usuario_id = $ventaReq->usuario_id;
            $ingresoNuevaVenta->paciente_id = $ventaReq->paciente_id;
            $ingresoNuevaVenta->subtotal = $ventaReq->subtotal;
            $ingresoNuevaVenta->iva = $ventaReq->iva;
            $ingresoNuevaVenta->descripcion1 = $ventaReq->descripcion1;
            $ingresoNuevaVenta->descripcion2 = $ventaReq->descripcion2;
            $ingresoNuevaVenta->descuento= '0';
          //  $ingresoNuevaVenta->descuento = $ventaReq->descuento;
            $ingresoNuevaVenta->total = $ventaReq->total;
            $ingresoNuevaVenta->fecha = date('Y-m-d');
            $ingresoNuevaVenta->estado = 'A';
            

            $norepetirCodigo = Ventas::where('num_venta', $num_venta)->get()->first();

            if ($norepetirCodigo) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El numero de venta ya existe',
                    'venta' => null,
                    'detalle' => null,
                 //   'transaccion' => null,
                    //'inventario' => null,

                ];
            } else {
                if ($ingresoNuevaVenta->save()) {

                     //cuando dispone de una orden
                    if ($dataOrdenesVentas->citas_id != '0') {
                        $ordenesventa = new Ordenes_VentasController();
                        $ordenesventa->guardar_ordenesventas($dataOrdenesVentas, $ingresoNuevaVenta->id);
                        //var_dump($servicioCtr); die();
                    } 

                    //Guarda detalle de venta
                    $detalle_Controller = new Detalle_VentasController();
                    $det = $detalle_Controller->guardar_detalleVenta($ingresoNuevaVenta->id, $detalleReq);

           /*          //Insertar una nueva transaccion
                    $nuevaTransaccion = $this->nuevomovimiento($ingresoNuevaVenta);

                    //Actualizar el inventario
                    $inventarioController = new Inventarios_Controller;
                    $resInvt = $inventarioController->guardarIngresoProducto($nuevaTransaccion->id, $detalleReq, 'S');

              */

                    $response = [
                        'status' => true,
                        'mensaje' => 'Guardando los datos',
                        'venta' => $ingresoNuevaVenta,
                        'detalle' => $det,
                   /*      'transaccion' => $nuevaTransaccion,
                        'inventario' => $resInvt, */
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se puede guardar',
                        'venta' => null,
                        'detalle' => null,
                       'transaccion' => null,
                       'inventario' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'venta' => null,
                'detalle' => null,
                'transaccion' => null,
                'inventario' => null,
            ];
        }
        // var_dump($venta); die();
        return response()->json($response, 200);
    }


    public function datatableventa(){

        $dataverventas = Ventas::where('estado', 'A')->orderBy('fecha', 'DESC')->get();
        $data = [];  $i = 1;

        foreach ($dataverventas as $dc) {
            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="ver_detalleVenta(' . $dc->id . ')">
                            <i class="fas fa-vote-yea"></i>
                            </button>

                        </div>';

            $data[] = [
                0 => $i,
                1 => $dc->fecha,
                2 => $dc->num_venta,
                3 => $dc->paciente->persona->cedula,
                4 => $dc->paciente->persona->nombre,
                5 => $dc->paciente->persona->apellido,
                6 => $dc->total,
                7 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($result, 200);
    }


    public function listarventasxid($id){

       
        $id = intval($id);
        $ventas = Ventas::find($id);
        $_ordenes_ventas = Ordenes_Ventas::where('ventas_id', $ventas->id)->get()->first();
        $ordenes_ventas = ($_ordenes_ventas == null) ? false: $_ordenes_ventas;
        $orden = ($_ordenes_ventas == null)  ? false : $ordenes_ventas->reservaciones;
        $response = [];

        if ($ventas) {
            $ventas->paciente->persona;
            $ventas->usuario->persona;

            foreach ($ventas->detalle_venta as $pro) {
                $pro->producto;
            }

            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'venta' => $ventas,
                'ordenes_ventas' => $ordenes_ventas,
                'reservaciones' => $orden,
                 
               
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos',
                'venta' => null,
            ];
        }

        return response()->json($response, 200);
    }


    public function ventasxmes(){

        $mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $pos = intval(date('m')) - 1;  $hoy = date('Y-m-d');  $inicioMes = date('Y') . '-' . date('m') . '-01';

        $ventas = Ventas::where('estado', 'A')->where('fecha', '>=', $inicioMes)->where('fecha', '<=', $hoy)->get();
     

        $response = [];  $total = 0;  
      
        if ($ventas) {
            foreach ($ventas as $ven) {
                $aux = $total += $ven->total;
                $total = round($aux, 2);
            }

           
            $totalGeneral = round(($total), 2);
            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'total' => $totalGeneral,
                'mes' => $mes[$pos],
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos',
                'total' => 0,
                'mes' => $mes[$pos],
            ];
        }

        return response()->json($response, 200);
    }

}
