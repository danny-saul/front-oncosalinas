<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PacienteController extends Controller
{
    //

        
    private $personaController;
    private $doctorController;

    public function __construct(){
        $this->personaController = new PersonaController();
        $this->doctorController =new DoctorController();
    }


        //
        public function listar(){

            $dataPaciente = Paciente::where('estado', 'A')->get();
            $response = [];
    
            if ($dataPaciente) {
                foreach ($dataPaciente as $item) {
                    $item->persona;
                }
    
                $response = [
                    'status' => true,
                    'mensaje' => 'Si hay datos',
                    'paciente' => $dataPaciente,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No hay datos',
                    'paciente' => null,
                ];
            }
    
            return response()->json($response);
        }
    

        public function guardar(Request $request){

            $aux = json_decode($request['data']);
           // dd($aux); die();
            $datausuariorequest = $aux->usuario;
            $datadoctorrequest = $aux->doctor;
         //   $datapacienterequest = $aux->paciente;
            $response = [];
    
            if (!isset($datausuariorequest) || $datausuariorequest == null) {
                $response = [
                    'status' => false,
                    'mensaje' => "No hay datos para procesar",
                    'usuario' => null,
                ];
            } else {
                $responsePersona = $this->personaController->guardarPersona($aux);
                //recuperar el id de persona
                $id_persona = $responsePersona['persona']->id;
                $clave = $datausuariorequest->password; //cedula
                $encriptar = hash('sha256', $clave);
    
                $nuevoUsuario = new Usuario();
                $nuevoUsuario->persona_id = $id_persona;
                $nuevoUsuario->roles_id = $datausuariorequest->roles_id;
                $nuevoUsuario->usuario = ' ';
                $nuevoUsuario->correo =$datausuariorequest->correo;
                $nuevoUsuario->password =' ';
                $nuevoUsuario->password2 = ' ';
                $nuevoUsuario->imagen = str_replace(' ', '', $datausuariorequest->imagen);
                $nuevoUsuario->imagen_cedula = str_replace(' ', '', $datausuariorequest->imagen_cedula);
                $nuevoUsuario->estado = 'A';
                
    
                //exixte usuario
                $existe_usuario = Usuario::where('persona_id', $id_persona)->get()->first();
           //     $exitenombreUsuario = Usuario::where('usuario', $datausuariorequest->usuario)->get()->first();
        //        $exitecorreo = Usuario::where('correo', $datausuariorequest->correo)->get()->first();
    
                if ($existe_usuario) {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El usuario ya se encuentra registrado',
                        'usuario' => null,
                    ];
          
    
          
                }
                else {
                    if ($nuevoUsuario->save()) {
                        //registrar en la tabla doctores
                        if ($datausuariorequest->roles_id == 2) {
                            $responseDoctor = $this->doctorController->guardardoctor($datadoctorrequest, $id_persona);
    
                            if ($responseDoctor == false) {
                                $response = [
                                    'status' => false,
                                    'mensaje' => 'El Doctor ya se encuentra registrado',
                                    'usuario' => $responseDoctor,
                                ];
                            } else {
                                $response = [
                                    'status' => true,
                                    'mensaje' => 'El doctor se ha registrado',
                                    'doctor' => $responseDoctor,
                                ];
                            }
                        } else {
                            if ($datausuariorequest->roles_id == 3) { //cliente
                                $nuevoPaciente = new Paciente();
                                $nuevoPaciente->persona_id = $id_persona;
                                $nuevoPaciente->estado = 'A';
                                $nuevoPaciente->save();
                            }
                        }
                        $response = [
                            'status' => true,
                            'mensaje' => 'El usuario se ha registrado',
                            'usuario' => $nuevoUsuario,
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'mensaje' => 'El usuario no se ha registrado',
                            'usuario' => null,
                        ];
                    }
                }
            }
    
            return response()->json($response, 200);
        }
    
    
    
        
        public function subirFichero(Request $request)
        {
            if ($request->hasFile('fichero')) {
                $img = $_FILES['fichero'];
                $originalName = $request->file('fichero')->getClientOriginalName();
        
                // Quitar espacios del nombre del archivo
                $path = str_replace(' ', '', $originalName);
        
                // Guardar el archivo con el nuevo nombre
                $request->file('fichero')->storeAs('public/fotos', $path);
        
                $response = [
                    'status' => true,
                    'mensaje' => 'Fichero subido',
                    'imagen' => $img['name'],
                    // 'direccion' => $enlace_actual . '/' . $target_path,
                ];
        
                return response()->json($response, 200);
            }
        }
        
    
         
   
        public function subirFichero2(Request $request)
        {
            if ($request->hasFile('fichero')) {
                $img = $_FILES['fichero'];
                $originalName = $request->file('fichero')->getClientOriginalName();
        
                // Quitar espacios del nombre del archivo
                $path = str_replace(' ', '', $originalName);
        
                // Guardar el archivo con el nuevo nombre
                $request->file('fichero')->storeAs('public/cedulas', $path);
        
                $response = [
                    'status' => true,
                    'mensaje' => 'Fichero subido',
                    'imagen' => $img['name'],
                    // 'direccion' => $enlace_actual . '/' . $target_path,
                ];
        
                return response()->json($response, 200);
            }
        }
    
    
    
    
    
        public function getFoto($disk, $file){
    
            if($disk == 'usuarios'){
                $existe = Storage::disk('avatars')->exists($file);
    
                if($existe){
                    $archivo = Storage::disk('avatars')->get($file);
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
    
    
        public function getFile($disk2, $file2){
            if ($disk2 === 'cedulas') {
                $diskName = ($disk2 === 'usuarios') ? 'avatars' : 'cedulas';
                
                $existe = Storage::disk($diskName)->exists($file2);
                
                if ($existe) {
                    $archivo = Storage::disk($diskName)->get($file2);
                    // Devolver el archivo PDF como respuesta
                    return new Response($archivo, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="'.$file2.'"'
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


            public function dataTable_paciente(){

                $datausuario = Usuario::where('estado', 'A')->where('roles_id','3')->get();
                $data = [];  $i = 1;
        
                $base = $_SERVER['APP_URL'].':'.$_SERVER['SERVER_PORT'].'/';
        
                foreach ($datausuario as $usua) {
                    $personas = $usua->persona;
                    $roles = $usua->roles;
                    $operadora = $usua->persona->operadora; /* $fileUrl = url('/api/documents/'.$files['name_file']); */
        
                    $url = $base. 'api/fotos/usuarios/' . $usua->imagen;
                    $url2 = $base. 'api/cedulas/cedulas/' . $usua->imagen_cedula;
        
                    $icono = $usua->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
                    $clase = $usua->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
                    $other = $usua->estado == 'A' ? 0 : 1;
        
                    $botones = '<div class="btn-group">
                             <a class="btn btn-info btn-sm" href="' . $url2 . '" target="_blank">
                       <i class="fa fa-eye fa-lg"></i> </a>
                                    <button class="btn btn-primary btn-sm descargar-pdf" onclick="editar_pac(' . $usua->id . ')">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </button>
                                    <button class="btn ' . $clase . '" onclick="eliminar_usuario(' . $usua->id . ',' . $other . ')">
                                        ' . $icono . '
                                    </button>
                                </div>';
        
                    $data[] = [
                        0 => $i,
                        1 => '<div class="box-img-usuario"><img src=' . $url . ' style="width: 40px; height:30px"></div>',
                        2 => $personas->cedula,
                        3 => $personas->apellido,
                        4 => $personas->nombre,
                        5 => $roles->rol,
                        6 => $usua->correo,
                        7 => $personas->telefono,
                        8 => $operadora->detalle_operadora,
                        9 => $personas->direccion,
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
            }
        
    
}
