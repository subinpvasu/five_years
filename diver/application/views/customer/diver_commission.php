<style type="text/css">
    #underlay{
        display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-color:#000;
        -moz-opacity:0.5;
        opacity:.50;
        filter:alpha(opacity=50);
    }
    #lightbox{
    background-color: #000000;
    border: 2px solid #FFFFFF;
    color: #FFFFFF;
    display: none;
    height: 75%;
    left: 30%;
    overflow: auto;
    padding: 16px;
    position: fixed;
    top: 15%;
    width: 45%;
    z-index: 1;
       
    }
</style>
<script type="text/javascript">
    function delete_commission_details()
    {

        $.ajax({url: "/btwdive/index.php/customer/deleteDiverCommission/",
            type: "post",
            data: {
                wo: $("#workOrderNumber").val(),
            },
            success: function(result) {
                //	alert(result);
            }
        });

    }
//Modify Commission Details
    function updateCommission()
    {


        $.ajax({url: "/btwdive/index.php/customer/updateDiverCommission/",
            type: "post",
            data: {
                worknummber: $("#workOrderNumber").val(),
                zinccount: $("#zincCount").val(),
                rate: $("#rate").val(),
                commission: $("#commission").val(),
            },
            success: function(result) {

                if (result > 0)
                {
                    alert("Data Modified.");
                     exitbtn();
                    updateList();
                }
            }
        });
    }
    function popup(wo)
    {
          $.ajax({url: "/btwdive/index.php/customer/displayCommissionDetails/",
                type: "post",
                data: {
                    one: wo

                },
                success: function(result) {
                    //alert(result);


                    var res = result.split("|");

                    $("#vesselName").val(res[0]);
                    $("#location").val(res[1]);
                    $("#workOrderNumber").val(res[2]);
                    $("#wo_date").val(res[3]);
                    $("#listPrice").val(res[4]);
                    $("#discount").val(res[5]);
                    $("#invoiceValue").val(res[6]);
                    $("#zincCount").val(res[7]);
                    $("#rate").val(res[8]);
                    $("#commission").val(res[9]);
                    $("#work_type").html(res[10]);



                }
            });
            //.............................................
  display();
           //setTimeout(display(), 10000);
            

       



    }
    function display()
    {
    	    document.getElementById('lightbox').style.display = 'block';
            document.getElementById('underlay').style.display = 'block';
    }
    function exitbtn()
    {
    	document.getElementById('underlay').style.display = 'none';
        document.getElementById('lightbox').style.display = 'none';
                   $("#vesselName").val('');
                    $("#location").val('');
                    $("#workOrderNumber").val('');
                    $("#wo_date").val('');
                    $("#listPrice").val('');
                    $("#discount").val('');
                    $("#invoiceValue").val('');
                    $("#zincCount").val('');
                    $("#rate").val('');
                    $("#commission").val('');
                    $("#work_type").html('');
                    
    }
</script>
<script>
    $(function() {
        $("#fromdate").datepicker();
        //$("#fromdate").datepicker("option", "dateFormat", "yy-mm-dd");
    });
    $(function() {
        $("#todate").datepicker();
        //$("#todate").datepicker("option", "dateFormat", "yy-mm-dd");
    });
    $(function() {
        $("#checkdate").datepicker();
        //$("#checkdate").datepicker("option", "dateFormat", "yy-mm-dd");
    });

    function listInvoices()
    {
        document.getElementById('light2').style.display = 'block';
        document.getElementById('fade2').style.display = 'block';
        //alert("Under Construction.");
    }
    function updateList()
    {
        if($("#diver").val()!='')
        {
           
        
        $("#worktoday").html('<img width="100px" height="100px" src="<?php echo base_url() ?>img/loading_gif.gif" style="position:relative;top:0px;left:0px;">');
        $.ajax({url: "/btwdive/index.php/customer/displayDiverCommission/",
            type: "post",
            data: {
                one: $("#diver").val(),
                from: $("#fromdate").val(),
                to: $("#todate").val(),
            },
            success: function(result) {

                $("#worktoday").html(result);
                //document.getElementById("totalwork").innerHTML=$("#totalcount").val();
                $("#worktoday tr:even").css("background-color", "#ffffff");
                $("#worktoday tr:odd").css("background-color", "#E5E5E5");
                $("#worktoday tr:even").css("color", "#000000");
                $("#worktoday tr:odd").css("color", "#000000");

                if(parseFloat($("#totalc").val()).toFixed(2)!='NaN'){
                    
                    
                var totalc = parseFloat($("#totalc").val()).toFixed(2);


                var deduction = $("#deduction").val();
                // alert(deduction);
                //  alert(totalc);
                // deduction = deduction.toFixed(2);
                var newtotal = parseFloat(totalc - deduction).toFixed(2);
                //  newtotal = newtotal.toFixed(2);
                $("#ctotal").val(totalc);
                $("#deduct").val(deduction);
                $("#newTotal").val(newtotal);
                //$("#ctotal").val()
            }}
        });
        }
    }
