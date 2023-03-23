<template>
    <button :class="classes" @click="click(data)" title="Update" v-if="meta.type === 'test-result' && data.status !== 1">
        <span>
            <i class="fa fa-eye" aria-hidden="true"></i>
        </span>
         View
    </button>
    <button :class="classes" @click="click(data)" title="Update" v-else>
        <span>
            <i class="fa" :class="classes.icon" aria-hidden="true"></i>
        </span>
        &nbsp;{{ name }}
    </button>
</template>

<script>
export default {
    props: {
        data: {},
        name: {},
        click: {
            type: Function,
            default: () => {
            }
        },
        classes: {
            type: Object,
            default: () => ({
                'btn': true,
                'btn-primary': true,
                'btn-sm': true,
                'icon': 'fa-edit',
            }),
        },
        meta: {}
    }
}
</script>

