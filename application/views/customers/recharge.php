<div class="app-content content container-fluid">
    <div class="content-wrapper">


        <div class="content-body"><div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <section class="card">
                <div class="card-block">
<h2 class="text-xs-center">Current Balance is <?= amountFormat($details['balance']) ?></h2>




                </div>
                <div class="card-block">
                    <form method="post" id="data_form" class="form-horizontal">
                        <input type="hidden" value="<?=$details['id'] ?>" name="id">

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="amount"><?php echo $this->lang->line('Amount') ?></label>

                            <div class="col-sm-3">
                                <input type="number" placeholder="Enter amount in 0.00"
                                       class="form-control margin-bottom " name="amount">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="name"></label>

                            <div class="col-sm-3">
                                <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                       value="Add Balance" data-loading-text="Updating...">
                                <input type="hidden" value="customers/balance" id="action-url">
                            </div>
                        </div>



                    </form>



                </div>
                <h5 class="text-xs-center"><?php echo $this->lang->line('Payment History') ?></h5>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th><?php echo $this->lang->line('Note') ?></th>


                    </tr>
                    </thead>
                    <tbody id="activity">
                    <?php foreach ($activity as $row) {

                        echo '<tr>
                            <td>' . amountFormat($row['col1']) . '</td><td>' . $row['col2'] . '</td>
                           
                        </tr>';
                    } ?>

                    </tbody>
                </table>
        </div>

            </section>
        </div>
    </div>
</div>
