<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Receta Médica</title>
    <style>
    @page {
        size: A4 landscape;
        margin: 20px;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin: 0;
        padding: 0;
        line-height: 1.2;
    }

    .encabezado {
        width: 100%;
        text-align: center;
        margin-bottom: 5px;
    }

    .logo-esquina {
        width: 150px;
    }

    .logo-central {
        height: 100px;
        margin-bottom: 5px;
    }

    .empresa-info h2 {
        margin: 0;
        font-size: 18px;
    }

    .empresa-info h4 {
        margin: 0;
        font-size: 11px;
    }

    .tabla-encabezado {
        width: 100%;
    }

    .tabla-encabezado td {
        vertical-align: top;
    }

    .datos-paciente {
        font-size: 11px;
        margin-bottom: 10px;
    }

    .contenido {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        page-break-inside: avoid;
    }

    .contenido td {
        vertical-align: top;
        padding: 0 10px;
    }

    .prescripcion {
        width: 49%;
    }

    .linea-divisoria {
        width: 2%;
        border-left: 1px solid black;
        padding: 0;
        margin: 0;
    }

    .indicaciones {
        width: 49%;
    }

    table.sin-bordes {
        width: 100%;
        border-collapse: collapse;
    }

    table.sin-bordes th,
    table.sin-bordes td {
        border: none;
        font-size: 11px;
        padding: 3px 5px;
    }

    h4 {
        margin-top: 5px;
        margin-bottom: 5px;
    }

    ul {
        margin-top: 0;
        margin-bottom: 0;
        padding-left: 15px;
        line-height: 1.1;
    }

    li {
        margin-bottom: 3px;
    }

    .doctor {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 10px;
        page-break-before: auto;
        page-break-after: avoid;
    }

    .doctor img {
        height: 70px;
    }

    .doctor p {
        margin: 2px;
        font-size: 10px;
    }

    .footer {
        text-align: center;
        font-size: 10px;
        margin-top: 10px;
        page-break-before: auto;
        page-break-after: avoid;
    }

    table,
    tr,
    td,
    ul,
    li {
        page-break-inside: avoid;
    }

    .firma-medico {
        font-size: 12px;
        text-align: left;
    }



    .logo-superior-izquierda {
    position: absolute;
    top: -35;
    left: -55;
    padding: 0;
    margin: 0;
    z-index: 999;
}

.logo-superior-izquierda img {
    width: 200px; /* ajusta el tamaño si es necesario */
    margin: 0;
    padding: 0;
}

    </style>
</head>
@php
$logoCentro = '';
$logoMeta = '';
$sello = '';

if (file_exists(public_path('img/' . $response['empresa']['logo']))) {
$logoCentro = base64_encode(file_get_contents(public_path('img/' . $response['empresa']['logo'])));
}

if (file_exists(public_path('img/meta1.JPG'))) {
$logoMeta = base64_encode(file_get_contents(public_path('img/meta1.JPG')));
}

if (file_exists(storage_path('app/public/sellos/' . $response['citas']['doctor']['img_sello']))) {
$sello = base64_encode(file_get_contents(storage_path('app/public/sellos/' .
$response['citas']['doctor']['img_sello'])));
}

$nacimiento = new DateTime($response['citas']['paciente']['persona']['fecha_nacimiento']);
$edad = $nacimiento->diff(new DateTime());
@endphp

<body>
    <!-- LOGO EN ESQUINA SUPERIOR IZQUIERDA -->
<div class="logo-superior-izquierda">
    <img src="data:image/jpeg;base64,{{ $logoMeta }}">
