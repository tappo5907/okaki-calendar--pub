import Chart from "chart.js"

$(function() {
    const foodWeights = $('#foodWeights').data('json')
    
    let labels = new Array();
    let chartData = new Array();
    
    $.each(foodWeights, (index, foodWeight) => {
        labels.push(foodWeight.hour)
        chartData.push(foodWeight.weight)
    })
    console.log(labels)
    console.log(chartData)
    
    const context = $("#foodWeightChart")
    const chart = new Chart(context, {
        // The type of chart we want to create
        type: 'line',
    
        // The data for our dataset
        data: {
            labels: labels,
            datasets: [{
                label: 'ご飯の量',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: chartData
            }]
        },
    
        // Configuration options go here
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {                          //軸設定
                yAxes: [{                      //y軸設定
                    display: true,             //表示設定
                    scaleLabel: {              //軸ラベル設定
                       display: true,          //表示設定
                       labelString: '量(g)',  //ラベル
                       //fontSize: 18               //フォントサイズ
                    },
                    /*
                    ticks: {                      //最大値最小値設定
                        min: 0,                   //最小値
                        max: 30,                  //最大値
                        fontSize: 18,             //フォントサイズ
                        stepSize: 5               //軸間隔
                    },
                    */
                }],
                xAxes: [{                         //x軸設定
                    display: true,                //表示設定
                    //barPercentage: 0.4,           //棒グラフ幅
                    //categoryPercentage: 0.4,      //棒グラフ幅
                    scaleLabel: {                 //軸ラベル設定
                       display: true,             //表示設定
                       labelString: '時間(時)',  //ラベル
                       //fontSize: 18               //フォントサイズ
                    },
                    /*
                    ticks: {
                        fontSize: 18             //フォントサイズ
                    },
                    */
                }],
            }
        }
    })
});