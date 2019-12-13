<article class="content">
    <div class="">
        <div class="row animated fadeInRight">

            <div class="col-md-8">
                <div class="card card-block">
                    <div class="ibox-title">
                        <h5><?php echo $this->lang->line('Details') ?></h5>
                        <div class="card sameheight-item stats" data-exclude="xs" style="height: 323px;">
                            <div class="card-block">

                                <div class="row row-sm stats-container">
                                    <div class="col-xs-12 col-sm-6 stat-col">

                                        <div class="stat">
                                            <div class="name"> <?php echo $this->lang->line('Account No') ?></div>
                                            <div class="value"> <?php echo $account['acn'] ?></div>

                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 stat-col">

                                        <div class="stat">
                                            <div class="name"> <?php echo $this->lang->line('Name') ?></div>
                                            <div class="value"> <?php echo $account['holder'] ?></div>

                                        </div>
                                        <hr>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 stat-col">

                                        <div class="stat">
                                            <div class="name"><?php echo $this->lang->line('Balance') ?></div>
                                            <div class="value"> <?php echo $account['lastbal'] ?></div>

                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 stat-col">

                                        <div class="stat">
                                            <div class="name"> <?php echo $this->lang->line('Opening Date') ?></div>
                                            <div class="value"> <?php echo dateformat_time($account['adate']) ?></div>

                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 stat-col">

                                        <div class="stat">
                                            <div class="name"> <?php echo $this->lang->line('Note') ?></div>
                                            <div class="value"> <?php echo $account['code'] ?></div>

                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</article>