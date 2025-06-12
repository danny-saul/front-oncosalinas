<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registrar Productos </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Registrar Productos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Informacion Producto</h3>
                    </div>
                    <div class="card-body">
                        <div id="accordion">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a id="acordion-persona" class="d-block w-100" data-toggle="collapse"
                                            href="#collapseOne">
                                            Datos Productos
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                    <div class="card-body">
                                        <form class="form-horizontal" id="nuevo-producto" enctype="multipart/form-data">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row">

                                                            <label for="codigo" class="col-sm-4 col-form-label">Codigo
                                                                Producto</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="0000F052555" maxlength="15"
                                                                    minlength="3" id="nuevo-codigo" name="codigo"
                                                                    required>

                                                            </div>

                                                            <label class="col-sm-4 col-form-label">Categoria</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="select-categoria" required>
                                                                    <option value="0">Seleccione la Categoria</option>
                                                                </select>
                                                            </div>


                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Nombre Producto</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  danger  solo-letras"
                                                                    maxlength="150" minlength="4" id="registro-Producto"
                                                                    name="nombres" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="cedula"
                                                                class="col-sm-4 col-form-label">Descripcion Producto
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control form-control-sm " rows="3"
                                                                    placeholder="Ingrese la descripcion del producto"
                                                                    id="descripcion-Producto"></textarea>
                                                            </div>

                                                            <label class="col-sm-4 col-form-label">Presentacion</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="select-presentacion" required>
                                                                    <option value="0">Seleccione la Presentacion del
                                                                        Producto</option>
                                                                </select>
                                                            </div>


                                                            <label for="stock"
                                                                class="col-sm-4 col-form-label">Stock</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  solo-numeros"
                                                                    placeholder="1" maxlength="5" minlength="1"
                                                                    id="stock-Producto" required>
                                                            </div>

                                                            <label for="persona-nombres "
                                                                class="col-sm-4 col-form-label d-none">Usuario</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  d-none danger letras-vd"
                                                                    maxlength="150" minlength="4" id="new-usuario"
                                                                    value=" " name="nombres">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">

                                                            <!-- 
                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Rol</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="nuevo-rol" required>

                                                                </select>
                                                            </div>
 -->
                                                            <!--         <label
                                                                class="col-sm-4 col-form-label">Seleccione el Diagnostico</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="nuevo-rol" required>

                                                                </select>
                                                            </div> -->



                                                            <label for="persona-nombres d-none"
                                                                class="col-sm-4 col-form-label  d-none">Contraseña</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm   d-none  danger"
                                                                    value="default" maxlength="150" minlength="4"
                                                                    name="nombres" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row d-none">
                                                            <label for="cedula"
                                                                class="col-sm-4 col-form-label">Confirmar Contraseña
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  d-none "
                                                                    value="default" required>
                                                            </div>

                                                        </div>


                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row">
                                                            <div class="col-12">
                                                                <div class="custom-control custom-checkbox mb-3">

                                                                </div>
                                                            </div>

                                                            <label for="fechaingreso"
                                                                class="col-sm-4 col-form-label">Fecha de Ingreso</label>
                                                            <div class="col-sm-8">
                                                                <input type="date"
                                                                    class="form-control form-control-sm soloNumeros"
                                                                    id="nuevo-fecha" name="fecha" required>

                                                            </div>

                                                            <label for="stock" class="col-sm-4 col-form-label">Precio
                                                                Compra</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="9.00" id="precioCompra-Producto"
                                                                    required>
                                                            </div>

                                                            <label for="stock" class="col-sm-4 col-form-label">Precio
                                                                Venta</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm "
                                                                    placeholder="10.50" id="precioVenta-Producto"
                                                                    required>
                                                            </div>

                                                            <label for="stock" class="col-sm-4 col-form-label">Marca
                                                                </label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm "
                                                                    placeholder="Season" id="marca-Producto"
                                                                    required>
                                                            </div>



                                                            <label for="" class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">

                                                            </div>
                                                            <label for="" class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">

                                                            </div>
                                                            <label for="" class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">

                                                            </div>
                                                            <label for="" class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">

                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">

                                                            </div>





                                                            <label for="" class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>




                                            </div>
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        <a id="acordion-usuario" class="d-block w-100"
                                                            data-toggle="collapse" href="#collapseTwo">
                                                            Cargar Fotografia
                                                        </a>
                                                    </h4>
                                                </div>

                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="imagen-Producto">Imagen</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" name="img"
                                                                            id="imagen-Producto"
                                                                            class="custom-file-input" accept=".jpg, .jpeg">
                                                                        <label class="custom-file-label"
                                                                            for="exampleInputFile">Subir
                                                                            Archivo</label>
                                                                    </div>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">Subir</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fas fa-save mr-2"></i>Guardar</button>
                                                    </div>



                                                </div>






                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Vista Imagen Usuario</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12" style="width: 218px; height: 315px">
                                <img id="imagen-produc" src="<?=SERVIDOR?>resources/usuarios/default.jpg"
                                    style="width:75%; height:95%; border-radius: 20%" class="mx-auto d-block">
                            </div>
                        </div>
                    </div>

                </div>
            </div>



        </div>



    </div>
</div>
</div>


<script src="<?= BASE ?>views/dist/js/scripts/peticionJWT.js"></script>


<script src="<?=BASE?>views/dist/js/scripts/registro_Productos.js"></script>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>