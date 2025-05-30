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

    .header {
        text-align: center;
        margin-bottom: 10px;
    }

    .header img {
        width: 80px;
        margin-bottom: 5px;
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

<body id="pdf-content">
    <!-- Encabezado con los datos de la empresa -->
    <div class="header">
        <!--   <img src="{{ asset('ruta/al/logo.png') }}" alt="Logo de la empresa"> -->
        <h2 style="margin: 0; font-size: 16px;">DENTAL MAX TEAM </h2>
        <p style="margin: 0; font-size: 14px;">Barrio San Francisco Calle 10 Entre Avenidas 8 y 9 La Libertad - Ecuador
        </p>
        <p style="margin: 0; font-size: 14px;">0978640033 - 0981324662</p>
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
            <td>DENTAL MAX TEAM</td>
            <td>0001</td>
            <td>DENTAL MAX TEAM</td>
            <td>0001</td>
            <td>0001</td>
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
            <th>E.- CONCLUSIONES Y SUGERENCIAS </th>
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
  


        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>

    <table>
        
        <tr>
            <td>NUMERO DE DOCUMENTO DE IDENTIFIACION</td>
            <td>FIRMA</td>
            <td>SELLO</td>
            
        </tr>
        <tr>
     
           
        </tr>




        <!-- Agrega las filas restantes según los datos del paciente -->
    </table>

</body>

</html>


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script> -->

<!-- <script src="<?=BASE?>views/dist/js/scripts/generarpdf.js"></script>

 -->

