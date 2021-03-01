<template>
    <div v-if="showLogin || showingRecoverPasswordForm || showingRegisterForm" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
        <!-- Connection Form -->
        <form v-if="showLogin" class="bg-white shadow-md rounded px-6 md:max-w-xl w-full max-h-4/5 overflow-auto" @submit.prevent="login">
            <div class="mt-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="email-login">
                    Email
                </label>
                <input v-model="userForm.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email-login" required type="email" placeholder="Email">
                <p class="text-red-700 mt-2" v-if="userError.email">{{ userError.email[0] }}</p>
            </div>
            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="password-login">
                    Mot de passe
                </label>
                <input v-model="userForm.password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password-login" required type="password" placeholder="Mot de passe">
                <p class="text-red-700 mt-2" v-if="userError.password">{{ userError.password[0] }}</p>
            </div>
            <div class="mt-4">
                <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer" v-on:click.prevent="showRegisterForm">
                    Pas encore de compte ?
                </a>
            </div>
            <div class="mt-2">
                <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer" v-on:click.prevent="showRecoverPasswordForm">
                    Mot de passe oublié ?
                </a>
            </div>
            <div class="mt-4 mb-6">
                <span class="flex w-full rounded">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Connexion
                    </button>
                    <button v-on:click="showConnectionForm" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Fermer
                    </button>
                </span>
            </div>
        </form>

        <!-- Register Form -->
        <form v-if="showingRegisterForm" class="bg-white shadow-md rounded px-6 md:max-w-xl w-full max-h-4/5 overflow-auto" @submit.prevent="register">
            <div class="mt-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="name-register">
                    Nom
                </label>
                <input v-model="userForm.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name-register" required type="text" placeholder="Nom">
                <p class="text-red-700 mt-2" v-if="userError.name">{{ userError.name[0] }}</p>
            </div>
            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="email-register">
                    Email
                </label>
                <input v-model="userForm.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email-register" required type="email" placeholder="Email">
                <p class="text-red-700 mt-2" v-if="userError.email">{{ userError.email[0] }}</p>
            </div>
            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="password-register">
                    Mot de passe
                </label>
                <input v-model="userForm.password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password-register" required type="password" placeholder="Mot de passe">
                <p class="text-red-700 mt-2" v-if="userError.password">{{ userError.password[0] }}</p>
            </div>
            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="password-confirmation-register">
                    Confirmation du mot de passe
                </label>
                <input v-model="userForm.passwordConfirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password-confirmation-register" required type="password" placeholder="Confirmation du mot de passe">
                <p class="text-red-700 mt-2" v-if="userError.password_confirmation">{{ userError.password_confirmation[0] }}</p>
            </div>
            <div class="mt-4 mb-6">
                    <span class="flex w-full rounded">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Inscription
                        </button>
                        <button v-on:click="showConnectionForm" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Fermer
                        </button>
                    </span>
            </div>
        </form>

        <!-- Recover Password Form -->
        <form v-if="showingRecoverPasswordForm" class="bg-white shadow-md rounded px-6 md:max-w-xl w-full max-h-4/5 overflow-auto" @submit.prevent="resetPassword">
            <div class="mt-6">
                    <span class="text-gray-700 text-sm font-normal mb-2">
                        Mot de passe oublié ? Aucun problème. Saisissez votre email dans le champ ci-dessous et nous vous enverrons un lien de réinitialisation pour en choisir un nouveau.
                    </span>
            </div>
            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="email-reset">
                    Email
                </label>
                <input v-model="userForm.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email-reset" required type="email" placeholder="Email">
                <p class="text-red-700 mt-2" v-if="userError.email">{{ userError.email[0] }}</p>
            </div>
            <div class="mt-4 mb-6">
                    <span class="flex w-full rounded">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Envoyer un lien
                        </button>
                        <button v-on:click.prevent="showRecoverPasswordForm" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Fermer
                        </button>
                    </span>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "LoginForm",

    props: ['showLogin'],

    data() {
        return {
            showingLoginForm: this.showLogin,
            showingRegisterForm: false,
            showingRecoverPasswordForm: false,
            userForm: {
                name: null,
                email: null,
                password: null,
                passwordConfirmation: null
            },
            userError: {}
        }
    },

    methods: {
        login() {
            axios.post(route('login').url(), {
                email: this.userForm.email,
                password: this.userForm.password
            }).then(() => {
                location.reload();
            }).catch((err) => {
                this.userError = err.response.data.errors;
            });
        },

        register() {
            axios.post(route('register').url(), {
                name: this.userForm.name,
                email: this.userForm.email,
                password: this.userForm.password,
                password_confirmation: this.userForm.passwordConfirmation
            }).then(() => {
                location.reload();
            }).catch((err) => {
                this.userError = err.response.data.errors;
            });
        },

        resetPassword() {
            // TODO : Reset password
        },

        resetUserForm() {
            this.userForm.name = null;
            this.userForm.email = null;
            this.userForm.password = null;
            this.userForm.passwordConfirmation = null;
        },

        showConnectionForm() {
            this.userError = {};
            this.resetUserForm();

            if (this.showLogin) {
                this.updateLoginForm(false);
            } else {
                this.showingRecoverPasswordForm = false;
                this.showingRegisterForm = false;
                this.updateLoginForm(true);
            }
        },

        showRegisterForm() {
            this.userError = {};
            this.resetUserForm();

            if (this.showingRegisterForm) {
                this.showingRegisterForm = false;
                this.updateLoginForm(true);
            } else {
                this.updateLoginForm(false);
                this.showingRegisterForm = true;
            }
        },

        showRecoverPasswordForm() {
            this.userError = {};
            this.resetUserForm();

            if (this.showingRecoverPasswordForm) {
                this.showingRecoverPasswordForm = false;
                this.updateLoginForm(true);
            } else {
                this.updateLoginForm(false);
                this.showingRecoverPasswordForm = true;
            }
        },

        updateLoginForm(value) {
            this.showingLoginForm = value;
            this.$emit("updateLoginForm", this.showingLoginForm);
        }
    }
}
</script>
