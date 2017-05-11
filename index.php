<html>
    <title>Civil Engineering</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <!--This JavaScript Block is in charge of generating the GoogleChart-->
    <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(init);

                function init() {
                    var xaxis = //this variable specifies the X axis, the default value is Step
                        <?php 
                            $x = isset($_GET['x']) ? $_GET['x'] : 'Step';
                            echo "'".$x."'";
                        ?>;

                    var yaxis = //this variable specifies the Y axis, the default value is Load
                        <?php 
                            $y = isset($_GET['y']) ? $_GET['y'] : 'Load';
                            echo "'".$y."'";
                        ?>;

                    var options = { //Specifies the options for the Google Chart
                        title: 'Data Graph',
                        chartArea: {
                            width: '60%',
                            height: '60%'
                        },
                        height: 383,
                        width: 600,
                        vAxis: {title: yaxis},
                        hAxis: {title: xaxis},
                        pointSize: 10,
                        pointShape: 'square',
                        crosshair: { trigger: 'selection'},
                        legend: { position: 'bottom' },
                    
                    };

                    var jsonData = $.ajax({ //Grabs data from the database by calling data.php file
                        url: "data.php",
                        dataType: "json",
                        async: false
                        }).responseText;

                    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                    var next = document.getElementById('nextBtn');
                    var back = document.getElementById('backBtn');
                    
                    var data = new google.visualization.DataTable(jsonData);
                    var view = new google.visualization.DataView(data);
                    view.setColumns([xaxis, yaxis]);

                    function drawChart() {
                        // Disabling the button while the chart is drawing.
                        next.disabled = true;
                        back.disabled = true;
                        google.visualization.events.addListener(chart, 'ready',
                            function() {
                                next.disabled = false;
                                back.disabled = false;
                            });
                        chart.draw(view, options);
                    }

                    next.onclick = function() {        
                        plusDivs(1);
                        var index = getIndex();
                        index = index - 1;
                        chart.setSelection([{row: index, column:null}]);
                    }
                    
                    back.onclick = function() {
                        plusDivs(-1);
                        var index = getIndex();
                        index = index - 1;
                        chart.setSelection([{row: index, column:null}]);
                    }

                    function selectHandler() {
                        var row = chart.getSelection()[0].row;
                        currentDiv(row + 1);
                    }

                    google.visualization.events.addListener(chart, 'select', selectHandler);
                    drawChart();
                }
            </script>
    <body>

    <div class="header">
        <img class="valpo" src="http://www.valpo.edu/wp-content/themes/cws-valpo/img/header/valpo_prestige_logo.png" alt="Valparaiso University" />
    </div>
            
    <div class="w3-content w3-display-container" id="slideshow">
        
    <?php //This PHP code executes and returns HTML code that specifies the location of the images
        include 'getImages.php';
    ?>

    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>

    <script type="text/javascript" src="js/slideshow.js"></script>

    <!--This form is used for changing the Axis-->
    <form method="get" id="form">
        <select id="x" name="x">
            <option selected="true" disabled="disabled">Choose X-Axis</option>                  
            <option value="Step">Step</option>
            <option value="Load">Load</option>
            <option value="Loading (lb)">Loading (lb)</option>
            <option value="Displacement (in)">Displacement (in)</option>
            <option value="Ext Bot">Ext Bot</option>
            <option value="Int Top">Int Top</option>
            <option value="Int Bot">Int Bot</option>
            <option value="Int Shear">Int Shear</option>
            <option value="Ext Top">Ext Top</option>
        </select>

        <select id="y" name="y">     
            <option selected="true" disabled="disabled">Choose Y-Axis</option>                 
            <option value="Step">Step</option>
            <option value="Load">Load</option>
            <option value="Loading (lb)">Loading (lb)</option>
            <option value="Displacement (in)">Displacement (in)</option>
            <option value="Ext Bot">Ext Bot</option>
            <option value="Int Top">Int Top</option>
            <option value="Int Bot">Int Bot</option>
            <option value="Int Shear">Int Shear</option>
            <option value="Ext Top">Ext Top</option>
        </select>

        <input type="submit" value="Change Axis">
    </form>
    </body>
</html> 
