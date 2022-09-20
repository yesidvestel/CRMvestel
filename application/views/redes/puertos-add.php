<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5>Nuevo Puerto</h5>
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

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('') ?>Nap</label>

                    <div class="col-sm-6">
                        <select name="nap" class="form-control" id="cmbnaps">
                        </select>
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('') ?>Puerto</label>

                    <div class="col-sm-6">
                       <select name="puerto" class="form-control">
                            <?php
							for ($i=1;$i<=16;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';}?>
                        </select>
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('') ?>Estodo</label>

                    <div class="col-sm-6">
                       <select name="estado" class="form-control">
                            <option value="Disponible">Disponible</option>
                            <option value="Ocupado">Ocupado</option>
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
                        <input type="hidden" value="redes/puerto_input" id="action-url">
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
	$("#cmbvlans").change(function(){
		$("#cmbvlans option:selected").each(function(){
			idv = $(this).val();
			//console.log(idDepartamento);
			$.post(baseurl+"redes/nap_list",{'idv': idv
				},function(data){
				//console.log(data);
					$("#cmbnaps").html(data);
			})
		})
	})
})	

</script>
