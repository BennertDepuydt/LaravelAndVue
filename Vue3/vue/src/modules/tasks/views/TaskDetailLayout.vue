<template>
  <b-container class="p-0" >
      <router-view></router-view>
  </b-container>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';

@Component({
  components: {

  }
})
export default class TaskDetailLayout extends Vue {


}
</script>

<style scoped lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
</style>