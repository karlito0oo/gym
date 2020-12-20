<style lang="scss">
.pagination {
    justify-content: flex-end !important;
}
</style>

<template>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item" v-bind:class="[{ disabled: !pagination.prevPageUrl }]"><a class="page-link" href="#" @click="$emit('prev');">Previous</a></li>
            <li class="page-item disabled"><a class="page-link text-dark " href="#">
                Page {{pagination.currentPage}} of {{pagination.lastPage}}
                </a></li>
            <li class="page-item" v-bind:class="[{ disabled: !pagination.nextPageUrl }]"><a class="page-link" href="#" @click="$emit('next');">Next</a></li>
        </ul>
    </nav>


</template>

<script>
    export default {
        props: ['pagination', 'client', 'filtered']
    }
</script>