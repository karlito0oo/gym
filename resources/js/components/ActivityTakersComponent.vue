<template>
    <div>
    <!-- Modal -->
<div class="modal fade text-xs-left" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
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
                    
                        <table class="table">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Name</th>
                                    <th>Section</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="project in projects.answered" :key="project.id">
                                    <td>{{project.lname}}, {{project.name}}</td>
                                    <td>{{project.section.name}}</td>
                                    
                                    <td>
                                        <a target="_blank" class="btn btn-success btn-sm" :href="'/home/activities/activity-result/' + projects.id + '/' + project.id"><span class="icon-eye"> View answer</span></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

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
            </div>
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
            projects: [],
        }
    },
    methods: {

        reloadTakers(activity){
            this.projects = activity;
            console.log(this.projects.answered);
            $('#viewModal').modal('show');
        },

    },
};
</script>
