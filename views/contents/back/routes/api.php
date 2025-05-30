<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AntecedentesController, AntecedentesFamiliarController, CategoriasController, CitasController, Correos_RecibidosController, Diagnosticocie10Controller, Doctor_HorarioController, DoctorController, DosisController, Examenes_ImagenesController, Examenes_LaboratorioController, FrecuenciaController, Higiene_Controller, Laboratorio_DetalleController, LaboratorioController, Odontograma_Componentdetalle, Odontograma_ComponentdetalleController, OdontogramaController, OdontoPerAntecedenteController, OrdenController, Paciente_AntecedentesController, PacienteController, PdfController, PDFController2, PdfControllerNuevo, PdfRecetaController, PermisoController, ProductoController, Receta_DetalleController, Receta_DiagnosticosController, RecetaController, RolController, ServiciosController, SexoController, Tipo_CoberturaController, Tipo_EstudioController, UsuarioController, VentasController, ViaController, };
use App\Models\Diagnosticocie10;
use App\Models\Dosis;
use App\Models\Tipo_Estudio;
use App\Http\Controllers\AuthController;
use App\Models\Odonto_Componentedetalle;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/fotos/{disk}/{file}', [ UsuarioController::class, 'getFoto' ]);
Route::get('/cedulas/{disk2}/{file2}', [ UsuarioController::class, 'getFile' ]); 
Route::get('/sellos/{disk4}/{file4}', [ DoctorController::class, 'getSello' ]);
Route::get('/estudios/{disk3}/{file3}', [ Examenes_ImagenesController::class, 'getFile' ]); 
 
Route::get('/cedulas/{disk}/{file}', [UsuarioController::class, 'getPDFpreview']);
Route::get('/productos/{disk5}/{file5}', [ProductoController::class, 'obtenerImgProducto']);

Route::get('/generar-pdf', [PdfController::class, 'generarPdf']);
Route::get('/listar_ordenesPdf/{id}', [ PdfController::class, 'listar_ordenesPdf']);
Route::get('/receta/{id}', [ PdfController::class, 'listar_ordenesPdf2']);
Route::get('/generar-pdf2', [PdfController::class, 'generarPdf2']);
Route::get('/certificado/{citas_id}', [ PdfController::class, 'listar_certificado']);
Route::get('/generar-pdf3', [PdfController::class, 'generarPdf3']);


Route::get('/imagenes_orden/{id}', [ PdfController::class, 'listar_orden_imagenes']);
Route::get('/generar-pdf4', [PdfController::class, 'generar_pdfImagenes']);

Route::get('/laboratorio_orden/{id}', [ PdfController::class, 'listar_orden_laboratorio']);
Route::get('/generar-pdf5', [PdfController::class, 'generar_pdfLaboratorio']);


Route::get('/listar_resultadoslabPdf/{id}', [ PdfController::class, 'listar_resultado_laboratorio']);
Route::get('/generar-pdf6', [PdfController::class, 'generar_pdfLaboratorioresultado']);

Route::get('/informeodonto/{id}', [ PdfController::class, 'listar_informeodonto']);
Route::get('/generar-pdf7', [PdfController::class, 'generar_pdfInformeOdonto']); 


Route::get('/recetaf2/{id}', [ PdfController::class, 'listar_receta2formato']);
Route::get('/generar-pdf8', [PdfController::class, 'generar_formato2receta']); 




/* Route::get('/informeodonto/{id}', [ OdontogramaController::class, 'listar_informeodonto']);
Route::get('/generar-pdf7', [OdontogramaController::class, 'generar_pdfInformeOdonto']);
 */
 
Route::post('/usuario/login', [ UsuarioController::class, 'iniciarsesion_login' ]); 

