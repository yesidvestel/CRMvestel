<script src="<?php echo base_url(); ?>assets/myjs/loading-bar.js" type="text/javascript"></script>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Los datos se estan generando</h6>
            <hr>

            <div class="row sameheight-container">
                <div class="col-md-12">
                    <div class="card card-block sameheight-item">

                        <span id="ldBar" class="ldBar text-xs-center"
                              style="width:100%;height:30px" ,

                        ></span>
                        <script>
                            var bar1 = new ldBar("#ldBar");

                            setInterval(function () {
                                bar1.set(Math.floor((Math.random() * 70) + 30));
                            }, 2000);
                        </script>
                    </div>
                </div>

            </div>

        </div>
    </div>
</article>
<script type="text/javascript">
    var url_="reports/statickets";
    var url_process="reports/refresh_process_tickets";
    setTimeout(function () {
        $.ajax({

            url: baseurl + url_process,
            dataType: 'json',
            success: function () {
                window.location.href = baseurl + url_;

            },
            error: function () {

            }

        });
    }, 2000);

</script>


