<?php

namespace App\Http\Controllers;

use App\Models\Certificados_Medicos;
use App\Models\Citas;
use App\Models\Empresa;
use App\Models\Laboratorio;
use App\Models\Odonto_Componentedetalle;
use App\Models\Orden;
use App\Models\Paciente;
use App\Models\Receta_Diagnostico;
use App\Models\Usuario;
use Dompdf\Dompdf;
use Dompdf\Options;


//use Illuminate\Http\Request;

class PdfController extends Controller
{



    public function listar_ordenesPdf($id)
    {
        $idorden = intval($id);
        $orden = Orden::find($idorden);

        $response = [];

        if ($orden == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'orden' => null,
            ];
        } else {
            // Obtener los datos de la empresa
            $empresa = Empresa::first();



            foreach ($orden->ordenes_diagnostico as $ord) {
                $ord->diagnosticocie10;
            }
            $orden->doctor->especialidades;

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'orden' => $orden,
                'citas' => $orden->citas->paciente->persona->sexo,
                'docsolicita' => $orden->citas->doctor->persona,
                'espe' => $orden->citas->doctor->especialidades,
                'diagnosticos' => $orden->ordenes_diagnostico,
                'cliente_id' => $orden->doctor->persona->id,

                'empresa' => [
                    'ruc' => $empresa->ruc,
                    'nombre_empresa' => $empresa->nombre_empresa,
                    'direccion_empresa' => $empresa->direccion_empresa,
                    'telefono1_empresa' => $empresa->telefono1_empresa,
                    'telefono2_empresa' => $empresa->telefono2_empresa,
                    'barra2' => $empresa->barra2,
                    'correo' => $empresa->correo,
                    'logo' => $empresa->logo,
                ],


            ];
        }

        // Llamar a generarPdf con la respuesta completa
        return $this->generarPdf($response);
    // return response()->json($response, 200);
    }


    public function generarPdf($response)
    {
        if (!$response['status']) {
            // Manejar el caso en que no hay datos disponibles
            return response()->json($response);
        }

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        // Configurar Dompdf para permitir imágenes remotas
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        // Cargar la vista documento.blade.php en una variable, pasando los datos del usuario
        $html = view('pdf.documento', compact('response'))->render();

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();


        // Mostrar el PDF en una nueva pestaña del navegador
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="documento.pdf"');
    }

    /**FIN  DE PDF INFOME  */






    /**INCIIO DE PDF RECETA  */

    public function listar_ordenesPdf2($id)
    {
        $idCitas = intval($id);
        $citas = Citas::find($idCitas);

        $response = [];

        if ($citas == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'citas' => null,
            ];
        } else {
            $valor = 0;

            foreach ($citas->citas_servicios as $serv) {
                $serv->servicios;
            }
 

            // Inicializar un array para los diagnósticos
            $diagnosticos = [];

            // Verificar si la cita existe
            if ($citas != null) {
                // Obtener diagnósticos directamente de la tabla Receta_Diagnostico
                $diagnosticos = Receta_Diagnostico::where('citas_id', $citas->id) // Filtrar por citas_id
                    ->where('estado', 'A') // Filtrar solo por estado 'A'
                    ->with('diagnosticocie10', 'tipo_diagnostico') // Incluir relaciones
                    ->get();

                // Mapear los diagnósticos a la estructura deseada
                $diagnosticos = $diagnosticos->map(function ($diag) {
                    return [
                        'diagnostico' => [
                            'descripcion' => $diag->diagnosticocie10->descripcion ?? '',
                            'clave' => $diag->diagnosticocie10->clave ?? ''
                        ],
                        'tipo_diagnostico' => [
                            'tipo_diagnostico' => $diag->tipo_diagnostico->tipo_diagnostico ?? ''
                        ]
                    ];
                });
            }

            // Ahora pasas estos diagnósticos a la respuesta
            $response['diagnosticos'] = $diagnosticos;

              // Obtener la última receta (según ID)
            $ultimaReceta = $citas->receta->sortByDesc('id')->first();

            $recetaConDetalles = null;

            if ($ultimaReceta) {
                // Filtrar solo los detalles con estado 'A' y cargar producto
                $ultimaReceta->load(['receta_detalle' => function ($query) {
                    $query->where('estado', 'A')->with('producto')
                    ->with('dosis')->with('frecuencia')->with('via')
                    
                    ;
                }]);

                $recetaConDetalles = $ultimaReceta;
            }


            // Obtener los datos de la empresa
            $empresa = Empresa::first();

                $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'valor' => $valor,
                'citas' => $citas,
                'paciente_id' => $citas->paciente->persona->id,
                'medico_id' => $citas->doctor->persona->id,
                'estado_orden_id' => $citas->estado_cita->id,
                'diagnosticos' => $diagnosticos,
                'receta' => $recetaConDetalles, // Solo la última receta con detalles en estado A
                'empresa' => [
                    'ruc' => $empresa->ruc,
                    'nombre_empresa' => $empresa->nombre_empresa,
                    'direccion_empresa' => $empresa->direccion_empresa,
                    'telefono1_empresa' => $empresa->telefono1_empresa,
                    'telefono2_empresa' => $empresa->telefono2_empresa,
                    'barra2' => $empresa->barra2,
                    'correo' => $empresa->correo,
                    'logo' => $empresa->logo,
                ],
            ];

        }

        return $this->generarPdf2($response);
     //  return response()->json($response, 200);


    }

    public function generarPdf2($response)
    {
        if (!$response['status']) {
            // Manejar el caso en que no hay datos disponibles
            return response()->json($response);
        }

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        // Configurar Dompdf para permitir imágenes remotas
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        // Cargar la vista documento.blade.php en una variable, pasando los datos del usuario
        $html = view('pdf.receta2', compact('response'))->render();

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();


        // Mostrar el PDF en una nueva pestaña del navegador
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="documento.pdf"');
    }

    /**  FIN RECETA */





    /**INICIO DE CERTIFICADO MEDICO */

    public function listar_certificado($citas_id)
    {
        // Convertir $citas_id a un entero
        $citas_id = intval($citas_id);

        // Buscar los certificados médicos que corresponden al citas_id dado
        $certificado = Certificados_Medicos::where('citas_id', $citas_id)->get();

        // Inicializar el arreglo de respuesta
        $response = [];

        // Verificar si se encontraron certificados médicos para el citas_id dado
        if ($certificado->isEmpty()) {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para mostrar',
                'orden' => null,
            ];
        } else {
            // Obtener los datos de la empresa
            $empresa = Empresa::first();

            // Inicializar un arreglo para almacenar los datos de citas
            $citasDatos = [];

            // Iterar sobre cada certificado médico encontrado
            foreach ($certificado as $cer) {
                // Acceder a la relación citas y paciente
                $citas = $cer->citas;
                $paciente = $citas->paciente;
                $doctorHorario = $citas->doctor_horario;
                $tipoContingencia = $cer->tipo_contingencia;
                $aislamiento = $cer->aislamiento;

                // Inicializar un arreglo para almacenar los datos de recetas y diagnósticos
                $recetasDiagnosticoDatos = [];

                // Iterar sobre cada receta y diagnóstico asociado a la cita
                foreach ($citas->receta_diagnostico as $recetaDiagnostico) {
                    // Acceder a la relación diagnosticocie10 dentro de receta_diagnostico
                    $diagnosticoCie10 = $recetaDiagnostico->diagnosticocie10;
                    $recetasDiagnosticoDatos[] = [
                        'diagnostico_cie10' => $diagnosticoCie10,
                        'diagnostico' => $recetaDiagnostico->diagnosticocie10,
                        'receta' => $recetaDiagnostico->receta,
                    ];
                }

                // Guardar los datos de sexo en un arreglo
                // Guardar los datos necesarios en un arreglo
                $citasDatos[] = [
                    'sexo' => $paciente->persona->sexo,
                    'nombre_doctor' => $doctorHorario->doctor->persona,
                    'especialidad' => $doctorHorario->doctor->especialidades,
                    'horario' => $doctorHorario->horario,
                    'recetas_diagnosticos' => $recetasDiagnosticoDatos,

                ];
            }

            // Construir la respuesta con los datos obtenidos
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'certificado' => $certificado,
                //  'tipo_contingencia' => $tipoContingencia,
                'citas' => $citasDatos,
                'empresa' => [
                    'ruc' => $empresa->ruc,
                    'nombre_empresa' => $empresa->nombre_empresa,
                    'direccion_empresa' => $empresa->direccion_empresa,
                    'telefono1_empresa' => $empresa->telefono1_empresa,
                    'telefono2_empresa' => $empresa->telefono2_empresa,
                    'barra2' => $empresa->barra2,
                    'correo' => $empresa->correo,
                    'logo' => $empresa->logo,
                ],
            ];
        }

        return $this->generarPdf3($response);

        //  return response()->json($response, 200);
    }

    public function generarPdf3($response)
    {
        if (!$response['status']) {
            // Manejar el caso en que no hay datos disponibles
            return response()->json($response);
        }

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        // Configurar Dompdf para permitir imágenes remotas
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        // Cargar la vista documento.blade.php en una variable, pasando los datos del usuario
        $html = view('pdf.certificado', compact('response'))->render();

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();


        // Mostrar el PDF en una nueva pestaña del navegador
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="documento.pdf"');
    }

    /**FIN CEERTIFICADO MEDICO */

    /* INICIO DE GENERAR ORDEN EN PDF ODEN DE IMAGENES */


    public function listar_orden_imagenes($id)
    {
        $idCitas = intval($id);
        $citas = Citas::find($idCitas);

        $response = [];

        if ($citas == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'citas' => null,
            ];
        } else {
            $valor = 0;

            foreach ($citas->citas_servicios as $serv) {
                $serv->servicios;
            }

            // Recopilar diagnósticos fuera del bucle de recetas
            $diagnosticos = [];
            foreach ($citas->ordenes as $ord) {
                foreach ($ord->ordenes_diagnostico as $ord_diag) {

                    $diagnostico = [
                        'diagnostico' => $ord_diag->diagnosticocie10,
                        'tipo_diagnostico' => $ord_diag->tipo_diagnostico
                    ];
                    $diagnosticos[] = $diagnostico;
                }
                // Eliminar los diagnósticos de la receta
                unset($ord->receta_diagnostico);
            }

            // Recopilar diagnósticos fuera del bucle de recetas
            $diagnosticos_receta = [];
            foreach ($citas->receta as $rece) {
                foreach ($rece->receta_diagnostico as $recediag) {
                    $diagnostico = [
                        'diagnostico' => $recediag->diagnosticocie10,
                        'tipo_diagnostico' => $recediag->tipo_diagnostico
                    ];
                    $diagnosticos_receta[] = $diagnosticos_receta;
                }
                // Eliminar los diagnósticos de la receta
                unset($rece->diagnosticos_receta);
            }



            foreach ($citas->ordenes as $orden) {
                $orden->tipo_estudio;
            }

            // Obtener los datos de la empresa
            $empresa = Empresa::first();

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'valor' => $valor,
                'citas' => $citas,
                // 'servicios' => $citas->citas_servicios,
                'paciente_id' => $citas->paciente->persona->id,
                'medico_id' => $citas->doctor->persona->id,
                'estado_orden_id' => $citas->estado_cita->id,
                'diagnosticos_receta' => $diagnosticos_receta,
                'diagnosticos' => $diagnosticos, // Agregar los diagnósticos fuera de las recetas     

                'empresa' => [
                    'ruc' => $empresa->ruc,
                    'nombre_empresa' => $empresa->nombre_empresa,
                    'direccion_empresa' => $empresa->direccion_empresa,
                    'telefono1_empresa' => $empresa->telefono1_empresa,
                    'telefono2_empresa' => $empresa->telefono2_empresa,
                    'barra2' => $empresa->barra2,
                    'correo' => $empresa->correo,
                    'logo' => $empresa->logo,
                ],
            ];
        }

        return $this->generar_pdfImagenes($response);
        // 	return response()->json($response, 200);


    }


    public function generar_pdfImagenes($response)
    {
        if (!$response['status']) {
            // Manejar el caso en que no hay datos disponibles
            return response()->json($response);
        }

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        // Configurar Dompdf para permitir imágenes remotas
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        // Cargar la vista documento.blade.php en una variable, pasando los datos del usuario
        $html = view('pdf.imagenes_orden', compact('response'))->render();

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();


        // Mostrar el PDF en una nueva pestaña del navegador
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="imagenes.pdf"');
    }


    /* FIN DE GENERAR ORDEN EN PDF ODEN DE IMAGENES */






    /* INICIO DE GENERAR ORDEN DE LABORATORIO EN PDF  */


    public function listar_orden_laboratorio($id)
    {
        $idCitas = intval($id);
        $citas = Citas::find($idCitas);

        $response = [];

        if ($citas == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'citas' => null,
            ];
        } else {
            $valor = 0;


            foreach ($citas->laboratorio as $lab) {
                foreach ($lab->laboratorio_detalle as $detalle_lab) {

                    $detalle_lab->tipo_examen->categoria_laboratorio;
                }
            }

            // Obtener los datos de la empresa
            $empresa = Empresa::first();

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'valor' => $valor,
                'citas' => $citas,
                // 'servicios' => $citas->citas_servicios,
                'paciente_id' => $citas->paciente->persona->id,
                'medico_id' => $citas->doctor->persona->id,
                'estado_orden_id' => $citas->estado_cita->id,


                'empresa' => [
                    'ruc' => $empresa->ruc,
                    'nombre_empresa' => $empresa->nombre_empresa,
                    'direccion_empresa' => $empresa->direccion_empresa,
                    'telefono1_empresa' => $empresa->telefono1_empresa,
                    'telefono2_empresa' => $empresa->telefono2_empresa,
                    'barra2' => $empresa->barra2,
                    'correo' => $empresa->correo,
                    'logo' => $empresa->logo,
                ],
            ];
        }

        return $this->generar_pdfLaboratorio($response);
        //  	return response()->json($response, 200);


    }


    public function generar_pdfLaboratorio($response)
    {
        if (!$response['status']) {
            // Manejar el caso en que no hay datos disponibles
            return response()->json($response);
        }

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        // Configurar Dompdf para permitir imágenes remotas
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        // Cargar la vista documento.blade.php en una variable, pasando los datos del usuario
        $html = view('pdf.laboratorio_orden', compact('response'))->render();

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();


        // Mostrar el PDF en una nueva pestaña del navegador
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="imagenes.pdf"');
    }


    /* FIN DE GENERAR ORDEN EN PDF ODEN DE IMAGENES */




    /**RESULTADOS LABORATORIO */

    /*         public function listar_resultado_laboratorio($id){
            $idorden = intval($id);
            $orden = Laboratorio::find($idorden);
        
            $response = [];
        
            if($orden == null){
                $response = [
                    'estado'=>false,
                    'mensaje'=>'No hay datos para mostrar',
                    'orden'=> null,
                ];
            }else{
                // Obtener los datos de la empresa
                 $empresa = Empresa::first();
        
             
                    foreach($orden->laboratorio_detalle as $detalle_lab){

                        $detalle_lab->tipo_examen->categoria_laboratorio;  
                    }
                
        
               
                $orden->doctor->especialidades;
                //$orden->tipo_examen;
                $response = [
                    'status' => true,
                    'mensaje' => 'Existen datos',
                    'orden' => $orden,
                    'citas' => $orden->citas->paciente->persona->sexo,
                    'cliente_id' => $orden->doctor->persona->id,
    
                    'empresa' => [
                        'ruc' => $empresa->ruc,
                        'nombre_empresa' => $empresa->nombre_empresa,
                        'direccion_empresa' => $empresa->direccion_empresa,
                        'telefono1_empresa' => $empresa->telefono1_empresa,
                        'telefono2_empresa' => $empresa->telefono2_empresa,
                        'barra2' => $empresa->barra2,
                        'correo' => $empresa->correo,
                        'logo' => $empresa->logo,
                    ],
               
               
                ];
            }
            
            // Llamar a generarPdf con la respuesta completa
        //    return $this->generar_pdfLaboratorioresultado($response);
            return response()->json($response, 200);
        } */


    public function listar_resultado_laboratorio($id)
    {
        $idorden = intval($id);
        $orden = Laboratorio::find($idorden);

        $response = [];

        if ($orden == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'orden' => null,
            ];
        } else {
            // Obtener los datos de la empresa
            $empresa = Empresa::first();

            // Filtrar solo los detalles del laboratorio con estado 'A'
            $detallesActivos = $orden->laboratorio_detalle->filter(function ($detalle_lab) {
                return $detalle_lab->estado == 'A'; // Filtrar por estado activo
            });

            // Si existen detalles activos
            if ($detallesActivos->isNotEmpty()) {
                foreach ($detallesActivos as $detalle_lab) {
                    // Si necesitas cargar la relación del tipo de examen (por ejemplo, la categoría)
                    $detalle_lab->tipo_examen->categoria_laboratorio;
                }
            }

            $orden->doctor->especialidades;

            // Preparar la respuesta
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'orden' => $orden,
                'citas' => $orden->citas->paciente->persona->sexo,
                'cliente_id' => $orden->doctor->persona->id,
                'empresa' => [
                    'ruc' => $empresa->ruc,
                    'nombre_empresa' => $empresa->nombre_empresa,
                    'direccion_empresa' => $empresa->direccion_empresa,
                    'telefono1_empresa' => $empresa->telefono1_empresa,
                    'telefono2_empresa' => $empresa->telefono2_empresa,
                    'barra2' => $empresa->barra2,
                    'correo' => $empresa->correo,
                    'logo' => $empresa->logo,
                ],
                'detalles_laboratorio' => $detallesActivos, // Solo detalles activos
            ];
        }

        return $this->generar_pdfLaboratorioresultado($response);

        //   return response()->json($response, 200);
    }


    public function generar_pdfLaboratorioresultado($response)
    {
        if (!$response['status']) {
            // Manejar el caso en que no hay datos disponibles
            return response()->json($response);
        }

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        // Configurar Dompdf para permitir imágenes remotas
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        // Cargar la vista documento.blade.php en una variable, pasando los datos del usuario
        $html = view('pdf.resultado_laboratorio', compact('response'))->render();

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();


        // Mostrar el PDF en una nueva pestaña del navegador
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="documento.pdf"');
    }


    /**FIN RESULTADOS DE LABORATORIO */




    /* 
        public function listar_informeodonto($id){

            $idPaciente = intval($id);
            $paciente = Paciente::find($idPaciente);
       
            $response = [];
    
            if($paciente == null){
                $response = [
                    'estado'=>false,
                    'mensaje'=>'No hay datos para mostrar',
                    'paciente'=> null,
                ];
            }else{
                $valor = 0 ;

                foreach($paciente->antecedentes_odonto_personal as $ap){
                    $ap->odonto_antecedentes_per;
                }

                foreach($paciente->antecedentes_odonto_familiar as $af){
                    $af->odonto_antecedentes_fam;
                }

                foreach($paciente->antecedentes_odonto_familiar as $af){
                    $af->odonto_antecedentes_fam;
                }

                foreach($paciente->antecedentes_estomatognatico_paciente as $esto){
                    $esto->odonto_estomatognatico;
                }
                
                foreach($paciente->citas as $cit){
                    $cit->servicios;
                    $cit->paciente->persona;
                    foreach($cit->examen_fisica as $exf){
                    
                    }
                     
                }
 

                    $empresa = Empresa::first();
    
                $response = [
                    'status' => true,
                    'mensaje' => 'Existen datos',
                    'valor' => $valor,
                    'paciente' => $paciente,
    
                   
    
                    'empresa' => [
                        'ruc' => $empresa->ruc,
                        'nombre_empresa' => $empresa->nombre_empresa,
                        'direccion_empresa' => $empresa->direccion_empresa,
                        'telefono1_empresa' => $empresa->telefono1_empresa,
                        'telefono2_empresa' => $empresa->telefono2_empresa,
                        'barra2' => $empresa->barra2,
                        'correo' => $empresa->correo,
                        'logo' => $empresa->logo,
                    ],
                ];
            }
    
            return $this->generar_pdfInformeOdonto($response);
         // return response()->json($response, 200);
        } */

    public function listar_informeodonto($id)
    {
        $idPaciente = intval($id);
        $paciente = Paciente::find($idPaciente);

        $response = [];

        if ($paciente == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'paciente' => null,
            ];
        } else {
            $valor = 0;


            foreach ($paciente->odontograma as $odo) {
                $odo->doctor; // Relación de antecedentes estomatognáticos
            }


            // Obtener antecedentes odontológicos personales
            foreach ($paciente->antecedentes_odonto_personal as $ap) {
                $ap->odonto_antecedentes_per; // Relación de antecedentes personales
            }

            // Obtener antecedentes odontológicos familiares
            foreach ($paciente->antecedentes_odonto_familiar as $af) {
                $af->odonto_antecedentes_fam; // Relación de antecedentes familiares
            }

            // Obtener antecedentes estomatognáticos
            foreach ($paciente->antecedentes_estomatognatico_paciente as $esto) {
                $esto->odonto_estomatognatico; // Relación de antecedentes estomatognáticos
            }

            // Obtener citas y sus servicios
            foreach ($paciente->citas as $cit) {
                $cit->servicios; // Relación de servicios asociados a la cita
                $cit->paciente->persona; // Relación con la persona del paciente
                foreach ($cit->examen_fisica as $exf) {
                    // Aquí puedes procesar los exámenes físicos si es necesario
                }
            }

            foreach ($paciente->piezas_paciente_higiene as $pie) {
                $pie->piezas_higiene; // Relación de antecedentes estomatognáticos
            }

            foreach ($paciente->enfermedad_periodontal as $ep) {
                $ep->enfermedad_dientes; // Relación de antecedentes estomatognáticos
            }

            foreach ($paciente->paciente_angle as $pa) {
                $pa->angle; // Relación de antecedentes estomatognáticos
            }

            foreach ($paciente->paciente_fluorosis as $flu) {
                $flu->enfermedad_dientes; // Relación de antecedentes estomatognáticos
            }
            foreach ($paciente->odontograma_diagnostico as $odd) {
                $odd->diagnostico_odonto; // Relación de antecedentes estomatognáticos
                $odd->tipo_diagnostico; // Relación de antecedentes estomatognáticos

            }




            // 🔽🔽🔽 BLOQUE NUEVO: Agrupar tratamientos por cita 🔽🔽🔽
            $detallesAgrupadosPorCita = [];

            foreach ($paciente->odontograma as $odo) {

                $contadorPiezasUnicas = collect();

                foreach ($paciente->odontograma as $odo) {
                    foreach ($odo->odontograma_detalle as $detalle) {
                        // Solo contar piezas activas y de dentición permanente
                        if ($detalle->estado_activo == 'A') {
                            $pieza = intval($detalle->pieza);

                            // Excluir piezas temporales (niños)
                            if (
                                !in_array($pieza, range(51, 55)) &&
                                !in_array($pieza, range(61, 65)) &&
                                !in_array($pieza, range(71, 75)) &&
                                !in_array($pieza, range(81, 85))
                            ) {
                                $contadorPiezasUnicas->put($pieza, true);
                            }
                        }
                    }
                }
                $cantidadPiezasTratadas = $contadorPiezasUnicas->count();




                $contadorPiezasUnicasCompo = collect();

                foreach ($paciente->odontograma as $odo) {
                    foreach ($odo->odonto_componentedetalle as $detalle) {
                        // Solo contar piezas con estado activo y que tengan algún tratamiento
                        if ($detalle->estado_activo == 'A') {
                            $numeroDiente = intval($detalle->numeroDiente);

                            if (
                                !in_array($numeroDiente, range(51, 55)) &&
                                !in_array($numeroDiente, range(61, 65)) &&
                                !in_array($numeroDiente, range(71, 75)) &&
                                !in_array($numeroDiente, range(81, 85))
                            ) {
                                $contadorPiezasUnicasCompo->put($numeroDiente, true);
                            }
                        }
                    }
                }
                $cantidadPiezasTratadasCompo = $contadorPiezasUnicasCompo->count();

                $total = $cantidadPiezasTratadas  +  $cantidadPiezasTratadasCompo;






                //ninos
                $contadorPiezasUnicasNinos = collect();

                foreach ($paciente->odontograma as $odo) {
                    foreach ($odo->odontograma_detalle as $detalle) {
                        // Solo contar piezas activas y de dentición permanente
                        if ($detalle->estado_activo == 'A') {
                            $pieza = intval($detalle->pieza);

                            // Excluir piezas temporales (niños)
                            if (
                                !in_array($pieza, range(11, 18)) &&
                                !in_array($pieza, range(21, 28)) &&
                                !in_array($pieza, range(31, 38)) &&
                                !in_array($pieza, range(41, 48))
                            ) {
                                $contadorPiezasUnicasNinos->put($pieza, true);
                            }
                        }
                    }
                }
                $cantidadPiezasTratadasNinos = $contadorPiezasUnicasNinos->count();




                $contadorPiezasUnicasCompoNinos = collect();

                foreach ($paciente->odontograma as $odo) {
                    foreach ($odo->odonto_componentedetalle as $detalle) {
                        // Solo contar piezas con estado activo y que tengan algún tratamiento
                        if ($detalle->estado_activo == 'A') {
                            $numeroDiente = intval($detalle->numeroDiente);

                            if (
                                !in_array($numeroDiente, range(11, 18)) &&
                                !in_array($numeroDiente, range(21, 28)) &&
                                !in_array($numeroDiente, range(31, 38)) &&
                                !in_array($numeroDiente, range(41, 48))
                            ) {
                                $contadorPiezasUnicasCompoNinos->put($numeroDiente, true);
                            }
                        }
                    }
                }
                $cantidadPiezasTratadasCompoNinos = $contadorPiezasUnicasCompoNinos->count();

                $totalNinos = $cantidadPiezasTratadasNinos  +  $cantidadPiezasTratadasCompoNinos;





                foreach ($odo->odontograma_detalle as $detalle) {
                    $citaId = $detalle->citas_id;
                    $fecha = $detalle->fecha;
                    //   $doctor = $odo->doctor;
                    // Obtener la cita con su relación de doctor
                    $cita = Citas::with('doctor')->find($citaId); // Traes también la relación con el doctor


                    // Inicializamos la cita si aún no existe
                    if (!isset($detallesAgrupadosPorCita[$citaId])) {
                        $detallesAgrupadosPorCita[$citaId] = [
                            'fecha' => $fecha,
                            'doctor' => $cita?->doctor?->persona?->nombre . ' ' . $cita?->doctor?->persona?->apellido, // Cambié esta parte para sacar el nombre del doctor de la cita
                            'firma_doc' => $cita?->doctor?->img_sello, // Cambié esta parte para sacar el nombre del doctor de la cita
                            'procedimientos' => [],
                        ];
                    }

                    // Diagnóstico
                    if ($detalle->diagnostico_odonto) {
                        $detallesAgrupadosPorCita[$citaId]['diagnosticos'][] = $detalle->diagnostico_odonto->clave_od . ' - ' . $detalle->diagnostico_odonto->descripcion_od;
                    }

                    // Procedimiento
                    if ($detalle->procedimiento_odonto) {
                        $detallesAgrupadosPorCita[$citaId]['procedimientos'][] = 'Pieza: ' . $detalle->pieza . '  ' . $detalle->procedimiento_odonto->clave_pro . ' - ' . $detalle->procedimiento_odonto->descripcion_pro;
                    }

                    $cita = Citas::find($citaId); // Buscar la cita usando el cita_id
                    if ($cita && $cita->receta) {
                        foreach ($cita->receta as $receta) {
                            // Agregar receta al array de detalles de la cita
                            $detallesAgrupadosPorCita[$citaId]['recetas'][] = [
                                'medicamento' => $receta->producto->nombre_producto, // Asegúrate de que estos campos existen en tu tabla Recetas
                                'dosis' => $receta->dosis,
                                'frecuencia' => $receta->frecuencia,
                            ];
                        }
                    }
                }
            }



            // Obtener los odontogramas asociados al paciente


            // Agregar los datos de la empresa
            $empresa = Empresa::first();

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'valor' => $valor,
                'paciente' => $paciente,
                'persona' => $paciente->persona,
                'empresa' => [
                    'ruc' => $empresa->ruc,
                    'nombre_empresa' => $empresa->nombre_empresa,
                    'direccion_empresa' => $empresa->direccion_empresa,
                    'telefono1_empresa' => $empresa->telefono1_empresa,
                    'telefono2_empresa' => $empresa->telefono2_empresa,
                    'barra2' => $empresa->barra2,
                    'correo' => $empresa->correo,
                    'logo' => $empresa->logo,
                ],
                'detalles_por_cita' => $detallesAgrupadosPorCita,
                'cantidad_piezas_tratadas' => $cantidadPiezasTratadas,
                'cantidad_compo' => $cantidadPiezasTratadasCompo,
                'total' => $total,


                'piezasninos' => $cantidadPiezasTratadasNinos,
                'cantidad_compoN' => $cantidadPiezasTratadasCompoNinos,
                'totaln' => $totalNinos



            ];
        }

          return $this->generar_pdfInformeOdonto($response);
       // return response()->json($response, 200);
    }



    public function generar_pdfInformeOdonto($response)
    {
        if (!$response['status']) {
            // Manejar el caso en que no hay datos disponibles
            return response()->json($response);
        }

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        // Configurar Dompdf para permitir imágenes remotas
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        // Cargar la vista documento.blade.php en una variable, pasando los datos del usuario
        $html = view('pdf.informe_odontograma', compact('response'))->render();

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();


        // Mostrar el PDF en una nueva pestaña del navegador
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="documento.pdf"');
    }





