<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registrar Usuario </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Registrar Usuario</li>
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
                        <h3 class="card-title">Informacion Usuario</h3>
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
                                        <form class="form-horizontal" id="nuevo-usuario" enctype="multipart/form-data">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row">
                                                            <div class="col-12">
                                                                <div class="custom-control custom-checkbox mb-3">
                                                                    <input class="custom-control-input" type="checkbox"
                                                                        id="no-validar">
                                                                    <label for="no-validar"
                                                                        class="custom-control-label">Pasaporte
                                                                        </label>
                                                                </div>
                                                            </div>

                                                            <label for="cedula"
                                                                class="col-sm-4 col-form-label">Cédula</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  solo-numeros"
                                                                    placeholder="09123456789" maxlength="10"
                                                                    minlength="10" id="nuevo-cedula" name="cedula"
                                                                    required>
                                                                    
                                                            </div>

                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Nombres</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  danger solo-letras"
                                                                    maxlength="150" minlength="4" id="nuevo-nombre"
                                                                    name="nombres" required>
                                                            </div>

                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Apellidos</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  danger solo-letras"
                                                                    maxlength="150" minlength="4" id="nuevo-apellido"
                                                                    name="nombres" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="cedula"
                                                                class="col-sm-4 col-form-label">Telefono Convencional</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  solo-numeros"
                                                                    placeholder="04 2799550" maxlength="10"
                                                                    minlength="7" id="nuevo-telefono" required>
                                                            </div>

                                                            <label for="cedula"
                                                                class="col-sm-4 col-form-label">Celular</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  solo-numeros"
                                                                    placeholder="09123456789" maxlength="10"
                                                                    minlength="10" id="nuevo-celular" required>
                                                            </div>

                                                            <label
                                                                class="col-sm-4 col-form-label">Genero</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="nuevo-genero" required>
                                                                    <option value="0">Seleccione el Sexo</option>
                                                                </select>
                                                            </div>




                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Usuario</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  danger"
                                                                    maxlength="150" minlength="4" id="new-usuario"
                                                                    name="nombres" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">


                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Rol</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="nuevo-rol" required>

                                                                </select>
                                                            </div>

                                                            <!--         <label
                                                                class="col-sm-4 col-form-label">Seleccione el Diagnostico</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="nuevo-rol" required>

                                                                </select>
                                                            </div> -->



                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Correo</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm  danger"
                                                                    id="nuevo-correo" name="nombres" required>
                                                            </div>

                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Contraseña</label>
                                                            <div class="col-sm-8">
                                                                <input type="password"
                                                                    class="form-control form-control-sm  danger"
                                                                    maxlength="150" minlength="4" id="nuevo-password"
                                                                    name="nombres" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="cedula"
                                                                class="col-sm-4 col-form-label">Confirmar Contraseña
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input type="password" class="form-control form-control-sm "
                                                                    id="nuevo-password2" required>
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
                                                                class="col-sm-4 col-form-label">Fecha de Nacimiento</label>
                                                            <div class="col-sm-8">
                                                                <input type="date"  
                                                                    class="form-control form-control-sm"
                                                                    placeholder="09123456789" maxlength="10"
                                                                    minlength="10" id="nuevo-fecha" name="cedula"
                                                                    required>
                                                                    
                                                            </div>

                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Tipo de Seguro</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="nuevo-tipo-seguro" required>
                                                                    <option value="16">Seleccione el Tipo de Seguro</option>
                                                                    <option value="1">General</option>
                                                                    <option value="2">Hijos dependiente menor 18 años</option>
                                                                    <option value="3">Conyugue</option>
                                                                    <option value="4">Campesino Familiar</option>
                                                                    <option value="5">Campesino Jefe Familia</option>
                                                                    <option value="6">Voluntario</option>
                                                                    <option value="7">Jubilado Campesino</option>
                                                                    <option value="8">Jubilado</option>
                                                                    <option value="9">Jubilado Riesgo Trabajo</option>
                                                                    <option value="10">Jubilado Hijo</option>
                                                                    <option value="11">Jubilado Conyuge</option>
                                                                    <option value="12">Montepio Horfandad</option>
                                                                    <option value="13">Montepio Viuda</option>
                                                                    <option value="14">Riesgo Trabajo</option>
                                                                    <option value="15">Particular</option>
                                                                    <option value="16">Ninguno</option>

                                                                </select>
                                                            </div>


                                                            <label for=""
                                                                class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">
                                                               
                                                            </div>
                                                            <label for=""
                                                                class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">
                                                               
                                                            </div>
                                                            <label for=""
                                                                class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">
                                                               
                                                            </div>
                                                            <label for=""
                                                                class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">
                                                               
                                                            </div>
                                                            <label for=""
                                                                class="col-sm-4 col-form-label"></label>
                                                            <div class="col-sm-8">
                                                               
                                                            </div>
                                                           
                                                        </div>

                                                        <div class="form-group row">
                                                           

                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Operadora</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="nuevo-operadora" required>
                                                                    <option value="1">Seleccione la Operadora</option>
                                                                    <option value="1">Claro</option>
                                                                    <option value="2">Movistar</option>
                                                                    <option value="3">CNT</option>
                                                                    <option value="4">Tuenti</option>
                                                                </select>
                                                            </div>




                                                           
                                                        </div>
                                                        <div class="form-group row">


                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Tipo de Cobertura</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                id="nuevo-cobertura" required>
                                                                    <option value="5">Seleccione la Cobertura</option>
                                                                    <option value="1">IESS</option>
                                                                    <option value="2">MSP</option>
                                                                    <option value="3">ISSFA</option>
                                                                    <option value="4">ISSPOL</option>
                                                                    <option value="5">Ninguna</option>

                                                                </select>
                                                            </div>

                                                            <label for="persona-nombres"
                                                                class="col-sm-4 col-form-label">Responsable del Paciente</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" value="Voluntario"
                                                                    class="form-control form-control-sm  danger  solo-texto"
                                                                    maxlength="150" minlength="4" id="nuevo-responsable"
                                                                    name="nombres" required>
                                                            </div>

                                                          
                                                                <div class="row col-md-12 d-none" id="dt-especialidad">

                                                              
                                                                <label for="persona-nombres"
                                                                    class="col-sm-4 col-form-label ">Especialidad</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control form-control-sm"
                                                                        id="nuevo-especialidad" required>
    
                                                                    </select>
                                                                </div>
                                                                </div> 
                                                          
                                                        


                                                        
                                                        </div>
                                                       


                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Direccion</label>
                                                    <textarea class="form-control form-control-sm " rows="3"
                                                        placeholder="Escribir su dirección"
                                                        id="nuevo-direccion"></textarea>
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
                                                                <label for="img-usuario">Imagen</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" name="img" id="img-usuario"
                                                                            class="custom-file-input" accept="image/*">
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
                                                                        <input type="file" name="img" id="img-cedula"
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
                                                

                                                </div>


                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        <a id="acordion-usuario" class="d-block w-100"
                                                            data-toggle="collapse" href="#collapseTwo">
                                                            Cargar Sello
                                                        </a>
                                                    </h4>
                                                </div>

                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="img-usuario-sello">Subir Sello</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" name="img" id="img-sello"
                                                                            class="custom-file-input"  accept="image/*">
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
                                <img id="imagen-usuario" src="<?=SERVIDOR?>resources/usuarios/default.jpg"
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


<script src="<?=BASE?>views/dist/js/scripts/registrar_usuario.js?ver=1.1.1.2"> </script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<!-- <script src="<?=BASE?>views/plugins/select2/js/select2.js"> </script>
<script src="<?=BASE?>views/plugins/select2/js/select2.full.js"> </script>
<script src="<?=BASE?>views/plugins/select2/js/select2.full.min.js"> </script>
<script src="<?=BASE?>views/plugins/select2/js/select2.min.js"> </script>
 -->
<!-- 
 -->