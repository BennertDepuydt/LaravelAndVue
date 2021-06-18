<template>
    <b-container class="p-0">
        <b-row class="vertical-center">
            <b-col cols="4"/>
            <b-col cols="4">
                <b-img fluid width="350" :src="pic"></b-img>
                <div class="w-100 text-center">
                    <h1 class="font-weight-bold">GroeiBaroMeter</h1>
                </div>
                <b-button class="w-100 mt-3" variant="outline-primary"  :to="`/auth/login`">
                    Get Started
                </b-button>
            </b-col>
            <b-col cols="4"/>
        </b-row>

    </b-container>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";

@Component({
    components: {
    }
})
export default class StudentDashboardView extends Vue {
    data() {
        return {
            pic: require('@/assets/homepage.svg')
        }
    }
}
</script>

<style lang="scss" scoped>
@import "src/styles/auth/AuthLayout";
.vertical-center {
    height: 100vh;
    align-items: center;
}
</style>