<template>
  <div>
  <b-col v-for="n in 2">
    <b-card class="p-1 h-100 mb-3 border-0">
    <b-row class="d-flex mb-1">
      <b-col>
        <h5>
          <font-awesome-icon class="black" icon="user"/>
          <span class="ml-3">Docent A</span>
        </h5>
      </b-col>
    </b-row>
      <b-row>
      <b-col>
        <span class="font-weight-bold">Difficulty</span>
        <progress-bar val="4"></progress-bar>
      </b-col>
      </b-row>
    <b-row>
      <b-col>
        <span>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare non ante eu aliquet. Praesent vestibulum orci eu sapien ultricies molestie. Fusce non mauris ut eros condimentum auctor. Ut turpis mauris, faucibus a scelerisque in, porta quis magna. Vivamus non ipsum ac lectus interdum bibendum vel sed nulla.
        </span>
      </b-col>
    </b-row>
    </b-card>
  </b-col>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import ProgressBar from "@/modules/tasks/components/ProgressBar.vue";

@Component({
  components: {ProgressBar}
})
export default class TaskFeedbackList extends Vue {

}
</script>

<style scoped lang="scss">
@import "./src/styles/dashboard/DashboardLayout.scss";
</style>

