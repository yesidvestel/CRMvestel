<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5><?php echo $this->lang->line('Edit Account') ?></h5>
                <hr>


                <input type="hidden" name="acid" value="<?php echo $account['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="accno"><?php echo $this->lang->line('Account No') ?></label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom required" name="accno"
                               value="<?php echo $account['acn'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="holder"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-8">


                        <input type="text" name="holder" class="form-control required"
                               aria-describedby="sizing-addon1" value="<?php echo $account['holder'] ?>">

                    </div>

                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="acode"><?php echo $this->lang->line('Note') ?></label>

                    <div class="col-sm-8">


                        <input type="text" name="acode" class="form-control"
                               aria-describedby="sizing-addon1" value="<?php echo $account['code'] ?>">

                    </div>

                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="accounts/editacc" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>

</article>

