var percentage = 0.25;

var browserData = [
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1},
    {color: 'blue', y: 1}
]

var quotient = Math.floor(percentage*12);
for (var i = 0; i < quotient; i++){
    browserData[i].color = 'red';
}

// Create the chart
Highcharts.chart('chart-container', {
    chart: {
        type: 'pie'
    },
    plotOptions: {
        pie: {
            shadow: false,
            center: ['50%', '50%'],
            borderWidth: 8
        }
    },
    tooltip: false,
    series: [{
        name: 'Browsers',
        data: browserData,
        size: '80%',
        innerSize: '60%',
        dataLabels: false
    }]
});