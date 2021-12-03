<template>
    <div>
                <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody>
                        <tr v-for="project in projects" :key="project.id">
                            <td><a :href="'/api/students/' + project.id">{{project.lname}}, {{project.name}}</a></td>
                            <td>{{convertTime(project)}}</td>
                            <td>PENDING</td>
                            <td>
                                <button class="btn btn-success btn-sm" @click="approveReservation(project)"><span data-toggle="tooltip" data-placement="left" title="" data-original-title="Approve Registration" class="icon-check"></span></button>
                            </td>
                        </tr>
                        <tr v-if="!projects.length">
                            <td colspan="4">
                               <center>NO DATA FOUND.</center>
                            </td>
                        </tr>
                    </tbody>
                </datatable>
                <pagination :pagination="pagination"
                            @prev="getProjects(pagination.prevPageUrl)"
                            @next="getProjects(pagination.nextPageUrl)">
                </pagination>



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
import moment from 'moment';
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
            { name: 'start', label: 'Date'},
            { name: 'status', label: 'Status'},
        ];

        columns.forEach((column) => {
           sortOrders[column.name] = -1;
        });
        return {
            projects: [],
            columns: columns,
            sortKey: 'start',
            sortOrders: sortOrders,
            showActionTable: true,
            perPage: ['10', '20', '30'],
            tableData: {
                draw: 0,
                length: 10,
                search: '',
                column: 0,
                dir: 'asc',
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
            endPoint: '/api/dt/reservations',
            event: {},
        }
    },
    methods: {

        approveReservation(project){
            self = this;
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
            }).then((result) => {
            if (result.isConfirmed) {

                self.event.id = project.calendarID;
                self.event.user_id = project.userID;

                axios.post('/api/calendars/approve/', self.event)
                .then((res) => {
                    self.getProjects();
                    Swal.fire(
                        'Approved!',
                        'Reservation has been approved.',
                        'success'
                    );
                })
                .catch((err) => {
                    console.log(err.response.data);
                });


                
            }
            })
        },

        convertTime(project){
            
            return moment(project.start + ' ' + project.timeStart).format("ddd, MMM Do YYYY, h:mm a");
            
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
        getProjects() {
            this.tableData.draw++;
            axios.get(this.endPoint, {params: this.tableData})
                .then(response => {
                    let data = response.data;
                    if (this.tableData.draw == data.draw) {
                        this.projects = data.data.data;
                        this.configPagination(data.data);
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
