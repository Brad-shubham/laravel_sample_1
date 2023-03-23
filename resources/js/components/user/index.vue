<template>
    <div class="card shadow mb-4 tb-select">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            <div v-if="canEdit">
                <button @click="addTeacher" type="button"
                        class="btn btn-primary btn-icon-split sm-top">
                    <span class="icon text-white-50"><i class="fa fa-plus text-white" aria-hidden="true"></i></span>
                    <span class="text">Add Teacher</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <data-table
                :data="users"
                :columns="columns"
                @onTablePropsChanged="reloadTable">
            </data-table>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import Button from '../common/Button';
    import datepicker from "../student/sub-component/datepicker";
    import flatPickr from "vue-flatpickr-component";

    export default {
        name: "user-index",
        data() {
            return {
                canEdit: Boolean,
                url: route('users.list'),
                users: {},
                userRoles: {},
                tableProps: {
                    search: '',
                    length: 10,
                    column: 'id',
                    dir: 'asc'
                },
                columns: [
                    {
                        label: 'ID',
                        name: 'id',
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
                        label: 'User Type',
                        name: 'user_type',
                        orderable: true,
                        classes: {
                            'text-capitalize': true,
                        }
                    },
                    {
                        label: 'Date Enrolled',
                        name: 'profile.date_enrolled',
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
                this.columns.push({
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
                });
            } else {
                this.columns.push({
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
        computed: {},
        methods: {
            getData(url = this.url, options = this.tableProps) {
                axios.get(url.template, {
                    params: options
                })
                    .then(response => {
                        this.users = response.data.users;
                        this.userRoles = response.data.roles;
                        this.users.data.forEach((item) => {
                            item.user_type = Object.keys(this.userRoles).find(key => this.userRoles[key] === item.user_type);
                        });
                    })
                    // eslint-disable-next-line
                    .catch(errors => {
                        //Handle Errors
                    })
            },
            reloadTable(tableProps) {
                this.getData(this.url, tableProps);
            },
            addTeacher() {
                window.location.href = route('users.create');
            },
            performAction(data) {
                if (this.canEdit) {
                    window.location.href = route('users.edit', `${data.id}`);
                } else {
                    window.location.href = route('users.show', `${data.id}`);
                }
            },
        }
    }
</script>
