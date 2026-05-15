//[Dashboard Javascript]

//Project:  Bonito Admin - Responsive Admin Template
//Version:  1.1.0
//Last change:  10/09/2017
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

    'use strict';

    // Make the dashboard widgets sortable Using jquery UI
    $('.connectedSortable').sortable({
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.box-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex: 999999
    });
    $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

    // jQuery UI sortable for the todo list
    $('.todo-list').sortable({
        placeholder: 'sort-highlight',
        handle: '.handle',
        forcePlaceholderSize: true,
        zIndex: 999999
    });

    // bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5();

    $('.daterange').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    }, function (start, end) {
        window.alert('You chose: ' + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

    /* jQueryKnob */
    $('.knob').knob();

    // jvectormap data
    var visitorsData = {
        US: 398, // USA
        SA: 400, // Saudi Arabia
        CA: 1000, // Canada
        DE: 500, // Germany
        FR: 760, // France
        CN: 300, // China
        AU: 700, // Australia
        BR: 600, // Brazil
        IN: 800, // India
        GB: 320, // Great Britain
        RU: 2000 // Russia
    };
    // World map by jvectormap
    $('#world-map').vectorMap({
        map: 'world_mill_en',
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: '#0a89c1',
                'fill-opacity': 1,
                stroke: 'none',
                'stroke-width': 0,
                'stroke-opacity': 1
            }
        },
        series: {
            regions: [
                {
                    values: visitorsData,
                    scale: ['#0a89c1', '#add6e8'],
                    normalizeFunction: 'polynomial'
                }
            ]
        },
        onRegionLabelShow: function (e, el, code) {
            if (typeof visitorsData[code] != 'undefined')
                el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
        }
    });

    // Sparkline charts
    var myvalues = [1300, 500, 1920, 927, 831, 1127, 719, 1930, 1221];
    $('#sparkline-1').sparkline(myvalues, {
        type: 'line',
        lineColor: '#67757c',
        fillColor: '#0a89c1',
        height: '50',
        width: '70'
    });
    myvalues = [715, 319, 620, 342, 662, 990, 730, 467, 559, 340, 881];
    $('#sparkline-2').sparkline(myvalues, {
        type: 'line',
        lineColor: '#67757c',
        fillColor: '#6ab6d8',
        height: '50',
        width: '70'
    });
    myvalues = [88, 49, 22, 35, 45, 72, 11, 55, 25, 19, 27];
    $('#sparkline-3').sparkline(myvalues, {
        type: 'line',
        lineColor: '#67757c',
        fillColor: '#add6e8',
        height: '50',
        width: '70'
    });



    // SLIMSCROLL FOR CHAT WIDGET
    $('#chat-box').slimScroll({
        height: '325px'
    });

    /*
     * Flot Interactive Chart
     * -----------------------
     */
    // We use an inline data source in the example, usually data would
    // be fetched from a server
    var data = [], totalPoints = 300

    function getRandomData() {

        if (data.length > 0)
            data = data.slice(1)

        // Do a random walk
        while (data.length < totalPoints) {

            var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5

            if (y < 0) {
                y = 0
            } else if (y > 100) {
                y = 100
            }

            data.push(y)
        }

        // Zip the generated y values with the x values
        var res = []
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
        }

        return res
    }

    var interactive_plot = $.plot('#interactive', [getRandomData()], {
        grid: {
            color: "#AFAFAF"
            , hoverable: true
            , borderWidth: 0
            , backgroundColor: '#FFF'
        },
        series: {
            shadowSize: 0, // Drawing is faster without shadows
            color: '#33bf7a'
        },
        tooltip: true,
        lines: {
            fill: true, //Converts the line chart to area chart
            color: '#33bf7a'
        },
        tooltipOpts: {
            content: "Visit: %y"
            , defaultTheme: false
        },
        yaxis: {
            min: 0,
            max: 100,
            show: true
        },
        xaxis: {
            show: true
        }
    })

    var updateInterval = 30 //Fetch data ever x milliseconds
    var realtime = 'on' //If == to on then fetch data every x seconds. else stop fetching
    function update() {

        interactive_plot.setData([getRandomData()])

        // Since the axes don't change, we don't need to call plot.setupGrid()
        interactive_plot.draw()
        if (realtime === 'on')
            setTimeout(update, updateInterval)
    }

    //INITIALIZE REALTIME DATA FETCHING
    if (realtime === 'on') {
        update()
    }
    //REALTIME TOGGLE
    $('#realtime .btn').click(function () {
        if ($(this).data('toggle') === 'on') {
            realtime = 'on'
        } else {
            realtime = 'off'
        }
        update()
    })
    /*
     * END INTERACTIVE CHART
     */

    /*
     * BAR CHART
     * ---------
     */

    var bar_data = {
        data: [['Jan', 18], ['Feb', 8], ['Mar', 15], ['Apr', 20], ['May', 11], ['Jun', 3], ['Jul', 18], ['Aug', 8], ['Sep', 15], ['Oct', 20], ['Nov', 11], ['Dec', 3]],
        color: '#7460EE', borderWidth: '0.1'
    }
    $.plot('#bar-chart', [bar_data], {
        grid: {
            borderWidth: 1,
            borderColor: '#f3f3f3',
            tickColor: '#f3f3f3'
        },
        series: {
            bars: {
                show: true,
                barWidth: 0.1,
                lineWidth: 0,
                fillColor: '#7460EE',
                align: 'center',
            }
        },
        xaxis: {
            mode: 'categories',
            tickLength: 0
        }
    })
    /* END BAR CHART */


    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */




    // -----------------------
    // - MONTHLY SALES CHART -
    // -----------------------

    // Get context with jQuery - using jQuery's .get() method.
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    // This will get the first returned node in the jQuery collection.
    var salesChart = new Chart(salesChartCanvas);

    var datasets = [];
    $(".country_report").each(function () {
        var color = $(this).attr('color');
        var name = $(this).attr('name');
        var jan = $(this).attr('jan');
        var feb = $(this).attr('feb');
        var mar = $(this).attr('mar');
        var apr = $(this).attr('apr');
        var may = $(this).attr('may');
        var jun = $(this).attr('jun');
        var jul = $(this).attr('jul');
        var aug = $(this).attr('aug');
        var sep = $(this).attr('sep');
        var oct = $(this).attr('oct');
        var nov = $(this).attr('nov');
        var dec = $(this).attr('dec');

        var final = {
            label: name,
            fillColor: 'rgba(30,172,190,0.1)',
            strokeColor: 'rgba(30,172,190,1)',
            pointColor: color,
            pointStrokeColor: 'rgba(30,172,190,1)',
            pointHighlightFill: color,
            pointHighlightStroke: 'rgba(30,172,190,1)',
            data: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec]
        };
        datasets.push(final);

    });
    var salesChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'Augest', 'September', 'October', 'November', 'December'],
        datasets: datasets
    };

    var salesChartOptions = {
        // Boolean - If we should show the scale at all
        showScale: true,
        // Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        // String - Colour of the grid lines
        scaleGridLineColor: 'rgba(0,0,0,.1)',
        // Number - Width of the grid lines
        scaleGridLineWidth: 0.5,
        // Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        // Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        // Boolean - Whether the line is curved between points
        bezierCurve: true,
        // Number - Tension of the bezier curve between points
        bezierCurveTension: 0,
        // Boolean - Whether to show a dot for each point
        pointDot: true,
        // Number - Radius of each point dot in pixels
        pointDotRadius: 4,
        // Number - Pixel width of point dot stroke
        pointDotStrokeWidth: 1,
        // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius: 20,
        // Boolean - Whether to show a stroke for datasets
        datasetStroke: true,
        // Number - Pixel width of dataset stroke
        datasetStrokeWidth: 1,
        // Boolean - Whether to fill the dataset with a color
        datasetFill: true,
        // String - A legend template
        legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        // Boolean - whether to make the chart responsive to window resizing
        responsive: true
    };

    // Create the line chart
    salesChart.Line(salesChartData, salesChartOptions);

    // ---------------------------
    // - END MONTHLY SALES CHART -
    // ---------------------------

    // -------------
    // - PIE CHART -
    // -------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
        {
            value: $('#andorid_user').attr('value'),
            color: '#26C6DA',
            highlight: '#26C6DA',
            label: 'Android'
        },
        {
            value: $('#ios_user').attr('value'),
            color: '#1e88e5',
            highlight: '#1e88e5',
            label: 'IOS'
        }
    ];
    var pieOptions = {
        // Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        // String - The colour of each segment stroke
        segmentStrokeColor: '#fff',
        // Number - The width of each segment stroke
        segmentStrokeWidth: 0,
        // Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 70, // This is 0 for Pie charts
        // Number - Amount of animation steps
        animationSteps: 100,
        // String - Animation easing effect
        animationEasing: 'easeOutBounce',
        // Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        // Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        // Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: false,
        // String - A legend template
        legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
        // String - A tooltip template
        tooltipTemplate: '<%=value %> <%=label%> users'
    };
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
    
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d');
    var pieChart2 = new Chart(pieChartCanvas2);
    var PieData2 = [
        {
            value: $('#arabic_user').attr('value'),
            color: '#7460ee',
            highlight: '#7460ee',
            label: 'Arabic'
        },
        {
            value: $('#english_user').attr('value'),
            color: '#fc4b6c',
            highlight: '#fc4b6c',
            label: 'English'
        }
    ];
    var pieOptions2 = {
        // Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        // String - The colour of each segment stroke
        segmentStrokeColor: '#fff',
        // Number - The width of each segment stroke
        segmentStrokeWidth: 0,
        // Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 70, // This is 0 for Pie charts
        // Number - Amount of animation steps
        animationSteps: 100,
        // String - Animation easing effect
        animationEasing: 'easeOutBounce',
        // Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        // Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        // Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: false,
        // String - A legend template
        legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
        // String - A tooltip template
        tooltipTemplate: '<%=value %> <%=label%> users'
    };
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart2.Doughnut(PieData2, pieOptions2);
    // -----------------
    // - END PIE CHART -
    // -----------------

    //----------------------------line

    // Get context with jQuery - using jQuery's .get() method.
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
    // This will get the first returned node in the jQuery collection.
    var lineChart = new Chart(lineChartCanvas);

    var lineChartData = {
        labels: ['0', '4', '8', '12', '16', '20', '24', '30'],
        datasets: [
            {
                label: 'Electronics',
                fillColor: 'rgba(38,198,218,0)',
                strokeColor: 'rgba(38,198,218,1)',
                pointColor: '#26C6DA',
                pointStrokeColor: 'rgba(38,198,218,0.5)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(38,198,218,1)',
                data: [0, 2, 3.5, 0, 13, 1, 4, 1]
            },
            {
                label: 'Digital Goods',
                fillColor: 'rgba(30,136,229,0)',
                strokeColor: 'rgba(30,136,229,1)',
                pointColor: 'rgba(30,136,229,0.5)',
                pointStrokeColor: '#1e88e5',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(30,136,229,1)',
                data: [0, 4, 0, 4, 0, 4, 0, 4]
            }
        ]
    };

    var lineChartOptions = {
        //Boolean - If we should show the scale at all
        showScale: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - Whether the line is curved between points
        bezierCurve: true,
        //Number - Tension of the bezier curve between points
        bezierCurveTension: 0.3,
        //Boolean - Whether to show a dot for each point
        pointDot: true,
        //Number - Radius of each point dot in pixels
        pointDotRadius: 1,
        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth: 1,
        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius: 20,
        //Boolean - Whether to show a stroke for datasets
        datasetStroke: true,
        //Number - Pixel width of dataset stroke
        datasetStrokeWidth: 1,
        //Boolean - Whether to fill the dataset with a color
        datasetFill: true,
        //String - A legend template
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true
    };

    //Create the line chart
    lineChart.Line(lineChartData, lineChartOptions);



}); // End of use strict
