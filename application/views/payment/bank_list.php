<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5 class="title"><?php echo $this->lang->line('Bank Accounts') ?> <a
                        href="<?php echo base_url('paymentgateways/add_bank_ac') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>
            <hr>
            <p><?php echo $this->lang->line('pay with bank') ?>.</p>
            <hr>

            <table id="catgtable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Account No') ?></th>
                    <th><?php echo $this->lang->line('Enable') ?></th>
                    <th><?php echo $this->lang->line('Action') ?></th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($bank_accounts as $row) {
                    $cid = $row['id'];
                    $title = $row['name'];
                    $enable = $row['acn'];
                    $dev_mode = $row['enable'];

                    echo "<tr>
                    <td>$i</td>
                    <td>$title</td>
                    <td>$enable</td>
                    <td>$dev_mode</td>
                  
                    <td><a href='" . base_url("paymentgateways/edit_bank_ac?id=$cid") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i> " . $this->lang->line('Edit') . "</a> <a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='icon-trash-o'></i></a></td></tr>";
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Account No') ?></th>
                    <th><?php echo $this->lang->line('Enable') ?></th>
                    <th><?php echo $this->lang->line('Action') ?></th>
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
                <p><?php echo $this->lang->line('delete this account') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="paymentgateways/delete_bank_ac">
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
