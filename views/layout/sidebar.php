<?php
ob_start();
?>
<div class="logo">
    <a href="<?= base_url ?>">
        <img class="img-fluid mx-auto d-block" src="<?= base_url ?>assets/img/logo.png" alt="IMA Logotipo" />
    </a>
</div>

<?php
$controller = $_GET['controller'];
$action = $_GET['action'];
$nombre_usuario = $_SESSION['leterago']["nombres"];
?>
<div class="sidebar-wrapper scrollbar">
    <div class="user">
        <div class="user-info">
            <?php if (isset($_SESSION['leterago'])): ?>  
                <a data-toggle="collapse" href="#collapseExample" class="username">
                    <span>
                        <?= $_SESSION['leterago']["nombres"]." ".$_SESSION['leterago']["apellidos"] ?>
                        <b class="caret"></b>
                    </span>
                </a>
            <?php else: ?>
                <a data-toggle="collapse" href="javascript:void(0)" class="username">
                    <span>
                        No esta loggeado {Usuario}
                    </span>
                </a>
            <?php endif; ?>            
            <div class="collapse" id="collapseExample">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#cambioClave" data-toggle="modal" data-target="#cambioClave">
                            <i class="material-icons">settings</i>
                            <span class="sidebar-normal"> Cambio Contraseña </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url ?>usuario/logout">
                            <i class="material-icons">exit_to_app</i>
                            <span class="sidebar-normal"> Cerrar Sesión </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <ul class="nav">
        <li class="nav-item <?php print $controller == "home" ? "active" : ""?> ">
            <a class="nav-link" href="<?= base_url ?>/home/index">
                <i class="material-icons">dashboard</i>
                <p> Tablero </p>
            </a>
        </li>
        
        <?php
        
        if( $_SESSION['leterago']['tipo'] == "CL" ) {
            ?>
            <li class="nav-item <?php print $controller == "credito" ? "active" : ""?>">
                <a class="nav-link" href="<?= base_url ?>credito/index">
                    <i class="material-icons">swap_horiz</i>
                    <p> Creditos </p>
                </a>
            </li>
            
            <li class="nav-item <?php print $controller == "cliente" ? "active" : ""?>">
                <a class="nav-link" href="<?= base_url ?>cliente/index">
                    <i class="material-icons">swap_horiz</i>
                    <p> Cliente </p>
                </a>
            </li>
            
            <?php
        }
        
        
        if( $_SESSION['leterago']['tipo'] != "CL" ) {
            
            if( $_SESSION['leterago']['tipo'] == "SA" ){
                ?>
                <li class="nav-item <?php print $controller == "home" ? "usuario" : ""?>">
                    <a class="nav-link collapsed" data-toggle="collapse" href="#paginasMantenimiento" aria-expanded="<?php print $controller == "usuario" ? "true" : ""?>">
                        <i class="material-icons">cached</i>
                        <p> Configuracion <b class="caret"></b></p>
                    </a>
                        
                                            
                    <div class="collapse  <?php print ( $controller == "usuario" || $controller == "perfil" ) ? "show" : ""?>" id="paginasMantenimiento" style="">
                        <ul class="nav">
                        
                            <li class="nav-item <?php print $controller == "usuario" ? "active" : ""?>">
                                <a class="nav-link" href="<?= base_url ?>usuario/index">
                                    <span class="sidebar-mini">US</span>
                                    <span class="sidebar-normal">Usuarios</span>
                                </a>
                            </li>
                        
                            <li class="nav-item <?php print $controller == "perfil" ? "active" : ""?>">
                                <a class="nav-link" href="<?= base_url ?>perfil/index">
                                    <span class="sidebar-mini">PE</span>
                                    <span class="sidebar-normal">Perfiles</span>
                                </a>
                            </li>
                        
                        </ul>
                            
                    </div>
                        
                </li>
                
                <?php
            }
            
            ?>
                
            <li class="nav-item <?php print $controller == "credito" ? "active" : ""?>">
                <a class="nav-link" href="<?= base_url ?>credito/index">
                    <i class="material-icons">swap_horiz</i>
                    <p> Creditos </p>
                </a>
            </li>
            
            <li class="nav-item <?php print $controller == "cliente" ? "active" : ""?>">
                <a class="nav-link" href="<?= base_url ?>cliente/index">
                    <i class="material-icons">swap_horiz</i>
                    <p> Clientes </p>
                </a>
            </li>
            
            
            <?php
        }
        
        ?>
        
            
    </ul>
                      
        </div>     
    </div>     
                    <div class="main-panel">
                        <!-- Navbar -->
                        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                            <div class="container-fluid">
                                <div class="navbar-wrapper">
                                    <div class="navbar-minimize">
                                        <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                                            <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                                            <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                                        </button>
                                    </div>
                                    <a class="navbar-brand" href="javascript:void(0)">
                                        <?php
                                        
                                        $strNombrePagina = "Home";
                                        if( $controller == "usuario" )$strNombrePagina = "Usuarios";    
                                        if( $controller == "perfil" )$strNombrePagina = "Perfiles";    
                                        if( $controller == "credito" )$strNombrePagina = "Crédito";    
                                        if( $controller == "cliente" )$strNombrePagina = "Clientes";    
                                        
                                        print($strNombrePagina);
                                        
                                        ?>
                                    </a>
                                </div>
                                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="navbar-toggler-icon icon-bar"></span>
                                    <span class="navbar-toggler-icon icon-bar"></span>
                                    <span class="navbar-toggler-icon icon-bar"></span>
                                </button>
                                <div class="collapse navbar-collapse justify-content-end">
                                </div>
                            </div>
                        </nav>
                        <!-- Modal para cambio de contraseña -->
                        <div class="modal fade" id="cambioClave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-small">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="font-weight: bold;">
                                            Cambio de Contraseña
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            <i class="material-icons">clear</i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="RegisterValidation" action="<?= base_url ?>usuario/cambioClave" method="POST">
                                            <div class="form-group">
                                                <label for="examplePassword" class="bmd-label-floating"> Contraseña *</label>
                                                <input type="password" class="form-control" id="clave" required="true" name="clave">
                                            </div>
                                            <div class="form-group">
                                                <label for="examplePassword1" class="bmd-label-floating"> Confirme Contraseña *</label>
                                                <input type="password" class="form-control" id="confirmar_clave" required="true" equalTo="#clave" name="confirmar_clave">
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-info">Confirmar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal cambio de contraseña -->
                        <script>
                            function setFormValidation(id) {
                                $(id).validate({
                                    highlight: function (element) {
                                        $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                                        $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
                                    },
                                    success: function (element) {
                                        $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                                        $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
                                    },
                                    errorPlacement: function (error, element) {
                                        $(element).closest('.form-group').append(error);
                                    },
                                });
                            }

                            $(document).ready(function () {
                                setFormValidation('#RegisterValidation');
                            });
                                      

                        </script>
                        <!-- End Navbar -->
                        <div class="content">
                            <div class="container-fluid" id="divContainerPrincipal">