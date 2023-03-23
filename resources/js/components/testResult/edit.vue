<template>
    <div class="card shadow my-3">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Evaluate Test Result</h6>
        </div>
        <div class="card-body">
            <div class="row add-course tb-test course-test">
                <div class="col-md-9 text-dark">
                    <form v-if="testResult.answer">
                        <div class="common-border p-0">
                            <div class="form-group">
                                <div class="tb-test-title pl-lg-3">
                                    <h1 class="d-inline-block">Title:</h1>
                                    <label>{{ originalAnswer.title }}</label>
                                </div>
                                <div class="tb-test-lesson pl-lg-3">
                                    <h1 class="d-inline-block">Lesson:</h1>
                                    <label>{{ originalAnswer.lesson.name }}</label>
                                </div>
                            </div>
                            <div v-for="(question,questionIndex) in originalAnswer.questions"
                                 :key="questionIndex">
                                <div v-if="question.type === questionType.MCQ">
                                    <div class="tb-questions d-lg-flex">
                                        <span class="pr-lg-2 font-weight-bold">Question:</span>
                                        <p>{{ question.text }}</p>
                                    </div>
                                    <div class="d-flex custom-width">
                                        <div class="tb-correct">Correct Option</div>
                                        <div>Selected</div>
                                    </div>
                                    <div class="options-table py-lg-3">
                                        <div class="form-group row py-1 align-items-center"
                                             v-for="(option,optionIndex) in question.options" :key="optionIndex">
                                            <label class="col-lg-2 col-form-label">Option {{ optionIndex + 1 }}:</label>
                                            <div class="col-lg-6">{{ option.text }}</div>
                                            <div class=" col-lg-2 responsive-select-icon">
                                                <input type="radio" :checked="option.is_answer" disabled>
                                                <div class="d-block d-lg-none pr-lg-2">Correct Option</div>
                                            </div>
                                            <div class=" col-lg-2 responsive-select-icon">
                                                <input type="radio"
                                                       :checked="(submittedAnswer.questions[questionIndex].answer === option.id) ? 1 : 0"
                                                       disabled>
                                                <div class="d-block d-lg-none pr-lg-2">Selected</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comments pl-lg-5 px-2">
                                        <label>Feedback:</label>
                                        <textarea class="form-control" rows="3" name="comments"
                                                  v-model="submittedAnswer.questions[questionIndex].comments">{{
                                                submittedAnswer.questions[questionIndex].comments
                                            }}</textarea>
                                    </div>
                                </div>
                                <div class="my-2" v-else>
                                    <div class="tb-questions d-lg-flex">
                                        <span class="pr-lg-2 font-weight-bold">Question:</span>
                                        <p>{{ question.text }}</p>
                                    </div>
                                    <div class="pl-lg-5 px-2">
                                        <p>{{ submittedAnswer.questions[questionIndex].answer }}</p>
                                    </div>
                                    <div class="tb-grade pb-3">
                                        <label>Grade:</label>
                                        <input type="text" class="form-control"
                                               v-model="submittedAnswer.questions[questionIndex].score"
                                               :disabled="isDisable"
                                               :class="{'is-invalid':form.errors.has('questions.'+questionIndex+'.marks')}"
                                               @change="setScore(questionIndex)"
                                               placeholder="marks"><span>/{{ maxMarks }}</span>
                                        <span class="help-block invalid-feedback"
                                              v-show="form.errors.has('questions.'+questionIndex+'.marks')"
                                              v-text="form.errors.first('questions.'+questionIndex+'.marks')"></span>
                                    </div>
                                    <div class="comments pl-lg-5 px-2">
                                        <label>Feedback:</label>
                                        <textarea class="form-control" rows="3" name="comments"
                                                  v-model="submittedAnswer.questions[questionIndex].comments">{{
                                                submittedAnswer.questions[questionIndex].comments
                                            }}</textarea>
                                    </div>
                                </div>
                                <hr v-if="(questionIndex+1) < originalAnswer.questions.length"/>
                            </div>
                        </div>
                    </form>
                    <div class="common-border text-center text-danger h-100" v-else>
                        <h4>No test answer data is found!</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="submit-row list-group ">
                        <button type="submit" title="Save" class="list-group-item" id="myheader" name="_save"
                                @click="saveResult"
                                :disabled="isDisable"
                                :class="{'tb-disabled-btn':isDisable}" v-if="testResult.answer">
                            <i class="fas fa-save"></i>
                            <span class="text">Save</span>
                        </button>
                        <div class="d-flex tb-score justify-content-center">
                            <h3>Score:</h3>
                            <span>{{ testResult.percentage }}%</span>
                        </div>
                        <div class="student-profile text-capitalize text-center">
                            <div class="tb-student-name">
                                <label>student name</label> :
                                <span>{{ testResult.student.profile.full_name }}</span>
                            </div>
                            <div class="tb-student-id">
                                <label>student id</label> :
                                <span>{{ testResult.student.student_id }}</span>
                            </div>
                            <div class="tb-status">
                                <span class="badge badge-danger"
                                      v-if="testResult.status === status.not_qualified">Not Qualified</span>
                                <span class="badge badge-success" v-if="testResult.status === status.qualified">Qualified</span>
                                <span class="badge badge-secondary"
                                      v-if="testResult.status === status.pending">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "form-backend-validation";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: "test-result-edit",
    components: {
        Loading
    },
    data() {
        return {
            isLoading: false,
            isFullPage: true,
            isDisable: false,
            form: new Form(),
            questionType: [],
            testResult: [],
            maxMarks: Number,
            status: [],
            submittedAnswer: [],
            originalAnswer: [],
            errors: {},
        };
    },
    created() {
        this.questionType = this.$attrs.questiontype;
        this.testResult = this.$attrs.testresult;
        this.maxMarks = this.$attrs.maxmarks;
        this.status = this.$attrs.status;
        this.submittedAnswer = this.testResult.answer.submitted_answers;
        this.originalAnswer = this.testResult.answer.original_answers;
        this.isDisable = (this.testResult.status !== this.status.pending);

        this.submittedAnswer.questions.filter(function (question, index) {
            if (question.type === 2 && question.score === 0) {
                question.score = null;
            }
        });
    },
    methods: {
        async saveResult() {
            this.isLoading = true;
            this.isDisable = true;

            let hasComments = false;
            this.submittedAnswer.questions.filter(function (question, index) {
                let comment = (question.comments !== null) ? question.comments.trim() : '';

                if (comment.length !== 0) {
                    hasComments = true;
                }
            });

            let totalMarks = parseFloat(this.testResult.total_marks);

            this.submittedAnswer.questions.filter(function (question, index) {
                if (question.type === 2) {
                    totalMarks = totalMarks + question.score;
                }
            });

            const percentage = ((totalMarks / (this.submittedAnswer.questions.length * this.maxMarks)) * 100).toFixed(2);

            try {
                this.form = new Form({
                    'submitted_answers': this.submittedAnswer,
                    'total_marks': totalMarks,
                    'percentage': percentage,
                    'has_comments': hasComments,
                });

                const response = await this.form.put(route('test-answers.update', this.testResult));

                if (response.status) {
                    this.isLoading = false;
                    this.testResult.percentage = percentage;
                    if (percentage < 70) {
                        this.testResult.status = this.status.not_qualified;
                    } else {
                        this.testResult.status = this.status.qualified;
                    }
                    this.$toasted.success('Test result updated successfully.');
                }
            } catch (e) {
                this.isLoading = false;
                this.isDisable = false;
                this.$toasted.error('Unable to update test result.');
            }
        },
        setScore(questionIndex) {
            this.submittedAnswer.questions[questionIndex].score = parseFloat(this.submittedAnswer.questions[questionIndex].score);
        }
    }
}
</script>
