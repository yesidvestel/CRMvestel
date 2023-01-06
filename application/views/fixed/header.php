<?php 
$lista_permisos1=$this->db->query("SELECT permisos_usuario.id,permisos_usuario.id_modulo,permisos_usuario.is_checked,modulos.codigo FROM permisos_usuario inner join  modulos on modulos.id_modulo=permisos_usuario.id_modulo WHERE id_usuario=".$this->aauth->get_user()->id)->result();        
        $lista_permisos_us=array();
        foreach ($lista_permisos1 as $key => $value) {
            $lista_permisos_us[$value->codigo]=$value->is_checked;
        }
//$lista_permisos_us=$this->employee->get_modulos_cliente($this->aauth->get_user()->id);
//var_dump($lista_permisos_us['comp']);
?>


<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <?php if (@$title) {
        echo "<title>$title</title >";
    } else {
        echo "<title>Neo Billing</title >";
    }
    ?>
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/images/ico/favicon.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/images/ico/favicon.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/images/ico/favicon.png">
    <link rel="apple-touch-icon" sizes="152x1f52" href="<?php echo base_url(); ?>assets/images/ico/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/ico/favicon.png">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/ico/favicon.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/bootstrap.css'); ?>">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/icomoon.css'); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url('assets/' . LTR . '/bootstrap-extended.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/app.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/colors.css'); ?>">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url('assets/' . LTR . '/core/menu/menu-types/vertical-menu.css'); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url('assets/' . LTR . '/core/menu/menu-types/vertical-overlay-menu.css'); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url('assets/' . LTR . '/core/colors/palette-gradient.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/datepicker.min.css') . APPVER ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/jquery.dataTables.css') . APPVER ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/summernote-bs4.css') . APPVER; ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/select2.min.css') . APPVER; ?>">
    <script src="<?php echo base_url('assets/myjs/utiles_duber.js?') . time(); ?>"></script>
    <!-- END Page Level CSS-->
    <!-- DATATABLE CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/DataTables/Buttons-2.2.3/css/buttons.dataTables.min.css"/>
    <!--end  DATATABLE CSS-->
    <!-- BEGIN Custom CSS-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/style.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/custom.css') . APPVER; ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/style.css') . APPVER; ?>">
    <!-- END Custom CSS-->

    <script src="<?php echo base_url(); ?>assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>


    <script src="<?php echo base_url(); ?>assets/portjs/raphael.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/portjs/morris.min.js" type="text/javascript"></script>


    <script src="<?php echo base_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo base_url('assets/myjs/summernote-bs4.min.js') . APPVER; ?>"></script>
    <script src="<?php echo base_url('assets/myjs/select2.min.js') . APPVER; ?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>


    <script type="text/javascript">var baseurl = '<?php echo base_url() ?>';</script>

</head>
<body data-open="click" data-menu="vertical-menu" data-col="2-columns"
      class="vertical-layout vertical-menu 2-columns  fixed-navbar"><span id="hdata"
                                                                          data-df="<?php echo $this->config->item('dformat2'); ?>"
                                                                          data-curr="<?php echo $this->config->item('currency'); ?>"></span>

<!-- navbar-fixed-top-->
<nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav">
				
                <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a>
                </li>
                <li class="nav-item"><a href="<?php echo base_url() ?>dashboard/" class="navbar-brand nav-link"><img
                                alt="branding logo" src="<?php echo base_url(); ?>userfiles/theme/logo-header.png"
                                data-expand="<?php echo base_url(); ?>userfiles/theme/logo-header.png"
                                data-collapse="<?php echo base_url(); ?>assets/images/logo/logo-80x80.png"
                              ></a></li>
                <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile"
                                                                    class="nav-link open-navbar-container"><i
                                class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
				
            </ul>
        </div>
        <div class="navbar-container content container-fluid">
            <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                <ul class="nav navbar-nav">
                    <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i
                                    class="icon-menu5"> </i></a></li>
                    <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i
                                    class="icon icon-expand2"></i></a></li>
                    <li class="nav-item "><input type="text" placeholder="<?php echo $this->lang->line('Search Customer') ?>" id="head-customerbox" class="nav-link menu-search form-control round"/></li>
                </ul>
                <div id="head-customerbox-result" class="dropdown dropdown-notification"></div>
                <ul class="nav navbar-nav float-xs-right">
                    <li class="nav-item"><a id="show_notify_1" href="#" class="nav-link nav-link-label"><i class=" icon-windows"></i></a></li>
                    <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown"
                                                                           class="nav-link nav-link-label"><i
                                    class="ficon icon-bell4"></i><span
                                    class="tag tag-pill tag-default tag-danger tag-default tag-up"
                                    id="taskcount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Pending Tasks') ?></span>
                                </h6>
                            </li>
                            <li class="list-group scrollable-container" id="tasklist"></li>
                            <li class="dropdown-menu-footer"><a href="<?php echo base_url('manager/todo') ?>"
                                                                class="dropdown-item text-muted text-xs-center"><?php echo $this->lang->line('Manage tasks') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown"
                                                                           class="nav-link nav-link-label"><i
                                    class="ficon icon-mail6"></i><span
                                    class="tag tag-pill tag-default tag-info tag-default tag-up"><?php echo $this->aauth->count_unread_pms() ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span>
                                </h6>
                            </li>
                            <li class="list-group scrollable-container">


                                <?php $list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);

                                foreach ($list_pm as $row) {

                                    echo '<a href="' . base_url('messages/view?id=' . $row->pid) . '" class="list-group-item">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="' . base_url('userfiles/employee/' . $row->picture) . '"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row->name . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">' . $row->{'date_sent'} . '</time></small>
                        </div>
                      </div></a>';
                                } ?>

                            </li>
                            <li class="dropdown-menu-footer"><a href="<?php echo base_url('messages') ?>"
                                                                class="dropdown-item text-muted text-xs-center"><?php echo $this->lang->line('Read all messages') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item"><a href="#" data-toggle="dropdown"
                                                                   class="dropdown-toggle nav-link dropdown-user-link"><span
                                    class="avatar avatar-online"><img
                                        src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>"
                                        alt="avatar"><i></i></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a href="<?php echo base_url(); ?>user/profile"
                                                                          class="dropdown-item"><i
                                        class="icon-head"></i><?php echo $this->lang->line('Profile') ?></a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url('user/logout'); ?>" class="dropdown-item"><i
                                        class="icon-power3"></i> <?php echo $this->lang->line('Logout') ?></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->


