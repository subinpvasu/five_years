<?php
include("../header.php");

$id = $_REQUEST['id'];

$array_currency = array('GBP' => "£", 'USD' => 'US$', 'EUR' => '€', 'CAD' => 'CA$', 'MAD' => "MAD", 'NOK' => 'kr', 'BRL' => 'R$', 'DKK' => 'kr.', 'SAR' => 'SAR', 'AUD' => 'AU$', 'HKD' => 'HK$', 'TRY' => 'TRY');

$account = $main->getRow("SELECT ad_account_name,ad_account_adword_id,ad_account_currencyCode FROM adword_accounts where ad_account_adword_id='" . $id . "' ");
$_SESSION['ad_account_adword_id'] = $account->ad_account_adword_id;
$_SESSION['ad_account_name'] = $account->ad_account_name;
$_SESSION['ad_account_currencyCode'] = $array_currency[$account->ad_account_currencyCode];
?>

<div class="report-container">
    <div class="page-header"><h1><?php echo $account->ad_account_name; ?> (<?php echo $account->ad_account_adword_id; ?>)</h1></div>
    <div class="report-div">
        <div class="report-div-one">
            <div class="report-details1">
                <span id="downloadLinkExcel" style="display:line;">
                    <!--a href="#" onclick="return htmToExcel()"; style="cursor:pointer;">Excel </a></span -->
                    <span class="txtcolor2" id="downloadHTMLExcel" style="display:none;">Downloading.......</span> &nbsp; &nbsp;
                    <span id="downloadLinkPdf" style="display:line;">
                        <a href="#" onclick="return htmToPdf()"; style="cursor:pointer;">Pdf </a></span>
                    <span class="txtcolor2" id="downloadHTMLPdf" style="display:none;">Downloading.......</span>
            </div>		
            <div class="report-details2">

                <input type='hidden' name='id' value='<?php echo $id; ?>' id="customer_id" />
                <div><span class="txtcolor2">Select</span> Month :</div>
                <div><select name='type' id="select_month" class="slectclass" ><option value="0">--Select--</option>
                        <?php
                        for ($i = 0; $i < 12; $i++) {

                            if (date("Y-m", strtotime(date('Y-m') . " -$i months")) == date("Y-m")) {
                                $s = "selected=selected";
                            } else {
                                $s = "";
                            }

                            echo "<option value='" . date("Y-m", strtotime(date('Y-m') . " -$i months")) . "' $s  >" . date("M-Y", strtotime(date('Y-m') . " -$i months")) . "</option>";
                        }
                        ?>
                    </select></div>
                <div><input type="image" src="../img/go.png" alt="GO" class="submit_button" id="submit_button_id" ></div>
                <div><span class="txtcolor2">Select</span> Quarter :</div>
                <div><select name='type' id="select_quarter" class="slectclass" ><option value="0">--Select--</option>
                        <?php
                        $ar = $main->getGivenNumberOfQuarters();
                        for ($i = 5; $i >= 0; $i--) {
                            echo "<option value='" . $ar[$i]['quarter'] . "' >" . $ar[$i]['quarter'] . "</option>";
                        }
                        ?>
                    </select></div>
                <div><input type="image" src="../img/go.png" alt="GO" class="submit_button" id="submit_button_id" ></div>


            </div>	
        </div>

        <div id="summery_report_id">
            <style> 
                table {table-layout:fixed;}
                td {padding-left:5px;}

                .classh1 {
                    background-color: #00d8ff;
                    padding: 10px 20px; 
                    border-radius : 10px 10px .01em .01em;
                    color: #fff;
                    font-size: 18px;
                    height: 30px;
                    width : 95%;
                    margin-bottom : 0px;
                }

                .classb1 {

                    width : 98.2%;
                    padding: 5px 0px;
                    background: #F5F5F5;
                    height:auto ;
                    margin:0px;
                    text-align: center ;
                }
                .classb2{
                    width : 95%;
                    padding: 10px 20px; 
                    border-bottom-left-radius : 10px;
                    border-bottom-right-radius : 10px;
                    background: #717171;
                    height:5px ;
                    margin-bottom : 10px;
                }
                .classb3{
                    width:98%;
                    background : #222 ;
                    border:1px #CCC solid ;
                    height : auto;
                    margin: 5px auto ;
                }
                .table1{
                    border-collapse  : collapse ;
                    border : #333 1px solid ;
                    height:auto;
                    width:100%;

                }
                .table1 td{

                    width:15%;
                    height:100px;
                }
                .hone,.htwo,.hthree,.hfour{
                    float:left;
                    width:100% ;
                    text-align : center;
                    margin:5px 0px;
                }
                .hone{
                    color:#666;

                }
                .htwo{
                    color:#EEE;
                    font-weight:bold ;
                    font-size : 18px;
                    margin-bottom:0px;
                }
                .hthree{

                    color:#EEE;
                    font-size : 10px;
                    margin-top:0px;
                }
                .hfour{

                }
                .classb4{
                    width:30%;
                    background:#DDD;
                    margin:auto;
                    font-size : 10px;
                    padding : 2px 5px;
                }
                .containerdiv{
                    display: none;

                }
                .green_span{
                    color:green;
                }
                .red_span{
                    color:red ;
                }

                .table_head{
                    background: #717171;
                    color:#FFF ;

                }
                .odd_trs{
                    background: #e1e1e1;
                }

                .classb1 table{

                    border-collapse : collapse ;
                }
                .classh1 p{

                    display: inline;
                    color:white;
                    font-weight: bold;
                    padding-left: 5px;
                    line-height: 15px;
                }
                .logo_div{
                    width : 95%;
                    margin: 10px;
                    height : 100px;
                }
                .logo_div table{
                    table-layout:initial;
                }
            </style>
            <div class="logo_div">
                <table>
                    <tr>
                        <td width="20%"><img src="<?php echo SITE_IMAGES . "push_logo.png"; ?>" /></td>
                        <td width="15%"><?php echo $account->ad_account_name; ?></td>
                        <td width="15%"><span id="month_text"><?php echo $monthTxt; ?> </span> <?php echo PPC_PUSH_REPORT; ?></td>
                        <td width="30%">Generated from Push™ Analyser</td>
                    </tr>
                </table>
            </div>
            <!-----  New Design  -->
            <div class="containerdiv" id="div1">
                <div class='classh1'>					
                    <input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Executive Summary : View your conversions and data for this month and compare to last month.</p> 

                </div>
                <div class='classb1'  id="exec_summery"></div>
                <div class='classb2'></div>                
            </div>

            <div class="containerdiv" id="div2">
                <b style="page-break-after: always;"></b>
                <div class='classh1'> 	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Conversion Share : View which campaigns contribute to your conversions. We focus on terms leading to conversions.</p></div>
                <div class='classb1' id="conversion_share">&nbsp;</div>
                <div class='classb2'></div>
            </div>

            <div class="containerdiv" id="div3">
                <b style="page-break-after: always;"></b>
                <div class='classh1'> 	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Ad Label Report : These ad labels show differences in themes being tested on adverts.</p></div>
                <div class='classb1' id="ad_label_report">&nbsp;</div>
                <div class='classb2'></div>	
            </div>

            <div class="containerdiv" id="div10">
                <b style="page-break-after: always;"></b>
                <div class='classh1'> 	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Ad Report : Your most popular adverts.</p></div>
                <div class='classb1' id="ad_report">&nbsp;</div>
                <div class='classb2'></div>		
                
            </div>

            <div class="containerdiv" id="div4">
                <b style="page-break-after: always;"></b>
                <div class='classh1'> 	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Wastage Analysis : These terms have not converted. Any irrelevant words in the query field will be added as a negative to save money.</p></div>
                <div class='classb1' id="wastage_analysis">&nbsp;</div>
                <div class='classb2'></div>			
               
            </div>

            <div class="containerdiv" id="div5">
                <b style="page-break-after: always;"></b>
                <div class='classh1'> 	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Device Report : View how your campaign performs by device.</p></div>
                <div class='classb1' id = "device_report">&nbsp;</div>
                <div class='classb2'></div>		
                
            </div>

            <div class="containerdiv" id="div6">
                <b style="page-break-after: always;"></b>
                <div class='classh1'> 	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Keyword Discovery : These terms have led to conversions. Using the query field we add themes of phrases and words to drive more sales/leads.
                    </p></div>
                <div class='classb1' id="keyword_discovery">&nbsp;</div>
                <div class='classb2'></div>	
                
            </div>

            <div class="containerdiv" id="div7">
                <b style="page-break-after: always;"></b>
                <div class='classh1'> 	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Conversion Booster : These keywords have a low click through rate. If we can increase it through tests we can increase conversions.</p></div>
                <div class='classb1' id="conversion_booster">&nbsp;</div>
                <div class='classb2'></div>
                
            </div>

            <div class="containerdiv" id="div8">
                 <b style="page-break-after: always;"></b>
                <div class='classh1'> 	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Avg By Day of Week : View clicks and conversions by day. We bid by day to allocate budget at on the right days of the week.</p></div>
                <div class='classb1' id="dayofweek">&nbsp;</div>
                <div class='classb2'></div>	
               
            </div>	

            <div class="containerdiv" id="div9">
                <b style="page-break-after: always;"></b>
                <div class='classh1'>	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Total By Hour of Day : View clicks and conversions by hour for the month. We bid by times in the day to allocate budget at best performing times.</p></div>
                <div class='classb1' id="hourofday">&nbsp;</div>
                <div class='classb2'></div>			
            </div>	
			<div class="containerdiv" id="div11">
                <b style="page-break-after: always;"></b>
                <div class='classh1'>	<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                    <p>Converted Rate By Hour and Day : Converted Rate By Hour and Day.</p></div>
                <div class='classb1' id="hourandday">&nbsp;</div>
                <div class='classb2'></div>			
            </div>	
        </div>
        <div id="additional_sections">
            <div class="containerdiv" id="div25">
                <div class='classh1'><p>Add Additional Sections</p></div>
                <div class='classb1' id="additional_sections_form"> 
                    <div id="additional_sections_form_error"></div>
                    <div id="additional_sections_form_div">
                        <div><label>Tile : </lable>&nbsp;<input type="text" name="additional_sections_title" value="" placeholder="Title" id="additional_sections_title" /></div>
                        <div><label>Image : </lable>&nbsp;<input type="file" name="additional_sections_file" value="" placeholder="Image" id="additional_sections_file" /></div>
                            <div><input type="button" name="additional_sections_add" id="additional_sections_add"  value="Add additional sections" /></div>
                    </div></div>
                <div class='classb2'></div>			
            </div>

        </div>
    </div>
</div>
<?php include("../footer.php"); ?>
