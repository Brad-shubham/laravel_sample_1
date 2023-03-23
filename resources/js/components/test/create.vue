<template>
    <div class="card shadow my-4">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Add Test</h6>
        </div>
        <div class="card-body">
            <div class="row common-space">
                <div class="col-md-9">
                    <form>
                        <div class="common-border py-0">
                            <div class="form-group row px-0">
                                <h1 class="h3 mb-2 text-gray-800">Title</h1>
                                <input type="text" class="form-control" placeholder="" v-model="form.title"
                                       :class="{'is-invalid':form.errors.has('title')}">
                                <span class="help-block invalid-feedback" v-show="form.errors.has('title')"
                                      v-text="form.errors.first('title')"></span>
                            </div>
                            <div class="form-group mb-3 p-0">
                                <h2 class="h3 mb-2 text-gray-800">Select Lesson</h2>
                                <multiselect name="lesson_id"
                                             v-model="form.lesson"
                                             :options="lessons"
                                             track-by="id"
                                             :searchable="true"
                                             :multiple="false"
                                             label="name"
                                             :class="{'is-invalid': (form.errors.has('lesson_id')) || (form.errors.has('questions'))}"></multiselect>
                                <span class="help-block invalid-feedback" v-show="form.errors.has('lesson_id')"
                                      v-text="form.errors.first('lesson_id')"></span>
                                <span class="help-block invalid-feedback" v-show="form.errors.has('questions')"
                                      v-text="form.errors.first('questions')"></span>
                            </div>
                            <div class="mb-5" v-for="(question,questionIndex) in form.questions" :key="questionIndex">
                                <h2 class="h3 mt-4 text-gray-800">Add Question</h2>
                                <div class="wrapper">
                                    <div class="gray-bg">
                                        <div class="form-group row p-0">
                                            <label class="col-xl-3 col-form-label"> Question
                                                Type:</label>
                                            <div class="col-xl-6 col-md-8">
                                                <select class="custom-select" v-model="question.type"
                                                        @change="toggleFormFields(questionIndex)"
                                                        :class="{'is-invalid':form.errors.has('questions.'+questionIndex+'.type')}">
                                                    <option :value="null">Choose...</option>
                                                    <option v-for="(type, key) in questionType" :value="type">
                                                        {{ key }}
                                                    </option>
                                                </select>
                                                <span class="help-block invalid-feedback select-type"
                                                      v-show="form.errors.has('questions.'+questionIndex+'.type')"
                                                      v-text="form.errors.first('questions.'+questionIndex+'.type')"></span>
                                            </div>
                                            <div data-toggle="tooltip" title="Delete">
                                                <div
                                                    class="responsive-text col-xl-3 col-md-2 d-flex align-items-center pl-lg-5">
                                                    <button type="button"
                                                            @click="showDeleteQuestionModal(questionIndex)"
                                                            class="btn cross-btn"
                                                            data-toggle="tooltip"
                                                            title="Delete">
                                                        delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-3 px-lg-0 py-lg-3" v-if="question.type !== null">
                                        <div class="px-0">
                                            <label>Question</label>
                                            <textarea class="form-control" rows="3"
                                                      :class="{'is-invalid': (form.errors.has('questions.'+questionIndex+'.text')) || (form.errors.has('questions.'+questionIndex+'.options'))}"
                                                      spellcheck="false" v-model="question.text"></textarea>
                                            <span class="help-block invalid-feedback"
                                                  v-show="form.errors.has('questions.'+questionIndex+'.text')"
                                                  v-text="form.errors.first('questions.'+questionIndex+'.text')"></span>
                                            <span class="help-block invalid-feedback"
                                                  v-show="form.errors.has('questions.'+questionIndex+'.options')"
                                                  v-text="form.errors.first('questions.'+questionIndex+'.options')"></span>
                                            <span class="help-block invalid-feedback"
                                                  v-show="form.errors.has('questions.'+questionIndex+'.options.is_answer')"
                                                  v-text="form.errors.first('questions.'+questionIndex+'.options.is_answer')"></span>
                                        </div>
                                    </div>
                                    <div class="ml-lg-5 py-lg-3" v-if="question.type === questionType.MCQ">
                                        <div class="form-group row py-1" v-if="question.options.length">
                                            <div class="offset-xl-9 col-xl-3"> Answer</div>
                                        </div>
                                        <div class="form-group row py-1"
                                             v-for="(option, optionIndex) in question.options" :key="optionIndex">
                                            <label class="col-xl-2 col-form-label">Option {{ optionIndex + 1
                                                }} </label>
                                            <div class="col-xl-7">
                                                <input type="text" class="form-control" v-model="option.text"
                                                       :class="{'is-invalid': (form.errors.has('questions.'+questionIndex+'.options.'+optionIndex+'.text')) || (form.errors.has('questions.'+questionIndex+'.options.'+optionIndex+'.is_answer'))}">
                                                <span class="help-block invalid-feedback"
                                                      v-show="form.errors.has('questions.'+questionIndex+'.options.'+optionIndex+'.text')"
                                                      v-text="form.errors.first('questions.'+questionIndex+'.options.'+optionIndex+'.text')"></span>
                                            </div>
                                            <div class="d-flex justify-content-between responisve-block">
                                                <div class="responsive-text col-xl-1">
                                                    <input type="radio" v-model="option.is_answer" :name="questionIndex"
                                                           :value="1"
                                                           @click="setOption(questionIndex,optionIndex)">
                                                </div>
                                                <div data-toggle="tooltip" title="Delete">
                                                    <div
                                                        class="responsive-text tb-trash col-xl-2 d-flex align-items-center"
                                                        data-toggle="modal" data-target="#exampleModal">
                                                        <button type="button"
                                                                @click="showDeleteOptionModal(questionIndex,optionIndex)"
                                                                class="btn btn-cross"
                                                                data-toggle="tooltip"
                                                                title="Delete">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="py-3 pl-3 add-btn text-blue"
                                                @click="addOption(questionIndex)"
                                                v-if="(question.options.length < 4)"><i class="fas fa-plus"></i> Add
                                            another option
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="custom-btn d-flex justify-content-center text-capitalize">
                        <button type="button" class="pl-3 add-btn text-blue" id="show-hidden-menu" @click="addQuestion">
                            <i class="fas fa-plus"></i> Add another Question
                        </button>
                    </div>
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
        <delete-modal :message-data="message" @confirm-delete="remove"
                      @close-delete="showDeletePopup=false"
                      v-if="showDeletePopup"></delete-modal>
    </div>
