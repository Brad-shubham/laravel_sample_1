<template>
    <div class="card shadow mb-4 tb-select">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tests</h6>
            <div v-if="canEdit">
                <a :href="route('tests.create')" class="btn btn-primary btn-icon-split sm-top">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus text-white" aria-hidden="true"></i>
                        </span>
                    <span class="text">Add Test</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <data-table
                :data="tests"
                :columns="columns"
                @onTablePropsChanged="reloadTable">
            </data-table>
        </div>
    </div>
</template>

<script>
    import Button from "../common/Button";
    import datepicker from "../student/sub-component/datepicker";

    export default {
        name: "test-index",
        data() {
            return {
                canEdit: Boolean,
                url: route('tests.list'),
                tests: {},
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
                        label: 'Title',
                        name: 'short_title',
                        orderable: true,
                    },
                    {
                        label: 'Lesson',
                        name: 'lesson.short_name',
                        orderable: true,
                    },
                    {
                        label: 'No. of Questions',
                        name: 'questions_count',
                        orderable: true,
                    },
                    {
                        label: 'Created At',
                        name: 'creation_date',
                        orderable: true,
                    },
                ],
            };
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
        methods: {
            getData(url = this.url, options = this.tableProps) {
                axios.get(url.template, {
                    params: options
                })
                    .then(response => {
                        this.tests = response.data.tests;
                    })
                    // eslint-disable-next-line
                    .catch(errors => {
                        //Handle Errors
                    })
            },
            reloadTable(tableProps) {
                this.getData(this.url, tableProps);
            },
            performAction(data) {
                if (this.canEdit) {
                    window.location.href = route('tests.edit', `${data.id}`);
                } else {
                    window.location.href = route('tests.show', `${data.id}`);
                }
            },
        }
    }
</script>
