<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class=" animated fadeInRight">
                <div class="col-md-8">
                    <div class="card card-block bg-white">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <form method="post" id="data_form" class="form-horizontal">
                            <div class="grid_3 grid_4">

                                <h5><?php echo $this->lang->line('Employee Details') ?> </h5>
                                <hr>
                                <div class="form-group row">

                                    <label class="col-sm-6 col-form-label"
                                           for="name"><?php echo $this->lang->line('UserName') ?>
                                        <small class="error">(Use Only a-z0-9)</small>
                                    </label>

                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control margin-bottom required" name="username"
                                               placeholder="username">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-6 col-form-label" for="email">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" placeholder="email"
                                               class="form-control margin-bottom required" name="email"
                                               placeholder="email">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-6 col-form-label"
                                           for="password"><?php echo $this->lang->line('Password') ?>
                                        <small>(min length 6)</small>
                                    </label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Password"
                                               class="form-control margin-bottom required" name="password"
                                               placeholder="password">
                                    </div>
                                </div>
                                <?php if ($this->aauth->get_user()->roleid >= 0) { ?>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('UserRole') ?></label>

                                        <div class="col-sm-5">
                                            <select name="roleid" class="form-control margin-bottom">
                                                <option value="5">Super usuario</option>
                                                <option value="4">Administrativo</option>
                                                <option value="3">Caja y ventas</option>
                                                <option value="2">Tecnicos</option>
                                                
                                            </select>
                                        </div>
                                    </div>


                                <?php } ?>

                                <hr>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('Name') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Nombre completo"
                                               class="form-control margin-bottom required" name="name"
                                               placeholder="Full name">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Documento</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Numero de documento"
                                               class="form-control margin-bottom required" name="documento"
                                               placeholder="Full name">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Fecha ingreso</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="ingreso"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>RH</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Grupo sanguineo"
                                               class="form-control margin-bottom" name="rh">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Eps</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Eps donde se encuentra afiliado"
                                               class="form-control margin-bottom" name="eps">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Fondo de pension</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Entidad donde este afiliado a pension"
                                               class="form-control margin-bottom" name="pensiones">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('Address') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Direccion completa"
                                               class="form-control margin-bottom" name="address">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="city"><?php echo $this->lang->line('City') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Ciudad"
                                               class="form-control margin-bottom" name="city">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="city">Departamento</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Departamento"
                                               class="form-control margin-bottom" name="region">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="country"><?php echo $this->lang->line('Country') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control margin-bottom" name="country">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="phone">Celular</label>

                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control margin-bottom" name="phone">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"></label>

                                    <div class="col-sm-4">
                                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                               value="<?php echo $this->lang->line('Add') ?>"
                                               data-loading-text="Adding...">
                                        <input type="hidden" value="employee/submit_user" id="action-url">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> </div>
<script type="text/javascript">
    $("#profile_add").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'user/submit_user';
        actionProduct1(actionurl);
    });
</script>

<script>

    function actionProduct1(actionurl) {

        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });


    }
</script>