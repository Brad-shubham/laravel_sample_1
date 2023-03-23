<template>
    <div class="card shadow mb-4 tb-select">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Student Status</h6>
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary btn-icon-split sm-top" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon text-white-50"><i class="fa fa-file-download text-white"
                                                            aria-hidden="true"></i></span>
                        <span class="text">Download</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" @click="downloadPdf">All</a>
                        <a class="dropdown-item" href="#" @click="downloadActive">Active Students</a>
                        <a class="dropdown-item" href="#" @click="downloadInactive">Inactive Students</a>
                        <a class="dropdown-item" href="#" @click="downloadUnresponsive">Unresponsive Students</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body tb-student">
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
import axios from "axios";

export default {
    name: "student-export",
    data() {
        return {
            url: route('students.exportListing'),
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
                    label: 'Status',
                    name: 'profile.activity_status',
                    orderable: true,
                },
            ],
            isLoading: false,
            isFullPage: true,
        };
    },
    components: {
        Loading,
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
        reloadTable(tableProps) {
            this.getData(this.url, tableProps);
        },
        downloadPdf() {
            this.isLoading = true;
            axios.get(route('students.exportPDF'))
                .then(response => {
                    this.isLoading = false;
                    this.$toasted.success('Check your email for downloading the PDF.');
                })
                .catch(errors => {
                    this.isLoading = false;
                    this.$toasted.error('Something went wrong.');
                })
        },
        downloadActive() {
          this.isLoading = true;
          axios.get(route('students.exportPDF'), {params: {type: 'active'}})
              .then(response => {
                this.isLoading = false;
                this.$toasted.success('Check your email for downloading the PDF.');
              })
              .catch(errors => {
                this.isLoading = false;
                this.$toasted.error('Something went wrong.');
              })
        },
        downloadInactive() {
            this.isLoading = true;
            axios.get(route('students.exportPDF'), {params: {type: 'inactive'}})
                .then(response => {
                    this.isLoading = false;
                    this.$toasted.success('Check your email for downloading the PDF.');
                })
                .catch(errors => {
                    this.isLoading = false;
                    this.$toasted.error('Something went wrong.');
                })
        },
        downloadUnresponsive() {
            this.isLoading = true;
            axios.get(route('students.exportPDF'), {params: {type: 'unresponsive'}})
                .then(response => {
                    this.isLoading = false;
                    this.$toasted.success('Check your email for downloading the PDF.');
                })
                .catch(errors => {
                    this.isLoading = false;
                    this.$toasted.error('Something went wrong.');
                })
        }
    },
}
</script>
