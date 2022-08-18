<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Historial Cuenta <?php echo $details['name'].' '.$details['unoapellido'] ?></h6>
            <hr>
			<table id="cgrtable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>Codigo</th>
                    <th><?php echo $this->lang->line('') ?>Fecha</th>
                    <th><?php echo $this->lang->line('') ?>Debito</th>
                    <th><?php echo $this->lang->line('') ?>Credito</th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
               foreach ($facturas as $row) {
				  
                    $cid = $row['id'];
                    $dtlle = $row['tid'];
					
					$tpo = $row['invoicedate'];	
					
                    $cdor = $row['total'];

                    echo "<tr>
                    <td>$i</td>
                    <td>$dtlle</td>
                    <td>$tpo</td>
                    <td></td>
                    <td>".amountformat($cdor)."</td>
					</tr>";
				   	 $pagos=$this->db->get_where('transactions',array('tid'=>$dtlle,'estado'=>null))->result_array();
				    foreach ($pagos as $row2) {
                    $cid2 = $row2['id'];
                    $dtlle2 = $row2['tid'];
					
					$tpo2 = $row2['date'];	
					
                    $cdor2 = $row2['credit'];

                    echo "<tr>
                    <td>$i</td>
                    <td>$cid2</td>
                    <td>$tpo2</td>
                    <td>".amountformat($cdor2)."</td>
                    <td></td>
					</tr>";
					}
                    $i++;
					
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>Codigo</th>
                    <th><?php echo $this->lang->line('') ?>Fecha</th>
                    <th><?php echo $this->lang->line('') ?>Debito</th>
                    <th><?php echo $this->lang->line('') ?>Credito</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#cgrtable').DataTable({
			 order: [[2, 'desc']],
		});
			
    });
</script>
