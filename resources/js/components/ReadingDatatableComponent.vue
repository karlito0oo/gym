<template>
    <div>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Reading Comprehension</h4>
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
                <button type="button" class="btn btn-primary m-2" @click="dataModalOpen">
                    <i class="icon-plus"></i> ADD
                </button>

                <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody>
                        <tr v-for="project in projects" :key="project.id">
                            <td>{{project.title}}</td>
                            <td>{{project.description}}</td>
                            <td>{{project.difficulty}}</td>
                            <td>{{project.genre.name}}</td>
                            <td v-html="(project.data.length < 50 ? project.data : project.data.substring(0,50) + ' ...')"></td>
                            <td>
                                <button class="btn btn-warning btn-sm" @click="deleteDataConfirm(project)"><span class="icon-android-delete"></span></button>
                                <button class="btn btn-info btn-sm" @click="editData(project)"><span class="icon-edit"></span></button>
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
                            <h4 class="form-section"><i class="icon-folder4"></i> {{ todo }} Reading Comprehension</h4>

                            <div class="form-group">
                                <label for="userinput5">Title</label>
                                <input class="form-control border-primary" type="text" placeholder="Title" v-model="datas.title">
                            </div>

                            <div class="form-group">
                                <label for="userinput6">Description</label>
                                <input class="form-control border-primary" type="text" placeholder="Description" v-model="datas.description">
                            </div>

                            <div class="form-group">
                                <label for="userinput6">Genre</label>
                                <select class="form-control border-primary" v-model="datas.genre_id">
                                    <option value="">Select Genre</option>
                                    <option v-for="genre in genres" :value="genre.id" :key="genre.id">
                                        {{ genre.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="userinput6">Difficulty</label>
                                <select class="form-control border-primary" v-model="datas.difficulty">
                                    <option value="">Select difficulty</option>
                                    <option>Beginner</option>
                                    <option>Intermediate</option>
                                    <option>Advanced</option>
                                    <option>Expert</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="userinput6">Story</label>
                                <textarea class="form-control border-primary" name="ckEditorTextarea" id="storyTextarea" v-model="datas.data">
                                </textarea>
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
    components: { datatable: Datatable, pagination: Pagination },
    created() {
        this.getProjects();
    },
    data() {
        let sortOrders = {};

        let columns = [
            { name: 'title', label: 'Title' },
            { name: 'description', label: 'Description'},
            { name: 'difficulty', label: 'difficulty'},
            { name: 'genre_id', label: 'Genre'},
            { name: 'data', label: 'Story'},
        ];

        columns.forEach((column) => {
           sortOrders[column.name] = -1;
        });
        return {
            projects: [],
            columns: columns,
            sortKey: 'title',
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
                title: '',
                description: '',
                data: '',
                genre_id: '',
                difficulty: '',

            },
            todo: 'Add',
            editableId: '',
            endPoint: '/api/readings/',
            notif: {
                type: 'alert',
                message: '<strong>Oh snap!</strong> Change a <a href="#" class="alert-link">few things up</a> and try submitting again.',
                show: false,
                confirm: false,
                function: '',
            },
            notifTimeout: 5,
            errors: new Errors(),
            genres: this.genresFetch(),
        }
    },
    methods: {
        genresFetch(){
            axios.post('/api/genres/fetch')
            .then((res) => {
                this.genres = res.data
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

        dataModalOpen(){
            this.clearFields();
            $('#dataModal').modal('show');
        },

        saveData(){
            this.datas.data = CKEDITOR.instances.storyTextarea.getData();
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
            CKEDITOR.instances.storyTextarea.setData(dataEdit.data)

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
    mounted(){
        CKEDITOR.replace('storyTextarea')
    }
};
</script>
