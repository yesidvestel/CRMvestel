<article class="content">
    <div>
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="">
            <div class="col-md-4">
                <div class="card card-block"><h5><?php echo $this->lang->line('Update Profile Picture') ?></h5>
                    <hr>
                    <div class="ibox-content no-padding border-left-right">
                        <img alt="profile picture" id="dpic" class="img-responsive"
                             src="<?php echo base_url('userfiles/employee/') . $user['picture'] ?>">
                    </div>
                    <hr>
                    <p><label for="fileupload"><?php echo $this->lang->line('Change Your Picture') ?></label><input
                                id="fileupload" type="file"
                                name="files[]"></p></div>


                <!-- signature -->

                <div class="card card-block"><h5><?php echo $this->lang->line('Update Your Signature') ?></h5>
                    <hr>
                    <div class="ibox-content no-padding border-left-right">
                        <img alt="sign_pic" id="sign_pic" class="img-responsive"
                             src="<?php echo base_url('userfiles/employee_sign/') . $user['sign'] ?>">
                    </div>
                    <hr>
                    <p>
                        <label for="sign_fileupload"><?php echo $this->lang->line('Change Your Signature') ?></label><input
                                id="sign_fileupload" type="file"
                                name="files[]"></p></div>


            </div>
            <div class="col-md-8">
                <div class="card card-block">
                    <form method="post" id="product_action" class="form-horizontal">
                        <div class="grid_3 grid_4">

                            <h5><?php echo $this->lang->line('Update Your Details') ?> (<?php echo $user['username'] ?>
                                )</h5>
                            <hr>


                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom  required" name="name"
                                           value="<?php echo $user['name'] ?>">
                                </div>
                            </div>
							<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Documento</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Numero de documento"
                                               class="form-control margin-bottom required" name="documento"
                                               placeholder="Full name" value="<?php echo $user['dto'] ?>">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Fecha ingreso</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="ingreso"
                                                   data-toggle="datepicker"
                                                   autocomplete="false" value="<?php echo $user['inicio'] ?>">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Tipo de sangre + RH</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Grupo sanguineo"
                                               class="form-control margin-bottom" name="rh" value="<?php echo $user['rh'] ?>">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Eps</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Eps donde se encuentra afiliado"
                                               class="form-control margin-bottom" name="eps" value="<?php echo $user['eps'] ?>">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Fondo de pension</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Entidad donde este afiliado a pension"
                                               class="form-control margin-bottom" name="pensiones" value="<?php echo $user['pensiones'] ?>">
                                    </div>
                                </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="address"
                                           class="form-control margin-bottom required" name="address"
                                           value="<?php echo $user['address'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="city"><?php echo $this->lang->line('City') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="city"
                                           class="form-control margin-bottom required" name="city"
                                           value="<?php echo $user['city'] ?>">
                                </div>
                            </div>
                            

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="postbox"><?php echo $this->lang->line('') ?>Departamento</label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Departamento de origen"
                                           class="form-control margin-bottom" name="region"
                                           value="<?php echo $user['region'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="phone"
                                           class="form-control margin-bottom required" name="phone"
                                           value="<?php echo $user['phone'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('') ?>Area</label>

                                <div class="col-sm-10">
                                   <select name="area" class="form-control margin-bottom">
									<option value="<?php echo $get_area['ida'] ?>">=><?php echo $get_area['nombre_area'] ?></option>
									<?php
										foreach ($area as $row) {
											$cid = $row['ida'];
											$title = $row['nombre_area'];
											echo "<option value='$cid'>$title</option>";
										}
										?>
									</select>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="email"
                                           class="form-control margin-bottom  required" name="email"
                                           value="<?php echo $user['email'] ?>" disabled>
                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="submit" id="profile_update" class="btn btn-success margin-bottom"
                                           value="<?php echo $this->lang->line('Update') ?>"
                                           data-loading-text="Updating...">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</article>
<script type="text/javascript">
    $("#profile_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'user/update';
        actionProduct(actionurl);
    });
</script>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>user/displaypic?id=<?php echo $user['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');
                $("#dpic").load(function () {
                    $(this).hide();
                    $(this).fadeIn('slow');
                }).attr('src', '<?php echo base_url() ?>userfiles/employee/' + data.result);


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


        // Sign
        var sign_url = '<?php echo base_url() ?>user/user_sign?id=<?php echo $user['id'] ?>';
        $('#sign_fileupload').fileupload({
            url: sign_url,
            dataType: 'json',
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');
                $("#sign_pic").load(function () {
                    $(this).hide();
                    $(this).fadeIn('slow');
                }).attr('src', '<?php echo base_url() ?>userfiles/employee_sign/' + data.result);


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