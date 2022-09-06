<template>
    <section
        id="login"
        class="d-flex align-items-center justify-content-center"
    >
        <div
            class="auth-container"
            :class="[ isSignIn ? 'right-panel-active' : '' ]"
            id="container"
        >
            <SignInComponent />
            <SignUpComponent />
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-right">
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal details to create new account<br>

                        </p>
                        <button
                            class="ghost"
                            @click="toogleSignInAndSignUp"
                            id="signUp"
                        >
                            Sign Up
                        </button>
                    </div>
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>To check the current forecast please login with your personal details
                        </p>
                        <button
                            class="ghost"
                            @click="toogleSignInAndSignUp"
                            id="signIn"
                        >
                            Sign In
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import SignInComponent from "../components/SignInComponent.vue";
import SignUpComponent from "../components/SignUpComponent.vue";

export default {
    name: "AuthenticationPage",
    components: {
        SignInComponent,
        SignUpComponent,
    },
    data() {
        return {
            isSignIn: false,
        };
    },
    methods: {
        toogleSignInAndSignUp() {
            this.isSignIn = !this.isSignIn;
        }
    }
}
</script>

<style lang="scss">
#login {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin: -20px 0 50px;

}

h1 {
    font-weight: bold;
    margin: 0;
}


p {
    font-size: 14px;
    font-weight: 100;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin: 20px 0 30px;
}

span {
    font-size: 12px;
}

a {
    color: #333;
    font-size: 14px;
    text-decoration: none;
    margin: 15px 0;
}

button {
    border-radius: 20px;
    border: 1px solid #3287f9;
    background-color: #2994f8;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
}

button:active {
    transform: scale(0.95);
}

button:focus {
    outline: none;
}

button.ghost {
    background-color: transparent;
    border-color: #FFFFFF;
}

form {
    background-color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    text-align: center;
}

.form-input {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
    max-width: 20em;
}

.form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.3s ease-in-out;
}

.sign-in-container {
    left: 0;
    width: 50%;
    z-index: 2;
}

.auth-container.right-panel-active .sign-in-container {
    transform: translateX(100%);
}

.sign-up-container {
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.auth-container.right-panel-active .sign-up-container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
}

@keyframes show {
    0%, 49.99% {
        opacity: 0;
        z-index: 1;
    }

    50%, 100% {
        opacity: 1;
        z-index: 5;
    }
}

.overlay-container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 100;
}

.auth-container.right-panel-active .overlay-container {
    transform: translateX(-100%);
}

@media (max-width: 768px) {
    .auth-container.right-panel-active .sign-up-container {
        transform: translateY(100%);
        //z translateX na translateY w res
    }
    .auth-container.right-panel-active .sign-in-container {
        //z translateX na translateY w res
        transform: translateY(0%);
    }

    .auth-container {
        overflow: initial;
    }
    .sign-in-container {
        width: 100%;
    }
    .sign-up-container {
        width: 100%;
    }
    .auth-container.right-panel-active .overlay-container {
        transform: translateY(-100%);
    }
    .auth-container.right-panel-active .overlay.form-container-left {
        transform: translateY(0%);
    }
    .auth-container.right-panel-active .overlay-right {
        transform: translateY(0%);
    }
    .overlay-container {
        left: 0;
        top: 100%;
        width: 100%;
    }
    .auth-container.right-panel-active .overlay {
        transform: translateY(0%) !important;
    }
    .overlay-right {
        transform: translateY(0) !important;
    }
    .overlay-left {
        transform: translateY(-20%) !important;
    }

}

.overlay {
    background: #2994f8;
    background: -webkit-linear-gradient(to right, #08C8F6, #2994f8);
    background: linear-gradient(to right, #08C8F6, #2994f8);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 0 0;
    color: #FFFFFF;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.auth-container.right-panel-active .overlay {
    transform: translateX(50%);
}

.overlay-panel {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    text-align: center;
    top: 0;
    height: 100%;
    width: 50%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.overlay-left {
    transform: translateX(-20%);
}

.auth-container.right-panel-active .overlay-left {
    transform: translateX(0);
}

.overlay-right {
    right: 0;
    transform: translateX(0);
}

.auth-container.right-panel-active .overlay-right {
    transform: translateX(20%);
}

.social-container {
    margin: 20px 0;
}

.social-container a {
    border: 1px solid #DDDDDD;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 5px;
    height: 40px;
    width: 40px;
}

</style>
