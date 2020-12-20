<template>
    <div class="table-responsive">
        <table class="table">
        <thead class="thead-inverse">
            <tr>
                <th v-for="column in columns" :key="column.name" @click="$emit('sort', column.name)"
                    :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                    :style="'width:'+column.width+';'+'cursor:pointer;'">
                    {{column.label}}
                </th>
                <th>Action</th>
            </tr>
        </thead>
        <slot></slot>
    </table>
    </div>
</template>

<script>
    export default {
        props: ['columns', 'sortKey', 'sortOrders', 'showActionTable']
    }
</script>