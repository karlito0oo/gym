<template>
    <div>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Members</h4>
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
                            <td>
                                <button class="btn btn-warning btn-sm" @click="deleteDataConfirm(project)"><span data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete user" class="icon-android-delete"></span></button>
                                <button class="btn btn-info btn-sm" @click="changeType(project)"><span class="icon-android-people" data-toggle="tooltip" data-original-title="Change User Type" ></span></button>
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
<form class="form" @submit.prevent="changeUserType()">
<div class="modal fade text-xs-left" id="changeUserTypeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
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
                            <h4 class="form-section"><i class="icon-folder4"></i> Change User Type</h4>
                            
                            <div class="form-group">
                                <label for="userinput6">User Type</label>
                                <select class="form-control border-primary" v-model="datas.user_type" required>
                                    <option value="">Select Section</option>
                                    <option value="2">Member</option>
                                    <option value="1">Super Admin</option>
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
            { name: 'lname', label: 'Name'},
            { name: 'email', label: 'Email'},
            { name: 'gender', label: 'Gender'},
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
                user_type: '',

            },
            todo: 'Add',
            editableId: '',
            endPoint: '/api/members/',
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
        changeType(user){
            this.editableId = user.id;
            this.datas.user_type = user.role_id;
            $('#changeUserTypeModal').modal('show');
        },
        changeUserType(){
                axios.patch(this.endPoint+'updateUserType/'+this.editableId, this.datas)
                .then((res) => {
                    Swal.fire(
                        'Updated!',
                        'You succefully updated user type.',
                        'success'
                    )
                    this.getProjects();
                    this.clearFields();
                    $('#changeUserTypeModal').modal('hide');
                })
                .catch((err) => {
                    this.errors.record(err.response.data);
                    this.showNotif('warning', '<strong>Warning!</strong><br>' + this.errors.get('name'));
                });
            
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

        deleteDataConfirm(data){
            this.notif.confirm = true;
            this.notif.function = 'dataDelete';
            this.editableId = data.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(this.endPoint+this.editableId)
                    .then((res) => {
                        this.getProjects();
                        this.clearFields();
                    })
                    .catch((err) => {
                        console.log(err); 
                    });

                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                }
            })
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