Route::group(['prefix' => 'usuario', 'middleware' => ['jwt.verify'] ], function () {
    Route::post('/guardar', [ UsuarioController::class, 'guardar' ]);
    Route::post('/editar', [ UsuarioController::class, 'editarUsuario' ]);
    Route::post('/fichero', [ UsuarioController::class, 'subirFichero']);
    Route::get('/contar', [ UsuarioController::class, 'contar_usuario']);
    Route::get('/contarpaciente', [ UsuarioController::class, 'contar_paciente']);

    Route::post('/fichero2', [ UsuarioController::class, 'subirFichero2']);
    Route::get('/listarusuario', [ UsuarioController::class, 'dataTable_usuario']);
    Route::get('/listarusuid/{id}', [ UsuarioController::class, 'listarUsuarioxid']);
    Route::get('/descargarPDF/{id}', [ UsuarioController::class, 'descargarPDF']);
    Route::post('/upload', [UsuarioController::class, 'uploadPdf']);
});

Route::group([ 'prefix' => 'permiso'], function () {
    Route::get('/menu', [ PermisoController::class, 'menu' ]);
    Route::get('/lista', [ PermisoController::class, 'lista']);
    Route::get('/get/{rol}', [ PermisoController::class, 'getPermisoRol']);
    Route::get('/rol/{id}', [ PermisoController::class, 'newPermiso' ]);

    Route::post('/otorgar', [ PermisoController::class, 'otorgar']);
});


Route::group(['prefix' => 'diagnostico', 'middleware' => ['jwt.verify']], function () {
    Route::get('/listar', [ Diagnosticocie10Controller::class, 'listar' ]);
    Route::get('/buscar', [Diagnosticocie10Controller::class, 'buscar']);

    Route::get('/listartipo', [ Diagnosticocie10Controller::class, 'listartipo' ]);
    Route::get('/listar/{id}', [ Diagnosticocie10Controller::class, 'listar_diagnosticoxID' ]);
    Route::get('/guardar', [ Diagnosticocie10Controller::class, 'guardar' ]);



    
});

Route::group(['prefix' => 'sexo', 'middleware' => ['jwt.verify'] ], function () {
    Route::get('/listar', [ SexoController::class, 'listar' ]);
});


Route::group(['prefix' => 'rol' , 'middleware' => ['jwt.verify'] ], function () {
    Route::get('/listar', [ RolController::class, 'listar' ]);
    Route::post('/guardar', [ RolController::class, 'guardar' ]);


 
});


Route::group(['prefix' => 'ventas' , 'middleware' => ['jwt.verify'] ], function () {
    Route::get('/listardatatable', [ VentasController::class, 'datatable_clientes' ]);
    Route::get('/listardatatableprod', [ VentasController::class, 'datatable_producto' ]);
    Route::get('/listarclientexid/{id}', [ VentasController::class, 'listarCliente_id' ]);
    Route::get('/listarproductoid/{id}', [ VentasController::class, 'listarProducto_id' ]);
    Route::get('/listar_producto', [ VentasController::class, 'listar_producto' ]);
    Route::get('/generar_aleartorio_ventas/{id_tablas}', [ VentasController::class, 'generar_numeros_aleartorios']);
    Route::post('/aumentarAleartoriosVentas', [ VentasController::class, 'aumentarAleartoriosVenta']);
 //   Route::post('/guardar', [ RolController::class, 'guardar' ]);


 
});


Route::group(['prefix' => 'tipo_examen', 'middleware' => ['jwt.verify']], function () {
    Route::get('/listar', [ LaboratorioController::class, 'listar_tipoexamen' ]);
    Route::get('/listarLab/{id}', [ LaboratorioController::class, 'listarId']);
    Route::get('/generar_aleartorio_lab/{id_tablas2}', [ LaboratorioController::class, 'generar_aleartorio_lab']);
    Route::post('/aumentarAleartoriosLab', [ LaboratorioController::class, 'aumentarAleartoriosLab']);
    Route::get('/listar_tipoexamenAnterior', [ LaboratorioController::class, 'listar_tipoexamenAnterior' ]);
 

    
});

Route::group(['prefix' => 'tipo_cobertura', 'middleware' => ['jwt.verify']], function () {
    Route::get('/listar', [ Tipo_CoberturaController::class, 'listar_tipocobertura' ]);
    Route::get('/listaroperadora', [ Tipo_CoberturaController::class, 'listar_operadora' ]);
    Route::get('/listartiposeguro', [ Tipo_CoberturaController::class, 'listar_tiposeguro' ]);


 
});

