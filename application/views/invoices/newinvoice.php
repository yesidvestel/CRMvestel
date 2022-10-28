<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <form method="post" id="data_form" name="formulario2">


                    <div class="row">


                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row">
                                    <div class="fcol-sm-12">
                                        <h3 class="title">
                                            <?php echo $this->lang->line('Bill To') ?> 
											<a href='#' class="btn btn-primary btn-sm rounded" data-toggle="modal" data-target="#addCustomer">
                                             <?php echo $this->lang->line('Add Client') ?>
                                            </a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst"
                                                                            class="caption"><?php echo $this->lang->line(''); ?>Buscar Usuario</label>
                                        <input type="text" class="form-control" name="cst" id="customer-box"
                                               placeholder="Enter Customer Name or Mobile Number to search"
                                               autocomplete="off"/>

                                        <div id="customer-box-result"></div>
                                    </div>

                                </div>
                                <div id="customer">
                                    <div class="clientinfo">
                                        <?php echo $this->lang->line('Client Details'); ?>
                                        <hr>
                                        <input type="hidden" name="customer_id" id="customer_id" value="0">
                                        <div id="customer_name"></div>
                                    </div>
                                    <div class="clientinfo">

                                        <div id="customer_address1"></div>
                                    </div>

                                    <div class="clientinfo">

                                        <div id="customer_phone"></div>
                                    </div>
                                    <hr>
                                    <div id="customer_pass" hidden=""></div><?php echo $this->lang->line('') ?> <select
                                            id="warehouses"
                                            class="selectpicker form-control" hidden="">
                                        <option value="7"><?php echo $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
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
                                                class="title"><?php echo $this->lang->line('Invoice Properties') ?></h3>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Invoice #" name="invocieno"
                                                   value="<?php echo $lastinvoice + 1 ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption">Sede</label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <select type="text" class="form-control" placeholder="Reference #" name="refer" id="refer" onchange="cambia()">
												<?php
												foreach ($sede as $row) {
													$cid = $row['id'];
													$title = $row['title'];
													echo "<option value='$title'>$title</option>";
												}
												?>
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6"><label for="invociedate"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="invoicedate"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieduedate"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control required" id="tsn_due"
                                                   name="invocieduedate"
                                                   placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="taxformat"
                                               class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                        <select class="form-control" name="taxformat"
                                                onchange="changeTaxFormat(this.value)"
                                                id="taxformat">
                                            <?php if ($this->config->item('tax') == 1) {
                                                echo '<option value="on" seleted>&raquo;Con impuesto</option>';
                                            } else {
                                                echo '<option value="off">&raquo;Sin impuesto</option>';
                                            } ?>
                                            <option value="on">Con impuesto</option>
                                            <option value="off">Sin impuesto</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                            <select class="form-control" onchange="changeDiscountFormat(this.value)"
                                                    id="discountFormat">

                                                <option value="%"><?php echo $this->lang->line('% Discount').' '.$this->lang->line('After TAX') ?> </option>
                                                <option value="flat"><?php echo $this->lang->line('Flat Discount').' '.$this->lang->line('After TAX')  ?></option>
                                                  <option value="b_p"><?php echo $this->lang->line('% Discount').' '.$this->lang->line('Before TAX')  ?></option>
                                                <option value="bflat"><?php echo $this->lang->line('Flat Discount').' '.$this->lang->line('Before TAX')  ?></option>
                                                <!-- <option value="0">Off</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption">Factura</label>
                                            <select class="form-control"

                                                    id="tipo_factura" name="tipo_factura">                                                    
                                                    
													<option value="Fija">Fija</option>
                                                    <option value="Recurrente">Recurrente</option>
												<?php if ($this->aauth->get_user()->roleid > 3) { ?>

                                                    <option value="Nota Credito">Nota Credito</option>
                                                    <option value="Nota Debito">Nota Debito</option>
                                                <!-- <option value="0">Off</option> -->
												<?php } ?>
                                            </select>
                                        </div>
                                    </div>
									
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="toAddInfo"
                                               class="caption">Observacion</label>
                                        <textarea class="form-control" name="notes" rows="2"></textarea></div>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">

<thead>
                            <tr class="item_header">
                                <th width="25%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?></th>
                                <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                <th width="15%" class="text-center">
                                    <?php echo $this->lang->line('Amount') ?>
                                    (<?php echo $this->config->item('currency'); ?>)
                                </th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>

