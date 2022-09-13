<?php
include_once '../Config/config.php';
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
                width: 90px;
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
        <img src="logo.png">
      </div>
      <h1>#SROFMG02021040</h1>
        <table>
            <tr>
                <td style="width: 300px; padding: 0px; vertical-align: top ">
                <table>
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
                <td style="vertical-align: top;">
                	<p>SHIPPING ADDRESS:</p>
                    <p>1, Rajiv Gandhi IT Expy, Phase 1, Vikram Sarabhai Instronics Estate, Thiruvanmiyur, Chennai, Tamil Nadu 600041, India</p>
                    <p>(602) 519-0450</p>                    
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
            <td colspan="3">DELIVERY FEE</td>
            <td class="total">₹'.$service[0]->deliveryFee.'</td>
          </tr>
          <tr>
            <td colspan="3" class="grand total">GRAND TOTAL</td>
            <td class="grand total">₹'.$service[0]->customerGrandTotal.'</td>
          </tr>
        </tbody>
      </table>
      <!--<div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>-->
    </main>
    <footer>
      For more details contact customer care: 96772 36909
    </footer>
  </body>
</html>';

echo $html;
?>