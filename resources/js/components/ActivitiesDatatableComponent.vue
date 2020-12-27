<template>
    <div>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Activities</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <!-- Alerts -->
                <div :class="'alert alert-'+notif.type +''" role="alert" v-show="notif.show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div><span v-html="notif.message"></span><span v-show="notif.confirm"> Click <a @click="handle_function_call(notif.function)" class="alert-link">here</a> to proceed.</span></div>
                </div>
                <!-- Add button -->
                <button type="button" class="btn btn-primary m-2" @click="dataModalOpen" v-show="currentUser.role_id != '1'">
                    <i class="icon-plus"></i> ADD
                </button>

                <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody>
                        <tr v-for="project in projects" :key="project.id">
                            <td>{{project.name}}</td>
                            <td>{{project.type}}</td>
                            <td>{{moment(project.dateStart + ' ' + project.dateStartTime).format('MMMM DD, YYYY LT')}}</td>
                            <td>{{moment(project.dateEnd + ' ' + project.dateEndTime).format('MMMM DD, YYYY LT')}}</td>
                            <td>
                                <li v-for="section in project.sections" :key="section.id">{{ section.name }}</li>
                            </td>
                            <!-- Admin or Instructor -->
                            <td v-show="currentUser.role_id != '1'">
                                <button class="btn btn-warning btn-sm" @click="deleteDataConfirm(project, 'activity')"><span class="icon-android-delete"></span></button>
                                <button class="btn btn-info btn-sm" @click="editData(project)"><span class="icon-edit"></span></button>
                            </td>
                            <!-- Student -->
                            <td v-show="currentUser.role_id == '1'">
                                <a :href="'/api/activities/'+project.id" :class="'btn btn-success btn-sm ' + isDisabledLink(project)" v-show="project.type == 'Reading Comprehension'">
                                    <span class="icon-book"></span> Read {{ (project.readers.length > 0 ? '(' + project.readers.length + ')' : '') }}
                                </a>
                                <a :href="(project.answered.length == 0 ? '/api/activities/'+project.id : '/home/activities/activity-result/'+project.id+'/'+currentUser.id)" :class="'btn btn-success btn-sm ' + isDisabledLink(project)" v-show="project.type != 'Reading Comprehension'">
                                    <span class="icon-android-clipboard"></span> {{(project.answered.length == 0 ? 'Answer' : 'View Result')}}
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </datatable>
                <pagination :pagination="pagination"
                            @prev="getProjects(pagination.prevPageUrl)"
                            @next="getProjects(pagination.nextPageUrl)">
                </pagination>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<form class="form" @submit.prevent="saveData()">
