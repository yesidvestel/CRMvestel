<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5>Nueva Vlan</h5>
                <hr>
                <input type="hidden" name="id" value="<?php echo $sms['id'] ?>">
                
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('') ?>Almacen</label>

                    <div class="col-sm-6">
                        <select name="almacen" class="form-control">
                            <?php
                            foreach ($almacen as $row) {
                                $cid = $row['id'];
                                $title = $row['almacen'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('') ?>vlan</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Nombre de la Vlan"
                               class="form-control margin-bottom  required" name="vlan">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('') ?>Detalle</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Detalles generales"
                               class="form-control margin-bottom  required" name="detalle">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="Crear" data-loading-text="Updating...">
                        <input type="hidden" value="redes/vlan_input" id="action-url">
                    </div>
                </div>

            </div>
        </form>
        <div class="box"></div>

    </div>

</article>
<script>
//traer ciudad				
$(document).ready(function(){
	$("#depar").change(function(){
		$("#depar option:selected").each(function(){
			idDepartamento = $(this).val();
			//console.log(idDepartamento);
			$.post(baseurl+"customers/ciudades_list",{'idDepartamento': idDepartamento
				},function(data){
				//console.log(data);
					$("#cmbCiudades").html(data);
			})
		})
	})
})
//traer localidad			
$(document).ready(function(){
	$("#cmbCiudades").change(function(){
		$("#cmbCiudades option:selected").each(function(){
			idCiudad = $(this).val();
			//console.log(idDepartamento);
			$.post(baseurl+"customers/localidades_list",{'idCiudad': idCiudad
				},function(data){
				//console.log(data);
					$("#cmbLocalidades").html(data);
			})
		})
	})
})
//traer barrio			
$(document).ready(function(){
	$("#cmbLocalidades").change(function(){
		$("#cmbLocalidades option:selected").each(function(){
			idLocalidad = $(this).val();
			//console.log(idDepartamento);
			$.post(baseurl+"customers/barrios_list",{'idLocalidad': idLocalidad
				},function(data){
				//console.log(data);
					$("#cmbBarrios").html(data);
			})
		})
	})
})	

</script>