Route::group(['prefix' => 'doctor', 'middleware' => ['jwt.verify']], function(){
    Route::get('/listar', [ DoctorController::class, 'getDoctor']);
    Route::get('/listardoctor', [ DoctorController::class, 'listar_medico']);
    Route::get('/listar/{id}', [ DoctorController::class, 'getDoctorId']);
    Route::get('/listarArray', [ DoctorController::class, 'listarArray']);
    Route::get('/datatable', [ DoctorController::class, 'getDoctordatatable']);
    Route::get('/search/{texto}', [ DoctorController::class, 'searchDoctor']);
    Route::post('/fichero3', [ DoctorController::class, 'subirSello']);

    Route::post('/eliminar', [ DoctorController::class, 'eliminar']);
    Route::post('/editar', [ DoctorController::class, 'editar']);
    Route::get('/listarespecialidades', [ DoctorController::class, 'listarEspecialidades']);

});



Route::group(['prefix' => 'doctor_horario', 'middleware' => ['jwt.verify']], function(){

    Route::get('/buscarDoctor', [ Doctor_HorarioController::class, 'buscarDoctor']);
    Route::get('/get_horas/{fecha}/{doctorId}/', [ Doctor_HorarioController::class, 'getHoras']);

    Route::post('/generar', [ Doctor_HorarioController::class, 'generar']);
});

Route::group(['prefix' => 'paciente', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listar', [ PacienteController::class, 'listar']);
    Route::post('/guardar', [ PacienteController::class, 'guardar' ]);
    Route::post('/fichero', [ PacienteController::class, 'subirFichero']);
    Route::post('/fichero2', [ PacienteController::class, 'subirFichero2']);
    Route::get('/dtlistar', [ PacienteController::class, 'dataTable_paciente']);

    

});


Route::group(['prefix' => 'servicios', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listar', [ ServiciosController::class, 'listar']);
    Route::get('/listar/{id}', [ ServiciosController::class, 'listar_serviciosxID' ]);

});



route::group(['prefix' => 'categoria' , 'middleware' => ['jwt.verify']], function (){
    Route::get('/datatable_categoria', [ CategoriasController::class, 'datatable_categoria' ]);
    Route::post('/guardar_categoria', [ CategoriasController::class, 'guardar_categoria' ]);
    Route::get('/listar_categorias', [ CategoriasController::class, 'listar_categorias' ]);
    Route::get('/listar_presentacion', [ CategoriasController::class, 'listar_presentacion' ]); 

    Route::post('/editar',[CategoriasController::class,'editar']);
    Route::post('/eliminar/{id}',[CategoriasController::class,'eliminar']);
    Route::get('/listarId/{id}', [ CategoriasController::class, 'listarId' ]);
    Route::get('/listarinventariocateprod/{id}', [ CategoriasController::class, 'listarinventariocateprod' ]);

    

});


