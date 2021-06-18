<template>

  <b-overlay
      :show="!this.dataReady"
      spinner-variant="secondary"
      style="overflow: hidden"
      variant="white"
  >
    <b-col cols="12">
      <b-row class="mb-row">
        <b-col class="pl-0">
          <h6 class="pb-2 border-bottom border-dark">Mentor</h6>
        </b-col>
      </b-row>
      <div v-if="mentor !== undefined ">
      <b-row class="mb-2">
        <small class="ml-1">Evaluation</small>
      </b-row>
      <b-row class="mb-1">
        <progress-bar :val="mentor.evaluation"></progress-bar>
      </b-row>
      <b-row class="mb-2">
        <small  class="ml-1">Complexity</small>
      </b-row>
      <b-row class="mb-1">
        <progress-bar :val="mentor.complexity"></progress-bar>
      </b-row>
      <b-row class="mb-2">
        <small class="ml-1">Independence</small>
      </b-row>
      <b-row class="mb-2">
        <progress-bar :val="mentor.independency"></progress-bar>
      </b-row>
      <b-row style="height:4rem;">

      </b-row>
      <b-row class="mb-2">
        <span class="font-weight-bold">Feedback</span>
      </b-row>
      <b-row class="mb-3">
        <b-col class="pl-0">
      <b-form-textarea
          v-model="mentor.feedback"
          plaintext
          rows="5"
          style="border:solid 1px #CCCCCC"
          class="p-3"
      ></b-form-textarea>
        </b-col>
      </b-row>
      <b-row class="mb-2">
        <span class="font-weight-bold">FeedForward</span>
      </b-row>
      <b-row class="mb-3">
        <b-col class="pl-0">
          <b-form-textarea
              v-model="mentor.feedforward"
              plaintext
              rows="5"
              style="border:solid 1px #CCCCCC"
              class="p-3 mb-2"
          ></b-form-textarea>
          <div class="d-flex justify-content-end mt-2">
            <font-awesome-icon :class="{ thumpsup: mentor.positive }" icon="thumbs-up" outline></font-awesome-icon>
            <font-awesome-icon :class="{ thumpsdown : !mentor.positive}" class="ml-2" icon="thumbs-down"></font-awesome-icon>
          </div>
        </b-col>
      </b-row>
      </div>
      <div v-else>
        <div class="w-100 text-center">
        <span class="text-muted align-middle">
            Mentor has no comment
        </span>
        </div>
      </div>
    </b-col>
  </b-overlay>


</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import DifficultyRangeSelector from "@/components/DifficultyRangeSelector.vue";
import ProgressBar from "@/modules/tasks/components/ProgressBar.vue";
import {feedbackService, Feedback , emptyfeedback} from "@/services/feedbacks/FeedbackService";

@Component({
  components: {
    DifficultyRangeSelector,
    ProgressBar

  }
})
export default class StudentFeedback extends Vue {
  private remark: string =""

  private mentor : Feedback = emptyfeedback()

  @Prop() id: string | undefined
  private dataReady: boolean = false

  async mounted() {
    await Promise.all([
      await this.getfeedback()
    ]).then(() => {
      this.dataReady = true
    }).catch(() => {
      this.dataReady = false
    })
  }

  async getfeedback(){
    //if(this.studentTask.stage != 0 || 1 || 2){
    await feedbackService.getfeedbacks(this.id)
        .then((r) => {
          this.mentor = r[0]
        })
        .catch(() => {
          Vue.router.push('/404')
        })
        .finally( () => {
          //this.addRoles()
        })
    //}
  }


}
</script>

<style scoped lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
</style>