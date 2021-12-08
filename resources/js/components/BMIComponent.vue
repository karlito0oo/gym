<template>
    <div>
        <a href="#" class="floatingBtn" data-toggle="modal" data-target="#dictionaryModal">
            <br>
            <i class="MyFloatingBtn"> B M I</i>
        </a>
        
        
        <!-- Modal -->
        <div class="modal fade text-xs-left" id="dictionaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Adult BMI Calculator</h4>
                </div>
                <div class="modal-body">
                    <label><h4>Height</h4></label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control border-primary col-md-6" placeholder="Feet" v-model="data.feets">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control border-primary col-md-6" placeholder="Inch" v-model="data.inches">
                        </div>
                    </div>
                    <br>
                    <label><h4>Weight</h4></label>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control border-primary col-md-6" placeholder="Kilo" v-model="data.kilos">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Record result</label>
                        <div class="input-group">
                            <label class="display-inline-block custom-control custom-radio ml-1">
                                <input type="radio" name="customer1" class="custom-control-input" :checked="(isRecord ? 'true' : 'false')" @click="isRecord=true">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description ml-0">Yes</span>
                            </label>
                            <label class="display-inline-block custom-control custom-radio">
                                <input type="radio" name="customer1" :checked="(!isRecord ? 'true' : 'false')" class="custom-control-input" @click="isRecord=false">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description ml-0">No</span>
                            </label>
                        </div>
                    </div>

                    <hr>
                    <div v-if="data.result != ''">
                        <label><h4>Result</h4></label>
                        <div class="row">
                            <div class="col-md-6">
                                <span v-html="data.result"></span>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>BMI</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr :style="(data.category == 'under' ? 'background-color: green' : '')">
                                            <td>Below 18.5</td>
                                            <td>Underweight</td>
                                        </tr>
                                        <tr :style="(data.category == 'healthy' ? 'background-color: green' : '')">
                                            <td>18.5—24.9</td>
                                            <td>Healthy</td>
                                        </tr>
                                        <tr :style="(data.category == 'over' ? 'background-color: green' : '')">
                                            <td>25.0—29.9</td>
                                            <td>Overweight</td>
                                        </tr>
                                        <tr :style="(data.category == 'obese' ? 'background-color: green' : '')">
                                            <td>30.0 and Above</td>
                                            <td>Obese</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="calculate">
                        <i class="icon-calculator"></i> Calculate
                    </button>
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
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
            console.log('Component mounted.')
        }
    }
</script>
