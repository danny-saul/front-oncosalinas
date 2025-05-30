<?php

namespace App\Http\Controllers;

use App\Models\Numeros_Aleartorios;
use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    //


        public function generar_numeros_aleartorios($id_tablas){

            $numeros_aleatorios = Numeros_Aleartorios::where('id_tablas', $id_tablas)->orderBy('id', 'DESC')->first();
            $response = [];
    
            if ($numeros_aleatorios == null) {
                $response = [
                    'estado' => true,
                    'id_tablas' => $id_tablas,
                    'mensaje' => 'Primera Serie',
                    'numero' => '00000000001',
                ];
            } else {
                $numero = intval($numeros_aleatorios->numeros);
    
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
    
        public function aumentarNumerosAleartorios(Request $request){
    
            $aux = json_decode($request['data']);
            $numAlerRequest = $aux->numeros;
            $numeros = $numAlerRequest->numeros;
            $id_tablas = $numAlerRequest->id_tablas;
            $response = [];
    
            if ($numAlerRequest == null) {
                $response = [
                    'status' => false,
                    'mensaje' => 'no ahi datos para procesar',
                ];
            } else {
                $nuevoNumAleartorio = new Numeros_Aleartorios();
                $nuevoNumAleartorio->numeros = $numeros;
                $nuevoNumAleartorio->id_tablas = $id_tablas;
                $nuevoNumAleartorio->estado = 'A';
                $nuevoNumAleartorio->save();
    
                $response = [
                    'estado' => true,
                    'mensaje' => 'Guardando Datos',
                    'numeros' => $nuevoNumAleartorio,
                ];
            }
    
            return response()->json($response, 200);
        }



    public function guardarOrden($citas_id, $orden = [] ){
        $response = [];

        if($orden > 0 ){
            foreach($orden as $serv){
                $nuevo = new Orden();
                $nuevo->citas_id = $citas_id;
               
                $nuevo->tipo_estudio_id = intval($serv->tipo_estudio_id);
                $nuevo->numero_orden = $serv->numero_orden;
                $nuevo->lateralidad_id = intval($serv->lateralidad_id);
                $nuevo->estado_orden_id = 1;
                $nuevo->justificacion = $serv->justificacion;
                $nuevo->resumen = $serv->resumen;
                $nuevo->informe = '';
                $nuevo->conclusion = '';
                $nuevo->documento = 1;
                $nuevo->estado = 'A'; 
                $nuevo->save();

            }
            $response = [
                'status' => true,
                'mensaje' => 'Guardado Diagnostico'
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay servicios en la orden',
                'receta_diagnostico' => null,
            ];
        }
        return response()->json($response, 200);
    } 


    public function listar_Orden($id)
    {

        $id = intval($id);
        $orden = Orden::find($id);
        $response = [];

        if ($orden) {
            $orden->citas->doctor->persona;
            $orden->citas;
            $orden->tipo_estudio;
            $orden->lateralidad;
            $orden->estado_orden;

            $response = [
                'status' => true,
                'orden' => $orden,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el orden',
                'orden' => null,
            ];
        }
        return response()->json($response, 200);
    }



/*     public function editar(Request $request)
    {

        $aux = json_decode($request['data']);
        $orden_request = $aux->orden;
        $id = intval($orden_request->id);
        $requestordenDiagnostico = $aux->ordenes_diagnosticos; 
      
        $justificacion = ucfirst($orden_request->justificacion);
        $resumen = ucfirst($orden_request->resumen);
        $informe = ucfirst($orden_request->informe);
        $conclusion = ucfirst($orden_request->conclusion);
        $documento = ucfirst($orden_request->documento);
        $documentoSinEspacios = str_replace(' ', '', $documento);


        $response = [];
        $produc = Orden::find($id);
        if ($orden_request) {
            if ($produc) {
           
                $produc->justificacion = $justificacion;
                $produc->resumen = $resumen;
                $produc->documento = $documentoSinEspacios;
                $produc->informe = $informe;
                $produc->conclusion = $conclusion;
                date_default_timezone_set('America/Guayaquil');
                $produc->fecha = date('Y-m-d H:i:s');
 
                $ordenDiagnostico = new Ordenes_DiagnosticosController();
                $orden_diagnosticosController = $ordenDiagnostico->guardar_ordenes_diagnosticos($produc->id, $requestordenDiagnostico);


                $produc->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'El producto se ha actualizado',
                    'materia' => $produc,
                    'orden_diagnostico' => $orden_diagnosticosController
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
    } */


    public function editar(Request $request)
{
    $aux = json_decode($request['data']);
    $orden_request = $aux->orden;
    $id = intval($orden_request->id);
    $requestordenDiagnostico = $aux->ordenes_diagnosticos;

    $doctor_id = intval($orden_request->doctor_id);

    $justificacion = ucfirst($orden_request->justificacion);
    $resumen = ucfirst($orden_request->resumen);
    $informe = ucfirst($orden_request->informe);
    $conclusion = ucfirst($orden_request->conclusion);
    $documento = $orden_request->documento;
    $documentoSinEspacios = str_replace(' ', '', $documento);

    $response = [];
    $produc = Orden::find($id);

    if ($orden_request) {
        if ($produc) {
            $produc->doctor_id = $doctor_id;

            $produc->justificacion = $justificacion;
            $produc->resumen = $resumen;
            $produc->documento = $documentoSinEspacios;
            $produc->informe = $informe;
            $produc->conclusion = $conclusion;
            date_default_timezone_set('America/Guayaquil');
            $produc->fecha = date('Y-m-d H:i:s');

            $ordenDiagnostico = new Ordenes_DiagnosticosController();
            $orden_diagnosticosController = $ordenDiagnostico->guardar_ordenes_diagnosticos($produc->id, $requestordenDiagnostico);

            // Cambiar el estado_orden_id de la tabla ordenes a 2
            $produc->estado_orden_id = 2;

            $produc->save();

            $response = [
                'status' => true,
                'mensaje' => 'Informe Finalizado',
                'materia' => $produc,
                'orden_diagnostico' => $orden_diagnosticosController
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede actualizar el Informe',
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


    public function subirEstudioPdf(Request $request){

        if($request->hasFile('fichero')){
            $img = $_FILES['fichero'];
           // $path = $request->file('fichero')->getClientOriginalName();
         $originalName = $request->file('fichero')->getClientOriginalName();

         // Quitar espacios del nombre del archivo
            $path = str_replace(' ', '', $originalName);
            $request->file('fichero')->storeAs('public/estudios',$path);
            
            $response = [
                'status' => true,
                'mensaje' => 'Fichero subido',
                'imagen' => $img['name'],
                // 'direccion' => $enlace_actual . '/' . $target_path,
            ];
            return response()->json($response, 200);
        }


    }



    public function listar_ordenes($id){
        $idorden = intval($id);
        $orden = Orden::find($idorden);
     //   $ordenController = new Servicios_Controller;

        $response = [];

        if($orden == null){
            $response = [
                'estado'=>false,
                'mensaje'=>'No hay datos para mostrar',
                'orden'=> null,

            ];
        }else{
     
             foreach($orden->ordenes_diagnostico as $ord){
                $ord->diagnosticocie10;
                 
            } 

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'orden' => $orden,
                'citas' => $orden->citas->paciente->persona->sexo,
                'doctor' => $orden->citas->doctor->persona,
                'diagnosticos' => $orden->ordenes_diagnostico,
                'cliente_id' => $orden->doctor->persona->id,
         
            ];
        }

        return response()->json($response);

    }





    /**EDITAR ORDENES EN CITAS */

    public function datatableOrdenesImagenes($citaId)
    {
   
       $cita_id = intval($citaId);
       $ordenes_imagenes = Orden::where('citas_id', $cita_id)->where('estado','A')->get();
       $data = [];
       $i = 1;
        foreach ($ordenes_imagenes as $rece) {
          
           $tipoestudio= $rece->tipo_estudio;
            
   
        
            $botones1 = '<div class="">
                           
                            <button class="btn btn-sm btn-warning" onclick="editar_ordenimagenes(' . $rece->id . ' )">
                                   <i class="fas fa-edit"></i> Editar
                               </button>
                          
                        </div>';
            $botones2 = '<div class="">
                           
   
                        <button  class="btn btn-sm btn-danger " onclick="eliminar_ordenimagenes(' . $rece->id . ')">
                            <i class="fas fa-trash"></i>  Eliminar
                        </button>
                    </div>';
   
            $data[] = [
              
                0 => $tipoestudio->codigo . ' ' . $tipoestudio->descripcion,
                1 => $rece->numero_orden,
                2=>'',
                3 => $rece->justificacion,
                4 => $rece->resumen,
                5 => $botones1,
                6 => $botones2,
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
    


    
public function editarOrdenesImagenes(Request $request){

    $aux = json_decode($request['data']);
    $ordesImgRequest = $aux->ordenes;
 
    $idOrdenesImagenes = intval($ordesImgRequest->id);
    $justificacion = $ordesImgRequest->justificacion;
    $resumen = $ordesImgRequest->resumen;
  
   

    $OrdenImgData = Orden::find($idOrdenesImagenes);
    $response = [];

    if ($ordesImgRequest) {
        if ($OrdenImgData) {
          

            $OrdenImgData->justificacion = $justificacion;
            $OrdenImgData->resumen = $resumen;
           
            $OrdenImgData->save();

            
            $response = [
                'status' => true,
                'mensaje' => 'El diagnotico se ha actualizado',
                'orden' => $OrdenImgData,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede actualizar el diagnostico',
            ];
        }
    } else {
        $response = [
            'status' => false,
            'mensaje' => 'No hay datos ',
        ];
    }

    return response()->json($response, 200);
}



public function eliminarItemOrdenes($OrdenesId){

    $id_Ordenes = intval($OrdenesId);
  //  $id_estado = intval($estadoId); //3 cancelado
    $mensajes = '';
    $response = [];
    $ordenes = Orden::find($id_Ordenes);

    if ($ordenes) {

      //  $cita->estado_cita_id = $id_estado;
        $ordenes->estado = 'I';
        $ordenes->save();
      
  
        switch ($id_Ordenes) {
            case 1:
                $mensajes = 'La orden de estudio  ha sido eliminada';
                break;
        }

        $response = [
            'status' => true,
            'mensaje' => $mensajes,
        ];
    } else {
        $response = [
            'status' => false,
            'mensaje' => 'No se puede cancelar la orden',
        ];
    }

    return response()->json($response, 200);
}


public function guardar_ordenesEdicion(Request $request)
{

    $auxiliar = json_decode($request['data']);
    $data_orden_req = $auxiliar->ordenes;


    $response = [];

    if ($data_orden_req) {
      
    
        $citas_id = $data_orden_req->citas_id;
        $doctor_id = $data_orden_req->doctor_id;
        $tipo_estudio_id = $data_orden_req->tipo_estudio_id;
        $numero_orden = $data_orden_req->numero_orden;
        $justificacion = $data_orden_req->justificacion;
        $resumen = $data_orden_req->resumen;
    
        $existecodigo = Orden::where('tipo_estudio_id',$tipo_estudio_id)->where('citas_id', $citas_id)->where('estado', 'A')
        ->get()->first();

        if ($existecodigo) {
            $response = [
                'estado' => false,
                'mensaje' => 'La orden de imagen ya se ha registrado, por favor de clic en el boton editar en la tabla',
                'orden' => null,
            ];

    }
       else {
            $nuevoOrden = new Orden();
    
            $nuevoOrden->citas_id = $citas_id;
            $nuevoOrden->numero_orden = $numero_orden;
            $nuevoOrden->tipo_estudio_id = $tipo_estudio_id;
            $nuevoOrden->justificacion = $justificacion;
            $nuevoOrden->doctor_id = $doctor_id;
            $nuevoOrden->resumen = $resumen;
            $nuevoOrden->lateralidad_id = 1;
            $nuevoOrden->estado_orden_id = 1;
            $nuevoOrden->informe = '';
            $nuevoOrden->conclusion = '';
            $nuevoOrden->documento = '';
      
            $nuevoOrden->estado = 'A';

            if ($nuevoOrden->save()) {
                $response = [
                    'estado' => true,
                    'mensaje' => 'El Diagnostico se ha registrado correctamente',
                    'orden' => $nuevoOrden,
                ];
            } else {
                $response = [
                    'estado' => false,
                    'mensaje' => 'No se ha guardado el diagnostico',
                    'orden' => null,
                ];
            }
        }
    } else {
        $response = [
            'estado' => false,
            'mensaje' => 'No hay datos para guardar',
            'receta' => null,
        ];
    }

    return response()->json($response, 200);
}

    /**FIN EDITAR ODENES EN CITAS */



}



