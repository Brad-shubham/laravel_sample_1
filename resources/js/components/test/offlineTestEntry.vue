<template>
    <div class="card shadow my-4">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Offline Test Entry</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <form method="POST">
                        <div class="common-border heading-one">
                            <div class="form-group">
                                <label>Select Student</label>
                                <multiselect name="student_id"
                                             v-model="form.student"
                                             :options="students"
                                             track-by="id"
                                             :searchable="true"
                                             :multiple="false"
                                             :class="{'is-invalid':form.errors.has('student_id')}"
                                             :custom-label="customLabel"></multiselect>
                                <span class="help-block invalid-feedback"
                                      v-show="form.errors.has('student_id')"
                                      v-text="form.errors.first('student_id')"></span>
                            </div>
                            <div class="form-group">
                                <label>Select Test</label>
                                <multiselect name="test_id"
                                             v-model="form.test"
                                             :options="tests"
                                             track-by="id"
                                             :searchable="true"
                                             :multiple="false"
                                             :class="{'is-invalid':form.errors.has('test_id')}"
                                             label="title"></multiselect>
                                <span class="help-block invalid-feedback"
                                      v-show="form.errors.has('test_id')"
                                      v-text="form.errors.first('test_id')"></span>
                            </div>
                            <div class="form-group">
                                <label>Grades</label>
                                <input type="text" class="form-control" placeholder="" v-model="form.grades" :class="{'is-invalid':form.errors.has('grades')}">
                                <span class="help-block invalid-feedback"
                                      v-show="form.errors.has('grades')"
                                      v-text="form.errors.first('grades')"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="submit-row list-group ">
                        <button type="button" title="Save" class="list-group-item" name="_save" @click="save">
                            <i class="fas fa-save"></i><span class="text">Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'form-backend-validation';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.min.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: "offline-test-entry",
    components: {
        Multiselect,
        Loading,
    },
    data() {
        return {
            isLoading: false,
            isFullPage: true,
            form: new Form(),
            tests: [],
            students: []
        }
    },
    created() {
        this.tests = this.$attrs.tests;
        this.students = this.$attrs.students;
        this.form = new Form({
            'student': null,
            'test': null,
            'grades': null,
        });
    },
    methods: {
        customLabel({student_id, profile}) {
            return `${student_id} - ${profile.full_name}`;
        },
        async save() {
            this.isLoading = true;
            this.form = new Form({
                'student_id': (this.form.student) ? this.form.student.id : null,
                'test_id': (this.form.test) ? this.form.test.id : null,
                'grades': this.form.grades,
            });
            try {
                const response = await this.form.post(route('offline.test.entry'));
                if (response.status) {
                    this.isLoading = false;
                    this.$toasted.success('Grade added successfully.');
                }else{
                    this.isLoading = false;
                    this.$toasted.error('Unable to add grades.');
                }
            } catch (e) {
                this.isLoading = false;
                this.$toasted.error('Unable to add grades.');
            }
        },
    }
}
</script>
