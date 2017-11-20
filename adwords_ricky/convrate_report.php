<?php
 if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="CRR" || $id=='' ){

	header("Location:account_details.php");
}

?>

<script>



function conversionRateByHourandDay(){

    var options = {
        
		chart: {
            type: 'heatmap',
            marginTop: 40,
            marginBottom: 80,
            plotBorderWidth: 1 ,
			renderTo: 'hourandday'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
                categories: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                crosshair: true
            }],
        yAxis: [{
            categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'],
            title: null
        }],
        tooltip: {
            shared: true
        },
        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[0]
        },

        legend: {
            align: 'right',
            layout: 'vertical',
            margin: 0,
            verticalAlign: 'top',
            y: 25,
            symbolHeight: 280
        },

        exporting: {
            enabled: false
        },
        credits: {
            enabled: false
        },

      series: [{
            name: 'Conv. Rate',
            borderWidth: 1,
            data: [],
            dataLabels: {
                enabled: true,
                color: '#000000'
            }
        }]

    }	
	
$.getJSON("convrate_heatmap.php", function (json) {
        
        if (json.error == 0) {
            options.series[0].data = json.convrate; 
            
            chart = new Highcharts.Chart(options);
            
}});

}

</script>
<div style="width:100%; margin:10px;">
<table><tr>
<td width="100%">
		<h2>Conversion Rate By Hour & Day</h2>
		<div id="hourandday"></div>
	</div>
	</td>
</tr></table>
</div>

