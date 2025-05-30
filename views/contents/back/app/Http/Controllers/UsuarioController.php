<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Paciente;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth; 

class UsuarioController extends Controller
{

    
    private $personaController;
    private $doctorController;

    public function __construct(){
        $this->personaController = new PersonaController();
        $this->doctorController =new DoctorController();
    }

    public function dataTable_usuario(){

        $datausuario = Usuario::where('estado', 'A')->get();
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
                            <button class="btn btn-primary btn-sm descargar-pdf" onclick="editar_usuario(' . $usua->id . ')">
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

    //comento 15-07-2024 14:37
     public function iniciarsesion_login(Request $request){

        $aux = json_decode($request['data']);
        $data = $aux->credenciales;
        $entrada = $data->entrada; //cedula
        $clave = $data->clave;
        $encriptar = hash('sha256', $clave);
        $response = [];

        if ((!isset($entrada) || $entrada == "") || (!isset($clave) || $clave == "")) { //false
            $response = [
                'status' => false,
                'mensaje' => 'Falta datos',
            ];
        } else { 
            $usuario = Usuario::where('usuario', $entrada)->get()->first();

            if ($usuario) {
                $doctor = $usuario->persona->doctor;
                $doc_id = [];  $paciente_id = [];

                foreach ($doctor as $doc) {
                    $doc_id = intval($doc->id);
                }

                $ArrayIdPaciente = $usuario->persona->paciente;
                foreach ($ArrayIdPaciente as $chelas) {
                    $paciente_id = $chelas->id;
                }

                if ($this->checkValidator($encriptar, $usuario->password)) {
                    $usuario->persona;
                    $rol = $usuario->roles->rol;
                    $roles_id = $usuario->roles_id;

                    $per = Persona::find($usuario->persona->id);
                    $usuario['persona'] = $per;
                    $nombre = $per->nombres . ' ' . $per->apellidos;
                    
                    $payload = [
                        'user_name' => $usuario->persona,
                        'rol'  => $rol
                    ];

                    $token = JWTAuth::customClaims($payload)->fromUser($usuario);


                    $response = [
                        'status' => true,
                        'mensaje' => 'Sesion iniciada',
                        'rol' => $rol,
                        'roles_id'=> $roles_id,
                        'persona' => $nombre,
                        'usuario' => $usuario,
                        'doctor' => $doc_id,
                        'paciente' => $paciente_id,
                        'token' => $token
                    ];

                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La contraseña es incorrecta',
                    ];
                }
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'El correo es incorrecto',
                ];
            }
        }

