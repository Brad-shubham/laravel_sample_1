<template>
    <div v-if="meta.type === 'test-result'">
        <span class="badge badge-secondary" v-if="data.status === 1">Pending</span>
        <span class="badge badge-success" v-else-if="data.status === 2">Qualified</span>
        <span class="badge badge-danger" v-else>Not Qualified</span>
    </div>
    <div v-else>
        <span class="badge badge-success" v-if="data.status === 3">Completed</span>
        <span class="badge badge-info" v-else-if="data.status === 2">In Progress</span>
        <span class="badge badge-primary" v-else-if="data.status === 1">Unlocked</span>
    </div>
</template>

<script>
export default {
    props: {
        data: {},
        meta: {}
    }
}
</script>
