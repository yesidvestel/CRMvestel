<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <div class="header-block">
                <h3 class="title">
                    <?php echo $this->lang->line('Support Tickets') ?>
                </h3></div>


            <p>&nbsp;</p>
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="pink" id="dash_0"></h3>
                                        <span><?php echo $this->lang->line('Waiting') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-clock3 pink font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="indigo" id="dash_1"></h3>
                                        <span><?php echo $this->lang->line('Processing') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-spinner5 indigo font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="green" id="dash_2"></h3>
                                        <span><?php echo $this->lang->line('Solved') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-clipboard2 green font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="deep-cyan"><?php echo $totalt ?></h3>
                                        <span><?php echo $this->lang->line('Total') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-stats-bars22 deep-cyan font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table id="doctable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Subject') ?></th>
                    <th><?php echo $this->lang->line('Added') ?></th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th><?php echo $this->lang->line('Action') ?></th>


                </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
    </div>
    <input type="hidden" id="dashurl" value="tickets/ticket_stats">
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
                <p><?php echo $this->lang->line('delete this ticket') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="tickets/delete_ticket">
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

        $('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php if (isset($_GET['filter'])) {
                    $filter = $_GET['filter'];
                } else {
                    $filter = '';
                }    echo site_url('tickets/tickets_load_list?stat=' . $filter)?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],
			"order": [[ 2, "desc" ]]

        });
        miniDash();
    });
</script>
