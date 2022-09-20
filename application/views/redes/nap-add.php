<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5>Nueva NAP</h5>
                <hr>
                
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('') ?>Sede</label>

                    <div class="col-sm-6">
                        <select name="almacen" class="form-control" id="almacen">
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
                       <select name="vlan" class="form-control" id="cmbvlans">
                            
                        </select>
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('') ?>Nombre</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Nombre de la nap"
                               class="form-control margin-bottom  required" name="nap">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('') ?>Puertos</label>

                    <div class="col-sm-6">
                       <select name="puertos" class="form-control">
                            <option value="8">8</option>
                            <option value="16">16</option>
                        </select>
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
                        <input type="hidden" value="redes/nap_input" id="action-url">
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
	$("#almacen").change(function(){
		$("#almacen option:selected").each(function(){
			id = $(this).val();
			//console.log(idDepartamento);
			$.post(baseurl+"redes/vlan_list",{'id': id
				},function(data){
				//console.log(data);
					$("#cmbvlans").html(data);
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
