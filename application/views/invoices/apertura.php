<script type="text/javascript" src="<?=base_url()?>assets/myjs/cookie.js"></script>
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
                                        <option value='3'><?php echo $this->lang->line('') ?>Yopal </option>
                                        <option value='3'><?php echo $this->lang->line('') ?>Monterrey</option>
                                        <option value='3'><?php echo $this->lang->line('') ?>Villanueva</option>
										<option value='3'><?php echo $this->lang->line('') ?>Mocoa</option>
                                    </select>


                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="sdate2"><?php echo $this->lang->line('From Date') ?></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="fecha" id="sdate2"
                                            autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="End Date" id="hora" name="hora"
                                            autocomplete="false" value="<?php echo date("g:i a") ?>" disabled>
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
        var fecha=$("#sdate2").val();
        var hora=$("#hora").val();
        
        $.post(baseurl+"Invoices/activar",{iduser:iduser,perfil:perfil,fecha:fecha,hora:hora},function(data){
                Cookies.set('mostrar_mensaje','si',{expires: 1});
                location.reload();                
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
        },'json');

        
        
    });
if(Cookies.get('mostrar_mensaje')=="si"){
        var link=baseurl+"invoices";
                $("#notify .message").html("<strong>Success </strong>: Apertura realiza ir a las vistas <a href='"+link+"' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> Ir</a> ");
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
                Cookies.remove('mostrar_mensaje');
        }
</script>