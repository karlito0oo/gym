<template>
    <div>
                    <table class="table">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Question</th>
                            <th>Answer 1</th>
                            <th>Answer 2</th>
                            <th>Answer 3</th>
                            <th>Answer 4</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="project in projects" :key="project.id">
                             <td>{{project.question}}</td>
                            <td :style="(project.correct_answer == 'answer_1' ? 'background-color: green; color:white; font-weight: bold;' : '')">{{project.answer_1}}</td>
                            <td :style="(project.correct_answer == 'answer_2' ? 'background-color: green; color:white; font-weight: bold;' : '')">{{project.answer_2}}</td>
                            <td :style="(project.correct_answer == 'answer_3' ? 'background-color: green; color:white; font-weight: bold;' : '')">{{project.answer_3}}</td>
                            <td :style="(project.correct_answer == 'answer_4' ? 'background-color: green; color:white; font-weight: bold;' : '')">{{project.answer_4}}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" @click=" $parent.deleteDataConfirm(project)"><span class="icon-android-delete"></span></a>
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

        reloadQuestions(questions){
            this.projects = questions;
        },

    },
};
</script>
