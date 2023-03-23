<template>
    <div class="card shadow my-4">
      <loading :active="isLoading"
               loader="dots"
               :is-full-page="isFullPage">
      </loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Course Progress</h6>
        </div>
        <div class="card-body">
            <div class="row add-course view-course">
                <div class="col-md-9">
                    <div class="common-border p-0">
                        <h1>Certificates</h1>
                        <div class="content-wrapper">
                            <div class="ng-modal-number-container">
                                <div class="questionNumbers" v-for="(certificate, index) in student.certificates">
                                    <div :class="certificate ? 'questionNumberIcon':'questionNumberIcon incomplete'"><i
                                        class="fa fa-check" aria-hidden="true"></i></div>
                                    <span class="text-uppercase"><a
                                        :class="certificate ? 'text-decoration-none':'text-decoration-none incomplete'"
                                        :href="certificate ? certificate.url : null" target="_blank">level {{ index + 1 }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="common-border p-0">
                        <h2>Courses</h2>
                        <div class="p-4">
                            <data-table
                                :data="courses"
                                :columns="coursesColumns"
                                @onTablePropsChanged="reloadCourseTable">
                            </data-table>
                          <div v-if="nextCourseToUnlock" class="pl-lg-5 d-lg-flex px-2">
                            <button @click="unlockNextCourse()" class="btn btn-primary btn-icon-split sm-top" >
                              <span class="text">Unlock Next Course</span>
                            </button>
                          </div>
                        </div>
                        <h2>Test Result</h2>
                        <div class="p-4">
                            <data-table
                                :data="testResults"
                                :columns="testResultColumns"
                                :order-by="testResultsTableProps.column"
                                @onTablePropsChanged="reloadTestResultTable">
                            </data-table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="submit-row list-group ">
                        <div class="student-profile text-capitalize text-center">
                            <div class="tb-student-name">
                                <label>student name</label> :
                                <span>{{ student.profile.full_name }}</span>
                            </div>
                            <div class="tb-student-id">
                                <label>student iD</label> :
                                <span>{{ student.student_id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Badge from "../testResult/sub-component/Badge";
import Button from "../common/Button";
import axios from "axios";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: "student-report",
    data() {
        return {
            data: {},
            courseTableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'asc'
            },
            testResultsTableProps: {
                search: '',
                length: 10,
                column: 'status',
                dir: 'asc'
            },
            coursesColumns: [
                {
                    label: 'Title',
                    name: 'course.name',
                    orderable: true,
                },
                {
                    label: 'Date',
                    name: 'updated_at',
                    orderable: true,
                },
                {
                    label: 'Status',
                    name: 'status',
                    orderable: false,
                    component: Badge,
                },
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
                    handler: this.courseAction,
                    component: Button,
                },
            ],
            testResultColumns: [
                {
                    label: 'Test Title',
                    name: 'test.title',
                    orderable: true,
                },
                {
                    label: 'Date',
                    name: 'updated_at',
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
                    handler: this.testResultAction,
                    component: Button,
                    meta: {
                        'type': 'test-result'
                    }
                },
            ],
            student: {},
            courses: {},
            testResults: {},
            isLoading : false,
            isFullPage: true,
            nextCourseToUnlock: {}
        };
    },
    components: {
      Loading,
    },
    created() {
        this.student = this.$attrs.student;
        if (this.student.certificates.length < 3) {
            for (var i = 1; i < 3; i++) {
                this.student.certificates[i] = this.student.certificates[i] ? this.student.certificates[i] : null;
            }
        }
        this.getCourseData();
        this.getTestResultData();
    },
    methods: {
        getCourseData(options = this.courseTableProps) {
            axios.get('/students/' + this.student.id + '/course/list', {
                params: options
            })
                .then(response => {
                    this.courses = response.data.courses;
                    this.nextCourseToUnlock = response.data.nextCourseToUnlock;
                })
                .catch(errors => {
                    //Handle Errors
                })
        },
        getTestResultData(options = this.testResultsTableProps) {
            axios.get('/students/' + this.student.id + '/test-results/list', {
                params: options
            })
                .then(response => {
                    this.testResults = response.data;
                })
                .catch(errors => {
                    //Handle Errors
                })
        },
        reloadCourseTable(tableProps) {
            this.getCourseData(tableProps);
        },
        reloadTestResultTable(tableProps) {
            this.getTestResultData(tableProps);
        },
        courseAction(data) {
            window.location.href = route('students.course.details', [`${this.student.id}`, `${data.course.id}`]);
        },
        testResultAction(data) {
            window.location.href = route('test-answers.edit', `${data.id}`);
        },
        unlockNextCourse() {
          this.isLoading = true;
          axios.post(`/students/${this.student.id}/courses/${this.nextCourseToUnlock.id}/unlock`)
              .then(response => {
                this.$toasted.success('Course Unlocked Successfully.');
                window.location.reload();
              })
              .catch(errors => {
                this.isLoading = false;
                this.$toasted.error('Something went wrong.');
              })
        }
    }
}
</script>
