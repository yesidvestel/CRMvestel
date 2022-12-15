<article class="content">
    <div class="">
        <div class="">
            <div class="col-md-4">
                <div class="card card-block">
                    <div class="ibox-title" align="center">
                        <h5><?php echo $this->lang->line('Employee Details') ?></h5>
                    </div>
                    <div>
                        <div class="ibox-content no-padding border-left-right" align="center">
                            <img alt="image" class="img-responsive"
                                 src="<?php echo base_url('userfiles/employee/' . $employee['picture']); ?>">
                        </div>
                        <hr>
                        <div class="ibox-content profile-content">
                            <h4><strong><?php echo $employee['name'] ?></strong></h4>
                            <p><i class="icon-map-marker"></i> <?php echo $employee['city'] ?></p>

                            <div class="row m-t-lg">
                                <div class="col-md-12">
                                    <strong><?php echo $this->lang->line('Address') ?>
                                        : </strong><?php echo $employee['address'] ?>
                                </div>

                            </div>
                            <div class="row m-t-lg">
                                <div class="col-md-12">
                                    <strong><?php echo $this->lang->line('City') ?>
                                        : </strong><?php echo $employee['city'] ?>
                                </div>

                            </div>
                            <div class="row m-t-lg">
                                <div class="col-md-12">
                                    <strong>Departamento
                                        : </strong><?php echo $employee['region'] ?>
                                </div>

                            </div>
                            <div class="row m-t-lg">
                                <div class="col-md-12">
                                    <strong><?php echo $this->lang->line('Country') ?>
                                        : </strong><?php echo $employee['country'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-12">
                                    <strong><?php echo $this->lang->line('Phone') ?></strong> <?php echo $employee['phone']; ?>
                                </div>

                            </div>
                            <div class="row m-t-lg">
                                <div class="col-md-12">
                                    <strong>EMail</strong> <?php echo $employee['email']; ?>
                                </div>

                            </div>
							<div class="row">
								<table class="table table-striped">
									<thead>
									<tr>
										<th><?php echo $this->lang->line('Files') ?></th>
									</tr>
									</thead>
									<tbody id="activity">
									<?php foreach ($attach as $row) {

										echo '<tr><td><a data-url="' . base_url() . 'employee/file_handling?op=delete&name=' . $row['col1'] . '&type='.$row['type'].'&invoice=' . $eid . '" class="aj_delete"><i class="btn-danger btn-lg icon-trash-a"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
									} ?>

									</tbody>
								</table>
								<!-- The fileinput-button span is used to style the file input field as button -->
								<span class="btn btn-success fileinput-button">
								<i class="glyphicon glyphicon-plus"></i>
								
									<!-- The file input field used as target for the file upload widget -->
								<input id="fileupload2" type="file" name="files[]" multiple>
								</span>
								<br>
								<pre>tipos: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
								<br>
								<!-- The global progress bar -->
								<div id="progress2" class="progress">
									<div class="progress-bar progress-bar-success"></div>
								</div>
								<!-- The container for the uploaded files -->
								<table id="files2" class="files"></table>
								<br>
                    		</div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-block">
                    <div class="container">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="hero-widget well well-sm">
                                    <div class="icon">
                                        <i class="icon-file-text-o"></i>
                                    </div>
                                    <div class="text">

                                        <label class="text-muted"><?php echo $this->lang->line('Invoices') ?></label>
                                    </div>
                                    <div class="options">
                                        <a href="<?php echo base_url('employee/invoices?id=' . $eid) ?>"
                                           class="btn btn-primary btn-lg"><i
                                                    class="icon-eye"></i> <?php echo $this->lang->line('View') ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="hero-widget well well-sm">
                                    <div class="icon">
                                        <i class="icon-book"></i>
                                    </div>
                                    <div class="text">

                                        <label class="text-muted"><?php echo $this->lang->line('Transactions') ?></label>
                                    </div>
                                    <div class="options">
                                        <a href="<?php echo base_url('employee/transactions?id=' . $eid) ?>"
                                           class="btn btn-primary btn-lg"><i
                                                    class="icon-eye"></i> <?php echo $this->lang->line('View') ?></a>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="hero-widget well well-sm">
                                    <div class="icon">
                                        <i class="icon-tasks"></i>
                                    </div>
                                    <div class="text">

                                        <label class="text-muted"><?php echo $this->lang->line('Sales') ?></label>
                                    </div>
                                    <div class="options">
                                        <a href="#pop_model" data-toggle="modal" data-remote="false"
                                           class="btn btn-primary btn-lg"><i
                                                    class="icon-eye"></i> <?php echo $this->lang->line('View') ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="hero-widget well well-sm">
                                    <div class="icon">
                                        <i class="icon-money4"></i>
                                    </div>
                                    <div class="text">

                                        <label class="text-muted"><?php echo $this->lang->line('Total Income') ?></label>
                                    </div>
                                    <div class="options">
                                        <a href="#pop_model2" data-toggle="modal" data-remote="false"
                                           class="btn btn-primary btn-lg"><i
                                                    class="icon-eye"></i> <?php echo $this->lang->line('View') ?></a>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="hero-widget well well-sm">
                                    <div class="icon">
                                        <i class="icon-user"></i>
                                    </div>
                                    <div class="text">

                                        <label class="text-muted"><?php echo $this->lang->line('Account') ?></label>
                                    </div>
                                    <div class="options">
                                        <a href="<?php echo base_url('employee/update?id=' . $eid) ?>"
                                           class="btn btn-primary btn-lg"><i class="icon-pencil"></i> <?php echo $this->lang->line('Edit') ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="hero-widget well well-sm">
                                    <div class="icon">
                                        <i class="icon-key"></i>
                                    </div>
                                    <div class="text">

                                        <label class="text-muted"><?php echo $this->lang->line('Change Password') ?></label>
                                    </div>
                                    <div class="options">
                                        <a href="<?php echo base_url('employee/updatepassword?id=' . $eid) ?>"
                                           class="btn btn-primary btn-lg"><i
                                                    class="icon-edit"></i><?php echo $this->lang->line('Change') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</article>
<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Calculate Total Sales') ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <?php echo $this->lang->line('Do you want mark') ?>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="eid" id="invoiceid" value="<?php echo $eid ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" id="action-url" value="employee/calc_sales">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Yes') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="pop_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Calculate Income') ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model2">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label for="pmethod">Mark As</label>
                            Do you want to calculate total income expenses of this employee ?
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="eid" id="invoiceid" value="<?php echo $eid ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="hidden" id="action-url" value="employee/calc_income">
                        <button type="button" class="btn btn-primary" id="submit_model2">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
$(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>employee/file_handling?id=<?php echo $eid ?>';
        $('#fileupload2').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files2').append('<tr><td><a data-url="<?php echo base_url() ?>employee/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $eid ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress2 .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
	//borrar documento
	  $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });
</script>