<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url ?>assets/img/apple-icon.png" />
        <link rel="icon" type="image/png" href="<?= base_url ?>assets/img/favicon.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>
            Portal Créditos - Leterago
        </title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <!-- CSS Files -->
        <link href="<?= base_url ?>assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="<?= base_url ?>assets/demo/demo.css" rel="stylesheet" />
        <!--   Core JS Files   -->
        <script src="<?= base_url ?>assets/js/core/jquery.min.js"></script>
        <script src="<?= base_url ?>assets/js/core/popper.min.js"></script>
        <script src="<?= base_url ?>assets/js/core/bootstrap-material-design.min.js"></script>
        <script src="<?= base_url ?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <!-- Plugin for the momentJs  -->
        <script src="<?= base_url ?>assets/js/plugins/moment.min.js"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="<?= base_url ?>assets/js/plugins/sweetalert2.js"></script>
        <!-- Forms Validations Plugin -->
        <script src="<?= base_url ?>assets/js/plugins/jquery.validate.min.js"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="<?= base_url ?>assets/js/plugins/jquery.bootstrap-wizard.js"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="<?= base_url ?>assets/js/plugins/bootstrap-selectpicker.js"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="<?= base_url ?>assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        <script src="<?= base_url ?>assets/js/plugins/jquery.dataTables.min.js"></script>
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="<?= base_url ?>assets/js/plugins/bootstrap-tagsinput.js"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="<?= base_url ?>assets/js/plugins/jasny-bootstrap.min.js"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="<?= base_url ?>assets/js/plugins/fullcalendar.min.js"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="<?= base_url ?>assets/js/plugins/nouislider.min.js"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="<?= base_url ?>assets/js/plugins/arrive.min.js"></script>
        <!-- Chartist JS -->
        <script src="<?= base_url ?>assets/js/plugins/chartist.min.js"></script>
        <!--  Notifications Plugin    -->
        <script src="<?= base_url ?>assets/js/plugins/bootstrap-notify.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="<?= base_url ?>assets/js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        <script src="<?= base_url ?>assets/demo/demo.js"></script>
        <!-- Mascara de entradas -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    </head>
    <body class="">       
        <div class="wrapper ">
            <div class="sidebar" data-color="white" data-background-color="black" data-image="<?= base_url ?>assets/img/sidebar-1.jpg">
                
                <div class="mlCargando">
                    <div class="divloader">
                        <div class="loader"></div>
                        <div class="sploader">Cargando...</div>
                    </div>
                    
                    
                </div>
                <style>
                
                    .mlCargando {
                        position: fixed;
                        z-index: 1051 !important;
                        left: 0px;
                        top: 0px;
                        width: 100%;
                        height: 100%;
                        background-color: #ACACAC;           
                        text-align: center;      
                        opacity: 0.5;                           
                    }
                    
                    .sploader {
                        font-weight: bold;
                        font-size: 25px;
                    }
                    
                    .divloader {
                      position: absolute;
                      left: 48%;
                      top: 48%;
                    }
                    
                    .loader {
                      border: 16px solid #f3f3f3; /* Light grey */
                      border-top: 16px solid #3498db; /* Blue */
                      border-radius: 50%;
                      width: 90px;
                      height: 90px;
                      animation: spin 1s linear infinite;
                    }

                    @keyframes spin {
                      0% { transform: rotate(0deg); }
                      100% { transform: rotate(360deg); }
                    }
                </style>
                