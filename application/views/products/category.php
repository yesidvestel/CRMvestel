<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5 class="title"> <?php echo $this->lang->line('Product Category') ?> <a
                        href="<?php echo base_url('productcategory/add') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>

            <hr>
            <table id="catgtable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('') ?>Total Material</th>
                    <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                    <?php /*?><th><?php echo $this->lang->line('Worth (Sales/Stock)') ?></th><?php */?>
                    <th><?php echo $this->lang->line('Action') ?></th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($cat as $row) {
                    $cid = $row['id'];
                    $title = $row['title'];
                    $total = $row['pc'];

                    $qty = $row['qty'];
                    $salessum = amountFormat($row['salessum']);
                    $worthsum = amountFormat($row['worthsum']);
                    echo "<tr>
                    <td>$i</td>
                    <td>$title</td>
                    <td>$total</td>
                    <td>$qty</td>                    
                    <td><a href='" . base_url("productcategory/view?id=$cid") . "' class='btn btn-success btn-xs'><i class='icon-file-text'></i> " . $this->lang->line('View') . "</a>&nbsp;<a href='" . base_url("productcategory/edit?id=$cid") . "' class='btn btn-warning btn-xs'><i class='icon-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='icon-trash-o'></i></a></td></tr>";
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('') ?>Total Material</th>
                    <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                    <?php /*?><th><?php echo $this->lang->line('Worth (Sales/Stock)') ?></th><?php */?>
                    <th><?php echo $this->lang->line('Action') ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#catgtable').DataTable({});

    });
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this product category') ?></strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="productcategory/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>