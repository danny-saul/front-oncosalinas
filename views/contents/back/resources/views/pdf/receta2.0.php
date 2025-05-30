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

    .header {
        text-align: center;
        margin-bottom: 2px;
    }

    .header img {
        width: 190px;
        /*     margin-bottom: 15px; */
        height: 120px;
        margin-top: -25px;
        margin-left: -15px;
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
        padding: 0px;
        font-size: 11px;
        border: none;
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


    /* Contenedor principal para centrar el contenido */
    .doctor-container {
        text-align: center;
        /* Centrar contenido */
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Alinear al centro */
    }

    /* Imagen del sello */
    .sello {
        width: 250px;
        height: 65px;
        display: block;
        margin-bottom: 5px;
        /* Espacio debajo de la imagen */
    }

    /* Estilo del texto debajo de la imagen */
    .doctor-text p {
        margin: 2px 0;
        /* Espacio reducido entre los párrafos */
        font-size: 7px;
        /* Tamaño de letra ajustado */
        text-align: center;
    }

    /* Mensaje de error si no se encuentra la imagen */
    .error-msg {
        color: red;
        font-weight: bold;
        text-align: center;
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
    <hr>

    <table>

        <tr>
            <td>FECHA CITA: {{ $response['citas']['fecha'] }}</td>
            <td>FECHA Y HORA DE IMPRESION {{ now()->format('d/m/Y H:i') }}</td>
            <td># NUM. RECETA: {{ $response['receta']['numero_receta'] }} </td>


        </tr>
    </table>
    <table>

        <tr>
            <td>PACIENTE: {{ $response['citas']['paciente']['persona']['nombre'] }}
                {{ $response['citas']['paciente']['persona']['apellido'] }}</td>
            <td> EDAD:
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
                echo " $anios años, $meses meses y $dias días";
                ?>
            </td>
            <td>GENERO:{{ $response['citas']['paciente']['persona']['sexo']['tipo'] }}</td>


        </tr>
    </table>

    <table>

        <tr>
            <td>CEDULA: {{ $response['citas']['paciente']['persona']['cedula'] }}</td>
            <td># H. CLINICA: {{ $response['citas']['paciente']['persona']['id'] }}</td>
            <td>ESPECIALIDAD: {{ $response['citas']['doctor']['especialidades']['nombre_especialidad'] }}</td>


        </tr>
    </table>

    <hr>

<table>
    <tr>
        <th>MEDICAMENTO</th>
        <th>CANTIDAD</th>
        <th>VÍA DE ADMINISTRACIÓN</th>
    </tr>

    @if(isset($response['receta']['receta_detalle']))
        @foreach($response['receta']['receta_detalle'] as $detalle)
            @if($detalle['estado'] === 'A')
                <tr>
                    <td>
                        {{ $detalle['producto']['nombre_producto'] }}
                        @if(isset($detalle['frecuencia']['tipo_frecuencia']))
                            - {{ $detalle['frecuencia']['tipo_frecuencia'] }}
                        @endif
                        @if(!empty($detalle['dosis']['tipo_dosis']))
                            - Dosis: {{ $detalle['dosis']['tipo_dosis'] }}
                        @endif
                        @if(!empty($detalle['duracion']))
                            - Duración: {{ $detalle['duracion'] }}
                        @endif
                        @if(!empty($detalle['observacion']))
                            - {{ $detalle['observacion'] }}
                        @endif
                    </td>
                    <td>{{ $detalle['cantidad'] }}</td>
                    <td>{{ $detalle['via']['tipo_via'] ?? '---' }}</td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="3">No hay detalles de receta disponibles.</td>
        </tr>
    @endif
</table>




    <table>
        <tr>
            <th>DIAGNOSTICOS</th>
            <th>DATOS DEL PRESCRIPTOR</th>

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
            <td class="doctor-info">
                <?php
        // Ruta de la imagen
        $imagen_path = storage_path('app/public/sellos/' . $response['citas']['doctor']['img_sello']);

        // Verificar si la imagen existe
        if (file_exists($imagen_path)) {
            // Obtener el contenido de la imagen en base64
            $imagen_base64 = base64_encode(file_get_contents($imagen_path));
    ?>
                <!-- Contenedor para centrar la imagen y el texto -->
                <div class="doctor-container">
                    <!-- Mostrar la imagen en base64 -->
                    <img src="data:image/jpeg;base64,<?= $imagen_base64 ?>" class="sello">
                    <div class="doctor-text">
                        <p><strong>Dr. {{ $response['citas']['doctor']['persona']['nombre'] }}
                                {{ $response['citas']['doctor']['persona']['apellido'] }}</strong></p>
                        <p>Especialista en {{ $response['citas']['doctor']['especialidades']['nombre_especialidad'] }} -
                            {{ $response['empresa']['nombre_empresa'] }}</p>
                        <p>Registro Senescyt: {{ $response['citas']['doctor']['reg_senescyt'] }} - Cédula:
                            {{ $response['citas']['doctor']['persona']['cedula'] }}</p>

                    </div>
                </div>
                <?php
        } else {
            echo "<p class='error-msg'>¡La imagen no se encontró!</p>";
        }
    ?>
            </td>


        </tr>
    </table>

    <hr>
    <div class="col-12 ">

        <div class="col-6" style="text-align:left; font-size: 10px">
            {{ $response['empresa']['nombre_empresa' ]}} -
            {{ $response['empresa']['direccion_empresa' ]}}</h2>

            {{ $response['empresa']['barra2' ]}}</h2>,

            ESCRIBENOS A NUESTRO WHATSAPP Y AGENDA UNA CITA CON NOSOTROS AL NUMERO:
            {{ $response['empresa']['telefono1_empresa' ]}} {{ $response['empresa']['telefono2_empresa' ]}}
        </div>
    </div>
    <hr>

</body>

</html>