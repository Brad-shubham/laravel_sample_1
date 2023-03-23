<template>
    <div class="card shadow my-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">View Book</h6>
        </div>
        <div class="card-body">
            <div class="row add-course">
                <div class="col-md-12">
                    <form enctype="multipart/form-data">
                        <div class="common-border px-3 py-0">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="book-name">Book Name</label>
                                    <input type="text" class="form-control" name="book-name" id="book-name"
                                           placeholder="" :value="book.name" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="author-name">Author Name</label>
                                    <input type="text" class="form-control" name="author-name" id="author-name"
                                           placeholder="" :value="book.author" disabled>
                                </div>
                            </div>

                            <div class="gray-bg mx-0">
                                <div class="form-row px-lg-3">
                                    <div class="form-group col-xl-2 py-1 align-items-center d-flex">
                                        <label for="course-id">Course Name</label>
                                    </div>
                                    <div class="form-group col-xl-10 py-1">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="course-name" id="course-name"
                                                   placeholder="" :value="course_name" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tb-publisher">
                                <div class="form-group px-0">
                                    <label for="publisher-detail">Publisher Detail</label>
                                    <trumbowyg name="publisher-detail" id="publisher-detail" :value="book.publisher"
                                               :config="config" :disabled="true"></trumbowyg>
                                </div>
                                <div class="form-group col-xl-6 col-md-12 m-0 p-0">
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" name="cover_image" id="cover-image"
                                               disabled>
                                        <label class="custom-file-label" for="cover-image" v-text="book.cover_image_name">Choose
                                            file</label>
                                        <div class="upload-img" v-show="showCoverImage">
                                            <img v-bind:src="book.cover_image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-for="(bookSection, bookSectionIndex) in book.book_sections" :key="bookSectionIndex"
                                 class="multiple-publisher common-border">
                                <div class="form-row">
                                    <div class="form-group col-md-12 p-0 mb-3">
                                        <label :for="'book-section-title-'+ bookSectionIndex">Title</label>
                                        <input type="text" class="form-control"
                                               :id="'book-section-title-'+ bookSectionIndex" :value="bookSection.title"
                                               placeholder="" disabled>
                                    </div>
                                    <div class="form-group col-md-12 p-0">
                                        <label :for="'book-section-content-'+ bookSectionIndex">Content</label>
                                        <trumbowyg :name="'book-section-content-'+ bookSectionIndex"
                                                   :id="'book-section-content-'+ bookSectionIndex"
                                                   v-model="bookSection.content" :config="config"
                                                   class="form-control" :disabled="true"></trumbowyg>
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
    import Trumbowyg from 'vue-trumbowyg';
    import 'trumbowyg/dist/plugins/fontsize/trumbowyg.fontsize.min.js';
    import 'trumbowyg/dist/ui/trumbowyg.css';

    export default {
        name: "book-view",
        props: {
            book: {
                type: Object | Array,
                required: true,
            },
            courses: {
                type: Object | Array,
            },
        },
        data() {
            return {
                course_name: null,
                showCoverImage: false,
                config: {
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
                }
            };
        },
        components: {
            Trumbowyg,
        },
        created() {
            if(this.book.cover_image != null){
                this.showCoverImage = true;
            }

            this.courses.forEach((course) => {
                if(course.id === this.book.course_id){
                    this.course_name = course.name;
                }
            });
        },
    }
</script>