<div class="modal fade text-xs-left" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
<div class="row match-height">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body collapse in">
                <div class="card-block">
                    
                       <!-- Alerts -->
                        <div :class="'alert alert-'+notif.type +''" role="alert" v-show="notif.show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <div><span v-html="notif.message"></span><span v-show="notif.confirm"> Click <a @click="handle_function_call(notif.function)" class="alert-link">here</a> to proceed.</span></div>
                            
                        </div>
                        <div class="form-body">
                            <h4 class="form-section"><i class="icon-folder4"></i> {{ todo }} Activity</h4>

                            <div class="form-group">
                                <label for="userinput6">Activity Type</label>
                                <select class="form-control border-primary" v-model="datas.type" @change="activityTypeChanged">
                                    <option value="">Select type</option>
                                    <option>Activity</option>
                                    <option>Quiz</option>
                                    <option>Examination</option>
                                    <option>Reading Comprehension</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="userinput5">Name</label>
                                <input class="form-control border-primary" type="text" placeholder="name" v-model="datas.name">
                            </div>

                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="userinput5">Date Start</label>
                                    <input class="form-control border-primary" type="date" placeholder="name" v-model="datas.dateStart">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userinpuasdt5">Time</label>
                                        <input class="form-control border-primary" type="time" placeholder="name" v-model="datas.dateStartTime">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="userinput5">Date End</label>
                                    <input class="form-control border-primary" type="date" placeholder="name" v-model="datas.dateEnd">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userinpuasdt5">Time</label>
                                        <input class="form-control border-primary" type="time" placeholder="name" v-model="datas.dateEndTime">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="userinput6">Sections</label>
                                <select class="form-control border-primary" v-model="datas.sections" multiple>
                                    <option value="" disabled>Select Sections</option>
                                    <option v-for="section in sections" :value="section.id" :key="section.id">
                                        {{ section.name }}
                                    </option>
                                </select>
                            </div>
                            
                            <div v-show="!datas.isReading">
                                <div class="input-group">
                                    <select class="form-control border-primary" v-model="questionToAdd">
                                        <option value="" disabled>Search question</option>
                                        <option v-for="question in questions" :value="question" :key="question.id">
                                            {{ question.question }}
                                        </option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" @click="addQuestion">
                                            <i class="icon-plus"></i> Add
                                        </button>
                                    </span>
                                </div>
                                <br>
                                <activity-question ref="ActivityQuestion"></activity-question>
                            </div>

                             <div v-show="datas.isReading">
                                <div class="input-group">
                                    <select class="form-control border-primary" v-model="readingToAdd">
                                        <option value="" disabled>Search reading Comprehension</option>
                                        <option v-for="reading in readings" :value="reading" :key="reading.id">
                                            {{ reading.title }} {{ reading.description }}
                                        </option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" @click="addReading">
                                            <i class="icon-plus"></i> Add
                                        </button>
                                    </span>
                                </div>
                                <br>
                                <reading-comprehension-table ref="ActivityReadingComprehension"></reading-comprehension-table>
                            </div>
                            
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
        <div class="modal-footer">
            <div class="form-actions right">
                <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">
                    <i class="icon-cross2"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="icon-check2"></i> Save
                </button>
            </div>
        </div>
    </div>
    </div>
</div>
</form>



    </div>
</template>

<script>

class Errors{
    constructor(){
        this.errors = {};
    }
    get(field){
        const keys = Object.keys(this.errors);

        var err = '';
        for (var a = 0; a < keys.length; a++) {
            err += this.errors[keys[a]] + "<br>";
        }
        return err;
    }
    record(errors){
        this.errors = errors.errors
    }
}

