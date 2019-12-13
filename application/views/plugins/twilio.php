<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5>Twilio SMS Service</h5>
                <hr>


                <p>You can send bills as SMS to your customers using Twilio SMS Service. You can also setup urls
                    shortner plugin to convert long invoice urls to small and more user friendly in SMS.</p>
                <p>You can signup here for keys. <a href="https://www.twilio.com/">https://www.twilio.com/</a></p>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Account SID</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key1"
                               value="<?php echo $universal['key1'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Auth Token</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key2"
                               value="<?php echo $universal['key2'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Send Id</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="sender"
                               value="<?php echo $universal['url'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms"><?php echo $this->lang->line('Enable') ?></label>

                    <div class="col-sm-8">
                        <select name="enable" class="form-control">

                            <?php switch ($universal['active']) {
                                case 1 :
                                    echo '<option value="1">--Yes--</option>';
                                    break;
                                case 0 :
                                    echo '<option value="0">--No--</option>';
                                    break;

                            } ?>
                            <option value="1">Yes</option>
                            <option value="0">No</option>


                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="plugins/twilio" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>

</article>