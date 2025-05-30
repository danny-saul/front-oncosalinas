<?php

namespace App\Http\Controllers;

use App\Models\Dia;
use App\Models\Doctor_Horario;
use DateTime;
use Illuminate\Http\Request;

class Doctor_HorarioController extends Controller
{

   /*  public function listarHorarios($doctorId){

        $doctor_id = intval($doctorId);
        $doctorhorario = Doctor_Horario::where('estado', 'A')->where('doctor_id', $doctor_id)->get();

        $data = [];
        $i = 1;

        if ($doctorhorario) {
            foreach ($doctorhorario as $dh) {
                $dia = $dh->dia->dia;
                $horaentrada = $dh->h_entrada;
                $horasalida = $dh->h_salida;


                $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="eliminar_Hora(' . $dh->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>

                        </div>';

                $data[] = [
                    0 => $i,
                    1 => $dia,
                    2 => $horaentrada,
                    3 => $horasalida,
                    4 => $botones,
                ];
                $i++;
            }

            $result = [
                'sEcho' => 1,
                'iTotalRecords' => count($data),
                'iTotalDisplayRecords' => count($data),
                'aaData' => $data,
            ];
        } else {
            $result = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'doctorhorario' => [],
            ];
        }

        return response()->json($result, 200);
    } */

 
/* 
    public function verhorariod(){

        $dataverhorario = Doctor_Horario::where('estado', 'A')->get();
        $data = [];
        $i = 1;

        foreach ($dataverhorario as $dc) {
            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editar_horaAdoctor(' . $dc->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar_horaAdoctor(' . $dc->id . ',' . $other . ')">
                                ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $dc->doctor->persona->nombre,
                2 => $dc->doctor->persona->apellido,
                3 => $dc->horarios_atencion->horaE,
                4 => $dc->horarios_atencion->horaS,
                5 => $dc->horarios_atencion->fecha,
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

        return $result;
    } */

    public function buscarDoctor(){

        $doctorHorario = Doctor_Horario::where('estado', 'A')->get();
        $response = [];

        if ($doctorHorario) {
            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'doctorHorario' => $doctorHorario,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos',
                'doctorHorario' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function getHoras($fecha, $doctorId){

        $doctor_id = intval($doctorId);

        $diaSemana = date("l", strtotime($fecha));
        $arrayDia = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $dia_id = array_keys($arrayDia, $diaSemana)[0];
        $dia_id = $dia_id + 1;

        $horas = Doctor_Horario::select('id', 'hora_inicio', 'hora_fin')->where('doctor_id', $doctor_id)
        ->where('dia_id', $dia_id)->where('estado', 'A')->get();

        if( $horas->count() > 0){
            $response =  [
                'status' => true,
                'mensaje' => 'Ok',
                'horas' => $horas
            ];
        }else{
            $response =  [
                'status' => false,
                'mensaje' => 'Not data',
                'horas' => null
            ];
        }

        return response()->json($response, 200);
    }

    //Inicializar horarios new
    public function generar(Request $request){

        $aux = json_decode($request['data']);
        $data = $aux->doctor_horario;
        $minHora = 60;
        $hInicio = $data->hora_inicio;
        $hFin = $data->hora_fin;
        $salto = $data->salto;

        if (intval($salto) > 0 && intval($salto) <= 60) {

            //Obtener los días de la semana
            $diasModel = Dia::where('estado', 'A')->orderBy('orden', 'ASC')->get();

            //Dividir las horas
            $inicio = date('Y-m-d') . ' ' . $hInicio;
            $fin = date('Y-m-d') . ' ' . $hFin;

            //Calcular la cantidad de horas a repetir
            $horaInicio = new DateTime($inicio);
            $horaFin = new DateTime($fin);
            $dif = $horaInicio->diff($horaFin);
            $cantHoras = intval($dif->format('%H'));

            //Calcular las veces de salto en el intervalo de horas - 5, 10, 15, 20, 30, 60
            // 9:00 - 18:00  >> saltos de 15 min >> 60 min/15
            $cantTurnosXhora = intval($minHora / intval($salto));

            //Generar los tiempos
            $auxSalto = 0;
            $resetDate = $inicio;


            if (count($diasModel) > 0) { //existen dias
                foreach ($diasModel as $dia) {

                    for ($i = 0; $i < $cantHoras; $i++) {

                        for ($j = 0; $j < $cantTurnosXhora; $j++) {
                            $nuevoInicio = strtotime('+ ' . $auxSalto . ' minute', strtotime($inicio));

                            $procesFin = date('Y-m-d H:i:s', $nuevoInicio);
                            $nuevoFin = strtotime('+ ' . $salto . ' minute', strtotime($procesFin));

                            $fInit = date('H:i:s', $nuevoInicio);
                            $fFin = date('H:i:s', $nuevoFin);

                            //$string = "Inicio " . $fInit. ' - Fin ' . $fFin;

                            //var_dump($string);


                            //Validar la hora de almuerzo - Es sagrada :v
                            $desde = intval(date('H', $nuevoInicio));
                            $hasta = intval(date('H', $nuevoFin));

                            if ($desde != 12) {
                                $entrada = date('H:i:s', $nuevoInicio);
                                $salida = date('H:i:s', $nuevoFin);

                                //$fechai = date('Y-m-d',$entrada); //fecha
                                //$fechaf = date('Y-m-d',$salida); //fecha


                            }
                            $auxSalto = $auxSalto + intval($salto);

                            //Validar si existe el registro
                            $existDoctorHorario = Doctor_Horario::where('doctor_id', intval($data->doctor_id))
                                ->where('dia_id', $dia->id)->where('hora_inicio',  $entrada)
                                ->where('hora_fin', $salida)->first();


                            if ($existDoctorHorario) {
                                //Existe y no crear
                                $response = [
                                    'status' => false,
                                    'mensaje' => 'El doctor ya tiene asignado su horario semanal',
                                    'doctor_horario' => []
                                ];
                            } else {

                                $doctorHorario = new Doctor_Horario();
                                $doctorHorario->usuario_id = intval($data->usuario_id);
                                $doctorHorario->doctor_id = intval($data->doctor_id);
                                $doctorHorario->dia_id = $dia->id;
                                $doctorHorario->hora_inicio = $entrada;
                                $doctorHorario->hora_fin = $salida;
                                //$doctorHorario->fecha = $fechai;
                                $doctorHorario->estado = 'A';
                                $doctorHorario->status = 'S';
                                $doctorHorario->save();

                                $response = [
                                    'status' => true,
                                    'mensaje' => 'se ha asignado su horario semanal',
                                    'doctor_horario' => $doctorHorario,
                                ];
                            }
                        }
                    }
                    $inicio = $resetDate;
                    $auxSalto = 0;
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'Intervalo de salto debe ser de 1 min a 60 min',
                'horarios_atencion' => null
            ];
        }

        return response()->json($response, 200);
    }
}
