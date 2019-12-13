<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5><?php echo $this->lang->line('Currency Format') ?></h5>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="invoiceprefix"><?php echo $this->lang->line('Currency') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom" name="currency"
                               value="<?php echo $currency['currency'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="currency"><?php echo $this->lang->line('Decimal Saparator') ?></label>

                    <div class="col-sm-6">
                        <select name="deci_sep" class="form-control">
                            <?php
                            echo '<option value="' . $currency['key1'] . '">' . $currency['key1'] . '</option>';

                            ?>
                            <option value=",">, (Comma)</option>
                            <option value=".">. (Dot)</option>
                            <option value="">None</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="thous_sep"><?php echo $this->lang->line('Thousand Saparator') ?></label>

                    <div class="col-sm-6">
                        <select name="thous_sep" class="form-control">
                            <?php
                            echo '<option value="' . $currency['key2'] . '">' . $currency['key2'] . '</option>'; ?>
                            <option value=",">, (Comma)</option>
                            <option value=".">. (Dot)</option>
                            <option value="">None</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="currency"><?php echo $this->lang->line('Decimal Place') ?></label>

                    <div class="col-sm-6">
                        <select name="decimal" class="form-control">
                            <?php
                            echo '<option value="' . $currency['url'] . '">' . $currency['url'] . '</option>'; ?>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="spost"><?php echo $this->lang->line('Symbol Position') ?></label>

                    <div class="col-sm-6">
                        <select name="spos" class="form-control">
                            <?php
                            if ($currency['method'] == 'l') $method = '**Left**'; else $method = '**Right**';
                            echo '<option value="' . $currency['method'] . '">' . $method . '</option>'; ?>
                            <option value="l">Left</option>
                            <option value="r">Right</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/currency';
        actionProduct(actionurl);
    });
</script>

