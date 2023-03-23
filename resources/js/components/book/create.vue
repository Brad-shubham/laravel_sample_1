<template>
    <div class="card shadow my-4">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Add Book</h6>
        </div>
        <div class="card-body">
            <div class="row add-course">
                <div class="col-md-9">
                    <form enctype="multipart/form-data">
                        <div class="common-border px-3 py-0">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="book-name">Book Name</label>
                                    <input type="text" class="form-control" name="book-name" id="book-name"
                                           placeholder="" v-model="form.name"
                                           :class="{'is-invalid':form.errors.has('name')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('name')"
                                          v-text="form.errors.first('name')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="author-name">Author Name</label>
                                    <input type="text" class="form-control" name="author-name" id="author-name"
                                           placeholder="" v-model="form.author"
                                           :class="{'is-invalid':form.errors.has('author')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('author')"
                                          v-text="form.errors.first('author')"></span>
                                </div>
                            </div>

                            <div class="gray-bg mx-0">
                                <div class="form-row px-lg-3">
                                    <div class="form-group col-xl-2 py-1 align-items-center d-flex">
                                        <label for="course-id">Course Name</label>
                                    </div>
                                    <div class="form-group col-xl-10 py-1">
                                        <div class="input-group">
                                            <select class="custom-select" name="course-id" id="course-id"
                                                    v-model="form.course_id"
                                                    :class="{'is-invalid':form.errors.has('course_id')}">
                                                <option  :value="null">Choose...</option>
                                                <option v-for="course in courses" v-text="course.name"
                                                        :value="course.id"></option>
                                            </select>
                                            <span class="help-block invalid-feedback select-type"
                                                  v-show="form.errors.has('course_id')"
                                                  v-text="form.errors.first('course_id')"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tb-publisher">
                                <div class="form-group px-0" :class="{'has-error':form.errors.has('publisher')}">
                                    <label for="publisher-detail">Publisher Detail</label>
                                    <vue-editor name="publisher-detail" id="publisher-detail"
                                                :editor-toolbar="customToolbar"
                                                v-model="form.publisher"/>
                                    <span class="text-danger small" v-show="form.errors.has('publisher')"
                                          v-text="form.errors.first('publisher')"></span>
                                </div>
                                <div class="form-group col-xl-6 col-md-12 m-0 p-0">
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" name="cover_image" id="cover-image"
                                               v-on:change="onCoverChange">
                                        <label class="custom-file-label" for="cover-image" v-text="form.cover_image_name">Choose
                                            file</label>
                                        <span class="small text-danger" v-if="customValidation.cover_image"
                                              v-text="customValidation.cover_image"></span>
                                        <div class="upload-img" v-show="showCoverImage">
                                            <img v-bind:src="form.cover_image">
                                            <button @click.prevent="removeCoverImage" class="close img-close">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-for="(bookSection, bookSectionIndex) in form.book_sections" :key="bookSectionIndex"
                                 class="multiple-publisher common-border">
                                <div class="form-row">
                                    <div class="form-group col-md-12 p-0 mb-3">
                                        <label :for="'book-section-title-'+ bookSectionIndex">Title</label>
                                        <input type="text" class="form-control"
                                               :id="'book-section-title-'+ bookSectionIndex" v-model="bookSection.title"
                                               placeholder=""
                                               :class="{'is-invalid':form.errors.has('book_sections.'+bookSectionIndex+'.title')}">
                                        <span class=" help-block invalid-feedback"
                                              v-show="form.errors.has('book_sections.'+bookSectionIndex+'.title')"
                                              v-text="form.errors.first('book_sections.'+bookSectionIndex+'.title')"></span>
                                    </div>
                                    <div class="form-group col-md-12 p-0 mb-3" :class="{'has-error':form.errors.has('book_sections.'+bookSectionIndex+'.content')}">
                                        <label :for="'book-section-content-'+ bookSectionIndex">Content</label>
                                        <vue-editor :name="'book-section-content-'+ bookSectionIndex"
                                                    :id="'book-section-content-'+ bookSectionIndex"
                                                    :editor-toolbar="customToolbar"
                                                    v-model="bookSection.content"/>
                                        <span class="text-danger small"
                                              v-show="form.errors.has('book_sections.'+bookSectionIndex+'.content')"
                                              v-text="form.errors.first('book_sections.'+bookSectionIndex+'.content')"></span>
                                    </div>
                                    <div class="form-group col-xl-6 col-md-12 m-0 p-0">
                                        <div class="custom-file mb-3">
                                            <input type="file" class="custom-file-input"
                                                   :name="'book-section-image-'+bookSectionIndex"
                                                   :id="'book-section-image-'+bookSectionIndex"
                                                   v-on:change="onBookSectionImageChange($event, bookSectionIndex)">
                                            <label class="custom-file-label"
                                                   :for="'book-section-image-'+bookSectionIndex"
                                                   v-text="bookSection.image_name">Choose Image</label>
                                            <span class="small text-danger" v-if="bookSection.image_validation_message"
                                                  v-text="bookSection.image_validation_message"></span>
                                            <div class="upload-img" v-show="bookSection.show_image">
                                                <img v-bind:src="bookSection.image">
                                                <button @click.prevent="removeBookSectionImage(bookSectionIndex)"
                                                        class="close img-close">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="delete-btn form-group col-md-12 p-0" data-tooltip="delete">
                                        <button @click.prevent="showDeleteBookSectionModal(bookSectionIndex)"
                                                title="delete">Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="custom-btn d-flex justify-content-center text-capitalize">
                        <button @click.prevent="addBookSection">
                            <i class="fas fa-plus"></i>
                            Add Another Section
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="submit-row list-group ">
                        <button type="submit" @click.prevent="submit" title="Save" class="list-group-item"
                                id="save-book" name="_save">
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
    import { VueEditor } from "vue2-editor";

    export default {
        name: "book-create",
        props: {
            courses: {
                type: Object | Array,
            },
        },
        data() {
            return {
                form: new Form(),
                showDeletePopup: false,
                bookSectionIndex: null,
                message: '',
                isLoading: false,
                isFullPage: true,
                formData: null,
                customValidation: {
                    cover_image: null,
                },
                showCoverImage: false,
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
            this.initForm();
        },
        components: {
            DeleteModal,
            Loading,
            VueEditor,
        },
        methods: {
            initForm() {
                this.form = new Form({
                    name: null,
                    author: null,
                    course_id: null,
                    publisher: null,
                    cover_image: null,
                    cover_image_name: 'Choose Image',
                    extension: null,
                    book_sections: [{
                        title: null,
                        content: null,
                        image: null,
                        image_name: 'Choose Image',
                        image_extension: null,
                        show_image: false,
                        image_validation_message: null,
                    }]
                })
            },
            onCoverChange(event) {
                this.validForm = false;
                let file = event.target.files[0];
                let extension = file.name.split('.').pop();

                this.validForm = this.validateCoverImage(file);

                if (this.validForm) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = function () {
                        vm.form.cover_image = reader.result;
                    };
                    reader.readAsDataURL(file);
                    this.form.extension = extension;
                    this.showCoverImage = true;
                } else {
                    this.form.cover_image_name = null;
                    this.showCoverImage = false;
                }
            },
            removeCoverImage(){
                this.form.cover_image = null;
                this.form.extension = null;
                this.form.cover_image_name = 'Choose Image';
                this.showCoverImage = false;
            },
            validateCoverImage(file) {
                this.customValidation.cover_image = null;

                if (file.size > 1024 * 1024) {
                    this.customValidation.cover_image = 'Cover image size should be less than 2MB.';
                    return false;
                }

                if (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/jpg') {
                    this.form.cover_image_name = file.name;
                } else {
                    this.customValidation.cover_image = 'Incorrect image type.';
                    return false;
                }
                return true;

            },
            onBookSectionImageChange(event, bookSectionIndex) {
                this.validForm = false;
                let file = event.target.files[0];
                let extension = file.name.split('.').pop();

                this.validForm = this.validateBookSectionImage(file, bookSectionIndex);

                if (this.validForm) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = function () {
                        vm.form.book_sections[bookSectionIndex].image = reader.result;
                    };
                    reader.readAsDataURL(file);
                    this.form.book_sections[bookSectionIndex].image_extension = extension;
                    this.form.book_sections[bookSectionIndex].show_image = true;
                } else {
                    this.form.book_sections[bookSectionIndex].image_name = null;
                }
            },
            removeBookSectionImage(bookSectionIndex){
                this.form.book_sections[bookSectionIndex].image = null;
                this.form.book_sections[bookSectionIndex].image_extension = null;
                this.form.book_sections[bookSectionIndex].image_name = 'Choose Image';
                this.form.book_sections[bookSectionIndex].show_image = false;
            },
            validateBookSectionImage(file, bookSectionIndex) {
                this.form.book_sections[bookSectionIndex].image_validation_message = null;

                if (file.size > 1024 * 1024) {
                    this.form.book_sections[bookSectionIndex].image_validation_message = 'Book Section image size should be less than 2MB.';
                    return false;
                }

                if (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/jpg') {
                    this.form.book_sections[bookSectionIndex].image_name = file.name;
                } else {
                    this.form.book_sections[bookSectionIndex].image_validation_message = 'Incorrect image type.';
                    return false;
                }
                return true;
            },
            async submit() {
                if (this.validForm) {
                    this.isLoading = true;
                    try {
                        const response = await this.form.post('/books');

                        if (response.status === true) {
                            this.isLoading = false;
                            this.$toasted.success(response.message);
                            setTimeout(() => window.location.href = route('books.index'), 500);
                        } else {
                            this.isLoading = false;
                            this.$toasted.error(response.message);
                        }
                    } catch (e) {
                        this.isLoading = false;
                        this.$toasted.error('Unable to create the book.')
                    }
                }

            },
            deleteBook() {
                this.isLoading = true;
                this.$http.delete(route('books.destroy', this.book.id))
                    .then(response => {
                        if (response.data.status === true) {
                            this.isLoading = false;
                            this.$toasted.success(response.data.message);
                            setTimeout(() => window.location.href = route('books.index'), 500);
                        } else {
                            this.isLoading = false;
                            this.$toasted.error(response.data.message);
                            setTimeout(() => window.location.href = route('books.index'), 500);
                        }
                    })
                    .catch(error => {
                        this.isLoading = false;
                        this.$toasted.error('Unable to delete book.');
                    })
            },
            addBookSection() {
                this.form.book_sections.push({
                    title: null,
                    content: null,
                    image: null,
                    image_name: 'Choose Image',
                    image_extension: null,
                    show_image: false,
                    image_validation_message: null,
                })
            },
            showDeleteBookSectionModal(bookSectionIndex) {
                this.showDeletePopup = true;
                this.message = 'Are you sure you want to delete this book section?';
                this.selectedBookSectionIndex = bookSectionIndex;
            },
            remove() {
                if (this.selectedBookSectionIndex === null) {
                    this.deleteBook();
                } else {
                    this.form.book_sections.splice(this.selectedBookSectionIndex, 1);
                    this.$toasted.success('Book section deleted successfully.');
                }
                this.selectedBookSectionIndex = null;
                this.showDeletePopup = false;
            }
        }
    }
</script>
