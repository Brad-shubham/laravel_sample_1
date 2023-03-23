<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">View Student</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9 tb-student-add">
                    <form method="POST">
                        <div class="common-border heading-one">
                            <h1>Personal Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="username">Student ID</label>
                                    <input type="text" class="form-control" name="student_id" id="username"
                                           :value="student.student_id" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="surname">Surname</label>
                                    <input type="text" class="form-control" name="surname" id="surname" disabled
                                    :value="student.profile.surname">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first-name">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first-name" disabled
                                           :value="student.profile.first_name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="middle-name">Second Name</label>
                                    <input type="text" class="form-control" name="middle_name" id="middle-name" disabled
                                           :value="student.profile.middle_name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" disabled
                                           disabled :value="student.email">
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="country-code">Code</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">+</div>
                                                </div>
                                                <input type="text" class="form-control" name="country_code"
                                                       id="country-code"
                                                       disabled
                                                       :value="student.country_code">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="phone">Phone Number</label>
                                            <input type="text" class="form-control" name="phone_number" id="phone"
                                                   disabled
                                                   :value="student.phone_number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="common-border heading-one">
                            <h1>Address Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                           disabled :value="student.profile.city">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" name="country" id="country" disabled
                                           :value="(student.profile.country_id) ? student.profile.country.name : null">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="po-number">P.O. Box Number</label>
                                    <input type="text" class="form-control" name="private_mail_po_number" disabled
                                           :value="student.profile.private_mail_po_number"
                                           id="po-number">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="org-po-number">Organization's P.O. Box Number</label>
                                    <input type="text" class="form-control" name="org_po_number" id="org-po-number"
                                           disabled :value="student.profile.org_po_number">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="designation">Designation within Organization</label>
                                    <input type="text" class="form-control" name="designation" id="designation" disabled
                                           :value="student.profile.designation">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postal-code">Postal Code</label>
                                    <input type="text" class="form-control" name="postal_code" id="postal-code" disabled
                                           :value="(student.profile.postal_code_id) ? student.profile.postal_code.full_code : null">
                                </div>
                            </div>
                        </div>
                        <div class="common-border heading-one">
                            <h1>Other Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date-enrolled">Date Enrolled</label>
                                    <input type="text" class="form-control" disabled
                                           :value="student.profile.date_enrolled"
                                           id="date-enrolled">
                                </div>
                                <div class="form-group col-md-6 date-picker">
                                    <label for="last-test">Last Heard/Test</label>
                                    <input type="text" class="form-control" disabled
                                           :value="student.profile.formatted_last_test"
                                           id="last-test">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 date-picker">
                                    <label for="encouragement-sent">Encouragement Card Sent</label>
                                    <input type="text" class="form-control" disabled
                                           :value="student.profile.formatted_encouragement_card_sent"
                                           id="encouragement-sent">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="prisoner">Prisoner</label>
                                    <input type="text" class="form-control" disabled
                                           :value="(student.profile.prisoner) ? 'Yes' : 'No'"
                                           id="prisoner">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="gender">Gender</label>
                                    <input type="text" class="form-control" disabled
                                           :value="genders[student.profile.gender]"
                                           id="gender">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="birth-year">Birth Year</label>
                                    <input type="text" class="form-control" disabled
                                           :value="student.profile.birth_year"
                                           id="birth-year">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="marital-status">Marital Status</label>
                                    <input type="text" class="form-control" disabled
                                           :value="martialStatus[student.profile.marital_status]"
                                           id="marital-status">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="religion">Religion</label>
                                    <input type="text" class="form-control" disabled
                                           :value="userReligions[student.profile.religion]"
                                           id="religion">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="course-language">Course language</label>
                                    <input type="text" class="form-control" disabled
                                           :value="(student.profile.course_language_id) ? student.profile.language.name : null"
                                           id="course-language">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="activity-status">Activity Status</label>
                                    <input type="text" class="form-control" disabled
                                           :value="userActivityStatus[student.profile.activity_status]"
                                           id="activity-status">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="comment">Comment</label>
                                    <textarea class="form-control" disabled id="comment"
                                              name="comment">{{ student.profile.comment }}</textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="submit-row list-group">
                        <button type="button" @click.prevent="viewCourses" title="View Courses"
                                class="list-group-item" id="view-courses"
                                name="view_courses">
                            <i class="fas fa-book-medical"></i><span class="text">View Courses</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "student-view",
    data() {
        return {
            student: [],
            genders: [],
            martialStatus: [],
            userReligions: [],
            userActivityStatus: [],
        };
    },
    created() {
        this.student = this.$attrs.student;
        this.genders = this.$attrs.genders;
        this.martialStatus = this.$attrs.martialstatus;
        this.userReligions = this.$attrs.userreligions;
        this.userActivityStatus = this.$attrs.useractivitystatus;
    },
    methods: {
        viewCourses() {
            window.location.href = route('students.report', this.student.id);
        }
    }
}
</script>
