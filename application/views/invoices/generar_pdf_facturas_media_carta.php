<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facturas ,<?=$sede." - ".$fecha ?> </title>
    <style type="text/css">
        

         h6{
            padding-top: -27px;
            font-size: 13px;
        }
        #t-titulo{
            /*border: 1px solid;*/
            text-align:center;
        }

        #tabla_contenido{
            border: 3px solid #00016a;
            width: 100%;
            vertical-align: text-top;
            height: 487px;
            border-radius: 10%;
            padding-left: 50px;
            padding-right: 50px;
        }

        small{
            font-size: 9px;
        }
        /* parte cabezal */
        #logo{
            width: 100px;
            padding-top: 10px;
        }
        #saludo{
            border: 1px solid #000; 
            border-radius: 10%;
            width: 73%;
            float: left;
            padding-left: 25px;
            
        }
        #logo-div{            
            text-align: right;
            width: 20%;
            float: left;
            
        }

        #td_tid{
            padding-top: 10px;
            width: 100%;
        }
        
        /* end parte cabezal */
        /* cuerpo facturas */
        .plist tr td {
            line-height: 12pt;
        }
        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;
            text-align: center;

        }
        .mfill {
            background-color: #eee;
        }

         table tr.item td{
            border: 1px solid #ddd;
            text-align: center;
        }
        /* end cuerpo facturas */
        /*Totales factura*/

         .subtotal tr td {
            line-height: 3pt;
            padding: 3pt;
            font-size: 9px;
        }

        .subtotal tr td {          
            border: 1px solid #ddd;
        }
        .myco2 {
            width: 300pt;
        }
        /*end Totales factura*/
        
        .datos_empresa{
            text-align: center;
            font-size: 10px;
            width: 100%;
            
        }
           .sts-Cortado
            {
             color: #A4282A;
            }
            .sts-Suspendido
            {
             color: #2224A3;
            }

            .st-Activo, .st-Instalar , .st-Cortado, .st-Suspendido, .st-Exonerado, .st-Compromiso, .st-Cartera
{
    text-transform: uppercase;
    color: #fff;
    padding: 4px;
    /*border-radius: 11px;*/
    
}
.st-Activo
{
 background-color: #4EAA28;
}
.st-Instalar
{
 background-color: #A49F20;
}
.st-Cortado
{
 background-color: #A4282A;
}

.st-Suspendido
{
 background-color: #2224A3;
}
.sts-Suspendido
{
 color: #2224A3;
}
.st-Exonerado
{
 background-color: #24A9AB;
}
.st-Compromiso
{
 background-color: #8B6390;
}
.st-Cartera
{
 background-color: #808000 ;
}

.tbs-servs{
    font-size: 8px;
}
    </style>
</head>
<body >
    <?php  ?>
    <table id="t-titulo" width="100%"  align="center" >
        <tbody>
            <tr>
                
                <td><img  src="<?=base_url()."userfiles/company/165334292264357072.png"  ?>"></td>
            </tr>
            <tr>
                <td><h1 >Facturas  </h1>
                <h3 > <?=$sede." - ".$fecha  ?></h3>
                </td>
            </tr>
        </tbody>
    </table>
    

    <hr>
    <pagebreak>
    <?php ?>
    
    <?php foreach ($lista as $keyc => $custmr) { 
        $sub_total=0;
        $tax_total=0;
        $factura = $this->customers->servicios_detail($custmr['id']);
       
        $phoneNumber = $custmr['celular'];
        $c1="";
        if(  strlen($phoneNumber)==10 )
        {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);
            $phoneNumber =  $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
            $c1=" - ";
        }else{
            $phoneNumber="";
        }
        $phoneNumber2=$custmr['celular2'];
        if(  strlen($phoneNumber2)==10 )
        {
            $areaCode = substr($phoneNumber2, 0, 3);
            $nextThree = substr($phoneNumber2, 3, 3);
            $lastFour = substr($phoneNumber2, 6, 4);
            
            $phoneNumber2 = $c1.$phoneNumber2 = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
        }else{
            $phoneNumber2="";
        }

