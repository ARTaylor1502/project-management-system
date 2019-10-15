<template>
    <div>
        <div class="list-group shadow">
            <name-step id="name_step" :errors="errors" @name-step-complete="handler($event, 2)" @name-step-incomplete="setStepNumber(1)"></name-step>
            <transition name="fade" mode="out-in">
                <role-step id="role_step" v-show="current_step > 1" :errors="errors" @role-step-complete="handler($event, 3)" @role-step-incomplete="setStepNumber(2)"></role-step>
            </transition>
            <transition name="fade" mode="out-in">
                <contact-details-step id="contact_details_step" v-show="current_step > 2" :errors="errors" @contact-details-step-complete="handler($event, 4)" @contact-details-step-incomplete="setStepNumber(3)"></contact-details-step>
            </transition>
            <transition name="fade" mode="out-in">
                <addresses-step id="addresses_step" v-show="current_step > 3" :errors="errors" :what3words_api_key="what3words_api_key" @addresses-step-complete="handler($event, 5)" @addresses-step-incomplete="setStepNumber(4)"></addresses-step>
            </transition>
            <transition name="fade" mode="out-in">
                <avatar-step id="avatar_step" v-show="current_step > 4" :errors="errors" @avatar-step-complete="handler($event, 6)" @avatar-step-incomplete="setStepNumber(5)"></avatar-step>
            </transition>
        </div>
        <button v-if="current_step === 6" class="btn btn-primary btn-lg float-right mb-5" @click="addUserHandler">Add User</button>
    </div>
</template>

<script>
    import NameStep from './steps/name-step';
    import RoleStep from './steps/role-step';
    import ContactDetailsStep from './steps/contact-details-step';
    import AddressesStep from './steps/addresses-step';
    import AvatarStep from './steps/avatar-step';
    import UserHelper from '../../../../../components/mixins/user-helper'

    export default {
        name: "create-user",
        props: ['what3words_api_key'],
        mixins: [UserHelper],
        components: {
            NameStep,
            RoleStep,
            ContactDetailsStep,
            AddressesStep,
            AvatarStep
        },
        data() {
            return {
                errors: {},
                current_step: 1,
                user_data: {},
                formData: null
            }
        },
        created() {
            this.$eventHub.$on('new-user-added', this.userAddedHandler);
            this.$eventHub.$on('new-user-added-errors', this.userAddedErrorsHandler);
        },
        methods: {
            addUserHandler() {
                this.populateForm();
                this.addUser(this.formData);
            },
            populateForm() {
                this.formData = new FormData();

                this.formData.append('first_name', this.user_data.first_name);
                this.formData.append('last_name', this.user_data.last_name);
                this.formData.append('title_id', this.user_data.title.id);
                this.formData.append('role_id', this.user_data.role.id);
                this.formData.append('email', this.user_data.email);
                this.formData.append('password', this.user_data.password);
                this.formData.append('landline_tele', this.user_data.landline_tele);
                this.formData.append('mobile_tele', this.user_data.mobile_tele);
                this.formData.append('department_id', (this.user_data.department ? this.user_data.department.id : null));

                if(this.user_data.addresses) {
                    for(let i = 0; i < this.user_data.addresses.length; i++){
                        let address = this.user_data.addresses[i];
                        this.formData.append('addresses[' + i + ']', JSON.stringify(address));
                    }
                }

                if(this.user_data.file && this.user_data.file.length > 0) {
                    let file = this.user_data.file[0];
                    this.formData.append('avatar', file);
                }
            },
            userAddedHandler(new_user_id) {
                window.location.href = '/staff/users/user/' + new_user_id;
            },
            userAddedErrorsHandler(errors) {
                this.errors = errors;
            },
            updateUserData(event) {
                for (const [key, value] of Object.entries(event)) {
                    this.user_data[key] = value;
                }
            },
            setStepNumber(step_number) {
                if(step_number > this.current_step) {
                    this.current_step = step_number;
                }
            },
            handler(e, step_number) {
                this.updateUserData(e);
                this.setStepNumber(step_number);
            }
        }
    }
</script>