Route::group(['prefix' => 'citas', 'middleware' => ['jwt.verify']], function(){

    Route::post('/guardar', [ CitasController::class, 'guardarCitas']);
    Route::post('/crear', [ CitasController::class, 'crearCitas']);
    Route::get('/listardatatablexmedico/{medicoId}', [ CitasController::class, 'datatablelistarxmedico']);
    Route::get('/listardatatablexmedico_atendidas/{medicoId}/{fechaInicio}/{fechaFin}', [ CitasController::class, 'datatablelistarxmedico_atendidas']);
    Route::get('/listardatatablexmedico_canceladas/{medicoId}/{fechaInicio}/{fechaFin}', [ CitasController::class, 'datatablelistarxmedico_canceladas']);
    Route::get('/listarcitasxid/{id}', [ CitasController::class, 'listar_citaxID']);
    Route::post('/guardar_historiaclinica', [ CitasController::class, 'guardando_atencion_medica']);
    Route::get('/listarcitas_xid/{id}', [ CitasController::class, 'listar_citasxid']);
    Route::get('/contar_citaspendiente/{medicoId}', [ CitasController::class, 'contar_citaspendiente']);

    Route::get('/listaraislamiento', [ CitasController::class, 'listaraislamiento']);
    Route::get('/listarcontingencia', [ CitasController::class, 'listarcontingencia']);
    Route::get('/cancelar/{recetaId}', [ CitasController::class, 'eliminarItemReceta']);
    Route::get('/datatableRecetas/{receta_id}', [ CitasController::class, 'datatableRecetas']);
    Route::get('/listar_recetas/{id}', [ CitasController::class, 'listar_recetas']);
    Route::post('/editarReceta', [ CitasController::class, 'editarReceta']);
    Route::post('/agregaredicionmedicamento', [ CitasController::class, 'guardar_edicionreceta']);


    Route::get('/dtableeditardiagnostico/{citaId}', [ CitasController::class, 'dtableeditardiagnostico']);

    Route::get('/listar_diagnostico/{id}', [ CitasController::class, 'listar_diagnostico']);
    Route::post('/editarDiagnostico', [ CitasController::class, 'editarDiagnostico']);
    Route::get('/cancelardiagnostico/{recetaId}', [ CitasController::class, 'eliminarItemRecetaDiagnostico']);
    Route::post('/agregarediciondiagnostico', [ CitasController::class, 'guardar_edicionDiagnostico']);

    Route::post('/editarHistorialClinico', [ CitasController::class, 'editarCitasHistorialClinico']);

    
    Route::get('/eliminarCitasCancelar/{id}', [ CitasController::class, 'eliminarCitasCancelar']);

    
    
    Route::get('/datatablelistarcitasGeneral', [ CitasController::class, 'datatablelistarcitasGeneral']);


    Route::get('/atendientocitas/{id}', [ CitasController::class, 'atendientocitas']);

    
    
});

Route::group(['prefix' => 'producto', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listar', [ ProductoController::class, 'listar_producto']);
    Route::post('/guardar', [ ProductoController::class, 'guardar_producto']);
    Route::post('/editar', [ ProductoController::class, 'editar']);
    Route::post('/guardar_prod2', [ ProductoController::class, 'guardar_producto2']);
    Route::get('/listar/{id}', [ ProductoController::class, 'listarId']);
    Route::post('/subirImagenes ', [ ProductoController::class, 'subirImgProducto']);
    Route::get('/datatable_producto', [ ProductoController::class, 'datatable_producto' ]);
    Route::get('/datatable_medicamentos', [ ProductoController::class, 'datatable_medicamentos' ]);
    Route::get('/cantidadproducto', [ ProductoController::class, 'cantidadproducto' ]);
    Route::get('/graficoStockProductos',[ProductoController::class,'graficoStockProductos']);

    
 
    

});

Route::group(['prefix' => 'tipoestudio', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listar', [ Tipo_EstudioController::class, 'listar_tipoestudio']);
    Route::get('/listar_tipoestudioNormal', [ Tipo_EstudioController::class, 'listar_tipoestudioNormal']);
    Route::get('/listar/{id}', [ Tipo_EstudioController::class, 'listarId']);
 
   

});

Route::group(['prefix' => 'correos', 'middleware' => ['jwt.verify']], function(){

    Route::get('/recibidos', [ Correos_RecibidosController::class, 'dt_correosrecibidos']);
    Route::get('/listar/{id}', [ Correos_RecibidosController::class, 'listarId']);
    Route::post('/editar', [ Correos_RecibidosController::class, 'editar']);
 
   
    Route::get('/dtsubscribe', [ Correos_RecibidosController::class, 'dt_susbscribe']);
    Route::get('/listarsubscribe/{id}', [ Correos_RecibidosController::class, 'listarsubscribe']);
    Route::post('/editarsubscribe', [ Correos_RecibidosController::class, 'editarsubscribe']);

});



Route::group(['prefix' => 'dosis', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listar', [ DosisController::class, 'listar']);
 
   

});

Route::group(['prefix' => 'frecuencia', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listar', [ FrecuenciaController::class, 'listar']);
 
   

});

