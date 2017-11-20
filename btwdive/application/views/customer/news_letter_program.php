<script type="text/javascript" src="<?php echo base_url();?>jquery/jquery-1.8.0.min.js"></script>
<script src="<?php echo base_url();?>jquery/jquery.zclip.js"></script>
<script>
$(document).ready(function(){
	$("td").css("padding-left","5px");
	$("th").css("padding-left","5px");
	$( "div  tr:even" ).css( "background-color", "grey" );
	$( "div  tr:even" ).css( "color", "white" );
	$( "div  tr:odd" ).css( "background-color", "white" );
	$( "div  tr:odd" ).css( "color", "black" );
});


$(document).ready(function(){
    $("#active_button").zclip({

       path:"<?php echo base_url();?>jquery/ZeroClipboard.swf",
       copy:function(){return $("#active_area").val();}

    });
});

$(document).ready(function(){
    $("#inactive_button").zclip({

       path:"<?php echo base_url();?>jquery/ZeroClipboard.swf",
       copy:function(){return $("#inactive_area").val();}

    });
});



// $("#active_button").click(function(){
// 	try{

// 	Copied = active_area.innerText.createTextRange();
// 	Copied.execCommand("Copy");
// 	}
// 	catch(e)
// 	{
// alert(e.message);
// 	}
// });
// $("#inactive_button").click(function(){
// 	holdtext = inactive_area.innerText;
// 	Copied = holdtext.createTextRange();
// 	Copied.execCommand("Copy");
// });


</script>

<h2 style="text-align: center;">Customer Email Addresses</h2>

<table style="width:80%;text-align: center;margin: 0px auto;">

<tr>
<th style="text-transform: uppercase;background-color: gray;">Active Customers</th>
<th style="text-transform: uppercase;background-color: gray;">Inactive Customers</th>
</tr>

<tr>


<td  style="vertical-align: top;">

<table style="width:100%;text-align: left;margin: 0px auto;">

<tr>
<th style="width:32%;background-color: white;color: black;">Customer Name</th>
<th style="width:65%;background-color: white;color: black;">Email Address</th>
</tr>
</table>
<div style="width:100%;height:410px;overflow: auto;">

<table style="width:100%;text-align: left;margin: 0px auto;">
<?php
$k=0;
$chr = '';
foreach ($active as $a)
{
    if (filter_var($a->EMAIL, FILTER_VALIDATE_EMAIL)) {
        echo '<tr><td  style="width:34%;">'.$a->FIRST_NAME.'&nbsp;'.$a->LAST_NAME.'</td><td  style="width:65%;">'.$a->EMAIL.'</td></tr>';
        $chr .= ','.$a->EMAIL;
        $k++;
    }

}
echo '<input type="hidden" id="active_areas" name="active" value="'.$k.'"  class="'.count($active).'"/>';
?>

</table>

<textarea id="active_area" style="display: none;"><?php echo $chr;?></textarea>
</div>
<div style="width:100%;float: left;">
<h3>Total : <?php echo $k;?></h3>
</div>
<div style="width:100%;position: relative;">
<button class="btn" style="width:auto;" id="active_button">Copy to Clipboard</button>
</div>


</td>

<td style="vertical-align: top;">

<table style="width:100%;text-align: left;margin: 0px auto;">

<tr>
<th  style="width:32%;background-color: white;color: black;">Customer Name</th>
<th style="width:65%;background-color: white;color: black;">Email Address</th>
</tr>
</table>
<div style="width:100%;height:410px;overflow: auto;">
<table style="width:100%;text-align: left;margin: 0px auto;">
<?php
$l=0;
$shr = '';
foreach ($inactive as $a)
{
    if (filter_var($a->EMAIL, FILTER_VALIDATE_EMAIL)) {
    echo '<tr><td style="width:34%;">'.$a->FIRST_NAME.'&nbsp;'.$a->LAST_NAME.'</td><td style="width:65%;">'.$a->EMAIL.'</td></tr>';
    $shr .= ','.$a->EMAIL;
    $l++;
    }
}
echo '<input type="hidden" id="inactive_areas" name="inactive" value="'.$l.'" class="'.count($inactive).'"/>';
?>

</table>
<textarea id="inactive_area" style="display: none;"><?php echo $shr;?></textarea>
</div>
<div style="width:100%;float: left;">
<h3>Total : <?php echo $l;?></h3>
</div>
<div style="width:100%;position: relative;">
<button class="btn" id="inactive_button" style="width:auto;">Copy to Clipboard</button>
</div>
</td>

</tr>

</table>
<div style="width:100%;float: left;text-align:center;">
<button onclick="self.close();" class="btn">Exit</button>
</div>