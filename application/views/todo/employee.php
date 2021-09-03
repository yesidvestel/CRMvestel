<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <div class="header-block">
                <h3 class="title">
                    <?php echo $this->lang->line('Tasks') ?>
                </h3></div>


            <p>&nbsp;</p>
            <table id="todotable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Task') ?></th>
                    <th><?php echo $this->lang->line('Due Date') ?></th>
                    <th><?php echo $this->lang->line('Start') ?></th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th><?php echo $this->lang->line('Actions') ?></th>


                </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
    </div>
</article>


<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="status"><?php echo $this->lang->line('Change Status') ?></label>
                            <select name="stat" class="form-control mb-1">
                                <option value="Due">Pendiente</option>
                                <option value="Progress">Realizando</option>
                                <option value="Done">Hecho</option>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" id="taskid" value="">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="manager/set_task">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="task_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="task_title"><?php echo $this->lang->line('Details'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1" id="description">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Priority') ?> <strong><span
                                        id="priority"></span></strong>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned to') ?> <strong><span
                                        id="employee"></span></strong>

                        </div>
                    </div>
					<div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned to') ?> <span id="idorden"></span>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned by') ?> <strong><span
                                        id="assign"></span></strong>

                        </div>
                    </div>
					<div class="col-md-4" style="margin-top: 5px;">
									
                                    <a id="link_id_encuesta" href="<?php echo base_url('encuesta/create?id=') ?>"
                                       class="btn btn-primary btn-lg" style="border-right-width: 22px;border-left-width: 22px;"><i
                                                class="icon-file-text2"></i> Encuesta</a>

                                </div>
					<div class="modal-footer">
                  	<table class="table table-striped">
						<thead>
						<tr>
							<th><?php echo $this->lang->line('Files') ?></th>
						</tr>
						</thead>
						<tbody id="activity">
						</tbody>
					</table>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" id="taskid" value="">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#todotable').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('manager/todo_load_list')?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ],

        });

        $(document).on('click', ".set-task", function (e) {
            e.preventDefault();
            $('#taskid').val($(this).attr('data-id'));

            $('#pop_model').modal({backdrop: 'static', keyboard: false});

        });


        $(document).on('click', ".view_task", function (e) {
            e.preventDefault();

            var actionurl = 'manager/view_task';
            var id = $(this).attr('data-id');
            $('#task_model').modal({backdrop: 'static', keyboard: false});


            $.ajax({

                url: baseurl + actionurl,
                type: 'POST',
                data: {'tid': id},
                dataType: 'json',
                success: function (data) {
					$('#idorden').html(data.idorden);
                    $('#description').html(data.description);					
                    $('#task_title').html(data.name);
                    $('#employee').html(data.employee);
                    $('#assign').html(data.assign);
                    $('#priority').html(data.priority);
                    $("#link_id_encuesta").attr("href",baseurl+"encuesta/create?id="+data.idorden);
					var x =data.archivo;
					var objetos="";
					$(x).each(function(ind,dat){
						objetos+="<tr><td><a data-url='"+baseurl+"tools/file_handling?op=delete&name="+ dat.col1+"&type="+dat.type+"&invoice="+ dat.id +"' class='aj_delete'><i class='btn-danger btn-lg icon-trash-a'></i></a> <a class='n_item' href='"+baseurl +"userfiles/attach/"+dat.col1 + "'>"+dat.col1+"</a></td></tr>";
					});
					$("#activity").html(objetos);
                }

            });

        });


    });
</script>