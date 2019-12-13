<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">
                <h5><?php echo $this->lang->line('Add New Transaction') ?></h5>
                <hr>

                <div class="form-group row">
                    <div class="frmSearch"><label for="cst"
                                                  class="caption col-sm-2 col-form-label"><?php echo $this->lang->line('Search Payer') ?>
                            <small>(Optional)</small>
                        </label>
                        <div class="col-sm-6"><input type="text" class="form-control" name="cst" id="customer-box"
                                                     placeholder="Enter Customer Name or Mobile Number to search"
                                                     autocomplete="off"/><input type="button" id="clear-form"
                                                                                class="btn-small btn-danger sub-btn"
                                                                                value="Clear Fields">

                            <div id="customer-box-result"></div>
                        </div>
                    </div>

                </div>
                <div id="customerpanel" class="form-group row">
                    <label for="toBizName"
                           class="caption col-sm-2 col-form-label"><?php echo $this->lang->line('C/o') ?> <span
                                style="color: red;">*</span></label>
                    <div class="col-sm-6"><input type="hidden" name="payer_id" id="customer_id" value="0">
                        <input type="text" class="form-control required" name="payer_name" id="customer_name">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Account') ?></label>

                    <div class="col-sm-6">
                        <select name="pay_acc" class="form-control">
                            <?php
                            foreach ($accounts as $row) {
                                $cid = $row['id'];
                                $acn = $row['acn'];
                                $holder = $row['holder'];
                                echo "<option value='$cid'>$acn - $holder</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>

                <input type="hidden" name="act" value="add_product">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="date"><?php echo $this->lang->line('Date') ?></label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control required"
                               name="date" data-toggle="datepicker"
                               autocomplete="false">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="amount"><?php echo $this->lang->line('Amount') ?></label>

                    <div class="col-sm-6">
                        <input type="number" placeholder="Amount"
                               class="form-control margin-bottom  required" name="amount">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('Type') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <select name="pay_type" class="form-control">
                                <option value="Income" selected><?php echo $this->lang->line('Income') ?></option>
                                <option value="Expense"><?php echo $this->lang->line('Expense') ?></option>

                            </select>

                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Category') ?></label>

                    <div class="col-sm-6">
                        <select name="pay_cat" class="form-control">
                            <?php
                            foreach ($cat as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                echo "<option value='$title'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('Method') ?> </label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <select name="paymethod" class="form-control">
                                <option value="Cash" selected><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                <option value="Cheque"><?php echo $this->lang->line('Cheque') ?></option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Note') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Note"
                               class="form-control" name="note">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add transaction') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="transactions/save_trans" id="action-url">
                    </div>
                </div>
            </div>

        </form>
    </div>
</article>

