<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Facturas Generadas,<?=$sede." - ".$fecha ?> </title>
    <style type="text/css">
        #clientes td{
            text-align: center;
            /*border-bottom: 2px solid #111;*/
            color: #333;
            font-size: 9px;
            padding: 1px;
            border-bottom: 1px solid #e3ebf3;

        }
       #clientes th{
            background: #555;color: #fff;
            text-transform: uppercase;
            text-align: center;
            font-size: 14px;
            padding: 10px;
        }
        #clientes{
            border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;
            
        }
        .tdcoloreada{
            padding: 0.75px 1px;
            border-bottom: 1px solid #e3ebf3;
            color: #333;font-size: 9px;background-color: rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        h3{
            padding-top: -15px;
        }
        #logo{
            
            width: 50px;
            
        }
        #t-titulo{
            border: 1px solid;
        }

    </style>
</head>
<body >
    <table id="t-titulo" width="100%">
        <tbody>
            <tr>
                <td><h2 > <?=$sede." - ".$fecha  ?></h2></td>
                <td rowspan="2"><img id="logo" src="<?=base_url()."userfiles/company/165334292264357072.png"  ?>"></td>
            </tr>
            <tr>
                <td><h3 >Reporte Facturas Generadas </h3></td>
            </tr>
        </tbody>
    </table>
    
    
    

      <hr>
    </table>
    <table align="center" id="clientes">
        <thead>
            <tr class="titulo">
                <th>#</th>
                <th>ID</th>
                <th>Nombre</th>
                <th>documento</th>
                <th>celular</th>
                <th>TID Factura</th>
                <th>Servicios</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista as $key => $value) {
                if($key%2==0){
                    $colorear="";
                }else{
                    $colorear="class='tdcoloreada'";
                }
            ?>
                <tr >
                    <td <?=$colorear?>> <?=$key+1  ?></td>
                    <td <?=$colorear?>><?=$value['id'] ?></td>
                    <td <?=$colorear?>><?=utf8_encode($value['name']." ".$value['apellido']) ?></td>
                    <td <?=$colorear?>><?=number_format($value['documento'],0,",",".") ?></td>
                    <?php 
                            $phoneNumber = $value['celular'];

                            if(  strlen($phoneNumber)==10 )
                            {
                                $areaCode = substr($phoneNumber, 0, 3);
                                $nextThree = substr($phoneNumber, 3, 3);
                                $lastFour = substr($phoneNumber, 6, 4);
                                $result =  $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
                            }else{
                                $result=$value['celular'];
                            }

                            $servs="";
                            if($value['television']!="no" && $value['television']!="" && $value['television']!="-"){
                                $servs="Tv";
                                if($value['combo']!="no" && $value['combo']!="" && $value['combo']!="-"){
                                    $servs.="+".$value['combo'];
                                
                                }
                            }else{
                                $servs=$value['combo'];
                            }
                     ?>
                    <td <?=$colorear?>><?=$result ?></td>
                    <td <?=$colorear?>><?=$value['tid'] ?></td>
                    <td <?=$colorear?>><?=$servs ?></td>
                    <td <?=$colorear?>><?="$ ".number_format($value['total'],0,",",".") ?></td>
                    
                </tr>
            <?php } ?>
            
        </tbody>
    </table>
  
</body>
</html>