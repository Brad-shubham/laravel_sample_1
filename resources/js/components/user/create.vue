<template>
    <div class="card shadow mb-4">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Add Teacher</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9 tb-student-add">
                    <form method="POST">
                        <div class="common-border heading-one">
                            <h1>Personal Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="surname">Surname*</label>
                                    <input type="text" class="form-control" name="surname" id="surname"
                                           v-model="form.surname"
                                           :class="{'is-invalid':form.errors.has('surname')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('surname')"
                                          v-text="form.errors.first('surname')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="first-name">First Name*</label>
                                    <input type="text" class="form-control" name="first_name" id="first-name"
                                           v-model="form.first_name"
                                           :class="{'is-invalid':form.errors.has('first_name')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('first_name')"
                                          v-text="form.errors.first('first_name')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="middle-name">Second Name</label>
                                    <input type="text" class="form-control" name="middle_name" id="middle-name"
                                           v-model="form.middle_name"
                                           :class="{'is-invalid':form.errors.has('middle_name')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('middle_name')"
                                          v-text="form.errors.first('middle_name')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email address*</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           v-model="form.email" :class="{'is-invalid':form.errors.has('email')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('email')"
                                          v-text="form.errors.first('email')"></span>
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
                                    <label for="designation">Designation within organization</label>
                                    <input type="text" class="form-control" name="designation" id="designation"
                                           v-model="form.designation"
                                           :class="{'is-invalid':form.errors.has('designation')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('designation')"
                                          v-text="form.errors.first('designation')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postal-code">Postal Code</label>
                                    <multiselect id="postal-code" name="postal_code"
                                                 v-model="form.postal_code"
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
import Form from "form-backend-validation";
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.min.css';
import flatPickr from "vue-flatpickr-component";
import Loading from "vue-loading-overlay";
import DeleteModal from "../modal/DeleteModal";

export default {
    name: "user-create",
    data() {
        return {
            isLoading: false,
            isFullPage: true,
            form: new Form(),
            user: [],
            userRoles: [],
            postalCodes: [],
            countries: [],
            nullValue: null,
        };
    },
    mounted() {
        this.form = new Form({
            'first_name': null,
            'surname': null,
            'middle_name': null,
            'email': null,
            'country_code': null,
            'phone_number': null,
            'user_type': null,
            'city': null,
            'country_id': null,
            'private_mail_po_number': null,
            'org_po_number': null,
            'designation': null,
            'postal_code_id': null,
        });
    },
    created() {
        this.user = this.$attrs.user;
        this.userRoles = this.$attrs.userroles;
        this.postalCodes = this.$attrs.postalcodes;
        this.countries = this.$attrs.countries;
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
                const response = await this.form.post(route('users.store'));

                if (response.status) {
                    this.isLoading = false;
                    this.$toasted.success('Teacher added successfully.');
                    setTimeout(() => window.location.href = route('users.edit', response.user), 1500);
                }
            } catch (e) {
                this.isLoading = false;
                this.$toasted.error('Unable to add teacher.');
            }
        }
    }
}
</script>
