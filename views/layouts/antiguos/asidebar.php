
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" > <!-- style="background-color: steelblue;" -->
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="<?=BASE?>views/dist/img/CORSANO.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8 "  >
      <span class="brand-text font-weight-light"><i><?=NOMBRE_EMPRESA?></i></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image" id="sesion-img">
          <!-- <img src="views/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
         <b> <a href="#" class="d-block" id="sesion-usuario"></a>
          <p class="text-white m-0" id="sesion-rol"></p></b>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="menu_rol">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pagina 1</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pagina 2</p>
                </a>
              </li>
            </ul>
          </li> -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
 <!--  <script src="views/dist/js/scripts/midleware.js"></script> -->