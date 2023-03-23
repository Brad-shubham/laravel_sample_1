<template>
    <div class="card shadow mb-4 tb-select">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Test Results</h6>
        </div>
        <div class="card-body">
            <data-table
                :data="testAnswers"
                :columns="columns"
                :order-by="tableProps.column"
                @onTablePropsChanged="reloadTable">
            </data-table>
        </div>
    </div>
</template>

<script>
import Button from '../common/Button';
import Badge from './sub-component/Badge';

export default {
    name: "test-result-index",
    data() {
        return {
            url: route('testAnswers.list'),
            testAnswers: {},
            testStatus: {},
            userRoles: {},
            tableProps: {
                search: '',
                length: 10,
                column: 'status',
                dir: 'asc',
            },
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Test Title',
                    name: 'test.title',
                    orderable: true,
                },
                {
                    label: 'Student Name',
                    name: 'student.profile.full_name',
                    orderable: true,
                },
                {
                    label: 'Status',
                    name: 'status',
                    orderable: false,
                    component: Badge,
                    meta: {
                        'type': 'test-result'
                    }
                },
                {
                    label: 'Submitted At',
                    name: 'creation_date',
                    orderable: true,
                },
                {
                    label: 'Action',
                    name: 'Evaluate',
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
                    meta: {
                        'type': 'test-result'
                    }
                },
            ],
        };
    },
    components: {
        Button,
        Badge
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
                    this.testAnswers = response.data.testAnswers;
                })
                .catch(errors => {
                    //Handle Errors
                })
        },
        reloadTable(tableProps) {
            this.getData(this.url, tableProps);
        },
        performAction(data) {
            window.location.href = route('test-answers.edit', `${data.id}`);
        },
    }
}
</script>
