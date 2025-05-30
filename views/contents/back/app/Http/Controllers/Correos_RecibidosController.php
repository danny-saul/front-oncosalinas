<?php

namespace App\Http\Controllers;

use App\Models\Correos_Recibidos;
use App\Models\Subscribe;
use Illuminate\Http\Request;

class Correos_RecibidosController extends Controller
{
    //

    public function dt_correosrecibidos()
    {

        $base = $_SERVER['APP_URL'] . ':' . $_SERVER['SERVER_PORT'] . '/';

        $dtcorreos = Correos_Recibidos::where('estado', 'A')
        ->get();
        $data = [];
        $i = 1;

        foreach ($dtcorreos as $correos_recib) {

        

            $icono = $correos_recib->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $correos_recib->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $correos_recib->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                           
                            <button class="btn btn-primary btn-sm" onclick="responder(' . $correos_recib->id . ')"> Responder
                              <i class="fas fa-envelope-open"></i>
                            </button>
                         
                        </div>';

            $data[] = [
                0 => $i,
                1 => $correos_recib->nombres,
                2 => $correos_recib->medico,
                3 => $correos_recib->celular,
                4 => $correos_recib->servicio,
                5 => $correos_recib->fecha,
                6 => $correos_recib->hora,
                7 => $correos_recib->correo,
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



    public function listarId($id)
    {
 
        $id = intval($id);
        $correos = Correos_Recibidos::find($id);
        $response = [];

        if ($correos) {
            $response = [
                'status' => true,
                'correos' => $correos,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el correos',
                'correos' => null,
            ];
            
        }
        return response()->json($response, 200);

    }


    public function editar(Request $request){
        
        $aux = json_decode($request ['data']);
        $correoReq = $aux->correos;
        $id = intval($correoReq->id);
        $correos = ucfirst($correoReq->observacion);

        $response = [];       
        $corr = Correos_Recibidos::find($id);
        if($correoReq){
            if($corr){
                $corr->observacion = $correos;
                $corr->estado = 'I';
                $corr->save(); 
                
                $persona = $corr->nombres;
                $usuario = Correos_Recibidos::where('id', $corr->id)->first();
                $nombres = $persona;
                $mailer = new MailController($usuario->correo, $nombres);
                if ($mailer->sedMailCita2($corr)) {
                    // echo "Enviado";
                }


                $response = [
                    'status' => true,
                    'mensaje' => 'El correo se ha enviado',
                    'correo' => $corr,
                ];
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el Correo',
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



    /**SUBSCRIBE */



    public function dt_susbscribe()
    {

        $base = $_SERVER['APP_URL'] . ':' . $_SERVER['SERVER_PORT'] . '/';

        $dt_subcsribe = Subscribe::where('estado', 'A')
        ->get();
        $data = [];
        $i = 1;

        foreach ($dt_subcsribe as $correos_subs) {

        

            $icono = $correos_subs->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $correos_subs->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $correos_subs->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                           
                            <button class="btn btn-primary btn-sm" onclick="respondersubscribe(' . $correos_subs->id . ')"> Responder
                              <i class="fas fa-envelope-open"></i>
                            </button>
                         
                        </div>';

            $data[] = [
                0 => $i,
                1 => $correos_subs->nombres,
                2 => $correos_subs->correo,
                3 => $correos_subs->motivo,
                4 => $correos_subs->mensaje,
                5 => $correos_subs->created_at->format('Y-m-d H:i:s'),
                6 => $botones,


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


    

     public function listarsubscribe($id)
    {
 
        $id = intval($id);
        $subscribe = Subscribe::find($id);
        $response = [];

        if ($subscribe) {
            $response = [
                'status' => true,
                'subscribe' => $subscribe,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el subscribe',
                'subscribe' => null,
            ];
            
        }
        return response()->json($response, 200);

    }



    public function editarsubscribe(Request $request){
        
        $aux = json_decode($request ['data']);
        $subscribeRequest = $aux->subscribe;
        $id = intval($subscribeRequest->id);
        $correos = ucfirst($subscribeRequest->observacion);

        $response = [];       
        $subs = Subscribe::find($id);
        if($subscribeRequest){
            if($subs){
                $subs->observacion = $correos;
                $subs->estado = 'I';
                $subs->save(); 
                
                $persona = $subs->nombres;
                $usuario = Subscribe::where('id', $subs->id)->first();
                $nombres = $persona;
                $mailer = new MailController($usuario->correo, $nombres);
                if ($mailer->sedMailCita3($subs)) {
                    // echo "Enviado";
                }


                $response = [
                    'status' => true,
                    'mensaje' => 'El correo se ha enviado',
                    'correo' => $subs,
                ];
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el Correo',
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
}