</div>


    <!-- ENCABEZADO CON TABLA -->
    <table class="tabla-encabezado">
        <tr>
          <!--   <td style="width: 15%; text-align: left;">
                <img class="logo-esquina" src="data:image/jpeg;base64,{{ $logoMeta }}">
            </td> -->
            <td style="width: 500%; text-align: center;">
                <img class="logo-central" src="data:image/jpeg;base64,{{ $logoCentro }}"><br>
                <div class="empresa-info">
                    <h2>{{ $response['empresa']['nombre_empresa'] }}</h2>
                    <h4>{{ $response['empresa']['direccion_empresa'] }}</h4>
                    <h4>{{ $response['empresa']['barra2'] }}</h4>
                    <h4>{{ $response['empresa']['telefono1_empresa'] }} /
                        {{ $response['empresa']['telefono2_empresa'] }}</h4>
                </div>
            </td>
             <td style="width: 15%; text-align: right;">
               <!--  <img class="logo-esquina" src="data:image/jpeg;base64,{{ $logoMeta }}"> -->
            </td> 
        </tr>
    </table>



    <table class="contenido">
        <tr>
            <!-- Prescripción -->
            <td class="prescripcion">
                <!-- DATOS DEL PACIENTE (alineados horizontalmente) -->
                <div class="datos-paciente">
                    <table class="sin-bordes">
                        <tr>
                            <td><strong>Paciente:</strong> {{ $response['citas']['paciente']['persona']['nombre'] }}
                                {{ $response['citas']['paciente']['persona']['apellido'] }}</td>
                            <td><strong>Fecha Cita:</strong> {{ $response['citas']['fecha'] }}</td>
                            <td><strong>Receta #:</strong> {{ $response['receta']['numero_receta'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cédula:</strong> {{ $response['citas']['paciente']['persona']['cedula'] }}</td>

                            <td><strong>Fecha Impresión:</strong> {{ now()->format('d/m/Y H:i') }}</td>
                            <td><strong>H. Clínica:</strong> {{ $response['citas']['paciente']['persona']['id'] }}</td>


                        </tr>
                        <tr>
                            <td><strong>Edad:</strong> {{ $edad->y }} años, {{ $edad->m }} meses</td>

                            <td><strong>Género:</strong> {{ $response['citas']['paciente']['persona']['sexo']['tipo'] }}
                            </td>
                            <td><strong>Especialidad:</strong>
                                {{ $response['citas']['doctor']['especialidades']['nombre_especialidad'] }}</td>


                        </tr>
                    </table>
                    <hr>
                </div>

                <!-- PRESCRIPCIÓN -->
                <h4>Prescripción</h4>
                <table class="sin-bordes">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Cant.</th>
                            <th>Vía</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($response['receta']['receta_detalle'] as $detalle)
                        @if($detalle['estado'] === 'A')
                        <tr>
                            <td>{{ $detalle['producto']['nombre_producto'] }}</td>
                            <td>{{ $detalle['cantidad'] }}</td>
                            <td>{{ $detalle['via']['tipo_via'] ?? '' }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>


                <br>
                <br>
                <br>

                <table>
                    <tr>
                        <th>DIAGNOSTICOS</th>


                    </tr>
                    <tr>
                        <td>
                            @if(isset($response['diagnosticos']) && count($response['diagnosticos']) > 0)
                            <table>


                                @foreach($response['diagnosticos'] as $diagnostico)
                                <tr>
                                    <td>{{ $diagnostico['diagnostico']['descripcion'] }}</td>
                                    <td>{{ $diagnostico['diagnostico']['clave'] }}</td>

                                </tr>
                                @endforeach
                            </table>
                            @else
                            <p>No hay diagnósticos disponibles.</p>
                            @endif







                        </td>
                    </tr>
                </table>


                <br>
                <br>
                <br>
                <br>



                <!-- DATOS Y FIRMA DEL MÉDICO -->
                <div class="firma-medico" style="margin-top: 30px;">
                    <hr style="width: 50%; margin-left: 0;">
                    <p style="margin: 5px 0 0 0;"><strong>Dr(a). {{ $response['citas']['doctor']['persona']['nombre'] }}
                            {{ $response['citas']['doctor']['persona']['apellido'] }}</strong></p>
                    <p style="margin: 0;">Especialista en
                        {{ $response['citas']['doctor']['especialidades']['nombre_especialidad'] }}</p>
                    <p style="margin: 0;">Senescyt: {{ $response['citas']['doctor']['reg_senescyt'] }} | C.I:
                        {{ $response['citas']['doctor']['persona']['cedula'] }}</p>
                </div>

                <br>
                 


                <!-- BLOQUE FINAL MODERNO CON DATOS DE EMPRESA -->
<div style="width: 100%; margin-top: 15px;   background: linear-gradient(to right, #cce7f0, #e6f4f8); color:rgb(0, 0, 0); border-radius: 6px; display: flex; align-items: center; justify-content: space-between; font-family: Arial, sans-serif; font-size: 11px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); page-break-inside: avoid;">
    
    <!-- Logo -->
<!--     <div style="flex: 0 0 70px;">
        <img src="data:image/jpeg;base64,{{ $logoCentro }}" alt="Logo" style="max-height: 55px; display: block;">
    </div>
 -->
    <!-- Datos -->
    <div  >
        <p style="margin: 2px 0; font-weight: bold; font-size: 12px;">{{ $response['empresa']['nombre_empresa'] }}</p>
        <p style="margin: 2px 0;">Direccion:  {{ $response['empresa']['direccion_empresa'] }}</p>
        <p style="margin: 2px 0;">Telefonos: {{ $response['empresa']['telefono1_empresa'] }} / {{ $response['empresa']['telefono2_empresa'] }}</p>
        <p style="margin: 2px 0;">Correo: {{ $response['empresa']['correo'] ?? 'info@empresa.com' }}</p>
        @if(!empty($response['empresa']['barra2']))
            <p style="margin: 2px 0;"> {{ $response['empresa']['barra2'] }}</p>
        @endif
    </div>
</div>







  

            </td>

            <!-- Línea divisoria -->
            <td class="linea-divisoria"></td>

            <!-- Indicaciones -->
            <td class="indicaciones">
                <!-- DATOS DEL PACIENTE (también en el lado derecho, si deseas) -->
                <div class="datos-paciente">
                    <table class="sin-bordes">
                        <tr>
                            <td><strong>Paciente:</strong> {{ $response['citas']['paciente']['persona']['nombre'] }}
                                {{ $response['citas']['paciente']['persona']['apellido'] }}</td>
                            <td><strong>Fecha Cita:</strong> {{ $response['citas']['fecha'] }}</td>
                            <td><strong>Receta #:</strong> {{ $response['receta']['numero_receta'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cédula:</strong> {{ $response['citas']['paciente']['persona']['cedula'] }}</td>

                            <td><strong>Fecha Impresión:</strong> {{ now()->format('d/m/Y H:i') }}</td>
                            <td><strong>H. Clínica:</strong> {{ $response['citas']['paciente']['persona']['id'] }}</td>


                        </tr>
                        <tr>
                            <td><strong>Edad:</strong> {{ $edad->y }} años, {{ $edad->m }} meses</td>

                            <td><strong>Género:</strong> {{ $response['citas']['paciente']['persona']['sexo']['tipo'] }}
                            </td>
                            <td><strong>Especialidad:</strong>
                                {{ $response['citas']['doctor']['especialidades']['nombre_especialidad'] }}</td>


                        </tr>
                    </table>
                    <hr>
                </div>

                <!-- INDICACIONES -->
                <h4>Indicaciones</h4>
                <ul>
                    @foreach($response['receta']['receta_detalle'] as $detalle)
                    @if($detalle['estado'] === 'A')
                    <li>
                        <strong>{{ $detalle['producto']['nombre_producto'] }}</strong><br>
                        @if(!empty($detalle['duracion'])) Duración: {{ $detalle['duracion'] }}<br>@endif
                        @if(!empty($detalle['observacion'])) Observación: {{ $detalle['observacion'] }} <br> @endif
                        @if(!empty($detalle['frecuencia'])) Frecuencia: {{ $detalle['frecuencia']['tipo_frecuencia'] }}@endif
                    </li>
                    @endif
                    @endforeach
                </ul>
                <br>
                <br>
                <br>
                
                
    
                <!-- DATOS Y FIRMA DEL MÉDICO -->

                <div class="firma-medico" style="margin-top: 30px;">
                    <hr style="width: 50%; margin-left: 0;">
                    <p style="margin: 5px 0 0 0;"><strong>Dr(a). {{ $response['citas']['doctor']['persona']['nombre'] }}
                            {{ $response['citas']['doctor']['persona']['apellido'] }}</strong></p>
                    <p style="margin: 0;">Especialista en
                        {{ $response['citas']['doctor']['especialidades']['nombre_especialidad'] }}</p>
                    <p style="margin: 0;">Senescyt: {{ $response['citas']['doctor']['reg_senescyt'] }} | C.I:
                        {{ $response['citas']['doctor']['persona']['cedula'] }}</p>
                </div>



                <!-- BLOQUE FINAL MODERNO CON DATOS DE EMPRESA -->
<div style="width: 100%; margin-top: 15px; padding: 8px 12px; background: linear-gradient(to right, #cce7f0, #e6f4f8); color: #003f5c; border-radius: 6px; display: flex; align-items: center; justify-content: space-between; font-family: Arial, sans-serif; font-size: 11px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); page-break-inside: avoid;">
    
    <!-- Logo -->
<!--     <div style="flex: 0 0 70px;">
        <img src="data:image/jpeg;base64,{{ $logoCentro }}" alt="Logo" style="max-height: 55px; display: block;">
    </div>
 -->
    <!-- Datos -->
<!--     <div style="flex: 1; padding-left: 15px;">
        <p style="margin: 2px 0; font-weight: bold; font-size: 12px;">{{ $response['empresa']['nombre_empresa'] }}</p>
        <p style="margin: 2px 0;">Direccion:  {{ $response['empresa']['direccion_empresa'] }}</p>
        <p style="margin: 2px 0;">Telefonos: {{ $response['empresa']['telefono1_empresa'] }} / {{ $response['empresa']['telefono2_empresa'] }}</p>
        <p style="margin: 2px 0;">Correo: {{ $response['empresa']['correo'] ?? 'info@empresa.com' }}</p>
        @if(!empty($response['empresa']['barra2']))
            <p style="margin: 2px 0;"> {{ $response['empresa']['barra2'] }}</p>
        @endif
    </div>
</div>


 -->




            </td>
            
        </tr>
        
    </table>
    
<!-- BLOQUE FINAL MODERNO CON DATOS DE EMPRESA -->
<!-- <div style="width: 100%; margin-top: 15px; padding: 8px 12px; background: linear-gradient(to right, #cce7f0, #e6f4f8); color: #003f5c; border-radius: 6px; display: flex; align-items: center; justify-content: space-between; font-family: Arial, sans-serif; font-size: 11px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); page-break-inside: avoid;">
    
    
    <div style="flex: 0 0 70px;">
        <img src="data:image/jpeg;base64,{{ $logoCentro }}" alt="Logo" style="max-height: 55px; display: block;">
    </div>

  
    <div style="flex: 1; padding-left: 15px;">
        <p style="margin: 2px 0; font-weight: bold; font-size: 12px;">{{ $response['empresa']['nombre_empresa'] }}</p>
        <p style="margin: 2px 0;">Direccion:  {{ $response['empresa']['direccion_empresa'] }}</p>
        <p style="margin: 2px 0;">Telefonos: {{ $response['empresa']['telefono1_empresa'] }} / {{ $response['empresa']['telefono2_empresa'] }}</p>
        <p style="margin: 2px 0;">Correo: {{ $response['empresa']['correo'] ?? 'info@empresa.com' }}</p>
        @if(!empty($response['empresa']['barra2']))
            <p style="margin: 2px 0;"> {{ $response['empresa']['barra2'] }}</p>
        @endif
    </div>
</div> -->


</body>

</html>