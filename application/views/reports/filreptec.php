<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('Account Statement') ?></h6>
            <hr>

            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">

                        <form action="<?php echo base_url() ?>reports/estadisticaportecnico" method="post" role="form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat">Tecnico</label>

                                <div class="col-sm-9">
                                    <select name="tecnico" class="form-control">
										<option value="all">Todos</option>
                                        <?php
                                        foreach ($tecnicos as $row) {
                                            $cid = $row['id'];
                                            $acn = $row['username'];
                                            echo "<option value='$acn'>$acn</option>";
                                        }
                                        ?>
                                    </select>


                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat">Sede</label>

                                <div class="col-sm-9">
                                    <select name="sede" class="form-control">
                                        <option value='all'>Todas</option>
                                        <?php
                                        foreach ($sede as $row) {
                                            $cid = $row['id'];
                                            $acn = $row['title'];
                                            echo "<option value='$cid'>$acn</option>";
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="sdate">Mes</label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="sdate" id="sdate2"
                                            autocomplete="false">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary btn-md" value="Ver">


                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</article>
