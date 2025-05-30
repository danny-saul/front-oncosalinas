<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Presentacion;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    //

    public function datatable_categoria(){

        $datacategoria = Categoria::where('estado', 'A')->get();
        $data = [];  $i = 1;

        foreach ($datacategoria as $cate) {
            $icono = $cate->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $cate->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $cate->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editar_categoria(' . $cate->id . ')"> Editar
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            </div>';
                       /*      <button class="btn ' . $clase . '" onclick="eliminar_categoria(' . $cate->id . ',' . $other . ')">
                               Eliminar ' . $icono . '
                            </button> */

            $data[] = [
                0 => $i,
                1 => $cate->nombre_categoria,
                2 => $botones,
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
    

    public function guardar_categoria(Request $request){

        $auxiliar = json_decode($request ['data']);
        $categoriarequest = $auxiliar->categorias;
      //  var_dump($auxiliar); die();
        $categoriaexiste = ucfirst($categoriarequest->nombre_categoria);
        if($categoriarequest){
            $new_Categoria = new Categoria();
            $existe_categoria = Categoria::where('nombre_categoria', $categoriaexiste)->get()->first();
            if($existe_categoria){
                $response = [
                    'estado'=> false,
                    'mensaje'=>'Categoria ya esta registrada',
                    'categoria' => null,

                ];
            }else{
                $new_Categoria->nombre_categoria = $categoriaexiste;
                $new_Categoria->estado = 'A';

                if($new_Categoria->save()){
                    $response = [
                        'estado'=> true,
                        'mensaje'=>'Categoria se ha registrado',
                        'categoria' => $new_Categoria,
                    ];
                }else{
                    $response = [
                        'estado'=> false,
                        'mensaje'=>'No se ha podido guardar',
                        'categoria' => null,
                    ];
                }
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No existen datos',
                'categoria' => null,
            ];

        }
        return response()->json($response, 200);


    }

    public function listar_categorias()
    {
        $response = [];

        $categoriaData = Categoria::where('estado', 'A')->get();

        if($categoriaData){
            
            $response = [
                'status' => true,
                'mensaje' => 'Existen Datos',
                'categorias' => $categoriaData
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No Existen Datos',
                'categorias' => $categoriaData
            ];

        }

        return response()->json($response, 200);

    }

    public function listar_presentacion()
    {
        $response = [];

        $PresentacionData = Presentacion::where('estado', 'A')->get();

        if($PresentacionData){
            
            $response = [
                'status' => true,
                'mensaje' => 'Existen Datos',
                'presentacion' => $PresentacionData
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No Existen Datos',
                'presentacion' => $PresentacionData
            ];

        }

        return response()->json($response, 200);

    } 

       public function editar(Request $request){
        
        $aux = json_decode($request ['data']);
        $cate_request = $aux->categoria;
        $id = intval($cate_request->id);
        $categoria = ucfirst($cate_request->nombre_categoria);

        $response = [];       
        $cate = Categoria::find($id);
        if($cate_request){
            if($cate){
                $cate->nombre_categoria = $categoria;
                $cate->save();  

                $response = [
                    'status' => true,
                    'mensaje' => 'La categoria  se ha actualizado',
                    'categoria' => $cate,
                ];
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar la categoria',
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos...!!'
            ];
        }
        return response()->json($response, 200);

    }

    public function listarId($id)
    {
 
        $id = intval($id);
        $categoria = Categoria::find($id);
        $response = [];

        if ($categoria) {
            $response = [
                'status' => true,
                'categoria' => $categoria,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el categoria',
                'categoria' => null,
            ];
            
        }
        return response()->json($response, 200);

    }

      public function eliminar(Request $request){

        $aux = json_decode($request['data']);
  
        $cate_request = $aux->categoria;
        $id = intval($cate_request->id);

        $categoria = Categoria::find($id);
        $response = [];

        if($categoria){
            $categoria->estado = 'I';
            $categoria->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado la categoria', 
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se ha podido eliminar la categoria', 
            ];
        }
        return response()->json($response, 200);

    }

    public function listarinventariocateprod($id)
    {
        $id=intval($id);
        $response = [];
        
        $categorias = Categoria::find($id);
        if ($categorias) {
            $categorias->producto;
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'categoria' => $categorias
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'categoria' => null
            ];
        }
        return response()->json($response, 200);

    }

}
