<template>
    <div class="form-container sign-up-container">
        <Form @submit="handleRegister" :validation-schema="schema">
            <h1 class="mb-4">Create Account</h1>

            <Field name="name" type="text" class="form-input" placeholder="Name"/>
            <ErrorMessage name="name" class="error-feedback"/>

            <Field name="email" type="text" class="form-input" placeholder="Email"/>
            <ErrorMessage name="email" class="error-feedback"/>

            <Field name="password" type="password" class="form-input" placeholder="Password" autocomplete="on"/>
            <ErrorMessage name="password" class="error-feedback"/>

            <Field name="password_confirmation" type="password" class="form-input" placeholder="Password confirmation" autocomplete="on"/>
            <ErrorMessage name="password_confirmation" class="error-feedback"/>

            <button :disabled="loading">
            <span
                v-show="loading"
                class="spinner-border spinner-border-sm"
            ></span>
                Sign Up
            </button>
            <!--
            <div class="form-group">
                <div v-if="message" class="alert alert-danger" role="alert">
                    {{ message }}
                </div>
            </div>
            -->
        </Form>
    </div>
</template>

<script>
import * as yup from "yup";
import {ErrorMessage, Field, Form} from "vee-validate";
import ToastService from "../services/toast-service";

export default {
    name: "SignUpComponent",
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        const schema = yup.object().shape({
            name: yup
                .string()
                .required("Username is required!")
                .min(3, "Must be at least 3 characters!")
                .max(20, "Must be maximum 20 characters!"),
            email: yup
                .string()
                .required("Email is required!")
                .email("Email is invalid!")
                .max(50, "Must be maximum 50 characters!"),
            password: yup
                .string()
                .required("Password is required!")
                .min(8, "Must be at least 8 characters!")
                .max(40, "Must be maximum 40 characters!"),
            password_confirmation: yup
                .string()
                .oneOf([yup.ref('password'), null], 'Passwords must match!')
        });
        return {
            successful: false,
            loading: false,
            message: "",
            schema,
        };
    },
    computed: {
        loggedIn() {
            return this.$store.state.auth.status.loggedIn;
        },
    },
    mounted() {
        if (this.loggedIn) {
            this.$router.push("/");
        }
    },
    methods: {
        handleRegister(user) {
            this.message = "";
            this.successful = false;
            this.loading = true;
            this.$store.dispatch("auth/register", user).then(
                (data) => {
                    this.message = data.message;
                    this.successful = true;
                    this.loading = false;
                    this.$router.go();
                    ToastService.showToast(this.message, "success")
                    //this.showToastOnRegisterSuccess()
                },
                (error) => {
                    this.message =
                        (error.response &&
                            error.response.data &&
                            error.response.data.message) ||
                        error.message ||
                        error.toString();
                    this.successful = false;
                    this.loading = false;
                    console.log(this.message)
                    ToastService.showToast(this.message, "error")
                }
            );

        },
        showToastOnRegisterSuccess() {
            this.$toast.open({
                message: "You have been signed up successfully !!!",
                type: "success",
                duration: 5000,
                position: 'top',
                dismissible: true
            })
        },
    },
};
</script>

<style scoped>

</style>
