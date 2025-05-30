<!-- resources/views/pdf/documento.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RECETA</title>
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

    <div class="header">


        <div style="float:left">
            <?php
                
                $imagen_path = public_path('img/' . $response['empresa']['logo']);
        
                if (file_exists($imagen_path)) {
                    // Obtener el contenido de la imagen en base64
                    $imagen_base64 = base64_encode(file_get_contents($imagen_path));
                ?>

            <img src="data:image/jpeg;base64,<?= $imagen_base64 ?> "
                style="width: 270px; height: 190px; margin-top:-100px">
            <?php
                } else {
                    // Si la imagen no existe, mostrar un mensaje de error
                    echo "¡La imagen no se encontró!";
                }
                ?>
            <div style="clear: both;"></div>

        </div>




    </div>

    <br>
    <br>
    <br>
    <!-- Tabla con los datos del paciente -->
    <table>
        <tr>
            <th>1.- INFORMACION DEL ESTABLECIMIENTO</th>
        </tr>

        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>
    <table>
        <tr>
            <th>NOMBRE</th>
            <th>SERVICIO</th>
            <th>FECHA</th>
            <th>Nº HISTORIA CLINICA</th>
        </tr>
        <tr>
            <td>{{ $response['empresa']['nombre_empresa' ]}}</td>
            <td>{{ $response['citas']['doctor']['especialidades']['nombre_especialidad'] }}</td>
            <td>{{ $response['citas']['fecha'] }}</td>
            <td>{{ $response['citas']['paciente']['persona']['id'] }}</td>
        </tr>
    </table>


    <table>
        <tr>
            <th>APELLIDOS</th>
            <th>NOMBRES</th>
            <th>SEXO</th>
            <th>NACIONALIDAD</th>
            <th>FECHA DE NACIMIENTO</th>
            <th>EDAD</th>
        </tr>
        <tr>
            <td>{{ $response['citas']['paciente']['persona']['apellido'] }}</td>
            <td>{{ $response['citas']['paciente']['persona']['nombre'] }}</td>
            <td>{{ $response['citas']['paciente']['persona']['sexo']['tipo'] }}</td>
            <td> </td>
            <td>{{ $response['citas']['paciente']['persona']['fecha_nacimiento'] }}</td>
            <td>
                <?php
                // Fecha de nacimiento del paciente
                $fecha_nacimiento = $response['citas']['paciente']['persona']['fecha_nacimiento'];

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
            <th>2.- PRESCRIPCION</th>
        </tr>
    </table>



    <table>
        <tr>
            <th>MEDICAMENTO</th>
            <th>CANTIDAD</th>
            <th>VIA DE ADMINISTRACION</th>



        </tr>
        @foreach($response['citas']['receta'] as $rece)
        @if($rece['estado'] == 'A')
        <!-- Condición para filtrar solo los productos con estado 'A' -->
        <tr>
            <td>{{ $rece['producto']['nombre_producto'] . ' - ' . $rece['frecuencia']['tipo_frecuencia']  . ' - ' . $rece['observacion'] }}
            </td>
            <td>{{ $rece['cantidad'] }}</td>
            <td>Via</td>
        </tr>
        @endif
        @endforeach







    </table>
    <table>
        <tr>
            <th>3.- DIAGNOSTICO</th>
        </tr>
    </table>


    @if(isset($response['diagnosticos']) && count($response['diagnosticos']) > 0)
    <table>
        <tr>
            <th>DIAGNÓSTICO</th>
            <th>CIE</th>
            <th>TIPO DIAGNÓSTICO</th>
        </tr>

        @foreach($response['diagnosticos'] as $diagnostico)
        <tr>
            <td>{{ $diagnostico['diagnostico']['descripcion'] }}</td>
            <td>{{ $diagnostico['diagnostico']['clave'] }}</td>
            <td>{{ $diagnostico['tipo_diagnostico']['tipo_diagnostico'] }}</td>
        </tr>
        @endforeach
    </table>
@else
    <p>No hay diagnósticos disponibles.</p>
@endif



    </table>
    <table>
        <tr>
            <th>3.- DATOS DEL PRESCRIPTOR</th>
        </tr>



        <div class="firma" style="line-height: 0.9; font-family: 'Times New Roman', Times, serif;">

            <p> <?php
                // Ruta de la imagen
            //    $imagen_path = public_path('/storage/sellos/' . $response['orden']['doctor']['img_sello']);
                $imagen_path = storage_path('app/public/sellos/' . $response['citas']['doctor']['img_sello']);

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

            <p>Dr. {{ ($response['citas']['doctor']['persona']['nombre'] ) }}
                {{ ($response['citas']['doctor']['persona']['apellido'] ) }} </p>
            <p>Especialista en {{ ($response['citas']['doctor']['especialidades']['nombre_especialidad'] ) }} -
                {{ $response['empresa']['nombre_empresa' ]}}</p>
            <p>Registro Senescyt: {{ ($response['citas']['doctor']['reg_senescyt'] ) }} - Cédula:
                {{ ($response['citas']['doctor']['persona']['cedula'] ) }}</p>
            <p>Registro MSP:</p>
            <p></p>
            @foreach ($response['citas']['doctor']['persona']['usuario'] as $usuario)
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







<!-- 

<table>

<tr>
    <td>NUMERO DE DOCUMENTO DE IDENTIFIACION</td>
    <td>FIRMA</td>
    <td>SELLO</td>

</tr>
<tr>
    <td>{{ $response['citas']['doctor']['persona']['cedula'] }}</td>

    <td>
        <?php
    // Ruta de la imagen
//    $imagen_path = public_path('/storage/sellos/' . $response['citas']['doctor']['img_sello']);
    $imagen_path = storage_path('app/public/sellos/' . $response['citas']['doctor']['img_sello']);

    // Verificar si la imagen existe
    if (file_exists($imagen_path)) {
        // Obtener el contenido de la imagen en base64
        $imagen_base64 = base64_encode(file_get_contents($imagen_path));
    ?>
   
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
  //  $imagen_path = public_path('/storage/sellos/' . $response['citas']['doctor']['img_sello']);
  $imagen_path = storage_path('app/public/sellos/' . $response['citas']['doctor']['img_sello']);

    // Verificar si la imagen existe
    if (file_exists($imagen_path)) {
        // Obtener el contenido de la imagen en base64
        $imagen_base64 = base64_encode(file_get_contents($imagen_path));
    ?>
   
        <img src="data:image/jpeg;base64,<?= $imagen_base64 ?>" style="width: 250px; height: 65px;">
        <?php
    } else {
        // Si la imagen no existe, mostrar un mensaje de error
        echo "¡La imagen no se encontró!";
    }
    ?>

    </td>

</tr>

 
</table>

 -->