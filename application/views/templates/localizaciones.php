<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5 class="title"><?php echo $this->lang->line('') ?>Administrar localizaciones
            </h5>
			<a href='<?php echo base_url("templates/depar_add"); ?>' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i> Nuevo Departamento</a>
			<a href='<?php echo base_url("templates/ciudad_add"); ?>' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i> Nueva Ciudad</a>
			<a href='<?php echo base_url("templates/local_add"); ?>' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i> Nueva Localidad</a>
			<a href='<?php echo base_url("templates/barrio_add"); ?>' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i> Nuevo Barrio</a>
            <hr>
            <table id="catgtable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>Departamento</th>
                    <th><?php echo $this->lang->line('') ?>Ciudad</th>
                    <th><?php echo $this->lang->line('') ?>Localidad</th>
                    <th><?php echo $this->lang->line('') ?>Barrio</th>
                    <th><?php echo $this->lang->line('') ?>Action</th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($barrios as $row) {
                    $cid = $row['idBarrio'];
                    $depar = $row['departamento'];
                    $ciudad = $row['ciudad'];
                    $local = $row['localidad'];
                    $barrio = $row['barrio'];

                    echo "<tr>
                    <td>$i</td>
                    <td>$depar</td>
                    <td>$ciudad</td>
                    <td>$local</td>
                    <td>$barrio</td>
                    
                  
                    <td><a href='" . base_url("templates/barrio_edit?id=$cid") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>" . $this->lang->line('Edit') . "</a>&nbsp&nbsp<a href='#' data-object-id=" . $cid ." class='btn btn-danger btn-xs delete-object'><span class='icon-bin'></span>" . $this->lang->line('Delete') . "</a></td></tr>";
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>Departamento</th>
                    <th><?php echo $this->lang->line('') ?>Ciudad</th>
                    <th><?php echo $this->lang->line('') ?>Localidad</th>
                    <th><?php echo $this->lang->line('') ?>Barrio</th>
                    <th><?php echo $this->lang->line('') ?>Action</th>

                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('') ?>¿Seguro que desea borrar este registro?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="" name="deleteid">
                <input type="hidden" id="action-url" value="templates/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#catgtable').DataTable({});

    });
</script>
