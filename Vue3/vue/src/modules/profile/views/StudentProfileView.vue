<template>
    <b-container class="p-0">
        <b-row class="pt-4">
            <b-col cols="12">
                <h5 class="border-bottom py-2 d-flex justify-content-between">
                    <span class="pl-1 font-weight-bold">My Profile</span>
                </h5>
            </b-col>
        </b-row>
        <b-row class="pt-4">
            <b-col cols="12">
                <b-card class="h-100 border-0">
                    <b-row class="h-100">
                        <b-col cols="1"/>
                        <b-col cols="2">
                            <b-avatar src="https://placekitten.com/300/300" size="6rem"></b-avatar>
                        </b-col>
                        <b-col cols="4">
                            <b-row class="align-middle">
                                <h2 class="font-weight-bold pt-4">
                                    {{ this.user.username }}
                                </h2>
                            </b-row>
                        </b-col>
                    </b-row>
                </b-card>
            </b-col>
        </b-row>
        <b-row class="pt-4">
            <b-col cols="6">
                <b-card class="h-100 border-0 pb-1 pt-1 pl-4 pr-4">
                    <b-col class="d-flex flex-column">
                        <h6 class="font-weight-bold text-center">Student</h6>
                        <template class="w-70 m-auto">
                            <p class="mb-1">
                                <font-awesome-icon icon="at" class="mr-3"/>
                                <b-link v-if="user.email !== null" class="text-black">{{this.user.email}}</b-link>
                                <small class="text-muted" v-else>Unknown email</small>
                            </p>
                          <p class="mb-1">
                            <font-awesome-icon icon="phone" class="rotate mr-3"/>
                            <b-link  v-if="user.phoneNumber !== null" >{{this.user.phoneNumber}}</b-link>
                            <small class="text-muted" v-else>Unknown phonenumber</small>
                          </p>
                          <p class="mb-1">
                            <font-awesome-icon icon="map-marker-alt" class="mr-3 test"/>
                            <b-link  v-if="user.location !== null" >{{this.user.location}}</b-link>
                            <small class="text-muted" v-else>Unknown location</small>
                          </p>
                          <p class="mb-1">
                            <font-awesome-icon icon="briefcase" class="mr-3 test"/>
                            <b-link  v-if="user.workplace !== null" >{{this.user.workplace}}</b-link>
                            <small class="text-muted" v-else>Unknown workplace</small>
                          </p>
                        </template>
                    </b-col>
                </b-card>
            </b-col>
            <b-col cols="6">
                <b-card class="h-100 border-0 pb-1 pt-1 pl-4 pr-4">
                    <b-col class="d-flex flex-column">
                        <h6 class="font-weight-bold text-center">Mentor</h6>
                        <template class="w-70 m-auto">
                            <p class="mb-1">
                                <font-awesome-icon icon="at" class="mr-3"/>
                                <b-link v-if="mentor.email !== null" class="text-black">{{mentor.email}}</b-link>
                                <small class="text-muted" v-else>Unknown email</small>
                            </p>
                            <p class="mb-1">
                                <font-awesome-icon icon="phone" class="rotate mr-3"/>
                                <b-link v-if="mentor.phoneNumber !== null">{{mentor.phoneNumber}}</b-link>
                                <small class="text-muted" v-else>Unknown phonenumber</small>
                            </p>
                            <p class="mb-1">
                                <font-awesome-icon icon="map-marker-alt" class="mr-3 test"/>
                                <span  v-if="mentor.location !== null" >{{mentor.location}}</span>
                                <small  v-else >Unknown location</small>
                            </p>
                        </template>
                    </b-col>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {emptyUserProfileInfo, UserProfileInfo, userService} from "@/services/users/UserService";


@Component({
    components: {}
})
export default class StudentProfile extends Vue {
    private user: UserProfileInfo = emptyUserProfileInfo()
    private mentor: UserProfileInfo = emptyUserProfileInfo()
    private userId : string = ""

    async mounted() {
      this.userId = await this.$auth.fetch()
        .then(function(r: any) {
          return r.data.id
        })
        await this.getUser()
        await this.getMentor()
    }

    async getUser() {


        await userService.getUserInfo(this.userId)
        .then((r) => {
            this.user = r
        })
            //TODO: Error handling
        .catch()
        .finally()
    }
  async getMentor(){
    await userService.getStudentMentor(this.userId)
        .then((r) => {
          this.mentor = r
        })
  }
}

</script>

<style scoped lang="scss">
.rotate {
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}

.test {
    width: 16px;
}
</style>
