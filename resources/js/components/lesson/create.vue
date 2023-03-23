<template>
    <div class="card shadow my-4">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Add Lesson</h6>
        </div>
        <div class="card-body">
            <div class="row add-course">
                <div class="col-md-9">
                    <form enctype="multipart/form-data">
                        <div class="common-border px-3 py-0">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="lesson-name">Name</label>
                                    <input type="text" class="form-control" id="lesson-name" name="lesson-name"
                                           v-model="form.name"
                                           :class="{'is-invalid':form.errors.has('name')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('name')"
                                          v-text="form.errors.first('name')"></span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="book-id">Book</label>
                                    <select class="custom-select" name="book-id" id="book-id"
                                            v-model="form.book_id"
                                            :class="{'is-invalid':form.errors.has('book_id')}">
                                        <option :value="null">Choose...</option>
                                        <option v-for="book in books" v-text="book.name"
                                                :value="book.id"></option>
                                    </select>
                                    <span class="help-block invalid-feedback"
                                          v-show="form.errors.has('book_id')"
                                          v-text="form.errors.first('book_id')"></span>
                                </div>
                            </div>
                            <draggable v-model="form.paragraphs"
                                       class="tb-lesson"
                                       @start="drag=true"
                                       @end="drag=false">
                                <div class="tb-lesson" v-for="(paragraph, paragraphIndex) in form.paragraphs"
                                     :key="paragraphIndex">
                                    <div class="gray-bg mx-0">
                                        <div class="form-row px-lg-3 justify-content-between">
                                            <div class="align-items-center d-flex py-1 ml-lg-0 ml-3">
                                                <label>Paragraphs {{ paragraphIndex + 1 }}</label></div>
                                            <div class="py-1">
                                                <div data-toggle="tooltip" title="Delete">
                                                    <button type="button"
                                                            @click.prevent="showDeleteParagraphModal(paragraphIndex)"
                                                            data-toggle="tooltip" title="Delete"
                                                            class="btn cross-btn">
                                                        delete
                                                    </button>
                                                </div>
                                                <span class="help-block invalid-feedback select-type"
                                                      style="display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group px-0 mt-3"
                                         :class="{'has-error':form.errors.has('paragraphs.'+paragraphIndex+'.content')}">
                                        <h2>Content</h2>
                                        <vue-editor :name="'paragraph-content-'+paragraphIndex"
                                                    :id="'paragraph-content-'+paragraphIndex"
                                                    :editor-toolbar="customToolbar"
                                                    v-model="paragraph.content" />
                                        <span class="text-danger small"
                                              v-show="form.errors.has('paragraphs.'+paragraphIndex+'.content')"
                                              v-text="form.errors.first('paragraphs.'+paragraphIndex+'.content')"></span>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="custom-file ">
                                                <input type="file" class="custom-file-input"
                                                       :name="'paragraph-image-'+paragraphIndex"
                                                       :id="'paragraph-image-'+paragraphIndex"
                                                       v-on:change="onParagraphImageChange($event, paragraphIndex)">
                                                <label class="custom-file-label"
                                                       :for="'paragraph-image-'+paragraphIndex"
                                                       v-text="paragraph.image_name">Choose file</label>
                                                <span class="small text-danger"
                                                      v-if="paragraph.image_validation_message"
                                                      v-text="paragraph.image_validation_message"></span>
                                                <div class="upload-img" v-show="paragraph.show_paragraph_image">
                                                    <img v-bind:src="paragraph.image">
                                                    <button @click.prevent="removeParagraphImage(paragraphIndex)"
                                                            class="close img-close">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <select class="form-control"
                                                    :name="'image-position-'+paragraphIndex"
                                                    :id="'image-position-'+paragraphIndex"
                                                    v-model="paragraph.image_position">
                                                <option value="null">Select Image Position</option>
                                                <option value="1">Top</option>
                                                <option value="0">Bottom</option>
                                            </select>
                                            <span class="text-danger small"
                                                  v-show="form.errors.has('paragraphs.'+paragraphIndex+'.image_position')"
                                                  v-text="form.errors.first('paragraphs.'+paragraphIndex+'.image_position')"></span>
                                        </div>
                                    </div>
                                    <div class="form-group px-0"
                                         v-for="(paragraphQuestion, paragraphQuestionIndex) in paragraph.questions">
                                        <h2 class="mt-3">Question {{ paragraphQuestionIndex + 1 }}</h2>
                                        <textarea class="form-control" rows="3"
                                                  :id="'paragraph-question-'+paragraphQuestionIndex"
                                                  v-model="paragraphQuestion.question"
                                                  :class="{'is-invalid':form.errors.has('paragraphs.'+paragraphIndex+'.questions.'+paragraphQuestionIndex+'.question')}"
                                                  spellcheck="false"></textarea>
                                        <span class="help-block invalid-feedback"
                                              v-show="form.errors.has('paragraphs.'+paragraphIndex+'.questions.'+paragraphQuestionIndex+'.question')"
                                              v-text="form.errors.first('paragraphs.'+paragraphIndex+'.questions.'+paragraphQuestionIndex+'.question')"></span>
                                        <div class="delete-btn" data-tooltip="delete">
                                            <button
                                                @click.prevent="showDeleteParagraphQuestionModal(paragraphIndex, paragraphQuestionIndex)"
                                                title="delete">Delete
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit" @click.prevent="addParagraphQuestion(paragraphIndex)"
                                            class="pl-3 add-btn text-blue">
                                        <span class="glyphicon glyphicon-plus"></span>+ Add another Question
                                    </button>
                                </div>
                            </draggable>
                            <div class="custom-btn d-flex justify-content-center text-capitalize" id="add-paragraph">
                                <button type="submit" @click.prevent="addParagraph()">
                                    <i class="fas fa-plus"></i>
                                    Add Another Paragraph
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="submit-row list-group ">
                        <button type="submit" @click.prevent="submit" title="Save" class="list-group-item"
                                id="save-lesson" name="_save">
                            <i class="fas fa-save"></i>
                            <span class="text">Save</span>
                        </button>
                    </div>
                </div>
                <delete-modal @confirm-delete="remove" :message-data="message" @close-delete="showDeletePopup=false"
                              v-if="showDeletePopup"></delete-modal>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'form-backend-validation';
