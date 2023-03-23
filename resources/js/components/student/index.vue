<template>
    <div class="card shadow mb-4 tb-select">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Students</h6>
            <div>
                <button @click="exportStudent" type="button" class="btn btn-primary btn-icon-split sm-top">
                    <span class="icon text-white-50"><i class="fa fa-file-download text-white" aria-hidden="true"></i></span>
                    <span class="text">Export Students</span>
                </button>
                <button @click="addStudent" type="button" class="btn btn-primary btn-icon-split sm-top">
                    <span class="icon text-white-50"><i class="fa fa-plus text-white" aria-hidden="true"></i></span>
                    <span class="text">Add Student</span>
                </button>
            </div>
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
import Form from "form-backend-validation";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Button from '../common/Button';
import datepicker from "./sub-component/datepicker";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
    name: "student-index",
    data() {
        return {
            canEdit: Boolean,
            url: route('students.list'),
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
                    name: 'student_id',
                    orderable: true,
                },
                {
                    label: 'Old Student ID',
                    name: 'old_student_id',
                    orderable: true,
                },
                {
                    label: 'First Name',
                    name: 'profile.short_first_name',
                    orderable: true,
                },
                {
                    label: 'Surname',
                    name: 'profile.short_surname',
                    orderable: true,
                },
                {
                    label: 'Phone Number',
                    name: 'formatted_phone_number',
                    orderable: true,
                },
                {
                    label: 'Date Enrolled',
                    name: 'profile.date_enrolled',
                    orderable: true,
                },
                {
                    label: 'Last Heard/Test',
                    name: 'profile.formatted_last_test',
                    orderable: true,
                },
            ],
            isLoading: false,
            isFullPage: true,
        };
    },
    components: {
        flatPickr,
        Loading,
        Button,
        datepicker,
    },
    created() {
        this.getData(this.url);
        this.canEdit = this.$attrs.canedit;
        if (this.canEdit) {
            this.columns.push(
                {
                    label: 'Action',
                    name: 'Edit',
                    orderable: false,
                    classes: {
                        'btn': true,
                        'btn-primary': true,
                        'btn-sm': true,
                        'icon': 'fa-edit',
                    },
                    event: "click",
                    handler: this.performAction,
                    component: Button,
                },);
        } else {
            this.columns.push(
                {
                    label: 'Action',
                    name: 'View',
                    orderable: false,
                    classes: {
                        'btn': true,
                        'btn-primary': true,
                        'btn-sm': true,
                        'icon': 'fa-eye',
                    },
                    event: "click",
                    handler: this.performAction,
                    component: Button,
                });
        }
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
        reloadTable(tableProps) {
            this.getData(this.url, tableProps);
        },
        addStudent() {
            window.location.href = route('students.create');
        },
        performAction(data) {
            if (this.canEdit) {
                window.location.href = route('students.edit', `${data.id}`);
            } else {
                window.location.href = route('students.show', `${data.id}`);
            }
        },
        exportStudent() {
            window.location.href = route('students.export');
        }
    }
}
</script>
