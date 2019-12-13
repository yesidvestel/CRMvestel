<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <form method="post" action="<?php echo base_url('export/products_o') ?>" class="form-horizontal">
                    <div class="grid_3 grid_4">

                        <h5><?php echo $this->lang->line('Export Products') ?></h5>
                        <hr>


                        <div class="form-group row">

                            <select name="type" class="form-control">
                                <option value="1"><?php echo $this->lang->line('Products') ?></option>
                                <option value="2"><?php echo $this->lang->line('Products with categories') ?></option>
                            </select>
                        </div>


                        <div class="form-group row">


                            <div class="col-sm-4">
                                <input type="submit" class="btn btn-success margin-bottom"
                                       value="Backup" data-loading-text="Updating...">

                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']]

            ]
        });
    });
</script>

