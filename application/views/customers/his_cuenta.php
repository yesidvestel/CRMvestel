<style type="text/css">
    .buttons-pdf,.buttons-excel{
        cursor: pointer;
    }
    .btn-group, .btn-group-vertical {
    position: absolute !important;
}
</style>
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
                    <th><?php echo $this->lang->line('') ?>Tipo</th>
                    <th><?php echo $this->lang->line('') ?>Cargo</th>
                    <th><?php echo $this->lang->line('') ?>Abono</th>


                </tr>
					<i style="background-color: forestgreen"></i>
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
                    <td>Factura</td>
                    <td>".amountformat($cdor)."</td>
                    <td></td>
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
                    <td>Pago</td>
                    <td></td>
                    <td>".amountformat($cdor2)."</td>
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
                    <th><?php echo $this->lang->line('') ?>Tipo</th>
                    <th><?php echo $this->lang->line('') ?>Cargo</th>
                    <th><?php echo $this->lang->line('') ?>Abono</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script src="https://kit.fontawesome.com/317775a1b1.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#cgrtable').DataTable({
			 order: [[2, 'desc']],
			language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros &nbsp",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
			     },
			     "sProcessing":"Procesando...",
            },
            dom: 'Bfrtilp',       
        buttons:[ 
            {
                extend:    'excelHtml5',
                text:      '<i class="fa-sharp fa-solid fa-file-excel"></i>',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                messageTop :'Historial Cuenta <?php echo $details['name'].' '.$details['unoapellido'] ?>'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa-sharp fa-solid fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                messageTop :'Historial Cuenta <?php echo $details['name'].' '.$details['unoapellido'] ?>'
            },
            {
                extend:    'print',
                text:      '<i class="icon-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]
			
		});
	$(".buttons-pdf").removeClass("dt-button");		
    $(".buttons-excel").removeClass("dt-button");     
    $(".buttons-print").removeClass("dt-button");     
    });

</script>
