<template>
    <div class="p-2">
        <!-- Notif -->
        <div :class="'alert alert-'+notif.type +''" role="alert" v-show="notif.show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div><span v-html="notif.message"></span><span v-show="notif.confirm"> Click <a @click="handle_function_call(notif.function)" class="alert-link">here</a> to proceed.</span></div>
            
        </div>
        <FullCalendar 
            :options="calendarOptions" 
        />
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
                        <div class="form-body">
                            <h4 class="form-section"><i class="icon-folder4"></i> {{ todo }} Event</h4>

                            <!-- <div class="form-group">
                                <label for="userinput5">Title</label>
                                <input readonly class="form-control border-primary" type="text" placeholder="name" v-model="event.title" required>
                            </div> -->

                            
                            <div class="form-group">
                                <label for="userinput5">Capacity</label>
                                <input class="form-control border-primary" type="number" placeholder="name" v-model="event.capacity" required>
                            </div>

                            <!-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="userinput5">Date Start</label>
                                    <input class="form-control border-primary" type="date" placeholder="name" v-model="event.start" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="userinput5">Date End</label>
                                    <input class="form-control border-primary" type="date" placeholder="name" v-model="event.end" required>
                                    </div>
                                </div>
                            </div> -->
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="userinput5">Time Start</label>
                                    <input class="form-control border-primary" type="time" placeholder="name" v-model="event.timeStart" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="userinput5">Time End</label>
                                    <input class="form-control border-primary" type="time" placeholder="name" v-model="event.timeEnd" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row" v-if="editableId">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="user in event.users" :key="user.id">
                                                <td>{{user.lname + ', ' + user.name}}</td>
                                                <td>{{user.email}}</td>
                                                <td>
                                                    <a :class="'btn btn-success btn-sm ' + (user.pivot.status != 'pending' ? 'disabled' : '')" @click="approveReservation(user.id)"><span data-toggle="tooltip" data-placement="left" title="" data-original-title="Approve Reservation">Approve</span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <slot></slot>
                                    </table>
                                </div>
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
                <button type="button" class="btn btn-danger ml-1" v-show="todo=='Edit'" @click="deleteDataConfirm">
                    <i class="icon-trash"></i> Delete
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
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
var moment = require('moment');
    export default {
        components: {
            FullCalendar, // make the <FullCalendar> tag available
        },
        props: {
            user: {
                type: Object
            }
        },
        data() {
            return {
                moment: moment,
                calendarOptions: {
                    plugins: [ dayGridPlugin, interactionPlugin ],
                    initialView: 'dayGridMonth',
                    eventClick: this.showEvent,
                    select: this.addEvent,
                    events: this.fetchEvents(),
                    selectable: true,
                },
                event:{
                    title: '',
                    start: '',
                    end: '',
                    timeStart: '',
                    timeEnd: '',
                    capacity: 0,
                    id: '',
                    users: [],
                },
                todo: 'Add',
                editableId: '',
                notif: {
                    type: 'alert',
                    message: '<strong>Oh snap!</strong> Change a <a href="#" class="alert-link">few things up</a> and try submitting again.',
                    show: false,
                    confirm: false,
                    function: '',
                },
            }
        },

        methods: {
            deleteDataConfirm(){
                $('#dataModal').modal('hide');
                this.notif.confirm = true;
                this.notif.function = 'dataDelete';
                this.showNotif('warning', '<strong>Warning! </strong> You are about to delete data.');
                
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
                        axios.delete('/api/calendars/'+this.editableId)
                        .then((res) => {
                            this.fetchEvents();
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
            dataDelete(){
                axios.delete('/api/calendars/'+this.editableId)
                .then((res) => {
                    this.fetchEvents();
                    this.clearFields();
                    this.showNotif('success', '<strong>Well done!</strong> You succefully deleted an event.');
                })
                .catch((err) => {
                    console.log(err); 
                });
            },
            fetchEvents(){
                axios.get('/api/calendars')
                .then((res) => {
                    this.calendarOptions.events = res.data.data;
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

            saveData(){
                if(this.todo == 'Add'){
                    axios.post('/api/calendars/', this.event)
                    .then((res) => {
                       
                        Swal.fire(
                            'Saved!',
                            'You succefully added schedule.',
                            'success'
                        )

                        this.fetchEvents();
                        this.clearFields();
                    })
                    .catch((err) => {
                        this.errors.record(err.response.data);
                        this.showNotif('warning', '<strong>Warning!</strong><br>' + this.errors.get('name'));
                    });
                }
                else if(this.todo == 'Edit'){
                    axios.patch('/api/calendars/'+this.editableId, this.event)
                    .then((res) => {
                        
                        Swal.fire(
                            'Updated!',
                            'You succefully updated schedule.',
                            'success'
                        )

                        this.fetchEvents();
                        this.clearFields();
                    })
                    .catch((err) => {
                        this.errors.record(err.response.data);
                        this.showNotif('warning', '<strong>Warning!</strong><br>' + this.errors.get('name'));
                    });
                }
                $('#dataModal').modal('hide');
                
            },

            approveReservation(user_id){
                this.event.user_id = user_id;
                axios.post('/api/calendars/approve/', this.event)
                .then((res) => {
                    this.fetchSelectedEvent();
                    this.fetchEvents();
                })
                .catch((err) => {
                    this.errors.record(err.response.data);
                });
                
            },

            clearFields(){
                this.todo = 'Add';
                this.event.title = '';
                this.event.start = '';
                this.event.end = '';
                this.event.timeStart = '';
                this.event.timeEnd = '';
                this.event.capacity = 0;
                this.editableId = '';
            },

            addEvent(args){
                if(this.user.userRole == 'admin'){
                    this.clearFields();
                    this.event.start = this.moment(args.start).format('YYYY-MM-DD');
                    this.event.end = this.moment(args.end).format('YYYY-MM-DD');
                    $('#dataModal').modal('show');
                }
            },

            fetchSelectedEvent(){
                axios.get('/api/calendars/'+this.editableId)
                .then((res) => {
                    this.event = res.data.data
                })
                .catch((err) => {
                    console.log(err);
                });
            },

            showEvent(args){
                this.event.title = args.event.title;
                this.event.start = this.moment(args.event.start).format('YYYY-MM-DD');
                this.event.end = (args.event.end == null ? this.moment(args.event.start).format('YYYY-MM-DD') : this.moment(args.event.end).format('YYYY-MM-DD'));
                this.event.timeStart = args.event.timeStart;
                this.event.timeEnd = args.event.timeEnd;
                this.event.id = args.event.id;
                this.editableId = args.event.id;

                console.log(args.event);

                var eventStart = this.moment(args.event.start).format('YYYY-MM-DD');

                var isPast = moment(moment().format('YYYY-MM-DD')).isAfter(eventStart);

                if(this.user.userRole == 'admin'){
                    this.todo = 'Edit';
                    this.fetchSelectedEvent();

                    $('#dataModal').modal('show');
                }
                else if(isPast){
                    Swal.fire(
                        'Oppppps!',
                        'You cannot book this slot anymore.',
                        'warning'
                    )
                }
                else if(this.user.userRole == 'member'){
                    console.log(args.event);
                    if(args.event.backgroundColor == '#2196f3'){
                        Swal.fire({
                            title: args.event.title,
                            text: "Book this slot?",
                            icon: 'default',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, book it!'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                axios.post('/api/calendars/reserve', this.event)
                                .then((res) => {
                                    this.fetchEvents();
                                })
                                .catch((err) => {
                                    console.log(err); 
                                });

                                Swal.fire(
                                'Yehey!',
                                'You successfully booked this slot.',
                                'success'
                                )
                            }
                        })
                    }
                    else if(args.event.backgroundColor == '#e91e62' || args.event.backgroundColor == '#4caf4f'){
                        Swal.fire({
                            title: args.event.title,
                            text: "Cancel "+ (args.event.backgroundColor == '#e91e62' ? "booking" : "reservation") +" for this slot?",
                            icon: 'default',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, cancel it!'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                axios.get('/api/calendars/cancel/'+this.event.id)
                                .then((res) => {
                                    this.fetchEvents();
                                })
                                .catch((err) => {
                                    console.log(err); 
                                });

                                Swal.fire(
                                'Yehey!',
                                'You successfully cancel '+ args.event.backgroundColor == '#e91e62' ? "booking" : "reservation" +' for this slot.',
                                'success'
                                )
                            }
                        })
                    }
                    
                }
                

                
            },
            handle_function_call(function_name) {
                this[function_name]()
            },
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