</template>

<script>
    import Form from 'form-backend-validation';
    import Multiselect from 'vue-multiselect';
    import 'vue-multiselect/dist/vue-multiselect.min.css';
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import DeleteModal from "../modal/DeleteModal";
    import Button from "../common/Button";

    export default {
        name: "test-create",
        components: {
            Button,
            Multiselect,
            Loading,
            DeleteModal,
        },
        data() {
            return {
                isLoading: false,
                isFullPage: true,
                showDeletePopup: false,
                message: '',
                selectedQuestionIndex: null,
                selectedOptionIndex: null,
                form: new Form({
                    title: null,
                    lesson_id: null,
                    lesson: {},
                    questions: [
                        {'text': null, 'type': null,},
                    ]
                }),
                lessons: [],
                questionType: []
            }
        },
        created() {
            this.lessons = this.$attrs.lessons;
            this.questionType = this.$attrs.questiontype;
        },
        methods: {
            addQuestion() {
                this.form.questions.push(
                    {'text': null, 'type': null,}
                );
            },
            addOption(questionIndex) {
                this.form.questions[questionIndex].options.push(
                    {'text': null, 'is_answer': 0});
                this.$forceUpdate();
            },
            toggleFormFields(index) {
                if (this.form.questions[index].type === this.questionType.MCQ) {
                    this.form.questions[index].options = [
                        {'text': null, 'is_answer': null},
                        {'text': null, 'is_answer': null},
                        {'text': null, 'is_answer': null},
                        {'text': null, 'is_answer': null},
                    ];
                } else {
                    this.$delete(this.form.questions[index], 'options');
                }
            },
            setOption(questionIndex, optionIndex) {
                this.form.questions[questionIndex].options.forEach((item) => {
                    item.is_answer = 0;
                });
                this.test.questions[questionIndex].options[optionIndex].is_answer = 1;
            },
            showDeleteQuestionModal(index) {
                this.showDeletePopup = true;
                this.message = 'Are you sure you want to delete this question?';
                this.selectedQuestionIndex = index;
            },
            showDeleteOptionModal(questionIndex, optionIndex) {
                this.showDeletePopup = true;
                this.message = 'Are you sure you want to delete this option?';
                this.selectedQuestionIndex = questionIndex;
                this.selectedOptionIndex = optionIndex;
            },
            remove() {
                if (this.selectedQuestionIndex !== null) {
                    if (this.selectedOptionIndex !== null) {
                        this.form.questions[this.selectedQuestionIndex].options.splice(this.selectedOptionIndex, 1);
                    } else {
                        this.form.questions.splice(this.selectedQuestionIndex, 1);
                    }
                }
                this.selectedQuestionIndex = null;
                this.selectedOptionIndex = null;
                this.showDeletePopup = false;
            },
            async save() {
                this.isLoading = true;
                try {
                    this.form.lesson_id = (this.form.lesson) ? this.form.lesson.id : null;
                    const response = await this.form.post(route('tests.store'));

                    if (response.status) {
                        this.isLoading = false;
                        this.$toasted.success('Test created successfully.');
                        setTimeout(() => window.location.href = route('tests.index'), 1500);
                    }
                } catch (e) {
                    this.isLoading = false;
                    this.$toasted.error('Unable to create test.');
                }
            }
        }
    }
</script>
