var processing = 0; var newproc =0;
$(document).ready(function () {

    customer_report();

    $(document).on("click", ".submit_button", function () {
        customer_report();
    });

    $(document).on("change", ".classcb", function () {
        var ischecked = $(this).is(':checked');
        if (!ischecked) {
            $(this).parent().parent().css("display", "none");
        }
    });
    $("#select_quarter").change(function () {
        $("#select_month").val(0);
    });
    $("#select_month").change(function () {
        $("#select_quarter").val(0);
    });
    $(document).on("click", "#additional_sections_add", function () {
        additional_sections_add();
    });
});

function customer_report() {

    var type = 0;
    if (processing == 1) {
        alert("Reports loading. Please wait....");
        return false;
    }

    processing = 1;
    $(".newsections").remove();
    $(".slectclass").prop('disabled', 'disabled');
    $(".containerdiv").css('display', 'none');
    $("#downloadLinkPdf").css('display', 'none');
    var id = $("#customer_id").val();
    if ($("#select_month").val() != 0) {
        var month = $("#select_month").val();
        type = 0;
        var txt = $("#select_month option:selected").text();
    }
    if ($("#select_quarter").val() != 0) {
        var month = $("#select_quarter").val();
        type = 1;
        var txt = $("#select_quarter option:selected").text();
    }

   // var div = "#summery_report_id";
    $("#downloadHTML").css('display', 'none');
    $("#downloadLink").css('display', 'none');
    $("#loading_gif_id2").css('display', 'none');


    var over = '<div id="overlay">' +
            '<img id="loading" src="../img/loading.gif">' +
            '</div>';

    $('#summery_report_id').append(over);

    $("#month_text").html("<b> " + txt + " </b>");
    $("#loading_gif_id").css('display', 'block');

    $.post('servicefiles/cr1.php', {id: id, month: month, type: type}, function (data) {

        $("#div1").css("display", "block");
        $("#exec_summery").html(data);
        loadConvShare(id, month);
        //reportLoadComplete();
    });


}

function loadConvShare(id, month) {

    var options = {
        chart: {
            renderTo: 'conversion_share',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: ''

        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.point.name + '</b>';
            }
        },
        colors: ['#9331C6', '#25D8FD', '#E9298F', '#33C757', '#FD9B27', '#373A3C', '#C5C5C5', '#F02640', '#199DB7']
        ,
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return '<b>' + this.point.name + '</b>';
                    },
                    fontSize: '15px'
                }
            }
        },
        exporting: {
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [{
                type: 'pie',
                name: 'Browser share',
                data: []
            }]
    }

    $.getJSON("servicefiles/cr2.php", {id: id, month: month}, function (json) {

        $("#div2").css("display", "block");


        if ($('#conversion_share_graph_image').length) {
            $('#conversion_share_graph_image').remove();
        }

        if (json.error == 1) {
            
            $('#conversion_share').html('No results found');
            adLabelReport(id, month);
            
        }
        else {
            options.series[0].data = json;

            chart = new Highcharts.Chart(options);

            options = JSON.stringify(options);
            options = encodeURIComponent(options);

            dataString = 'async=true&content=options&options=' + options + '&type=image%2Fpng&width=&scale=&constr=Chart&callback=';

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'http://export.highcharts.com/',
                success: function (data) {

                    var img = 'http://export.highcharts.com/' + data;

                    $.post('servicefiles/conv_img.php', {img: img}, function (data) {


                        $("#div2").append('<input type="hidden" id="conversion_share_graph_image" value="' + data + '" />');

                        //reportLoadComplete();
                        adLabelReport(id, month);

                    });


                }});
        }
    });



}

function preview(filename, div) {
    if ($('#type').val() === 'application/pdf') {

        $('#' + div).html('<iframe style="width:600px;height:400px" src="./' + filename + '"></iframe>')
    } else {
        $('#' + div).html('<div style = "width:100%; background:#FFF; text-align:center;"><img src="' + filename + '"/></div>');
    }
}


function adLabelReport(id, month) {


    $.post('servicefiles/cr3.php', {id: id, month: month}, function (data) {

        $("#div3").css("display", "block");
        $("#ad_label_report").html(data);
        //reportLoadComplete();
        adReport(id, month)


    });
}

function adReport(id, month) {


    $.post('servicefiles/cr10.php', {id: id, month: month}, function (data) {

        $("#div10").css("display", "block");
        $("#ad_report").html(data);

        wastageAnalysisReport(id, month)


    });
}