?>
    
<div id="tabla_contenido" >
    
                
<!-- Inicio Factura-->
    <!-- Encabezado-->
        <div id="td_tid"><small><?= "#".$factura['tid'] ?></small></div>
     
        <div id="saludo"  ><h4>Sr(a) <?=$custmr['name']." ".$custmr['dosnombre']." ".$custmr['unoapellido']." ".$custmr['dosapellido'] ?></h4>
            <h6><?= strtoupper( $custmr['tipo_documento']." : ".number_format($custmr['documento'],0,",",".")) ?></h6>
            <h6>Direccion : <?= $custmr['nomenclatura'] . ' ' . $custmr['numero1'] . $custmr['adicionauno'].' Nº '.$custmr['numero2'].$custmr['adicional2'].' - '.$custmr['numero3'].", ".$sede; ?></h6>
            <h6>Telefono : <?= $phoneNumber.$phoneNumber2 ?></h6>
            <h6 style="line-height:10px;font-size: 8px;padding-top: -23px;">Resive un cordial saludo de parte de <?=$company->cname ?>, a continuacion te presentamos el documento de cobro de los servicios del hogar.</h6>
        </div>
        <div id="logo-div"> <img id="logo" src="<?=base_url()."userfiles/company/".$company->logo  ?>"></div>
    <!-- Encabezado-->
    <br>
    <!--Cuerpo Facturas-->
    <?php $data=$this->clientgroup->get_datos_customer_pdf($custmr['id']); 
        foreach ($data as $key2 => $value2) {
            ${$key2}=$value2;
        }
    ?>
