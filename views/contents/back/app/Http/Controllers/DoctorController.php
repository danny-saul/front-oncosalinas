<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Especialidades;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DoctorController extends Controller
{
    //
    public function guardardoctor($doctor, $persona_id)
    {
        if ($doctor) {
            $nuevodoctor = new Doctor();
            $nuevodoctor->persona_id = $persona_id;
            $nuevodoctor->especialidades_id =$doctor->especialidades_id;
            $nuevodoctor->reg_senescyt ='09999999999';
            $nuevodoctor->reg_access ='098755555555';
            $nuevodoctor->img_sello = str_replace(' ', '', $doctor->img_sello);
            $nuevodoctor->estado = 'A';
            $nuevodoctor->save();

            return $nuevodoctor;

        } else {
            return null;
        }
    }

    public function getDoctor(){

        $dataDoctor = Doctor::where('estado', 'A')->get();
        $response = [];

        if ($dataDoctor) {
            foreach ($dataDoctor as $chelas) {
                $chelas->persona;
                $dh = $chelas->doctor_horario;

                foreach ($dh as $item) {
                    $item->horarios_atencion;
                }
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'doctor' => $dataDoctor,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'doctor' => null,
            ];
        }

        return response()->json($response, 200);
    }

    public function listar_medico()
    {
        $response = [];

        $dtdoctor = Doctor::where('estado', 'A')->get();

        if($dtdoctor){
            foreach($dtdoctor as $pers){
                $pers->persona;
                foreach($pers->doctor_especialidades as $espe){
                    $espe->especialidades;

                }
               
            }
            $response = [
                'status' => true,
                'mensaje' => 'Existen Datos',
                'doctor' => $dtdoctor
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No Existen Datos',
                'doctor' => $dtdoctor
            ];

        }

        return response()->json($response, 200);

    }



    public function listarEspecialidades(){

        $dtEspecialidades = Especialidades::where('estado', 'A')->get();
        $response = [];

        if ($dtEspecialidades) {
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'especialidades' => $dtEspecialidades,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'especialidades' => null,
            ];
        }

        return response()->json($response, 200);
    }


    
public function subirSello(Request $request)
{
    if ($request->hasFile('fichero')) {
        $img = $_FILES['fichero'];
        $originalName = $request->file('fichero')->getClientOriginalName();

        // Quitar espacios del nombre del archivo
        $path = str_replace(' ', '', $originalName);

        // Guardar el archivo con el nuevo nombre
        $request->file('fichero')->storeAs('public/sellos', $path);

        $response = [
            'status' => true,
            'mensaje' => 'Fichero subido',
            'imagen' => $img['name'],
            // 'direccion' => $enlace_actual . '/' . $target_path,
        ];

        return response()->json($response, 200);
    }
}





public function getSello($disk, $file){

    if($disk == 'sellos'){
        $existe = Storage::disk('sellos')->exists($file);

        if($existe){
            $archivo = Storage::disk('sellos')->get($file);
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


}
