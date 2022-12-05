<?php 

$tt_inc = 0;foreach ($gastototal as $row) {
        $tt_exp += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval($row['total']) . "},";
    }
        ?>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Metas Mensuales</h6>
            <hr>

            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"><?php echo $this->lang->line('') ?>Vesagro</h5>
                                    <h5 class="text-bold-400"><?php  echo amountFormat($gasvesagro) . '/' . amountFormat($goals['vesagro']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($gasvesagro* 100) / $goals['vesagro']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Servicios</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($servicios) . '/' . amountFormat($goals['servicios']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($servicios * 100) / $goals['servicios']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Compras</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($compras) . '/' . amountFormat($goals['compras']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($compras * 100) / $goals['compras']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Creditos y Acuerdos</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($creditos) . '/' . amountFormat($goals['creditos']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($creditos * 100) / $goals['creditos']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Proveedores internet</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($internet) . '/' . amountFormat($goals['internet']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($internet * 100) / $goals['internet']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Programadoras</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($programadora) . '/' . amountFormat($goals['programadora']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($programadora * 100) / $goals['programadora']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Impuestos</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($impuestos) . '/' . amountFormat($goals['impuestos']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($impuestos * 100) / $goals['impuestos']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
			<div class="col-md-6">
                    <div class="card card-block sameheight-item">
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Nomina</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($nomina) . '/' . amountFormat($goals['nomina']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($nomina * 100) / $goals['nomina']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Socios</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($socios) . '/' . amountFormat($goals['socios']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($socios * 100) / $goals['socios']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Oficial</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($oficial) . '/' . amountFormat($goals['oficial']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($oficial * 100) / $goals['oficial']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Ordenes de compra</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($purchase) . '/' . amountFormat($goals['purchase']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($purchase * 100) / $goals['purchase']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Servicios publicos</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($publicos) . '/' . amountFormat($goals['publicos']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($publicos * 100) / $goals['publicos']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Comisiones</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($comisiones) . '/' . amountFormat($goals['comisiones']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($comisiones * 100) / $goals['comisiones']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('') ?>Celulares</h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($celulares) . '/' . amountFormat($goals['celulares']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($celulares * 100) / $goals['celulares']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</article>