<?php  ?>
        <table class="plist" cellpadding="0" cellspacing="0" width="100%">


        <tr class="heading">
             <td>
               #
            </td>
            <td>
                Factura
            </td>
            <td>
                Items
            </td>
            <td>
                <?php echo $this->lang->line('Price') ?>
            </td>
           

            <?php  echo '<td>' . $this->lang->line('Tax') . '</td>';

             ?>
            <td class="t_center">
                <?php echo $this->lang->line('SubTotal') ?>
            </td>
        </tr>

        <?php
        $fill = true;
        $sub_t=0;
        $c=1;
      $mostrar=true;
        if(count($products)==1 && isset($facturas_adelantadas) && count($facturas_adelantadas)>0){
            $query1=$this->db->query("select count(*) as conteo from transactions where tid='".$products[0]['tid']."' and estado is null")->result();    
            if($query1[0]->conteo>=2){
                $mostrar=false;
            }
        }
        setlocale(LC_TIME, "spanish");
        foreach ($products as $row) {

            $cols = 3;
            
            if ($fill == true) {
                $flag = ' mfill';               
            } else {
                $flag = '';
            }
            $sub_t+=$row['price']*$row['qty'];
            
//codigo x

    $sub_t += $row['total'];
    
       /*if($servicios_asignados!=""){
            $servicios_asignados="<thead><tr><th class='tbs-servs'>Prod</th><th class='tbs-servs'>Cant.</th> <th class='tbs-servs'>Iva</th><th class='tbs-servs'>Sub.</th> <th class='tbs-servs'>Total.</th></tr></thead><tbody>".$servicios_asignados."</tbody>";
       }*/
        $f1 = date(" F ",strtotime($row['invoicedate']));
        $transacciones_factura=array();
        if($total_customer<0){                                                    
            $transacciones_factura=$this->db->query("select sum(credit-debit) as total_pagado from transactions where tid=".$row['tid']." and estado is null and id!=".$tr_saldo_adelantado['id'])->result_array();                                                    
        }else{
            $transacciones_factura=$this->db->query("select sum(credit-debit) as total_pagado from transactions where tid=".$row['tid']." and estado is null")->result_array();                                                                                                        
        }
        
        if(isset($transacciones_factura[0]['total_pagado']) && $transacciones_factura[0]['total_pagado']>0){
                    $porcentaje=($transacciones_factura[0]['total_pagado']*100)/$row['total'];
                    $row['total']-=$transacciones_factura[0]['total_pagado'];
                    $row['subtotal']=$row['subtotal']-(($row['subtotal']*$porcentaje)/100);
                    $row['tax']=$row['tax']-(($row['tax']*$porcentaje)/100);   
                    if($row['subtotal']==$row['total']){
                        $row['subtotal']-=$row['tax'];    
                    } 
        }
        
        $sub_total+=$row['subtotal'];
        $tax_total+=$row['tax'];

$servicios_asignados="";
 
        $list_items= $this->db->get_where("invoice_items",array("tid"=>$row['tid']))->result_array();

        $fac1=$this->db->get_where('invoices',array("tid"=>$row['tid']))->row();

        
        $prs=-10;
        if($fac1->pamnt<$fac1->total && $fac1->pamnt>1){
            $restante=$fac1->total-$fac1->pamnt;
            $prs=($restante*100)/$fac1->total;
        }
       foreach ($list_items as $key => $value) {
        $servicios_asignados.=$value['product'];
        if($prs!=-10){

            $value['price']=($value['price']*$prs)/100;
            $value['totaltax']=($value['totaltax']*$prs)/100;
        }
        if($value['totaltax']!=0){
           
           if($value['qty']>1){
                $servicios_asignados.=": (iva{".round($value['totaltax'])."}+".round($value['price']).")*".$value['qty']; 
           }else{
                $servicios_asignados.=": iva{".round($value['totaltax'])."}+".round($value['price']); 
           }
        }else{
            if($value['qty']>1){
                $servicios_asignados.=": subtotal{".round($value['price'])."}*".$value['qty']; 
            }
        }
        if($value['qty']>1){
            $value['subtotal']=($value['price']+$value['totaltax'])*$value['qty'];
        }else{
            $value['subtotal']=$value['price']+$value['totaltax'];
        }
        $servicios_asignados.=" = ".amountFormat($value['subtotal']);           
            //$servicios_asignados.="<tr ><td class='tbs-servs'>".$value['product']."</td><td class='tbs-servs'>".$value['qty']."</td><td class='tbs-servs'>".$value['totaltax']."</td><td class='tbs-servs'>".$value['price']."</td><td class='tbs-servs'>".$value['subtotal']."</td>";
           if($key<(count($list_items)-1)){
            $servicios_asignados.="<br >";
           }
       }
// end codigo x

if($mostrar){
            echo '<tr class="item' . $flag . '"> <td>'.$c.'</td>
                            <td>' . ucfirst(strftime("%B", strtotime($f1))).' CTA : ' . $row['tid'] . '</td>
                            <td ><small> ' . $servicios_asignados.'</small></td>
                            <td style="width:12%;">' . amountExchange($row['subtotal']) . '</td>
                            ';
             $cols++; echo '<td style="width:16%;">' . amountExchange($row['tax']) . ' </td>';
            
            echo '<td class="t_center">' . amountExchange($row['total']) . '</td>
                        </tr>';
           
            $fill = !$fill;
            $c++;
          }
        }

  if(isset($facturas_adelantadas)){
                                        foreach ($facturas_adelantadas as $key => $value) {

                                            $cols = 3;
            
            if ($fill == true) {
                $flag = ' mfill';               
            } else {
                $flag = '';
            }
            echo '<tr class="item' . $flag . '"> <td>'.$c.'</td>
                            <td>' . ucfirst($value['mes']) . '</td>
                            <td></td>
                            <td style="width:12%;">' . amountFormat($value['valor_a_colocar'])  . '</td>
                            ';
            $cols++; echo '<td style="width:16%;">' . amountExchange(0) . ' </td>'; 
            
            echo '<td class="t_center">' . amountFormat($value['valor_a_colocar'])  . '</td>
                        </tr>';
           
            $fill = !$fill;
            $c++;



                                             
                                        }
                                    }

        ?>


    </table>