Route::group(['prefix' => 'examenes_imagen', 'middleware' => ['jwt.verify']], function(){

/*     Route::get('/listardatatable/{medicoId}', [ Examenes_ImagenesController::class, 'datatablelistarxmedico2']);
    Route::get('/listarresultados/{medicoId}', [ Examenes_ImagenesController::class, 'datatablelistarresultadoxmedico']); */
/*     Route::get('/listarresultadosconcluidos/{medicoId}', [ Examenes_ImagenesController::class, 'listarresultadosconcluidos']); */
    Route::get('/listarorden/{id}', [ Examenes_ImagenesController::class, 'listar_Orden']);
    Route::get('/contar_ordenesImagenespendiente/{medicoId}', [ Examenes_ImagenesController::class, 'contar_ordenesImagenespendiente']);

    
 
    Route::get('/listardatatable', [ Examenes_ImagenesController::class, 'datatablelistarOrdenGeneral']);
   Route::get('/listarresultadosconcluidos', [ Examenes_ImagenesController::class, 'listarresultadosconcluidosGeneral']);
   

});


Route::group(['prefix' => 'examenes_laboratorio', 'middleware' => ['jwt.verify']], function(){

    Route::get('/dttablelistarlaboratorio/{medicoId}', [ Examenes_LaboratorioController::class, 'dttablelistarlaboratorio']);
    Route::get('/listarresultadosconcluidos/{medicoId}', [ Examenes_LaboratorioController::class, 'listarresultadosconcluidos']);
    Route::get('/listarorden/{id}', [ Examenes_ImagenesController::class, 'listar_Orden']);
    Route::get('/contar_ordenesImagenespendiente/{medicoId}', [ Examenes_ImagenesController::class, 'contar_ordenesImagenespendiente']);

    
 
 
   

});

Route::group(['prefix' => 'via', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listar', [ ViaController::class, 'listar']);
  
   

});

Route::group(['prefix' => 'receta', 'middleware' => ['jwt.verify']], function(){
    
        Route::get('/generar_aleartorio_rec/{id_tablas4}', [ RecetaController::class, 'generar_aleartorio_rece']);
        Route::post('/aumentarAleartoriosRec', [ RecetaController::class, 'aumentarAleartoriosRec']);

        Route::post('/guardarReceta', [ RecetaController::class, 'guardarOrdenReceta']);






   Route::get('/datatable_receta_editar/{id}', [ RecetaController::class, 'datatable_receta_editar']);


    Route::get('/listar_encabezadoreceta/{citaId}', [ RecetaController::class, 'listar_encabezadoreceta']);
    Route::post('/guardarRecetaNew', [ RecetaController::class, 'guardarOrdenRecetaNueva']);


  /*   Route::post('/guardar_agregarLabsEdicion', [ LaboratorioController::class, 'guardar_agregarLabsEdicion']);
    Route::get('/eliminarItemLabs/{LabsId}', [ LaboratorioController::class, 'eliminarItemLabs']);


    Route::get('/detallexId/{id}', [ Laboratorio_DetalleController::class, 'listarDetalleXId']);
    Route::post('/guardarDetalleItems', [ Laboratorio_DetalleController::class, 'editarItemsLabs']);

 */


        
        
    });
    
    Route::group(['prefix' => 'recetadiagnostico', 'middleware' => ['jwt.verify']], function(){
        
        
        Route::post('/guardar_recetas_diagnosticos', [ Receta_DiagnosticosController::class, 'guardar_recetas_diagnosticos']);
        Route::post('/guardarSinReceta', [Receta_DiagnosticosController::class, 'guardarDiagnosticosSinReceta']);

});

   


Route::group(['prefix' => 'ordenes', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listarorden/{id}', [ OrdenController::class, 'listar_Orden']);
    Route::get('/listar_ordenes/{id}', [ OrdenController::class, 'listar_ordenes']);
    Route::post('/subirestudio', [ OrdenController::class, 'subirEstudioPdf']);
    Route::post('/editar', [ OrdenController::class, 'editar']);
    Route::get('/generar_numeros_aleartorios/{id_tablas}', [ OrdenController::class, 'generar_numeros_aleartorios']);
    Route::post('/aumentarNumerosAleartorios', [ OrdenController::class, 'aumentarNumerosAleartorios']);


    /**INICIO EDITAR ORDEN */
    
    Route::get('/dttablelistarorden/{id}', [ OrdenController::class, 'datatableOrdenesImagenes']);
    Route::post('/editarOrdenesImagenes', [ OrdenController::class, 'editarOrdenesImagenes']);
    Route::get('/cancelarordeneseditar/{ordenId}', [ OrdenController::class, 'eliminarItemOrdenes']);
    Route::post('/guardarOrdenEdicion', [ OrdenController::class, 'guardar_ordenesEdicion']);

    
    
});

