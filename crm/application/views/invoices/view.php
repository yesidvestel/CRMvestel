<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <?php if ($this->session->flashdata("messagePr")) { ?>
                <div class="alert alert-info">
                    <?php echo $this->session->flashdata("messagePr") ?>
                </div>
            <?php } ?>

            <section class="card">
                <div id="invoice-template" class="card-block">
                    <div class="row wrapper white-bg page-heading">

                        <div class="col-lg-12">
                            <?php
                            $validtoken = hash_hmac('ripemd160', $invoice['tid'], $this->config->item('encryption_key'));

                            $link = '../../billing/view?id=' . $invoice['tid'] . '&token=' . $validtoken;
                            $linkp = '../../billing/printinvoice?id=' . $invoice['tid'] . '&token=' . $validtoken;
                            if ($invoice['status'] != 'canceled') {
                                echo ' <div class="title-action"><a href="' . $link . '"  class="btn btn-large btn-success" title="Partial Payment"
                                ><span class="fa fa-money"></span> '.$this->lang->line('Make Payment').' </a>
                                <a href="' . $linkp . '"  class="btn btn-large btn-info" title="Partial Payment"
                                ><span class="fa fa-print"></span> '.$this->lang->line('Print').' </a>   </div>';
                            } else {
                                echo '<h2 class="btn btn-oval btn-danger">' . $this->lang->line('Cancelled') . '</h2>';
                            } ?>
                        </div>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row">
                        <div class="col-md-9 col-sm-12 text-xs-center text-md-left"><p></p>
                            <img src="../../userfiles/company/<?php echo $this->config->item('logo') ?>"
                                 class="img-responsive p-1 m-b-2" style="max-height: 100px"><br>
                            <b><?php echo $this->lang->line('From') ?></b>


                            <ul class="px-0 list-unstyled">
                                <?php echo '<li class="text-bold-800">' . $this->config->item('ctitle') . '</li><li>' .
                                    $this->config->item('address') . '</li><li>' . $this->config->item('city') . '</li><li> ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '</li><li>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email'); ?>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-sm-12 text-xs-center text-md-right">
                            <h2><?php echo $this->lang->line('INVOICE') ?></h2>
                            <p class="pb-1"> <?php echo $this->config->item('prefix') . ' #' . $invoice['tid'] . '</p>
                            <p class="pb-1">Reference:' . $invoice['refer'] . '</p>'; ?>
                            <ul class="px-0 list-unstyled">
                                <li><?php echo $this->lang->line('Gross Amount') ?></li>
                                <li class="lead text-bold-800"><?php echo amountExchange($invoice['total'], $invoice['multi']) ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                        <div class="col-sm-12 text-xs-center text-md-left"><br>
                            <b>Bill To</b>
                        </div>
                        <div class="col-md-4 col-sm-12 text-xs-center text-md-left">
                            <ul class="px-0 list-unstyled">


                                <li class="text-bold-800"><a
                                            href="<?php echo base_url('customers/view?id=' . $invoice['cid']) ?>"><strong
                                                class="invoice_a"><?php echo $invoice['name'] . '</strong></a></li><li>' . $invoice['address'] . '</li><li>' . $invoice['city'] . ',' . $invoice['country'] . '</li><li> ' . $this->lang->line('Phone') . ' : ' . $invoice['phone'] . '</li><li> ' . $this->lang->line('Email') . ' : ' . $invoice['email']; ?>
                                </li>
                            </ul>

                        </div>
                        <div class="offset-md-5 col-md-3 col-sm-12 text-xs-center text-md-left">
                            <?php echo '<p><span class="text-muted">'.$this->lang->line('Invoice Date').':</span> ' . $invoice['invoicedate'] . '</p> <p><span class="text-muted">'.$this->lang->line('Due Date').' :</span> ' . $invoice['invoiceduedate'] . '</p>  <p><span class="text-muted">'.$this->lang->line('Terms').' :</span> ' . $invoice['termtit'] . '</p>';
                            ?>
                        </div>
                    </div>
                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('Description') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Tax') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Discount') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    foreach ($products as $row) {

                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td>
                           
                            <td>' . amountExchange($row['price'], $invoice['multi']). '</td>
                             <td>' . $row['qty'] . '</td>
                            <td>' . amountExchange($row['totaltax'],$invoice['multi']) . ' (' . amountFormat_s($row['tax']) . '%)</td>
                            <td>' . amountExchange($row['totaldiscount'], $invoice['multi']) . ' (' . amountFormat_s($row['discount']) . '' . $invoice['format_discount'] . ')</td>
                            <td>' . amountExchange($row['subtotal'], $invoice['multi']) . '</td>
                        </tr>';
                                        $c++;
                                    } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-xs-center text-md-left">


                                <div class="row">
                                    <div class="col-md-8"><p class="lead"><?php echo $this->lang->line('Payment Status') ?>: <u><strong
                                                        id="pstatus"><?php echo $this->lang->line(ucwords($invoice['status'])) ?></strong></u>
                                        </p>
                                        <p class="lead"><?php echo $this->lang->line('Payment Method') ?>: <u><strong
                                                        id="pmethod"><?php echo $this->lang->line($invoice['pmethod']) ?></strong></u>
                                        </p>

                                        <p class="lead mt-1"><br><?php echo $this->lang->line('Note') ?>:</p>
                                        <code>
                                            <?php echo $invoice['notes'] ?>
                                        </code>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <p class="lead">Total Due</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td><?php echo $this->lang->line('Sub Total') ?></td>
                                            <td class="text-xs-right"> <?php echo amountExchange($invoice['subtotal'],$invoice['multi']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Tax') ?></td>
                                            <td class="text-xs-right"><?php echo amountExchange($invoice['tax'],$invoice['multi']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Shipping') ?></td>
                                            <td class="text-xs-right"><?php echo amountExchange($invoice['shipping'],$invoice['multi']) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-800"><?php echo $this->lang->line('Total') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php echo amountExchange($invoice['total'],$invoice['multi']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Payment Made') ?></td>
                                            <td class="pink text-xs-right">
                                                (-) <?php echo amountExchange($invoice['pamnt'],$invoice['multi']) ?></span></td>
                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold-800"><?php echo $this->lang->line('Balance Due') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php $myp = '';
                                                $rming = $invoice['total'] - $invoice['pamnt'];
                                                if ($rming < 0) {
                                                    $rming = 0;

                                                }
                                                echo ' <span id="paydue">' . amountExchange($rming,$invoice['multi']) . '</span></strong>'; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-xs-center">
                                    <p><?php echo $this->lang->line('Authorized person') ?></p>
                                    <?php echo '<img src="../../userfiles/employee_sign/' . $employee['sign'] . '" alt="signature" class="height-100"/>
                                    <h6>(' . $employee['name'] . ')</h6>
                                    <p class="text-muted">' . user_role($employee['roleid']) . '</p>'; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Footer -->

                    <div id="invoice-footer"><p class="lead"><?php echo $this->lang->line('Credit Transactions') ?>:</p>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th><?php echo $this->lang->line('Method') ?></th>
                                <th><?php echo $this->lang->line('Amount') ?></th>
                                <th><?php echo $this->lang->line('Note') ?></th>


                            </tr>
                            </thead>
                            <tbody id="activity">
                            <?php foreach ($activity as $row) {

                                echo '<tr>
                            <td>' . $row['date'] . '</td>
                            <td>' . $this->lang->line($row['method']) . '</td>
                            <td>' . amountExchange($row['credit'],$invoice['multi']) . '</td>
                            <td>' . $row['note'] . '</td>
                        </tr>';
                            } ?>

                            </tbody>
                        </table>

                        <div class="row">

                            <div class="col-md-7 col-sm-12">

                                <h6><?php echo $this->lang->line('Terms & Condition') ?></h6>
                                <p> <?php

                                    echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
                                    ?></p>
                            </div>

                        </div>

                    </div>
                    <!--/ Invoice Footer -->
                    <hr>
                </div>
            </section>
        </div>
    </div>
</div>




