<template>
    <div>
        <mentor-dashboard-header/>
        <div class="general-page">
            <router-view/>
        </div>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import DashboardHeader from "@/components/StudentDashboardHeader.vue";
import MentorDashboardHeader from "../../../components/MentorDashboardHeader.vue";

@Component({
    components: {MentorDashboardHeader, DashboardHeader}
})
export default class MentorDashboardLayout extends Vue {

}
</script>

<style lang="scss">
@import "./src/styles/dashboard/DashboardLayout.scss";
</style>
