<template>
  <div class="w-100 ml-sm-2">
      <b-row >
        <b-col class="d-flex justify-content-between">
          <div class="">
              <small>Evaluation</small>
          </div>
          <div class="test">
            <b-progress v-if="parseInt(evaluation) === 0" class="border" style="width: 91%;" :value="evaluation" height="5px" min="0" max="5"></b-progress>
            <b-progress v-else-if="parseInt(evaluation) < 3" variant="danger" style="width: 91%;background-color:#CCCCCC" :value="evaluation" height="5px" min="0" max="5"></b-progress>
            <b-progress v-else-if="parseInt(evaluation) < 4"  variant="warning" style="width: 91%;background-color:#CCCCCC" :value="evaluation" height="5px" min="0" max="5"></b-progress>
            <b-progress v-else-if="parseInt(evaluation) < 6" variant="success" style="width: 91%;background-color:#CCCCCC" :value="evaluation" height="5px" min="0" max="5"></b-progress>
          </div>
        </b-col>
      </b-row>
    <b-row >
      <b-col class="d-flex justify-content-between">
        <div class="">
          <small>Complexity</small>
        </div>
        <div class="test">
          <b-progress v-if="parseInt(complexity) === 0" class="border" style="width: 91%;" :value="complexity" height="5px" min="0" max="5"></b-progress>
          <b-progress v-else-if="parseInt(complexity) < 3" variant="danger" style="width: 91%;background-color:#CCCCCC" :value="complexity" height="5px" min="0" max="5"></b-progress>
          <b-progress v-else-if="parseInt(complexity) < 4"  variant="warning" style="width: 91%;background-color:#CCCCCC" :value="complexity" height="5px" min="0" max="5"></b-progress>
          <b-progress v-else-if="parseInt(complexity) < 6" variant="success" style="width: 91%;background-color:#CCCCCC" :value="complexity" height="5px" min="0" max="5"></b-progress>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col class="d-flex justify-content-between">
        <div class="">
          <small>Independency</small>
        </div>
        <div class="test">
          <b-progress v-if="parseInt(independency) === 0" class="border" style="width: 91%;" :value="independency" height="5px" min="0" max="5"></b-progress>
          <b-progress v-else-if="parseInt(independency) < 3" variant="danger" style="width: 91%;background-color:#CCCCCC" :value="independency" height="5px" min="0" max="5"></b-progress>
          <b-progress v-else-if="parseInt(independency) < 4"  variant="warning" style="width: 91%;background-color:#CCCCCC" :value="independency" height="5px" min="0" max="5"></b-progress>
          <b-progress v-else-if="parseInt(independency) < 6" variant="success" style="width: 91%;background-color:#CCCCCC" :value="independency" height="5px" min="0" max="5"></b-progress>
        </div>
      </b-col>
    </b-row>
    <b-row v-if="this.preference !== undefined">
      <b-col class="d-flex justify-content-between">
        <div class="">
          <small>Preference</small>
        </div>
        <div class="test">
          <b-progress v-if="parseInt(preference) === 0" class="border" style="width: 91%;" :value="preference" height="5px" min="0" max="5"></b-progress>
          <b-progress v-else-if="parseInt(preference) < 3" variant="danger" style="width: 91%;background-color:#CCCCCC" :value="preference" height="5px" min="0" max="5"></b-progress>
          <b-progress v-else-if="parseInt(preference) < 4"  variant="warning" style="width: 91%;background-color:#CCCCCC" :value="preference" height="5px" min="0" max="5"></b-progress>
          <b-progress v-else-if="parseInt(preference) < 6" variant="success" style="width: 91%;background-color:#CCCCCC" :value="preference" height="5px" min="0" max="5"></b-progress>
        </div>
      </b-col>
    </b-row>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';

@Component({
  components: {}
})
export default class ProgressBar extends Vue {
  @Prop() evaluation: number | undefined
  @Prop() complexity: number | undefined
  @Prop() independency: number | undefined
  @Prop() preference: number | undefined

}
</script>

<style scoped lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
.test {
  margin-top: 11px;
  width: 80%;
}
.border {
  -webkit-appearance:none;
  -moz-appearance:none;
  -s-appearance:none;
  -o-appearance:none;
  appearance:none;
  border:1px solid red !important;
}
</style>

