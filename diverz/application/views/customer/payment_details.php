<style type="text/css">
	.redmark {
	color: #F00;
}
 .bill tr:nth-child(even){
  background-color:#ffffff;
  color:#000000;		
        }
      .bill tr:nth-child(odd){
  background-color:#E5E5E5;
  color:#000000;		
        }
         .pay tr:nth-child(even){
  background-color:#ffffff;
  color:#000000;		
        }
      .pay tr:nth-child(odd){
  background-color:#E5E5E5;
  color:#000000;		
        }
    </style>
 <script type="text/javascript">
$(function() {
	$( "#current_pay_date" ).datepicker();
	//$( "#current_pay_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	});
$(function() {	
$( "#check_date" ).datepicker();
//$( "#check_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});
function paymentSave()
{
     var amt=$("#payment_amount").val();
   if((amt=="")||(amt==0)||(amt<0)||(isNaN(amt)))
   {
       alert("Cannot enter Blank or Zero data");
   }
   else
   {
$.ajax({url:"/btwdive/index.php/customer/savePayment/",
		type:"post",
		data:{
		tran_date:$("#current_pay_date").val(),
                invoiceno:$("#invoice_no").val(),
                custid:$("#custid").val(),
                check_no:$("#check_no").val(),
                check_date:$("#check_date").val(),
                credit:$("#payment_amount").val(),
                notes:$("#comments").val(),
                       
			},
			success:function(result){alert("Payment Details Updated");
                            self.close();
			//location.reload();
			}
		});
           
}
}
function deletePayment(id)
{
    //alert(id);
    var pk_ledger=id;
var r = confirm("Are you sure you want to Delete this Credit Amount");
		if(!r){
			exit;
			}
			delete_payment(pk_ledger);
	       alert("Data Deleted!");
	        location.reload();
          
            }
            
 function delete_payment(pk_ledger)
 {
 $.ajax({url:"/btwdive/index.php/customer/deleteCreditPayment/",
			type:"post",
			 data: {
				 	ledger_id:pk_ledger,
				 	
			 },
			 success:function(result){
				//	alert(result);
					}
	  });    
 }
        </script>                

	
        
        
        </script>
       
<h2 style="width:100%;text-align: center;">Form To Enter Payment Details</h2>	
 <table width="90%" border="0">
  <tr>
    <td width="20%" rowspan="2">Client</td>
    <td width="17%" rowspan="2"><?php foreach ($customers as $customer): echo $customer->first_name;echo " ".$customer->last_name; endforeach;?></td>
    <td width="25%" rowspan="2">Invoice No</td>
    <td width="38%"><?php if($inv=='C')
    {
    	echo "";
    }else
    {
    	echo $inv; 
    }
    ?><input type="hidden" value="<?php echo $inv; ?>" id="invoice_no"><input type="hidden" value="<?php foreach ($customers as $customer): echo $customer->pk_customer;endforeach;?>" id="custid"></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Billing Details</td>
    <td>&nbsp;</td>
    <td>Payment details</td>
    <td class="redmark">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div style="width:500px;height:150px;overflow-y: scroll; background-color:#FFFFFF">
            <table width="100%" class="bill"><?php  
            $i=0;
            $amt_billed=0;
            foreach ($billing as $billings): 
                
                     
                    
                
?>
           
					<tr style="cursor: pointer;">
                                        <td width="25%"><?php echo $billings->wo_number;?></td>
					<td width="25%"><?php echo $billings->wo_class;?></td>
			
                                        <td width="50%"><?php 
                                        if($billings->wo_number=='C/F')
                                        {
                                        	echo $billings->schedule_date;
                                        	$amt_billed= $amt_billed+$billings->schedule_date;
                                        }
                                        else
                                        {
                   echo $disc[$i][0]->discamt;
                   $amt_billed= $amt_billed+$disc[$i][0]->discamt;
//                   $tst=$disc[0][0];
                   
//                             foreach ($disc as $d):   
//                 foreach ($d as $p):
//                                        echo $p->discamt;
//                             endforeach;endforeach;
                                        }
                                        ?></td>
					</tr>
					<?php 
                                        $i++;
                                        endforeach;   
                                   
                                        ?>	
        </table>
                     </div></td>
    <td colspan="2">
    <div  style="width:500px;height:150px;overflow-y: scroll; background-color:#FFFFFF">
	<table width="100%" class="pay"><?php $amt_recd=0; foreach ($payment as $payments):$amt_recd=$amt_recd+$payments->credit;?>
					<tr style="cursor: pointer;" onclick="deletePayment('<?= $payments->pk_ledger ?>')">
					<td width="25%"><font color="#00000"><?php echo $payments->check_no;?></td>
					<td width="25%"><font color="#00000"><?php echo $payments->check_date;?></td></td>
					<td width="50%"><font color="#00000"><?php echo $payments->credit;?></td></td>
					</tr>
					<?php endforeach; ?>	
        </table>
                     </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Amount Billed</td>
    <td><input  type="text" style="text-align:right;background-color:#E5E5E5;" id="amountbilled" width="30" readonly value="<?php echo $amt_billed; ?>"/></td>
    <td>Amount Recieved</td>
    <td><input type="text" name="" value="<?php echo $amt_recd; ?>" id="amount_recieved" class="textbox" style="width: auto;text-align:right;background-color:#E5E5E5;" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Balance Due</td>
    <td><input type="text" name=""  id="balance_due" class="textbox" style="width: auto;text-align:right;background-color:#E5E5E5;" value="<?php
   // echo $amt_recd;
  //  echo $amt_billed;
    bcscale(2);
   $bal= bcsub($amt_billed, $amt_recd);
        //       $bal=($amt_billed)-($amt_recd);
              echo $bal;
               ?>"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Current Payment Amount</td>
    <td><input type="text" name="" value="" id="payment_amount" class="textbox" style="width: auto;text-align:right;" /></td>
    <td>Current Payment Date</td>
    <td><input type="text" name=""
				value="<?php echo date("m/d/Y")?>" id="current_pay_date" class="textbox"
				style="width: auto;" /></td>
  </tr>
  <tr>
    <td>Check No</td>
    <td><input type="text" name="" value="" id="check_no" class="textbox" style="width: auto" /></td>
    <td>Check Date</td>
    <td><input type="text" name=""
				value="<?php echo date("m/d/Y")?>" id="check_date" class="textbox"
				style="width: auto" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Comments</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2"><textarea id="comments" rows="10" cols="250"> </textarea></td>
   
    
  </tr>
  <tr>
      <td><button class="btn" id="savebtn" onclick="paymentSave()">Save</button></td>
    <td><button class="btn" onclick="self.close()">Exit</button></td>
  </tr>
</table>
