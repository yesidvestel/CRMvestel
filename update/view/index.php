<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title>NeoBilling Update Wizard</title>
    <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.css'/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel='stylesheet' type='text/css' href='assets/css/install.css'/>
    <link rel="shortcut icon" href="../assets/images/favicon.ico"/>

    <script type='text/javascript' src='assets/js/jquery.min.js'></script>
    <script type='text/javascript' src='assets/jquery-validation/jquery.validate.min.js'></script>
    <script type='text/javascript' src='assets/jquery-validation/jquery.form.js'></script>

</head>
<body>
<div class="install-box">

    <div class="panel panel-install">
        <div class="panel-heading text-center">
            <h2>Neo Billing Update Wizard</h2>
        </div>
        <div class="panel-body no-padding">
            <div class="tab-container clearfix">

                <div id="pre-installation" class="tab-title col-sm-4 active"><i class="fa fa-circle-o"></i><strong>
                        Info</strong></span></div>
                <div id="configuration" class="tab-title col-sm-4"><i class="fa fa-circle-o"></i><strong>
                        Configuration</strong></div>
                <div id="finished" class="tab-title col-sm-4"><i class="fa fa-circle-o"></i><strong> Finished</strong>
                </div>
            </div>
            <div class="tab-content">


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="pre-installation-tab">
                        <div class="section">
                            <div class="text-center">
                                <h4>About</h4>
								<p><strong>This wizard is not applicable for fresh installation.</strong></p>
                                <hr class="star-primary">
                                <p>Application Name: <strong>Neo Billing</strong></p>
                                <p>New Version: <strong> v <?php echo VER ?></strong></p>
                                <p>Minimum Required Installed Version: <strong> v <?php echo PREVIOUS ?></strong></p>

                                <p>Update Release Date: <strong><?php echo RDATE ?></strong></p>

                                <p>By: <strong>Rajesh Dukiya</strong> [ <a href="https://www.ultimatekode.com"
                                                                           target="_blank">www.ultimatekode.com</a>
                                    ]</p>
									
                            </div>
                        </div>
                        <div class="section">
                            <div class="text-center">
                                <h4>Support</h4>
                                <hr class="star-primary">

                                <p>If you find any bugs or you have any idea for improvement, Please don't hesitate to
                                    contact with me using
                                    Our profile page<br>
                                    <a href="http://codecanyon.net/user/ultimatekode"
                                       target="_blank">http://codecanyon.net/user/ultimatekode</a></p>
                            </div>
                        </div>


                        <div class="panel-footer">
                            <button class="btn btn-info form-next"><i class='fa fa-chevron-right'></i> Next</button>
                        </div>


                    </div>
                    <div role="tabpanel" class="tab-pane" id="configuration-tab">

                        <div class="section">

                            <form name="config-form" id="config-form" action="action.php" method="post">

                                <div class="section clearfix">
                                    <p><strong>Please enter your database connection details.</strong></p>
                                    <hr/>
                                    <div>
                                        <div class="form-group clearfix">
                                            <label for="host" class=" col-md-3">Database Host</label>
                                            <div class="col-md-9">
                                                <input type="text" value="" id="host" name="host" class="form-control"
                                                       placeholder="Database Host (usually localhost)"/>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbuser" class=" col-md-3">Database User</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbuser" class="form-control"
                                                       autocomplete="off" placeholder="Database user name"/>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbpassword" class=" col-md-3">Password</label>
                                            <div class=" col-md-9">
                                                <input type="password" value="" name="dbpassword" class="form-control"
                                                       autocomplete="off" placeholder="Database user password"/>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbname" class=" col-md-3">Database Name</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbname" class="form-control"
                                                       placeholder="Database Name"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="panel-footer">
                                    <button  <?php
                            if (!$all_requirement_success) {
                                echo "disabled=disabled";
                            }
                            ?>  type="submit" class="btn btn-info form-next">
                                        <span class="loader hide"> Please wait...It may take 5+ minutes...</span>
                                        <span class="button-text"><i class='fa fa-chevron-right'></i> Finish</span>
                                    </button>
                                </div>

                            </form>


                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="finished-tab">
                        <div class="clearfix">
                            <i class="status fa fa-check-circle-o pull-left" style="font-size: 50px"> </i><span
                                    class="pull-left" style="line-height: 50px;">Congratulation! update successfully installed.</span>

                        </div>

                        <div style="margin: 15px 0 15px 60px; color: #d73b3b;">
                            Don't forget to delete your update and install directory!
                        </div>

                    </div>
                    <div id="alert-container">

                    </div>
                    <div class="text-center m-b-10">
                        Thank you for purchasing our application, write us on support@ultimatekode.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    var configurationIab = $('#form_control');
    var onFormSubmit = function ($form) {
        configurationIab.attr('name', 'app_url[]');
        $form.find('[type="submit"]').attr('disabled', 'disabled').find(".loader").removeClass("hide");
        $form.find('[type="submit"]').find(".button-text").addClass("hide");
        $("#alert-container").html("");
    };
    var onSubmitSussess = function ($form) {
        $form.find('[type="submit"]').removeAttr('disabled').find(".loader").addClass("hide");
        $form.find('[type="submit"]').find(".button-text").removeClass("hide");
    };


    $(document).ready(function () {
        var $preInstallationTab = $("#pre-installation-tab"),
            $termTab = $("#terms-tab"),
            $configurationTab = $("#configuration-tab");


        $(".form-next1").click(function () {

            $termTab.removeClass("active");
            $("#terms").removeClass("active");
            $preInstallationTab.addClass("active");
            $("#pre-installation").addClass("active");
            $("#terms").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");

        });
        $(".form-next").click(function () {

            if ($preInstallationTab.hasClass("active")) {
                $("#pre-installation").removeClass("active");
                $preInstallationTab.removeClass("active");

                $termTab.removeClass("active");
                $configurationTab.addClass("active");
                $("#pre-installation").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                $("#configuration").addClass("active");
                $("#host").focus();
            }
        });

        $("#config-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $configurationTab.removeClass("active");
                        $("#configuration").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").addClass("active");
                        $("#finished-tab").addClass("active");
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });

    });
</script>