<!-- main menu-->
<div data-scroll-to-active="true" class="main-menu menu-static menu-dark menu-accordion menu-shadow" id="side">
    <!-- main menu header-->
    <div class="main-menu-header">
        <div>
            <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle "
                                 src="<?php echo base_url('userfiles/employee/' . $this->aauth->get_user()->picture) ?>">
                             </span>
                <a data-toggle="dropdown" class="dropdown-toggle block" href="#" aria-expanded="false">
                    <span class="clear white">  <span
                                class="text-xs"><?php echo user_role($this->aauth->get_user()->roleid); ?><b
                                    class="caret"></b></span> </span> </a>
                <ul class="dropdown-menu animated m-t-xs">
                    <li>
                        <a href="<?php echo base_url() . 'user/profile">&nbsp;(' . $this->aauth->get_user()->username; ?>)</a></li>

                      <li class=" divider">
                    </li>
                    <li>
                        <a href="<?php echo base_url('user/logout'); ?>">&nbsp;<?php echo $this->lang->line('Logout'); ?></a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <!-- / main menu header-->
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">

            <li class="nav-item <?php if ($this->uri->segment(1) == "dashboard") {
                echo 'active';
            } ?>">
                <a href="<?php echo base_url(); ?>dashboard/"> <i class="icon-dashboard"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Dashboard') ?></span></a>
            </li>
			<!--- HEAD ----->
            <?php if ($this->aauth->get_user()->roleid == 5) { ?>
                <li class="navigation-header"><span
                            data-i18n="nav.category.support">Cobranza</span><i
                            data-toggle="tooltip"
                            data-placement="right"
                            data-original-title="Sales"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "invoices" OR $this->uri->segment(1) == "quote") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-plus"></i> <span
                                class="menu-title"><?php echo $this->lang->line('sales') ?>
						
						<!-- MENU FACTURACION-->
						
                    <i class="icon-arrow"></i></span></a>
                    <ul class="menu-content">
						<li>
                            <a href="<?php echo base_url(); ?>invoices/apertura">Apertura</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices/create"><?php echo $this->lang->line('New Invoice'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices"><?php echo $this->lang->line('Manage Invoices'); ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>quote"><?php echo $this->lang->line('Manage Quotes'); ?></a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>reports/cierre">Cierre</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices/generar_facturas">Generar Facturas</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>facturasElectronicas/generar_facturas_electronicas_multiples">Facturas Electronicas M</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices/notas">Notas Credito/Debito</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "rec_invoices") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-android-calendar"></i> <span
                                class="menu-title"><?php echo $this->lang->line('Reccuring Sales') ?><i
                                    class="icon-arrow"></i></span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>rec_invoices/dashboard"><?php echo $this->lang->line('Dashboard'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>rec_invoices/create"><?php echo $this->lang->line('New Invoice'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>rec_invoices"><?php echo $this->lang->line('Manage Invoices') ?></a>
                        </li>

                    </ul>
                </li>

				<!--- MENU INVENTARIOS--->
			
                <li class="navigation-header"><span><?php echo $this->lang->line('Stock') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Stock"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
				<li class="nav-item has-sub <?php if ($this->uri->segment(1) == "equipos") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-wifi3"></i><span
                                class="menu-title"><?php echo $this->lang->line('') ?>Redes</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<li>
                            <a href="<?php echo base_url(); ?>products/equipoadd"><?php echo $this->lang->line('') ?>Ingreso de Equipo</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>products/equipos"><?php echo $this->lang->line('') ?>Administrar equipos</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>productcategory/almacen">Bodega equipos</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>redes/sedes">Conexiones</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>redes/conexionlist">Administrar Conexion</a>
                        </li>
					</ul>
				</li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "products") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-truck2"></i><span
                                class="menu-title"><?php echo $this->lang->line('') ?>Inventarios</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>products/add"><?php echo $this->lang->line('') ?>Ingreso de material</a>
                        </li>
						
                        <li>
                            <a href="<?php echo base_url(); ?>products"><?php echo $this->lang->line('') ?>Administrar material</a>
                        </li>
						
                        <li>
                            <a href="<?php echo base_url(); ?>productcategory"><?php echo $this->lang->line('') ?>Categoria de material</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>productcategory/warehouse"><?php echo $this->lang->line('Warehouses') ?></a>
                        </li>
						
                        <li>
                            <a href="<?php echo base_url(); ?>products/stock_transfer"><?php echo $this->lang->line('') ?>Traspasos</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>products/historial_inv"><?php echo $this->lang->line('') ?>Historial</a>
                        </li>
                    </ul>
                </li>
				<!---ORDENES DE SERVICIOS --->
			
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "purchase") {
                    echo ' open';
                } ?>">
					
					
                    <a href=""> <i class="icon-file"></i><span
                                class="menu-title"> <?php echo $this->lang->line('') ?>Ordenes </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>purchase/create"><?php echo $this->lang->line('New Order') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>purchase">Adm. Ordenes de compra<?php echo $this->lang->line('') ?></a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>purchase/orden_servicio">Adm. Ordenes de servicio<?php echo $this->lang->line('') ?></a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>purchase/historial_ord">Historial<?php echo $this->lang->line('') ?></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "stockreturn") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-share-square-o"></i> <span
                                class="menu-title"><?php echo $this->lang->line('Stock Return') ?>
                            <i
                                    class="icon-arrow"></i></span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>stockreturn/create"><?php echo $this->lang->line('Add new'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>stockreturn"><?php echo $this->lang->line('Records'); ?></a>
                        </li>

                    </ul>
                </li>
				 <!--- MENU CRM--->
			
                <li class="navigation-header"><span><?php echo $this->lang->line('CRM') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="CRM"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "customers") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-group"></i><span
                                class="menu-title"> <?php echo $this->lang->line('') ?>Usuarios</span><i
                                class="fa arrow"></i> </a>
					<!---ADMINISTRADOR DE USUARIOS--->
					
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>customers/create"><?php echo $this->lang->line('') ?>Nuevo Usuario</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>customers"><?php echo $this->lang->line('') ?>Administrar Usuarios</a>
                        <li>
                            <a href="<?php echo base_url(); ?>clientgroup"><?php echo $this->lang->line('Manage Groups') ?></a>
                        </li>
                    </ul>
                </li>
				<!--- SOPORTE TECNICO --->
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "tickets") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-ticket"></i><span
                                class="menu-title"><?php echo $this->lang->line('Support Tickets') ?></span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<li>
                            <a href="<?php echo base_url(); ?>quote/create"><?php echo $this->lang->line(''); ?>Nuevo ticket</a>
                        </li>                        
                        <li>
                            <a href="<?php echo base_url(); ?>tickets"><?php echo $this->lang->line('Manage Tickets') ?></a>
                        </li>
						


                    </ul>
                </li>
				<!--- moviles --->
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "moviles") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-sitemap"></i><span
                                class="menu-title">Moviles</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>moviles/create"><?php echo $this->lang->line(''); ?>Nueva movil</a>
                        </li>                        
                        <li>
                            <a href="<?php echo base_url(); ?>moviles">Administrar Moviles</a>
                        </li>


                    </ul>
                </li>
				<!--- PROVEDORES--->
			
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "supplier") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-ios-people"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Suppliers') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>supplier/create"><?php echo $this->lang->line('New Supplier') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>supplier"><?php echo $this->lang->line('') ?>Proveedores de Productos</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>supplier/pro_servicios"><?php echo $this->lang->line('') ?>Proveedores de Servicios</a>
                        </li>
                    </ul>
                </li>
				<!--- ENCUENTAS --->
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "encuesta") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-android-clipboard"></i><span
                                class="menu-title">Encuestas</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<li>
                            <a href="<?php echo base_url(); ?>llamadas/list_llamadas"><?php echo $this->lang->line(''); ?>Lista de llamadas</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>llamadas/list_compromisos"><?php echo $this->lang->line(''); ?>Lista de Acuerdos</a>
                        </li> 
						<li>
                            <a href="<?php echo base_url(); ?>encuesta/create"><?php echo $this->lang->line(''); ?>Nueva Encuenta</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>encuesta/index"><?php echo $this->lang->line('') ?>Lista Encuestas</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>encuesta/newats"><?php echo $this->lang->line(''); ?>Nueva ATS</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>encuesta/listats"><?php echo $this->lang->line(''); ?>Lista de ATS</a>
                        </li>
                        
                    </ul>
                </li>
                <!---------------- GESTION DE PROYECTOS ----------------->
                <li class="navigation-header"><span><?php echo $this->lang->line('Project') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Balance"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "projects") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-file"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Project Management') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>projects/addproject"><?php echo $this->lang->line('New Project') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('Manage Projects') ?></a>
                        </li>
                    </ul>
                </li>
			    
			    <!--- TAREAS---->
			
                <li><a href="<?php echo base_url(); ?>tools/todo"><i class="icon-android-done-all"></i><span
                                class="menu-title"> <?php echo $this->lang->line('') ?>Listado de Tareas</span></a></li>
			
                <!---------------- end project ----------------->
                <li class="navigation-header"><span><?php echo $this->lang->line('Balance') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Balance"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "accounts") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-bank"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Accounts') ?></span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>accounts"><?php echo $this->lang->line('Manage Accounts') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>accounts/add"><?php echo $this->lang->line('New Account') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>accounts/balancesheet"><?php echo $this->lang->line('BalanceSheet') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/accountstatement"><?php echo $this->lang->line('Account Statements') ?></a>
                        </li>

                    </ul>
                </li>
						<!--- TESORERIA--->
			
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "transactions") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-exchange"></i><span
                                class="menu-title"> <?php echo $this->lang->line('') ?>Tesoreria</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>transactions"><?php echo $this->lang->line('View Transactions') ?></a>
                        </li>
                         <li>
                            <a href="<?php echo base_url(); ?>transactions/anulaciones"><?php echo $this->lang->line('View Anulations') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/add"><?php echo $this->lang->line('New Transaction') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/transfer"><?php echo $this->lang->line('New Transfer') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/income"><?php echo $this->lang->line('Income'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/expense"><?php echo $this->lang->line('Expense') ?></a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>transactions/transferencia">Transferencias</a>
                        </li>

                    </ul>
                </li>

                <li class="navigation-header"><span><?php echo $this->lang->line('Miscellaneous') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Miscellaneous"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>

					<!--- DATOS Y REPORTES--->
			
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "reports") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-file-archive-o"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Data & Reports') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>reports/statistics_services1">Estadisticas Servicios</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/statistics"><?php echo $this->lang->line('Statistics') ?></a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>reports/metas"><?php echo $this->lang->line('') ?>Metas</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/accountstatement"><?php echo $this->lang->line('Account Statements')
								
								
								
								?></a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>reports/filreptec">Reporte Tecnicos</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/customerstatement"><?php echo $this->lang->line('Customer') . ' ' . $this->lang->line('Account Statements') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/supplierstatement"><?php echo $this->lang->line('Supplier') . ' ' . $this->lang->line('Account Statements') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/incomestatement"><?php echo $this->lang->line('Calculate Income'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/expensestatement"><?php echo $this->lang->line('Calculate Expenses') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/customerviewstatement"><?php echo $this->lang->line('Clients Transactions') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/taxstatement"><?php echo $this->lang->line('TAX').' '.$this->lang->line('Statements'); ?> </a>
                        </li>
                        <?php if ($this->aauth->get_user()->roleid >= 5) {?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/historial_crm">Historial CRM</a>
                        </li>
                        <?php } ?>

                    </ul>
                </li>
						<!--- HERRAMIENTAS---->
			

                <li><a href="<?php echo base_url(); ?>tools/notes"><i class="icon-android-clipboard"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Notes') ?></span></a></li>


                <li><a href="<?php echo base_url(); ?>events"><i class="icon-calendar2"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Calendar') ?></span></a></li>
			
                <li><a href="<?php echo base_url(); ?>tools/documents"><i class="icon-android-download"></i><span
                                class="menu-title"><?php echo $this->lang->line('Documents') ?></span></a></li>

			<!--- menu configuraciones------->
			

                <li class="navigation-header"><span>Configure</span><i data-toggle="tooltip" data-placement="right"
                                                                       data-original-title="Configure"
                                                                       class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "settings") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-cog"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Settings') ?></span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>settings/company"><?php echo $this->lang->line('Company'); ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>settings/billing"><?php echo $this->lang->line('Billing') ?>
                                & Language</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/currency"><?php echo $this->lang->line('Currency') ?></a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>settings/asignacion"><?php echo $this->lang->line('') ?>Asignaciones</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>settings/promociones"><?php echo $this->lang->line('') ?>Promociones</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/dtformat"><?php echo $this->lang->line('Date & Time Format') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>transactions/categories"><?php echo $this->lang->line('Transaction Categories') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>tools/setgoals"><?php echo $this->lang->line('Set Goals') ?></a>
                        </li>
                        <li><a href="<?php echo base_url(); ?>restapi"><?php echo $this->lang->line('REST API') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/email"><?php echo $this->lang->line('Email Config') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/billing_terms"><?php echo $this->lang->line('Billing Terms') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>cronjob"><?php echo $this->lang->line('Automatic Corn Job') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/recaptcha"><?php echo $this->lang->line('Security') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/theme"><?php echo $this->lang->line('Theme') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/tickets"><?php echo $this->lang->line('Support Tickets') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/about"><?php echo $this->lang->line('About') ?></a>
                        </li>
                          <li>
                            <a href="<?php echo base_url(); ?>webupdate">Update</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>clientgroup/apis_vars_edit">Editar Variables Apis</a>
                        </li>
                        <!--slbs-->


                    </ul>
                </li>
                <li><a href="<?php echo base_url(); ?>employee"><i class="icon-users"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Employees') ?></span></a>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "paymentgateways") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-cc"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Payment Settings') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/settings"><?php echo $this->lang->line('Payment Settings') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways"><?php echo $this->lang->line('Payment Gateways') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/currencies"><?php echo $this->lang->line('Payment Currencies') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/exchange"><?php echo $this->lang->line('Currency Exchange') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/bank_accounts"><?php echo $this->lang->line('Bank Accounts') ?></a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "plugins") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-anchor"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Plugins') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/recaptcha">reCaptcha Security</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/shortner">URL Shortener</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/twilio">Twilio SMS</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/exchange">Currency Exchange API</a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "templates") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-table3"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Templates') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>templates/email"><?php echo $this->lang->line('Email') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>templates/sms">SMS</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/theme"><?php echo $this->lang->line('Theme') ?></a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>templates/local"><?php echo $this->lang->line('') ?>Localizaciones</a>
                        </li>

                    </ul>
                </li>
                <li class="navigation-header"><span><?php echo $this->lang->line('Backup & Export').'-'.$this->lang->line('Import'); ?><i
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="Export"
                                class="icon-ellipsis icon-ellipsis"></i>
                </li>


                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "export") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-database"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Export Data') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>export/crm"><?php echo $this->lang->line('Export People Data'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/transactions"><?php echo $this->lang->line('Export Transactions'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/products"><?php echo $this->lang->line('Export Products'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/account"><?php echo $this->lang->line('Account Statements') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/dbexport"><?php echo $this->lang->line('Database Backup'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/taxstatement"><?php echo $this->lang->line('TAX'); ?> Statements</a>
                        </li>



                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "import") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-road2"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Import') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>import/products"><?php echo $this->lang->line('Import Products'); ?></a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>importequipo/equipos"><?php echo $this->lang->line(''); ?>Importar Equipos</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>importequipo/usuarios"><?php echo $this->lang->line(''); ?>Importar Usuarios</a>
                        </li>
						<li>
                            <a href="<?php echo base_url(); ?>importequipo/facturas"><?php echo $this->lang->line(''); ?>Importar facturas</a>
                        </li>
					</ul>
                </li>
            <?php } ?>
			
			<!---------- MENU ADMINISTRACION----->
			
			<!--- HEAD ----->
            <?php if ($this->aauth->get_user()->roleid <= 4) { ?>
                <?php 

//$lista_permisos_us=$this->employee->get_modulos_cliente($this->aauth->get_user()->id); ?>
				<?php if ($lista_permisos_us['co'] != null) { ?>
                <li class="navigation-header"><span
                            data-i18n="nav.category.support">Cobranza</span><i
                            data-toggle="tooltip"
                            data-placement="right"
                            data-original-title="Sales"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
				
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "invoices" OR $this->uri->segment(1) == "quote") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-plus"></i> <span
                                class="menu-title"><?php echo $this->lang->line('sales') ?>
						
						<!-- MENU FACTURACION-->
						
                    <i class="icon-arrow"></i></span></a>
					
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['coape'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>invoices/apertura">Apertura</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['conue'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices/create"><?php echo $this->lang->line('New Invoice'); ?></a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['coadm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices"><?php echo $this->lang->line('Manage Invoices'); ?></a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['cocie'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>reports/cierre">Cierre</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['cofa'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices/generar_facturas">Generar Facturas</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['cofae'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>facturasElectronicas/generar_facturas_electronicas_multiples">Facturas Electronicas M</a>
                        </li>
						
                        <?php } if ($lista_permisos_us['conotas'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices/notas">Notas Credito/Debito</a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
				<!--- MENU REDES--->
				<?php if ($lista_permisos_us['red'] != null) { ?>
                <li class="navigation-header"><span><?php echo $this->lang->line('Stock') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Stock"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
				<li class="nav-item has-sub <?php if ($this->uri->segment(1) == "equipos") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-wifi3"></i><span
                                class="menu-title"><?php echo $this->lang->line('') ?>Redes</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['reding'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>products/equipoadd"><?php echo $this->lang->line('') ?>Ingreso de Equipo</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['redadm'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>products/equipos"><?php echo $this->lang->line('') ?>Administrar equipos</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['redbod'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>productcategory/almacen">Bodega equipos</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['redcon'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>redes/sedes">Conexiones</a>
                        </li>
						<?php } if ($lista_permisos_us['redadmcon'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>redes/conexionlist">Administrar Conexion</a>
                        </li>
						<?php } ?>
					</ul>
				</li>
				<?php } ?>
				<!--- MENU INVENTARIOS--->
				<?php if ($lista_permisos_us['inv'] != null) { ?>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "products") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-truck2"></i><span
                                class="menu-title"><?php echo $this->lang->line('') ?>Inventarios</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['inving'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>products/add"><?php echo $this->lang->line('') ?>Ingreso de material</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['invadm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>products"><?php echo $this->lang->line('') ?>Administrar material</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['invcat'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>productcategory"><?php echo $this->lang->line('') ?>Categoria de material</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['invalm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>productcategory/warehouse"><?php echo $this->lang->line('Warehouses') ?></a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['invtrs'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>products/stock_transfer"><?php echo $this->lang->line('') ?>Traspasos</a>
                        </li>
						<?php } if ($lista_permisos_us['inhis'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>products/historial_inv"><?php echo $this->lang->line('') ?>Historial</a>
                        </li>
						<?php } ?>
                    </ul>
                </li>
				<?php } ?>
				<!---ORDENES DE SERVICIOS --->
				<?php if ($lista_permisos_us['com'] != null) { ?>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "purchase") {
                    echo ' open';
                } ?>">
					
					
                    <a href=""> <i class="icon-file"></i><span
                                class="menu-title"> <?php echo $this->lang->line('') ?>Ordenes </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['comnue'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>purchase/create"><?php echo $this->lang->line('New Order') ?></a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['comadm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>purchase">Adm. Ordenes de compra<?php echo $this->lang->line('') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['comadmser'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>purchase/orden_servicio">Adm. Ordenes de servicio<?php echo $this->lang->line('') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['comhis'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>purchase/historial_ord">Historial<?php echo $this->lang->line('') ?></a>
                        </li>
						<?php } ?>
						
                    </ul>
                </li>
				<?php } ?>
				 <!--- MENU CRM--->
				<?php if ($lista_permisos_us['us'] != null) { ?>
                <li class="navigation-header"><span><?php echo $this->lang->line('CRM') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="CRM"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "customers") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-group"></i><span
                                class="menu-title"> <?php echo $this->lang->line('') ?>Usuarios</span><i
                                class="fa arrow"></i> </a>
					<!---ADMINISTRADOR DE USUARIOS--->
					
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['usnue'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>customers/create"><?php echo $this->lang->line('') ?>Nuevo Usuario</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['usadm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>customers"><?php echo $this->lang->line('') ?>Administrar Usuarios</a>
						</li>
						<?php } ?>
						<?php if ($lista_permisos_us['usgru'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>clientgroup"><?php echo $this->lang->line('Manage Groups') ?></a>
                        </li>
						<?php } ?>
                    </ul>
                </li>
				<?php } ?>
				<!--- SOPORTE TECNICO --->
				<?php if ($lista_permisos_us['tik'] != null) { ?>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "tickets") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-ticket"></i><span
                                class="menu-title"><?php echo $this->lang->line('Support Tickets') ?></span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['tiknue'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>quote/create"><?php echo $this->lang->line(''); ?>Nuevo ticket</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['tikadm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>tickets"><?php echo $this->lang->line('Manage Tickets') ?></a>
                        </li>
						<?php } ?>
                    </ul>
                </li>
				<?php } ?>
				<!--- moviles --->
				<?php if ($lista_permisos_us['mo'] != null) { ?>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "moviles") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-sitemap"></i><span
                                class="menu-title">Moviles</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['monue'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>moviles/create"><?php echo $this->lang->line(''); ?>Nueva movil</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['moadm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>moviles">Administrar Moviles</a>
                        </li>
						<?php } ?>

                    </ul>
                </li>
				<?php } ?>
				<!--- PROVEDORES--->
				<?php if ($lista_permisos_us['pro'] != null) { ?>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "supplier") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-ios-people"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Suppliers') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['pronue'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>supplier/create"><?php echo $this->lang->line('New Supplier') ?></a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['proadm'] != null) { ?>
                         <li>
                            <a href="<?php echo base_url(); ?>supplier"><?php echo $this->lang->line('') ?>Proveedores de Productos</a>
                        </li>
						<?php } if ($lista_permisos_us['proser'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>supplier/pro_servicios"><?php echo $this->lang->line('') ?>Proveedores de Servicios</a>
                        </li>
						<?php } ?>
                    </ul>
                </li>
				<?php } ?>
				<!--- ENCUENTAS --->
				<?php if ($lista_permisos_us['enc'] != null) { ?>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "encuesta") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-android-clipboard"></i><span
                                class="menu-title">Encuestas</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['encllam'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>llamadas/list_llamadas"><?php echo $this->lang->line(''); ?>Lista de llamadas</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['enclisacu'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>llamadas/list_compromisos"><?php echo $this->lang->line(''); ?>Lista de Acuerdos</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['encnue'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>encuesta/create"><?php echo $this->lang->line(''); ?>Nueva Encuenta</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['encenc'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>encuesta/index"><?php echo $this->lang->line('') ?>Lista Encuestas</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['encats'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>encuesta/newats"><?php echo $this->lang->line(''); ?>Nueva ATS</a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['encatslis'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>encuesta/listats"><?php echo $this->lang->line(''); ?>Lista de ATS</a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
				<?php } ?>
                <!---------------- GESTION DE PROYECTOS ----------------->
				<?php if ($lista_permisos_us['proy'] != null) { ?>
                <li class="navigation-header"><span><?php echo $this->lang->line('Project') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Balance"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "projects") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-file"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Project Management') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['proynue'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>projects/addproject"><?php echo $this->lang->line('New Project') ?></a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['proyadm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('Manage Projects') ?></a>
                        </li>
						<?php } ?>
                    </ul>
                </li>
			    <?php } ?>
			    <!--- TAREAS---->
				<?php if ($lista_permisos_us['tar'] != null) { ?>
                <li><a href="<?php echo base_url(); ?>tools/todo"><i class="icon-android-done-all"></i><span
                                class="menu-title"> <?php echo $this->lang->line('') ?>Listado de Tareas</span></a></li>
				<?php } ?>
                <!---------------- end project ----------------->
				<?php if ($lista_permisos_us['cuen'] != null) { ?>
                <li class="navigation-header"><span><?php echo $this->lang->line('Balance') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Balance"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "accounts") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-bank"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Accounts') ?></span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['cuenadm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>accounts"><?php echo $this->lang->line('Manage Accounts') ?></a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['cuennue'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>accounts/add"><?php echo $this->lang->line('New Account') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['cuenbal'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>accounts/balancesheet"><?php echo $this->lang->line('BalanceSheet') ?></a>
                        </li>
						<?php } ?>
						<?php if ($lista_permisos_us['cuendec'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/accountstatement"><?php echo $this->lang->line('Account Statements') ?></a>
                        </li>
						<?php } ?>
                    </ul>
                </li>
				<?php } ?>
						<!--- TESORERIA--->
				<?php if ($lista_permisos_us['tes'] != null) { ?>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "transactions") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-exchange"></i><span
                                class="menu-title"> <?php echo $this->lang->line('') ?>Tesoreria</span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['testran'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions"><?php echo $this->lang->line('View Transactions') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['tesanu'] != null) { ?>
                         <li>
                            <a href="<?php echo base_url(); ?>transactions/anulaciones"><?php echo $this->lang->line('View Anulations') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['tesnuetransac'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/add"><?php echo $this->lang->line('New Transaction') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['tesnuetransfer'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/transfer"><?php echo $this->lang->line('New Transfer') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['tesing'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/income"><?php echo $this->lang->line('Income'); ?></a>
                        </li>
						<?php } if ($lista_permisos_us['tesgas'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/expense"><?php echo $this->lang->line('Expense') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['testransfer'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>transactions/transferencia">Transferencias</a>
                        </li>
						<?php } ?>
                    </ul>
                </li>
				<?php } ?>
				<!--- DATOS Y REPORTES--->
				<?php if ($lista_permisos_us['dat'] != null) { ?>
                <li class="navigation-header"><span><?php echo $this->lang->line('Miscellaneous') ?></span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Miscellaneous"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>

					
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "reports") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-file-archive-o"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Data & Reports') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['datservicios'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>reports/statistics_services1">Estadisticas Servicios</a>
                        </li>
						<?php } if ($lista_permisos_us['datest'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/statistics"><?php echo $this->lang->line('Statistics') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['datmet'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>reports/metas"><?php echo $this->lang->line('') ?>Metas</a>
                        </li>
						<?php } if ($lista_permisos_us['datdec'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/accountstatement"><?php echo $this->lang->line('Account Statements')?></a>
                        </li>
						<?php } if ($lista_permisos_us['datrep'] != null) { ?>
						<li>
                            <a href="<?php echo base_url(); ?>reports/filreptec">Reporte Tecnicos</a>
                        </li>
						<?php } if ($lista_permisos_us['datusu']!= '') { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/customerstatement"><?php echo $this->lang->line('Customer') . ' ' . $this->lang->line('Account Statements') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['datpro'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/supplierstatement"><?php echo $this->lang->line('Supplier') . ' ' . $this->lang->line('Account Statements') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['dating'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/incomestatement"><?php echo $this->lang->line('Calculate Income'); ?></a>
                        </li>
						<?php } if ($lista_permisos_us['datgas'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/expensestatement"><?php echo $this->lang->line('Calculate Expenses') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['dattrans'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/customerviewstatement"><?php echo $this->lang->line('Clients Transactions') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['datimp'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/taxstatement"><?php echo $this->lang->line('TAX').' '.$this->lang->line('Statements'); ?> </a>
                        </li>
						
                        <?php } if ($lista_permisos_us['dathistorial'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/historial_crm">Historial CRM</a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
				<?php } ?>
						<!--- HERRAMIENTAS---->
				
				<?php if ($lista_permisos_us['not'] != null) { ?>
                <li><a href="<?php echo base_url(); ?>tools/notes"><i class="icon-android-clipboard"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Notes') ?></span></a></li>
				<?php } ?>
				<?php if ($lista_permisos_us['cal'] != null) { ?>
                <li><a href="<?php echo base_url(); ?>events"><i class="icon-calendar2"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Calendar') ?></span></a></li>
				<?php } ?>
				<?php if ($lista_permisos_us['doct'] != null) { ?>
                <li><a href="<?php echo base_url(); ?>tools/documents"><i class="icon-android-download"></i><span
                                class="menu-title"><?php echo $this->lang->line('Documents') ?></span></a></li>
				<?php } ?>
			<!--- menu configuraciones------->
			
				<?php if ($lista_permisos_us['conf'] != null) { ?>
                <li class="navigation-header"><span>Configure</span><i data-toggle="tooltip" data-placement="right"
                                                                       data-original-title="Configure"
                                                                       class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "settings") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-cog"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Settings') ?></span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['confemp'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/company"><?php echo $this->lang->line('Company'); ?></a>
                        </li>
						<?php } if ($lista_permisos_us['conffa'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/billing"><?php echo $this->lang->line('Billing') ?>
                                & Language</a>
                        </li>
						<?php } if ($lista_permisos_us['confmon'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/currency"><?php echo $this->lang->line('Currency') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['conffec'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/dtformat"><?php echo $this->lang->line('Date & Time Format') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['confcat'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/categories"><?php echo $this->lang->line('Transaction Categories') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['confmet'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>tools/setgoals"><?php echo $this->lang->line('Set Goals') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['confrest'] != null) { ?>
                        <li>
							<a href="<?php echo base_url(); ?>restapi"><?php echo $this->lang->line('REST API') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['confcorr'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/email"><?php echo $this->lang->line('Email Config') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['confterm'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/billing_terms"><?php echo $this->lang->line('Billing Terms') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['confaut'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>cronjob"><?php echo $this->lang->line('Automatic Corn Job') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['confseg'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/recaptcha"><?php echo $this->lang->line('Security') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['conftem'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/theme"><?php echo $this->lang->line('Theme') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['confsop'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/tickets"><?php echo $this->lang->line('Support Tickets') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['conface'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/about"><?php echo $this->lang->line('About') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['confupt'] != null) { ?>
                          <li>
                            <a href="<?php echo base_url(); ?>webupdate">Update</a>
                        </li>
						<?php } if ($lista_permisos_us['confapi'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>clientgroup/apis_vars_edit">Editar Variables Apis</a>
                        </li>
                        <!--slbs-->
						<?php } ?>

                    </ul>
                </li>
				<?php } ?>
				<?php if ($lista_permisos_us['emp'] != null) { ?>
                <li><a href="<?php echo base_url(); ?>employee"><i class="icon-users"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Employees') ?></span></a>
                </li>
				<?php } ?>
				<?php if ($lista_permisos_us['pag'] != null) { ?>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "paymentgateways") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-cc"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Payment Settings') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['pagconf'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/settings"><?php echo $this->lang->line('Payment Settings') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['pagvia'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways"><?php echo $this->lang->line('Payment Gateways') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['pagmon'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/currencies"><?php echo $this->lang->line('Payment Currencies') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['pagcam'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/exchange"><?php echo $this->lang->line('Currency Exchange') ?></a>
                        </li>
						<?php } if ($lista_permisos_us['pagban'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/bank_accounts"><?php echo $this->lang->line('Bank Accounts') ?></a>
                        </li>
						<?php } ?>

                    </ul>
                </li>
				<?php } ?>
				<!---PLUGIN----->
				<?php if ($lista_permisos_us['comp'] != null) { ?>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "plugins") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-anchor"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Plugins') ?> </span><i
                                class="fa arrow"></i> </a>
                    <ul class="menu-content">
						<?php if ($lista_permisos_us['comprec'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/recaptcha">reCaptcha Security</a>
                        </li>
						<?php } if ($lista_permisos_us['compurl'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/shortner">URL Shortener</a>
                        </li>
						<?php } if ($lista_permisos_us['comptwi'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/twilio">Twilio SMS</a>
                        </li>
						<?php } if ($lista_permisos_us['compcurr'] != null) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/exchange">Currency Exchange API</a>
                        </li>
						<?php } ?>
                    </ul>
                </li>

            <?php } } ?>
			
        </ul>
		
		
    </div>
    <!-- /main menu content-->
    <!-- main menu footer-->
    <!-- include includes/menu-footer-->
    <!-- main menu footer-->
    <div id="rough"></div>
</div>
<!-- / main menu-->

<script type="text/javascript">
    var abcd=$( 'a[href*="'+baseurl+'settings/activate"]' );
    $(abcd[0]).parent().remove();
</script>