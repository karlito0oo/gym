<template>
    <div>
                    <table class="table">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Difficulty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="project in projects" :key="project.id">
                            <td>{{project.title}}</td>
                            <td>{{project.description}}</td>
                            <td>{{project.difficulty}}</td>
                           
                            <td>
                                <a class="btn btn-warning btn-sm" @click=" $parent.deleteDataConfirm(project, 'readings')"><span class="icon-android-delete"></span></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                    

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

        reloadReadings(readings){
            this.projects = readings;
        },

    },
};
</script>
