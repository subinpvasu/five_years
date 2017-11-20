<?php
 if(!isset($_SESSION['user_name'])){ header("Location:index.php");}
if($type !="DHR" || $id=='' ){

	header("Location:account_details.php");
}

?>

<script>

function avgByDayofWeek(){
	
var options = {
        chart: {
			renderTo: 'dayofweek'
			
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday'],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            
            title: {
                text: 'Clicks',
				style: {
                color:'#95CEFF' }
            },
			labels: {
                format: '{value}',
                style: {
                    color: '#95CEFF'
                }
            },
        }, { // Secondary yAxis
            title: {
                text: 'Conversions',
				style: {
                color:'#40818B' }
            },
            labels: {
				
                style: {
                    color: '#40818B'
                }
            },
			
            opposite: true
        }],
        tooltip: {
            shared: true
        },
		colors: [
        '#95CEFF',
        '#40818B'
        ],
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 100,
            floating: true,
            
        },
		exporting:{
			enabled: false
		},
		 credits: {
			enabled: false
		},
		legend: {
            align: 'right',
            verticalAlign: 'top',
            layout: 'vertical',
            x: 0,
            y: 100
        },
        series: [{
            name: 'Clicks',
            type: 'column',
            yAxis: 0,
            data: [],
            

        }, 
		
		{
            name: 'Conversions',
            type: 'column',
			yAxis: 1,
            data: [],
            
        }]
    }    
	
if($('#dayofweek_graph_image').length) {$('#dayofweek_graph_image').remove();}	
	$.getJSON("dhr_reports_1.php", {},function(json) {
				
		$("#div8").css("display","block");
		options.series[0].data = json.clicks;
		options.series[1].data = json.conversions;
		chart = new Highcharts.Chart(options);
		
	});

}


function totalByHourofDay(){
	
var options = {
        chart: {
			renderTo: 'hourofday'
			
        },
        title: {
            text: ''
        },	
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            
            title: {
                text: 'Clicks',
				style: {
                color:'#95CEFF' }
            },
			labels: {
                format: '{value}',
                style: {
                    color: '#95CEFF'
                }
            },
        }, { // Secondary yAxis
            title: {
                text: 'Conversions',
				style: {
                color:'#40818B' }
            },
            labels: {
				format: '{value}',
                style: {
                    color: '#40818B'
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },	
		colors: [
        '#95CEFF',
        '#40818B'
        ],
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 100,
            floating: true,
            
        },
		exporting:{
			enabled: false
		},
		 credits: {
      enabled: false
		},
		legend: {
            align: 'right',
            verticalAlign: 'top',
            layout: 'vertical',
            x: 0,
            y: 100
        },
        series: [{
            name: 'Clicks',
            type: 'column',
            yAxis: 0,
            data: [],
            

        }, {
            name: 'Conversions',
            type: 'column',
			yAxis: 1,
            data: [],
            
        }]
    }    
	if($('#hourofday_graph_image').length) {$('#hourofday_graph_image').remove();}	
	$.getJSON("dhr_reports_2.php", {},function(json) {
				
		$("#div9").css("display","block");
		options.series[0].data = json.clicks;
		options.series[1].data = json.conversions;
		chart = new Highcharts.Chart(options);
				
	});

}

</script>
<div style="width:100%; margin:10px;">
<table><tr>
<td width="50%">
		<h2>Avg. by Day of Week</h2>
		<div id="dayofweek"></div>
	</div>
	
<td>
		<h2>Total by Hour of Day</h2>
		<div id="hourofday"></div>
	</td>
</tr></table>
</div>