</thead>  <tbody>
                            <tr>
                                <td><input type="text" class="form-control text-center" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-0'>
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="<?php date('d') ?>"></td>
                                <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control vat " name="product_tax[]" id="vat-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off"></td>
                                <td class="text-center" id="texttaxa-0">0</td>
                                <td><input type="text" class="form-control discount" name="product_discount[]"
                                           onkeypress="return isNumber(event)" id="discount-0"
                                           onkeyup="rowTotal('0'), billUpyog()" autocomplete="off"></td>
                                <td><span class="currenty"><?php echo $this->config->item('currency'); ?></span>
                                    <strong><span class='ttlText' id="result-0">0</span></strong></td>
                                <td class="text-center">

                                </td>
                                <input type="hidden" name="taxa[]" id="taxa-0" value="0">
                                <input type="hidden" name="disca[]" id="disca-0" value="0">
                                <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-0" value="0">
                                <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                            </tr>
                            <tr><td colspan="8"><textarea id="dpid-0" class="form-control" name="product_description[]" placeholder="<?php echo $this->lang->line('Enter Product description'); ?>" autocomplete="off"></textarea><br></td></tr>

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
                                <td colspan="6" align="right"><input type="hidden" value="0" id="subttlform"
                                                                     name="subtotal"><strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                </td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                    <span id="taxr" class="lightMode">0</span></td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" align="right">
                                    <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency');
                                        if (isset($_GET['project'])) {
                                            echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                        } ?></span>
                                    <span id="discs" class="lightMode">0</span></td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
								<td colspan="2"><strong>ASIGNAR SERVICIO</strong>
                                <td colspan="4" align="right">
                                    <strong><?php echo $this->lang->line('Shipping') ?></strong></td>
                                <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                    onkeypress="return isNumber(event)"
                                                                    placeholder="Value"
                                                                    name="shipping" autocomplete="off"
                                                                    onkeyup="updateTotal()"></td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="2" hidden=""><?php if ($exchange['active'] == 1){
                                    echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                                    <select name="mcurrency"
                                            class="selectpicker form-control">
                                        <option value="0">Default</option>
                                        <?php foreach ($currency as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                        } ?>

                                    </select><?php } ?></td>
									<td colspan="2">Television</small>
                                    <select name="television" class="selectpicker form-control">
                                        <option value="no">No</option>
                                        <?php
											foreach ($paquete as $row) {
												$cid = $row['pid'];
												$title = $row['product_name'];
												echo "<option value='$title'>$title</option>";
											}
											?>
                                    </select>
                                <a href="" class="btn-small btn-primary" id="btn-mas-tv">Mas Tv</a>
                                <!--inicio modal elementos tv-->
                                 <div id="modal_mas_tv" class="modal fade">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title">Servicios Adicionales Tv</h4>
											</div>

                                             <div class="modal-body" id="body_modal">
                                                 <div class="form-group row">

                                                     <label class="col-sm-3 control-label" for="sdate2">Punto Adicional</label>
                                                   <div  class="col-sm-9">
                                                      <select name="puntos" class="selectpicker form-control">
                                                         <option value="0">no</option>
                                                         <?php for ($i=1;$i<=30;$i++){
                                                          echo '<option value="'.$i.'">'.$i.'</option>';}?>
                                                        </select>
                                                    </div>
                                                   </div>
                                                   <?php foreach ($servicios_por_sedes as $key => $value1) { ?>
                                                   <div id="servs_tv_sede_<?=$value1['title']?>" data-id-sede="<?=$value1['id'] ?>" class="servs_sede_<?=$value1['title']?> serv_sedes">
													<?php if(count($value1['servicios_tv'])!=0){ 
                                                         foreach ($value1['servicios_tv'] as $key => $serv) {?>
                                                   <div class="form-group row">
														<label class="col-sm-3 control-label"
                                                          for="serv_add_<?=$serv['pid']  ?>"><?=$serv['product_name'] ?></label>
                                                      <div  class="col-sm-9">
                                                         <select name="serv_add_<?=$serv['pid']  ?>" class="selectpicker form-control select_sede_<?=$value1['title']?>">
                                                           <option value="0">no </option>
                                                           <?php foreach ($serv['valores'] as $key => $valora1) {
                                                            echo '<option value="'.$valora1.'">'.$valora1.'</option>';}?>
                                                         </select>
                                                      </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php } ?>
                                                     </div>
                                                     <?php } ?>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <a data-dismiss="modal" href="#" class="btn btn-success">Guardar</a>
                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                <!--inicio modal elementos tv-->        
                                </td>


                                <td colspan="4" align="right"><strong><?php echo $this->lang->line('Grand Total') ?>
                                        (<span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                </td>
                                <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                                    id="invoiceyoghtml" readonly="">

                                </td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="2" hidden=""><?php echo $this->lang->line('Payment Terms') ?> 
								<select name="pterms" class="selectpicker form-control"><?php foreach ($terms as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>

                                    </select></td>
								<td colspan="2">Internet 
								<select name="combo" class="selectpicker form-control">
										<option value="no">No</option>
										<?php
											foreach ($paqueteinter as $row) {
												$cid = $row['pid'];
												$title = $row['product_name'];
												echo "<option value='$title'>$title</option>";
											}
											?>
										
                                    </select><a href="" class="btn-small btn-primary" id="btn-mas-internet">Mas Internet</a>        
                                    <!--inicio modal elementos internet-->
                                    <div id="modal-mas-internet" class="modal fade">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                           <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">Servicios Adicionales Internet</h4>
                                           </div>
											<div class="modal-body" id="body_modal">
                                                <?php foreach ($servicios_por_sedes as $key => $value1) { ?>
                                                <div id="servs_internet_sede_<?=$value1['title']?>" class="servs_sede_<?=$value1['title']?> serv_sedes" data-id-sede="<?=$value1['id'] ?>">

                                                <?php if(count($value1['servicios_internet'])!=0){ 
                                                    foreach ($value1['servicios_internet'] as $key => $serv) {?>
                                                    <div class="form-group row">
 														<label class="col-sm-3 control-label"
                                                        for="serv_add_<?=$serv['pid']  ?>"><?=$serv['product_name'] ?></label>
                                                        <div  class="col-sm-9">
                                                            <select name="serv_add_<?=$serv['pid']  ?>" class="selectpicker form-control select_sede_<?=$value1['title']?>">
                                                               <option value="0">no </option>
                                                               <?php foreach ($serv['valores'] as $key => $valora1) {
                                                                echo '<option value="'.$valora1.'">'.$valora1.'</option>';}?>
                                                              </select>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php } ?>
                                                  </div>
                                                  <?php } ?>
                                                </div>
                                                <div class="modal-footer">
                                                                <a data-dismiss="modal" href="#" class="btn btn-success">Guardar</a>
                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                <!--inicio modal elementos internet-->

                                </td>

								
                                <td align="right" colspan="6"><input type="submit" class="btn btn-success sub-btn" value="<?php echo $this->lang->line('Generate Invoice') ?> " id="submit-data" data-loading-text="Creating...">

                                </td>
								
                            </tr>
							<tr>
								<th>Significado Letras Pequetes</th>
							</tr>
							<tr>
							<td>V: Villanueva &nbsp S: Solo &nbsp D: Dedicado &nbsp C: Comercial &nbsp &nbsp &nbsp I: Institucional</td>
							</tr>

                            </tbody>
                        </table>
                    </div>

                    <input type="hidden" value="invoices/action" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                    <input type="hidden" value="%" name="taxformat" id="tax_format">
                    <input type="hidden" value="%" name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?php if ($this->config->item('tax') == 1) {
                        echo 'yes';
                    } else {
                        echo 'no';
                    } ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">


                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal" name="formulario1">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Customer') ?></h4>
                </div>

                <!-- Modal Body -->
				
                <div class="modal-body">
					
					<div class="col-md-6"  style="margin-top: -10px;">
						<h5><?php echo $this->lang->line('') ?>Datos personales</h5>
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="form-group row">

                        <h6><label class="col-sm-3 col-form-label"
                               for="name"><?php echo $this->lang->line('') ?>1er Nombre</label></h6> 

                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>2do Nombre</label></h6>
                        </div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>1er Apellido</label></h6>
                        </div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>2do Apellido</label></h6>
                        </div>

                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control margin-bottom" name="name" id="mcustomer_name">
                        </div>
                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control margin-bottom" name="dosnombre" id="mcustomer_dosnombre">
                        </div>
                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control margin-bottom" name="unoapellido" id="mcustomer_unoapellido">
                        </div>
                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control margin-bottom" name="dosapellido" id="mcustomer_dosapellido">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="address"><?php echo $this->lang->line('Company') ?></label></h6>

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="phone"><?php echo $this->lang->line('') ?>Celular</label></h6>
                        </div>
                    
                    <div class="col-sm-6">
							<input type="text" placeholder="Compañia"
                                   class="form-control margin-bottom" name="company" id="mcustomer_address1">
                        
							</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="celular" id="mcustomer_phone">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label" for="celular2">Celular (adi)</label></h6>

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="email"><?php echo $this->lang->line('') ?>Correo</label></h6>
                        </div>                    
                        <div class="col-sm-6">
                            <input type="text" placeholder="Numero adicional"
                                   class="form-control margin-bottom" name="celular2" id="mcustomer_city">
                        </div>
                        <div class="col-sm-6">
                        <input type="text" placeholder="email"
                                   class="form-control margin-bottom" name="email" id="mcustomer_email">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-4 col-form-label"
                               for="nacimiento"><?php echo $this->lang->line('') ?>Feha de nacimiento</label></h6>

                        <div class="col-sm-2">
                            <h6><label class="col-form-label"
                               for="tipo_cliente"><?php echo $this->lang->line('') ?>Tipo clte</label></h6>
                        </div>
                        <div class="col-sm-2">
                            <h6><label class="col-form-label"
                               for="tipo_documento"><?php echo $this->lang->line('') ?>Tipo Dto</label></h6>
                        </div>
                        <div class="col-sm-4">
                            <h6><label class="col-form-label"
                               for="documento"><?php echo $this->lang->line('') ?>Nº Documento</label></h6>
                        </div>
                    
                    	<div class="col-sm-4">
						<input type="text" class="form-control"
                                                   placeholder="Billing Date" name="nacimiento"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                        
						</div>
                        <div class="col-sm-2">
                            <select class="form-control"  id="discountFormat" name="tipo_cliente">
													<option value="Natural">Natural</option>
                                                	<option value="Juridico">Juridico</option>
                                                  	<option value="Gubernamental">Gubernamental</option>
                                                	<option value="Militar">Militar</option>
                                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control"  id="mcustomer_country" name="tipo_documento">
													<option value="CC">CC</option>
                                                	<option value="CE">CE</option>
                                                  	<option value="NIT">NIT</option>
                                                	<option value="PAS">PAS</option>
                                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Numero de documento"
                                   class="form-control margin-bottom" name="documento" id="mcustomer_documento">
                        </div>
                    </div>
                    <hr>
                    <h5><?php echo $this->lang->line('') ?>Datos de residencia</h5>
                    <hr>
                    <div class="form-group row">
						
						
						<div class="col-sm-6">
							 <h6><label class="col-sm-6 col-form-label"
								   for="departamento"><?php echo $this->lang->line('') ?>Departamento</label></h6>
						
							<?php echo $this->lang->line('departamentos') ?> 
							<select id="departamentos"	class="selectpicker form-control" name="departamento" id="mcustomer_country">
								<option value="0"><?php echo $this->lang->line('departamentos') ?></option><?php 						foreach ($departamentos as $row) {
									echo '<option value="' . $row['idDepartamento'] . '">' . $row['departamento'] . '</option>';
								} ?>

							</select>
						
						</div> 

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="ciudad"><?php echo $this->lang->line('') ?>Ciudad</label></h6>
						    <div id="ciudades">
								<select id="cmbCiudades" class="selectpicker form-control" name="ciudad">
                                <option>Seleccionar</option>
                                <option value="1">Seleccionar</option>
                                </select>
							</div>
							   
                        </div>
                      
                       
                    </div>
                    <div class="form-group row"> 
					
						<div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="localidad"><?php echo $this->lang->line('') ?>Localidad</label></h6>
						    <div id="localidades">
								<select id="cmbLocalidades"  class="selectpicker form-control" name="localidad">
                                <option>Seleccionar</option>
                                </select>
							</div>
							   
                        </div>
						
						<div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="barrio"><?php echo $this->lang->line('') ?>Barrio</label></h6>
						    <div id="barrios">
								<select id="cmbBarrios" class="selectpicker form-control" name="barrio" >
                                <option>Seleccionar</option>
                                </select>
							</div>
							   
                        </div>
                    	 
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-12 col-form-label"
                               for="city"><?php echo $this->lang->line('') ?>Direccion</label></h6>

                        
                    
                    	<div class="col-sm-2">
						<select class="form-control"  id="discountFormat" name="nomenclatura">
													<option value="Calle">Calle</option>
                                                	<option value="Carrera">Carrera</option>
                                                  	<option value="Diagonal">Diagonal</option>
                                                	<option value="Transversal">Transversal</option>
                                            </select>
                        
						</div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero1">
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="adicionauno">
													<option value=""></option>
                                                    <option value="bis">bis</option>
                                                	<option value="a">a</option>
                                                  	<option value="b">b</option>
                                                	<option value="c">c</option>
                                                    <option value="d">d</option>
                                                    <option value="e">e</option>
                                                    <option value="a bis">a bis</option>
                                                    <option value="b bis">b bis</option>
                                                    <option value="c bis">c bis</option>
                                                    <option value="d bis">d bis</option>
                                            </select>
                        </div>
                        <div class="col-sm-1" style="margin-left: -10px;">
                            <label class="col-form-label" for="Nº">Nº</label>
                        </div>
                        <div class="col-sm-2" style="margin-left: 14px;">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero2" style="margin-left: -20px;">
                        </div>
                        <div class="col-sm-2" style="margin-left: -20px;margin-right: -20px;">
                            <select class="col-sm-1 form-control" name="adicional2">
													<option value=""></option>
                                                    <option value="bis">bis</option>
                                                	<option value="a">a</option>
                                                  	<option value="b">b</option>
                                                	<option value="c">c</option>
                                                    <option value="d">d</option>
                                                    <option value="e">e</option>
                                                    <option value="a bis">a bis</option>
                                                    <option value="b bis">b bis</option>
                                                    <option value="c bis">c bis</option>
                                                    <option value="d bis">d bis</option>
                                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero3" id="numero3">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Residencia</label></h6>

                        <div class="col-sm-6">
                            
                            <h6><label class="col-sm-2 col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Referencia</label></h6>
                        </div>
                    
                    	<div class="col-sm-6">
                        	<select class="form-control"  id="discountFormat" name="residencia">
													<option value="Casa">Casa</option>
                                                	<option value="Apartamento">Apartamento</option>
                                                  	<option value="Edificio">Edificio</option>
                                                	<option value="Oficina">Oficina</option>
                                            </select>
						</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="detalles de residencia"
                                   class="form-control margin-bottom" name="referencia">
                        </div>
					</div>
						<div class="form-group row">

                        <h6><label class="col-sm-2 col-form-label"
                               for="customergroup"><?php echo $this->lang->line('') ?>Sede</label></h6>
						
                        <div class="col-sm-12">
                            <select name="customergroup" class="form-control"  >
                                <?php

                                foreach ($customergrouplist as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>
                        </div>
					</div>
                 </div> 
                <!--ship-->

                <div class="col-md-6 " style="margin-top: -10px;">
                    <h5><?php echo $this->lang->line('') ?>Datos de Integracion</h5>
                    <div class="form-group row">					
                        <div class="input-group">
                            <label class="display-inline-block custom-control custom-radio ml-1">
                                <input type="checkbox" name="customer1" class="custom-control-input" id="copy_address">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description ml-0"><?php echo $this->lang->line('') ?>Integrar al sistema</span>
                            </label>

                        </div>

                        <div class="col-sm-10">
                            <?php echo $this->lang->line("") ?>Ingrese los datos para integrar USUARIO con el SISTEMA
                        </div>
                    </div>


                    <div class="form-group row">

                        <h6><label class="col-sm-10 col-form-label"
                               for="name_s"><?php echo $this->lang->line('Name') ?></label><h6>
						
                        <div class="col-sm-12">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" name="name_s" id="mcustomer_name_s"> 
                        </div>
                    </div>


                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="phone_s"><?php echo $this->lang->line('') ?>Contraseña</label></h6>

                        <div class="col-sm-6">
                             <h6><label class="col-sm-2 col-form-label" for="email_s">Servicio</label></h6>
                        </div>                    
                    	<div class="col-sm-6">                       
                        <input type="text" 
                                   class="form-control margin-bottom" name="contra" id="mcustomer_documento_s">
						</div>
                        <div class="col-sm-6">
                            <select class=" col-sm-2 form-control"  id="discountFormat" name="servicio">
													<option value="pppoe">pppoe</option>
                                                    <option value="pptp">pptp</option>
                                                	
                                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="address"><?php echo $this->lang->line('') ?>Perfil</label></h6>

                        <div class="col-sm-6">
                            
                            <h6><label class="col-sm-6 col-form-label"
                               for="city_s"><?php echo $this->lang->line('') ?>Ip local</label></h6>
                        </div>
                    
                   		 <div class="col-sm-6">
							<select class=" col-sm-2 form-control"  id="discountFormat" name="perfil" onchange="cambia2()">
													<option value="-">-</option>
                                            </select>                       
						</div>
                        <div class="col-sm-6">
                            <select class=" col-sm-2 form-control"  id="discountFormat" name="Iplocal">
													<option value="-">-</option>
                                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="region_s"><?php echo $this->lang->line('') ?>Ip remota</label></h6>

                        <div class="col-sm-6">                            
                            <h6><label class="col-sm-2 col-form-label"
                               for="country_s"><?php echo $this->lang->line('') ?>Comentario</label></h6>
                        </div>
                    
                    	<div class="col-sm-6">
							<input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="Ipremota" id="Ipremota" value="10.0.0.3">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Barrio y codigo usuario"
                                   class="form-control margin-bottom" name="comentario" id="mcustomer_comentario_s">
                        </div>
                    </div>
					</div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/>
										
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    cambia();
    var sede_actual=$("#refer option:selected").val();
    function cambia(){
        var sede_sel=$("#refer option:selected").val();
        $(".serv_sedes").css("display","none");
        $(".servs_sede_"+sede_sel).css("display","");
        if(sede_actual!=sede_sel){
            $(".select_sede_"+sede_actual).val("0");
        }
        sede_actual=$("#refer option:selected").val();


    }
function ShowSelected()
{
/* Para obtener el valor */
var cod = document.getElementById("producto").value;
alert(cod);
 
/* Para obtener el texto */
var combo = document.getElementById("producto");
var selected = combo.options[combo.selectedIndex].text;
alert(selected);
}
</script>
<script type="text/javascript">	
	$(document).on('click','#btn-mas-internet',function(e){
        e.preventDefault();
        $("#modal-mas-internet").modal("show");
    });
    $(document).on('click','#btn-mas-tv',function(e){
        e.preventDefault();
        $("#modal_mas_tv").modal("show");
    });
	var Iplocal_2 = new Array ("10.0.0.1");
	var Iplocal_3 = new Array ("80.0.0.1");
	var Iplocal_4 = new Array ("10.1.100.1");
							//crear funcion que ejecute el cambio
							function cambia2(){
								var customergroup;
								customergroup = document.formulario1.customergroup[document.formulario1.customergroup.			selectedIndex].value;
								//se verifica la seleccion dada
								if(customergroup!=0){
									mis_opts=eval("Iplocal_"+customergroup);
									//definimos cuantas obciones hay
									num_opts=mis_opts.length;
									//marcamos obciones en el selector
									document.formulario1.Iplocal.length = num_opts;
									//colocamos las obciones array
									for(i=0; i<num_opts; i++){
										document.formulario1.Iplocal.options[i].value=mis_opts[i];
										document.formulario1.Iplocal.options[i].text=mis_opts[i];
									}
										}else{
											//resultado si no hay obciones
											document.formulario1.Iplocal.length = 1;
											document.formulario1.Iplocal.options[0].value="-"
											document.formulario1.Iplocal.options[0].text="-"											
								}
								document.formulario1.Iplocal.options[0].selected = true;
							}		
				
			$("#departamentos").change(function(){
 
				if($(this).val()!=""){
					 
					var dato=$(this).val(); 
					$.ajax({
						type:"POST",
						dataType:"html",
						url:"ciudades_list",
						data:"idDepartamento="+dato+" ",
						success:function(msg){ 
							$('#cmbCiudades').html('<option>Seleccionar</option>'+ msg); 
						}
					});
				}else{
					//$("#dependencia").empty().attr("disabled","disabled");
					//$("#departamento").empty().attr("disabled","disabled");
				}
			});
			
			$("#cmbCiudades").change(function(){ 
				 
				if($(this).val()!=""){
					 
					var dato=$(this).val(); 
				 
					
					$.ajax({
						type:"POST",
						dataType:"html",
						url:"localidades_list",
						data:"idCiudad="+dato+" ",
						success:function(msg){   
							$('#cmbLocalidades').html('<option>Seleccionar</option>'+msg); 
						}
					});
				}else{
					//$("#dependencia").empty().attr("disabled","disabled");
					//$("#departamento").empty().attr("disabled","disabled");
				}
			});
			
			$("#cmbLocalidades").change(function(){ 
 
				if($(this).val()!=""){
					 
					var dato=$(this).val();  
					
					$.ajax({
						type:"POST",
						dataType:"html",
						url:"barrios_list",
						data:"idLocalidad="+dato+" ",
						success:function(msg){  
							$('#cmbBarrios').html('<option>Seleccionar</option>'+msg); 
						}
					});
				}else{
					//$("#dependencia").empty().attr("disabled","disabled");
					//$("#departamento").empty().attr("disabled","disabled");
				}
			});
			
			
		
		</script>
