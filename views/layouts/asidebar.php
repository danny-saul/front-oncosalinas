<!-- Main Sidebar Container -->
<aside class="main-sidebar bg-white text-dark elevation-2">
    <!-- Fondo blanco, texto oscuro -->
    <!-- Brand Logo -->
    <a  class="brand-link border-bottom pb-2 mb-2">
        <img src="<?= BASE ?>views/dist/img/oncosalinas.png" alt="Logo" class="brand-image img-circle elevation-2"
            style="opacity: .9">
    
        <span class="brand-text font-weight-light"><?= NOMBRE_EMPRESA ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom">
            <div class="image" id="sesion-img">
                <!-- Imagen de usuario dinámica -->
            </div>
            <div class="info">
                <a  class="d-block fw-bold text-dark" id="sesion-usuario"></a>
                <p class="text-muted small m-0" id="sesion-rol"></p>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" id="menu_rol" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Menú cargado dinámicamente con JS -->
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper -->
<div class="content-wrapper">


    <style>
        .main-sidebar {
            transition: all 0.3s ease-in-out;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        }

        .nav-sidebar .nav-link {
            color: #343a40;
            transition: background 0.2s ease;
        }

        .nav-sidebar .nav-link.active,
        .nav-sidebar .nav-link:hover {
            background-color: #f1f1f1;
            color: #007bff !important;
        }

        .nav-icon {
            color: #6c757d;
        }

        .brand-link {
            background-color: #fff !important;
        }

        /* Estilo neumórfico al hacer hover sobre el menú principal */
        .nav-sidebar .nav-item>.nav-link:hover {
            background: #e9f7fc !important;
            /* Azul muy clarito */
            color: #17a2b8 !important;
            border-left: 4px solid #17a2b8;
            box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.08),
                -2px -2px 6px rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        /* Icono y texto del menú principal */
        .nav-sidebar .nav-item>.nav-link:hover i,
        .nav-sidebar .nav-item>.nav-link:hover p {
            color: #17a2b8 !important;
        }

        /* Estilo neumórfico para submenús */
        .nav-treeview .nav-item>.nav-link:hover {
            background: #f0f4f7 !important;
            color: #007bff !important;
            border-left: 3px solid #007bff;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.06),
                -2px -2px 5px rgba(255, 255, 255, 0.7);
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
        }

        /* Icono y texto de los hijos */
        .nav-treeview .nav-item>.nav-link:hover i,
        .nav-treeview .nav-item>.nav-link:hover p {
            color: #007bff !important;
        }
    </style>