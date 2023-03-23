<template>
    <div class="card shadow my-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">View Course</h6>
        </div>
        <div class="card-body">
            <div class="row add-course">
                <div class="col-md-12">
                    <form>
                        <div class="common-border p-0">
                            <div class="form-group row">
                                <div class="col-md-6 pl-lg-3">
                                    <label for="course-name">Course Name</label>
                                    <input type="text" class="form-control" name="course-name" id="course-name"
                                           placeholder="Course Name" :value="course.name" disabled>
                                </div>
                            </div>
                            <div v-for="(book, bookIndex) in course.books" :key="bookIndex">
                                <div class="gray-bg">
                                    <div class="form-group row p-0">
                                        <label :for="'book-' + bookIndex" class="col-xl-2  col-form-label">
                                            Book:
                                            {{bookIndex + 1}}</label>
                                        <div class="col-xl-8 ">
                                            <input type="text" class="form-control" name="book-name"
                                                   :id="'book-' + bookIndex"
                                                   :value="book.name"
                                                   placeholder="Book Name" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-lg-5 py-lg-3 mt-3">
                                    <div class="form-group row py-1" v-for="(lesson, lessonIndex) in book.lessons"
                                         :key="lessonIndex">
                                        <label :for="'book-' + bookIndex + '-lesson-'+ lessonIndex"
                                               class="col-xl-2 col-md-4 col-form-label">Lesson
                                            {{lessonIndex +1}}</label>
                                        <div class="col-xl-4 col-md-5">
                                            <input type="text" class="form-control" name="lesson-name"
                                                   :id="'book-' + bookIndex + '-lesson-'+ lessonIndex"
                                                   placeholder="Lesson Name" :value="lesson.name" disabled>
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
        name: "course-view",
        props: {
            course: {
                type: Object | Array,
                required: true
            }
        },
    }
</script>
