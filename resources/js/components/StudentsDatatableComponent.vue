<template>
    <div>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Students</h4>
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

                <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody>
                        <tr v-for="project in projects" :key="project.id">
                            <td><a :href="'/api/students/' + project.id">{{project.lname}}, {{project.name}}</a></td>
                            <td>{{project.email}}</td>
                            <td>{{project.gender}}</td>
                            <td>{{(project.section ? project.section.name : 'N/A')}}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" @click="deleteDataConfirm(project)" v-show="currentUser.role_id == 2"><span class="icon-android-delete"></span></button>
                                <button class="btn btn-info btn-sm" v-show="currentUser.role_id != 1" @click="editData(project)"><span class="icon-android-contacts"></span></button>
                                <a class="btn btn-info btn-sm" :href="'/api/students/' + project.id" v-show="currentUser.role_id == 1"><span class="icon-profile"> View Profile</span></a>
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
    <div class="modal-dialog modal-md" role="document">
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
                            <div v-html="notif.message"></div>
                        </div>
                        <div class="form-body">
                            <h4 class="form-section"><i class="icon-folder4"></i> Assign Section</h4>
                            
                            <div class="form-group">
                                <label for="userinput6">Section</label>
                                <select class="form-control border-primary" v-model="datas.section_id">
                                    <option value="">Select Section</option>
                                    <option v-for="section in sections" :value="section.id" :key="section.id">
                                        [{{ section.name }}]  {{section.description}}
                                    </option>
                                </select>
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
export default {
    props: ['user'],
    components: { datatable: Datatable, pagination: Pagination },
    created() {
        this.getProjects();

    },
    data() {
        let sortOrders = {};

        let columns = [
            { name: 'lname', label: 'Last name'},
            { name: 'email', label: 'Email'},
            { name: 'gender', label: 'Gender'},
            { name: 'section_id', label: 'Section'},
        ];

        columns.forEach((column) => {
           sortOrders[column.name] = -1;
        });
        return {
            currentUser: JSON.parse(this.user),
            projects: [],
            columns: columns,
            sortKey: 'name',
            sortOrders: sortOrders,
            showActionTable: true,
            perPage: ['10', '20', '30'],
            tableData: {
                draw: 0,
                length: 10,
                search: '',
                column: 0,
                dir: 'desc',
                type: 'students',
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
                section_id: '',
                student_id: '',

            },
            todo: 'Add',
            editableId: '',
            endPoint: '/api/students/',
            notif: {
                type: 'alert',
                message: '<strong>Oh snap!</strong> Change a <a href="#" class="alert-link">few things up</a> and try submitting again.',
                show: false,
                confirm: false,
                function: '',
            },
            errors: new Errors(),
            sections: this.sectionsFetch(),
        }
    },
    methods: {
        sectionsFetch(){
            axios.post('/api/sections/fetch')
            .then((res) => {
                this.sections = res.data
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
                this.datas[keys[a]] = '';
            }
            this.todo = 'Add';
            $('#dataModal').modal('hide');
        },

        dataModalOpen($id){
            this.datas.student_id = $id;
            $('#dataModal').modal('show');
        },

        saveData(){
                axios.patch(this.endPoint+'updateSection/'+this.datas.student_id, this.datas)
                .then((res) => {
                    this.showNotif('success', '<strong>Well done!</strong> You succefully updated the data.');
                    this.getProjects();
                    this.clearFields();
                })
                .catch((err) => {
                    this.errors.record(err.response.data);
                    this.showNotif('warning', '<strong>Warning!</strong><br>' + this.errors.get('name'));
                });
            
        },

        dataDelete(){
            axios.delete(this.endPoint+this.editableId)
            .then((res) => {
                this.getProjects();
                this.clearFields();
                this.showNotif('success', '<strong>Well done!</strong> You succefully deleted the data.');
            })
            .catch((err) => {
                console.log(err); 
            });
        },

        deleteDataConfirm(data){
            this.notif.confirm = true;
            this.notif.function = 'dataDelete';
            this.editableId = data.id;
            this.showNotif('warning', '<strong>Warning! </strong> You are about to delete data.');
        },
        editData(dataEdit){

            const keys = Object.keys(this.datas);
            for (var a = 0; a < keys.length; a++) {
                this.datas[keys[a]] = dataEdit[keys[a]];
            }
    
            this.datas.student_id = dataEdit.id;
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
    }
};
</script>
