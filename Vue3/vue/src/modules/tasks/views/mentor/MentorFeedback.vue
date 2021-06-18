<template>
  <b-overlay
      :show="!this.dataReady"
      spinner-variant="secondary"
      style="overflow: hidden"
      variant="white"
  >
        <b-container>
            <b-row class="pb-2">
              <b-col cols="6">
                <div>
                  <h6 class=" pb-2 border-bottom border-dark">Student</h6>
                </div>
              </b-col>
              <b-col cols="6">
                <div>
                  <h6 class="pb-2 border-bottom border-dark">Mentor</h6>
                </div>
              </b-col>
            </b-row>
            <b-row class="pb-2">
                <b-col cols="6">
                    <div>
                        <small class="ml-1">Evaluation</small>
                        <progress-bar :val="this.student.evaluation"></progress-bar>
                    </div>
                </b-col>
                <b-col cols="6">
                    <div>
                        <small class="ml-1">Evaluation</small>
                        <difficulty-range-selector @sliderChange="handleDifficultySlider"></difficulty-range-selector>
                    </div>
                </b-col>
            </b-row>
            <b-row class="pb-2">
                <b-col cols="6">
                    <div>
                        <small class="ml-1">Complexity</small>
                        <progress-bar :val="this.student.complexity" ></progress-bar>
                    </div>
                </b-col>
                <b-col cols="6">
                    <div>
                        <small class="ml-1">Complexity</small>
                        <difficulty-range-selector @sliderChange="handleComplexitySlider"></difficulty-range-selector>
                    </div>
                </b-col>
            </b-row>
            <b-row class="pb-2">
                <b-col cols="6">
                    <div>
                        <small  class="ml-1">Independence</small>
                        <progress-bar :val="this.student.independency"></progress-bar>
                    </div>
                </b-col>
                <b-col cols="6">
                    <div>
                        <small class="ml-1">Independence</small>
                        <difficulty-range-selector @sliderChange="handleIndependenceSlider"></difficulty-range-selector>
                    </div>
                </b-col>
            </b-row>
          <b-row class="pb-2">
            <b-col cols="6">
              <div>
                <small class="ml-1">Preference</small>
                <progress-bar :val="this.student.preference" ></progress-bar>
              </div>
            </b-col>
          </b-row>
            <b-row cols="12" class="pt-4">
                <b-col cols="6">
                  <span class="font-weight-bold">Remark</span>
                  <b-form-textarea
                      id="textarea-default"
                      v-model="this.student.comment"
                      plaintext
                      rows="5"
                      class="p-3 mt-2 mb-3"
                      style="border:solid 1px #CCCCCC"
                  ></b-form-textarea>
                </b-col>
              <b-col cols="6">
                <span class="font-weight-bold">Feedback</span>
                <b-form-textarea
                    id="textarea-default"
                    v-model="mentorFeedback"
                    placeholder="Type your feedback here"
                    rows="5"
                    :state="this.feedbackValid"
                    v-on:click="feedbackCheck()"
                    class="mt-2 mb-3 p-3"
                ></b-form-textarea>
              </b-col>

              </b-row>
              <b-row cols="12">
                <b-col cols="6">
                  <span class="font-weight-bold">Description</span>
                  <b-form-textarea
                      id="textarea-default"
                      v-model="this.student.description"
                      plaintext
                      rows="5"
                      class="p-3 mt-2"
                      style="border:solid 1px #CCCCCC"
                  ></b-form-textarea>
                </b-col>
                  <b-col cols="6">
                    <span class="font-weight-bold">Feedforward</span>
                    <b-form-textarea
                        id="textarea-default"
                        v-model="mentorFeedforward"
                        placeholder="Type your feedforward here"
                        v-on:click="feedforwardCheck()"
                        rows="5"
                        :state="this.feedforwardValid"
                        class="mt-2 mb-3 p-3"
                    ></b-form-textarea>
                  </b-col>
              </b-row>
          <b-row cols="12" class="mb-3">
            <b-col>
              <div class="d-flex justify-content-end">
                <font-awesome-icon :class="{ thumpsup: mentorisActive }" @click="mentorisActive = !mentorisActive" icon="thumbs-up" outline></font-awesome-icon>
                <font-awesome-icon :class="{ thumpsdown : !mentorisActive }" @click="mentorisActive = !mentorisActive" class="ml-2" icon="thumbs-down"></font-awesome-icon>
              </div>
            </b-col>
          </b-row>
          <b-button type="submit" class="mt-5 mb-5 float-right" @click="saveFeedbackMentor()" variant="light">
            Add
          </b-button>
        </b-container>
  </b-overlay>