//Delete Commission Details
    $(document).ready(function() {
        $("#delete").click(function() {
            var r = confirm("Are you sure you want to Delete this transaction");
            if (!r) {
                exit;
            }
            delete_commission_details();
            alert("Data Deleted!");
            location.reload();
        });

    });
    /*
     
     */

    function printDiver()
    {
        var diver = $("#diver").val();
        var from = $("#fromdate").val();
        var to = $("#todate").val();
        from = from.replace(/\//g,'^');
        to = to.replace(/\//g,'^');
        window.open("<?php echo site_url('/customer/print_diver_commission/') ?>" + '/' + diver + '/' + from + '/' + to+ '/' +'/0');
        //  alert("hai");
    }


</script>
<input type="hidden" id="bsurl" value="<?php echo base_url() ?>"/>
<img src="asdsa" width="1px" height="1px" />


<div style="width: 40%; float: left; text-align: center;">
    Commission Report From <input type="text" name=""
                                  value="<?php
$k = date('m/d/Y', strtotime('last Sunday', strtotime(date('m/d/Y'))));
$date = $k;
$newdate = strtotime('-6 day', strtotime($date));
$newdate = date('m/d/Y', $newdate);
echo $newdate;
?>" id="fromdate" class="textbox"
                                  style="width: auto" onchange="updateList()" />
</div>
<div style="width: 40%; float: left; text-align: center;">
    To<input type="text" name="" value="<?php echo date('m/d/Y', strtotime('last Sunday', strtotime(date('m/d/Y')))); ?>"
             id="todate" class="textbox" style="width: auto" onchange="updateList()"/>
</div>
<div style="width: 19%; float: left; text-align: center;">

    Select Diver<select class="select" style="width:70%;" id="diver" onchange="updateList()">
        <option value="">Diver Name</option>
        <?php
        foreach ($options as $o):
            echo '<option value="' . $o->PK_DIVER . '">' . $o->DIVER_NAME . '</option>';
        endforeach;
        ?>
    </select>
</div>


<h2 style="width:100%;text-align: center;">To Edit The Amount Click on the transaction</h2>

<div style="width:100%;float:left;text-align: center;">
    <table style="width:98%;float:left;text-align: center;padding-left:0px;">
        <tr style="background-color: grey;">
            <th style="width:20%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Vessel Name</th>
            <th style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Location</th>
            <th style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Work Type</th>
            <th style="width:20%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Work Order</th>
            <th style="width:15%;float:left;text-align: center;padding:0px;border-right:1px solid white;background-color: grey;">Date</th>
            <th style="width:13%;float:left;text-align: center;padding:0px;background-color: grey;">Commission</th>
        </tr>
        <tr></tr> 
   </table>
    
    <div style="width:100.3%;float:left;text-align: center;padding-left:0px;height:300px;overflow-y: scroll;" id="worktoday">

    </div></div>

<div style="height: 340px; width: 300px" >
    

    
    
</div>
<div id="underlay" ></div>
<div id="lightbox" style="text-align:center;">
    <h3 style="
    width: 100%;
    float: left;
">Commission Details - <p style="
    display: inline-block;" id="work_type"> </p></h3>
    <div style="float: left;background-color: #000000;color: #ffffff;width: 100%; height:300px;text-align: center;">
        <div style="float: left; width: 100%; padding-left: 10px; padding-top: 10px;text-align: center;">
           
            <table width="100%" border="0">
  <tr>
    <td style="text-align:right;width:40%">Vessel Name</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;;background-color:#E5E5E5;" id="vesselName" readonly="readonly"></td>
  </tr>
  <tr>
    <td style="text-align:right;">Location</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;;background-color:#E5E5E5;" id="location" readonly="readonly"></td>
  </tr>
  <tr>
    <td style="text-align:right;">Work order number</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;text-align:right;;background-color:#E5E5E5;" id="workOrderNumber" readonly="readonly"></td>
  </tr>
  <tr>
    <td style="text-align:right;">Work order date</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;text-align:right;;background-color:#E5E5E5;" id="wo_date" readonly="readonly"></td>
  </tr>
  <tr >
    <td style="text-align:right;">List price</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;text-align:right;;background-color:#E5E5E5;" id="listPrice" readonly="readonly"></td>
  </tr>
  <tr>
    <td style="text-align:right;">Discount</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;text-align:right;;background-color:#E5E5E5;" id="discount" readonly="readonly"></td>
  </tr>
  <tr>
    <td style="text-align:right;">Invoice Value</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;text-align:right;;background-color:#E5E5E5;" id="invoiceValue" readonly="readonly" ></td>
  </tr>
  <tr>
    <td style="text-align:right;">Zinc Count</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;text-align:right;" id="zincCount" ></td>
  </tr>
  <tr>
    <td style="text-align:right;">Rate</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;text-align:right;" id="rate"></td>
  </tr>
  <tr>
    <td style="text-align:right;">Commission</td>
    <td style="text-align: left;"><input type="text" class="textbox" style="width: 200px;text-align:right;" id="commission"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
            </div><br /><br />
            <div style="align:center;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn" id="delete">Delete</button>
                <button class="btn"   onclick="updateCommission()" >modify</button>
                <button class="btn"   onclick="exitbtn()" >Exit</button>
            </div>
            <div style="float: left; width: 236px;">

            </div>
        </div>
    </div>
</div>
<!-- 
<div style="width:40%;float:left;text-align: left;">
    <form id="service_clean">
        <fieldset style="margin: 0px auto;border-right:2px solid white;">
            <table>
                <tr>
                    <td>Check No</td>
                    <td> Check Date</td>
                    <td></td>
                    <td  rowspan="3" style="vertical-align: bottom;"><button class="btn" id="process_pay" style="width: 160px;">Process Payment</button>
                <tr>
                    <td><input type='text' class="textbox" id="checkno"  style="width: auto"></td>
                    <td> <input type="text" name=""
                                value="<?php echo date("m/d/Y") ?>" id="checkdate" class="textbox"
                                style="width: auto" /></td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>
 -->
<div style="width:40%;float:right;text-align:right;">
    <table>
        <tr>
            <td></td>
            <td>Total Commission</td>
            <td><input type="text" class="textbox" id="ctotal"
                       style="width: auto" /></td>
        </tr>
        <tr>
            <td>Deductions</td>
            <td><select class="select" style="width:130px;">
                    
                    <?php
        foreach ($diver_deduction as $div_ded):
            echo '<option value="' . $div_ded->OPTIONS . '">' . $div_ded->OPTIONS . '</option>';
        endforeach;
        ?>
                </select>
            </td>
            <td><input type="text" class="textbox"
                       style="width: auto" id="deduct"/></td>
        </tr>
        <tr>
            <td></td>
            <td>New Total</td>
            <td><input type="text"  class="textbox"
                       style="width: auto" id="newTotal"/></td>
        </tr>
        <tr>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <button class="btn" onclick="printDiver()" id="void">Print</button></td>
            <td>&nbsp;</td>
            <td>
                <button class="btn" onclick="self.close()">Exit</button></td>
        </tr>
        <tr>
    </table>

</div>
<div style="width:100%;float:left;text-align: left;height:50px;">

</div>
<br><br><br><br><br>

