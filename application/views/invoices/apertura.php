<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Apertura de caja</h6>
            <hr>
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">

                        <form  action="<?php echo base_url() ?>Invoices/activar" method="post" role="form" id="form_apertura" >
							<input type="hidden" class="form-control" placeholder="Invoice #" name="iduser" id="iduser" value="<?php echo $employee['id'] ?>">
                            
                            <div class="form-group row">
								
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Caja</label>

                                <div class="col-sm-9">
                                    <select name="perfil" class="form-control" id="perfil">
                                        <option value='2'><?php echo $this->lang->line('') ?>Yopal </option>
                                        <option value='1'><?php echo $this->lang->line('') ?>Monterrey</option>
                                        <option value='0'><?php echo $this->lang->line('') ?>Villanueva</option>
										<option value='-1'><?php echo $this->lang->line('') ?>Mocoa</option>
                                    </select>


                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="fecha" id="sdate"
                                            autocomplete="false" disabled>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="End Date" id="hora" name="hora"
                                            autocomplete="false" value="<?php echo date("H").":".date("i") ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary btn-md" value="Abrir">


                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</article>
<script type="text/javascript">
    $("#form_apertura").submit(function(event){
        event.preventDefault();
        var iduser=$("#iduser").val();
        var perfil=$("#perfil option:selected").val();
        var fecha=$("#sdate").val();
        var hora=$("#hora").val();
        console.log
        $.post(baseurl+"Invoices/activar",{iduser:iduser,perfil:perfil,fecha:fecha,hora:hora},function(data){
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
        },'json');
        
    });
</script>