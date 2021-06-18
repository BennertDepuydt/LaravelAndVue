<template>
  <div class="w-100">
    <b-col class="p-0">
      <b-row>
        <b-col v-if="parseInt(val) === 0">
          <b-progress class="border" style="width: 91%;" :value="val" height="5px" min="0" max="5"></b-progress>
        </b-col>
        <b-col v-else-if="parseInt(val) < 3">
          <b-progress  variant="danger" style="width: 91%;background-color:#CCCCCC" :value="val" height="5px" min="0" max="5"></b-progress>
        </b-col>
        <b-col v-else-if="parseInt(val) < 4">
          <b-progress variant="warning" style="width: 91%;background-color:#CCCCCC" :value="val" height="5px" min="0" max="5"></b-progress>
        </b-col>
        <b-col v-else-if="parseInt(val) < 6">
          <b-progress variant="success" style="width: 91%;background-color:#CCCCCC" :value="val" height="5px" min="0" max="5"></b-progress>
        </b-col>
      </b-row>
      <b-row class="d-flex justify-content-around">
        <b-col><small>0</small></b-col>
        <b-col><small>1</small></b-col>
        <b-col><small>2</small></b-col>
        <b-col><small>3</small></b-col>
        <b-col><small>4</small></b-col>
        <b-col><small>5</small></b-col>
      </b-row>
    </b-col>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';

@Component({
  components: {}
})
export default class ProgressBar extends Vue {
  @Prop() val: number | undefined

}
</script>

<style scoped lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
.border {
  -webkit-appearance:none;
  -moz-appearance:none;
  -s-appearance:none;
  -o-appearance:none;
  appearance:none;
  border:1px solid red !important;
}
</style>

