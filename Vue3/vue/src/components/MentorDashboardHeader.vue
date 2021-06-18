<template>
    <b-navbar toggleable="lg" class="bg-header border-0" type="light">
        <b-container class="p-0">
            <b-navbar-brand>
                <router-link class="w-10" to="/mentor/dashboard">
                    <b-img fluid width="100" :src="logo"></b-img>
                </router-link>
            </b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="text-center">
                    <b-nav-item class="text-black" to="/mentor/dashboard">DASHBOARD</b-nav-item>
                </b-navbar-nav>

                <b-navbar-nav class="ml-auto text-center">
                    <b-nav-item-dropdown right>
                        <template #button-content>
                            <font-awesome-icon icon="flag" class="m-2"/>
                        </template>
                        <b-dropdown-item href="#">EN</b-dropdown-item>
                        <b-dropdown-item href="#">NL</b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item-dropdown right>
                        <template #button-content>
                            <font-awesome-icon icon="user" class="m-2"/>
                        </template>
                        <b-dropdown-item @click="logout()">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-container>
    </b-navbar>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';


@Component({
    components: {}
})

export default class StudentDashboardHeader extends Vue {
    data() {
        return {
            logo: require('@/assets/BaroLogo.png')
        }
    }

    logout() {
        this.$auth.logout({
            redirect: '/auth/login'
        })
    }
}
</script>
s
<style scoped lang="scss">
@import "src/styles/dashboard/DashboardLayout";
</style>