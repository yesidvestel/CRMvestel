<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5><?php echo $this->lang->line('Currency Exchange') ?></h5>
                <hr>

                <p>Application has integrated currencylayer.com API. It offers a real-time currency conversion for your
                    invoices. Accurate Exchange Rates for 168 World Currencies with data updates ranging from every 60
                    minutes down to stunning 60 seconds. Please visit <a href="https://currencylayer.com/">currencylayer.com</a>
                    to get API key.
                <p>
                <p> Please do not forget set the CRON job for automatic base rate updates in background.</p>
                <p> API Integration and Cron Job are optionals, you can manually set exchange rates here <a
                            href="<?php echo base_url() ?>paymentgateways/currencies"><?php echo base_url() ?>
                        paymentgateways/currencies</a></p>


                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="currency"><?php echo $this->lang->line('Base Currency Code') ?>
                        <small>(i.e. USD,AUD)</small>
                    </label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="currency"
                               value="<?php echo $exchange['url'] ?>" maxlength="3">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-4 col-form-label" for="key1"><?php echo $this->lang->line('API Key') ?></label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key1"
                               value="<?php echo $exchange['key1'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="key2">API Endpoint</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key2"
                               value="<?php echo $exchange['key2'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="enable"><?php echo $this->lang->line('Enable Exchange') ?></label>

                    <div class="col-sm-8">
                        <?php if ($exchange['active'] == 1) {
                            $env = 'Yes';
                        } else {
                            $env = 'No';
                        } ?>
                        <select class="form-control" name="enable">
                            <option value="<?php echo $exchange['active'] ?>">
                                --<?php echo $this->lang->line($env) ?>--
                            </option>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="paymentgateways/exchange" id="action-url">
                    </div>
                </div>

            </div>
        </form>

    </div>

</article>

