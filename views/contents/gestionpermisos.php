<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <b>Permisos</b> </h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center form-group flex-column">
                <label for="">Rol</label>
                <select class="form-control form-control-sm" id="select-rol">
                    <!--  <option>option 1</option> -->
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-danger card-outline shadow">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Permisos</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Menus</th>
                                    <th>Permisos</th>
                                </tr>
                            </thead>
                            <tbody id="body-menus">
                               
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/permisos.js?ver=1.1.1.2"></script>