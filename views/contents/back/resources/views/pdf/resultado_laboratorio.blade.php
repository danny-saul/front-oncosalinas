<!-- resources/views/pdf/documento.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDEN LABORATORIO</title>
    <style>
    body {
        font-family: Arial, sans-serif;
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

<body style="font-family: 'Times New Roman', Times, serif;">

    <div class="header">


        <div style="float:left">
            <?php
              
              $imagen_path = public_path('img/' . $response['empresa']['logo']);
        
                if (file_exists($imagen_path)) {
                    // Obtener el contenido de la imagen en base64
                    $imagen_base64 = base64_encode(file_get_contents($imagen_path));
                ?>

            <img src="data:image/jpeg;base64,<?= $imagen_base64 ?>">
            <?php
                } else {
                    // Si la imagen no existe, mostrar un mensaje de error
                    echo "¡La imagen no se encontró!";
                }
                ?>
            <div style="clear: both;"></div>

        </div>


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
    <br>

    <br>

    <br>

    <div class="header" style="margin-top: -35px;">
        <h3 style="background-color:#9abbde; font-family: 'Times New Roman', Times, serif;">EXAMENES DE LABORATORIO</h3>
    </div>
    Fecha: {{ $response['orden']['citas']['fecha'] }}
    <h5 style="color: red;"> Orden: {{ $response['orden']['numero_orden_lab'] }} </h5>



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


    <hr>




    <div class="header" style="margin-top: -35px;">
        <h3 style="background-color:#9abbde; font-family: 'Times New Roman', Times, serif;">RESULTADOS</h3>
    </div>
    <div class="col-12 ">

        <div class="col-6">

            <table>
                <tr>
                    <th>EXAMEN</th>
                    <th>RESULTADO</th>


                </tr>
                @foreach($response['orden']['laboratorio_detalle'] as $detalle)
                <tr>
                    <td>{{ $detalle['tipo_examen']['descripcion_lab'] }}</td>
                    <td>{{ $detalle['resultado_examen'] }}</td>
                </tr>
                @endforeach





                <!-- Agrega las filas restantes según los datos del paciente -->
            </table>


        </div>
    </div>

    <br>
    <hr>

    <div class="firma" style="line-height: 0.9; font-family: 'Times New Roman', Times, serif;">

        <p> <?php
                // Ruta de la imagen
            //    $imagen_path = public_path('/storage/sellos/' . $response['orden']['doctor']['img_sello']);
                $imagen_path = storage_path('app/public/sellos/' . $response['orden']['citas']['doctor']['img_sello']);

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
        </p>
        <p>________________________________________</p>

        <p>Dr. {{ ($response['orden']['doctor']['persona']['nombre'] ) }}
            {{ ($response['orden']['doctor']['persona']['apellido'] ) }} </p>
        <p>Especialista en {{ ($response['orden']['doctor']['especialidades']['nombre_especialidad'] ) }} -
            {{ $response['empresa']['nombre_empresa' ]}}</p>
        <p>Registro Senescyt: {{ ($response['orden']['doctor']['reg_senescyt'] ) }} - Cédula:
            {{ ($response['orden']['doctor']['persona']['cedula'] ) }}</p>
        <p>Registro MSP:</p>
        <p></p>
        @foreach ($response['orden']['doctor']['persona']['usuario'] as $usuario)
        <p>Email: {{ $usuario->correo }}</p>

        @endforeach
    </div>















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