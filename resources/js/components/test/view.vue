<template>
    <div class="card shadow my-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">View Test</h6>
        </div>
        <div class="card-body">
            <div class="row common-space">
                <div class="col-md-12">
                    <form>
                        <div class="common-border py-0">
                            <div class="form-group row px-0">
                                <h1 class="h3 mb-2 text-gray-800">Title</h1>
                                <input type="text" class="form-control" placeholder="" disabled :value="test.title">
                            </div>
                            <div class="form-group mb-3 p-0">
                                <h2 class="h3 mb-2 text-gray-800">Select Lesson</h2>
                                <input type="text" class="form-control" placeholder="" disabled
                                       :value="test.lesson.name">
                            </div>
                            <div class="mb-5" v-for="(question,questionIndex) in test.questions" :key="questionIndex">
                                <div class="wrapper">
                                    <div class="gray-bg">
                                        <div class="form-group row p-0">
                                            <label class="col-xl-3 col-form-label"> Question
                                                Type:</label>
                                            <div class="col-xl-6">
                                                <input type="text" class="form-control" placeholder="" disabled
                                                       :value="(questionType.MCQ === question.type) ? 'MCQ' : 'Reflexive'">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-3 px-lg-0 py-lg-3">
                                        <div class="px-0">
                                            <label>Question</label>
                                            <textarea class="form-control" rows="3" disabled
                                                      spellcheck="false">{{ question.text }}</textarea>
                                        </div>
                                    </div>
                                    <div class=" ml-lg-5 py-lg-3" v-if="question.type === questionType.MCQ">
                                        <div class="form-group row py-1" v-if="question.options.length">
                                            <div class="offset-xl-9 col-xl-3"> Answer</div>
                                        </div>
                                        <div class="form-group row py-1"
                                             v-for="(option, optionIndex) in question.options" :key="optionIndex">
                                            <label class="col-xl-2 col-form-label">Option {{ optionIndex + 1
                                                }}</label>
                                            <div class="col-xl-7">
                                                <input type="text" class="form-control" disabled :value="option.text">
                                            </div>
                                            <div class="d-flex justify-content-between responisve-block">
                                                <div class="responsive-text col-xl-1">
                                                    <input type="radio" v-model="option.is_answer" :name="questionIndex" disabled :value="option.is_answer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "test-view",
        data() {
            return {
                test: null,
                questionType: []
            }
        },
        created() {
            this.test = this.$attrs.test;
            this.questionType = this.$attrs.questiontype;
        },
    }
</script>
