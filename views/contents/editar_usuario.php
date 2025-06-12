<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Paciente </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Editar Paciente</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">



            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Informacion Paciente</h3>
                        </div>
                        <div class="card-body">
                            <div id="accordion">
                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h4 class="card-title w-100">
                                            <a id="acordion-persona" class="d-block w-100" data-toggle="collapse"
                                                href="#collapseOne">
                                                Datos Personales
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <form class="form-horizontal" id="editar-usuario"
                                                enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group row">
                                                                <div class="col-12">
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                        <input type="hidden" name="" id="id-usuario">
                                                                        <input type="hidden" name="" id="id-persona">

                                                                        <input class="custom-control-input"
                                                                            type="checkbox" id="no-validar">
                                                                        <label for="no-validar"
                                                                            class="custom-control-label">Pasaporte
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <label for="cedula"
                                                                    class="col-sm-4 col-form-label">Cédula</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm solo-numeros"
                                                                        placeholder="09123456789" maxlength="10"
                                                                        minlength="10" id="editar-cedula" name="cedula"
                                                                        required>

                                                                </div>

                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label">Nombres</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm  danger  solo-letras"
                                                                        maxlength="150" minlength="4" id="editar-nombre"
                                                                        name="nombres" required>
                                                                </div>

                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label">Apellidos</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm  danger  solo-letras"
                                                                        maxlength="150" minlength="4"
                                                                        id="editar-apellido" name="nombres" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="cedula"
                                                                    class="col-sm-4 col-form-label">Telefono
                                                                    Convencional</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm  solo-numeros"
                                                                        placeholder="04 2799550" maxlength="10"
                                                                        minlength="7" id="editar-telefono"
                                                                        value="04-0000000">
                                                                </div>

                                                                <label for="cedula"
                                                                    class="col-sm-4 col-form-label">Celular</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm  solo-numeros"
                                                                        placeholder="09123456789" maxlength="10"
                                                                        minlength="10" id="editar-celular" required>
                                                                </div>

                                                                <label class="col-sm-4 col-form-label">Genero</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control form-control-sm"
                                                                        id="editar-genero" required>

                                                                    </select>
                                                                </div>




                                                            </div>
                                                            <div class="form-group row">




                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label">Correo</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm  danger"
                                                                        id="editar-correo" name="nombres">
                                                                </div>


                                                            </div>



                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group row">
                                                                <div class="col-12">
                                                                    <div class="custom-control custom-checkbox mb-3">

                                                                    </div>
                                                                </div>

                                                                <label for="fnacimiento"
                                                                    class="col-sm-4 col-form-label">Fecha de
                                                                    Nacimiento</label>
                                                                <div class="col-sm-8">
                                                                    <input type="date"
                                                                        class="form-control form-control-sm soloNumeros"
                                                                        id="editar-fecha" name="cedula" required>

                                                                </div>

                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label">Tipo de
                                                                    Seguro</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control form-control-sm"
                                                                        id="editar-tipo-seguro">
                                                                    </select>
                                                                </div>

                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label">Rol</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control form-control-sm"
                                                                        id="editar-rol" required>

                                                                    </select>
                                                                </div>

                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label">Usuario</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm  danger"
                                                                        id="editar-usuario2" name="nombres">
                                                                </div>



                                                                <label for="" class="col-sm-4 col-form-label"></label>
                                                                <div class="col-sm-8">

                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-4 col-form-label"></label>
                                                                <div class="col-sm-8">

                                                                </div>

                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label">Operadora</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control form-control-sm"
                                                                        id="editar-operadora" required>

                                                                    </select>
                                                                </div>





                                                                <label for="" class="col-sm-4 col-form-label"></label>
                                                                <div class="col-sm-8">

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">


                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label">Tipo de
                                                                    Cobertura</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control form-control-sm"
                                                                        id="editar-cobertura">


                                                                    </select>
                                                                </div>

                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label">Responsable del
                                                                    Paciente</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm  danger"
                                                                        maxlength="150" minlength="4"
                                                                        id="editar-responsable" name="nombres"
                                                                        value="Voluntario">
                                                                </div>





                                                            </div>



                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Direccion</label>
                                                        <textarea class="form-control form-control-sm " rows="3"
                                                            placeholder="Escribir su dirección"
                                                            id="editar-direccion"></textarea>
                                                    </div>


                                                </div>
                                                <div class="card card-success">
                                                    <div class="card-header">
                                                        <h4 class="card-title w-100">
                                                            <a id="acordion-usuario" class="d-block w-100"
                                                                data-toggle="collapse" href="#collapseTwo">
                                                                Subir Fotografia
                                                            </a>
                                                        </h4>
                                                    </div>

                                                    <div class="card-body">

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="img-usuario">Imagen</label>
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input type="file" name="img"
                                                                                id="img-usuario"
                                                                                class="custom-file-input"
                                                                                accept="image/*">
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


                                                    </div>

                                                    <div class="card-header">
                                                        <h4 class="card-title w-100">
                                                            <a id="acordion-usuario" class="d-block w-100"
                                                                data-toggle="collapse" href="#collapseTwo">
                                                                Cargar Cedula
                                                            </a>
                                                        </h4>
                                                    </div>

                                                    <div class="card-body">

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="img-usuario-cedula">Subir Cedula</label>
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input type="file" name="img"
                                                                                id="img-cedula"
                                                                                class="custom-file-input" accept=".pdf">
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
                                <!-- <div class="col-12" style="width: 218px; height: 315px">
                                    <img id="imagen-usuario" src="<?=SERVIDOR?>resources/usuarios/default.jpg"
                                        style="width:75%; height:95%; border-radius: 20%" class="mx-auto d-block">
                                </div> -->
                           
                                <div>
                                    <!-- Aquí se mostrará el preview del PDF -->
                                    <div id="pdf-container" frameborder="0"></div>
                                </div>

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


<script src="<?=BASE?>views/dist/js/scripts/editarUsuario.js?ver=1.1.1.3"></script>