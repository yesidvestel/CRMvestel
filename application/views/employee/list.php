<style type="text/css">
    
    .jstree-default .jstree-themeicon-custom{
        background-color: #1D2B36;
    }
    .jstree-default .jstree-clicked {
      background: none;
    }
</style>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h5 class="title">
                <?php echo $this->lang->line('Employee') ?> <a href="<?php echo base_url('employee/add') ?>"
                                                               class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>
            <table id="emptable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
					<th>Hora ingreso</th>
					<th>Apertura Caja</th>
					<th>Cierre Caja</th>
                    <th><?php echo $this->lang->line('Actions') ?></th>
					<?php if ($this->aauth->get_user()->roleid == 5) {
					echo "<th>Admin</th>";
						}?>

                </tr>
                </thead>
                <tbody>
                <?php $i = 1;

                foreach ($employee as $row) {
                    $aid = $row['id'];
                    $username = $row['username'];
                    $name = $row['name'];
                    $role = user_role($row['roleid']);
                    $status = $row['banned'];
					//horas cajas
                    $fin = $row['finicial'];
                    $fcrre = $row['fcierre'];
					if($fin!=null){
						$horain = "/".date("g:i a",strtotime($row['hinicial']));
					}else{
						$horain = "";
					}
					if($fcrre!=null){
						$horacie = "/".date("g:i a",strtotime($row['hcierre']));
					}else{
						$horacie = "";
					}
					$hora = date("g:i a",strtotime($row['last_login']));
                    if ($status == 1) {
                        $status = 'Deactive';
                        $btn = "<a href='#' data-object-id='" . $aid . "' class='btn btn-orange btn-xs delete-object' title='Enable'><i class='icon-eye-slash'></i> Enable</a>";
                    } else {
                        $status = 'Active';
                        $btn = "<a href='#' data-object-id='" . $aid . "' class='btn btn-orange btn-xs delete-object' title='Disable'><i class='icon-eye-slash'></i> " . $this->lang->line('Disable') ."</a>";
                    }					
                $ver="<a href='" . base_url("employee/view?id=$aid") . "' class='btn btn-success btn-xs'><i class='icon-file-text'></i> " . $this->lang->line('View') ."</a>";
                if($this->aauth->get_user()->roleid != 5){
                    $ver="<a href='#' data-name='".$name."' data-id-empleado='".$aid."' data-role='".$role."' class='btn btn-success btn-xs ver-permisos'><i class='icon-file-text'></i> " . $this->lang->line('View') ."</a>";
                }
                    echo "<tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$role</td>                 
                    <td>$status</td>
					<td>$hora</td>
					<td>$fin$horain</td>
					<td>$fcrre$horacie</td>
                    <td>".$ver."</td>";
					if ($this->aauth->get_user()->roleid == 5) {
					echo "<td>$btn&nbsp;&nbsp;<a href='#pop_model' data-toggle='modal' data-remote='false' data-object-id='" . $aid . "' class='btn btn-danger btn-xs delemp' title='Delete'><i class='icon-trash-o'></i></a></td>
					
					</tr>";
                    $i++;
					}
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
					<th>Hora ingreso</th>
					<th>Apertura Caja</th>
					<th>Cierre Caja</th>
                    <th><?php echo $this->lang->line('Actions') ?></th>
					<?php if ($this->aauth->get_user()->roleid == 5) {
					echo "<th>Admin</th>";
						}?>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#emptable').DataTable({});


    });

    $('.delemp').click(function (e) {
        e.preventDefault();
        $('#empid').val($(this).attr('data-object-id'));

    });
    $(document).on("click",".ver-permisos",function (e){
        e.preventDefault();
        var nombre=$(this).data("name");
        var id_=$(this).data("id-empleado");
        var role=$(this).data("role");
        if(role=="Super usuario"){
            $(".checkbox_modulos").prop('checked', true);  
        }else{
            $(".checkbox_modulos").prop('checked', false);
            $.post(baseurl+"employee/get_permios_employe",{"id":id_},function(data){
               for (let i in data) {
                var chec=false;
                if(data[i]==0 ){
                    chec=true;
                }
                //var input='<input class="checkbox_modulos" type="checkbox"  name="'+i+'" id="'+i+'" '+chec+'>';
                $("#"+i).prop('checked', chec);
                //$("#"+i).replaceWith(input);
              
            }
            },'json');
        }
        
        $("#titulo_perms").html("Permisos Usuario : "+nombre);
        $("#role_text").html("Rol : "+role);
        $("#info-modal").modal("show");
    });
    $(function () { 
        $('.tres_view').jstree(); 
        $('.tres_view').on('ready.jstree', function() {
            $(".tres_view").jstree("open_all");          
        }); 

    });
</script>

<div id="info-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titulo_perms">Permisos usuario</h4>
                <h5 id="role_text"></h5>
            </div>
            <div class="modal-body">
                 <div align="center">
                    <table id="table_permisos" >
                                    <?php          
                                                    $col=0;foreach ($modulos_padre as $ke1 => $mod) {$col++;       ?>
                                        <?php if($col==1){echo "<tr>";} ?>
                                                                                
                                                        <td style="border: orange double 1px;vertical-align: top;">
                                                            <div class="tres_view">
                                                              <ul>

                                                                <li data-jstree='{"icon":"btn btn-primary <?=$mod->icono?>"}'>&nbsp;<?=$mod->nombre  ?>&nbsp;&nbsp;<input  class="checkbox_modulos" type="checkbox" name="<?=$mod->codigo  ?>" id="<?=$mod->codigo  ?>">
                                                                  <ul>
                                                                    <?php $lista_de_hijos=$this->db->query("SELECT * FROM modulos where  id_padre=".$mod->id_modulo." order by id_modulo")->result(); ?>
                                                                    <?php foreach ($lista_de_hijos as $keyh => $hijo) {?>
                                                                        <li><input  class="checkbox_modulos" type="checkbox" name="<?=$hijo->codigo ?>" id="<?=$hijo->codigo ?>">&nbsp;<?=$hijo->nombre  ?></li>
                                                                    <?php } ?>
                                                                  </ul>
                                                                </li>
                                                              </ul>
                                                            </div>
                                                        </td>
                        
                                        <?php if($col==2){$col=0;echo "</tr>";}} ?>
                                        </table>
                 </div>
            </div>
            <div class="modal-footer">
                
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Deactive Employee</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to deactive this account ? <br><strong> It will disable this account access to
                        user.</strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="employee/disable_user">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Deactive</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="modal-body">
                        <p>Are you sure you want to delete this employee? <br><strong> It may interrupt old invoices,
                                disable account is a better option.</strong></p>
                    </div>
                    <div class="modal-footer">


                        <input type="hidden" class="form-control required"
                               name="empid" id="empid" value="">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="employee/delete_user">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Delete'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>