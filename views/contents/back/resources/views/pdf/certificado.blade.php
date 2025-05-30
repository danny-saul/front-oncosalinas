<!-- resources/views/pdf/documento.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CERTIFICADO MEDICO</title>
    <style>
    body {

        font-family: 'Times New Roman', Times, serif;
        margin: 0;

        /* Eliminar el margen */
    }

    h1 {
        color: blue;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: center;
        margin-bottom: 2px;
        width: 100%;
        box-sizing: border-box;
    }

    .logo-left,
    .logo-right {
        width: 20%;
        text-align: center;
    }

    .empresa-info {
        width: 60%;
        text-align: center;
    }

    .header img {
        width: 100px;
        /* Ajustado para que quepan ambos */
        height: auto;
        margin: 0;
        /* Elimina márgenes que empujan */
    }

    table {
        width: 100%;
        /* Ocupar todo el ancho disponible */
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    th,
    td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 5px;
        font-size: 11px;
        /* Tamaño de letra reducido */
    }

    th {
        background-color: #f2f2f2;
    }

    .td1 {
        font-size: 5px;

    }

    .firma {
        margin-top: 5px;
        text-align: center;

    }

    h4 {
        margin-bottom: 5px;
        /* Ajusta este valor según sea necesario */
    }

    p {
        margin-top: 5px;
        /* Ajusta este valor según sea necesario */
        margin-bottom: 5px;
        /* Ajusta este valor según sea necesario */
        font-size: 12px;
    }
    </style>
</head>

<body>
    <?php
$imagen_base64 = ''; // Definir variable por defecto

$imagen_path = public_path('img/' . $response['empresa']['logo']);
if (file_exists($imagen_path)) {
    $imagen_base64 = base64_encode(file_get_contents($imagen_path));
}
?>

    <?php
$imagen_base642 = ''; // Definir variable por defecto

$imagen_path2 = public_path('img/meta2.JPG');
if (file_exists($imagen_path2)) {
    $imagen_base642 = base64_encode(file_get_contents($imagen_path2));
}
?>


<table width="100%" style="border-collapse: collapse; border: none;">
    <tr>
        <td align="left" width="20%" style="border: none;">
            <?php if (!empty($imagen_base64)): ?>
                <img src="data:image/jpeg;base64,<?= $imagen_base64 ?>" width="150" style="margin-top: -40px; margin-left: -30px" >
            <?php else: ?>
                ¡Logo no encontrado!
            <?php endif; ?>
        </td>
        <td align="center" width="60%" style="border: none; text-align: center;">
            <div style="text-align: center;">
                <h2 style="margin: 0; font-size: 16px;">{{ $response['empresa']['nombre_empresa'] }}</h2>
                <h2 style="margin: 0; font-size: 5px;">{{ $response['empresa']['direccion_empresa'] }}</h2>
                <h2 style="margin: 0; font-size: 9px;">{{ $response['empresa']['barra2'] }}</h2>
                <h2 style="margin: 0; font-size: 9px;">
                    {{ $response['empresa']['telefono1_empresa'] }} {{ $response['empresa']['telefono2_empresa'] }}
                </h2>
            </div>
        </td>
        <td align="right" width="19%" style="border: none;">
            <?php if (!empty($imagen_base642)): ?>
                <img src="data:image/jpeg;base64,<?= $imagen_base642 ?>" width="130" style="margin-top: -20px; margin-right: -50px">
            <?php endif; ?>
        </td>
    </tr>
