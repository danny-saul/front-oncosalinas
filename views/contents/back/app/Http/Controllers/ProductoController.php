<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; // Importar la clase File si aún no está importada

class ProductoController extends Controller
{
    //
    private $limite = 5;


    public function listar_producto2()
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

    //
    public function listar_producto()
    {

        $producto = Producto::where('estado', 'A')->get();
        $response = [];

        if ($producto) {

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'producto' => $producto,
               // 'categoria' => $producto->categoria->id
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'producto' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function listarId($id)
    {

        $id = intval($id);
        $producto = Producto::find($id);
        $response = [];

        if ($producto) {
            $producto->categoria;
            $producto->presentacion;

            $response = [
                'status' => true,
                'producto' => $producto,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el producto',
                'producto' => null,
            ];
        }
        return response()->json($response, 200);
    }

    private function generate_key($limit){
        $key = '';

        $aux = sha1(md5(time()));
        $key = substr($aux, 0, $limit);

        return $key;
    }

    public function guardar_producto(Request $request)
    {

        $auxiliar = json_decode($request['data']);
        $data_producto_req = $auxiliar->producto;
        $codigoaleartorio = $this->generate_key($this->limite);

        $response = [];

        if ($data_producto_req) {
        
         //   $categoria_id = $data_producto_req->categoria_id;
            $nombre_producto = $data_producto_req->nombre_producto;
      //      $descripcion_producto = $data_producto_req->descripcion;
     //       $presentacion = $data_producto_req->presentacion_id;
      //      $imagen = $data_producto_req->imagen;
     //       $stock = $data_producto_req->stock;
    //        $precio_venta = $data_producto_req->precio_venta;
   //         $precio_compra = $data_producto_req->precio_compra;
           //   $fecha = $data_producto_req->fecha;

            $existecodigo = Producto::where('nombre_producto',$nombre_producto)
            ->get()->first();
 
            if ($existecodigo) {
                $response = [
                    'estado' => false,
                    'mensaje' => 'El producto ya se ha registrado',
                    'producto' => null,
                ];
  

        }
           else {
                $nuevoproducto = new Producto();
                $nuevoproducto->categoria_id = 2;
                $nuevoproducto->codigo = $codigoaleartorio;
                $nuevoproducto->nombre_producto = $nombre_producto;
                $nuevoproducto->descripcion = '';
                $nuevoproducto->presentacion_id = 1;
                $nuevoproducto->imagen = 'default.png';
                $nuevoproducto->nombre_comercial = 'Generico';
                $nuevoproducto->stock = 500;
                $nuevoproducto->marca = '1';
                $nuevoproducto->precio_venta = '0.00';
                $nuevoproducto->precio_compra = '0.00';
                $nuevoproducto->fecha = date('Y-m-d');
                $nuevoproducto->estado = 'A';

                if ($nuevoproducto->save()) {
                    $response = [
                        'estado' => true,
                        'mensaje' => 'El producto se ha registrado correctamente',
                        'producto' => $nuevoproducto,
                    ];
                } else {
                    $response = [
                        'estado' => false,
                        'mensaje' => 'No se ha guardado el producto',
                        'producto' => null,
                    ];
                }
            }
        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para guardar',
                'producto' => null,
            ];
        }

        return response()->json($response, 200);
    }




    public function guardar_producto2(Request $request)
    {

        $auxiliar = json_decode($request['data']);
        $data_producto_req = $auxiliar->producto;
 

        $response = [];

        if ($data_producto_req) {
            $codigo_Prod = $data_producto_req->codigo;
            $cate_id = $data_producto_req->categoria_id;
            $nom_prdcto = $data_producto_req->nombre_producto;
            $descripcion = $data_producto_req->descripcion;
            $presentacion = $data_producto_req->presentacion_id;
            $imagen = $data_producto_req->imagen;
            $stock = $data_producto_req->stock;
            $marca = $data_producto_req->marca;
            $precio_venta = $data_producto_req->precio_venta;
            $precio_compra = $data_producto_req->precio_compra;
            $fecha = $data_producto_req->fecha;

            $existecodigo = Producto::where('nombre_producto',$nom_prdcto)
            ->where('presentacion_id', $presentacion)
            ->where('descripcion', $descripcion)
            ->where('codigo', $codigo_Prod)
            ->get()->first();
         //   var_dump($existecodigo); die();
          //  $existepresentacion = Producto::where('presentacion_id', $presentacion)->get()->first();
          //  $exitedescripcion = Producto::where('descripcion_producto', $descripcion_producto)->get()->first();
            if ($existecodigo) {
                $response = [
                    'estado' => false,
                    'mensaje' => 'El producto ya se ha registrado',
                    'producto' => null,
                ];
     /*        }else if ($existepresentacion){
                $response = [
                    'status' => false,
                    'mensaje' => 'El producto ya se encuentra registrado con esta presentacion',
                    'producto' => null,
                ];
            }else if ($exitedescripcion){
                $response = [
                    'status' => false,
                    'mensaje' => 'El producto ya seencuentra registrado',
                    'producto' => null,
                ]; */

        }
           else {
                $nuevoproducto = new Producto();
                $nuevoproducto->categoria_id = $cate_id;
                $nuevoproducto->codigo = $codigo_Prod;
                $nuevoproducto->nombre_producto = $nom_prdcto;
                $nuevoproducto->descripcion = $descripcion;
                $nuevoproducto->presentacion_id = $presentacion;
                $nuevoproducto->imagen = $imagen;
                $nuevoproducto->stock = $stock;
                $nuevoproducto->marca = $marca;
                $nuevoproducto->precio_venta = $precio_venta;
                $nuevoproducto->precio_compra = $precio_compra;
                $nuevoproducto->fecha = $fecha;
                $nuevoproducto->estado = 'A';
                $nuevoproducto->nombre_comercial = 'Generico';

                if ($nuevoproducto->save()) {
                    $response = [
                        'estado' => true,
                        'mensaje' => 'El producto se ha registrado correctamente',
                        'producto' => $nuevoproducto,
                    ];
                } else {
                    $response = [
                        'estado' => false,
                        'mensaje' => 'No se ha guardado el producto',
                        'producto' => null,
                    ];
                }
            }
        } else {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para guardar',
                'producto' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function subirImgProducto(Request $request)
    {
        if ($request->hasFile('fichero')) {
        $img = $_FILES['fichero'];
        $originalName = $request->file('fichero')->getClientOriginalName();

        // Quitar espacios del nombre del archivo
        $path = str_replace(' ', '', $originalName);

        // Guardar el archivo con el nuevo nombre
        $request->file('fichero')->storeAs('public/producto', $path);

        $response = [
            'status' => true,
            'mensaje' => 'Fichero subido',
            'imagen' => $img['name'],
            // 'direccion' => $enlace_actual . '/' . $target_path,
        ];

        return response()->json($response, 200);
        }
    }

    public function datatable_producto()
    {

        $base = $_SERVER['APP_URL'] . ':' . $_SERVER['SERVER_PORT'] . '/';

        $dataProducto = Producto::where('estado', 'A')->get()->where('categoria_id','4');
        $data = [];
        $i = 1;

        foreach ($dataProducto as $produc) {

            $url = $base . 'api/productos/productos/' . $produc->imagen;

            $icono = $produc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $produc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $produc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-info btn-sm disabled" onclick="agregarStock(' . $produc->id . ')">
                               Agregar Stock <i class="fa fa-plus fa-lg"></i>
                            </button>
                            <button class="btn btn-primary btn-sm" onclick="editar_producto(' . $produc->id . ')"> Editar
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn disabled' . $clase . '" onclick="eliminar_producto(' . $produc->id . ',' . $other . ')">
                               Eliminar ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => '<div class="box-imagen-produc"><img src=' . "$url" . ' " style="width: 50px;"></div>', 
                2 => $produc->codigo,
                3 => $produc->categoria->nombre_categoria,
                4 => $produc->nombre_producto,
                5 => $produc->descripcion,
                6 => $produc->presentacion->tipo_presentacion,
                7 => $produc->stock,
                8 => $produc->marca,
                9 => $produc->precio_venta,
                10 => $produc->precio_compra,
                11 => $botones,


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

    public function datatable_medicamentos()
    {

        $base = $_SERVER['APP_URL'] . ':' . $_SERVER['SERVER_PORT'] . '/';

        $dataProducto = Producto::where('estado', 'A')->where('categoria_id', '!=', 4)
        ->get();
        $data = [];
        $i = 1;

        foreach ($dataProducto as $produc) {

            $url = $base . 'api/productos/productos/' . $produc->imagen;

            $icono = $produc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $produc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $produc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-info btn-sm disabled" onclick="agregarStock(' . $produc->id . ')">
                               Agregar Stock <i class="fa fa-plus fa-lg"></i>
                            </button>
                            <button class="btn btn-primary btn-sm" onclick="editar_producto(' . $produc->id . ')"> Editar
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn disabled' . $clase . '" onclick="eliminar_producto(' . $produc->id . ',' . $other . ')">
                               Eliminar ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => '<div class="box-imagen-produc"><img src=' . "$url" . ' " style="width: 50px;"></div>', 
                2 => $produc->codigo,
                3 => $produc->categoria->nombre_categoria,
                4 => $produc->nombre_producto,
                5 => $produc->descripcion,
                6 => $produc->presentacion->tipo_presentacion,
                7 => $produc->stock,
                8 => $produc->precio_venta,
                9 => $produc->precio_compra,
                10 => $botones,


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





    public function obtenerImgProducto2($disk5, $file5)
    {
      
	
        if ($disk5 === 'productos') {
            $diskName = ($disk5 === 'usuarios') ? 'avatars' : 'productos';
            
            $existe = Storage::disk($diskName)->exists($file5);
            
            if ($existe) {
                $archivo = Storage::disk($diskName)->get($file5);
                // Devolver el archivo PDF como respuesta
                return new Response($archivo, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$file5.'"'
                ]);
            } else {
                $data = [
                    'estado' => false,
                    'mensaje' => 'Archivo no existe',
                    'error' => 404
                ];
                return response()->json($data, 404);
            }
        } else {
            $data = [
                'estado' => false,
                'mensaje' => 'Disco no válido',
                'error' => 400
            ];
            return response()->json($data, 400);
        }
    
    }

    
 public function obtenerImgProducto($disk5, $file5){

    if($disk5 == 'productos'){
        $existe = Storage::disk('productos')->exists($file5);

        if($existe){
            $archivo = Storage::disk('productos')->get($file5);
               return new Response($archivo, 200);
        }else{
            $data = [
                'estado' => false,
                'mensaje' => 'Imagen no existe',
                'error' => 404
            ];
        }
    }


    else{
        $data = [
            'estado' => false,
            'mensaje'=> 'No se pude cargar la imagen',
            'error' => 505
        ];
    }

    return response()->json($data);
}



public function editar(Request $request)
{

    $aux = json_decode($request['data']);
    $pro_request = $aux->producto;
    $id = intval($pro_request->id);
    $categoria_id = intval($pro_request->categoria_id);
    $presentacion_id = intval($pro_request->presentacion_id);
    $codigo = $pro_request->codigo;
    $nombre_producto = ucfirst($pro_request->nombre);
    $descripcion = ucfirst($pro_request->descripcion);
    $stock = ucfirst($pro_request->stock);
    $marca = ucfirst($pro_request->marca);
    $precio_venta = ucfirst($pro_request->precio_venta);
    $precio_compra = ucfirst($pro_request->precio_compra);
    $fecha = ucfirst($pro_request->fecha);


    $response = [];
    $produc = Producto::find($id);
    if ($pro_request) {
        if ($produc) {
            $produc->categoria_id = $categoria_id;
            $produc->presentacion_id = $presentacion_id;
            $produc->nombre_producto = $nombre_producto;
            $produc->codigo = $codigo;
            $produc->descripcion = $descripcion;
            $produc->nombre_comercial = 'Generico';
            $produc->stock = $stock;
            $produc->marca = $marca;
            $produc->precio_venta = $precio_venta;
            $produc->precio_compra = $precio_compra;
            $produc->fecha = $fecha;
            $produc->save();

            $response = [
                'status' => true,
                'mensaje' => 'El producto se ha actualizado',
                'materia' => $produc,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede actualizar el producto',
            ];
        }
    } else {
        $response = [
            'status' => false,
            'mensaje' => 'No hay datos'
        ];
    }
    return response()->json($response, 200);
}
 

public function cantidadproducto()
{

    $produ = Producto::where('estado', 'A')->get()->where('categoria_id','4');
    $response = [];

    if ($produ) {
        $response = [
            'estado' => true,
            'mensaje' => 'existe datos',
            'nombre' => 'Productos',
            'cantidad' => $produ->count(),
        ];
    } else {
        $response = [
            'estado' => false,
            'mensaje' => 'no existe datos',
            'nombre' => 'Productos',
            'cantidad' => 0,
        ];
    }

    return response()->json($response, 200);
}

public function graficoStockProductos(){
       
    $productos = Producto::where('estado', 'A')->get();
    $categorias = Categoria::where('estado', 'A')->get();

    $productos_id = []; //array principal
    $secundario = [];

    $arrayFinal = [];   $arrayPercent = [];
    $total_global = 0;  
    $totalParcentaje = 0; $index = 0;

    foreach ($categorias as $item) {
        $nombreCategoria = $item->nombre_categoria;
        $producto = $item->producto;
        $data[] = count($producto);
        $aux = [];  $_cont = 0;
        foreach ($producto as $p) {
            if ($item->id == $p->categoria->id) {
                $_cont += $p->stock;
            }

            if($index == 0){
                $aux = [
                    'name' => $nombreCategoria,
                    'y' => $_cont,
                    'sliced' => true,
                    'selected' => true,
                ];
            }else{
                $aux = [
                    'name' => $nombreCategoria,
                    'y' => $_cont
                ];
            }
        }
        $arrayFinal[] = (object) $aux;
        $index++;
    }
    $final = [
        'data' => $arrayFinal,
    ];
    return response()->json($final, 200);

   // echo json_encode($final);
}


}
