    var initChartSample5 = function() {
        var chart = AmCharts.makeChart("chart_5", {
            "theme": "light",
            "type": "serial",
            "startDuration": 2,

            "fontFamily": 'Open Sans',

            "color":    '#888',

            "dataProvider": [{
                "partida": "05-01",
                "value": 4025,
                "color": "#FF0F00"
            }, {
                "partida": "03-02",
                "value": 1882,
                "color": "#FF6600"
            }, {
                "partida": "09-01",
                "value": 1809,
                "color": "#FF9E01"
            }, {
                "partida": "02-01",
                "value": 1322,
                "color": "#FCD202"
            }, {
                "partida": "00-05",
                "value": 1122,
                "color": "#F8FF01"
            }, {
                "partida": "00-08",
                "value": 1114,
                "color": "#B0DE09"
            }, {
                "partida": "00-09",
                "value": 984,
                "color": "#04D215"
            }, {
                "partida": "07-01",
                "value": 711,
                "color": "#0D8ECF"
            }, {
                "partida": "09-06",
                "value": 665,
                "color": "#0D52D1"
            }, {
                "partida": "04-04",
                "value": 580,
                "color": "#2A0CD0"
            }, {
                "partida": "04-03",
                "value": 443,
                "color": "#8A0CCF"
            }, {
                "partida": "07-08",
                "value": 441,
                "color": "#CD0D74"
            }, {
                "partida": "02-09",
                "value": 395,
                "color": "#754DEB"
            }, {
                "partida": "09-05",
                "value": 386,
                "color": "#DDDDDD"
            }, {
                "partida": "02-06",
                "value": 384,
                "color": "#999999"
            }, {
                "partida": "03-05",
                "value": 338,
                "color": "#333333"
            }, {
                "partida": "08-04",
                "value": 328,
                "color": "#000000"
            }],
            "valueAxes": [{
                "position": "left",
                "axisAlpha": 0,
                "gridAlpha": 0
            }],
            "graphs": [{
                "balloonText": "[[category]]: <b>[[value]]</b>",
                "colorField": "color",
                "fillAlphas": 0.85,
                "lineAlpha": 0.1,
                "type": "column",
                "topRadius": 1,
                "valueField": "value"
            }],
            "depth3D": 40,
            "angle": 30,
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "partida",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "gridAlpha": 0

            },
            "exportConfig": {
                "menuTop": "20px",
                "menuRight": "20px",
                "menuItems": [{
                    "icon": '/lib/3/images/export.png',
                    "format": 'png'
                }]
            }
        }, 0);

        jQuery('.chart_5_chart_input').off().on('input change', function() {
            var property = jQuery(this).data('property');
            var target = chart;
            chart.startDuration = 0;

            if (property == 'topRadius') {
                target = chart.graphs[0];
            }

            target[property] = this.value;
            chart.validateNow();
        });

        $('#chart_5').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
    };

