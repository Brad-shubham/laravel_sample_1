<template>
    <div class="card shadow mb-4">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Add Student</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9 tb-student-add">
                    <form method="POST">
                        <div class="common-border heading-one">
                            <h1>Personal Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           v-model="form.email" :class="{'is-invalid':form.errors.has('email')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('email')"
                                          v-text="form.errors.first('email')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="surname">Surname*</label>
                                    <input type="text" class="form-control" name="surname" id="surname"
                                           v-model="form.surname"
                                           :class="{'is-invalid':form.errors.has('surname')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('surname')"
                                          v-text="form.errors.first('surname')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first-name">First Name*</label>
                                    <input type="text" class="form-control" name="first_name" id="first-name"
                                           v-model="form.first_name"
                                           :class="{'is-invalid':form.errors.has('first_name')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('first_name')"
                                          v-text="form.errors.first('first_name')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="middle-name">Second Name</label>
                                    <input type="text" class="form-control" name="middle_name" id="middle-name"
                                           v-model="form.middle_name"
                                           :class="{'is-invalid':form.errors.has('middle_name')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('middle_name')"
                                          v-text="form.errors.first('middle_name')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="country-code">Country Code*</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">+</div>
                                        </div>
                                        <input type="text" class="form-control" name="country_code"
                                               id="country-code"
                                               v-model="form.country_code"
                                               :class="{'is-invalid':form.errors.has('country_code')}">
                                        <span class="help-block invalid-feedback"
                                              v-show="form.errors.has('country_code')"
                                              v-text="form.errors.first('country_code')"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-10">
                                    <label for="phone">Phone Number*</label>
                                    <input type="text" class="form-control" name="phone_number" id="phone"
                                           v-model="form.phone_number"
                                           :class="{'is-invalid':form.errors.has('phone_number')}">
                                    <span class="help-block invalid-feedback"
                                          v-show="form.errors.has('phone_number')"
                                          v-text="form.errors.first('phone_number')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="is-old">Is old student</label>
                                    <select class="form-control" id="is-old" name="is_old"
                                            v-model="form.is_old" @change="onIsOldChange"
                                            :class="{'is-invalid':form.errors.has('is_old')}">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('is_old')"
                                          v-text="form.errors.first('is_old')"></span>
                                </div>
                                <div class="form-group col-md-6" v-if="isOldStatus">
                                    <label for="old-student-id">Old Student ID</label>
                                    <input type="text" class="form-control" name="old_student_id" id="old-student-id"
                                           v-model="form.old_student_id"
                                           :class="{'is-invalid':form.errors.has('old_student_id')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('old_student_id')"
                                          v-text="form.errors.first('old_student_id')"></span>
                                </div>
                            </div>
                        </div>
                        <div class="common-border heading-one">
                            <h1>Address Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                           v-model="form.city"
                                           :class="{'is-invalid':form.errors.has('city')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('city')"
                                          v-text="form.errors.first('city')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="country">Country</label>
                                    <select class="form-control" id="country" name="country"
                                            v-model="form.country_id"
                                            :class="{'is-invalid':form.errors.has('country_id')}">
                                        <option :value="nullValue">------</option>
                                        <option v-for="(country) in countries" :value="country.id">{{ country.name }}
                                        </option>
                                    </select>
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('country_id')"
                                          v-text="form.errors.first('country_id')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="po-number">P.O. Box Number</label>
                                    <input type="text" class="form-control" name="private_mail_po_number"
                                           v-model="form.private_mail_po_number"
                                           :class="{'is-invalid':form.errors.has('private_mail_po_number')}"
                                           id="po-number">
                                    <span class="help-block invalid-feedback"
                                          v-show="form.errors.has('private_mail_po_number')"
                                          v-text="form.errors.first('private_mail_po_number')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="org-po-number">Organization's P.O. Box Number</label>
                                    <input type="text" class="form-control" name="org_po_number" id="org-po-number"
                                           v-model="form.org_po_number"
                                           :class="{'is-invalid':form.errors.has('org_po_number')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('org_po_number')"
                                          v-text="form.errors.first('org_po_number')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="designation">Designation within Organization</label>
                                    <input type="text" class="form-control" name="designation" id="designation"
                                           v-model="form.designation"
                                           :class="{'is-invalid':form.errors.has('designation')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('designation')"
                                          v-text="form.errors.first('designation')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postal-code">Postal Code</label>
                                    <multiselect id="postal-code" name="postal_code"
                                                 v-model="form.postal_code_id"
                                                 :options="postalCodes"
                                                 track-by="id"
                                                 :searchable="true"
                                                 :multiple="false"
                                                 label="full_code"
                                                 :class="{'is-invalid':form.errors.has('postal_code_id')}"></multiselect>
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('postal_code_id')"
                                          v-text="form.errors.first('postal_code_id')"></span>
                                </div>
                            </div>
                        </div>
                        <div class="common-border heading-one">
                            <h1>Other Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6 date-picker">
                                    <label for="encouragement-sent">Encouragement Card Sent</label>
                                    <flat-pickr v-model="form.encouragement_card_sent"
                                                :config="config"
                                                class="form-control"
                                                :class="{'is-invalid':form.errors.has('encouragement_card_sent')}"
                                                id="encouragement-sent"></flat-pickr>
                                    <span class="help-block invalid-feedback"
                                          v-show="form.errors.has('encouragement_card_sent')"
                                          v-text="form.errors.first('encouragement_card_sent')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="prisoner">Prisoner</label>
                                    <select class="form-control" id="prisoner" name="prisoner"
                                            v-model="form.prisoner"
                                            :class="{'is-invalid':form.errors.has('prisoner')}">
                                        <option :value="nullValue">-------</option>
                                        <option :value="1">Yes</option>
                                        <option :value="0">No</option>
                                    </select>
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('prisoner')"
                                          v-text="form.errors.first('prisoner')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender"
                                            v-model="form.gender"
                                            :class="{'is-invalid':form.errors.has('gender')}">
                                        <option :value="nullValue">-------</option>
                                        <option v-for="(gender,key) in genders" :value="key">{{ gender }}</option>
                                    </select>
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('gender')"
                                          v-text="form.errors.first('gender')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="birth-year">Birth Year</label>
                                    <input type="text" class="form-control" name="birth_year" id="birth-year"
                                           minlength="4" maxlength="4" v-model="form.birth_year"
                                           :class="{'is-invalid':form.errors.has('birth_year')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('birth_year')"
                                          v-text="form.errors.first('birth_year')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="marital-status">Marital Status</label>
                                    <select class="form-control" id="marital-status" name="marital_status"
                                            v-model="form.marital_status"
                                            :class="{'is-invalid':form.errors.has('marital_status')}">
                                        <option :value="nullValue">-------</option>
                                        <option v-for="(status,key) in martialStatus" :value="key">{{ status }}</option>
                                    </select>
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('marital_status')"
                                          v-text="form.errors.first('marital_status')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="religion">Religion</label>
                                    <select class="form-control" id="religion" name="religion"
                                            v-model="form.religion"
                                            :class="{'is-invalid':form.errors.has('religion')}">
                                        <option :value="nullValue">-------</option>
                                        <option v-for="(religion,key) in userReligions" :value="key">{{ religion }}
                                        </option>
                                    </select>
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('religion')"
                                          v-text="form.errors.first('religion')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="course-language">Course language</label>
                                    <select class="form-control" id="course-language" name="course_language_id"
                                            v-model="form.course_language_id"
                                            :class="{'is-invalid':form.errors.has('course_language_id')}">
                                        <option :value="nullValue">-------</option>
                                        <option v-for="(language) in languages" :value="language.id">{{ language.name }}
                                        </option>
                                    </select>
                                    <span class="help-block invalid-feedback"
                                          v-show="form.errors.has('course_language_id')"
                                          v-text="form.errors.first('course_language_id')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="activity-status">Activity Status</label>
                                    <select class="form-control" id="activity-status" name="activity_status"
                                            v-model="form.activity_status"
                                            :class="{'is-invalid':form.errors.has('activity_status')}">
                                        <option :value="nullValue">-------</option>
                                        <option v-for="(activity,key) in userActivityStatus" :value="key">{{ activity }}
                                        </option>
                                    </select>
                                    <span class="help-block invalid-feedback"
                                          v-show="form.errors.has('activity_status')"
                                          v-text="form.errors.first('activity_status')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="comment">Comment</label>
                                    <textarea class="form-control" id="comment" v-model="form.comment"
                                              :class="{'is-invalid':form.errors.has('comment')}"
                                              name="comment">{{ form.comment }}</textarea>
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('comment')"
                                          v-text="form.errors.first('comment')"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="submit-row list-group">
                        <button type="button" @click.prevent="save" title="Save"
                                class="list-group-item" id="save-course"
                                name="_save">
                            <i class="fas fa-save"></i><span class="text">Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'form-backend-validation';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.min.css';
