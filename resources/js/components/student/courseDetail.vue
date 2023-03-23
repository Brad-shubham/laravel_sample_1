<template>
    <div class="card shadow my-4">
      <loading :active="isLoading"
               loader="dots"
               :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Course Details</h6>
        </div>
        <div class="card-body">
            <div class="row tb-view-list">
                <div class="col-md-9 text-dark">
                    <div class="common-border p-0">
                        <div class=" pt-4">
                            <div class="tb-test-title pl-lg-3 px-2">
                                <h1 class="d-inline-block">
                                    Course:
                                </h1>
                                <label readonly>
                                    {{ course.name }}
                                </label>
                            </div>
                            <div class="pl-lg-3 px-2">
                                <h3 class="d-inline-block">Books</h3>
                                <div>
                                  <div class="mb-5 d-inline" v-for="(book, index) in course.books" :key="index">
                                    <label>{{ book.name }}</label>
                                    <button @click="unlockBook(book)" class="btn btn-sm btn-primary btn-icon-split sm-top m-2" >
                                      <span class="text">Unlock</span>
                                    </button>
                                  </div>
                                  <hr>
                                  <button @click="unlockAllBooks(course)" class="btn btn-sm btn-primary btn-icon-split sm-top m-2" >
                                    <span class="text">Unlock All Books</span>
                                  </button>
                                  <hr>
                                </div>
                              </div>
                        </div>
                        <div class="mb-5" v-for="(lesson, index) in course.lessons" :key="index">
                            <div class="tb-test-lesson pl-lg-3 px-2">
                                <h1 class="d-inline-block">
                                    Lesson:
                                </h1>
                                <label>{{ lesson.name }}</label>
                                <hr>
                                <div v-if="!(lesson.lesson_status && lesson.lesson_status.is_unlocked)" class="pl-lg-5 d-lg-flex px-2">
                                  <button @click="courseAction(lesson)" class="btn btn-primary btn-icon-split sm-top" >
                                    <span class="text">Unlock</span>
                                  </button>
                                </div>
                                <hr>
                            </div>
                            <div v-for="(paragraphAnswer,index) in lesson.paragraph_answers" :key="index">
                                <div class="pl-lg-5 d-lg-flex px-2">
                                    <span class="pr-lg-2  font-weight-bold">Question:</span>
                                    <p>{{ paragraphAnswer.paragraph_question.question }}</p>
                                </div>
                                <div class="pl-lg-5 px-2">
                                    <p>{{ paragraphAnswer.answer }}</p>
                                </div>
                                <hr v-if="(index + 1) < lesson.paragraph_answers.length"/>
                            </div>
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
import axios from "axios";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    name: "student-course-detail",
    data() {
        return {
            student: [],
            course: [],
          isLoading : false,
          isFullPage: true,
        }
    },
  components: {
    Loading,
  },
    created() {
        this.student = this.$attrs.student;
        this.course = this.$attrs.course;

    },
  methods: {
    courseAction(lesson) {
      this.isLoading = true;
      axios.post(`/students/${this.student.id}/courses/${this.course.id}/lessons/${lesson.id}`)
          .then(response => {
            this.student = response.data.student;
            this.course = response.data.course;
            this.$toasted.success('Lesson Unlocked Successfully.');
            window.location.reload();
          })
          .catch(errors => {
            this.isLoading = false;
            this.$toasted.error('Something went wrong.');
          })
    },
    unlockBook(book) {
      this.isLoading = true;
      axios.post(`/students/${this.student.id}/courses/${this.course.id}/books/${book.id}`)
          .then(response => {
            this.$toasted.success('Book Unlocked Successfully.');
            window.location.reload();
          })
          .catch(errors => {
            this.isLoading = false;
            this.$toasted.error('Something went wrong.');
          })
    },
    unlockAllBooks(course) {
      this.isLoading = true;
      axios.post(`/students/${this.student.id}/courses/${this.course.id}/unlockbooks`)
          .then(response => {
            this.$toasted.success('All Books Unlocked Successfully.');
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
