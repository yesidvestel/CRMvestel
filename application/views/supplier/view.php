<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>

        <div class="content-body">
            <section>
                <div class="row wrapper white-bg page-heading">
                    <div class="col-md-4">
                        <div class="card card-block">
                            <h4 class="text-xs-center"><?php echo $details['name'] ?></h4>
                            <div class="ibox-content mt-2">
                                <img alt="image" id="dpic" class="img-responsive"
                                     src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
                            </div>
                            <hr>
                            <div class="user-button">
                                <div class="row mt-3">
                                    <div class="col-md-6">

                                        <a href="#sendMail" data-toggle="modal" data-remote="false"
                                           class="btn btn-primary btn-md  " data-type="reminder"><i
                                                    class="icon-envelope"></i> <?php echo $this->lang->line('Send Message') ?>
                                        </a>

                                    </div>
                                    <div class="col-md-6">
                                        <a href="<?php echo base_url('supplier/edit?id=' . $details['id']) ?>"
                                           class="btn btn-warning btn-md"><i
                                                    class="icon-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5><?php echo $this->lang->line('Balance Summary') ?></h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-primary float-xs-right"><?php echo amountFormat($money['credit']) . '</span>' . $this->lang->line('Income') ?>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-danger float-xs-right"><?php echo amountFormat($money['debit']) ?></span>
                                            <?php echo $this->lang->line('Expenses') ?>
                                        </li>

                                    </ul>

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

										echo '<tr><td><a data-url="' . base_url() . 'supplier/file_handling?op=delete&name=' . $row['col1'] . '&type='.$row['type'].'&invoice=' . $details['id'] . '" class="aj_delete"><i class="btn-danger btn-lg icon-trash-a"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
									} ?>

									</tbody>
								</table>
								<!-- The fileinput-button span is used to style the file input field as button -->
								<span class="btn btn-success fileinput-button">
								<i class="glyphicon glyphicon-plus"></i>
								
									<!-- The file input field used as target for the file upload widget -->
								<input id="fileupload" type="file" name="files[]" multiple>
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
                    <div class="col-md-8">
                        <div class="card card-block">
                            <h4><?php if($details['categoria']==1){ $cat='Productos';}else{$cat='Servicios';} echo $this->lang->line('Supplier Details').' de '.$cat ?></h4>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Name') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['name'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>NIT</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['nit'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Company') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['company'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Phone') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['phone'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong>Email</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['email'] ?>
                                </div>

                            </div>
                            
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Address') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['address'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('City') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['city'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Departamento</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['region'] ?>
                                </div>

                            </div>
                            <hr>
							<?php if ($details['pago']=='Cuenta'){ ?>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Cuenta</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['cuenta'] ?>,
									<?php echo $details['typo'] ?>,
                                    <?php echo $details['banco'] ?>
                                </div>

                            </div>
                            <hr>
                            <?php } ?>
                            <hr>
                            <div class="row mt-3">
                                <div class="col-md-6">

                                    <a href="<?php echo base_url('supplier/invoices?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg"><i
                                                class="icon-file-text2"></i> <?php echo $this->lang->line('View Purchase Orders') ?>
                                    </a>

                                </div>
                                <div class="col-md-6">
                                    <a href="<?php echo base_url('supplier/transactions?id=' . $details['id']) ?>"
                                       class="btn btn-success btn-lg"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('View Transactions') ?>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</div>


<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Email</h4>
            </div>

            <div class="modal-body">
                <form id="sendmail_form">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                       value="<?php echo $details['email'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Supplier Name') ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $details['name'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="cid" name="tid" value="<?php echo $details['id'] ?>">
                    <input type="hidden" id="action-url" value="communication/send_general">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendNow"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>supplier/file_handling?id=<?php echo $details['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files2').append('<tr><td><a data-url="<?php echo base_url() ?>supplier/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $details['id'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

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
<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });


    });


</script>