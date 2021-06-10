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
                            <h4 class="card-title"><?php echo $this->lang->line('All Time Detailed Statistics') ?></h4>
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
                                <table class="table table-hover mb-1" border="1">
                                    <thead>
										<tr>
										<th rowspan="2">Tipor de orden</th>
										<th colspan="30" style="text-align: center">Dia</th>
										</tr>
									
                                    <tr>
                                        
                                        <?php for ($i=1;$i<=30;$i++){
													echo '<th>'.$i.'</th>';}?>
                                        <th><?php echo $this->lang->line('sold') . $this->lang->line('products') ?></th>
                                    </tr>
										
                                    </thead>
                                    <tbody>
				
										<tr>
											<td>Instalacion Tv+Internet</td>
											<?php for ($i=1;$i<=30;$i++){
											
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="Instalacion"')
												->like("section","Television +","right")
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
											<?php 
											$totalins= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->like("created","2021-06","left")
												->where('detalle="Instalacion"')
												->like("section","Television +","right")
												->get()->result(); ?>
											<td align="center"><?php echo $totalins[0]->numero ?></td>
										</tr>
										<tr>
											<td bgcolor="#D5D5D5">Instalacion Television</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="Instalacion"')
												->where('section="Television"')
												->get()->result(); ?>
											<td bgcolor="#D5D5D5"><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Instalacion Internet</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="Instalacion"')
												->not_like("section","Television")
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Agregar Television</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="AgregarTelevision"')
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Agregar Internet</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="AgregarInternet"')
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Traslado</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="Traslado"')
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Revision</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->like("section","Revision","right")
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Reconexion Television</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="Reconexion Television"')
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Suspension Combo</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="Suspension Combo"')
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Suspension Internet</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="Suspension Internet"')
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Suspension Television</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="Suspension Television"')
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
										</tr>
										<tr>
											<td>Corte Television</td>
											<?php for ($i=1;$i<=30;$i++){
											$instalaciones= $this->db->select("count(idt) as numero")
												->from('tickets')
												->where('status="Resuelto"')
												->where('created="2021-06-'.$i.'"')
												->where('detalle="Corte Television"')
												->get()->result(); ?>
											<td><?php echo $instalaciones[0]->numero; } ?></td>
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