<?php  ?>
    <!-- ENd Cuerpo Facturas-->
    <!-- totales Factura-->
 <br>
    <?php $estado_de_user="Cancelado"; 
if(($sub_total+$tax_total)>0){
    $estado_de_user="Debe";
}
if($total_customer==0){
    $estado_de_user="Cancelado";   
}else if($total_customer<0){
    $estado_de_user="Pago Adelantado";
    $sub_total=0;
    $tax_total=0;
} 
if($factura['estado']=="Activo"){
    $fa=$this->db->get_where("invoices",array("tid"=>$factura['tid']))->row();
    $servs_eco=""; 
        if ($fa->television == "no" ){
            $servs_eco.= '';
        } else{
                if($fa->estado_tv == "Cortado"){
                        $servs_eco.= "<b><i class='sts-Cortado'>Tv (cortada)</i></b>";
                }else if($fa->estado_tv == "Suspendido"){
                        $servs_eco.= "<b><i class='sts-Suspendido'>Tv (suspendida)</i></b>";
                }else{
                    //$servs_eco.= $fa->television;    
                }
            }
    if ($fa->combo == "no" ){
            $servs_eco.= '';
        } else{

             if($fa->estado_combo == "Cortado"){
                        $servs_eco.= " <b><i class='sts-Cortado'>Internet (cortado)</i></b>";
                }else if($fa->estado_combo == "Suspendido"){
                        $servs_eco.= " <b><i class='sts-Suspendido'>Internet (suspendido)</i></b>";
                }else{
                    //$servs_eco.= ' mas '.$fa->combo;
                }
            }

    //$servs_eco=$servs_eco;
}else{
$servs_eco="<span class='st-".$factura['estado']."'>".$factura['estado']."<span>";
}

if($servs_eco!=""){
    $servs_eco=", ".$servs_eco;
}
?>
    <table class="subtotal" width="100%">

       
        <tr>
            <td class="myco2" rowspan="<?php echo $cols ?>"><br><br><br>
                <p><?php echo '<strong>' . $this->lang->line('Status') . ': ' . ucwords($estado_de_user).' '.$servs_eco.'</strong></p>'; ?>
            </td>
            <td colspan="2" style="text-align:center;"><strong><?php echo $this->lang->line('Summary') ?></strong></td>
            


        </tr>
        <tr class="f_summary">


            <td><?php echo $this->lang->line('SubTotal') ?>:</td>

            <td><?php echo amountExchange($sub_total); ?></td>
        </tr>
        <?php 
            echo '<tr>        

            <td>' . $this->lang->line('Total Tax') . ' :</td>

            <td>' . amountExchange($tax_total) . '</td>
        </tr>';
        
        
            echo '<tr>


            <td> Total:</td>

            <td>' . amountExchange($sub_total+$tax_total) . '</td>
        </tr>';

        

        
        ?>
        <tr>


            <td><?php echo $this->lang->line('Balance Due') ?>:</td>

            <td colspan="2" align="center"><strong><?php
     $rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming < 0) {
        $rming = 0;

    }
    $x=$sub_total+$tax_total;
    if($total_customer<0){
        $x=$total_customer;
    }
    echo amountExchange($x);
    echo '</strong></td>
        </tr>
        </table>
        ';
        
        
?>

                        <!-- end totales Factura-->
                        <!-- foter factura-->
                        <div class="datos_empresa" >
                            <p class="p_datos_empresa">
                                <?=$company->cname.", Nit: ".$company->taxid." - Telefono : ".$sede_var->telefono." - Dir : ".$sede_var->direccion.", Sede ".$sede ?>
                            </p>
                        </div>
<!-- Fin Factura-->


    
</div>

    <?php if($keyc%2==0){echo "<br>";}  } ?>
    
  
</body>
</html>