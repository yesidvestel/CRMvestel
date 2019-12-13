<article class="content">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card card-block">

        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('Expense Statement') ?></h6>
            <hr>

            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">

                        <p><?php echo $this->lang->line('This Month Expenses') ?><?php echo amountFormat($income['monthinc']) ?></p>
                        <p id="param1"></p>
                        <p id="param2"></p>


                    </div>
                </div>

            </div>

        </div>

    </div>
    <div class="card card-block">
        <div class="grid_3 grid_4">
            <form method="post" id="product_action" class="form-horizontal">
                <div class="grid_3 grid_4">
                    <h6><?php echo $this->lang->line('Custom Range') ?></h6>
                    <hr>


                    <div class="form-group row">

                        <label class="col-sm-3 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Account') ?></label>

                        <div class="col-sm-6">
                            <select name="pay_acc" class="form-control">
                                <option value='0'><?php echo $this->lang->line('All Accounts') ?></option>
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


                    <div class="form-group row">

                        <label class="col-sm-3 control-label"
                               for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control required"
                                   placeholder="Start Date" name="sdate" id="sdate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3 control-label"
                               for="edate"><?php echo $this->lang->line('To Date') ?></label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control required"
                                   placeholder="End Date" name="edate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-3 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="hidden" name="check" value="ok">
                            <input type="submit" id="calculate_expense" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Calculate') ?>"
                                   data-loading-text="Calculating...">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</article>
