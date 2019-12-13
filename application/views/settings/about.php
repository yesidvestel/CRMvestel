<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5>About</h5>
                <hr>


                <div class="form-group row">


                    <div class="col-sm-12 text-xs-center">
                        <h3>Neo Billing</h3><h5> V 3.6 </h5> <h6> Copyright 2019 <a
                                    href="https://codecanyon.net/user/ultimatekode">UltimateKode</a>
                        </h6>

                    </div>
                </div>


            </div>
        </form>
    </div>
</article>
<script type="text/javascript">
    $("#time_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/dtformat';
        actionProduct(actionurl);
    });
</script>

