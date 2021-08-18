<div id="modal_sede" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
				<h3 align="center">BIENVENIDO</h3>
                <h4 class="modal-title" align="center">Vestel trabaja con lógica, ética y estética</h4>
            </div>
            <div class="modal-body">
                <p>¿Desde que sede estas accediendo? </p>
                <div class="col-sm-9">
                    
                        <select name="sede_accede" class="form-control" id="sede_accede">
							<?php if ($this->aauth->get_user()->roleid > 3) {?>
							<option value="0">Todas</option>
                            <?php }
                                foreach ($customergrouplist as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    $selected="";
                                    if($sede_accede==$cid){
                                        $selected="selected='true'";
                                    }
                                    if($cid!="1"){
                                        echo "<option ".$selected." value='$cid'>$title</option>";
                                    }
                                }
                                ?>
                        </select>
                    
                </div>
            </div>
            <div class="modal-footer">
                
                
                <button type="button" class="btn btn-primary" onclick="guardar_sede_actual()">Aceptar</button>
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#modal_sede").modal("show");
    function guardar_sede_actual(){
        var sede=$("#sede_accede option:selected").val();

        $.post(baseurl+"dashboard/guardar_sede_user_se_conecta",{sede:sede},function(data){

        });
        $("#modal_sede").modal("toggle");
    }
</script>