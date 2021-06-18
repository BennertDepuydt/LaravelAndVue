<template>
    <div>
        <auth-card-register v-if="firstStage">
            <template v-slot:form>
                <b-form>
                    <b-input-group class="mt-3">
                        <b-form-input
                            type="text"
                            required
                            v-model="firstName"
                            :state="firstNameValid"
                            v-on:click="checkFirstName()"
                            placeholder="Firstname"
                        ></b-form-input>
                    </b-input-group>

                    <b-input-group class="mt-3">
                        <b-form-input
                            type="text"
                            required
                            v-model="lastName"
                            :state="lastNameValid"
                            v-on:click="checkLastName()"
                            placeholder="Lastname"
                        ></b-form-input>
                    </b-input-group>

                    <b-input-group class="mt-3">
                        <b-form-input
                            type="tel"
                            required
                            v-model="phone"
                            :state="phoneValid"
                            v-on:click="checkPhone()"
                            placeholder="Phone"
                        ></b-form-input>
                    </b-input-group>

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
                            type="text"
                            required
                            v-model="workplace"
                            :state="workplaceValid"
                            v-on:click="checkWorkplace()"
                            placeholder="Workplace"
                        ></b-form-input>
                    </b-input-group>

                    <b-input-group class="mt-3">
                        <b-form-input
                            required
                            v-b-tooltip.hover.left="'Min length: 8 & 1 special character.'"
                            v-model="password"
                            :state="passwordValid"
                            v-on:click="checkPassword()"
                            placeholder="Password"
                            type="password"
                        ></b-form-input>
                    </b-input-group>

                    <b-input-group class="mt-3">
                        <b-form-input
                            required
                            v-model="confirmedPassword"
                            :state="confirmedPasswordValid"
                            v-on:click="checkConfirmedPassword()"
                            placeholder="Repeat password"
                            type="password"
                        ></b-form-input>
                    </b-input-group>

                    <b-form-checkbox v-model="receiveEmail" class="mt-3" name="check-button" switch>
                        Receive email notifications
                    </b-form-checkbox>

                    <b-button v-if="!isNotStudent" class="w-100 mt-3" @click="switchStage()" variant="outline-primary">
                        Save
                    </b-button>

                    <b-button v-else class="w-100 mt-3" :disabled="isLoadingRegistration" @click="switchStage()" variant="outline-primary">
                        <template v-if="isLoadingRegistration">
                            <b-spinner small label="Small Spinner"></b-spinner>
                        </template>
                        Register
                    </b-button>
                </b-form>
            </template>
        </auth-card-register>

        <auth-card-register v-if="secondStage">
            <template v-slot:form>
                <b-form>
                    <b-input-group class="mt-3">
                        <b-form-input
                            type="text"
                            required
                            v-model="address"
                            :state="addressValid"
                            v-on:click="checkAddress()"
                            placeholder="Address"
                        ></b-form-input>
                    </b-input-group>

                    <vue-bootstrap-typeahead
                        class="mt-3"
                        :state="false"
                        v-on:click="checkQuery()"
                        :data="educations"
                        :serializer="s => s.name"
                        :id="s => s.id"
                        placeholder="Search your education"
                    >
                        <template slot="suggestion" slot-scope="{ data, htmlText }">
                            <span v-html="htmlText" @click="setEducation(`${data.id}`)"></span>
                        </template>
                    </vue-bootstrap-typeahead>

                    <b-button class="w-100 mt-5" :disabled="isLoadingRegistration" @click="register()"
                              variant="outline-primary">
                        <template v-if="isLoadingRegistration">
                            <b-spinner small label="Small Spinner"></b-spinner>
                        </template>
                        Register
                    </b-button>
                </b-form>
            </template>
        </auth-card-register>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import AuthCardRegister from "@/modules/auth/components/AuthCardRegister.vue";
import {educationService} from "@/services/educations/EducationService";

@Component({
    components: {AuthCardRegister},
})
export default class RegisterView extends Vue {
    private educations: Array<string> = []
    private isLoading: boolean = false;
    private isLoadingRegistration: boolean = false;

    private firstName: string = ''
    private lastName: string = ''
    private email: string = ''
    private password: string = ''
    private confirmedPassword: string = ''
    private query: string = ''
    private address: string = ''
    private phone: string = ''
    private workplace: string = ''

