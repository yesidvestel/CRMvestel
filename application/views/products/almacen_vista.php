<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5><?php echo $this->lang->line('Products') ?></h5>
			<div class="col-xl-4 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                    
										<?php $numero_asignados= $this->db->select('count(id) as numero')->from('equipos')->where('almacen='.$_GET["id"].' AND asignado=0 or asignado is null')->get()->result(); ?>
                                        <h3 class="green"><?=$numero_asignados[0]->numero?></h3>
                                        <span>Por asignar</span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-rocket green font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <?php $numero_sinasignar= $this->db->select('count(id) as numeroasig')->from('equipos')->where('almacen='.$_GET["id"].' AND asignado!=0')->get()->result(); ?>
                                        <h3 class="red"><?=$numero_sinasignar[0]->numeroasig?></h3>
                                        <span>Asignados</span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-blocked red font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <?php $numero_total= $this->db->select('count(id) as numero')->from('equipos')->where('almacen='.$_GET["id"].'')->get()->result(); ?>
                                        <h3 class="cyan"><?=$numero_total[0]->numero?></h3>
                                        <span><?php echo $this->lang->line('Total') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-stats-bars22 cyan font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
        <hr>

            <hr>
            <table id="equipostable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
					<th>Codigo</th>
                    <th>MAC</th>
                    <th>Serial</th>
                    <th>Estado</th>
                    <th>Asignado a:</th>
					<th>Marca</th>
					<th>T/po sistema</th>
					<th>Vlan</th>
					<th>Nat</th>
					<th>P/to Nat</th>
					<th>Img</th>
                    <th><?php echo $this->lang->line('Settings') ?></th>


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
					<th>Codigo</th>
                    <th>MAC</th>
                    <th>Serial</th>
                    <th>Estado</th>
                    <th>Asignado a:</th>
					<th>Marca</th>
					<th>T/po sistema</th>
					<th>Vlan</th>
					<th>Nat</th>
					<th>P/to Nat</th>
					<th>Img</th>
                    <th><?php echo $this->lang->line('Settings') ?></th>

                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">

    var table;

    $(document).ready(function () {

        //datatables
        table = $('#equipostable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('products/equipos_list') . '?id=' . $_GET['id']; ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
			"order": [[ 2, "desc" ]],
                "language": {
                    "info": "Pagina _PAGE_ de _PAGES_",
                    "zeroRecords": "No se encontraron resultados",
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }

        });

    });
	$("#equipostable").on('draw.dt',function (){
		$(".clasignar").click(function(ev){
			ev.preventDefault();
			$("#asigna_model").modal("show");
			$("#object-id2").val($(this).data("object-id2"));
		
		});
	});
	
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this product') ?></p>
            </div>
			
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="products/delete_e">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
            </div>
        </div>
    </div>
</div>
<div id="asigna_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('') ?>Asignacion</h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('') ?>Asignar equipo a tecnico</p>
				<div>
					<select name="tecnico" class="form-control" id="tec">
						<?php
						foreach ($tecnicoslista as $row) {
							$cid = $row['id'];
							$title = $row['username'];
							$nombre = $row['name'];
							echo "<option value='$title' data-id='$cid'>$nombre</option>";
						}
						?>
					</select>
				</div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id2" value="">
                <input type="hidden" id="action-urldos" value="products/asigna_e">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="asignar-confirm"><?php echo $this->lang->line('') ?>Asignar</button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
            </div>
        </div>
    </div>
