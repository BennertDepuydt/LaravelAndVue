<template>
    <auth-content-view is-login="true" is-register="true">
        <template v-slot:form>
            <b-form>
                <b-input-group class="mt-3">
                    <b-form-input
                        type="email"
                        required
                        v-model="email"
                        :state="emailValid"
                        v-on:click="checkEmail()"
                        placeholder="Email"
                    ></b-form-input>
                </b-input-group>

                <b-input-group class="mt-3">
                    <b-form-input
                        required
                        v-model="password"
                        :state="passwordValid"
                        v-on:click="checkPassword()"
                        placeholder="Password"
                        type="password"
                    ></b-form-input>
                </b-input-group>

                <b-form-checkbox
                    v-model="rememberMe"
                    size="small"
                    class="mt-3"
                    button-variant="light"
                    switch
                >
                    Remember me
                </b-form-checkbox>

            </b-form>

            <b-button type="submit" class="w-100 mt-5" :disabled="isLoading" @click="loginUser()"
                      variant="outline-primary">
                <template v-if="isLoading">
                    <b-spinner small label="Small Spinner"></b-spinner>
                </template>
                Log in
            </b-button>
            <b-button class="w-100 mt-3" variant="outline-primary" :to="`/auth/register`">
                Register
            </b-button>
        </template>
    </auth-content-view>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import AuthContentView from "@/modules/auth/components/AuthCardLogin.vue";

@Component({
    components: {AuthContentView}
})
export default class LoginView extends Vue {
    private isLoading: boolean = false;
    private rememberMe: boolean = false;

    data() {
        return {
            logo: require('@/assets/BaroLogo.png')
        }
    }

    private email: string = ''
    private password: string = ''

    private emailValid: boolean | null = null;
    private passwordValid: boolean | null = null;

    mounted() {
        let remember = this.$auth.remember();
        if(remember) {
            this.email = JSON.parse(remember).email
            this.rememberMe = true;
        }
    }

    @Watch('email')
    checkEmail() {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        this.emailValid = re.test(this.email) && this.email !== ''
    }

    @Watch('password')
    checkPassword() {
        this.passwordValid = this.password !== '' && this.password.length > 7
    }

    async loginUser() {
        this.isLoading = true
        if (this.emailValid && this.passwordValid) {
            this.$auth.login({
                data: {
                    email: this.email,
                    password: this.password
                },
                remember: this.rememberMe ? JSON.stringify({email: this.email}) : null,
            })
                .then((r)=> {
                    this.$auth.fetch()
                        .then(function(r: any) {
                            if (r.data.data[0].role === 'Student') {
                                Vue.router.push('/student/dashboard')
                            }
                            if (r.data.data[0].role === 'Lecturer') {
                                Vue.router.push('/lecturer/dashboard')
                            }
                            if (r.data.data[0].role === 'Mentor') {
                                Vue.router.push('/mentor/dashboard')
                            }
                        })
                        .catch(() => {
                            Vue.router.push('/404')
                        })
                    .finally(() => {
                        this.isLoading = false
                    })
                })
                .catch((e) => {
                    this.password = ''
                    this.launchCredentialsErrorToast('Email or password is wrong!')
                    this.isLoading = false
                })
                .finally(() => {
            });

        } else {
            this.launchCredentialsErrorToast('Email or password is wrong!')
            this.isLoading = false
        }
    }

    launchErrorToast() {
        Vue.$toast.open({
            message: 'Something went wrong, try again!',
            type: 'error',
            position: 'bottom-right'
        })
    }

    launchCredentialsErrorToast(res: string) {
        Vue.$toast.open({
            message: res + '',
            type: 'error',
            position: 'bottom-right'
        })
    }
}
</script>

<style scoped lang="scss">
</style>
