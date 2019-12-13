<article class="content">
    <div class="card card-block">
        <?php if ($message) {

            echo '<div id = "notify" class="alert alert-success"  >
            <a href = "#" class="close" data - dismiss = "alert" >&times;</a >

            <div class="message" >Token updated successfully!</div >
        </div >';
        } ?>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <div class="card-block"><h5>Cron Job Management </h5>

                <hr>
                <p>The software utility Cron is a time-based job scheduler. People who set up and maintain autometed
                    application task use cron to schedule jobs to run periodically at fixed times, dates, or intervals.
                    Recommended cron job scheduling is in midnight.</p><br><a
                        href="<?php echo base_url('cronjob/generate'); ?>" class="btn btn-primary btn-sm rounded">
                    Update Cron Token
                </a>
                <p></p>
                <h4 class="text-gray-dark"><?php echo $corn['cornkey']; ?></h4>

                <hr>
                <p class="text-bold-500"> Job Recurring Invoices Auto Management URL is</p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/reccuring?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/reccuring?token=' . $corn['cornkey']) ?></pre>
                <hr>
                <p class="text-bold-500">Due Recurring Invoices Autometic Email URL is </p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/rec_invoices_email?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/rec_invoices_email?token=' . $corn['cornkey']) ?></pre>
                <hr>
                <p class="text-bold-500">Due Invoices Autometic Email URL is </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/due_invoices_email?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/due_invoices_email?token=' . $corn['cornkey']) ?></pre>

                <hr>
                <p class="text-bold-500">Automatic Report data update</p>
                <p>
                    <small>This action will update the monthly sales,sold items, total income and expenses of past 12
                        months.
                    </small>
                </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/reports?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/reports?token=' . $corn['cornkey']) ?></pre>

                <p class="text-bold-500">Automatic Currency Exchange Rates update</p>
                <p>
                    <small>This action will update the payment Currency Exchange Rates.
                    </small>
                </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/update_exchange_rate?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/update_exchange_rate?token=' . $corn['cornkey']) ?></pre>

            </div>


        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#acctable').DataTable({});

    });
</script>