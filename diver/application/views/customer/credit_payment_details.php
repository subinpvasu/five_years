<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<link rel="stylesheet"
      href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="../../../jquery/calender.js"></script>
<script src="../../jquery/calender.js"></script>
<link rel="stylesheet" href="../../../css/style.css" />
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

window.onunload=function(){
	
	 
		//window.opener.document.getElementById("win<?php echo $cid; ?>").value=0;
	window.opener.changeWindowStatus(<?php echo $cid; ?>);
		
}
    $(function() {
        $("#current_pay_date").datepicker();
     //   $("#current_pay_date").datepicker("option", "dateFormat", "yy-mm-dd");
    });
    $(function() {
        $("#check_date").datepicker();
      //  $("#check_date").datepicker("option", "dateFormat", "yy-mm-dd");
    });
    function paymentSave()
    {
        var amt = $("#payment_amount").val();
        if ((amt == "") ||(amt == 0)|| (amt < 0)||(isNaN(amt)))
        {
            alert("Cannot enter Blank or Zero data");
        }
        else
        {
            $.ajax({url: "/btwdive/index.php/customer/saveCreditPayment/",
                type: "post",
                data: {
                    repair:$("#repair").val(),
                    tran_date: $("#current_pay_date").val(),
                    custid: $("#custid").val(),
                    check_no: $("#check_no").val(),
                    check_date: $("#check_date").val(),
                    credit: $("#payment_amount").val(),
                    notes: $("#comments").val(),
                },
                success: function(result) {
                    alert("Payment Details Updated");
                    self.close();
                    //location.reload();
                }
            });

        }
    }
    function deletePayment(id)
    {
//alert(id);
        var pk_ledger = id;
        var r = confirm("Are you sure you want to Delete this Credit Amount");
        if (!r) {
            exit;
        }
        delete_payment(pk_ledger);
        alert("Data Deleted!");
        location.reload();

    }

    function delete_payment(pk_ledger)
    {
        $.ajax({url: "/btwdive/index.php/customer/deleteCreditPayment/",
            type: "post",
            data: {
                ledger_id: pk_ledger,
            },
            success: function(result) {
                //	alert(result);
            }
        });
    }
</script>
<input type="hidden" id="window_status" value="<?php echo $cid; ?>"/>
<h2 style="width:100%;text-align: center;">Form To Enter Payment Details</h2>	
<table width="90%" border="0">
    <tr>
        <td width="20%" rowspan="2">Client</td>
        <td width="17%" rowspan="2">
        <?php foreach ($cname as $customer): 
        echo $customer->cust_name; endforeach;?>
        <input type="hidden" id="custid" value="<?php echo $cid; ?>"/></td>
        <td width="25%" rowspan="2"></td>
        <td width="38%"></td>
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
                <table width="100%" class="bill">		<?php foreach ($customers as $customer): ?>
                    <tr style="cursor: pointer;">
                        <td width="25%"><?php echo $customer->invno; ?></td>
                        <td width="25%"><?php echo $customer->invdt; ?></td>

                        <td width="50%"><?php echo $customer->billedc; //echo $customer->amount_billed;  ?></td>
                    </tr>
                    <?php endforeach; ?>

                </table>
            </div></td>
        <td colspan="2">
            <div style="width:500px;height:150px;overflow-y: scroll; background-color:#FFFFFF">
                <table width="100%" class="pay">		<?php $amt_recd = 0;
                    foreach ($payment as $payments):$amt_recd = $amt_recd + $payments->credit;
                        ?>
                        <tr style="cursor: pointer;" onclick="deletePayment('<?= $payments->pk_ledger ?>')">
                            <td width="25%"><?php echo $payments->invoice_no; ?></td>

                            <td width="25%"><?php echo $payments->transaction_date; ?></td>

                            <td width="50%"><?php echo $payments->credit; //echo $customer->amount_billed;  ?></td>
                        </tr>
<?php endforeach; ?>

                </table>
            </div></td>
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
        <td><input  type="text" style="text-align:right;background-color:#E5E5E5;" id="amountbilled" width="30" readonly="readonly" value="<?php
                    foreach ($amount as $a):$amt_billed = $a->amount_billed;
                        echo $amt_billed;
                    endforeach;
                    ?>"/></td>
        <td>Amount Recieved</td>
        <td><input type="text" name="" value="<?php echo $amt_recd; ?>" id="amount_recieved" class="textbox" style="width: auto;text-align:right;background-color:#E5E5E5;" readonly="readonly" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Balance Due</td>
        <td><input type="text" name="" value="<?php
            $balance = $amt_billed - $amt_recd;
            $aa = round($balance, 2);
            if ($aa == 0) {

                print '0.00';
            }
            
            else{
               print sprintf("%.2f",$aa);
            }
            ?>" id="balance_due" class="textbox" style="width: auto;text-align:right;background-color:#E5E5E5;" readonly="readonly" /></td>
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
                   value="<?php echo date("m/d/Y") ?>"  readonly="readonly" class="textbox" id="current_pay_date"
                   style="width: auto" /></td>
    </tr>
    <tr>
        <td>Check No</td>
        <td><input type="text" name="" value="" id="check_no" class="textbox" style="width: auto" /></td>
        <td>Check Date</td>
        <td><input type="text" name=""
                   value="<?php echo date("m/d/Y") ?>" class="textbox"
                   style="width: auto"  readonly="readonly" id="check_date"/></td>
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
        <td colspan="2" rowspan="2"><textarea id="comments" style="max-width: 1500px; 
    max-height: 60px;"> </textarea></td>

    </tr>
    <tr>
        <td><button class="btn" id="savebtn" onClick="paymentSave()">Save</button></td>
        <td><button class="btn" onclick="self.close()">Exit</button></td>
    </tr>
</table>
<input type="hidden" id="repair" value="<?php echo $repair;?>"/>
