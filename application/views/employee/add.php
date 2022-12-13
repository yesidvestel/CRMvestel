<style type="text/css">
    .checkbox_modulos{
        cursor: pointer;
        transform: scale(1.5);
    }
    #table_permisos{
        transform: scale(1.2);
        

        
        
    }
    .jstree-default .jstree-themeicon-custom{
        background-color: #1D2B36;
    }
    .jstree-default .jstree-clicked {
  background: none;
}
</style>

<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class=" animated fadeInRight">
                <div class="col-md-8">
                    <div class="card card-block bg-white">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <form method="post" id="data_form" class="form-horizontal">
                            <div class="grid_3 grid_4">

                                <h5><?php echo $this->lang->line('Employee Details') ?> </h5>
                                <hr>
                                <div class="form-group row">

                                    <label class="col-sm-6 col-form-label"
                                           for="name"><?php echo $this->lang->line('UserName') ?>
                                        <small class="error">(Use Only a-z0-9)</small>
                                    </label>

                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control margin-bottom required" name="username"
                                               placeholder="username">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-6 col-form-label" for="email">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" placeholder="email"
                                               class="form-control margin-bottom required" name="email"
                                               placeholder="email">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-6 col-form-label"
                                           for="password"><?php echo $this->lang->line('Password') ?>
                                        <small>(min length 6)</small>
                                    </label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Password"
                                               class="form-control margin-bottom required" name="password"
                                               placeholder="password">
                                    </div>
                                </div>
                                <?php if ($this->aauth->get_user()->roleid >= 0) { ?>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('UserRole') ?></label>

                                        <div class="col-sm-5">
                                            <select id="sl-roleid" name="roleid" class="form-control margin-bottom">
                                                <option value="5">Super usuario</option>
                                                <option value="4">Administrativo</option>
                                                <option value="3">Caja y ventas</option>
                                                <option value="2">Tecnicos</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                        <h2 style="text-align: center;">Permisos</h2>
                                        
                                        <div align="center">
                                            <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                          <br>
                                            <br>

                                        <table id="table_permisos" >
<?php          $col=0;foreach ($modulos_padre as $ke1 => $mod) {$col++;       ?>
    <?php if($col==1){echo "<tr>";} ?>
                                            
                    <td style="border: orange double 1px;vertical-align: top;">
                        <div class="tres_view">
                          <ul>

                            <li data-jstree='{"icon":"btn btn-primary <?=$mod->icono?>"}'>&nbsp;<?=$mod->nombre  ?>&nbsp;&nbsp;<input checked  class="checkbox_modulos" type="checkbox" name="<?=$mod->codigo  ?>" id="<?=$mod->id_modulo  ?>">
                              <ul>
                                <?php $lista_de_hijos=$this->db->query("SELECT * FROM modulos where  id_padre=".$mod->id_modulo." order by id_modulo")->result(); ?>
                                <?php foreach ($lista_de_hijos as $keyh => $hijo) {?>
                                    <li><input checked class="checkbox_modulos" type="checkbox" name="<?=$hijo->codigo ?>" id="<?=$hijo->id_modulo ?>">&nbsp;<?=$hijo->nombre  ?></li>
                                <?php } ?>
                              </ul>
                            </li>
                          </ul>
                        </div>
                    </td>
                        
                                        <?php if($col==2){$col=0;echo "</tr>";}} ?>
                                        </table>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                          <br>
                                            <br>
                                            
                                        </div>
									

                                <?php } ?>

                                <hr>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('Name') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Nombre completo"
                                               class="form-control margin-bottom required" name="name"
                                               placeholder="Full name">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Documento</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Numero de documento"
                                               class="form-control margin-bottom required" name="documento"
                                               placeholder="Full name">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Fecha ingreso</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="ingreso"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Tipo de sangre + RH</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Grupo sanguineo"
                                               class="form-control margin-bottom" name="rh">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Eps</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Eps donde se encuentra afiliado"
                                               class="form-control margin-bottom" name="eps">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Fondo de pension</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Entidad donde este afiliado a pension"
                                               class="form-control margin-bottom" name="pensiones">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('Address') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Direccion completa"
                                               class="form-control margin-bottom" name="address">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="city"><?php echo $this->lang->line('City') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Ciudad"
                                               class="form-control margin-bottom" name="city">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="city">Departamento</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Departamento"
                                               class="form-control margin-bottom" name="region">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="country"><?php echo $this->lang->line('Country') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control margin-bottom" name="country">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="phone">Celular</label>

                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control margin-bottom" name="phone">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="phone">Area</label>

                                    <div class="col-sm-10">
                                         <select name="area" class="form-control margin-bottom">
										   <?php
												foreach ($area as $row) {
													$cid = $row['ida'];
													$title = $row['nombre_area'];
													echo "<option value='$cid'>$title</option>";
												}
												?>
                                         </select>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"></label>

                                    <div class="col-sm-4">
                                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                               value="<?php echo $this->lang->line('Add') ?>"
                                               data-loading-text="Adding...">
                                        <input type="hidden" value="employee/submit_user" id="action-url">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> </div>
