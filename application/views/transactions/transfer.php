<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">
                <h5><?php echo $this->lang->line('Add New Transfer') ?></h5>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('From Account') ?></label>

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

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('To Account') ?></label>

                    <div class="col-sm-6">
                        <select name="pay_acc2" class="form-control">
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

                    <label class="col-sm-2 col-form-label"
                           for="amount"><?php echo $this->lang->line('Amount') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Amount"
                               class="form-control margin-bottom  required" name="amount">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add transaction') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="transactions/save_transfer" id="action-url">
                    </div>
                </div>
            </div>

        </form>
    </div>
</article>

