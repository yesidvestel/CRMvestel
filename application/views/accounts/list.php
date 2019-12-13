<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 animated fadeInRight">
            <h5><?php echo $this->lang->line('Accounts') ?></h5>
            <div class="row">

                <div class="col-xl-6 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="green"><?php echo $this->config->item('currency') ?><span
                                                    id="dash_0"></span></h3>
                                        <span id="dash_"><?php echo $this->lang->line('Balance') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-moneybag green font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="cyan" id="dash_1"></h3>
                                        <span><?php echo $this->lang->line('Accounts') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-stats-bars22 cyan font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table id="acctable" class="table table-hover mb-1" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Account No') ?></th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                        <th><?php echo $this->lang->line('Actions') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    foreach ($accounts as $row) {
                        $aid = $row['id'];
                        $acn = $row['acn'];
                        $holder = $row['holder'];
                        $balance = amountFormat($row['lastbal']);
                        $qty = $row['adate'];
                        echo "<tr>
                    <td>$i</td>
                    <td>$acn</td>
                    <td>$holder</td>
                 
                    <td>$balance</td>
                    <td><a href='" . base_url("accounts/view?id=$aid") . "' class='btn btn-success btn-xs'><i class='icon-file-text'></i>  ".$this->lang->line('View')."</a>&nbsp;<a href='" . base_url("accounts/edit?id=$aid") . "' class='btn btn-warning btn-xs'><i class='icon-pencil'></i>  ".$this->lang->line('Edit')."</a>&nbsp;<a href='#' data-object-id='" . $aid . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='icon-trash-o'></i></a></td></tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Account No') ?></th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                        <th><?php echo $this->lang->line('Actions') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <input type="hidden" id="dashurl" value="accounts/account_stats">
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#acctable').DataTable({});
        miniDash();

    });
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Account') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('Delete account message') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="accounts/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>