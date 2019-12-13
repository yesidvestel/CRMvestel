<!-- BEGIN VENDOR JS-->
<script type="text/javascript">

    $('[data-toggle="datepicker"]').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('[data-toggle="datepicker"]').datepicker('setDate', new Date());
    $('#sdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('#sdate').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');
    $('.date30').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');


</script>
<script src="<?php echo base_url(); ?>assets/myjs/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/ui/perfect-scrollbar.jquery.min.js"
        type="text/javascript"></script>
<script src="<?php echo
base_url(); ?>assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/myjs/jquery.dataTables.min.js"></script>


<script type="text/javascript">var dtformat = $('#hdata').attr('data-df');
    var currency = $('#hdata').attr('data-curr');
    ;</script>
<script src="<?php echo base_url('assets/myjs/custom.js') . APPVER; ?>"></script>
<script src="<?php echo base_url('assets/myjs/basic.js') . APPVER; ?>"></script>
<script src="<?php echo base_url('assets/myjs/control.js') . APPVER; ?>"></script>

<script src="<?php echo base_url('assets/js/core/app.js') . APPVER; ?>" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/js/core/app-menu.js" type="text/javascript"></script>
<script type="text/javascript">
    $.ajax({

        url: baseurl + 'manager/pendingtasks',
        dataType: 'json',
        success: function (data) {
            $('#tasklist').html(data.tasks);
            $('#taskcount').html(data.tcount);

        },
        error: function (data) {
            $('#response').html('Error')
        }

    });


    var winh = document.body.scrollHeight;
    var sideh = document.getElementById('side').scrollHeight;
    var opx = winh - sideh;
    document.getElementById('rough').style.height = opx + "px";
    $('body').on('click', '.menu-toggle', function () {


        var opx2 = winh - sideh + 180;
        document.getElementById('rough').style.height = opx2 + "px";
    });
</script>
</body>
</html>