</table>





    
    <br>



    <div class="" style="line-height: 0.7;  float:left; font-family: 'Times New Roman', Times, serif;">
        @if(isset($response['certificado']) && !empty($response['certificado']))
        @foreach($response['certificado'] as $cert)
        <p> Salinas, {{$cert['fecha']}}</p>
        <p> Documento #, {{$cert['id']}}-{{$cert['fecha']}}</p>
        @endforeach
        @else
        <p>No se encontraron certificados</p>
        @endif

    </div>

    <br>
    <br>
    <br>
    <br>



    <div class="header" style="margin-top: -35px;">
        <h2 style="font-family: 'Times New Roman', Times, serif;">CERTIFICADO MÉDICO</h2>
        @if(isset($response['certificado']) && !empty($response['certificado']))

        @endif

    </div>
    <br>
    <br>

    @if(isset($response['certificado']) && !empty($response['certificado']))
    @foreach($response['certificado'] as $cert)
    <div class="contenido" style="line-height: 1.3; font-family: 'Times New Roman', Times, serif;">
        <p>Certifico que el o la paciente, {{ strtoupper($cert['citas']['paciente']['persona']['nombre']) }}
            {{ strtoupper($cert['citas']['paciente']['persona']['apellido']) }} con cedula de ciudadania No
            {{ strtoupper($cert['citas']['paciente']['persona']['cedula']) }},
            con historia clinica # {{ strtoupper($cert['citas']['paciente']['persona']['id']) }}, con direccion
            domiciliaria
            {{ strtoupper($cert['citas']['paciente']['persona']['direccion']) }} y con numero telefonico
            {{ strtoupper($cert['citas']['paciente']['persona']['celular']) }},
            fue atendido el dia {{ strtoupper($cert['citas']['fecha']) }}, a las
            {{ strtoupper($cert['citas']['doctor_horario']['hora_inicio']) }} en la unidad medica,
            {{ strtoupper($response['empresa']['nombre_empresa']) }}
            {{ strtoupper($response['empresa']['direccion_empresa']) }}.

            <br>
            <br>

        <h4>DIAGNÓSTICO:</h4>
        @foreach($response['citas'] as $cita)
        @foreach($cita['recetas_diagnosticos'] as $recetaDiagnostico)
        <p>{{ strtoupper($recetaDiagnostico['diagnostico_cie10']['descripcion']) }} CIE10
            {{ strtoupper($recetaDiagnostico['diagnostico_cie10']['clave']) }}</p>
        @endforeach
        @endforeach


        <h4>TIPO DE CONTINGENCIA:</h4>
        <p> {{ strtoupper($cert['tipo_contingencia']['contingencia']) }}</p>
        <h4>ACTIVIDAD LABORAL:</h4>
        <p> {{ strtoupper($cert['actividad_laboral']) }}</p>
        <p>EMPRESA: {{ strtoupper($cert['entidad_laboral']) }}</p>
        <h4>AISLAMIENTO:</h4>
        <p> {{ strtoupper($cert['aislamiento']['tipo_aislamiento']) }}</p>
        <p>Se recomienda reposo por {{ strtoupper($cert['dia_descanso']) }} días, a partir de la fecha de atención.</p>
        <!--   <p>Desde: 26 (veintiséis) / Octubre / 2023 Hasta: 04 (cuatro) / Noviembre / 2023</p> -->
    </div>

    @endforeach
    @else
    <p>No se encontraron certificados</p>
    @endif

    <br>
    <br>
    <br>


    <div class="firma" style="line-height: 0.9; font-family: 'Times New Roman', Times, serif;">
        <p>Atentamente</p>
        <p>  
            <br><br><br>
            <br><br><br>
        </p>
        <p>________________________________________</p>

        <p>Dr. {{ ($cert['citas']['doctor']['persona']['nombre'] ) }}
            {{ ($cert['citas']['doctor']['persona']['apellido'] ) }} </p>
        <p>Especialista en {{ ($cert['citas']['doctor']['especialidades']['nombre_especialidad'] ) }} <br> <br>
            {{ $response['empresa']['nombre_empresa' ]}}</p>
        <p>Registro Senescyt: {{ ($cert['citas']['doctor']['reg_senescyt'] ) }} - Cédula:
            {{ ($cert['citas']['doctor']['persona']['cedula'] ) }}</p>
        
        <p></p>
        @foreach ($cert['citas']['doctor']['persona']['usuario'] as $usuario)
        <p>Email: {{ $usuario->correo }}</p>

        @endforeach
    </div>







</body>

</html>






<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Médico</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        /* Tamaño de letra */
    }

    .container {
        width: 100%;
        max-width: 800px;
        /* Tamaño máximo para ajustarse a una hoja A4 */
        margin: auto;
        padding: 20px;
        box-sizing: border-box;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .numero-oficio {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .contenido {
        margin-bottom: 15px;
        text-align: justify;
        /* Justificar el texto */
        line-height: 1.5;
        /* Interlineado */
        text-justify: inter-word;
        /* Justificar palabras */
    }
    </style>
</head>

<!-- <body>
    <div class="container">
        <div class="header">
            <h2>CERTIFICADO MÉDICO</h2>
            <p class="numero-oficio">Oficio # 1063676-26-10-2023</p>
        </div>
        <div class="contenido">
            <p>Certifico que el o la paciente, ZAMBRANO ESPINOZA JOSE SANTOS con cédula de ciudadanía No 0701656654,
                <br>
                con historia clínica 17929, con dirección domiciliaria SALINAS y con número telefónico 0993667935, <br>
                fue atendido el día 26-Octubre-2023, en la unidad médica, SERVIDENT S.A. (Salinas) - ubicada en RANCHO
                ALEGRE <br> diagonal a
                ESPOLTEL SALINAS, acreditada como prestadora externa del IESS. <br>
                Según contrato 21300900-SPSIFG-019-2012 - Santa Elena
            </p>
            <h4>DIAGNÓSTICO:</h4>
            <p>TUMOR MALIGNO DE LA GLÁNDULA TIROIDES CIE10 C73</p>
            <p>CONVALECENCIA CONSECUTIVA A TRATAMIENTO NO ESPECIFICADO CIE10 Z549</p>
            <h4>TIPO DE CONTINGENCIA:</h4>
            <p>ENFERMEDAD CATASTRÓFICA</p>
            <h4>ACTIVIDAD LABORAL:</h4>
            <p>JARDINERÍA</p>
            <p>EMPRESA: MUNICIPIO GAD</p>
            <h4>AISLAMIENTO:</h4>
            <p>Ninguno</p>
            <p>Se recomienda reposo por 10 (diez) días, a partir de la fecha de atención.</p>
            <p>Desde: 26 (veintiséis) / Octubre / 2023 Hasta: 04 (cuatro) / Noviembre / 2023</p>
        </div>
        <div class="firma">
            <p>Atentamente</p>
            <p>ORLANDO FERNÁNDEZ ALVARADO</p>
            <p>Oncología - SERVIDENT S.A. (Salinas)</p>
            <p>Cédula: 0963138524</p>
            <p>Registro MSP:</p>
            <p>Registro Senescyt: 86221130095</p>
            <p>Email: rafaelfer12121@gmail.com</p>
        </div>
    </div>
</body> -->

</html>