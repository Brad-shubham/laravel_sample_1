<template>
    <div>
        <input type="checkbox" value="1" v-model="data.gift_sent" @input="click(data)">
    </div>
</template>

<script>
export default {
    name: "CourseGiftSent",
    props: {
        data: {},
        value: null,
        click: {
            type: Function,
            default: () => {
            }
        },
    }
}
</script>
