<template>
    <flat-pickr v-model="data.profile.last_test"
                :config="config"
                @input="click(data)"></flat-pickr>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        name: "datepicker",
        components: {
            flatPickr,
        },
        data() {
            return {
                config: {
                    wrap: false,
                    altFormat: 'M d, Y',
                    altInput: true,
                    dateFormat: 'Y-m-d',
                    maxDate: "today",
                },
            }
        },
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
