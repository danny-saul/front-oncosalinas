<!-- resources/views/pdf/documento.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HISTORIA CLINICA ODONTOLOGICA</title>
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
        text-align: center;
        margin-bottom: 2px;
    }

    .header img {
        width: 150px;
        /*     margin-bottom: 15px; */
        height: 120px;
        margin-top: -25px;
    }

    .tabletitle {
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


    .encabezado-informe th:nth-child(1) {
        width: 30%;
    }

    .encabezado-informe th:nth-child(2) {
        width: 20%;
    }

    .encabezado-informe th:nth-child(3) {
        width: 20%;
    }

    .encabezado-informe th:nth-child(4) {
        width: 20%;
    }

    .encabezado-informe th:nth-child(5) {
        width: 10%;
    }




    /**tabla de higiene */

    /*     .mi-contenedor-tablas {
        width: 100%;
        padding: 10px;
    }

    .mi-fila-tablas {
        display: flex;
        gap: 20px;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .mi-columna-tabla {
        flex: 1;
        min-width: 300px;
    }

    .mi-tabla-enfermedades {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        border: 1px solid #ccc;
    }

    .mi-tabla-enfermedades th,
    .mi-tabla-enfermedades td {
        padding: 5px;
        border: 1px solid #ccc;
        text-align: left;
    }

    .mi-tabla-enfermedades th.mi-header {
        text-align: center;
        background-color: #f0f0f0;
    } */
    </style>
</head>

<body>


    <div class="header">




        <div style="float: right;">
            <h2 style="margin: 0; font-size: 16px; font-family: 'Times New Roman', Times, serif;">
                {{ $response['empresa']['nombre_empresa' ]}}</h2>
            <h2 style="margin: 0; font-size: 5px;">{{ $response['empresa']['direccion_empresa' ]}}</h2>
            <h2 style="margin: 0; font-size: 9px;">{{ $response['empresa']['barra2' ]}}</h2>
            <h2 style="margin: 0; font-size: 9px;">{{ $response['empresa']['telefono1_empresa' ]}}
                {{ $response['empresa']['telefono2_empresa' ]}} </h2>
        </div>


    </div>


    <br>
    <br>
    <br>


    <!-- Tabla con los datos del paciente -->
    <table class="tabletitle">
        <tr>
            <th>A.- DATOS DEL ESTABLECIMIENTO Y USUARIO / PACIENTE</th>
        </tr>

        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>
    <table class="tabletitle">
        <tr>
            <th>INSTITUCION DEL SISTEMA</th>
            <th>UNICODIGO</th>
            <th>ESTABLECIMIENTO DE SALUD</th>
            <th>N HISTORIA CLINICA</th>
            <th>NUMERO DE ARCHIVO</th>
            <th>N. DE HOJA</th>

        </tr>
        <tr>
            <td>{{ $response['empresa']['nombre_empresa' ]}}</td>
            <td>0001</td>
            <td>{{ $response['empresa']['nombre_empresa' ]}}</td>
            @foreach($response['paciente']['citas'] as $datos)

            <td>{{ $datos['paciente']['persona']['id'] }}</td>



            @endforeach
            <td></td>

        </tr>
    </table>

    <table class="tabletitle">
        <tr>
            <th>APELLIDOS</th>
            <th>NOMBRES</th>
            <th>SEXO</th>
            <th>EDAD</th>
            <th>CONDICION DE EDAD

            </th>
        </tr>



        <tr>
            <td>{{ $response['persona']['apellido'] }}</td>
            <td>{{ $response['persona']['nombre'] }}</td>
            <td>{{ $response['persona']['sexo']['tipo'] }}</td>

            <td>
                <?php
                // Fecha de nacimiento del paciente
                $fecha_nacimiento = $response['persona']['fecha_nacimiento'];

                // Convertir la fecha de nacimiento a un objeto DateTime
                $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);

                // Fecha actual
                $fecha_actual = new DateTime();

                // Calcular la diferencia entre la fecha actual y la fecha de nacimiento
                $diferencia = $fecha_actual->diff($fecha_nacimiento_dt);

                // Obtener el número de años, meses y días
                $anios = $diferencia->y;
                $meses = $diferencia->m;
                $dias = $diferencia->d;

                // Imprimir la edad en años, meses y días
                echo   $anios ;
                ?>
            </td>

            <td>X</td>

        </tr>


    </table>


    <table class="tabletitle">
        <tr>
            <th>B.- MOTIVO DE CONSULTA</th>
            <th>EMBARAZADA</th>
            <th>SI
            <td>-</td>
            </th>
            <th>NO
            <td> - </td>
            </th>
        </tr>


        <tr>
            <td>PACIENTE ASINTOMATICO </td>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>


        </tr>
    </table>



    <table class="tabletitle">
        <tr>
            <th>C.- ENFERMEDAD O PROBLEMA ACTUAL</th>

        </tr>


        <tr>

            <td>PACIENTE ASINTOMATICO </td>


        </tr>
    </table>




    <table class="tabletitle">
        <tr>
            <th>D.- ANTECEDENTES PATOLOGICOS PERSONALES </th>

        </tr>


    </table>


    <table border="1" class="tabletitle">
        <thead>
            <tr>
                <!-- Las cabeceras van vacías ya que se llenarán con los tipos de antecedentes y respuestas -->
                @for($i = 1; $i <= 10; $i++) @endfor </tr>
        </thead>
        <tbody>
            <tr>
                <!-- Fila para los tipos de antecedentes -->
                @foreach($response['paciente']['antecedentes_odonto_personal'] as $antecedente)
                <td>{{ $antecedente['odonto_antecedentes_per']['tipo_antecedente_per'] }}</td>
                @endforeach
                <!-- Si hay menos de 10 antecedentes, rellenamos el resto de las columnas con espacios vacíos -->
                @for($i = count($response['paciente']['antecedentes_odonto_personal']); $i < 10; $i++) <td>
                    </td>
                    @endfor
            </tr>
            <tr>
                <!-- Fila para las respuestas -->
                @foreach($response['paciente']['antecedentes_odonto_personal'] as $antecedente)
                <td>{{ $antecedente['respuesta'] }}</td>
                @endforeach
                <!-- Si hay menos de 10 antecedentes, rellenamos el resto de las columnas con espacios vacíos -->
                @for($i = count($response['paciente']['antecedentes_odonto_personal']); $i < 10; $i++) <td>
                    </td>
                    @endfor
            </tr>
        </tbody>


    </table>

    <table class="tabletitle">
        <tr>
            <th>E.- ANTECEDENTES PATOLOGICOS FAMILIARES</th>

        </tr>


    </table>


    <table border="1" class="tabletitle">
        <thead>
            <tr>
                <!-- Las cabeceras van vacías ya que se llenarán con los tipos de antecedentes y respuestas -->
                @for($j = 1; $j <= 10; $j++) @endfor </tr>
        </thead>
        <tbody>
            <tr>
                <!-- Fila para los tipos de antecedentes -->
                @foreach($response['paciente']['antecedentes_odonto_familiar'] as $antecedente)
                <td>{{ $antecedente['odonto_antecedentes_fam']['tipo_antecedente_fam'] }}</td>
                @endforeach
                <!-- Si hay menos de 10 antecedentes, rellenamos el resto de las columnas con espacios vacíos -->
                @for($j = count($response['paciente']['antecedentes_odonto_familiar']); $j < 10; $j++) <td>
                    </td>
                    @endfor
            </tr>
            <tr>
                <!-- Fila para las respuestas -->
                @foreach($response['paciente']['antecedentes_odonto_familiar'] as $antecedente)
                <td>{{ $antecedente['respuesta'] }}</td>
                @endforeach
                <!-- Si hay menos de 10 antecedentes, rellenamos el resto de las columnas con espacios vacíos -->
                @for($j = count($response['paciente']['antecedentes_odonto_familiar']); $j < 10; $j++) <td>
                    </td>
                    @endfor
            </tr>
        </tbody>


    </table>


    <table class="tabletitle">
        <tr>
            <th>F.- CONSTANTES VITALES </th>

        </tr>


    </table>

    <table class="tabletitle">

        @foreach($response['paciente']['citas'] as $datos)
        @foreach($datos['examen_fisica'] as $exf)
        <tr>
            <td>TEMPERATURA °C
            <td>{{ $exf['temperatura'] }}</td>
            </td>
            <td>PULSO / min.
            <td>{{ $exf['pulso'] }}</td>
            </td>
            <td>FRECUENCIA RESPIRATORIA / min.
            <td>{{ $exf['frecuencia_respiratoria'] }}</td>
            </td>
            <td>PRESIÓN ARTERIAL (mmHg)
            <td> {{ $exf['presion_arterial'] }}</td>
            </td>
        </tr>





        @endforeach
        @endforeach



    </table>


    <table class="tabletitle">
        <tr>
            <th>G.- EXAMEN DEL SISTEMA ESTOMATOGNÁTICO </th>

        </tr>


    </table>


    @php
    // Convertimos la colección en un array para evitar errores con array_slice()
    $antecedentes = $response['paciente']['antecedentes_estomatognatico_paciente']->toArray();

    // Dividimos los antecedentes en dos grupos de 7
    $fila1 = array_slice($antecedentes, 0, 7);
    $fila2 = array_slice($antecedentes, 7, 7);
    @endphp
    @php
    // Convertimos la colección en un array si es una colección de Laravel
    $antecedentes = $response['paciente']['antecedentes_estomatognatico_paciente']->toArray();

    // Dividimos los antecedentes en dos grupos de 7
    $fila1 = array_slice($antecedentes, 0, 7);
    $fila2 = array_slice($antecedentes, 7, 7);
    @endphp

    <table border="1" class="tabletitle">
        <tbody>
            <!-- Fila 1 -->
            <tr>
                @foreach($fila1 as $antecedente)
                <td><strong>{{ $antecedente['odonto_estomatognatico']['tipo_estomato'] }}</strong></td>
                <td>{{ $antecedente['respuesta'] }}</td>
                @endforeach
                @for($k = count($fila1); $k < 7; $k++) <td>
                    </td>
                    <td></td> <!-- Relleno si hay menos de 7 antecedentes -->
                    @endfor
            </tr>

            <!-- Fila 2 -->
            <tr>
                @foreach($fila2 as $antecedente)
                <td><strong>{{ $antecedente['odonto_estomatognatico']['tipo_estomato'] }}</strong></td>
                <td>{{ $antecedente['respuesta'] }}</td>
                @endforeach
                @for($k = count($fila2); $k < 7; $k++) <td>
                    </td>
                    <td></td> <!-- Relleno si hay menos de 7 antecedentes -->
                    @endfor
            </tr>
        </tbody>
    </table>




    <table class="tabletitle">
        <tr>
            <th>H.- ODONTOGRAMA</th>

        </tr>


    </table>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>



    <table class="tabletitle">
        <tr>
            <th>I.- INDICADORES DE SALUD BUCAL</th>

        </tr>


    </table>



    @php
    // Piezas que deben mostrarse en la tabla
    $piezasTotales = [
    ['16', '17', '55'],
    ['11', '21', '51'],
    ['26', '27', '65'],
    ['36', '37', '75'],
    ['31', '41', '71'],
    ['46', '47', '81'],
    ];

    // Extraemos las piezas respondidas del JSON
    $piezasRespondidas = [];
    foreach ($response['paciente']['piezas_paciente_higiene'] as $pieza) {
    $numero = $pieza['piezas_higiene']['num_pieza'];
    $respuesta = $pieza['respuesta'];
    $piezasRespondidas[$numero] = $respuesta;
    }
    @endphp

    <table>

        <tr>
            <td>HIGIENE ORAL SIMPLIFICADA</td>
            <td>PLAC</td>
            <td>CALC</td>
            <td>GING</td>
            <td>ENF. PERIODONTAL</td>
            <td>TIPOS DE OCLUSION</td>
            <td>NIVEL DE FLUOROSIDAD</td>

        </tr>
        <tr>
            <td>
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <th colspan="6" class="text-center">PIEZAS EXAMINADAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($piezasTotales as $fila)
                            <tr>
                                @foreach ($fila as $pieza)
                                <td>{{ $pieza }}</td>
                                <td class="text-center">
                                    @if (isset($piezasRespondidas[$pieza]) && $piezasRespondidas[$pieza] === 'Sí')
                                    X
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </td>
            <td>
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <th colspan="6" class="text-center">0-3</th>
                            </tr>
                        </thead>

                    </table>
                </div>

            </td>


            <td>
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <th colspan="6" class="text-center">0-3</th>
                            </tr>
                        </thead>

                    </table>
                </div>


            </td>

            <td>
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <th colspan="6" class="text-center">0-1</th>
                            </tr>
                        </thead>

                    </table>
                </div>


            </td>

            <td>

                <div class="mi-columna-tabla">
                    <table class="mi-tabla-enfermedades">
                        <thead>
                            <tr>
                                <th colspan="2" class="mi-header">ENF. DENTALES</th>
                            </tr>
                            <tr>
                                <th>Tipo de Enfermedad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($response['paciente']['enfermedad_periodontal'] as $enfermedad)
                            <tr>
                                <td>Leve</td>
                                <td class="text-center">@if ($enfermedad['enfermedad_dientes']['tipo'] === 'Leve' &&
                                    $enfermedad['respuesta'] === 'Sí') X @endif</td>
                            </tr>
                            <tr>
                                <td>Moderada</td>
                                <td class="text-center">@if ($enfermedad['enfermedad_dientes']['tipo'] === 'Moderada' &&
                                    $enfermedad['respuesta'] === 'Sí') X @endif</td>
                            </tr>
                            <tr>
                                <td>Severa</td>
                                <td class="text-center">@if ($enfermedad['enfermedad_dientes']['tipo'] === 'Severa' &&
                                    $enfermedad['respuesta'] === 'Sí') X @endif</td>
                            </tr>
                            <tr>
                                <td>Ninguna</td>
                                <td class="text-center">@if ($enfermedad['enfermedad_dientes']['tipo'] === 'Ninguna' &&
                                    $enfermedad['respuesta'] === 'Sí') X @endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </td>


            <td>
                <div class="mi-columna-tabla">
                    <table class="mi-tabla-enfermedades">
                        <thead>
                            <tr>
                                <th colspan="2" class="mi-header">MAL OCLUSIÓN</th>
                            </tr>
                            <tr>
                                <th>Tipo de Enfermedad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($response['paciente']['paciente_angle'] as $ang)
                            <tr>
                                <td>Angle I</td>
                                <td class="text-center">@if ($ang['angle']['tipo'] === 'Angle I' && $ang['respuesta']
                                    ===
                                    'Sí') X @endif</td>
                            </tr>
                            <tr>
                                <td>Angle II</td>
                                <td class="text-center">@if ($ang['angle']['tipo'] === 'Angle II' && $ang['respuesta']
                                    ===
                                    'Sí') X @endif</td>
                            </tr>
                            <tr>
                                <td>Angle III</td>
                                <td class="text-center">@if ($ang['angle']['tipo'] === 'Angle III' && $ang['respuesta']
                                    ===
                                    'Sí') X @endif</td>
                            </tr>
                            <tr>
                                <td>Ninguna</td>
                                <td class="text-center">@if ($ang['angle']['tipo'] === 'Ninguna' && $ang['respuesta']
                                    ===
                                    'Sí') X @endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </td>


            <td>
                <!-- FLUOROSIS -->
                <div class="mi-columna-tabla">
                    <table class="mi-tabla-enfermedades">
                        <thead>
                            <tr>
                                <th colspan="2" class="mi-header">FLUOROSIS</th>
                            </tr>
                            <tr>
                                <th>Tipo de Enfermedad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($response['paciente']['paciente_fluorosis'] as $flu)
                            <tr>
                                <td>Leve</td>
                                <td class="text-center">@if ($flu['enfermedad_dientes']['tipo'] === 'Leve' &&
                                    $flu['respuesta'] === 'Sí') X @endif</td>
                            </tr>
                            <tr>
                                <td>Moderada</td>
                                <td class="text-center">@if ($flu['enfermedad_dientes']['tipo'] === 'Moderada' &&
                                    $flu['respuesta'] === 'Sí') X @endif</td>
                            </tr>
                            <tr>
                                <td>Severa</td>
                                <td class="text-center">@if ($flu['enfermedad_dientes']['tipo'] === 'Severa' &&
                                    $flu['respuesta'] === 'Sí') X @endif</td>
                            </tr>
                            <tr>
                                <td>Ninguna</td>
                                <td class="text-center">@if ($flu['enfermedad_dientes']['tipo'] === 'Ninguna' &&
                                    $flu['respuesta'] === 'Sí') X @endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </td>


        </tr>

        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>





    <table>

        <tr>
            <th>J.- INDICADORES CPO - ceo</th>
            <th>K.- SIMBOLOGIA ODONTOGRAMA</th>


        </tr>
        <tr>
            <td>
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">D</th>
                            </tr>
                            <tr>
                                <th>C</th>
                                <th>P</th>
                                <th>O</th>
                                <th>TOTAL</th>
                                <th>&nbsp;</th> <!-- Espacio en blanco para dentición primaria -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$response['cantidad_piezas_tratadas']}}</td> <!-- C -->
                                <td>{{$response['cantidad_compo']}}</td> <!-- P -->
                                <td>0</td> <!-- O -->
                                <td>{{$response['total']}}</td> <!-- TOTAL -->
                                <td></td>
                            </tr>
                        </tbody>


                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">d</th>
                            </tr>
                            <tr>
                                <th>c</th>
                                <th>e</th>
                                <th>o</th>
                                <th>TOTAL</th>
                                <th>&nbsp;</th> <!-- Espacio en blanco para dentición primaria -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$response['piezasninos']}}</td> <!-- C -->
                                <td>{{$response['cantidad_compoN']}}</td> <!-- P -->
                                <td>0</td> <!-- O -->
                                <td>{{$response['totaln']}}</td> <!-- TOTAL -->
                                <td></td>

                            </tr>
                        </tbody>


                    </table>
                </div>
            </td>




            <td>

                <div class="col-md-8">

                    <?php
                // Ruta de la imagen
              //  $imagen_path = public_path('/storage/sellos/' . $response['citas']['doctor']['img_sello']);
              $imagen_path = storage_path('app/public/fotos/simodo.JPG');

                // Verificar si la imagen existe
                if (file_exists($imagen_path)) {
                    // Obtener el contenido de la imagen en base64
                    $imagen_base64 = base64_encode(file_get_contents($imagen_path));
                ?>

                    <img src="data:image/jpeg;base64,<?= $imagen_base64 ?>" style="width: 550px; height: 105px;">
                    <?php
                } else {
                    // Si la imagen no existe, mostrar un mensaje de error
                    echo "¡La imagen no se encontró!";
                }
                ?>
                </div>

            </td>







        </tr>

        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>


    <table class="tabletitle">
        <tr>
            <th>L.- EXAMENES COMPLEMENTARIOS</th>

        </tr>


    </table>


    <table class="tabletitle">
        <tr>
            <th>M.- INFORME DE EXAMENES</th>
            <th></th>
            <th></th>
            <th></th>


        </tr>


        <tr>

            <td>Biometria </td>
            <td>Quimica Sanguinea </td>
            <td>Rayos X </td>
            <td>Otros </td>
        </tr>


    </table>

    <table class="tabletitle">
        <tr>


            <td style="text-align: justify; line-height: 1.2; font-size: 10px;">
                @foreach($response['paciente']['odontograma'] as $odt)
                @foreach($odt['odontograma_detalle'] as $resp )
                <div> {{$resp['procedimiento_odonto']['clave_pro']}}
                    {{$resp['procedimiento_odonto']['descripcion_pro']}} Pieza: {{$resp['pieza']}}</div>

                @endforeach
                @endforeach
            </td>

        </tr>

    </table>



    <table class="tabletitle">

        <tr>
            <th>N.- DIAGNOSTICO</th>
        </tr>



    </table>





    <table class="tabletitle">
        <tr>
            <th>DIAGNOSTICO CIE</th>
            <th>CLAVE</th>
            <th>TIPO</th>
        </tr>

        @foreach($response['paciente']['odontograma_diagnostico'] as $diagnostico)
        @if($diagnostico['estado'] === 'A')
        <tr>
            <td>{{ $diagnostico['diagnostico_odonto']['descripcion_od'] }}</td>
            <td>{{ $diagnostico['diagnostico_odonto']['clave_od'] }}</td>
            <td>{{ $diagnostico['tipo_diagnostico']['tipo_diagnostico'] }}</td>
        </tr>
        @endif
        @endforeach
    </table>





    </table>

    <br>
    <br>
    <br>
    <br>
    <br>


    <table class="tabletitle">
        <tr>
            <th>O.- DATOS DEL PROFESIONAL RESPONSABLE</th>
        </tr>

        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>
    <table class="tabletitle">
        <tr>
            <th>FECHA DE APERURA</th>
            <th>HORA</th>
            <th>APELLIDOS</th>
            <th>NOMBRES</th>

        </tr>

        @foreach ($response['paciente']['odontograma'] as $odo)

        <tr>
            <td>
                <?php
            // Obtener la fecha y la hora del objeto $response['orden']['fecha']
            $fecha_hora = $odo['fecha_creacion'];

            // Convertir la cadena de fecha y hora en un objeto DateTime
            $fecha_hora_dt = new DateTime($fecha_hora);

            // Obtener la fecha y la hora por separado
            $fecha = $fecha_hora_dt->format('Y-m-d');
            $hora = $fecha_hora_dt->format('H:i:s');
            ?>

                {{ $fecha }}
            </td>
            <td>
                <?php
            // Obtener la fecha y la hora del objeto $response['orden']['fecha']
            $fecha_hora = $odo['fecha_creacion'];

            // Convertir la cadena de fecha y hora en un objeto DateTime
            $fecha_hora_dt = new DateTime($fecha_hora);

            // Obtener la fecha y la hora por separado
            $fecha = $fecha_hora_dt->format('Y-m-d');
            $hora = $fecha_hora_dt->format('H:i:s');
            ?>

                {{ $hora }}
            </td>
            <td>{{ $odo['doctor']['persona']['apellido'] }}</td>
            <td>{{ $odo['doctor']['persona']['nombre'] }}</td>
        </tr>


        @endforeach


        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>


    <table>

        <tr>
            <td>NUMERO DE DOCUMENTO DE IDENTIFIACION</td>
            <td>FIRMA</td>
            <td>SELLO</td>

        </tr>
        <tr>
            <td>{{ $odo['doctor']['persona']['cedula'] }}</td>
            <td>
                <?php
        // Ruta de la imagen
      //  $imagen_path = public_path('/storage/sellos/' . $response['orden']['doctor']['img_sello']);
        $imagen_path = storage_path('app/public/sellos/' . $odo['doctor']['img_sello']);
        // Verificar si la imagen existe
        if (file_exists($imagen_path)) {
            // Obtener el contenido de la imagen en base64
            $imagen_base64 = base64_encode(file_get_contents($imagen_path));
        ?>
                <!-- Mostrar la imagen en base64 -->
                <img src="data:image/jpeg;base64,<?= $imagen_base64 ?>" style="width: 250px; height: 65px;">
                <?php
        } else {
            // Si la imagen no existe, mostrar un mensaje de error
            echo "¡La imagen no se encontró!";
        }
        ?>
            </td>


            <td>
                <?php
        // Ruta de la imagen
    //    $imagen_path = public_path('/storage/sellos/' . $response['orden']['doctor']['img_sello']);
        $imagen_path = storage_path('app/public/sellos/' . $odo['doctor']['img_sello']);

        // Verificar si la imagen existe
        if (file_exists($imagen_path)) {
            // Obtener el contenido de la imagen en base64
            $imagen_base64 = base64_encode(file_get_contents($imagen_path));
        ?>
                <!-- Mostrar la imagen en base64 -->
                <img src="data:image/jpeg;base64,<?= $imagen_base64 ?>" style="width: 250px; height: 65px;">
                <?php
        } else {
            // Si la imagen no existe, mostrar un mensaje de error
            echo "¡La imagen no se encontró!";
        }
        ?>
            </td>


        </tr>

        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>




    <table class="tabletitle">
        <tr>
            <th>P.- TRATAMIENTO</th>
        </tr>

        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>



    <table class="tabletitle">
        <tr>
            <th>SESION Y FECHA</th>
            <th>DIAGNOSTICO Y COMPLICACIONES</th>
            <th>PROCEDIMIENTOS</th>
            <th>PRESCRIPCIÓN</th>
            <th>SELLO Y FIRMA</th>

        </tr>

        @foreach($response['detalles_por_cita'] as $citaId => $detalle)


        <tr>
            <td>
                <strong>Sesión {{ $loop->iteration }}</strong><br>
                {{ $detalle['fecha'] }}
            </td>


            <td style="text-align: justify; line-height: 1.2; font-size: 10px;">
                @foreach($detalle['diagnosticos'] as $diagnostico)
                <div>{{ $diagnostico }}</div>
                @endforeach
            </td>
            <td style="text-align: justify; line-height: 1.2; font-size: 10px;">
                @foreach($detalle['procedimientos'] as $procedimiento)
                <div>{{ $procedimiento }}</div>
                @endforeach
            </td>

            <td>
                @if(isset($detalle['recetas']) && count($detalle['recetas']) > 0)
                @foreach($detalle['recetas'] as $receta)
                <ul>
                    <li>
                        <strong>Medicamento:</strong> {{ $receta['medicamento'] }}<br>
                        <strong>Dosis:</strong> {{ $receta['dosis']['tipo_dosis'] }}<br>
                        <strong>Frecuencia:</strong> {{ $receta['frecuencia']['tipo_frecuencia'] }}
                    </li>
                </ul>
                @endforeach
                @else
                <p></p>
                @endif
            </td>


            <td>
                @php
                // Ruta de la imagen (suponiendo que tienes la imagen en la ruta correcta)
                $imagen_path = storage_path('app/public/sellos/' . $detalle['firma_doc']);
                if (file_exists($imagen_path)) {
                $imagen_base64 = base64_encode(file_get_contents($imagen_path));
                }
                @endphp

                @if(isset($imagen_base64))
                <!-- Mostrar la imagen en base64 -->
                <img src="data:image/jpeg;base64,{{ $imagen_base64 }}" style="width: 125px; height: 40px;">
                @else
                <!-- Si no hay imagen, muestra un mensaje -->
                ¡La imagen no se encontró!
                @endif
            </td>
        </tr>


        @endforeach


        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>



</body>


</html>