<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Edit') ?></h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Title') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Task Title"
                               class="form-control margin-bottom  required" name="name"
                               value="<?php echo $task['name'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Status') ?></label>

                    <div class="col-sm-4">
                        <select name="status" class="form-control">
                            <?php echo '<option value="' . $task['status'] . '">--' . $this->lang->line($task['status']) . '--</option>'; 
							echo"<option value='Due'>".$this->lang->line('Due')."</option>
                            <option value='Done'>".$this->lang->line('Done')."</option>
                            <option value='Progress'>".$this->lang->line('Progress')."</option>";
							?>

                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Priority') ?></label>

                    <div class="col-sm-4">
                        <select name="priority" class="form-control">
                            <?php echo '<option value="' . $task['priority'] . '">--' . $task['priority'] . '--</option>'; ?>
                            <option value='Low'>Baja</option>
                            <option value='Medium'>Media</option>
                            <option value='High'>Alta</option>
                            <option value='Urgent'>Urgente</option>
                        </select>


                    </div>
                </div>
 <?php if($this->aauth->get_user()->roleid>3){ ?>
<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat">Puntuación</label>

                    <div class="col-sm-4">
                        <select name="puntuacion" class="form-control">
                            <?php for ($i=0; $i <=100 ; $i++) { 
                                if($task['puntuacion']==$i){

                                    echo "<option selected='true' value='".$i."'>".$i." puntos</option>";
                                }else{
                                    echo "<option value='".$i."'>".$i." puntos</option>";   
                                }
                            } ?>
                        </select>


                    </div>
                </div>
            <?php } ?>
                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="edate"><?php echo $this->lang->line('Start Date') ?></label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control required"
                               placeholder="Start Date" name="staskdate"
                               data-toggle="datepicker" autocomplete="false" value="<?php echo $task['start'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="edate"><?php echo $this->lang->line('Due Date') ?></label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control required"
                               placeholder="End Date" name="taskdate"
                               data-toggle="datepicker" autocomplete="false" value="<?php echo $task['duedate'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Assign to') ?></label>

                    <div class="col-sm-4">

                        <select name="employee" class="form-control select-box">
                            <?php
                            echo '<option value="' . $task['eid'] . '">--' . $task['emp'] . '--</option>';
                            foreach ($emp as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                 <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                    for="pay_cat">Agendar</label>
                                    <div class="col-sm-2">
                                        
                                        <div class="input-group">
                                        <select name="agendar" id="agendar" class="form-control mb-1">
                                                <option value='no'>No</option>
                                                <option value='si'>Si</option>
                                                <option value='actualizar'>Actualizar</option>
                                            </select>
                                        </div>
                                        </div>
                                    <div class="col-sm-3 agendar-cl">
                                        

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control"
                                                   placeholder="Billing Date" name="f_agenda"
                                                   data-toggle="datepicker"
                                                   autocomplete="false" >
                                            
                                        </div>
                                        
                                    
                                </div>
                                    <div class="col-sm-3 agendar-cl">
                                        

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control"
                                           placeholder="End Date" name="hora"
                                            autocomplete="false" value="<?php echo date("g:i a") ?>">
                                            
                                        </div>
                                        
                                    
                                </div>
                            </div>
                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="content"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10"
                                  name="content"><?php echo $task['description'] ?></textarea>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="tools/edittask" id="action-url">
                        <input type="hidden" value="<?php echo $task['id'] ?>" name="id">
                    </div>
                </div>
            </form>
			<div class="row">
				<table class="table table-striped">
					<thead>
					<tr>
						<th><?php echo $this->lang->line('Files') ?></th>
					</tr>
					</thead>
					<tbody id="activity">
					<?php foreach ($attach as $row) {

						echo '<tr><td><a data-url="' . base_url() . 'tools/file_handling?op=delete&name=' . $row['col1'] . '&type='.$row['type'].'&invoice=' . $_GET['id'] . '" class="aj_delete"><i class="btn-danger btn-lg icon-trash-a"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
					} ?>

					</tbody>
				</table>
					<!-- The fileinput-button span is used to style the file input field as button -->
					<span class="btn btn-success fileinput-button">
					<i class="glyphicon glyphicon-plus"></i>

						<!-- The file input field used as target for the file upload widget -->
					<input id="fileupload" type="file" name="files[]" multiple>
					</span>
					<br>
					<pre>tipos: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
					<br>
					<!-- The global progress bar -->
					<div id="progress" class="progress">
						<div class="progress-bar progress-bar-success"></div>
					</div>
					<!-- The container for the uploaded files -->
					<table id="files" class="files"></table>
					<br>
			</div>
        </div>
    </div>
</article>
<script type="text/javascript">
 $("#agendar").change(function(){
            if($(this).val()=="no"){
                $(".agendar-cl").css("display","none");    
            }else{
                $(".agendar-cl").css("display","");
            }
            
        });
    $(function () {
        $('.select-box').select2();

        $('.summernote').summernote({
            height: 250,
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
    });
</script>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
/*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>tools/file_handling?id=<?php echo $_GET['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>tools/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $_GET['id'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });
</script>