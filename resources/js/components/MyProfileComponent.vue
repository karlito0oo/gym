<template>
    <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
			<div class="card-header no-border text-xs-center">
				<img v-bind:src="'/images/' + (currentUser.profilePicture ? 'studentImage/' + currentUser.profilePicture : 'defaultuser.png')" alt="unlock-user" class="rounded-circle img-fluid center-block" style="height: 300px; width: 300px;">
				<h5 class="card-title mt-1">{{ currentUser.lname + ", " + currentUser.name }}</h5>

                <form @submit.prevent="uploadImage">
                    <input id="imageFile" type="file" @change="imageChanged" accept="image/*" style="display:none;">
                </form>
			</div>

			<p class="card-subtitle line-on-side text-muted text-xs-center font-small-3 mx-2" style="cursor: pointer;" onclick="$('#imageFile').click()"><span>Change your profile picture</span></p>
            
                <!-- Alerts -->
                <div :class="'alert alert-'+notif.type +''" role="alert" v-show="notif.show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div><span v-html="notif.message"></span><span v-show="notif.confirm"> Click <a @click="handle_function_call(notif.function)" class="alert-link">here</a> to proceed.</span></div>
                </div>

            <div class="card-block">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" aria-controls="active" aria-expanded="true">Social Wall</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="myactivity-tab" data-toggle="tab" href="#myactivity" aria-controls="link">My Activity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#myaccount" aria-controls="linkOpt" id="myaccount-tab">My Account</a>
                    </li>
                </ul>
                <div class="tab-content px-1 pt-1">
                    <!-- Social Wall -->
                    <div role="tabpanel" class="tab-pane fade active in" id="active" aria-labelledby="active-tab" aria-expanded="true">
                        <div class="input-group">
                            <textarea id="userinput8" rows="2" class="form-control border-primary" placeholder="What's on your mind?" v-model="post.body"></textarea>

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" style="height: 57px" @click="submitPost">
                                    <i class="icon-compose"></i> Post
                                </button>
                            </span>
                        </div>
                        <br>
                        <hr>
                        <div class="media-list">
                            <div id="postBody" v-for="post in socialwall" :key="post.id">
                                <div class="media">
                                    <a class="media-left" href="#">
                                        <img v-bind:src="'/images/' + (post.posted_by.profilePicture ? 'studentImage/' + post.posted_by.profilePicture : 'defaultuser.png')" class="media-object" alt="Generic placeholder image" style="width: 64px;height: 64px;">
                                    </a>
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="media-heading">{{post.posted_by.name + ' ' + post.posted_by.lname}}{{(post.owner_id != post.for_user_id ? ' -> ' + post.for_user.name + ' ' + post.for_user.lname: '')}}</h4>
                                            </div>
                                            <div class="col-md-6" style="text-align:right">
                                                <small><i>{{moment(post.created_at).format('MMMM DD, YYYY LT')}}</i></small>
                                            </div>
                                        </div>
                                        {{post.body}}
                                    </div>
                                </div>
                                <hr>
                            </div>
						</div>
                    </div>
                    <!-- My Activity -->
                    <div role="tabpanel" class="tab-pane fade" id="myactivity" aria-labelledby="myactivity-tab" aria-expanded="true">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-block">
                                            <div class="media">
                                                <div class="media-body text-xs-left">
                                                    <h3 class="pink">{{ currentUser.answeredActivityCount }}</h3>
                                                    <span>Answered Activity</span>
                                                </div>
                                                <div class="media-right media-middle">
                                                    <i class="icon-bag2 pink font-large-2 float-xs-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-block">
                                            <div class="media">
                                                <div class="media-body text-xs-left">
                                                    <h3 class="teal">{{ currentUser.studentSameSectionCount }}</h3>
                                                    <span>Students in same section</span>
                                                </div>
                                                <div class="media-right media-middle">
                                                    <i class="icon-user1 teal font-large-2 float-xs-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-block">
                                            <div class="media">
                                                <div class="media-body text-xs-left">
                                                    <h3 class="deep-orange">{{ currentUser.averageScore }} %</h3>
                                                    <span>Average Score</span>
                                                </div>
                                                <div class="media-right media-middle">
                                                    <i class="icon-diagram deep-orange font-large-2 float-xs-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-block">
                                            <div class="media">
                                                <div class="media-body text-xs-left">
                                                    <h3 class="cyan">{{ currentUser.upcomingActivityCount }}</h3>
                                                    <span>Upcoming Activities</span>
                                                </div>
                                                <div class="media-right media-middle">
                                                    <i class="icon-ios-help-outline cyan font-large-2 float-xs-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- My account -->
                    <div class="tab-pane fade" id="myaccount" role="tabpanel" aria-labelledby="myaccount-tab" aria-expanded="false">
                        <div class="card-body collapse in">
                        <div class="card-block">
                            <form class="form" @submit.prevent="updateProfile()">
                                <div class="form-body">
                                    <h4 class="form-section"><i class="icon-head"></i> Personal Info</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">First Name</label>
                                                <input type="text" id="projectinput1" class="form-control" placeholder="First Name" name="fname" v-model="currentUser.name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">Last Name</label>
                                                <input type="text" id="projectinput2" class="form-control" placeholder="Last Name" name="lname" v-model="currentUser.lname">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput3">Birthday</label>
                                                <input type="date" id="projectinput3" class="form-control" placeholder="Birthday" v-model="currentUser.birthday">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput4">Gender</label>
                                                <select class="form-control border-primary" v-model="currentUser.gender">
                                                    <option value="">Select Gender</option>
                                                    <option>Female</option>
                                                    <option>Male</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput3">E-mail</label>
                                                <input type="text" id="projectinput3" class="form-control" placeholder="E-mail" name="email" v-model="currentUser.email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput4">Contact Number</label>
                                                <input type="text" id="projectinput4" class="form-control" placeholder="Contact Number" name="phone" v-model="currentUser.contactNo">
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="form-section"><i class="icon-clipboard4"></i> More Info</h4>

                                    <div class="form-group">
                                        <label for="companyName">Instructor</label>
                                        <input disabled type="text" id="companyName" class="form-control" placeholder="N/a" name="company" :value="(currentUser.instructor ? currentUser.instructor.lname + ', ' + currentUser.instructor.name : '')">
                                    </div>

                                    <div class="form-group">
                                        <label for="companyName">Section</label>
                                        <input disabled type="text" id="companyName" class="form-control" placeholder="N/a" name="company" :value="(currentUser.section ? currentUser.section.name : '')">
                                    </div>

                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icon-check2"></i> Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    </div>
                    
                </div>
            </div>
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
var moment = require('moment');
    export default {
        props: ['user'],
        data() {
            return {
                moment: moment,
                errors: new Errors(),
                currentUser: JSON.parse(this.user),
                notif: {
                    type: 'alert',
                    message: '<strong>Oh snap!</strong> Change a <a href="#" class="alert-link">few things up</a> and try submitting again.',
                    show: false,
                    confirm: false,
                    function: '',
                },
                post:{
                    body: '',
                },
                socialwall:this.fetchSocialWall(),
            }
        },
        mounted() {
        },
        
        methods: {

            fetchSocialWall(){
                 axios.get('/api/posts/')
                .then((res) => {
                    this.socialwall =  res.data;
                })
                .catch((err) => {
                    this.errors.record(err.response.data);
                    this.showNotif('warning', '<strong>Warning!</strong><br>' + this.errors.get('name'));
                });
            },

            submitPost(){
                this.post.for_user_id = this.currentUser.id;
                axios.post('/api/posts/', this.post)
                .then((res) => { 
                    this.showNotif('success', '<strong>Well done!</strong> You succefully posted what\'s on your mind!.');
                    this.fetchSocialWall();
                    this.post.body = '';
                })
                .catch((err) => {
                    this.errors.record(err.response.data);
                    this.showNotif('warning', '<strong>Warning!</strong><br>' + this.errors.get('name'));
                });
            },

            updateProfile(){
                axios.patch('/api/students/'+this.currentUser.id, this.currentUser)
                .then((res) => {
                    this.showNotif('success', '<strong>Well done!</strong> You succefully updated your profile.');
                })
                .catch((err) => {
                    this.errors.record(err.response.data);
                    this.showNotif('warning', '<strong>Warning!</strong><br>' + this.errors.get('name'));
                });
            },

            imageChanged(e){

                var fileReader = new FileReader();

                fileReader.readAsDataURL(e.target.files[0]);

                fileReader.onload = (e) => {
                    this.currentUser.profilePicture = e.target.result;

                    axios.post('/api/uploadImage/StudentImage', this.currentUser)
                    .then((res) => {
                        this.currentUser.profilePicture = res.data;
                        this.showNotif('success', '<strong>Well done!</strong> You succefully updated your profile picture.');
                    })
                    .catch((err) => {
                        console.log(err);
                    });
                }
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

        }
    }
</script>