Route::group(['prefix' => 'laboratorio', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listar/{id}', [ Examenes_LaboratorioController::class, 'listar_Orden']);
    Route::post('/editar', [ Examenes_LaboratorioController::class, 'editar']);
    Route::post('/guardarOrden', [ LaboratorioController::class, 'guardarOrdenLaboratorio']);

    

    Route::get('/datatableLaboratorioeditar/{id}', [ LaboratorioController::class, 'datatableLaboratorioeditar']);
    Route::get('/listar_encabezadolabs/{citaId}', [ LaboratorioController::class, 'listar_encabezadolabs']);
    Route::post('/guardar_agregarLabsEdicion', [ LaboratorioController::class, 'guardar_agregarLabsEdicion']);
    Route::get('/eliminarItemLabs/{LabsId}', [ LaboratorioController::class, 'eliminarItemLabs']);


    Route::get('/detallexId/{id}', [ Laboratorio_DetalleController::class, 'listarDetalleXId']);
    Route::post('/guardarDetalleItems', [ Laboratorio_DetalleController::class, 'editarItemsLabs']);


    

/*
    Route::get('/generar_numeros_aleartorios/{id_tablas}', [ OrdenController::class, 'generar_numeros_aleartorios']);
    Route::post('/aumentarNumerosAleartorios', [ OrdenController::class, 'aumentarNumerosAleartorios']); */

    
});


Route::group(['prefix' => 'antecedentes', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listarAntecedentesXGrupos', [ AntecedentesController::class, 'listarGrupos_antecedentes']);
    Route::get('/listargruposxid/{grupo_id}', [ AntecedentesController::class, 'listarGrupos_antecedentesxid']);
  //  Route::post('/guardar', [ AntecedentesController::class, 'guardar_antecedentes']);
   // Route::post('/', [ AntecedentesController::class, 'guardar_antecedentes']);
 
   

});

Route::group(['prefix' => 'antecedentesfamiliares', 'middleware' => ['jwt.verify']], function(){

    Route::get('/listarantecedentesfamiliares', [ AntecedentesFamiliarController::class, 'listarGrupos_antecedentesfamiliares']);
    Route::post('/guardar', [ AntecedentesFamiliarController::class, 'guardar_antecedentes_familiares']);
    Route::get('/listar/{paciente_id}', [ AntecedentesFamiliarController::class, 'listar_antecedentesfamiliaresxid']);
 
    
   

});

Route::group(['prefix' => 'pacienteantecedentes', 'middleware' => ['jwt.verify']], function(){

 
   Route::post('/guardar', [ Paciente_AntecedentesController::class, 'guardar_antecedentes']);
   Route::get('/listar/{paciente_id}', [ Paciente_AntecedentesController::class, 'listar_antecedentesxid']);
   

});

Route::group(['prefix' => 'odontograma', 'middleware' => ['jwt.verify']], function(){
 
    Route::post('/guardar', [ OdontogramaController::class, 'guardando_odonto']);
    Route::get('/listarodontopaciente/{paciente_id}', [ OdontogramaController::class, 'obtenerOdontograma']);




    Route::get('/listar_tratamientos', [ OdontogramaController::class, 'listar']);
    Route::get('/listar_odontogramas', [ OdontogramaController::class, 'listarOdontogramas']);
    Route::get('/listar_odontogramas/{paciente_id}', [ OdontogramaController::class, 'listarOdontogramapacienteid']);


    
    Route::get('/listardiagnostico', [ OdontogramaController::class, 'listar_diagnostico_odnto' ]);
    Route::get('/listarprocedimiento ', [ OdontogramaController::class, 'listar_procedimiento_odnto' ]);

    Route::get('/listarodontogramadetallexid/{id}', [ OdontogramaController::class, 'listar_detalleodontoxid' ]);
    Route::post('/editarDetalleOdonto', [ OdontogramaController::class, 'editarOdontogramaDetalle']);
   // Route::get('/cancelardetalleodonto/{DetalleOdontoID}', [ OdontogramaController::class, 'eliminarItemOdontograma']);

    Route::post('/eliminarDetalleOdonto', [ OdontogramaController::class, 'eliminarOdontogramaDetalle']);

    
    Route::post('/guardar_edicionDiagnosticoO', [ OdontogramaController::class, 'guardar_edicionDiagnosticoO']);
    Route::get('/dtableeditardiagnosticoOdonto/{odontograma_id}', [ OdontogramaController::class, 'dtableeditardiagnosticoOdonto']);
    Route::get('/listar_odontodiagnostico/{paciente_id}', [ OdontogramaController::class, 'listar_odontodiagnostico']);
    
    
    
    Route::get('/eliminarItemRDiagnostico/{id}', [ OdontogramaController::class, 'eliminarItemRDiagnostico']);
  //  Route::get('/eliminarItemRDiagnostico/{paciente_id}', [ OdontogramaController::class, 'eliminarItemRDiagnostico'])->withoutMiddleware('throttle:api');

    
});


