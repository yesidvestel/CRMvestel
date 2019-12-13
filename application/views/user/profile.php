<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="">
                <div class=" animated fadeInRight">
                    <div class="col-md-4">
                        <div class="card card-block">

                            <div>
                                <div class="ibox-content no-padding border-left-right">
                                    <img alt="image" class="img-responsive"
                                         src="<?php echo base_url('userfiles/employee/' . $employee['picture']); ?>">
                                </div>
                                <hr>
                                <div class="ibox-content profile-content">
                                    <h4><strong><?php echo $employee['name'] ?></strong></h4>
                                    <p><i class="icon-map-marker"></i> <?php echo $employee['city'] ?></p>

                                    <div class="row m-t-lg">
                                        <div class="col-md-12">
                                            <strong><?php echo $this->lang->line('Address') ?>
                                                : </strong><?php echo $employee['name'] ?>
                                        </div>

                                    </div>
                                    <div class="row m-t-lg">
                                        <div class="col-md-12">
                                            <strong><?php echo $this->lang->line('City') ?>
                                                : </strong><?php echo $employee['city'] ?>
                                        </div>

                                    </div>
                                    <div class="row m-t-lg">
                                        <div class="col-md-12">
                                            <strong><?php echo $this->lang->line('Region') ?>
                                                : </strong><?php echo $employee['region'] ?>
                                        </div>

                                    </div>
                                    <div class="row m-t-lg">
                                        <div class="col-md-12">
                                            <strong><?php echo $this->lang->line('Country') ?>
                                                : </strong><?php echo $employee['country'] ?>
                                        </div>

                                    </div>
                                    <div class="row m-t-lg">
                                        <div class="col-md-12">
                                            <strong><?php echo $this->lang->line('PostBox') ?>
                                                : </strong><?php echo $employee['postbox'] ?>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row m-t-lg">
                                        <div class="col-md-12">
                                            <strong><?php echo $this->lang->line('Phone') ?></strong> <?php echo $employee['phone']; ?>
                                        </div>

                                    </div>
                                    <div class="row m-t-lg">
                                        <div class="col-md-12">
                                            <strong>EMail</strong> <?php echo $employee['email']; ?>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-block">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-file-text-o"></i>
                                            </div>
                                            <div class="text">

                                                <label class="text-muted"><?php echo $this->lang->line('Invoices') ?></label>
                                            </div>
                                            <div class="options">
                                                <a href="<?php echo base_url('employee/invoices?id=' . $eid) ?>"
                                                   class="btn btn-primary btn-lg"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-book"></i>
                                            </div>
                                            <div class="text">

                                                <label class="text-muted"><?php echo $this->lang->line('Transactions') ?></label>
                                            </div>
                                            <div class="options">
                                                <a href="<?php echo base_url('employee/transactions?id=' . $eid) ?>"
                                                   class="btn btn-primary btn-lg"><i
                                                            class="fa fa-eye"></i> <?php echo $this->lang->line('View') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-user"></i>
                                            </div>
                                            <div class="text">

                                                <label class="text-muted"><?php echo $this->lang->line('Account') ?></label>
                                            </div>
                                            <div class="options">
                                                <a href="<?php echo base_url('user/update?id=' . $eid) ?>"
                                                   class="btn btn-primary btn-lg"><i class="icon-pencil"></i> Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-key"></i>
                                            </div>
                                            <div class="text">

                                                <label class="text-muted">Password</label>
                                            </div>
                                            <div class="options">
                                                <a href="<?php echo base_url('user/updatepassword?id=' . $eid) ?>"
                                                   class="btn btn-primary btn-lg"><i
                                                            class="icon-edit"></i><?php echo $this->lang->line('Change') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="hero-widget well well-sm">


                                            <p class="text-muted"><?php echo $this->lang->line('Your Signature') ?></p>

                                            <img alt="image" class="img-responsive"
                                                 src="<?php echo base_url('userfiles/employee_sign/' . $employee['sign']); ?>">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>