    private firstStage: boolean = true;
    private secondStage: boolean = false;
    private isNotStudent: boolean = false;
    private receiveEmail: boolean = false;

    private firstNameValid: boolean | null = null;
    private lastNameValid: boolean | null = null;
    private emailValid: boolean | null = null;
    private passwordValid: boolean | null = null;
    private confirmedPasswordValid: boolean | null = null;
    private queryValid: boolean | null = null;
    private addressValid: boolean | null = null;
    private phoneValid: boolean | null = null;
    private workplaceValid: boolean | null = null;

    @Watch('firstName')
    checkFirstName() {
        this.firstNameValid = this.firstName !== '' && this.firstName.length > 1;
    }

    @Watch('lastName')
    checkLastName() {
        this.lastNameValid = this.lastName !== '' && this.lastName.length > 1;
    }

    @Watch('phone')
    checkPhone() {
        this.phoneValid = this.phone !== '';
    }

    @Watch('email')
    checkEmail() {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        this.emailValid = re.test(this.email) && this.email !== ''
    }

    @Watch('workplace')
    checkWorkplace() {
        this.workplaceValid = this.workplace !== '' && this.workplace.length > 1;
    }

    @Watch('password')
    checkPassword() {
        this.checkConfirmedPassword()
        const specialChars = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        this.passwordValid = this.password !== '' && this.password.length > 7 && specialChars.test(this.password)
    }

    @Watch('confirmedPassword')
    checkConfirmedPassword() {
        this.confirmedPasswordValid = this.password === this.confirmedPassword && this.confirmedPassword !== ''
    }

    @Watch('query')
    checkQuery() {
        this.queryValid = this.query !== ''
    }

    @Watch('address')
    checkAddress() {
        this.addressValid = this.address !== ''
    }

    mounted() {
        this.getEducationList()
    }

    async getEducationList() {
        try {
            this.isLoading = true
            this.educations = await educationService.getEducations()
                .then((r) => this.educations = r)
                .catch()
                .finally(() => this.isLoading = false)
        } catch (e) {
            console.log(e)
        }
    }

    setEducation(id: string) {
        this.query = id
    }

    switchStage() {
        if (this.checkFirstStage()) {
            const domain = this.email.substring(this.email.indexOf('@') + 1);

            if (domain === 'student.odisee.be') {
                this.firstStage = false;
                this.secondStage = true;
            } else {
                this.isNotStudent = true
                this.register()
            }
        }
    }

    checkFirstStage(): boolean {
        if (this.firstNameValid &&
            this.lastNameValid &&
            this.emailValid &&
            this.passwordValid &&
            this.phone &&
            this.confirmedPasswordValid &&
            this.workplace) {
            return true
        } else {
            this.launchFieldToast()
            return false
        }
    }

    checkSecondStage(): boolean {
        return !!(this.addressValid && this.queryValid);
    }


    async register() {
        this.isLoadingRegistration = true
        if (this.checkSecondStage() || this.isNotStudent) {
            this.$auth
                .register({
                    data: {
                        firstname: this.firstName,
                        lastname: this.lastName,
                        email: this.email,
                        password: this.password,
                        phoneNumber: this.phone,
                        location: this.address,
                        eduId: this.query,
                        wantsMails: this.receiveEmail,
                        workplace: this.workplace,
                    },
                    error: function () {
                        Vue.router.push('/403')
                    },
                    staySignedIn: true,
                    autoLogin: true,
                })
                .then(() => {
                    this.$auth.fetch()
                        .then(function (r: any) {
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
                        this.isLoadingRegistration = false
                    })
                })
                .catch(() => {
                    this.launchErrorToast();

                })
            .finally(() => {
                this.isLoadingRegistration = false
            })

        }
    }


    launchErrorToast() {
        Vue.$toast.open({
            message: 'Something went wrong, try again!',
            type: 'error',
            position: 'bottom-right'
        })
    }

    launchFieldToast() {
        Vue.$toast.open({
            message: 'Fill in all fields.',
            type: 'error',
            position: 'bottom-right'
        })
    }

}

</script>

<style scoped lang="scss">
</style>
