<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">

            <div class="well col-xs-12">
                <div class="row">
                    <div class="text-center">
                        <h5><?php echo $this->lang->line('Transaction Details') ?> </h5><?php echo'<a href="' . base_url() . 'transactions/print_t?id=' . $trans['id'] . '" class="btn btn-info btn-xs"  title="Print"><span class="icon-print"></span></a>'; ?>
                    </div>
                    <hr>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <?php echo '<strong>' . $this->config->item('ctitle') . '</strong><br>' .
                                $this->config->item('address') . '<br>' . $this->config->item('address2') . '<br> '.$this->lang->line('Phone').': ' . $this->config->item('phone') . '<br>  '.$this->lang->line('Email').': ' . $this->config->item('email'); ?>
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <address>
                            <?php echo '<strong>' . $trans['payer'] . '</strong><br>' .
                                $cdata['address'] . '<br>' . $cdata['city'] . '<br>' . $this->lang->line('Phone') . ': ' . $cdata['phone'] . '<br>  '.$this->lang->line('Email').': ' . $cdata['email']; ?>
                        </address>
                    </div>

                </div>

                <div class="row">
                    <hr>

                    <?php echo '<div class="col-xs-6 col-sm-6 col-md-6">
                    <p>' . $this->lang->line('Debit') . ' : ' . amountFormat($trans['debit']) . ' </p><p>' . $this->lang->line('Credit') . ' : ' . amountFormat($trans['credit']) . ' </p><p>' . $this->lang->line('Type') . ' : ' . $trans['type'] . '</p>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>' . $this->lang->line('Date') . ' : ' . dateformat($trans['date']) . '</p><p>' . $this->lang->line('Transaction') . ' ID : ' .prefix(5) . $trans['id'] . '</p><p>' . $this->lang->line('Category') . ' : ' . $trans['cat'] . '</p>
            </div><div class="col-xs-12 col-sm-12 col-md-12 ">
                    <p>' . $this->lang->line('Note') . ' : ' . $trans['note'] . '</p>
            </div></div>'; ?>'

                </div>
            </div>

</article>