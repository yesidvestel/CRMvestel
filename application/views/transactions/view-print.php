<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Trans #<?php echo $trans['id'] ?></title>

    <style>

        @page { sheet-size: 220mm 110mm; }

        h1.bigsection {
            page-break-before: always;
            page: bigger;
        }

        table td {
            padding: 10pt;
        }


    </style>

</head>
<body style="font-family: Helvetica;">

<h5><?php echo $this->lang->line('Transaction Details') . ' ID : '  .prefix(5) . $trans['id'] ?></h5>
<hr>
<table>
    <?php echo'<tr><td>' . $this->lang->line('Date') . ' : ' . dateformat($trans['date']) . '</td><td>Transaction ID : '  .prefix(5) . $trans['id'] . '</td><td> ' . $this->lang->line('Category') . ' : ' . $trans['cat'] . '</td></tr>'; ?>
</table>

    <hr>
<table>
    <tr><td><?php echo '<strong>' . $this->config->item('ctitle') . '</strong><br>' .
                $this->config->item('address') . '<br>' . $this->config->item('address2') . '<br>' . $this->lang->line('Phone') . ': ' . $this->config->item('phone') . '<br> ' . $this->lang->line('Email') . ': ' . $this->config->item('email'); ?></td><td> <?php echo '<strong>' . $trans['payer'] . '</strong><br>' .
                $cdata['address'] . '<br>' . $cdata['city'] . '<br>' . $this->lang->line('Phone') . ': ' . $cdata['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $cdata['email']; ?></td><td> <?php echo '<div class="col-xs-6 col-sm-6 col-md-6">
                    <p>' . $this->lang->line('Debit') . ' : ' . amountFormat($trans['debit']) . ' </p><p>' . $this->lang->line('Credit') . ' : ' . amountFormat($trans['credit']) . ' </p><p>' . $this->lang->line('Type') . ' : ' . $trans['type'] . '</p>'; ?></td></tr>
</table>
<?php echo '<p>' . $this->lang->line('Note') . ' : ' . $trans['note'] . '</p>'; ?>
</body>