import DeleteModal from '../modal/DeleteModal';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import draggable from 'vuedraggable';
import { VueEditor } from "vue2-editor";

export default {
    name: "book-create",
    props: {
        books: {
            type: Object | Array,
        },
    },
    data() {
        return {
            form: new Form(),
            showDeletePopup: false,
            lessonIndex: null,
            selectedParagraphIndex: null,
            selectedParagraphQuestionIndex: null,
            message: '',
            isLoading: false,
            isFullPage: true,
            validForm: true,
            customToolbar: [
                [{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
                ['blockquote'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                [{ 'color': [] }, { 'background': [] }],
                ['link'],
                ['clean'],
            ]
        };
    },
    mounted() {
        this.initForm()
    },
    components: {
        DeleteModal,
        Loading,
        draggable,
        VueEditor
    },
    methods: {
        initForm() {
            this.form = new Form({
                name: null,
                book_id: null,
                paragraphs: [{
                    content: null,
                    image: null,
                    image_position: null,
                    image_extension: null,
                    image_name: 'Choose Image',
                    order_number: null,
                    show_paragraph_image: false,
                    image_validation_message: null,
                    questions: [{
                        question: null,
                    }]
                }]
            })
        },
        onParagraphImageChange(event, paragraphIndex) {
            this.validForm = false;
            let file = event.target.files[0];
            let extension = file.name.split('.').pop();

            this.validForm = this.validateParagraphImage(file, paragraphIndex);

            if (this.validForm) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = function () {
                    vm.form.paragraphs[paragraphIndex].image = reader.result;
                };
                reader.readAsDataURL(file);
                this.form.paragraphs[paragraphIndex].image_extension = extension;
                this.form.paragraphs[paragraphIndex].show_paragraph_image = true;
            } else {
                this.form.paragraphs[paragraphIndex].image_name = null;
            }
        },
        removeParagraphImage(paragraphIndex) {
            this.form.paragraphs[paragraphIndex].image = null;
            this.form.paragraphs[paragraphIndex].image_extension = null;
            this.form.paragraphs[paragraphIndex].image_name = 'Choose Image';
            this.form.paragraphs[paragraphIndex].show_paragraph_image = false;
        },
        async submit() {
            if (this.validForm) {
                this.isLoading = true;
                try {
                    const response = await this.form.post('/lessons');

                    if (response.status === true) {
                        this.isLoading = false;
                        this.$toasted.success(response.message);
                        setTimeout(() => window.location.href = route('lessons.index'), 500);
                    } else {
                        this.isLoading = false;
                        this.$toasted.error(response.message);
                    }
                } catch (e) {
                    this.isLoading = false;
                    this.$toasted.error('Unable to create the lesson.');
                }
            }
        },
        validateParagraphImage(file, paragraphIndex) {
            this.form.paragraphs[paragraphIndex].image_validation_message = null;

            if (file.size > 1024 * 1024) {
                this.form.paragraphs[paragraphIndex].image_validation_message = 'Cover image size should be less than 2MB.';
                return false;
            }

            if (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/jpg') {
                this.form.paragraphs[paragraphIndex].image_name = file.name;
            } else {
                this.form.paragraphs[paragraphIndex].image_validation_message = 'Incorrect image type.';
                return false;
            }
            return true;
        },
        addParagraph() {
            this.form.paragraphs.push({
                content: null,
                image: null,
                image_position: null,
                image_extension: null,
                image_name: 'Choose Image',
                order_number: null,
                show_paragraph_image: false,
                image_validation_message: null,
                questions: [{
                    question: null,
                }]
            });
        },
        addParagraphQuestion(paragraphIndex) {
            this.form.paragraphs[paragraphIndex].questions.push({
                question: null,
            })
        },
        showDeleteParagraphModal(paragraphIndex) {
            this.showDeletePopup = true;
            this.message = 'Are you sure you want to delete this paragraph?';
            this.selectedParagraphIndex = paragraphIndex;
        },
        showDeleteParagraphQuestionModal(paragraphIndex, paragraphQuestionIndex) {
            this.showDeletePopup = true;
            this.message = 'Are you sure you want to delete this paragraph question?';
            this.selectedParagraphIndex = paragraphIndex;
            this.selectedParagraphQuestionIndex = paragraphQuestionIndex;
        },
        remove() {
            if (this.selectedParagraphIndex !== null) {
                if (this.selectedParagraphQuestionIndex !== null) {
                    this.form.paragraphs[this.selectedParagraphIndex].questions.splice(this.selectedParagraphQuestionIndex, 1);
                    this.$toasted.success('Paragraph question deleted successfully.');
                } else {
                    this.form.paragraphs.splice(this.selectedParagraphIndex, 1);
                    this.$toasted.success('Paragraph deleted successfully.');
                }
            }
            this.selectedParagraphIndex = null;
            this.selectedParagraphQuestionIndex = null;
            this.showDeletePopup = false;
        }
    }
}
</script>
