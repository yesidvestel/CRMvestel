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
                                    <h5 class="text-bold-400"><?php  echo amountFormat($gasvesagro) . '/' . amountFormat($goals['expense']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($tt_exp * 100) / $goals['expense']);
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
                                    <h5 class="text-bold-400"><?php echo amountFormat($servicios) . '/' . amountFormat($goals['expense']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($tt_exp * 100) / $goals['expense']);
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
                                    <h5 class="text-bold-400"><?php echo amountFormat($compras) . '/' . amountFormat($goals['expense']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($tt_exp * 100) / $goals['expense']);
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
                                    <h5 class="text-bold-400"><?php echo amountFormat($creditos) . '/' . amountFormat($goals['expense']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($tt_exp * 100) / $goals['expense']);
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
                                    <h5 class="text-bold-400"><?php echo amountFormat($nomina) . '/' . amountFormat($goals['expense']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($tt_exp * 100) / $goals['expense']);
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
                                    <h5 class="text-bold-400"><?php echo amountFormat($socios) . '/' . amountFormat($goals['expense']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($tt_exp * 100) / $goals['expense']);
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
                                    <h5 class="text-bold-400"><?php echo amountFormat($oficial) . '/' . amountFormat($goals['expense']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($tt_exp * 100) / $goals['expense']);
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
