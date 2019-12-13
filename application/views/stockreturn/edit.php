<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form">
            <div class="row">
                <div class="col-sm-6 cmp-pnl">
                    <div id="customerpanel" class="inner-cmp-pnl">
                        <div class="form-group row">
                            <div class="fcol-sm-12">
                                <h3 class="title">
                                    <?php echo $this->lang->line('Bill From') ?> <a href='#'
                                                                                    class="btn btn-primary btn-sm rounded"
                                                                                    data-toggle="modal"
                                                                                    data-target="#addCustomer">
                                        <?php echo $this->lang->line('Add Supplier') ?>
                                    </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="frmSearch col-sm-12"><label for="cst"
                                                                    class="caption"><?php echo $this->lang->line('Search Supplier') ?></label>
                                <input type="text" class="form-control" name="cst" id="supplier-box"
                                       placeholder="Enter Supplier Name or Mobile Number to search" autocomplete="off"/>

                                <div id="supplier-box-result"></div>
                            </div>

                        </div>
                        <div id="customer">
                            <div class="clientinfo">
                                <?php echo $this->lang->line('Supplier Details') ?>
                                <hr>
                                <?php echo '  <input type="hidden" name="customer_id" id="customer_id" value="' . $invoice['csd'] . '">
                                <div id="customer_name"><strong>' . $invoice['name'] . '</strong></div>
                            </div>
                            <div class="clientinfo">

                                <div id="customer_address1"><strong>' . $invoice['address'] . '<br>' . $invoice['city'] . ',' . $invoice['country'] . '</strong></div>
                            </div>

                            <div class="clientinfo">

                                <div type="text" id="customer_phone">Phone: <strong>' . $invoice['phone'] . '</strong><br>Email: <strong>' . $invoice['email'] . '</strong></div>
                            </div>'; ?>
                                <hr><?php echo $this->lang->line('Warehouse') ?> <select id="warehouses"
                                                                                         class="selectpicker form-control">
                                    <option value="0">All</option><?php foreach ($warehouse as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                    } ?>

                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="col-sm-6 cmp-pnl">
                        <div class="inner-cmp-pnl">


                            <div class="form-group row">

                                <div class="col-sm-12"><h3
                                            class="title"> <?php echo $this->lang->line('Purchase Order Properties') ?></h3>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6"><label for="invocieno"
                                                             class="caption"> <?php echo $this->lang->line('Purchase Order') ?>
                                        #</label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Purchase Order #"
                                               name="invocieno"
                                               value="<?php echo $invoice['tid']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6"><label for="invocieno"
                                                             class="caption"> <?php echo $this->lang->line('Reference') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Reference #" name="refer"
                                               value="<?php echo $invoice['refer'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">

                                <div class="col-sm-6"><label for="invociedate"
                                                             class="caption"> <?php echo $this->lang->line('Order Date') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar4"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control required editdate"
                                               placeholder="Billing Date" name="invoicedate" autocomplete="false"
                                               value="<?php echo dateformat($invoice['invoicedate']) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6"><label for="invocieduedate"
                                                             class="caption"><?php echo $this->lang->line('Order Due Date') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control required editdate" name="invocieduedate"
                                               placeholder="Due Date" autocomplete="false"
                                               value="<?php echo dateformat($invoice['invoiceduedate']) ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="taxformat"
                                           class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                    <select class="form-control" name="taxformat" onchange="changeTaxFormat(this.value)"
                                            id="taxformat">
                                        <?php if ($invoice['taxstatus'] == 'yes') {
                                            echo '<option value="on" seleted>&raquo;' . $this->lang->line('On') . '</option>';
                                        } else {
                                            echo '<option value="off">&raquo;' . $this->lang->line('Off') . '</option>';
                                        } ?>
                                        <option value="on"><?php echo $this->lang->line('On') ?></option>
                                        <option value="off"><?php echo $this->lang->line('Off') ?></option>
                                    </select>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                        <select class="form-control" onchange="changeDiscountFormat(this.value)"
                                                id="discountFormat">
                                           <?php echo '<option value="' . $invoice['format_discount'] . '">'.$this->lang->line('Do not change').'</option>'; ?>
                                                 <option value="%"><?php echo $this->lang->line('% Discount').' '.$this->lang->line('After TAX') ?> </option>
                                                <option value="flat"><?php echo $this->lang->line('Flat Discount').' '.$this->lang->line('After TAX')  ?></option>
                                                  <option value="b_p"><?php echo $this->lang->line('% Discount').' '.$this->lang->line('Before TAX')  ?></option>
                                                <option value="bflat"><?php echo $this->lang->line('Flat Discount').' '.$this->lang->line('Before TAX')  ?></option>
                                            <!-- <option value="0">Off</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="toAddInfo"
                                           class="caption"><?php echo $this->lang->line('Order Note') ?></label>
                                    <textarea class="form-control" name="notes"
                                              rows="2"><?php echo $invoice['notes'] ?></textarea></div>
                            </div>

                        </div>
                    </div>

                </div>


                <div id="saman-row">
                    <table class="table-responsive tfr my_stripe">

