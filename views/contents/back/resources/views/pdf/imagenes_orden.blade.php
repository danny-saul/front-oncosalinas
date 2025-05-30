<!-- resources/views/pdf/documento.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDEN IMAGEN</title>
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



<body style="font-family: 'Times New Roman', Times, serif;">

    <table width="100%" style="border-collapse: collapse; border: none;">
        <tr>
            <td align="left" width="20%" style="border: none;">
                <?php if (!empty($imagen_base64)): ?>
                <img src="data:image/jpeg;base64,<?= $imagen_base64 ?>" width="150"
                    style="margin-top: -40px; margin-left: -30px">
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
                <img src="data:image/jpeg;base64,<?= $imagen_base642 ?>" width="130"
                    style="margin-top: -20px; margin-right: -50px">
                <?php endif; ?>
            </td>
        </tr>
    </table>


    <br>
    <div class="header" style="margin-top: -35px;">
        <h2 style="font-family: 'Times New Roman', Times, serif;">ORDEN DE IMAGEN</h2>
    </div>
    <hr>
    <hr>
    <div class="col-12">
        <div class="col-6">
            Nombres: {{ $response['citas']['paciente']['persona']['nombre'] }}
            {{ $response['citas']['paciente']['persona']['apellido'] }}
            <br>
            Fecha: {{ $response['citas']['fecha'] }}
        </div>
        <div class="col-6">

        </div>
    </div>



    <div class="col-12 ">
        <br>


        <div class="col-6">
            Estudios Solicitados:
            <br>
            <ul>
                @if(isset($response['citas']['ordenes']))
                @php
                $ordenesFiltradas = collect($response['citas']['ordenes'])->where('estado', 'A');
                @endphp

                @if($ordenesFiltradas->isNotEmpty())
                @foreach($ordenesFiltradas as $orden)
                <li>{{ $orden['tipo_estudio']['descripcion'] }}</li>
                @endforeach
                @else
                <li>No hay estudios solicitados.</li>
                @endif
                @else
                <li>No hay estudios solicitados.</li>
                @endif
            </ul>
        </div>

    </div>

    <br>
    <hr>

    <div class="firma" style="line-height: 0.9; font-family: 'Times New Roman', Times, serif;">

        <p> 
                
            <br><br><br>
            <br><br><br>
        
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
            <td>DATOS DE IDENTIFICACION</td>
            <td>DATOS DEL PROFESIONAL</td>
            <td>SELLO</td>
            
        </tr>
        <tr>
            <td>{{ $response['citas']['doctor']['persona']['cedula'] }}</td>
          
          <td style="line-height: 0.1; font-family: 'Times New Roman', Times, serif;">  
          <p>{{ strtoupper($response['citas']['doctor']['persona']['nombre'] ) }}
            {{ strtoupper($response['citas']['doctor']['persona']['apellido'] ) }}  
        <p>{{ strtoupper($response['citas']['doctor']['especialidades']['nombre_especialidad'] ) }} -
        <p>Registro MSP:</p>
        <p>Registro Senescyt: {{ strtoupper($response['citas']['doctor']['persona']['cedula'] ) }}</p>
        <p>Email: {{ strtoupper($response['citas']['doctor']['persona']['correo'] ) }}</p>
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

   
    </table> -->