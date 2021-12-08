<template>
    <div class="row">
       <div class="col-xl-8 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <canvas id="line-chart" height="500"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: {
                    feets: '',
                    inches: '',
                    kilos: '',
                    result: '',
                    bmi: '',
                    category: '',
                },
                isRecord: false,
            }
        },

        methods: {
            calculate() {
                var cm = this.data.feets * 30.48;
                cm = cm + (this.data.inches * 2.54);

                this.data.bmi = this.data.kilos / Math.pow(cm, 2) * 10000;
                this.data.bmi = this.data.bmi.toFixed(2);

                if(parseFloat(this.data.bmi) < 18.5){
                    this.category = 'under';
                    this.data.result = 'Your BMI is '+this.data.bmi+', indicating your weight is in the Underweight category for adults of your height.<br><br>Talk with your healthcare provider to determine possible causes of underweight and if you need to gain weight.';
                }
                else if(parseFloat(this.data.bmi) > 18.5 && parseFloat(this.data.bmi) <= 24.99){
                    this.data.category = 'healthy';
                    this.data.result = 'Your BMI is '+this.data.bmi+', indicating your weight is in the Healthy category for adults of your height.<br><br>Maintaining a healthy weight may reduce the risk of chronic diseases associated with overweight and obesity.';
                }
                else if(parseFloat(this.data.bmi) > 25.0 && parseFloat(this.data.bmi) <= 29.99){
                    this.data.category = 'over';
                    this.data.result = 'Your BMI '+this.data.bmi+', indicating your weight is in the Overweight category for adults of your height. <br><br>People who are overweight or obese are at higher risk for chronic conditions such as high blood pressure, diabetes, and high cholesterol. <br><br>Anyone who is overweight should try to avoid gaining additional weight. Additionally, if you are overweight with other risk factors (such as high LDL cholesterol, low HDL cholesterol, or high blood pressure), you should try to lose weight. Even modest weight loss may help lower the risk of disease.';
                }
                else{
                    this.data.category = 'obese';
                    this.data.result = 'Your BMI is '+this.data.bmi+', indicating your weight is in the Obese category for adults of your height. <br><br>People who are overweight or obese are at higher risk for chronic conditions such as high blood pressure, diabetes, and high cholesterol. <br><br>Anyone who is overweight should try to avoid gaining additional weight. Additionally, if you are overweight with other risk factors (such as high LDL cholesterol, low HDL cholesterol, or high blood pressure), you should try to lose weight. Even modest weight loss may help lower the risk of disease.';
                }

                if(this.isRecord){
                    axios.post('/api/bmi/', this.data)
                    .then((res) => {
                        console.log('Result saved');
                    })
                    .catch((err) => {
                        console.log(err.response.data);
                    });
                }
            },
        },
        
        mounted() {
            //Get the context of the Chart canvas element we want to select
            var ctx = $("#line-chart");

            // Chart Options
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: "#f3f3f3",
                            drawTicks: false,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: "#f3f3f3",
                            drawTicks: false,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'BMI Chart'
                }
            };

            // Chart Data
            var chartData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: "My Third dataset - No bezier",
                    data: [45, 25, 16, 36, 67, 18, 76],
                    lineTension: 0,
                    fill: false,
                    borderColor: "#FF5722",
                    pointBorderColor: "#FF5722",
                    pointBackgroundColor: "#FFF",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                }]
            };

            var config = {
                type: 'line',

                // Chart Options
                options : chartOptions,

                data : chartData
            };

            // Create the chart
            var lineChart = new Chart(ctx, config);
        }
    }
</script>
