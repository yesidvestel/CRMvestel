<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5><?php echo $this->lang->line('') ?>ESTADOS</h5>

            <hr>
            <div class="card card-block">
                <h4><?php echo $this->lang->line('') ?>Usuario</h4>
                <hr>
                <div class="row m-t-lg">
                    <div class="col-md-1">
                        <strong><?php echo $this->lang->line('Name') ?></strong>
                    </div>
                    <div class="col-md-10">
                        <?php echo $details['name'].' '.$details['unoapellido'] ?>
                    </div>

                </div>
                <div class="row m-t-lg">
                    <div class="col-md-1">
                        <strong>Documento</strong>
                    </div>
                    <div class="col-md-10">
                        <?php echo $details['documento'] ?>
                    </div>

                </div>
            </div>
            <hr>
            <table id="cgrtable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>usuario</th>
                    <th><?php echo $this->lang->line('') ?>Fecha</th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($estado as $row) {
                    $cid = $row['id'];
                    $dtlle = $row['name'];
                    $dtlle2 = $row['unoapellido'];
                    $tpo = $row['fecha'];
                    $cdor = $row['estado'];

                    echo "<tr>
                    <td>$i</td>
                    <td>$dtlle $dtlle2</td>
                    <td>$tpo</td>
                    <td>$cdor</td>
					</tr>";
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>usuario</th>
                    <th><?php echo $this->lang->line('') ?>Fecha</th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#cgrtable').DataTable({});

    });
</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Transaction') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>