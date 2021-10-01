<template>
    <div>
        <div class="row">
            <div class="col-xs-12 mt-1 mb-3">
                <h4>Here's our equipments 
                 <button  v-if="user.userRole == 'admin'" type="button" class="btn btn-sm btn-primary" style="float:right" @click="dataModalOpen">
                    <i class="icon-plus"></i>ADD
                </button></h4>
                <p>Gym equipments are any apparatus or device used during physical activity to enhance the strength or conditioning effects of that exercise by providing either fixed or adjustable amounts of resistance, or to otherwise enhance the experience or outcome of an exercise routine.</p>
                <hr>
            </div>
        </div>
        
                
        <div class="row match-height">
            <div class="col-xl-4 col-md-6 col-sm-12" v-for="equipment in equipments" :key="equipment.id">
                <div class="card" style="height: 480px;">
                    <div class="card-body">
                        <div class="card-block">
                            <h4 class="card-title">{{equipment.name}}</h4>
                            <h6 class="card-subtitle text-muted">{{equipment.subDescription}}</h6>
                        </div>
                        <div class="embed-responsive embed-responsive-item embed-responsive-16by9">
                            <iframe width="560" height="315" :src="'https://www.youtube.com/embed/' + equipment.embedLink" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="card-block">
                            <p class="card-text">{{equipment.description}}</p>
                            <a :href="'https://www.youtube.com/watch?v=' + equipment.embedLink" class="card-link" target="_blank">Watch in Youtube</a>
                            <a v-if="user.userRole == 'admin'" href="#" @click.prevent="editEquipment(equipment)" class="card-link">Edit</a>
                            <a v-if="user.userRole == 'admin'" href="#" @click.prevent="deleteEquipment(equipment)" class="card-link">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



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
                            
                                <div class="form-body">
                                    <h4 class="form-section"><i class="icon-folder4"></i> {{ todo }} Equipment</h4>

                                    <div class="form-group">
                                        <label for="userinput5">Name *</label>
                                        <input class="form-control border-primary" type="text" placeholder="Name" v-model="datas.name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="userinput5">Sub Description</label>
                                        <input class="form-control border-primary" type="text" placeholder="Sub Description" v-model="datas.subDescription">
                                    </div>

                                    <div class="form-group">
                                        <label for="userinput6">Youtube Link *</label>
                                        <input class="form-control border-primary" type="text" placeholder="3-9CeyWv2QQ" v-model="datas.embedLink" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="userinput6">Description *</label>
                                        <textarea class="form-control border-primary" placeholder="Description" rows="4" cols="50" v-model="datas.description" required></textarea>
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
export default {
    
    props: {
        user: {
            type: Object
        }
    },

    data() {
        return {
            todo: 'Add',
            datas: {
                name: '',
                description: '',
                embedLink: '',
                subDescription: '',

            },
            equipments: {},
        }
    },

    mounted() {
        this.getEquipments();
    },

    methods: {
        editEquipment(equipment) {
            console.log(equipment);
            this.datas.id = equipment.id;
            this.datas.name = equipment.name;
            this.datas.description = equipment.description;
            this.datas.embedLink = equipment.embedLink;
            this.datas.subDescription = equipment.subDescription;
            this.todo = 'Edit';
            $('#dataModal').modal('show');
        },
        
        deleteEquipment(equipment) {
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
                    axios.delete('/api/equipments/'+equipment.id)
                    .then((res) => {
                        this.clearFields();
                        this.getEquipments();
                        Swal.fire(
                            'Well Done!',
                            'Successfully deleted an equipment!',
                            'success'
                        )
                    })
                    .catch((err) => {
                        console.log(err);
                    });
                }
            })
        },

        getEquipments(){
            axios.get('/api/equipments')
            .then((res) => {
                this.equipments = res.data;
            })
            .catch((err) => {
                console.log(err);
            });
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
            if(this.todo == 'Add'){
                axios.post('/api/equipments', this.datas)
                .then((res) => {
                    this.clearFields();
                    this.getEquipments();
                    Swal.fire(
                        'Well Done!',
                        'Successfully added an equipment!',
                        'success'
                    )
                })
                .catch((err) => {
                    console.log(err);
                });
            }
            else if(this.todo == 'Edit'){
                axios.patch('/api/equipments/'+this.datas.id, this.datas)
                .then((res) => {
                    this.clearFields();
                    this.getEquipments();
                    Swal.fire(
                        'Well Done!',
                        'Successfully updated an equipment!',
                        'success'
                    )
                })
                .catch((err) => {
                    console.log(err);
                });
            }
            
        },

    },
};
</script>