        return response()->json($response, 200);
    } 

     private function checkValidator($credencia1, $credencial2){
        if ($credencia1 == $credencial2) {
            return true;
        } else {
            return false;
        }
    } 

    public function contar_usuario(){
        $datausuario = Usuario::where('estado', 'A')->get();
        $response = [];

        if ($datausuario) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Usuarios',
                'cantidad' => $datausuario->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Usuario',
                'cantidad' => 0,
            ];
        }

        return response()->json($response, 200);
    }

    public function contar_paciente(){

        $datacliente = Paciente::where('estado', 'A')->get();
        $response = [];

        if ($datacliente) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Clientes',
                'cantidad' => $datacliente->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Cliente',
                'cantidad' => 0,
            ];
        }

        return response()->json($response, 200);
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
       //     $nuevoUsuario->especialidades_id = $datausuariorequest->especialidades_id;
            $nuevoUsuario->roles_id = $datausuariorequest->roles_id;
            $nuevoUsuario->usuario = $datausuariorequest->usuario;
            $nuevoUsuario->correo = $datausuariorequest->correo;
            $nuevoUsuario->password = $encriptar;
            $nuevoUsuario->password2 = $encriptar;
            $nuevoUsuario->imagen = str_replace(' ', '', $datausuariorequest->imagen);
            $nuevoUsuario->imagen_cedula = str_replace(' ', '', $datausuariorequest->imagen_cedula);
            $nuevoUsuario->estado = 'A';
            
            

            //exixte usuario
            $existe_usuario = Usuario::where('persona_id', $id_persona)->get()->first();
            $exitenombreUsuario = Usuario::where('usuario', $datausuariorequest->usuario)->get()->first();
            $exitecorreo = Usuario::where('correo', $datausuariorequest->correo)->get()->first();

            if ($existe_usuario) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El usuario ya se encuentra registrado',
                    'usuario' => null,
                ];
            }else if ($exitenombreUsuario){
                $response = [
                    'status' => false,
                    'mensaje' => 'El nombre de usuario ya se encuentra registrado',
                    'usuario' => null,
                ];

            } else if ($exitecorreo){
                $response = [
                    'status' => false,
                    'mensaje' => 'El correo ya se encuentra registrado',
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


    public function listarUsuarioxid($id){

        $datausuario = Usuario::find($id);
        $base = $_SERVER['APP_URL'].':'.$_SERVER['SERVER_PORT'].'/';
        $response = [];

        if ($datausuario) {
            $datausuario->roles;
            $datausuario->persona->sexo;

            if($datausuario->persona->doctor){
                $doctor = $datausuario->persona->doctor;
                $tipocobertura = $datausuario->persona->tipo_cobertura;
                $tiposeguro = $datausuario->persona->tipo_seguro;
                $operadora = $datausuario->persona->operadora;
            }

            
        
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'usuario' => $datausuario,
            ];
    

        
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'usuario' => null,
            ];
        }

        return response()->json($response, 200);
    }


    public function editarUsuario(Request $request){

        $aux = json_decode($request['data']);
        $usuariorequest = $aux->usuario;

        $idusuario = intval($usuariorequest->id);
        $personaid = intval($usuariorequest->persona_id);
        $roles_id = intval($usuariorequest->roles_id);
        $sexo_id = intval($usuariorequest->sexo_id);
        $operadora_id = intval($usuariorequest->operadora_id);
        $tipo_cobertura_id = intval($usuariorequest->tipo_cobertura_id);
        $tipo_seguro_id = intval($usuariorequest->tipo_seguro_id);

        $usuariodata = Usuario::find($idusuario);
        $response = [];

        if ($usuariorequest) {
            if ($usuariodata) {
                $usuariodata->persona_id = $personaid;
    
                $usuariodata->roles_id = $roles_id;
                $usuariodata->usuario = $usuariorequest->usuario;
                $usuariodata->correo = $usuariorequest->correo;

                $personadata = Persona::find($usuariodata->persona_id);
                $personadata->cedula = $usuariorequest->cedula;
                $personadata->nombre = $usuariorequest->nombre;
                $personadata->apellido = $usuariorequest->apellido;
                $personadata->telefono = $usuariorequest->telefono;
                $personadata->celular = $usuariorequest->celular;

                $personadata->direccion = $usuariorequest->direccion;
                $personadata->fecha_nacimiento = $usuariorequest->fecha_nacimiento;
                $personadata->responsable = $usuariorequest->responsable;
                $personadata->sexo_id = $sexo_id;
                $personadata->operadora_id = $operadora_id;
                $personadata->tipo_cobertura_id = $tipo_cobertura_id;
                $personadata->tipo_seguro_id = $tipo_seguro_id;

                
                $personadata->save();
                $usuariodata->save();

                if ($usuariodata->save()) {
            
                }
                $response = [
                    'status' => true,
                    'mensaje' => 'el usuario se ha actualizado',
                    'usuario' => $usuariodata,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el usuario',
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



    public function getPDFpreview($disk, $file)
    {
        if ($disk === 'cedulas') {
            $diskName = ($disk === 'usuarios') ? 'avatars' : 'cedulas';

            $existe = Storage::disk($diskName)->exists($file);

            if ($existe) {
                $archivo = Storage::disk($diskName)->get($file);
                // Devolver el archivo PDF como respuesta
                return new Response($archivo, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$file.'"'
                ]);
            } else {
                abort(404, 'Archivo no existe');
            }
        } else {
            abort(400, 'Disco no válido');
        }
    }



}
