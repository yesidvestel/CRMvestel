<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5 class="title"><?php echo $this->lang->line('') ?>Administrar Conexiones
            </h5>
			<a href='<?php echo base_url("redes/vlanadd"); ?>' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i> Nueva Vlan</a>
			<a href='<?php echo base_url("redes/napadd"); ?>' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i> Nueva Nap</a>
			<a href='<?php echo base_url("redes/puertosadd"); ?>' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>Nuevo Puerto</a>
            <hr>
            <table id="catgtable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>Sede</th>
                    <th><?php echo $this->lang->line('') ?>Vlan</th>
                    <th><?php echo $this->lang->line('') ?>Nap</th>
                    <th><?php echo $this->lang->line('') ?>Puerto</th>
                    <th><?php echo $this->lang->line('') ?>Asignado</th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('') ?>Detalle</th>
                    <th><?php echo $this->lang->line('') ?>Action</th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($puertos as $row) {
					$usuario = $this->db->get_where('customers', array('id' => $row['asignado']))->row();
                    $cid = $row['idp'];
                    $sede = $row['almacen'];
                    $idvlan = $row['idvlan'];
                    $vlan = $row['vlan'];
                    $idnap = $row['idnap'];
                    $nap = $row['nap'];
                    $puerto = $row['puerto'];
					$asignado = $usuario->abonado;
                    $iduser = $usuario->id;
                    $estado = $row['estado'];
                    $detalle = $row['dir_nap'];
                    echo "<tr>
                    <td>$i</td>
                    <td>$sede</td>
                    <td>$vlan <a href='" . base_url("redes/vlanedit?id=$idvlan") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>" . $this->lang->line('') . "</a></td>
                    <td>$nap  <a href='" . base_url("redes/napedit?id=$idnap") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>" . $this->lang->line('') . "</a></td>
                    <td>$puerto</td>
                    <td><a href='" . base_url("customers/view?id=$iduser") . "'>$asignado</a></td>
                    <td>$estado</td>
                    <td>$detalle</td>
                    
                  
                    <td><a href='" . base_url("redes/puertosedit?id=$cid") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>" . $this->lang->line('Edit') . "</a>&nbsp&nbsp<a href='#' data-object-id=" . $cid ." class='btn btn-danger btn-xs delete-object'><span class='icon-bin'></span>" . $this->lang->line('Delete') . "</a></td></tr>";
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>Sede</th>
                    <th><?php echo $this->lang->line('') ?>Vlan</th>
                    <th><?php echo $this->lang->line('') ?>Nap</th>
                    <th><?php echo $this->lang->line('') ?>Puerto</th>
                    <th><?php echo $this->lang->line('') ?>Asignado</th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('') ?>Detalle</th>
                    <th><?php echo $this->lang->line('') ?>Action</th>

                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('') ?>¿Seguro que desea borrar este registro?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="" name="deleteid">
                <input type="hidden" id="action-url" value="redes/delete_p">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script src="https://kit.fontawesome.com/317775a1b1.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#catgtable').DataTable({
			select: true,
			 order: [[1, 'desc']],
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