import flatPickr from "vue-flatpickr-component";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: "student-create",
    data() {
        return {
            isLoading: false,
            isFullPage: true,
            config: {
                wrap: false,
                altFormat: 'M d, Y',
                altInput: true,
                dateFormat: 'Y-m-d',
                maxDate: "today",
            },
            form: new Form(),
            genders: [],
            martialStatus: [],
            userReligions: [],
            userActivityStatus: [],
            postalCodes: [],
            countries: [],
            languages: [],
            nullValue: null,
            isOldStatus: false,
        };
    },
    created() {
        this.genders = this.$attrs.genders;
        this.martialStatus = this.$attrs.martialstatus;
        this.userReligions = this.$attrs.userreligions;
        this.userActivityStatus = this.$attrs.useractivitystatus;
        this.postalCodes = this.$attrs.postalcodes;
        this.countries = this.$attrs.countries;
        this.languages = this.$attrs.languages;
    },
    mounted() {
        this.form = new Form({
            'first_name': null,
            'surname': null,
            'middle_name': null,
            'email': null,
            'is_old': 0,
            'old_student_id': null,
            'country_code': null,
            'phone_number': null,
            'city': null,
            'country_id': null,
            'private_mail_po_number': null,
            'org_po_number': null,
            'designation': null,
            'postal_code_id': null,
            'last_test': null,
            'encouragement_card_sent': null,
            'prisoner': null,
            'gender': null,
            'birth_year': null,
            'marital_status': null,
            'religion': null,
            'course_language_id': null,
            'activity_status': null,
            'comment': null,

        });
    },
    components: {
        flatPickr,
        Loading,
        Multiselect,
    },
    methods: {
        async save() {
            this.isLoading = true;

            try {
                this.form.postal_code_id = (this.form.postal_code_id) ? this.form.postal_code_id.id : null;
                const response = await this.form.post(route('students.store'));

                if (response.status) {
                    this.isLoading = false;
                    this.$toasted.success('Student added successfully.');
                    setTimeout(() => window.location.href = route('students.edit', response.student), 1500);
                }
            } catch (e) {
                this.isLoading = false;
                this.$toasted.error('Unable to add student.');
            }
        },
        onIsOldChange() {
            this.isOldStatus = !this.isOldStatus;
            console.log(this.isOldStatus);
        }
    }
}
</script>