function wastageAnalysisReport(id, month) {

    $.post('servicefiles/cr4.php', {id: id, month: month}, function (data) {

        $("#div4").css("display", "block");
        $("#wastage_analysis").html(data);

        deviceReport(id, month);

    });

}

function deviceReport(id, month) {

    $.post('servicefiles/cr5.php', {id: id, month: month}, function (data) {

        $("#div5").css("display", "block");
        $("#device_report").html(data);

        keywordDiscovery(id, month);

        //reportLoadComplete();


    });
}

function keywordDiscovery(id, month) {

    $.post('servicefiles/cr6.php', {id: id, month: month}, function (data) {

        $("#div6").css("display", "block");
        $("#keyword_discovery").html(data);

        conversionBooster(id, month);

        //reportLoadComplete();


    });
}


function conversionBooster(id, month) {

    $.post('servicefiles/cr7.php', {id: id, month: month}, function (data) {

        $("#div7").css("display", "block");
        $("#conversion_booster").html(data);

        avgByDayofWeek(id, month);

        //reportLoadComplete();


    });
}

function avgByDayofWeek(id, month) {

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
                categories: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                crosshair: true
            }],
        yAxis: [{ // Primary yAxis

                title: {
                    text: 'Clicks',
                    style: {
                        color: '#95CEFF'}
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: '#95CEFF'
                    }
                },
            }, {// Secondary yAxis
                title: {
                    text: 'Conversions',
                    style: {
                        color: '#40818B'}
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
        exporting: {
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

    if ($('#dayofweek_graph_image').length) {
        $('#dayofweek_graph_image').remove();
    }
    $.getJSON("servicefiles/cr8.php", {id: id, month: month}, function (json) {
        $("#div8").css("display", "block");
        if (json.error == 0) {
            options.series[0].data = json.clicks;
            options.series[1].data = json.conversions;
            chart = new Highcharts.Chart(options);
            options = JSON.stringify(options);
            options = encodeURIComponent(options);

            dataString = 'async=true&content=options&options=' + options + '&type=image%2Fpng&width=&scale=&constr=Chart&callback=';

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'http://export.highcharts.com/',
                success: function (data) {
                    var img = 'http://export.highcharts.com/' + data;

                    $.post('servicefiles/conv_img.php', {img: img}, function (data) {

                        $("#div8").append('<input type="hidden" id="dayofweek_graph_image" value="' + data + '" />');

                        totalByHourofDay(id, month);

                    });

                },
                error: function (err) {
                    $('#dayofweek').html('Error: ' + err.statusText);
                }
            });

        }
        else {
            $("#dayofweek").html('<div>' + json.error + '</div>')
            totalByHourofDay(id, month);
        }

    });

}

function totalByHourofDay(id, month) {

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
                categories: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                crosshair: true
            }],
        yAxis: [{ // Primary yAxis

                title: {
                    text: 'Clicks',
                    style: {
                        color: '#95CEFF'}
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: '#95CEFF'
                    }
                },
            }, {// Secondary yAxis
                title: {
                    text: 'Conversions',
                    style: {
                        color: '#40818B'}
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
        exporting: {
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
    if ($('#hourofday_graph_image').length) {
        $('#hourofday_graph_image').remove();
    }
    $.getJSON("servicefiles/cr9.php", {id: id, month: month}, function (json) {
        $("#div9").css("display", "block");
        if (json.error == 0) {
            options.series[0].data = json.clicks;
            options.series[1].data = json.conversions;
            chart = new Highcharts.Chart(options);
            options = JSON.stringify(options);
            options = encodeURIComponent(options);

            dataString = 'async=true&content=options&options=' + options + '&type=image%2Fpng&width=&scale=&constr=Chart&callback=';

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'http://export.highcharts.com/',
                success: function (data) {
                    var img = 'http://export.highcharts.com/' + data;

                    $.post('servicefiles/conv_img.php', {img: img}, function (data) {

                        $("#div9").append('<input type="hidden" id="hourofday_graph_image" value="' + data + '" />');

                        conversionRateByHourandDay(id, month);

                    });


                },
                error: function (err) {
                    $('#hourofday').html('Error: ' + err.statusText);
                }

            });
            //chart = new Highcharts.Chart(options);
        }
        else {
            $("#hourofday").html('<div>' + json.error + '</div>')
            conversionRateByHourandDay(id, month);
        }


    });

}