Route::group(['prefix' => 'odontogramacomponente', 'middleware' => ['jwt.verify']], function(){
 
    Route::post('/guardar', [ Odontograma_ComponentdetalleController::class, 'guardando_odontodetallecomponente']);
    Route::get('/listar_odcomponentexcita/{id}', [ Odontograma_ComponentdetalleController::class, 'listar_odcomponentexcita' ]);
    Route::get('/obtenerDetalleComponente/{paciente_id}', [ Odontograma_ComponentdetalleController::class, 'obtenerDetalleComponente']);
   
    
    
    
});


Route::group(['prefix' => 'odontoantecedente', 'middleware' => ['jwt.verify']], function(){
  

    Route::post('/guardar', [OdontoPerAntecedenteController::class, 'guardar']);
    Route::get('/obtener-antecedentes/{paciente_id}', [OdontoPerAntecedenteController::class, 'obtenerAntecedentes']);
    Route::get('/obtener-antecedentesFam/{paciente_id}', [OdontoPerAntecedenteController::class, 'obtenerAntecedentesFam']);
    Route::get('/obtener-antecedentesEsto/{paciente_id}', [OdontoPerAntecedenteController::class, 'obtenerAntecedentesEsto']);
 

    Route::post('/guardarAFamiliares', [OdontoPerAntecedenteController::class, 'guardarAFamiliares']);
    Route::post('/guardarAesto', [OdontoPerAntecedenteController::class, 'guardarAestomatognatico']);

    
    
});


Route::group(['prefix' => 'higiene', 'middleware' => ['jwt.verify']], function(){
  

    Route::post('/guardarpieza', [Higiene_Controller::class, 'guardarPiezasHigiente']);
    Route::get('/obtener-piezahigiente/{paciente_id}', [Higiene_Controller::class, 'obtenerPiezasPct']);

    Route::post('/guardarenfp', [Higiene_Controller::class, 'guardarEnfermedadPeriodontal']);
    Route::get('/obtener-enfermerdadperiodontal/{paciente_id}', [Higiene_Controller::class, 'obtenerEnfermedadPeriodontal']);

    Route::post('/guardarAngle', [Higiene_Controller::class, 'guardarAngle']);
    Route::get('/obtenerAngle/{paciente_id}', [Higiene_Controller::class, 'obtenerAngle']);

    Route::post('/guardarFluor', [Higiene_Controller::class, 'guardarFluor']);
    Route::get('/obtenerFluor/{paciente_id}', [Higiene_Controller::class, 'obtenerFluor']);
    
});












Route::group(['prefix' => 'ventas', 'middleware' => ['jwt.verify']], function(){
 
 
 
    Route::get('/graficaventasmensual', [ VentasController::class, 'graficaventasmensual' ]);
    Route::post('/guardarventas', [ VentasController::class, 'guardar_ventas' ]);
    Route::get('/datatableventa', [ VentasController::class, 'datatableventa' ]);
    Route::get('/listarventasxid/{id}', [ VentasController::class, 'listarventasxid']);
    Route::get('/totales', [ VentasController::class, 'ventasxmes']);

 

    
});
