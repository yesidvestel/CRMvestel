<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Signature Pad demo</title>
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
  <a id="github" style="position: absolute; top: 0; right: 0; border: 0" href="https://github.com/szimek/signature_pad">
    
  </a>

  <div id="signature-pad" class="signature-pad">
    <div class="signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="signature-pad--footer">
      <div class="description">Firma Digital Contrato</div>

      <div class="signature-pad--actions">
        <div>
          <button type="button" class="button clear" data-action="clear">Clear</button>
          <button type="button" class="button" data-action="change-color">Change color</button>
          <button type="button" class="button" data-action="undo">Undo</button>

        </div>
        <div>
          <button type="button" class="button save" data-action="save-png">Save as PNG</button>
          <button type="button" class="button save" data-action="save-jpg">Save as JPG</button>
          <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
        </div>
      </div>
    </div>
  </div>

  <script src="<?=base_url()?>assets/js/pintar/signature_pad.js"></script>
  <script src="<?=base_url()?>assets/js/pintar/app.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(".alert").remove();
  </script>
</body>
</html>
