<template>
    <div class="form-container sign-in-container">
        <Form @submit="handleLogin" :validation-schema="schema">
            <h1 class="mb-4">Sign in</h1>
            <Field name="email" type="text" class="form-input" placeholder="Email"/>
            <ErrorMessage name="email" class="error-feedback"/>
            <Field name="password" type="password" class="form-input" placeholder="Password"/>
            <ErrorMessage name="email" class="error-feedback"/>
            <a href="#">Forgot your password?</a>
            <button :disabled="loading">
                <span v-show="loading" class="spinner-border spinner-border-sm"></span>
                <span>Sign In</span>
            </button>
            <div class="form-group">
                <div v-if="message" class="alert alert-danger" role="alert">
                    {{ message }}
                </div>
            </div>
        </Form>
    </div>
</template>
<script>
import * as yup from "yup";
import {ErrorMessage, Field, Form} from "vee-validate";
export default {
    name: "SignInComponent",
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        const schema = yup.object().shape({
            email: yup.string().required("Email is required!"),
            password: yup.string().required("Password is required!"),
        });
        return {
            loading: false,
            message: "",
            test: null,
            schema,
        };
    },
    methods: {
        handleLogin(user) {
            this.loading = true;
            this.$store.dispatch("auth/login", user).then(
                () => {
                    this.$router.push("/")
                    this.showToastOnLoginSuccess();
                },
                (error) => {
                    this.loading = false;
                    this.message =
                        (error.response &&
                            error.response.data &&
                            error.response.data.message) ||
                        error.message ||
                        error.toString();
                }
            );
        },
        showToastOnLoginSuccess() {
            this.$toast.open({
                message: "You have been signed in successfully !!!",
                type: "success",
                duration: 5000,
                position: 'top',
                dismissible: true
            })
        },
        toogleSignInAndSignUp() {
            this.isSignIn = !this.isSignIn;
        },
    },
    computed: {
        loggedIn() {
            return this.$store.state.auth.status.loggedIn;
        },
    },
    created() {
        if (this.loggedIn) {
            this.$router.push("/login");
        }
    },
}
</script>
<style>

</style>
