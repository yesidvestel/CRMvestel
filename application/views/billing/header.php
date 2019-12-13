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
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/ico/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/ico/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/bootstrap.css'); ?>">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/bootstrap-extended.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/app.css'); ?>">
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
    <link rel="stylesheet" href="<?php echo base_url('assets/' . LTR . '/card.css') . APPVER; ?>">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/style.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/custom.css'); ?>">
    <!-- END Custom CSS-->

    <script src="<?php echo base_url(); ?>assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>


    <script src="<?php echo base_url(); ?>assets/portjs/raphael.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/portjs/morris.min.js" type="text/javascript"></script>


    <script src="<?php echo base_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo base_url('assets/myjs/summernote-bs4.min.js') . APPVER; ?>"></script>


    <script type="text/javascript">var baseurl = '<?php echo base_url() ?>';</script>

</head>
<body data-open="click" data-menu="vertical-menu" data-col="1-column"
      class="vertical-layout vertical-menu 1-column  container boxed-layout"><span id="hdata"
                                                                                   data-df="<?php echo $this->config->item('dformat2'); ?>"
                                                                                   data-curr="<?php echo $this->config->item('currency'); ?>"></span>


<!-- ////////////////////////////////////////////////////////////////////////////-->


<!-- main menu-->

<!-- main menu header-->

<!-- / main menu-->