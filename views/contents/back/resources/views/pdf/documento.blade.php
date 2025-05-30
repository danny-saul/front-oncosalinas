<!-- resources/views/pdf/documento.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFORME MEDICO</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        /* Eliminar el margen */
    }

    h1 {
        color: blue;
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
        font-size: 7px;

    }
    </style>
</head>

<body>


    <div class="header">


        <div style="float:left">
            <?php
        
        $imagen_path = public_path('img/' . $response['empresa']['logo']);

        if (file_exists($imagen_path)) {
            // Obtener el contenido de la imagen en base64
            $imagen_base64 = base64_encode(file_get_contents($imagen_path));
        ?>

            <img src="data:image/jpeg;base64,<?= $imagen_base64 ?> "
              style="width: 100px; height: 50px; margin-top:-50px">

            <?php
        } else {
            // Si la imagen no existe, mostrar un mensaje de error
            echo "¡La imagen no se encontró!";
        }
        ?>
            <div style="clear: both;"></div>

        </div>




    </div>

    

    <!-- Tabla con los datos del paciente -->
    <table>
        <tr>
            <th>A.- DATOS DEL ESTABLECIMIENTO Y USUARIO / PACIENTE</th>
        </tr>

        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>
    <table>
        <tr>
            <th>INSTITUCION DEL SISTEMA</th>
            <th>CODIGO</th>
            <th>ESTABLECIMIENTO DE SALUD</th>
            <th>N HISTORIA CLINICA</th>
            <th>ID</th>
        </tr>
        <tr>
            <td>{{ $response['empresa']['nombre_empresa' ]}}</td>
            <td>0001</td>
            <td>{{ $response['empresa']['nombre_empresa' ]}}</td>
            <td>{{ $response['orden']['citas']['paciente']['persona']['id'] }}</td>
            <td>{{ $response['orden']['citas']['paciente']['persona']['id'] }}</td>
        </tr>




        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>

    <table>
        <tr>
            <th>APELLIDOS</th>
            <th>NOMBRES</th>
            <th>SEXO</th>
            <th>FECHA DE NACIMIENTO</th>
            <th>EDAD</th>
        </tr>
        <tr>
            <td>{{ $response['orden']['citas']['paciente']['persona']['apellido'] }}</td>
            <td>{{ $response['orden']['citas']['paciente']['persona']['nombre'] }}</td>
            <td>{{ $response['orden']['citas']['paciente']['persona']['sexo']['tipo'] }}</td>
            <td>{{ $response['orden']['citas']['paciente']['persona']['fecha_nacimiento'] }}</td>
            <td>
                <?php
                // Fecha de nacimiento del paciente
                $fecha_nacimiento = $response['orden']['citas']['paciente']['persona']['fecha_nacimiento'];

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
                echo "Edad: $anios años, $meses meses y $dias días";
                ?>
            </td>

        </tr>
    </table>

    <table>
        <tr>
            <th>B.- DATOS DEL SERVICIO</th>
        </tr>
    </table>



    <table>
        <tr>
            <th>PROFESIONAL QUE REALIZA EL ESTUDIO</th>
            <th>FECHA DE REALIZACION</th>
            <th>PROFESIONAL SOLICITANTE</th>
            <th>SERVICIO</th>
            <th>ESPECIALIDAD</th>

        </tr>
        <tr>
            <td>{{ $response['orden']['doctor']['persona']['nombre'] }}
                {{ $response['orden']['doctor']['persona']['apellido'] }}</td>
            <td>{{ $response['orden']['fecha']}}</td>
            <td>{{ $response['docsolicita']['nombre'] }}
                {{ $response['docsolicita']['apellido'] }}</td>
            <td>CONSULTA EXTERNA</td>
            <td>{{ $response['espe']['nombre_especialidad'] }}</td>

        </tr>
    </table>

    <table>
        <tr>
            <th>C.- ESTUDIO DE IMAGENOLOGIA SOLICITADO</th>
        </tr>
    </table>



    <table>

        <tr>
            <td class="td1">RX CONVENCIONAL</td>
            <td></td>
            <td class="td1">RX PORTATIL</td>
            <td></td>
            <td class="td1">TOMOGRAFIA</td>
            <td></td>
            <td class="td1">RESONANCIA</td>
            <td></td>
            <td class="td1">ECOGRAFIA</td>
            <td></td>
            <td class="td1">MAMOGRAFIA</td>
            <td></td>
            <td class="td1">PROCEDIMIENTO</td>
            <td></td>
            <td class="td1">OTRO</td>
            <td></td>
            <td class="td1">SEDACION</td>
            <td class="td1">SI</td>
            <td></td>
            <td class="td1">NO</td>
            <td></td>
        </tr>

    </table>
    <table>
        <tr>
            <td>
                DESCRIPCION:
            </td>

        </tr>
    </table>



    <table>
        <tr>
            <th>D.- HALLAZGOS POR IMAGENOLOGIA </th>
        </tr>
    </table>

    <table>
        <tr>
            <td style="text-align: justify; line-height: 1.5;">
                {!! nl2br(e($response['orden']['informe'])) !!}
            </td>


        </tr>
    </table>

    <table>
        <tr>
            <th>E.- CONCLUSIONES Y SUGERENCIAS </th>
        </tr>
    </table>

    <table>
        <tr>
            <td style="text-align: justify; line-height: 1.5;">
                {!! nl2br(e($response['orden']['conclusion'])) !!}
            </td>


        </tr>
    </table>

    <table>
        <tr>
            <th>F.- DIAGNOSTICO</th>
        </tr>
    </table>



    <table>
        <tr>
            <th>DIAGNOSTICO</th>
            <th>CIE</th>
            <th>PRE</th>
            <th>DEF</th>


        </tr>

        @foreach($response['orden']['ordenes_diagnostico'] as $diagnostico)
        <tr>
            <td>{{ $diagnostico['diagnosticocie10']['descripcion'] }}</td>
            <td>{{ $diagnostico['diagnosticocie10']['clave'] }}</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach







    </table>

    <table>
        <tr>
            <th>G.- DATOS DEL PROFESIONAL RESPONSABLE</th>
        </tr>

        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>
    <table>
        <tr>
            <th>FECHA</th>
            <th>HORA</th>
            <th>APELLIDOS</th>
            <th>NOMBRES</th>

        </tr>
        <tr>
            <td>
                <?php
            // Obtener la fecha y la hora del objeto $response['orden']['fecha']
            $fecha_hora = $response['orden']['fecha'];

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
            $fecha_hora = $response['orden']['fecha'];

            // Convertir la cadena de fecha y hora en un objeto DateTime
            $fecha_hora_dt = new DateTime($fecha_hora);

            // Obtener la fecha y la hora por separado
            $fecha = $fecha_hora_dt->format('Y-m-d');
            $hora = $fecha_hora_dt->format('H:i:s');
            ?>

                {{ $hora }}
            </td>
            <td>{{ $response['orden']['doctor']['persona']['apellido'] }}</td>
            <td>{{ $response['orden']['doctor']['persona']['nombre'] }}</td>
        </tr>



        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>

    <table>

        <tr>
            <td>NUMERO DE DOCUMENTO DE IDENTIFIACION</td>
            <td>FIRMA</td>
            <td>SELLO</td>

        </tr>
        <tr>
            <td>{{ $response['orden']['doctor']['persona']['cedula'] }}</td>
            <td>
                <?php
                // Ruta de la imagen
              //  $imagen_path = public_path('/storage/sellos/' . $response['orden']['doctor']['img_sello']);
                $imagen_path = storage_path('app/public/sellos/' . $response['orden']['doctor']['img_sello']);
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
                $imagen_path = storage_path('app/public/sellos/' . $response['orden']['doctor']['img_sello']);

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

    <hr>
        <hr>
        <div class="col-12 ">

            <div class="col-6" style="text-align:right; font-size: 10px">
                {{ $response['empresa']['nombre_empresa' ]}} <br>
                {{ $response['empresa']['direccion_empresa' ]}}</h2>
                <br>
                {{ $response['empresa']['barra2' ]}}</h2>
                <br>
                {{ $response['empresa']['telefono1_empresa' ]}} {{ $response['empresa']['telefono2_empresa' ]}}
            </div>
        </div>
        <hr>

</body>

</html>