function conversionRateByHourandDay(id, month) {

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
    if ($('#hourandday_graph_image').length) {
        $('#hourandday_graph_image').remove();
    }
    $.getJSON("servicefiles/cr11.php", {id: id, month: month}, function (json) {
        $("#div11").css("display", "block");
        if (json.error == 0) {
            options.series[0].data = json.convrate; 
            //options.series[1].data = json.conversions;
            chart = new Highcharts.Chart(options);
            options = JSON.stringify(options);
            options = encodeURIComponent(options);

            dataString = 'async=true&content=options&options=' + options + '&type=image%2Fpng&width=&scale=&constr=Chart&callback=';

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'http://export.highcharts.com/',
                success: function (data) {
                    var img = 'http://export.highcharts.com/' + data;

                    $.post('servicefiles/conv_img.php', {img: img}, function (data) {

                        $("#div11").append('<input type="hidden" id="hourandday_graph_image" value="' + data + '" />');

                        reportLoadComplete();

                    });


                },
                error: function (err) {
                    $('#hourandday').html('Error: ' + err.statusText);
                }

            });
            //chart = new Highcharts.Chart(options);
        }
        else {
            $("#hourandday").html('<div>' + json.error + '</div>')
            reportLoadComplete();
        }


    });

}



function reportLoadComplete() {
    $('#overlay').remove();
    $(".containerdiv").css('display', 'block');
    $("#downloadHTMLExcel").css('display', 'none');
    $("#downloadLinkExcel").css('display', '');
    $("#downloadHTMLPdf").css('display', 'none');
    $("#downloadLinkPdf").css('display', '');
    $("#loading_gif_id2").css('display', 'none');
    $(".slectclass").removeAttr("disabled");

    processing = 0;
}




function htmToExcel() {


    var html = $("#summery_report_id").html();

    if (html != '') {

        $("#downloadHTMLExcel").css('display', '');
        $("#downloadLinkExcel").css('display', 'none');
        $.post('servicefiles/html_excel.php', {html: html}, function (data) {

            if (data == 1) {

                $("#downloadHTMLExcel").css('display', 'none');
                $("#downloadLinkExcel").css('display', '');

                window.open('phpHtmlExcel.php', '_blank');

            }

        });
    }
    else {
        alert("Please wait... ");
    }
    return false;
}
function htmToPdf() {

    var html = $("#summery_report_id").html();
    var html1 = $("#conversion_share").html();
    var html2 = $("#dayofweek").html();
    var html3 = $("#hourofday").html();
    var html4 = $("#hourandday").html();

    var graph1 = $("#conversion_share_graph_image").val();
    var graph2 = $("#dayofweek_graph_image").val();
    var graph3 = $("#hourofday_graph_image").val();
    var graph4 = $("#hourandday_graph_image").val();


    if (html != '') {

        $("#downloadHTMLPdf").css('display', '');
        $("#downloadLinkPdf").css('display', 'none');
        $.post('servicefiles/html_excel.php', {html: html, html1: html1, html2: html2, html3: html3, html4: html4, graph1: graph1, graph2: graph2, graph3: graph3, graph4: graph4}, function (data) {

            if (data == 1) {

                $("#downloadHTMLPdf").css('display', 'none');
                $("#downloadLinkPdf").css('display', '');

                window.open('phpHtmlPdf.php', '_blank');

            }

        });
    }
    else {
        alert("Please wait... ");
    }
    return false;
}
function additional_sections_add(){
    
    
    if(newproc == 0) {
        newproc = 1;
        $("#additional_sections_form_error").html('');
        var file_data = $('#additional_sections_file').prop('files')[0];   
        var title_data = $('#additional_sections_title').val();   
        var error = 0 ;  
        var str = $('#Search').val();
        var ext = $('#additional_sections_file').val().split('.').pop().toLowerCase();
        /*if(!title_data.trim() || /^[a-zA-Z0-9-:. ]*$/.test(title_data) == false) {
            $("#additional_sections_form_error").html('<div>Please enter a valid title for your new section</div>');
            error =1 ;
        }    
        elseif($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            $("#additional_sections_form_error").html('<div>Please upload image with type jpg, jpeg, png or gif</div>');
            error =1 ;
        }*/ 
        if(error==0){
            var form_data = new FormData();                  
            form_data.append('file', file_data);
            form_data.append('title', title_data);

            $.ajax({
                url: 'servicefiles/cr25.php', // point to server-side PHP script 
                dataType: 'json',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(json){
                    
                    if(json.error ==0){                
                        $("#summery_report_id").append(json.str);            
                        $('#additional_sections_title').val('');
                        $('#additional_sections_file').val('');
                    }
                    else {                
                        $("#additional_sections_form_error").html('<div>' + json.str + '</div>');
                    }
                    
                    newproc = 0;
                }
            });
        }

    }
}

