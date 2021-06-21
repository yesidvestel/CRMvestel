<style>
.static {
  	position: sticky;
  	left: 0;
	width: 140px;
	background: white;
}
.staticdos {
  	position: sticky;
  	top: 0;
}
	th .static{
		background-color:#719FD0;
	}
	
.first-col {
  padding-left: 35px!important;
}
table {
  display: block;
  overflow-x: auto;
}
	th {
		background-color:#719FD0;
	}
	tr:nth-child(2n){
		background-color:aliceblue;
	}
	tr:nth-child(2n) .static{
		background-color:aliceblue;
	}
</style>
<?php $mes = date("Y-m-",strtotime($filter[2]));
	/*if ($filter[0]=="all")
	$tecnico = '';
	}else{
	$tecnico = 'asignado="'.$filter[0].'"';
	}*/?>
	
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="card-header">
                <h4 class="card-title">Rendimiento Tecnico<a class="float-xs-right"
                                                                                               href="<?php echo base_url() ?>reports/refresh_data"><i
                                class="icon-refresh2"></i></a></h4>


            </div>
        </div>
        <div class="content-body"><!-- stats -->

            <!--/ stats -->
            <!--/ project charts -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title"><?php echo $this->lang->line('Sales in last 12 months') ?></h6>

                        </div>

                        <div class="card-body">


                            <div id="invoices-sales-chart"></div>

                        </div>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title"><?php echo $this->lang->line('Products in last 12 months') ?></h6>

                        </div>

                        <div class="card-body">


                            <div id="invoices-products-chart"></div>

                        </div>

                    </div>
                </div>

            </div>
            <!--/ project charts -->
            <!-- Recent invoice with Statistics -->
            <div class="row match-height">

                <div class="col-xl-12 col-lg-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Estadisticas Detalladas <?php echo $filter[0]?></h4>
                            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                                    <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-hover mb-1">
                                    <thead>
										<tr>
										<th rowspan="2" width="140px" class="static">Tipor de orden</th>
										<th colspan="31" style="text-align: center">Dia</th>
										</tr>
									
                                    <tr>
                                        
                                        <?php for ($i=1;$i<=31;$i++){
													echo '<th>'.$i.'</th>';}?>
                                        <th rowspan="2">TOTAL</th>
                                    </tr>
										
                                    </thead>
                                    <tbody>
										
										<tr>
											<td class="static">Ins. Tv+Int</td>
											<?php foreach ($tipos as $row) {
											
											 /*?>$this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="Instalacion"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												
												$instalaciones= $this->db->like("section","Television +","right")->get()->result(); <?php */?>
											
											<td class="first-col"><?php echo $row['numero']; } ?></td>
											<?php 
											$totalins= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="Instalacion"')
												->like("section","Television +","right");
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalins= $this->db->get()->result();
												 ?>
											<td align="center"><?php echo $totalins[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Ins. Tv</td>
											<?php for ($i=1;$i<=31;$i++){
											$instalacionestv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="Instalacion"')
												->where('section="Television"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$instalacionestv = $this->db->get()->result(); ?>
											<td><?php echo $instalacionestv[0]->numero; } ?></td>
											<?php 
											$totalinstv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="Instalacion"')
												->where('section="Television"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalinstv = $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalinstv[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Ins. Int</td>
											<?php for ($i=1;$i<=31;$i++){
											$instalacionesint= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="Instalacion"')
												->not_like("section","Television");
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$instalacionesint = $this->db->get()->result(); ?>
											<td><?php echo $instalacionesint[0]->numero; } ?></td>
											<?php 
											$totalinsint= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="Instalacion"')
												->not_like("section","Television");
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalinsint = $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalinsint[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Agregar Tv</td>
											<?php for ($i=1;$i<=31;$i++){
											$agregartv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="AgregarTelevision"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$agregartv = $this->db->get()->result(); ?>
											<td><?php echo $agregartv[0]->numero; } ?></td>
											<?php 
											$totalinsagretv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="AgregarTelevision"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalinsagretv = $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalinsagretv[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Agregar Int</td>
											<?php for ($i=1;$i<=31;$i++){
											$agregarint= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="AgregarInternet"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$agregarint = $this->db->get()->result(); ?>
											<td><?php echo $agregarint[0]->numero; } ?></td>
											<?php 
											$totalinsagrein= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="AgregarInternet"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalinsagrein = $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalinsagrein[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Traslado</td>
											<?php for ($i=1;$i<=31;$i++){
											$traslado= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="Traslado"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$traslado = $this->db->get()->result(); ?>
											<td><?php echo $traslado[0]->numero; } ?></td>
											<?php 
											$totaltras= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="Traslado"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totaltras = $this->db->get()->result(); ?>
											<td align="center"><?php echo $totaltras[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Revision</td>
											<?php for ($i=1;$i<=31;$i++){
											$revision= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->like("detalle","Revision","right");
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$revision = $this->db->get()->result(); ?>
											<td><?php echo $revision[0]->numero; } ?></td>
											<?php 
											$totalrev= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->like("detalle","Revision","right");
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalrev = $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalrev[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Recon. Tv</td>
											<?php for ($i=1;$i<=31;$i++){
											$reconexiontv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->like("detalle","Reconexion","right");
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$reconexiontv = $this->db->get()->result(); ?>
											<td><?php echo $reconexiontv[0]->numero; } ?></td>
											<?php 
											$totalrecotv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->like("detalle","Reconexion","right");
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalrecotv = $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalrecotv[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Sus. Tv+Int</td>
											<?php for ($i=1;$i<=31;$i++){
											$suspensioncom= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="Suspension Combo"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$suspensioncom = $this->db->get()->result(); ?>
											<td><?php echo $suspensioncom[0]->numero; } ?></td>
											<?php 
											$totalsuscom= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="Suspension Combo"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalsuscom = $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalsuscom[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Sus. Int</td>
											<?php for ($i=1;$i<=31;$i++){
											$suspensionint= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="Suspension Internet"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$suspensionint = $this->db->get()->result(); ?>
											<td><?php echo $suspensionint[0]->numero; } ?></td>
											<?php 
											$totalsusint= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="Suspension Internet"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalsusint = $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalsusint[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Sus. Tv</td>
											<?php for ($i=1;$i<=31;$i++){
											$suspensiontv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="Suspension Television"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$suspensiontv= $this->db->get()->result(); ?>
											<td><?php echo $suspensiontv[0]->numero; } ?></td>
											<?php 
											$totalsustv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="Suspension Television"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalsustv= $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalsustv[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static">Corte Tv</td>
											<?php for ($i=1;$i<=31;$i++){
											$cortetv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"')
												->where('detalle="Corte Television"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$cortetv= $this->db->get()->result(); ?>
											<td><?php echo $cortetv[0]->numero; } ?></td>
											<?php 
											$totalcortv= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left")
												->where('detalle="Corte Television"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalcortv= $this->db->get()->result(); ?>
											<td align="center"><?php echo $totalcortv[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static" style="background-color:#719FD0 ">TOTAL DIA</td>
											<?php for ($i=1;$i<=31;$i++){
											$totalrsto= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->where('fecha_final="'.$mes.$i.'"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalrsto= $this->db->get()->result(); ?>
											<td style="background-color:#719FD0 "><?php echo $totalrsto[0]->numero; } ?></td>
											<?php 
											$totalgenrto= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Resuelto"')
												->like("fecha_final","$mes","left");
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalgenrto= $this->db->get()->result(); ?>
											<td align="center" style="background-color:#719FD0 "><?php echo $totalgenrto[0]->numero ?></td>
										</tr>
										<tr>
											<td class="static" style="background-color: cadetblue">PENDIENTES</td>
											<?php for ($i=1;$i<=31;$i++){
											$totalrsto= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Pendiente"')
												->where('created="'.$mes.$i.'"');
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalrsto= $this->db->get()->result(); ?>
											<td style="background-color: cadetblue"><?php echo $totalrsto[0]->numero; } ?></td>
											<?php 
											$totalgenrto= $this->db->select("count(idt) as numero")
												->from('tickets')
												->join('customers', 'tickets.cid=customers.id', 'left')
												->where('gid="'.$filter[1].'"')
												->where('status="Pendiente"')
												->like("created","$mes","left");
												if($filter[0]!="all"){
													$this->db->where('asignado="'.$filter[0].'"');
												}
												$totalgenrto= $this->db->get()->result(); ?>
											<td align="center" style="background-color: cadetblue"><?php echo $totalgenrto[0]->numero ?></td>
										</tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent invoice with Statistics -->


        </div>
    </div>
</div>
<script type="text/javascript">


    $('#invoices-sales-chart').empty();

    Morris.Bar({
        element: 'invoices-sales-chart',
        data: [
            <?php $i = 0;foreach (array_reverse($stat) as $row) {
            if ($i > 11) break;
            $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['income']) . ", z: " . intval($row['expense']) . "},";
            $i++;
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Income', 'expense'],
        hideHover: 'auto',
        resize: true,
        barColors: ['#34cea7', '#ff6e40'],
    });


    $('#invoices-products-chart').empty();

    Morris.Line({
        element: 'invoices-products-chart',
        data: [
            <?php $i = 0;foreach (array_reverse($stat) as $row) {
            if ($i > 11) break;
            $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['items']) . ", z: " . intval($row['invoices']) . "},";
            $i++;
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Products', 'Invoices'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40'],
    });


</script>