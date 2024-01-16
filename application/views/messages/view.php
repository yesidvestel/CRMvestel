<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="content-header row">

            <div class="card card-block"><h5 class="card-title"><?php echo $this->lang->line('Messages') ?> <a
                            href="#sendUserPM" data-toggle="modal"
                            data-remote="false" data-type="reminder"
                            class="btn btn-large btn-success"

                    ><span class="icon-mail"></span> <?php echo $this->lang->line('') ?>Responder</a> <a href="#deletePM"
                                                                                                       data-toggle="modal"
                                                                                                       data-remote="false"
                                                                                                       data-type="reminder"
                                                                                                       class="btn btn-large btn-danger"

                    ><span class="icon-trash"></span> <?php echo $this->lang->line('Delete') ?> </a></h5>
				<?php foreach ($employee as $row) { ?>
                <section id="description" class="card">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card-header">
                                <h4 class="card-title"><?php
                                    //print_r($employee);
                                    echo $row['name'];
                                    ?></h4>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <div class="card-text">
                                        <p><img alt="image" class="img-circle " src="<?php

                                            echo base_url('userfiles/employee/' . $row['picture']);
                                            ?>"></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <?php
                            //print_r($employee);
                            //$pms = $this->aauth->get_pm($pmid, $this->aauth->get_user()->id);

                            echo '<div class="card-header">
                        <h4 class="card-title">' . $row['title'] . '</h4>
                    </div>
                    <div class="card-body collapse in">' . $row['date_sent'] . '
                        <div class="card-block">
                            <div class="card-text">
                                <p>' . $row['message'] . '</p>

                            </div>
                        </div>
                    </div>'; ?></div>
                    </div>
                </section>
				<?php } ?>
            </div>


        </div>
    </div>
</div>


<div id="sendUserPM" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Send Message') ?></h4>
            </div>

            <div class="modal-body" id="emailbody">
                <form class="sendpm">
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="username"><?php echo $this->lang->line('UserName') ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-user"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Username" name="username"
                                       id="username"
                                       value="" autocomplete="off"><input type="hidden" id="userid" name="userid"
                                                                          value="">
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1">
                            <div id="username-result"></div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="invoiceid" name="tid" value="">
                    <input type="hidden" class="form-control"
                           id="emailtype" value="">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="send_pm_u"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
</div>
<div id="deletePM" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <form class="delete_pm">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php echo $this->lang->line('delete message') ?>

                        </div>
                    </div>


                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="pmid" value="<?php echo $pmid ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <button type="button" class="btn btn-primary"
                                id="sendpm"><?php echo $this->lang->line('Delete') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });

        $('form').on('submit', function (e) {
            e.preventDefault();
            alert($('.summernote').summernote('code'));
            alert($('.summernote').val());
        });
    });
    $(document).on('click', "#send_pm_u", function (e) {
        e.preventDefault();


        sendPM();


    });

    function sendPM() {


        $("#sendUserPM").modal('hide');

        jQuery.ajax({

            url: baseurl + 'messages/sendpm',
            type: 'POST',
            data: $('form.sendpm').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);


                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });

    }

    $("#username").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search/user',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#username").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#username-result").show();
                $("#username-result").html(data);
                $("#username").css("background", "none");

            }
        });
    });

    $(document).on('click', ".selectuser", function (e) {
        e.preventDefault();


        $("#username").val($(this).attr('data-username'));
        $("#userid").val($(this).attr('data-userid'));


    });


    $(document).on('click', "#sendpm", function (e) {
        e.preventDefault();


        deletePM();


    });

    function deletePM() {


        $("#deletePM").modal('hide');

        jQuery.ajax({

            url: baseurl + 'messages/deletepm',
            type: 'POST',
            data: $('form.delete_pm').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#description').remove();


                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });

    }
</script>