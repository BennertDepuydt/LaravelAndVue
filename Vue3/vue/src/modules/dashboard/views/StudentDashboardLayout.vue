<template>
    <div>
        <student-dashboard-header/>
        <div class="general-page">
            <router-view/>
        </div>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import DashboardHeader from "@/components/StudentDashboardHeader.vue";
import StudentDashboardHeader from "@/components/StudentDashboardHeader.vue";

@Component({
  components: {StudentDashboardHeader, DashboardHeader}
})
export default class StudentDashboardLayout extends Vue {

}
</script>

<style lang="scss">
@import "./src/styles/dashboard/DashboardLayout.scss";
</style>
