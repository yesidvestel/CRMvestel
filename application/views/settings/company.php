<article class="content">
    <div class="">
        <div class="col-md-6">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>

                <form method="post" id="product_action" class="form-horizontal">
                    <div class="grid_3 grid_4">

                        <h5><?php echo $this->lang->line('Edit Company Details') ?></h5>
                        <hr>


                        <input type="hidden" name="id" value="<?php echo $company['id'] ?>">


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="name"><?php echo $this->lang->line('Company Name') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Name"
                                       class="form-control margin-bottom  required" name="name"
                                       value="<?php echo $company['cname'] ?>">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="address"><?php echo $this->lang->line('Address') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="address"
                                       class="form-control margin-bottom  required" name="address"
                                       value="<?php echo $company['address'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="city"><?php echo $this->lang->line('City') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="city"
                                       class="form-control margin-bottom  required" name="city"
                                       value="<?php echo $company['city'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="city"><?php echo $this->lang->line('Region') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="city"
                                       class="form-control margin-bottom  required" name="region"
                                       value="<?php echo $company['region'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="country"><?php echo $this->lang->line('Country') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Country"
                                       class="form-control margin-bottom  required" name="country"
                                       value="<?php echo $company['country'] ?>">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="PostBox"
                                       class="form-control margin-bottom  required" name="postbox"
                                       value="<?php echo $company['postbox'] ?>">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="phone"><?php echo $this->lang->line('Phone') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="phone"
                                       class="form-control margin-bottom  required" name="phone"
                                       value="<?php echo $company['phone'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="email"><?php echo $this->lang->line('Email') ?></label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="email"
                                       class="form-control margin-bottom  required" name="email"
                                       value="<?php echo $company['email'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="email"><?php echo $this->lang->line('Tax') ?> ID </label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="TAX ID"
                                       class="form-control margin-bottom" name="taxid"
                                       value="<?php echo $company['taxid'] ?>">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"></label>

                            <div class="col-sm-4">
                                <input type="submit" id="company_update" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Update Company') ?>"
                                       data-loading-text="Updating...">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <form method="post" id="product_action" class="form-horizontal">
                    <div class="grid_3 grid_4">

                        <h5><?php echo $this->lang->line('Company Logo') ?></h5>
                        <hr>


                        <input type="hidden" name="id" value="<?php echo $company['id'] ?>">
                        <div class="ibox-content no-padding border-left-right">
                            <img alt="image" id="dpic" class="img-responsive"
                                 src="<?php echo base_url('userfiles/company/') . $company['logo'] ?>">
                        </div>

                        <hr>
                        <p><label for="fileupload"><?php echo $this->lang->line('Change Company Logo') ?></label><input
                                    id="fileupload" type="file"
                                    name="files[]"></p>
                        <pre>Recommended logo size is 500x200px.</pre>


                    </div>
                </form>
            </div>
        </div>
    </div>
</article>
<script type="text/javascript">
    $("#company_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/company';
        actionProduct(actionurl);
    });
</script>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    $(function () {
        'use strict';
        var url = '<?php echo base_url() ?>settings/companylogo?id=<?php echo $company['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {

                $("#dpic").load(function () {
                    $(this).hide();
                    $(this).fadeIn('slow');
                }).attr('src', '<?php echo base_url() ?>userfiles/company/' + data.result);


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