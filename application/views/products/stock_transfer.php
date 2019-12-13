<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">
                <h5><?php echo $this->lang->line('Stock Transfer') ?></h5>
                <hr>


                <input type="hidden" name="act" value="add_product">



                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Transfer From') ?></label>

                    <div class="col-sm-6">
                        <select id="wfrom" name="from_warehouse" class="form-control">
                            <option value='0'>Select</option>
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Products') ?></label>
                           

                    <div class="col-sm-8">
                        <select id="products_l" name="products_l[]" class="form-control required select-box" multiple="multiple">

                       </select>                  

                    </div>
                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">
                         <thead>

                            <tr class="item_header">
                                <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Amount') ?>
                                    (<?php echo $this->config->item('currency'); ?>)
                                </th>
                            </tr>
                         </thead>   
                         <tbody>
                            <tr>
                                <td><input type="text" class="form-control text-center" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-0'>
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="1"></td>                                                       
                                <input type="hidden" name="taxa[]" id="taxa-0" value="0">
                                <input type="hidden" name="disca[]" id="disca-0" value="0">
                                <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-0" value="0">
                                <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                            </tr>
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
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Transfer To') ?></label>

                    <div class="col-sm-6">
                        <select name="to_warehouse" class="form-control">
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
				

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Stock Transfer') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="products/stock_transfer" id="action-url">
                    </div>
                </div>
            </div>

        </form>
    </div>
</article>

<script type="text/javascript">
    $("#products_l").select2();
    $("#wfrom").on('change', function(){
    var tips=$('#wfrom').val();
    $("#products_l").select2({

        tags: [],
        ajax: {
            url: baseurl + 'products/stock_transfer_products?wid='+tips,
            dataType: 'json',
            type: 'POST',
            quietMillis: 50,
            data: function (customer) {
                return {
                    customer: customer
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.product_name,							
                            id: item.pid
                        }
                    })
                };
            },
        }
    }); });
</script>