/*segundo fromato receta pero es el mismo q el de arriba solo cambia la direccion del pdf abajo el nombre del pdf */




    /**INCIIO DE PDF RECETA  */

    public function listar_receta2formato($id)
    {
        $idCitas = intval($id);
        $citas = Citas::find($idCitas);

        $response = [];

        if ($citas == null) {
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para mostrar',
                'citas' => null,
            ];
        } else {
            $valor = 0;

            foreach ($citas->citas_servicios as $serv) {
                $serv->servicios;
            }
 

            // Inicializar un array para los diagnósticos
            $diagnosticos = [];

            // Verificar si la cita existe
            if ($citas != null) {
                // Obtener diagnósticos directamente de la tabla Receta_Diagnostico
                $diagnosticos = Receta_Diagnostico::where('citas_id', $citas->id) // Filtrar por citas_id
                    ->where('estado', 'A') // Filtrar solo por estado 'A'
                    ->with('diagnosticocie10', 'tipo_diagnostico') // Incluir relaciones
                    ->get();

                // Mapear los diagnósticos a la estructura deseada
                $diagnosticos = $diagnosticos->map(function ($diag) {
                    return [
                        'diagnostico' => [
                            'descripcion' => $diag->diagnosticocie10->descripcion ?? '',
                            'clave' => $diag->diagnosticocie10->clave ?? ''
                        ],
                        'tipo_diagnostico' => [
                            'tipo_diagnostico' => $diag->tipo_diagnostico->tipo_diagnostico ?? ''
                        ]
                    ];
                });
            }

            // Ahora pasas estos diagnósticos a la respuesta
            $response['diagnosticos'] = $diagnosticos;

              // Obtener la última receta (según ID)
            $ultimaReceta = $citas->receta->sortByDesc('id')->first();

            $recetaConDetalles = null;

            if ($ultimaReceta) {
                // Filtrar solo los detalles con estado 'A' y cargar producto
                $ultimaReceta->load(['receta_detalle' => function ($query) {
                    $query->where('estado', 'A')->with('producto')
                    ->with('dosis')->with('frecuencia')->with('via')
                    
                    ;
                }]);

                $recetaConDetalles = $ultimaReceta;
            }


            // Obtener los datos de la empresa
            $empresa = Empresa::first();

                $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'valor' => $valor,
                'citas' => $citas,
                'paciente_id' => $citas->paciente->persona->id,
                'medico_id' => $citas->doctor->persona->id,
                'estado_orden_id' => $citas->estado_cita->id,
                'diagnosticos' => $diagnosticos,
                'receta' => $recetaConDetalles, // Solo la última receta con detalles en estado A
                'empresa' => [
                    'ruc' => $empresa->ruc,
                    'nombre_empresa' => $empresa->nombre_empresa,
                    'direccion_empresa' => $empresa->direccion_empresa,
                    'telefono1_empresa' => $empresa->telefono1_empresa,
                    'telefono2_empresa' => $empresa->telefono2_empresa,
                    'barra2' => $empresa->barra2,
                    'correo' => $empresa->correo,
                    'logo' => $empresa->logo,
                ],
            ];

        }

        return $this->generar_formato2receta($response);
     //  return response()->json($response, 200);


    }

    public function generar_formato2receta($response)
    {
        if (!$response['status']) {
            // Manejar el caso en que no hay datos disponibles
            return response()->json($response);
        }

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        // Configurar Dompdf para permitir imágenes remotas
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        // Cargar la vista documento.blade.php en una variable, pasando los datos del usuario
        $html = view('pdf.receta3', compact('response'))->render();

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();


        // Mostrar el PDF en una nueva pestaña del navegador
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="documento.pdf"');
    }

    /**  FIN RECETA */






















}