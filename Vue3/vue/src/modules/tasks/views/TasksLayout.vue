<template>
  <div>
    <dashboard-header/>
    <div class="general-page">
      <router-view/>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import DashboardHeader from "@/components/StudentDashboardHeader.vue";

@Component({
  components: {DashboardHeader}
})
export default class TasksLayout extends Vue {

}
</script>

<style lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
</style>
