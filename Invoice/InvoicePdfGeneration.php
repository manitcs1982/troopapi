<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/config.php';

ini_set('max_input_vars','10000' );
error_reporting(~E_NOTICE && ~E_WARNING);

//$data = json_decode(file_get_contents("php://input")); //Recieving input data


$url = $apiRootPath.'GetServiceDetailsByServiceId.php?serviceId='.$_GET['serviceId'];		
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET',		        
    ),
);			
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$service = json_decode($result);
//print_r($service);
$html = '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Oncefyxd</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

            #logo img {
                /*width: 90px;*/
            }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

            #project span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
            }

        #company {
            float: right;
            text-align: right;
        }

            #project div,
            #company div {
                white-space: nowrap;
            }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
           
        }

            table tr:nth-child(2n-1) td {
                background: #F5F5F5;
            }

            table th,
            table td {
                text-align: center;
            }

            table th {
                padding: 5px 20px;
                color: #5D6975;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;
                font-weight: normal;
            }

            table .service,
            table .desc {
                text-align: left;
            }

            table td {
                padding: 20px;
                text-align: right;
            }

                table td.service,
                table td.desc {
                    vertical-align: top;
                }

                table td.unit,
                table td.qty,
                table td.total {
                    font-size: 1.2em;
                }

                table td.grand {
                    border-top: 1px solid #5D6975;
                    ;
                }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
        
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img style="width: 90px;" src="../images/ic_launcher_round.png">
      </div>
      <h1>#'.$service[0]->referenceId.'</h1>
        <table>
            <tr>
                <td style="width: 300px; padding: 0px; vertical-align: top ">
                <table id="rows">
                        <tr>
                            <td style="vertical-align: top;">
                            	<table>
                            		<tr><td style="height: 30px;">PRODUCT</td></tr>';
                            		
                            		foreach($service[0]->serviceItems as $items){
	                            		$html = $html.'<tr><td style="height: 30px;">'.$items->name.'</td></tr>';
                            		}
		                           	
		                           	$html = $html.'</table>	                            
	                        </td>
                            <td style="vertical-align: top;">
                            	<table>
                            		<tr><td  style="height: 30px;">'.$service[0]->productDetails->name.'</td></tr>';
                            		
                            		foreach($service[0]->serviceItems as $items){
	                            		$html = $html.'<tr><td style="height: 30px;">'.$items->optionAnswer.'</td></tr>';
                            		}
		                           	
		                           	$html = $html.'</table>                            	
                            </td>
                        </tr>                      
                    </table>
                    
                    
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="vertical-align: top;width: 300px;">
                	<p>HELPDESK ADDRESS:</p>
                    <p>Oncefyxd office, Adyar, Chennai - 600 020</p>
                           
                </td>
            </tr>
        </table>      
    </header>
    <main>
      <table>
        <thead>
          <tr>            
            <th class="desc">NAME</th>
            <th>PRICE</th>
            <th>QTY * PRICE (Inc GST)</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>';
        
  foreach($service[0]->DefectsList as $defect){
			
		
          $html= $html . '<tr>            
            <td class="desc">'.$defect->imageDescription.'</td>
            <td class="unit">₹'.($defect->customerPrice/$defect->quantity).'</td>
            <td class="qty">'.$defect->quantity.' * ₹'.($defect->customerDisplayPrice/$defect->quantity).'</td>
            <td class="total">₹'.$defect->customerDisplayPrice.'</td>
          </tr>
          ';
	}
	
        $html = $html.'<tr>
            <td colspan="3">DELIVERY CHARGE</td>
            <td class="total">₹'.$service[0]->deliveryFee.'</td>
          </tr>
          <tr>
            <td colspan="3" class="grand total">GRAND TOTAL</td>
            <td class="grand total">₹'.$service[0]->customerGrandTotal.'</td>
          </tr>
        </tbody>
      </table>     
    </main>
    <footer>
      For more details contact customer care: 96772 36909
    </footer>
  </body>
</html>';

require_once '../libs/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([ 'mode' => 'utf-8','setAutoTopMargin' => 'stretch','autoMarginPadding' => 2, 'format' => 'A4-P']);

$mpdf->use_kwt = true;  

//$mpdf->SetHTMLHeader($data->header);
// Set a simple Footer including the page number
//$mpdf->setFooter('{PAGENO}');	

$mpdf->setAutoBottomMargin = 'stretch';

//echo $html;
$mpdf->WriteHTML($html);

$pdffile = 'PDF/'.$_GET['fileName'].'.pdf';

$mpdf->Output($pdffile);

//echo $html;

echo '{"pdfPath" : "'.$invoicePdfPath.$_GET['fileName'].'.pdf"}';


 ?>