<script type="text/javascript">
    $("#profile_add").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'user/submit_user';
        actionProduct1(actionurl);
    });
    $(function () { 
        $('.tres_view').jstree(); 
        $('.tres_view').on('ready.jstree', function() {
            $(".tres_view").jstree("open_all");          
        }); 

    });
    $(document).on("click",'.checkbox_modulos',function(ev){
        var input='<input class="checkbox_modulos" type="checkbox"  name="'+this.name+'" id="'+this.id+'" ';
        if($(this).is(":checked")){
            input+=" checked >";
        }else{
            input+=" >";
        }
        $("#"+this.id).replaceWith(input);
    });
</script>

<script>
	select_checkbox_segun_rol();//para hacer la seleccion al principio
$("#sl-roleid").on("change",function(ev){
	select_checkbox_segun_rol();//al cambiar de rol
});
function select_checkbox_segun_rol(){
	var roleid=$("#sl-roleid option:selected").val();
		$(":checkbox").prop("checked",false);
		if(roleid=="5"){
			//cobranza
			$("input[name=co]").prop("checked",true);
			$("input[name=coape]").prop("checked",true);
			$("input[name=conue]").prop("checked",true);
			$("input[name=coadm]").prop("checked",true);
			$("input[name=cocie]").prop("checked",true);
			$("input[name=cofa]").prop("checked",true);
			$("input[name=cofae]").prop("checked",true);
			$("input[name=conotas]").prop("checked",true);
			//usuarios
			$("input[name=us]").prop("checked",true);
			$("input[name=usnue]").prop("checked",true);
			$("input[name=usadm]").prop("checked",true);
			$("input[name=usgru]").prop("checked",true);
			//tickets
			$("input[name=tik]").prop("checked",true);
			$("input[name=tiknue]").prop("checked",true);
			$("input[name=tikadm]").prop("checked",true);
			//moviles
			$("input[name=mo]").prop("checked",true);
			$("input[name=monue]").prop("checked",true);
			$("input[name=moadm]").prop("checked",true);
			//proveedores
			$("input[name=pro]").prop("checked",true);
			$("input[name=pronue]").prop("checked",true);
			$("input[name=proadm]").prop("checked",true);
			//encuestas
			$("input[name=enc]").prop("checked",true);
			$("input[name=encllam]").prop("checked",true);
			$("input[name=encnue]").prop("checked",true);
			$("input[name=encenc]").prop("checked",true);
			$("input[name=encats]").prop("checked",true);
			$("input[name=encatslis]").prop("checked",true);
			//proyectos
			$("input[name=proy]").prop("checked",true);
			$("input[name=proynue]").prop("checked",true);
			$("input[name=proyadm]").prop("checked",true);
			//cuentas
			$("input[name=cuen]").prop("checked",true);
			$("input[name=cuenadm]").prop("checked",true);
			$("input[name=cuennue]").prop("checked",true);
			$("input[name=cuenbal]").prop("checked",true);
			$("input[name=cuendec]").prop("checked",true);
			//redes
			$("input[name=red]").prop("checked",true);
			$("input[name=reding]").prop("checked",true);
			$("input[name=redadm]").prop("checked",true);
			$("input[name=redbod]").prop("checked",true);
			//ordenes
			$("input[name=com]").prop("checked",true);
			$("input[name=comnue]").prop("checked",true);
			$("input[name=comadm]").prop("checked",true);
			//tesoreria
			$("input[name=tes]").prop("checked",true);
			$("input[name=testran]").prop("checked",true);
			$("input[name=tesanu]").prop("checked",true);
			$("input[name=tesnuetransac]").prop("checked",true);
			$("input[name=tesnuetransfer]").prop("checked",true);
			$("input[name=tesing]").prop("checked",true);
			$("input[name=tesgas]").prop("checked",true);
			$("input[name=testransfer]").prop("checked",true);
			//datos
			$("input[name=dat]").prop("checked",true);
			$("input[name=datest]").prop("checked",true);
			$("input[name=datdec]").prop("checked",true);
			$("input[name=datrep]").prop("checked",true);
			$("input[name=datusu]").prop("checked",true);
			$("input[name=datpro]").prop("checked",true);
			$("input[name=dating]").prop("checked",true);
			$("input[name=datgas]").prop("checked",true);
			$("input[name=dattrans]").prop("checked",true);
			$("input[name=datimp]").prop("checked",true);
			$("input[name=dathistorial]").prop("checked",true);
			//notas
			$("input[name=not]").prop("checked",true);
			//calendario
			$("input[name=cal]").prop("checked",true);
			//documentos
			$("input[name=doct]").prop("checked",true);
			//pagos
			$("input[name=pag]").prop("checked",true);
			$("input[name=pagconf]").prop("checked",true);
			$("input[name=pagvia]").prop("checked",true);
			$("input[name=pagmon]").prop("checked",true);
			$("input[name=pagcam]").prop("checked",true);
			$("input[name=pagban]").prop("checked",true);
			//inventarios
			$("input[name=inv]").prop("checked",true);
			$("input[name=inving]").prop("checked",true);
			$("input[name=invadm]").prop("checked",true);
			$("input[name=invcat]").prop("checked",true);
			$("input[name=invalm]").prop("checked",true);
			$("input[name=invtrs]").prop("checked",true);
			//empleados
			$("input[name=emp]").prop("checked",true);
			//complementos
			$("input[name=comp]").prop("checked",true);
			$("input[name=comprec]").prop("checked",true);
			$("input[name=compurl]").prop("checked",true);
			$("input[name=comptwi]").prop("checked",true);
			$("input[name=compcurr]").prop("checked",true);
			//plantillas
			$("input[name=pla]").prop("checked",true);
			$("input[name=placor]").prop("checked",true);
			$("input[name=plamen]").prop("checked",true);
			$("input[name=platem]").prop("checked",true);
			//configuraciones
			$("input[name=conf]").prop("checked",true);
			$("input[name=confemp]").prop("checked",true);
			$("input[name=conffa]").prop("checked",true);
			$("input[name=confmon]").prop("checked",true);
			$("input[name=conffec]").prop("checked",true);
			$("input[name=confcat]").prop("checked",true);
			$("input[name=confmet]").prop("checked",true);
			$("input[name=confrest]").prop("checked",true);
			$("input[name=confcorr]").prop("checked",true);
			$("input[name=confterm]").prop("checked",true);
			$("input[name=confaut]").prop("checked",true);
			$("input[name=confseg]").prop("checked",true);
			$("input[name=conftem]").prop("checked",true);
			$("input[name=confsop]").prop("checked",true);
			$("input[name=conface]").prop("checked",true);
			$("input[name=confupt]").prop("checked",true);
			$("input[name=confapi]").prop("checked",true);
			//tareas
			$("input[name=tar]").prop("checked",true);
		}else if(roleid=="4"){
			//cobranza
			$("input[name=co]").prop("checked",true);
			$("input[name=coape]").prop("checked",true);
			$("input[name=conue]").prop("checked",true);
			$("input[name=coadm]").prop("checked",true);
			$("input[name=cocie]").prop("checked",true);
			//usuarios
			$("input[name=us]").prop("checked",true);
			$("input[name=usnue]").prop("checked",true);
			$("input[name=usadm]").prop("checked",true);
			$("input[name=usgru]").prop("checked",true);
			//tickets
			$("input[name=tik]").prop("checked",true);
			$("input[name=tiknue]").prop("checked",true);
			$("input[name=tikadm]").prop("checked",true);
			//moviles
			$("input[name=mo]").prop("checked",true);
			$("input[name=monue]").prop("checked",true);
			$("input[name=moadm]").prop("checked",true);
			//proveedores
			$("input[name=pro]").prop("checked",true);
			$("input[name=pronue]").prop("checked",true);
			$("input[name=proadm]").prop("checked",true);
			//encuestas
			$("input[name=enc]").prop("checked",true);
			$("input[name=encllam]").prop("checked",true);
			$("input[name=encnue]").prop("checked",true);
			$("input[name=encenc]").prop("checked",true);
			$("input[name=encats]").prop("checked",true);
			$("input[name=encatslis]").prop("checked",true);
			//proyectos
			$("input[name=proy]").prop("checked",true);
			$("input[name=proynue]").prop("checked",true);
			$("input[name=proyadm]").prop("checked",true);
			//redes
			$("input[name=red]").prop("checked",true);
			$("input[name=reding]").prop("checked",true);
			$("input[name=redadm]").prop("checked",true);
			$("input[name=redbod]").prop("checked",true);
			//ordenes
			$("input[name=com]").prop("checked",true);
			$("input[name=comnue]").prop("checked",true);
			$("input[name=comadm]").prop("checked",true);
			//tesoreria
			$("input[name=tes]").prop("checked",true);
			$("input[name=tesnuetransac]").prop("checked",true);
			$("input[name=tesnuetransfer]").prop("checked",true);
			//datos
			$("input[name=dat]").prop("checked",true);
			$("input[name=datest]").prop("checked",true);
			$("input[name=datdec]").prop("checked",true);
			$("input[name=datrep]").prop("checked",true);
			//notas
			$("input[name=not]").prop("checked",true);
			//calendario
			$("input[name=cal]").prop("checked",true);
			//documentos
			$("input[name=doct]").prop("checked",true);
			//inventarios
			$("input[name=inv]").prop("checked",true);
			$("input[name=inving]").prop("checked",true);
			$("input[name=invadm]").prop("checked",true);
			$("input[name=invcat]").prop("checked",true);
			$("input[name=invalm]").prop("checked",true);
			$("input[name=invtrs]").prop("checked",true);
			//empleados
			$("input[name=emp]").prop("checked",true);
			//tareas
			$("input[name=tar]").prop("checked",true);
		}else if(roleid=="3"){
			//cobranza
			$("input[name=co]").prop("checked",true);
			$("input[name=coape]").prop("checked",true);
			$("input[name=conue]").prop("checked",true);
			$("input[name=cocie]").prop("checked",true);
			//usuarios
			$("input[name=us]").prop("checked",true);
			$("input[name=usnue]").prop("checked",true);
			$("input[name=usgru]").prop("checked",true);
			//tickets
			$("input[name=tik]").prop("checked",true);
			$("input[name=tiknue]").prop("checked",true);
			$("input[name=tikadm]").prop("checked",true);
			//notas
			$("input[name=not]").prop("checked",true);
			//calendario
			$("input[name=cal]").prop("checked",true);
			//documentos
			$("input[name=doct]").prop("checked",true);
			//ordenes
			$("input[name=com]").prop("checked",true);
			$("input[name=comadm]").prop("checked",true);
			//tesoreria
			$("input[name=tes]").prop("checked",true);
			$("input[name=tesnuetransac]").prop("checked",true);
			$("input[name=tesnuetransfer]").prop("checked",true);
			//tareas
			$("input[name=tar]").prop("checked",true);
		}else if(roleid=="2"){
			//notas
			$("input[name=not]").prop("checked",true);
			//calendario
			$("input[name=cal]").prop("checked",true);
			//documentos
			$("input[name=doct]").prop("checked",true);
			//tareas
			$("input[name=tar]").prop("checked",true);
		}
}
    function actionProduct1(actionurl) {

        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });


    }
</script>