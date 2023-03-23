<template>
    <div class="card shadow mb-4 tb-select">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gift Reminder</h6>
        </div>
        <div class="card-body date-picker tb-student">
            <data-table
                :data="data"
                :columns="columns"
                @onTablePropsChanged="reloadTable">
            </data-table>
        </div>
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import CourseGiftSent from "./sub-component/courseGiftSent";
import Form from "form-backend-validation";

export default {
    name: "student-gift-reminder",
    data() {
        return {
            canEdit: Boolean,
            url: route('gift.reminder.list'),
            data: {},
            tableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'asc'
            },
            columns: [
                {
                    label: 'Student ID',
                    name: 'student.student_id',
                    orderable: true,
                },
                {
                    label: 'First Name',
                    name: 'student.profile.first_name',
                    orderable: true,
                },
                {
                    label: 'Surname',
                    name: 'student.profile.surname',
                    orderable: true,
                },
                {
                    label: 'Course',
                    name: 'course.name',
                    orderable: true,
                },
                {
                    label: 'Gift Sent',
                    name: 'gift_sent',
                    orderable: false,
                    event: "click",
                    handler: this.updateGiftSentStatus,
                    component: CourseGiftSent,
                },
            ],
            isLoading: false,
            isFullPage: true,
        };
    },
    components: {
        Loading,
        CourseGiftSent,
    },
    created() {
        this.getData(this.url);
    },
    methods: {
        getData(url = this.url, options = this.tableProps) {
            axios.get(url.template, {
                params: options
            })
                .then(response => {
                    this.data = response.data;
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                })
        },
        async updateGiftSentStatus(data) {
            console.log(data);
            this.isLoading = true;
            this.form = new Form({
                gift_sent: (data.gift_sent) ? 0 : 1,
            });
            try {
                const response = await this.form.patch(route('students.update.giftSent', [`${data.student.id}`, `${data.course_id}`]));

                if (response.status) {
                    this.isLoading = false;
                    this.$toasted.success('Updated successfully');
                }
            } catch (e) {
                this.isLoading = false;
                this.$toasted.error('Unable to update status');
            }
        },
        reloadTable(tableProps) {
            this.getData(this.url, tableProps);
        },
    }
}
</script>

<style scoped>

</style>
