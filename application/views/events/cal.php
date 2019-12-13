<link href='<?php echo base_url(); ?>assets/portcss/fullcalendar.css' rel='stylesheet'/>
<link href="<?php echo base_url(); ?>assets/portcss/bootstrapValidator.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/portcss/bootstrap-colorpicker.min.css" rel="stylesheet"/>
<!-- Custom css  -->
<link href="<?php echo base_url(); ?>assets/portcss/custom.css" rel="stylesheet"/>
<script src='<?php echo base_url(); ?>assets/portjs/moment.min.js'></script>
<script src="<?php echo base_url(); ?>assets/portjs/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url(); ?>assets/portjs/fullcalendar.min.js"></script>
<script src='<?php echo base_url(); ?>assets/portjs/bootstrap-colorpicker.min.js'></script>


<script src='<?php echo base_url(); ?>assets/portjs/main.js'></script>


<article class="content">
    <div class="card card-block">
        <!-- Notification -->
        <div class="alert"></div>


        <div id='calendar'></div>
    </div>
</article>


<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="error"></div>
                <form class="form-horizontal" id="crud-form">
                    <input type="hidden" id="start">
                    <input type="hidden" id="end">
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="title"><?php echo $this->lang->line('Add Event')  ?></label>

                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="title"><?php echo $this->lang->line('Title')  ?></label>
                        <div class="col-md-8">
                            <input id="title" name="title" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="description"><?php echo $this->lang->line('Description')  ?></label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="color"><?php echo $this->lang->line('Color')  ?></label>
                        <div class="col-md-4">
                            <input id="color" name="color" type="text" class="form-control input-md"
                                   readonly="readonly"/>
                            <span class="help-block">Click to pick a color</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Cancel')  ?></button>
            </div>
        </div>
    </div>
</div>