import Datatable from './Datatables.vue';
import Pagination from './DatatablePagination.vue';
import ActivityQuestion from './ActivityQuestionComponent.vue';
import ActivityReadingComprehension from './ActivityReadingComprehensionComponent.vue';
import datetime from 'vuejs-datetimepicker';
var moment = require('moment');
export default {
    
    props: ['user'],

    components: { datatable: Datatable, pagination: Pagination, datetime, 'reading-comprehension-table': ActivityReadingComprehension, 'activity-question': ActivityQuestion},
    created() {
        this.getProjects();
    },
    data() {
        let sortOrders = {};

        let columns = [
            { name: 'name', label: 'Name' },
            { name: 'type', label: 'Type'},
            { name: 'dateStart', label: 'Date Start'},
            { name: 'dateEnd', label: 'Date End'},
            { name: '', label: 'Sections'},
        ];

        columns.forEach((column) => {
           sortOrders[column.name] = -1;
        });
        return {
            moment: moment,
            projects: [],
            columns: columns,
            sortKey: 'dateStart',
            sortOrders: sortOrders,
            showActionTable: true,
            perPage: ['10', '20', '30'],
            tableData: {
                draw: 0,
                length: 10,
                search: '',
                column: 0,
                dir: 'desc',
            },
            pagination: {
                lastPage: '',
                currentPage: '',
                total: '',
                lastPageUrl: '',
                nextPageUrl: '',
                prevPageUrl: '',
                from: '',
                to: ''
            },
            datas: {
                name: '',
                type: '',
                dateStart: '',
                dateEnd: '',
                dateStartTime: '',
                dateEndTime: '',
                sections: [],
                questions: [],
                readings: [],
                isReading: false,
            },
            todo: 'Add',
            editableId: '',
            deletableId: '',
            endPoint: '/api/activities/',
            notif: {
                type: 'alert',
                message: '<strong>Oh snap!</strong> Change a <a href="#" class="alert-link">few things up</a> and try submitting again.',
                show: false,
                confirm: false,
                function: '',
            },
            errors: new Errors(),
            sections: this.sectionsFetch(),
            questions: this.questionsFetch(),
            readings: this.readingsFetch(),
            questionToAdd: '',
            readingToAdd: '',
            currentUser: JSON.parse(this.user),
        }
    },
    methods: {

        isDisabledLink(project){
            var currentDate = moment().format('YYYY-MM-DD HH:mm:ss');
            var startDateTime = moment(project.dateStart + ' ' + project.dateStartTime).format('YYYY-MM-DD HH:mm:ss');
            var endDateTime = moment(project.dateEnd + ' ' + project.dateEndTime).format('YYYY-MM-DD HH:mm:ss');
            if(startDateTime <= currentDate && endDateTime >= currentDate){
                return '';
            }
            else{
                if(project.answered.length == 0){
                    return 'disabled';
                }
                else{
                    return '';
                }
            }
        },

        containsObject(obj, list) {
            var x;
            for (x in list) {
                if (list.hasOwnProperty(x) && list[x] === obj) {
                    return true;
                }
            }

            return false;
        },

        activityTypeChanged(){
            if(this.datas.type == 'Reading Comprehension'){
                this.datas.isReading = true;
                this.$refs.ActivityReadingComprehension.reloadReadings(this.datas.readings);
            }
            else{
                this.datas.isReading = false;
                this.$refs.ActivityQuestion.reloadQuestions(this.datas.questions);
            }
        },

        addQuestion(){
            if(!this.containsObject(this.questionToAdd, this.datas.questions) && this.questionToAdd != ''){
                this.datas.questions.push(this.questionToAdd);
                this.$refs.ActivityQuestion.reloadQuestions(this.datas.questions);
                this.questionToAdd = '';
                this.showNotif('success', '<strong>Well done!</strong> You succefully added the question.');
            }
            else if(this.containsObject(this.questionToAdd, this.datas.questions)){
                this.showNotif('warning', '<strong>Warning! </strong> Question already added to list.');
            }
            else{
                this.showNotif('warning', '<strong>Warning! </strong> No question selected.');
            }
            
        },

        addReading(){
            if(!this.containsObject(this.readingToAdd, this.datas.readings) && this.readingToAdd != ''){
                this.datas.readings.push(this.readingToAdd);
                this.$refs.ActivityReadingComprehension.reloadReadings(this.datas.readings);
                this.readingToAdd = '';
                this.showNotif('success', '<strong>Well done!</strong> You succefully added the question.');
            }
            else if(this.containsObject(this.readingToAdd, this.datas.readings)){
                this.showNotif('warning', '<strong>Warning! </strong> Question already added to list.');
            }
            else{
                this.showNotif('warning', '<strong>Warning! </strong> No question selected.');
            }
            
        },

        sectionsFetch(){
            axios.post('/api/sections/fetch')
            .then((res) => {
                this.sections = res.data
            })
            .catch((err) => {
                console.log(err);
            });
        },

        readingsFetch(){
            axios.post('/api/readings/fetch')
            .then((res) => {
                this.readings = res.data
            })
            .catch((err) => {
                console.log(err);
            });
        },

        questionsFetch(){
            axios.post('/api/questions/fetch')
            .then((res) => {
                this.questions = res.data
            })
            .catch((err) => {
                console.log(err);
            });
        },

        showNotif(type, message){
            this.notif.type = type;
            this.notif.message = message;
            this.notif.show = true;

            setTimeout(() => {
                this.notif.show = false;
                this.notif.confirm = false;
            }, 5000)
        },

        clearFields(){
            const keys = Object.keys(this.datas);
            for (var a = 0; a < keys.length; a++) {
                if(keys[a] == 'sections' || keys[a] == 'questions' || keys[a] == 'readings'){
                    this.datas[keys[a]] = [];
                    this.$refs.ActivityReadingComprehension.reloadReadings(this.datas.readings);
                    this.$refs.ActivityQuestion.reloadQuestions(this.datas.questions);
                }
                else{
                    this.datas[keys[a]] = '';
                }
            }
            this.todo = 'Add';
            $('#dataModal').modal('hide');
        },

        dataModalOpen(){
            this.clearFields();
            $('#dataModal').modal('show');
        },

        saveData(){
            if(this.todo == 'Add'){
                axios.post(this.endPoint, this.datas)
                .then((res) => {
                    this.showNotif('success', '<strong>Well done!</strong> You succefully saved the data.');
                    this.getProjects();
                    this.clearFields();
                })
                .catch((err) => {
                    this.errors.record(err.response.data);
                    this.showNotif('warning', '<strong>Warning!</strong><br>' + this.errors.get('name'));
                });
            }
            else if(this.todo == 'Edit'){
                axios.patch(this.endPoint+this.editableId, this.datas)
                .then((res) => {
                    this.showNotif('success', '<strong>Well done!</strong> You succefully updated the data.');
                    this.getProjects();
                    this.clearFields();
                })
                .catch((err) => {
                    this.errors.record(err.response.data);
                    this.showNotif('warning', '<strong>Warning!</strong><br>' + this.errors.get('name'));
                });
            }
            
        },

        dataDelete(){
            axios.delete(this.endPoint+this.deletableId)
            .then((res) => {
                this.getProjects();
                this.clearFields();
                this.showNotif('success', '<strong>Well done!</strong> You succefully deleted the data.');
            })
            .catch((err) => {
                console.log(err); 
            });
        },

        removeQuestion(){
            var removeIndex = this.datas.questions.map(function(item) { return item.id; }).indexOf(this.deletableId);
            this.datas.questions.splice(removeIndex, 1);
            this.$refs.ActivityQuestion.reloadQuestions(this.datas.questions);
                this.showNotif('success', '<strong>Well done!</strong> You succefully removed the question.');
        },

        removeReading(){
            var removeIndex = this.datas.readings.map(function(item) { return item.id; }).indexOf(this.deletableId);
            this.datas.readings.splice(removeIndex, 1);
            this.$refs.ActivityReadingComprehension.reloadReadings(this.datas.readings);
                this.showNotif('success', '<strong>Well done!</strong> You succefully removed the reading comprehension.');
        },

        deleteDataConfirm(data, type = null){
            this.notif.confirm = true;
            if(type == 'activity'){
                this.notif.function = 'dataDelete';
            }
            else if(type == 'readings'){
                this.notif.function = 'removeReading';
            }
            else{
                this.notif.function = 'removeQuestion';
            }
            this.deletableId = data.id;
            this.showNotif('warning', '<strong>Warning! </strong> You are about to delete data.');
        },
        editData(dataEdit){
            this.clearFields();
            const keys = Object.keys(this.datas);
            for (var a = 0; a < keys.length; a++) {
                if(keys[a] != 'sections'){
                    this.datas[keys[a]] = dataEdit[keys[a]];
                }
            }

            dataEdit.sections.forEach((section) => {
                this.datas.sections.push(section.id);
            });

            if(dataEdit.type == 'Reading Comprehension'){
                this.datas.isReading = true;
                this.datas.readings = dataEdit.readings;
                this.$refs.ActivityReadingComprehension.reloadReadings(this.datas.readings);
            }
            else{
                this.datas.isReading = false;
                this.datas.questions = dataEdit.questions;
                this.$refs.ActivityQuestion.reloadQuestions(this.datas.questions);
            }

            

            this.editableId = dataEdit.id;
            this.todo = 'Edit';
            $('#dataModal').modal('show');
        },

        getProjects() {
            this.tableData.draw++;
            axios.get(this.endPoint, {params: this.tableData})
                .then(response => {
                    let data = response.data;
                    if (this.tableData.draw == data.draw) {
                        this.projects = data.data.data;
                        this.configPagination(data.data);
                    }

                    if(this.pagination.total == 0){
                        this.showNotif('warning', '<strong>Warning!</strong> No data found!.');
                    }
                })
                .catch(errors => {
                    console.log(errors);
                });
        },
        configPagination(data) {
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, 'name', key);
            this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
            this.getProjects();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value)
        },
        handle_function_call(function_name) {
            this[function_name]()
        },
    },
};
</script>
