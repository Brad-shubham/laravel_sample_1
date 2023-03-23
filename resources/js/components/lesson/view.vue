<template>
    <div class="card shadow my-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">View Lesson</h6>
        </div>
        <div class="card-body">
            <div class="row add-course">
                <div class="col-md-12">
                    <form enctype="multipart/form-data">
                        <div class="common-border px-3 py-0">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="lesson-name">Name</label>
                                    <input type="text" class="form-control" id="lesson-name" name="lesson-name"
                                           :value="lesson.name" disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="book-id">Book</label>
                                    <input class="custom-select" name="book-id" id="book-id"
                                            :value="book_name" disabled>
                                </div>
                            </div>

                            <div class="tb-lesson" v-for="(paragraph, paragraphIndex) in lesson.paragraphs">
                                <div class="gray-bg mx-0">
                                    <div class="form-row px-lg-3 justify-content-between">
                                        <div class="align-items-center d-flex py-1 ml-lg-0 ml-3">
                                            <label>Paragraphs {{paragraphIndex +1}}</label></div>
                                    </div>
                                </div>
                                <div class="form-group px-0">
                                    <h2>Content</h2>
                                    <trumbowyg :name="'paragraph-content-'+paragraphIndex"
                                               :id="'paragraph-content-'+paragraphIndex"
                                               :value="paragraph.content" :config="config"
                                               class="form-control" :disabled="true"></trumbowyg>
                                </div>
                                <div class="form-group col-md-6 m-0  p-0">
                                    <h2>Image</h2>
                                    <div class="custom-file mb-2">
                                        <input type="file" class="custom-file-input"
                                               :name="'paragraph-image-'+paragraphIndex"
                                               :id="'paragraph-image-'+paragraphIndex" disabled>
                                        <label class="custom-file-label" :for="'paragraph-image-'+paragraphIndex"
                                               v-text="paragraph.image_name">Choose file</label>
                                        <div class="upload-img" v-show="paragraph.show_paragraph_image">
                                            <img v-bind:src="paragraph.image">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group px-0"
                                     v-for="(paragraphQuestion, paragraphQuestionIndex) in paragraph.questions">
                                    <h2>Question {{paragraphQuestionIndex +1}}</h2>
                                    <textarea class="form-control" rows="3"
                                              :id="'paragraphs.'+paragraphIndex+'.questions.'+paragraphQuestionIndex+'.question'"
                                              :value="paragraphQuestion.question" disabled spellcheck="false"></textarea>
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
    import Trumbowyg from 'vue-trumbowyg';
    import 'trumbowyg/dist/plugins/fontsize/trumbowyg.fontsize.min.js';
    import 'trumbowyg/dist/ui/trumbowyg.css';

    export default {
        name: "lesson-edit",
        props: {
            lesson: {
                type: Object | Array,
                required: true,
            },
            books: {
                type: Object | Array,
            },
        },
        data() {
            return {
                book_name: null,
                config:{
                    removeformatPasted: true,
                    btns: [
                        ['formatting'],
                        ['fontsize'],
                        ['strong', 'em', 'del'],
                        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                        ['link'],
                        ['unorderedList', 'orderedList'],
                        ['horizontalRule'],
                        ['removeformat'],
                        ['undo', 'redo'],
                        ['fullscreen']
                    ]
                },
            };
        },
        components: {
            Trumbowyg,
        },
        created() {
            this.lesson.paragraphs.forEach((paragraph) => {
                if (paragraph.image != null) {
                    paragraph.show_paragraph_image = true;
                }else{
                    paragraph.image_name = 'No Image';
                }
            });

            this.books.forEach((book) => {
                if(book.id === this.lesson.book_id){
                    this.book_name = book.name;
                }
            });
        },
    }
</script>
