<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Odontograma</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: sans-serif;
        }

        .odontograma-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }

        .fila {
            display: flex;
            flex-direction: row;
            gap: 10px;
        }

        .diente {
            width: 60px;
            text-align: center;
        }

        svg {
            width: 50px;
            height: 50px;
        }

        .cara {
            stroke: black;
            stroke-width: 0.5;
            fill: white;
        }

        .numero-diente {
            font-size: 10px;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <div class="odontograma-container">
        <div class="fila" id="odontograma-adultos-superior-izq">
            @foreach (['18','17','16','15','14','13','12','11'] as $num)
                <div class="diente">
                    <svg viewBox="0 0 50 50">
                        <polygon points="10,5 40,5 35,15 15,15" class="cara"/> <!-- Vestibular -->
                        <polygon points="10,45 40,45 35,35 15,35" class="cara"/> <!-- Lingual -->
                        <polygon points="10,5 15,15 15,35 10,45" class="cara"/> <!-- Mesial -->
                        <polygon points="40,5 35,15 35,35 40,45" class="cara"/> <!-- Distal -->
                        <polygon points="15,15 35,15 35,35 15,35" class="cara"/> <!-- Oclusal -->
                    </svg>
                    <div class="numero-diente">{{ $num }}</div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