<thead>
                        <tr class="item_header">
                            <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                            <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                            <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                            <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?>(%)</th>
                            <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?></th>
                            <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                            <th width="10%" class="text-center"><?php echo $this->lang->line('Amount') ?>
                                (<?php echo $this->config->item('currency'); ?>)
                            </th>
                            <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                        </tr></thead><tbody>
                        <?php $i = 0;
                        foreach ($products as $row) {
                            echo '<tr >
                        <td><input type="text" class="form-control text-center" name="product_name[]" placeholder="Enter Product name or Code"  value="' . $row['product'] . '">
                        </td>
                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . $row['qty'] . '" ><input type="hidden" name="old_product_qty[]" value="' . $row['qty'] . '" ></td>
                        <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . $row['price'] . '"></td>
                        <td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' . $i . '"
                                    onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                    autocomplete="off"  value="' . $row['tax'] . '"></td>
                        <td class="text-center" id="texttaxa-' . $i . '">' . $row['totaltax'] . '</td>
                        <td><input type="text" class="form-control discount" name="product_discount[]"
                                   onkeypress="return isNumber(event)" id="discount-' . $i . '"
                                   onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off"  value="' . $row['discount'] . '"></td>
                        <td><span class="currenty">' . $this->config->item('currency') . '</span>
                            <strong><span class="ttlText" id="result-' . $i . '">' . $row['subtotal'] . '</span></strong></td>
                        <td class="text-center">
<button type="button" data-rowid="' . $i . '" class="btn btn-danger removeProd" title="Remove"> <i class="icon-minus-square"></i> </button>
                        </td>
                        <input type="hidden" name="taxa[]" id="taxa-' . $i . '" value="' . $row['totaltax'] . '">
                        <input type="hidden" name="disca[]" id="disca-' . $i . '" value="' . $row['totaldiscount'] . '">
                        <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' . $i . '" value="' . $row['subtotal'] . '">
                        <input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['pid'] . '">
                    </tr><tr class="desc_p"><td colspan="8"><textarea id="dpid-' . $i . '" class="form-control" name="product_description[]" placeholder="Enter Product description" autocomplete="off">' . $row['product_des'] . '</textarea><br></td></tr>';
                            $i++;
                        } ?>
                        <tr class="last-item-row sub_c">
                            <td class="add-row">
                                <button type="button" class="btn btn-success" aria-label="Left Align"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Add product row" id="addproduct">
                                    <i class="icon-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                </button>
                            </td>
                            <td colspan="7"></td>
                        </tr>

                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="6" align="right"><strong>Total Tax</strong></td>
                            <td align="left" colspan="2"><span
                                        class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                <span id="taxr" class="lightMode"><?php echo $invoice['tax'] ?></span></td>
                        </tr>
                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="6" align="right">
                                <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                            <td align="left" colspan="2"><span
                                        class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                <span id="discs" class="lightMode"><?php echo $invoice['discount'] ?></span></td>
                        </tr>

                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="6" align="right"><input type="hidden"
                                                                 value="<?php echo $invoice['subtotal'] ?>"
                                                                 id="subttlform"
                                                                 name="subtotal"><strong><?php echo $this->lang->line('Shipping') ?></strong>
                            </td>
                            <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                onkeypress="return isNumber(event)" placeholder="Value"
                                                                name="shipping" autocomplete="off"
                                                                onkeyup="updateTotal()"
                                                                value="<?php echo $invoice['shipping'] ?>"></td>
                        </tr>

                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="6" align="right"><strong><?php echo $this->lang->line('Grand Total') ?>(<span
                                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                            </td>
                            <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                                id="invoiceyoghtml"
                                                                value="<?php echo $invoice['total']; ?>" readonly="">

                            </td>
                        </tr>
                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="2"><?php echo $this->lang->line('Payment Terms') ?> <select name="pterms"
                                                                                                     class="selectpicker form-control"><?php echo '<option value="' . $invoice['termid'] . '">*' . $invoice['termtit'] . '</option>';
                                    foreach ($terms as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                    } ?>


                                </select></td>
                            <td colspan="2">
                                <div>
                                    <label><?php echo $this->lang->line('Update Stock') ?></label>
                                    <div class="input-group">
                                        <label class="display-inline-block custom-control custom-radio ml-1">
                                            <input type="radio" name="update_stock" class="custom-control-input"
                                                   value="yes" checked="">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description ml-0">Yes</span>
                                        </label>
                                        <label class="display-inline-block custom-control custom-radio">
                                            <input type="radio" name="update_stock" class="custom-control-input"
                                                   value="no">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description ml-0">No</span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td align="right" colspan="4"><input type="submit" class="btn btn-success sub-btn"
                                                                 value="<?php echo $this->lang->line('Update Order') ?>"
                                                                 id="submit-data" data-loading-text="Updating...">
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>

                <input type="hidden" value="stockreturn/editaction" id="action-url">
                <input type="hidden" value="puchase_search" id="billtype">
                <input type="hidden" value="<?php echo $i - 1; ?>" name="counter" id="ganak">
                <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                <input type="hidden" value="%" name="taxformat" id="tax_format">
                <input type="hidden" value="%" name="discountFormat" id="discount_format">
                <input type="hidden" value="yes" name="tax_handle" id="tax_status">
                <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">


        </form>
    </div>

</article>

<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Supplier') ?></h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name"><?php echo $this->lang->line('Name') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" id="mcustomer_name" name="name" required>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="phone"><?php echo $this->lang->line('Phone') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Phone"
                                   class="form-control margin-bottom" name="phone" id="mcustomer_phone">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                        <div class="col-sm-10">
                            <input type="email" placeholder="Email"
                                   class="form-control margin-bottom crequired" name="email" id="mcustomer_email">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="address"><?php echo $this->lang->line('Address') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Address"
                                   class="form-control margin-bottom " name="address" id="mcustomer_address1">
                        </div>
                    </div>
                    <div class="form-group row">


                        <div class="col-sm-6">
                            <input type="text" placeholder="City"
                                   class="form-control margin-bottom" name="city" id="mcustomer_city">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region">
                        </div>

                    </div>

                    <div class="form-group row">


                        <div class="col-sm-6">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country" id="mcustomer_country">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="PostBox"
                                   class="form-control margin-bottom" name="postbox">
                        </div>
                    </div>


                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="msupplier_add" class="btn btn-primary submitBtn"
                           value="<?php echo $this->lang->line('ADD') ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript"> $('.editdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});</script>