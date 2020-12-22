<template>
<main id="main" class="login">
    <div class="login-intro">
        <div class="login-intro__content">
            <div class="logo">
                <img src="../../assets/img/log-inf-mini.png" alt="logo" />
            </div>
            <h1>Welcome to INFLUENCIA</h1>
            <p>Now you can track campaigns of your influencers easy and on any social network!</p>
        </div>
    </div>
    <div class="login-form">
        <div class="login-form__content">
            <h2>LOGIN TO YOUR ACCOUNT</h2>
            <form @submit.prevent="login" autocomplete="on">
                <div class="control has-icon">
                    <input v-model="email" type="email" class="input-email" placeholder="john@example.com" autocomplete="email" />
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" x="0" y="0" version="1.1" viewBox="0 0 512 512" xml:space="preserve">
                            <path d="M469.333,64H42.667C19.135,64,0,83.135,0,106.667v298.667C0,428.865,19.135,448,42.667,448h426.667 C492.865,448,512,428.865,512,405.333V106.667C512,83.135,492.865,64,469.333,64z M42.667,85.333h426.667 c1.572,0,2.957,0.573,4.432,0.897c-36.939,33.807-159.423,145.859-202.286,184.478c-3.354,3.021-8.76,6.625-15.479,6.625 s-12.125-3.604-15.49-6.635C197.652,232.085,75.161,120.027,38.228,86.232C39.706,85.908,41.094,85.333,42.667,85.333z M21.333,405.333V106.667c0-2.09,0.63-3.986,1.194-5.896c28.272,25.876,113.736,104.06,169.152,154.453 C136.443,302.671,50.957,383.719,22.46,410.893C21.957,409.079,21.333,407.305,21.333,405.333z M469.333,426.667H42.667 c-1.704,0-3.219-0.594-4.81-0.974c29.447-28.072,115.477-109.586,169.742-156.009c7.074,6.417,13.536,12.268,18.63,16.858 c8.792,7.938,19.083,12.125,29.771,12.125s20.979-4.188,29.76-12.115c5.096-4.592,11.563-10.448,18.641-16.868 c54.268,46.418,140.286,127.926,169.742,156.009C472.552,426.073,471.039,426.667,469.333,426.667z M490.667,405.333 c0,1.971-0.624,3.746-1.126,5.56c-28.508-27.188-113.984-108.227-169.219-155.668c55.418-50.393,140.869-128.57,169.151-154.456 c0.564,1.91,1.194,3.807,1.194,5.897V405.333z" />
                        </svg>
                    </div>
                </div>
                <div class="control has-icon">
                    <input v-model="password" type="password" class="input-password" placeholder="Password" autocomplete="password" />
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="m18.75 24h-13.5c-1.24 0-2.25-1.009-2.25-2.25v-10.5c0-1.241 1.01-2.25 2.25-2.25h13.5c1.24 0 2.25 1.009 2.25 2.25v10.5c0 1.241-1.01 2.25-2.25 2.25zm-13.5-13.5c-.413 0-.75.336-.75.75v10.5c0 .414.337.75.75.75h13.5c.413 0 .75-.336.75-.75v-10.5c0-.414-.337-.75-.75-.75z" />
                            <path d="m17.25 10.5c-.414 0-.75-.336-.75-.75v-3.75c0-2.481-2.019-4.5-4.5-4.5s-4.5 2.019-4.5 4.5v3.75c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-3.75c0-3.309 2.691-6 6-6s6 2.691 6 6v3.75c0 .414-.336.75-.75.75z" />
                            <path d="m12 17c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0-2.5c-.275 0-.5.224-.5.5s.225.5.5.5.5-.224.5-.5-.225-.5-.5-.5z" />
                            <path d="m12 20c-.414 0-.75-.336-.75-.75v-2.75c0-.414.336-.75.75-.75s.75.336.75.75v2.75c0 .414-.336.75-.75.75z" />
                        </svg>
                    </div>
                </div>
                <div class="control">
                    <button type="submit" class="btn btn-blue btn-primary">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</main>
</template>

<script>
import SecureLS from "secure-ls";

export default {
    data() {
        return {
            email: null,
            password: null,
        };
    },
    beforeRouteEnter(to, from, next) {
        let ls = new SecureLS();

        next((vm) => {
            const loggedIn = ls.get("user");
            if (loggedIn) {
                next("/dashboard");
                return;
            }
            next();
        });
    },
    notifications: {
        showLoginSuccess: {
            title: "Login success",
            type: "success",
        },
        showLoginError: {
            title: "Error",
            type: "error",
        },
    },
    methods: {
        login() {
            this.$store
                .dispatch("login", {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    if(response.success){
                            this.showLoginSuccess({
                            message: `Welcome back ${response.content.user.name}`
                        });

                        this.$router.push({ name: 'dashboard' });
                    }else{
                        throw new Error("Something going wrong!");
                    }
                })
                .catch((error) => {
                    let message = "Internal server error!";
                    if(typeof error.response !== "undefined" && error.response.status !== 500 && error.response.hasOwnProperty("data") && error.response.data.hasOwnProperty("message"))
                        message = error.response.data.message;

                    this.showLoginError({
                        message: message
                    });
                });
        },
    }
};
</script>
