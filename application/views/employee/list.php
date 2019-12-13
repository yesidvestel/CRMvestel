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
                    <th><?php echo $this->lang->line('Actions') ?></th>


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

                    if ($status == 1) {
                        $status = 'Deactive';
                        $btn = "<a href='#' data-object-id='" . $aid . "' class='btn btn-orange btn-xs delete-object' title='Enable'><i class='icon-eye-slash'></i> Enable</a>";
                    } else {
                        $status = 'Active';
                        $btn = "<a href='#' data-object-id='" . $aid . "' class='btn btn-orange btn-xs delete-object' title='Disable'><i class='icon-eye-slash'></i> " . $this->lang->line('Disable') ."</a>";
                    }

                    echo "<tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$role</td>                 
                    <td>$status</td>
                    <td><a href='" . base_url("employee/view?id=$aid") . "' class='btn btn-success btn-xs'><i class='icon-file-text'></i> " . $this->lang->line('View') ."</a>&nbsp;&nbsp;$btn&nbsp;&nbsp;<a href='#pop_model' data-toggle='modal' data-remote='false' data-object-id='" . $aid . "' class='btn btn-danger btn-xs delemp' title='Delete'><i class='icon-trash-o'></i></a></td></tr>";
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th><?php echo $this->lang->line('Actions') ?></th>
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
</script>


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