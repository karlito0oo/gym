<template>
    <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
			<div class="card-header no-border text-xs-center">
				<img :src="imageSRC" alt="unlock-user" class="rounded-circle img-fluid center-block" style="height: 300px; width: 300px;">
				<h5 class="card-title mt-1">{{ user.lname + ", " + user.name }}</h5>

                <form @submit.prevent="uploadImage">
                    <input id="imageFile" type="file" @change="imageChanged" accept="image/*" style="display:none;">
                </form>
			</div>

			<p class="card-subtitle line-on-side text-muted text-xs-center font-small-3 mx-2" style="cursor: pointer;" onclick="$('#imageFile').click()"><span>Change your profile picture</span></p>

            <div class="card-block">
                <div class="tab-content px-1 pt-1">
                    <!-- My Activity -->
                    <div role="tabpanel" class="tab-pane fade active in" id="active" aria-labelledby="active-tab" aria-expanded="true">
                        <div class="card-body collapse in">
                        <div class="card-block">
                            <form class="form" @submit.prevent="updateProfile()">
                                <div class="form-body">
                                    <h4 class="form-section"><i class="icon-head"></i> Personal Info</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">First Name *</label>
                                                <input type="text" id="projectinput1" class="form-control" placeholder="First Name" name="fname" v-model="user.name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">Last Name *</label>
                                                <input type="text" id="projectinput2" class="form-control" placeholder="Last Name" name="lname" v-model="user.lname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput3">Birthday</label>
                                                <input type="date" id="projectinput3" class="form-control" placeholder="Birthday" v-model="user.birthday">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput4">Gender</label>
                                                <select class="form-control border-primary" v-model="user.gender">
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
                                                <label for="projectinput3">E-mail *</label>
                                                <input disabled type="text" id="projectinput3" class="form-control" placeholder="E-mail" name="email" v-model="user.email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput4">Contact Number</label>
                                                <input type="text" id="projectinput4" class="form-control" placeholder="Contact Number" name="phone" v-model="user.contactNo">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icon-check2"></i> Update Profile
                                    </button>
                                </div>
                            </form>

                            <form class="form" @submit.prevent="updatePassword()">
                                <br><br>
                                <h4 class="form-section"><i class="icon-lock2"></i> Password</h4>

                                <div class="form-group">
                                    <label for="companyName">Current Password</label>
                                    <input type="password" class="form-control" placeholder="Current Password" required v-model="passwords.currentPassword">
                                </div>

                                <div class="form-group">
                                    <label for="companyName">New Password</label>
                                    <input type="password" class="form-control" placeholder="New Password" required v-model="passwords.newPassword">
                                </div>

                                <div class="form-group">
                                    <label for="companyName">Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Confirm Password" required v-model="passwords.confirmPassword">
                                </div>

                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icon-check2"></i> Update Password
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
        props: {
            user: {
                type: Object
            }
        },
        data() {
            return {
                passwords: {
                    id: this.user.id,
                    currentPassword: '',
                    newPassword: '',
                    confirmPassword: '',
                },
                imageSRC: '/images/' + (this.user.profilePicture ? 'studentImage/' + this.user.profilePicture : 'defaultuser.png'),
            }
        },
        mounted() {
        },
        
        methods: {

            updateProfile(){
                axios.patch('/api/users/'+this.user.id, this.user)
                .then((res) => {
                    Swal.fire(
                        'Well done!',
                        'You succefully updated your profile.',
                        'success'
                    )
                })
                .catch((err) => {
                    this.errors.record(err);
                });
            },

            updatePassword(){
                axios.post('/api/users/updatePassword', this.passwords)
                .then((res) => {
                    if(!res.data.result){
                        Swal.fire(
                            'Error!',
                            res.data.message,
                            'error'
                        )
                    }
                    else{
                        Swal.fire(
                            'Well done!',
                            'You succefully updated your password.',
                            'success'
                        )
                    }
                    
                })
                .catch((err) => {
                    this.errors.record(err);
                });
            },

            imageChanged(e){

                var fileReader = new FileReader();

                fileReader.readAsDataURL(e.target.files[0]);

                fileReader.onload = (e) => {
                    this.user.profilePicture = e.target.result;

                    axios.post('/api/uploadImage/StudentImage', this.user)
                    .then((res) => {
                        this.user.profilePicture = res.data;

                        this.imageSRC = '/images/studentImage/' + res.data;
                        
                        Swal.fire(
                            'Well done!',
                            'You succefully updated your profile picture.',
                            'success'
                        )
                    })
                    .catch((err) => {
                        console.log(err);
                    });
                }
            },

        }
    }
</script>
