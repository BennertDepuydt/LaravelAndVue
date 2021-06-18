<template>
  <b-row align-v="center" class="h-100 ml-0 mr-0">
    <b-col>
      <Doughnut
          :data="[25, 75, 30]"
          :labels="['For', 'Demo', 'Only']"
          :colors="['#EF5D50', '#2B3643', '#3241E4']"
      />
    </b-col>
  </b-row>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import Doughnut from "@/components/Doughnut.vue";

@Component({
  components: {
    Doughnut
  }
})
export default class Tasks extends Vue {


}
</script>

<style scoped lang="scss">
@import "./src/styles/dashboard/DashboardLayout.scss";
</style>
