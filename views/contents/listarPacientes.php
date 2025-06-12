<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Medico </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Listar Pacientes</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
    <div class="card">
            <div class="card-header card-dark d-flex p-0">
                <h3 class="card-title p-3 card-dark">Listar Uusuarios</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Pacientes
                            </a></li>

                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="div" style="overflow: auto;">
                            <table id="tabla-pacientes" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5px">#</th>
                                        <th>Imagen</th>
                                        <th># Cedula </th>
                                        <th>Apellidos</th>
                                        <th>Nombres</th>  
                                        <th>Rol </th>
                                        <th>Correo</th> 
                                        <th>Telefono</th>
                                        <th>Operadora</th>
                                        <th>Direccion</th> 
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
</div>





<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=BASE?>views/plugins/moment/moment.min.js"></script>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>

<script src="<?= BASE ?>views/dist/js/scripts/peticionJWT.js"></script>

<script src="<?=BASE?>views/dist/js/scripts/listarPacientes.js?ver=1.1.1.2"></script>

<script>
$(document).ready(function() {
    $('.descargar-pdf').on('click', function() {
        var url = $(this).data('url');
        descargarPDF(url);
    });

    function descargarPDF(url) {
        // Realizar la solicitud AJAX para descargar el PDF
        $.ajax({
            url: url,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data) {
                // Crear un enlace para descargar el PDF
                var blob = new Blob([data], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'documento.pdf'; // Nombre del archivo descargado
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                console.error('Error al descargar el PDF:', error);
            }
        });
    }
});
</script>




<script>
        $(document).ready(function() {
            $('#imprimir').click(function() {
                // Llamada AJAX para obtener el PDF
                $.ajax({
                    url: urlServidor + 'fotos/usuarios}/'+ usuarios, // Reemplaza con la URL correcta de tu función PHP/Laravel
                    method: 'GET',
                    success: function(data, status, xhr) {
                        // Crear un blob con la respuesta del servidor
                        var blob = new Blob([data], { type: 'application/pdf' });
                        var url = URL.createObjectURL(blob);
                        
                        // Redirigir a la URL del PDF en una nueva pestaña
                        window.open(url, '_blank');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener el PDF:', error);
                        alert('No se pudo obtener el PDF. Por favor, inténtalo de nuevo.');
                    }
                });
            });
 
        });
    </script>
</body>
</html>