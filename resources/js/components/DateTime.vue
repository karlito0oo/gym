<template>
    <span>
        {{ date }}
    </span>
</template>

<script>
import moment from 'moment';
    export default {
        data() {
            return {
                date: '',
            }
        },

        methods: {
            updateTime(){
                this.date = moment().format("ddd, MMM Do YYYY, h:mm a");
            }
        },
        
        mounted() {
            setInterval(this.updateTime, 1000);
        }
    }
</script>
