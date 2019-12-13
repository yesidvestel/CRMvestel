<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5><?php echo $this->lang->line('Edit Billing Details') ?></h5>
                <hr>


                <input type="hidden" name="id" value="<?php echo $company['id'] ?>">
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="invoiceprefix"><?php echo $this->lang->line('Invoice Prefix') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="taxid"
                               class="form-control margin-bottom  required" name="invoiceprefix"
                               value="<?php echo $company['prefix'] ?>" maxlength="5">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="taxstatus"><?php echo $this->lang->line('TAX Status') ?></label>

                    <div class="col-sm-6">
                        <select name="taxstatus" class="form-control">

                            <?php if ($company['tax'] == 1) {
                                echo '<option value="1">*' . $this->lang->line('On') . '*</option>';


                            } ?>
                            <option value="0"><?php echo $this->lang->line('Off') ?></option>
                            <option value='1'><?php echo $this->lang->line('On') ?></option>

                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="taxid"><?php echo $this->lang->line('TAX ID') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="taxid"
                               class="form-control margin-bottom" name="taxid"
                               value="<?php echo $company['taxid'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="currency">Language</label>

                    <div class="col-sm-6">
                        <select name="language" class="form-control">

                            <?php
                            echo '<option value="' . $company['lang'] . '">--' . $company['lang'] . '--</option>';
                            ?>
                            <option value="english">English</option>
                            <option value='arabic'>Arabic</option>
                            <option value='bengali'>Bengali</option>
                            <option value='czech'>Czech</option>
                            <option value="chinese-simplified">Chinese-simplified</option>
                            <option value='chinese-traditional'>Chinese-traditional</option>
                            <option value='dutch'>Dutch</option>
                            <option value='french'>French</option>
                            <option value='german'>German</option>
                            <option value='greek'>Greek</option>
                            <option value='hindi'>Hindi</option>
                            <option value='indonesian'>Indonesian</option>
                            <option value='italian'>Italian</option>
                            <option value='japanese'>Japanese</option>
							<option value='korean'>Korean</option>
                            <option value='latin'>Latin</option>
                            <option value='polish'>Polish</option>
                            <option value='portuguese'>Portuguese</option>
                            <option value='russian'>Russian</option>
                            <option value='swedish'>Swedish</option>
                            <option value='spanish'>Spanish</option>
							<option value='turkish'>Turkish</option>
                            <option value='urdu'>Urdu</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="invoiceprefix"><?php echo $this->lang->line('Quote').' '.$this->lang->line('Prefix') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="q_prefix"
                               value="<?php echo $prefix['name'] ?>"  maxlength="5">
                    </div>
                </div>
                 <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="invoiceprefix"><?php echo $this->lang->line('Purchase Order').' '.$this->lang->line('Prefix') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="p_prefix"
                               value="<?php echo $prefix['key1'] ?>"  maxlength="5">
                    </div>
                </div>

                  <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="invoiceprefix"><?php echo $this->lang->line('RECCURING INVOICE').' '.$this->lang->line('Prefix') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="r_prefix"
                               value="<?php echo $prefix['key2'] ?>"  maxlength="5">
                    </div>
                </div>
                   <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="invoiceprefix"><?php echo $this->lang->line('Stock Return').' '.$this->lang->line('Prefix') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="s_prefix"
                               value="<?php echo $prefix['url'] ?>"  maxlength="5">
                    </div>
                </div>
                   <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="invoiceprefix"><?php echo $this->lang->line('Transactions').' '.$this->lang->line('Prefix') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="t_prefix"
                               value="<?php echo $prefix['method'] ?>"  maxlength="5">
                    </div>
                </div>
                   <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="invoiceprefix"><?php echo $this->lang->line('Others').' '.$this->lang->line('Prefix') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="o_prefix"
                               value="<?php echo $prefix['other'] ?>"  maxlength="5">
                        <small>-</small>
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
        var actionurl = baseurl + 'settings/billing';
        actionProduct(actionurl);
    });
</script>

