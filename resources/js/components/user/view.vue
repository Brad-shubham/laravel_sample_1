<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">View User</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 tb-student-add">
                    <form method="POST">
                        <div class="common-border heading-one">
                            <h1>Personal Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="surname">Surname</label>
                                    <input type="text" class="form-control" name="surname" id="surname" disabled
                                           :value="user.profile.surname">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="first-name">First Name</label>
                                    <input type="text" class="form-control" name="first_name" disabled id="first-name"
                                           :value="user.profile.first_name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="middle-name">Second Name</label>
                                    <input type="text" class="form-control" name="middle_name" id="middle-name" disabled
                                           :value="user.profile.middle_name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email address*</label>
                                    <input type="email" class="form-control" id="email" disabled
                                           :value="user.email">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="country-code">Country Code</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">+</div>
                                        </div>
                                        <input type="text" class="form-control" name="country_code" id="country-code"
                                               disabled
                                               :value="user.country_code">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number" id="phone" disabled
                                           :value="user.phone_number">
                                </div>
                            </div>
                        </div>
                        <div class="common-border heading-one">
                            <h1>Address Information</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                           disabled :value="user.profile.city">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="country">Country*</label>
                                    <input type="text" class="form-control" name="country" id="country"
                                           disabled
                                           :value="(user.profile.country_id) ? user.profile.country.name : null">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="po-number">P.O. Box Number</label>
                                    <input type="text" class="form-control" name="private_mail_po_number" disabled
                                           :value="user.profile.private_mail_po_number"
                                           id="po-number">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="org-po-number">Organization's P.O. Box Number</label>
                                    <input type="text" class="form-control" name="org_po_number" id="org-po-number"
                                           disabled
                                           :value="user.profile.org_po_number">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="designation">Designation within organization</label>
                                    <input type="text" class="form-control" name="designation" id="designation" disabled
                                           :value="user.profile.designation">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postal-code">Postal Code</label>
                                    <input type="text" class="form-control" name="postal_code" id="postal-code" disabled
                                           :value="(user.profile.postal_code_id) ? user.profile.postal_code.full_code : null">
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
    name: "user-view",
    data() {
        return {
            user: [],
        };
    },
    created() {
        this.user = this.$attrs.user;
    },
}
</script>
