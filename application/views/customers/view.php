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
                            <h4 class="text-xs-center"><?php  echo  strtoupper($details['name']." ".$details['apellidos']) ?></h4>
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
                                        <a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
                                           class="btn btn-info btn-md"><i
                                                    class="icon-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h3><?php echo $this->lang->line('Balance') ?></h3>
                                    <?= amountFormat($details['balance']) ?>
                                    <hr>
                                    <h5><?php echo $this->lang->line('Balance Summary') ?></h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-primary float-xs-right"><?php echo amountFormat($money['credit']) ?></span>
                                            <?php echo $this->lang->line('Income') ?>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-danger float-xs-right"><?php echo amountFormat($money['debit']) ?></span>
                                            <?php echo $this->lang->line('Expenses') ?>
                                        </li>

                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-danger float-xs-right"><?php echo amountFormat($due['total']-$due['pamnt']) ?></span>
                                            <?php echo $this->lang->line('Total Due') ?>
                                        </li>

                                    </ul>

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <h5><?php echo $this->lang->line('') ?>SEDE
                                        <small><?php echo $invoice['ron'] ?></small>
                                    </h5>


                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="offset-md-2 col-md-4">
                                    <a href="<?php echo base_url('customers/changepassword?id=' . $details['id']) ?>"
                                       class="btn btn-danger btn-md"><i
                                                class="icon-pencil"></i> <?php echo $this->lang->line('Change Password') ?>
                                    </a>
                                </div>
                                
                                <div class="col-md-12"><br>
                                    <h5><?php echo $this->lang->line('Change Customer Picture') ?></h5><input
                                            id="fileupload"
                                            type="file"
                                            name="files[]"></div>
                                           
                               
                                            

                                <div id="progress" class="progress1">
                                    <div class="progress-bar progress-bar-success"></div>
                                     
                                </div>
                                
                            </div>
                            <hr>
                             <strong>DATOS DE INTEGRACION</strong>
                            <hr>                            
                                <div class="col-md-3">
                                    <strong><?php echo $this->lang->line('') ?>Mikrotik:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Usuario:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Pasword:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Servicio:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Perfil:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Local:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Remota:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Comt/rio:</strong>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $customergroup['title'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['name_s'] ?>                                   
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['contra'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['servicio'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['perfil'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['Iplocal'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['Ipremota'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $barrio['barrio'] ?>                                    
                                </div>
                                
                                
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="card card-block">
                            <h4><?php echo $this->lang->line('Customer Details') ?></h4>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Usuario Nº:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['id'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Name') ?>s:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['name'] ?> <?php echo $details['dosnombre'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Apellidos:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['unoapellido'] ?> <?php echo $details['dosapellido'] ?>
                                </div>
                    
                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Empresa:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['company'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Celular:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['celular'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Celular ADI:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['celular2'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Correo:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['email'] ?>
                                </div>

                            </div>
							<hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Fecha de nacimiento:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['nacimiento'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Tipo:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['tipo_cliente'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong>Documento:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['tipo_documento'] .". ". $details['documento'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Departamento:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo  $departamentos['departamento'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Ciudad:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $ciudad['ciudad'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Localidad:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $localidad['localidad'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Barrio:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $barrio['barrio'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Direccion:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['nomenclatura']." ".$details['numero1'].$details['adicionauno']." N° ".$details['numero2'].$details['adicional2']." - ".$details['numero3'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Referencia:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['residencia'].", ".$details['referencia'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row mt-3">
                                <div class="col-md-4">

                                    <a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg"><i
                                                class="icon-file-text2"></i> <?php echo $this->lang->line('View Invoices') ?></a>

                                </div>
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('customers/transactions?id=' . $details['id']) ?>"
                                       class="btn btn-success btn-lg"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('View Transactions') ?>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('customers/balance?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg"><i
                                                class="icon-wallet"></i> <?php echo $this->lang->line('Wallet') ?>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-xs-center">Wallet Recharge/<?php echo $this->lang->line('Payment History') ?></h5>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('Amount') ?></th>
                                    <th><?php echo $this->lang->line('Note') ?></th>


                                </tr>
                                </thead>
                                <tbody id="activity">
                                <?php foreach ($activity as $row) {

                                    echo '<tr>
                            <td>' . amountFormat($row['col1']) . '</td><td>' . $row['col2'] . '</td>
                           
                        </tr>';
                                } ?>

                                </tbody>
                            </table>


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
                                    for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $details['name'].$details['apellidos'] ?>"></div>
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
        var url = '<?php echo base_url() ?>customers/displaypic?id=<?php echo $details['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');
                $("#dpic").load(function () {
                    $(this).hide();
                    $(this).fadeIn('slow');
                }).attr('src', '<?php echo base_url() ?>userfiles/customers/' + data.result);


            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
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