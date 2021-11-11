<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Firma Digital</title>
  <meta name="description" content="Signature Pad - HTML5 canvas based smooth signature drawing using variable width spline interpolation.">

  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link rel="stylesheet" href="<?=base_url()?>assets/css/pintar/signature-pad.css">

  <!--[if IE]>
    <link rel="stylesheet" type="text/css" href="css/ie9.css">
  <![endif]-->

  
</head>
<body onselectstart="return false">
  
  <a id="github" style="position: absolute; top: 0; right: 0; border: 0" href="#">
    
  </a>

  <div id="signature-pad" class="signature-pad">
    <div class="signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="signature-pad--footer">
      <div class="description"><?= (isset($type) && $type=="orden") ? 'Firma digital usuario que resive' : 'Firma Digital Contrato'?></div>

      <div class="signature-pad--actions">
        <div>
          <button type="button" class="button clear" data-action="clear">Borrar</button>
          <button type="button" class="button" data-action="change-color">Cambiar el Color</button>
          <button type="button" class="button" data-action="undo">Deshacer</button>

        </div>
        <div>
          
          <form id="form" action="<?=base_url()?>customers/save_firma" method="post">
        <input type="hidden" name="customer_id" value="<?php echo $id; ?>">
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <input type="hidden" name="base64" value="" id="base64">
        <button id="saveandfinish" class="btn btn-success">Guardar y Finalizar</button>
    </form>
          
        </div>
      </div>
    </div>
  </div>
    
  <script src="<?=base_url()?>assets/js/pintar/signature_pad.js"></script>
  <script src="<?=base_url()?>assets/js/pintar/app.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    var id_customer="<?=$id?>";
    $(".alert").remove();


     document.getElementById('form').addEventListener("submit",function(e){

   // var ctx = document.getElementById("canvas");
      var image = canvas.toDataURL(); // data:image/png....
      document.getElementById('base64').value = image;
   },false);
  </script>
</body>
</html>