</template>

<script lang="ts">

import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import DifficultyRangeSelector from "@/components/DifficultyRangeSelector.vue";
import ProgressBar from "@/modules/tasks/components/ProgressBar.vue";
import StudentFeedback from "@/modules/tasks/views/student/StudentFeedback.vue";
import {feedbackService, Feedback , emptyfeedback} from "@/services/feedbacks/FeedbackService";
import {taskService, TaskStudent , emptytaskstudent} from "@/services/tasks/TaskService";
import {timeout} from "rxjs/operators";



@Component({
    components: {
        DifficultyRangeSelector,
        ProgressBar,
        StudentFeedback
    }
})
export default class MentorFeedback extends Vue {
    private mentorFeedback: string = ""
    private mentorFeedforward: string = ""
    private mentorisActive : boolean = true
    private mentordifficulty : number = 0
    private mentorindependence : number = 0
    private mentorcomplexity : number = 0
    private student : TaskStudent = emptytaskstudent()
    private feedbackList: Array<Feedback> = []
    private count : number = 0
    private userid : string = ""
    private feedback : boolean = false
    private feedbackValid: boolean | null = null
    private feedforwardValid: boolean | null = null

    @Prop () id : string | undefined
    private dataReady: boolean = false

  async mounted() {
    await Promise.all([
      await this.getstudentinfo(),
      this.userid = await this.$auth.fetch()
          .then(function(r: any) {
            return r.data.id
          })
    ]).then(() => {
      this.dataReady = true
    }).catch(() => {
      this.dataReady = false
    })
  }

    async getstudentinfo() {
      await feedbackService.getfeedbackstudent(this.id)
          .then((r) => {
            this.student = r
         })
          .catch(()=>{
            Vue.router.push('/404')
            this.launchErrorToast()
          })
    }
    validation() : boolean{
      return !(!isNaN(this.mentordifficulty) || !isNaN(this.mentorcomplexity) || !isNaN(this.mentorindependence));
    }

    async saveFeedbackMentor() {
      this.feedbackCheck()
      this.feedforwardCheck()
      if(this.student.stage == 2){
        if((!this.validation() && this.feedbackValid && this.feedforwardValid) == true){
          await feedbackService.setmentorfeedback(this.mentorFeedback, this.mentorFeedforward,  this.mentordifficulty, this.mentorcomplexity, this.mentorindependence, this.mentorisActive,this.userid,this.student.id)
              .then((r) => {
                this.feedback = r
              })
              .catch(() => {
                Vue.router.push('/404')
                this.launchErrorToast()
              })
          if(this.feedback){
            await this.getstudentinfo()
            await taskService.setStage(this.student , 3)
            await Vue.router.push('/mentor/dashboard')
            this.launchFeedbackAddedToast()
          }
        }
        else {
          if(this.feedbackValid == false){
            Vue.$toast.open({
              message: 'Feedback can\'t be empty!',
              type: 'error',
              position: 'bottom-right'
            })
          }
          if(this.feedforwardValid == false){
            Vue.$toast.open({
              message: 'Feedforward can\'t be empty!',
              type: 'error',
              position: 'bottom-right'
            })
          }
        }
      }
      }

  @Watch('mentorFeedback')
  feedbackCheck() {
    this.feedbackValid = this.mentorFeedback !== ''
  }
  @Watch('mentorFeedforward')
  feedforwardCheck() {
    this.feedforwardValid = this.mentorFeedforward !== ''
  }


    handleDifficultySlider(difficulty: number){
      this.mentordifficulty = difficulty
    }
    handleIndependenceSlider(independence: number){
      this.mentorindependence = independence
    }
    handleComplexitySlider(complexity: number){
      this.mentorcomplexity = complexity
    }

  launchFeedbackToast() {

  }
  launchFeedforwardToast() {

  }
  launchFeedbackAddedToast() {
    Vue.$toast.open({
      message: 'Feedback is successfully added!',
      type: 'success',
      position: 'bottom-right'
    })
  }
  launchErrorToast() {
    Vue.$toast.open({
      message: 'Something went wrong, try again!',
      type: 'error',
      position: 'bottom-right'
    })
  }
}
</script>

<style scoped lang="scss">
@import "src/styles/tasks/TaskLayout.scss";

</style>