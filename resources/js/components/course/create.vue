<template>
    <div class="card shadow my-4">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Add Course</h6>
        </div>
        <div class="card-body">
            <div class="row add-course">
                <div class="col-md-9">
                    <form>
                        <div class="common-border p-0">
                            <div class="form-group row">
                                <div class="col-md-6 pl-lg-3">
                                    <label for="course-name">Course ID</label>
                                    <input type="text" class="form-control" name="portal-course-id" id="portal-course-id"
                                           placeholder="Course ID" v-model="form.portal_course_id"
                                           :class="{'is-invalid':form.errors.has('portal_course_id')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('portal_course_id')"
                                          v-text="form.errors.first('portal_course_id')"></span>
                                </div>
                                <div class="col-md-6 pl-lg-3">
                                    <label for="course-name">Course Name</label>
                                    <input type="text" class="form-control" name="course-name" id="course-name"
                                           placeholder="Course Name" v-model="form.name"
                                           :class="{'is-invalid':form.errors.has('name')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('name')"
                                          v-text="form.errors.first('name')"></span>
                                </div>
                            </div>
                            <div v-for="(book, bookIndex) in form.books" :key="bookIndex">
                                <div class="gray-bg">
                                    <div class="form-group row p-0">
                                        <label :for="'book-' + bookIndex" class="col-xl-2 col-form-label">
                                            Book:
                                            {{bookIndex + 1}}</label>
                                        <div class="col-xl-8">
                                            <input type="text" class="form-control" name="book-name"
                                                   :id="'book-' + bookIndex"
                                                   v-model="book.name"
                                                   placeholder="Book Name"
                                                   :class="{'is-invalid':form.errors.has('books.'+bookIndex+'.name')}">
                                            <span class="help-block invalid-feedback"
                                                  v-show="form.errors.has('books.'+bookIndex+'.name')"
                                                  v-text="form.errors.first('books.'+bookIndex+'.name')"></span>
                                        </div>
                                        <div data-toggle="tooltip" class="d-flex align-items-center" title="Delete">
                                            <div
                                                class="responsive-text tb-trash col-xl-2"
                                                data-target="#exampleModal">
                                                <button class="btn btn-sm cross-btn"
                                                        @click.prevent="showDeleteBookModal(bookIndex)"
                                                        data-toggle="tooltip"
                                                        title="Delete">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-lg-5 py-lg-3 mt-3">
                                    <div class="form-group row py-1" v-for="(lesson, lessonIndex) in book.lessons"
                                         :key="lessonIndex">
                                        <label :for="'book-' + bookIndex + '-lesson-'+ lessonIndex" class="col-xl-2 col-md-4 col-form-label">Lesson
                                            {{lessonIndex +1}}</label>
                                        <div class="col-xl-4 col-md-5">
                                            <input type="text" class="form-control" name="lesson-name"
                                                   :id="'book-' + bookIndex + '-lesson-'+ lessonIndex"
                                                   placeholder="Lesson Name" v-model="lesson.name"
                                                   :class="{'is-invalid':form.errors.has('books.'+bookIndex+'.lessons.'+lessonIndex+'.name')}">
                                            <span class="help-block invalid-feedback"
                                                  v-show="form.errors.has('books.'+bookIndex+'.lessons.'+lessonIndex+'.name')"
                                                  v-text="form.errors.first('books.'+bookIndex+'.lessons.'+lessonIndex+'.name')"></span>
                                        </div>
                                        <div data-toggle="tooltip" title="Delete">
                                            <div
                                                class="responsive-text tb-trash col-xl-3 col-md-2 d-flex align-items-center">
                                                <button class="btn btn-sm custom-popup"
                                                        @click.prevent="showDeleteLessonModal(bookIndex, lessonIndex)"
                                                        data-toggle="tooltip"
                                                        title="Delete">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="py-3 pl-3 add-btn text-blue" @click.prevent="addLesson(bookIndex)">
                                        <span class="glyphicon glyphicon-plus"></span>+ Add another Lesson
                                    </button>
                                </div>
                            </div>
                            <div class="custom-btn d-flex justify-content-center text-capitalize" id="add-book">
                                <button @click.prevent="addBook">
                                    <i class="fas fa-plus"></i>
                                    Add book
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="submit-row list-group ">
                        <button type="button" @click.prevent="submit" title="Save"
                                class="list-group-item" id="save-course"
                                name="_save">
                            <i class="fas fa-save"></i>
                            <span class="text">Save</span>
                        </button>
                    </div>
                </div>
            </div>
            <delete-modal @confirm-delete="remove" :message-data="message" @close-delete="showDeletePopup=false"
                          v-if="showDeletePopup"></delete-modal>
        </div>
    </div>
</template>

<script>
    import Form from 'form-backend-validation';
    import DeleteModal from '../modal/DeleteModal'
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: "course-create",
        data() {
            return {
                form: new Form(),
                selectedBookIndex: null,
                selectedLessonIndex: null,
                showDeletePopup: false,
                message: '',
                isLoading: false,
                isFullPage: true,
            }
        },
        mounted() {
            this.initForm();
        },
        components: {
            DeleteModal,
            Loading,
        },
        methods: {
            initForm() {
                this.form = new Form({
                    portal_course_id: null,
                    name: null,
                    books: [{
                        name: null,
                        lessons: [{
                            name: null,
                        }, {
                            name: null,
                        }, {
                            name: null,
                        }]
                    }]
                }, {resetOnSuccess: false});
            },
            async submit() {
                this.isLoading = true;
                try {
                    const response = await this.form.post('/courses');

                    if (response.status === true) {
                        this.isLoading = false;
                        this.$toasted.success(response.message);
                        setTimeout(() => window.location.href = route('courses.index'), 500);
                    } else {
                        this.isLoading = false;
                        this.$toasted.error(response.message);
                    }
                } catch (e) {
                    this.isLoading = false;
                    this.$toasted.error('Unable to create the course.')
                }
            },
            addBook() {
                this.form.books.push({
                    name: null,
                    lessons: [{
                        name: null,
                    }, {
                        name: null,
                    }, {
                        name: null,
                    }]
                });
            },
            showDeleteBookModal(bookIndex) {
                this.showDeletePopup = true;
                this.message = 'Are you sure you want to delete this book?';
                this.selectedBookIndex = bookIndex;
            },
            removeBook(index) {
                this.form.books.splice(index, 1);
            },
            addLesson(bookIndex) {
                this.form.books[bookIndex].lessons.push({
                    name: null,
                })
            },
            showDeleteLessonModal(bookIndex, lessonIndex = null) {
                this.showDeletePopup = true;
                this.message = 'Are you sure you want to delete this lesson?';
                this.selectedBookIndex = bookIndex;
                this.selectedLessonIndex = lessonIndex;
            },
            remove() {
                if (this.selectedLessonIndex === null) {
                    this.form.books.splice(this.selectedBookIndex, 1);
                    this.$toasted.success('Book deleted successfully.');
                } else {
                    this.form.books[this.selectedBookIndex].lessons.splice(this.selectedLessonIndex, 1);
                    this.$toasted.success('Lesson deleted successfully.');
                }
                this.selectedBookIndex = null;
                this.selectedLessonIndex = null;
                this.showDeletePopup = false;
            }
        }
    }
</script>
