<template>
    <div class="card shadow mb-4">
        <loading :active="isLoading"
                 loader="dots"
                 :is-full-page="isFullPage"></loading>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9 tb-student-add">
                    <form method="POST">
                        <div class="common-border heading-one">
                            <h1>Personal Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="email">Email address*</label>
                                    <input type="email" class="form-control" id="email"
                                           v-model="user.email" :class="{'is-invalid':form.errors.has('email')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('email')"
                                          v-text="form.errors.first('email')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="surname">Surname*</label>
                                    <input type="text" class="form-control" name="surname" id="surname"
                                           v-model="user.profile.surname"
                                           :class="{'is-invalid':form.errors.has('surname')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('surname')"
                                          v-text="form.errors.first('surname')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="first-name">First Name*</label>
                                    <input type="text" class="form-control" name="first_name" id="first-name"
                                           v-model="user.profile.first_name"
                                           :class="{'is-invalid':form.errors.has('first_name')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('first_name')"
                                          v-text="form.errors.first('first_name')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="middle-name">Second Name</label>
                                    <input type="text" class="form-control" name="middle_name" id="middle-name"
                                           v-model="user.profile.middle_name"
                                           :class="{'is-invalid':form.errors.has('middle_name')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('middle_name')"
                                          v-text="form.errors.first('middle_name')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="old-password">Current Password</label>
                                    <input type="password" class="form-control" name="last_name" id="old-password"
                                           v-model="form.old_password"
                                           :class="{'is-invalid':form.errors.has('old_password')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('old_password')"
                                          v-text="form.errors.first('old_password')"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control" id="password"
                                           v-model="form.password"
                                           :class="{'is-invalid':form.errors.has('password')}">
                                    <span class="help-block invalid-feedback" v-show="form.errors.has('password')"
                                          v-text="form.errors.first('password')"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm-password">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm-password"
                                           v-model="form.password_confirmation">
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
import Loading from "vue-loading-overlay";
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    name: "user-edit-profile",
    data() {
        return {
            isLoading: false,
            isFullPage: true,
            form: new Form({
                'old_password': null,
                'password': null,
                'password_confirmation': null,
            }),
            user: [],
        };
    },
    components: {
        Loading,
    },
    created() {
        this.user = this.$attrs.user;
    },
    methods: {
        async save() {
            this.isLoading = true;
            this.form = new Form({
                'first_name': this.user.profile.first_name,
                'middle_name': this.user.profile.middle_name,
                'surname': this.user.profile.surname,
                'email': this.user.email,
                'old_password': this.form.old_password,
                'password': this.form.password,
                'password_confirmation': this.form.password_confirmation,
            });
            try {
                const response = await this.form.put(route('user.profile.update', this.user.id));
                if (response.status) {
                    this.isLoading = false;
                    this.$toasted.success('Profile updated successfully.');
                }
            } catch (e) {
                this.isLoading = false;
                this.$toasted.error('Unable to update profile.');
            }
        },
    }
}
</script>
