<?php
//print_r($balances);
?>
<style type="text/css">
    .mon_invoice
    {
        float: left;
        width: 980px;
        background-color: #ffffff;
        color: #000000;
        min-height: 500px;
    }
    .mon_header
    {
        width: 980px;
        height: 44px;
    }
    .mon_header h2
    {
        float: left;
        margin-left: 20px;
    }
    .mon_header > div {
        float: right;
        font-size: 17px;
        margin-right: 20px;
        margin-top: 20px;
    }
    table {
        width: 100%;
    }
    .first td {
        border-bottom: 1px solid;
        font-size: 15px;
        font-weight: bold;
        padding-left: 18px;
    }
    .first1 td {
        font-size: 15px;
        font-weight: bold;
        padding-left: 18px;
        padding-top: 11px;
    }
</style>

<div style="background-color: white;color:black;font-size:12px;width:66%;margin:0% auto;text-align: center;" id="balanceout">
    <h2 style="width:100%;text-align:left;padding-top:15px;">B.T.W Dive Service  <?php //echo $from.'<br>'.$to;                   ?></h2>
    <h4 style="border:none;text-align: right;width:100%;"><?php echo date("m/d/Y") ?> &nbsp;&nbsp;&nbsp;&nbsp;</h4>
    <table>
        <tr class="first">
            <td style="width: 20%;">Month</td>
            <td style="width: 20%;">Class</td>
            <td style="width: 20%;text-align:center;">List Price</td>
            <td style="width: 20%;text-align:center;">Net Price</td>
            <td style="width: 20%;text-align:center;">Payments</td>
        </tr>
<?php
        $k="";
        $mon_list=0; 
        $mon_net = 0 ;
        $grandList=0;
        $grandNet=0;
        $grandPayment=0;
        if(empty($balances) )
        {
           // exit;
        }
 else {
      
// print_r($amountrecd);
         $i=0;
     //print $val2->amt;

 //  exit;
        foreach($balances as $key => $val)
        {         
         //  echo $val->month ;
            if($k != $val->month ){ 
                
                if($k != "") 
                {
                 //   $k=$val->month;
                   echo "<tr><td></td><th style='text-align:left'>Total For: $k</th><th style='text-align:right' >".$mon_list."</th><th style='text-align:right'>".$mon_net."</th><th style='text-align:right'>".$amountrecd[$i]->amt."</th></tr>";
                   $grandPayment=$grandPayment+$amountrecd[$i]->amt;
                   $i++;
                }
                
                $mon_list=0; $mon_net = 0 ;
                echo "<tr><td><b>$val->month</b></td><td></td><td></td><td></td><td></td></tr>";
                $k= $val->month ;
            }
            echo "<tr><td></td><td style='text-align:left'><b>".$val->Class."</b></td><td style='text-align:right'>".$val->list_price."</td><td style='text-align:right'>".$val->net_amnt."</td><td></td></tr>";
            
            $mon_list += $val->list_price ; 
            $mon_net += $val->net_amnt;
            $grandList+=$val->list_price;
       $grandNet+=$val->net_amnt;
//          
            
             
        }
        echo "<tr><td></td><th style='text-align:left'>Total For: $k</th><th  style='text-align:right'>".$mon_list."</th><th  style='text-align:right'>".$mon_net."</th><th style='text-align:right'>".$amountrecd[$i]->amt."</th></tr>";
$grandPayment=$grandPayment+$amountrecd[$i]->amt;     
        
//  $grandList+=$mon_list;
      //  $grandNet+=$mon_net;
        ?>
        <tr>
            <th><u>Grand Total</u></th>
            <td></td>
            <th  style='text-align:right'><?php echo $grandList; ?></th>
            <th  style='text-align:right'><?php echo $grandNet; ?></th>
            <th  style='text-align:right'><?php echo $grandPayment; ?></th>
            </tr>

    
      <?php  
 }    
        ?>

    </table>
</div>
