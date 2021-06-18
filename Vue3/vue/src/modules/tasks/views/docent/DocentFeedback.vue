<template>
  <b-overlay
      :show="!this.dataReady"
      spinner-variant="secondary"
      style="overflow: hidden"
      variant="white"
  >
      <b-container class="p-0">
          <b-row>
            <b-col cols="6">
              <student-feedback :id="this.id"></student-feedback>
            </b-col>
            <b-col cols="6" >
                <MentorFeedbackDocent :id="this.id"></MentorFeedbackDocent>
            </b-col>
          </b-row>
        <b-row class="mt-1">
          <b-col class="pl-0">
            <h6 class="pb-2 mt-4 border-bottom border-dark">Docent</h6>
          </b-col>
        </b-row>
              <b-row class="mn-4 d-flex justify-content-between">
                    <b-col cols="6">
                    <span class="font-weight-bold">Feedback</span>
                    <b-form-textarea
                        id="textarea-default"
                        class="mb-2"
                        v-model="docentFeedback"
                        :state="this.feedbackValid"
                        rows="5"
                        v-on:click="feedbackCheck"
                        placeholder="Type your feedback here"
                    ></b-form-textarea>
                    </b-col>
                    <b-col cols="6">
                    <span class="font-weight-bold">FeedForward</span>
                    <b-form-textarea
                        id="textarea-default"
                        class="mb-2"
                        rows="5"
                        v-model="docentFeedforward"
                        :state="this.feedforwardValid"
                        v-on:click="feedforwardCheck()"
                        placeholder="Type your feedforward here"
                    ></b-form-textarea>
                      <div class="d-flex justify-content-end">
                        <font-awesome-icon :class="{ thumpsup: docentisActive }" @click="docentisActive = !docentisActive" icon="thumbs-up" outline></font-awesome-icon>
                        <font-awesome-icon :class="{ thumpsdown : !docentisActive }" @click="docentisActive = !docentisActive" class="ml-2" icon="thumbs-down"></font-awesome-icon>
                      </div>
                    </b-col>
              </b-row>
        <b-button type="submit" class="my-5 float-right" @click="saveFeedbackDocent()" variant="light">
          Add
        </b-button>
      </b-container>
  </b-overlay>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import DifficultyRangeSelector from "@/components/DifficultyRangeSelector.vue";
import StudentFeedback from "@/modules/tasks/views/student/StudentFeedback.vue";
import MentorFeedbackDocent from "@/modules/tasks/views/mentor/MentorFeedbackDocent.vue";
import {feedbackService, Feedback , emptyfeedback} from "@/services/feedbacks/FeedbackService";
import {taskService, TaskStudent , emptytaskstudent} from "@/services/tasks/TaskService";

@Component({
  components: {
    DifficultyRangeSelector,
    StudentFeedback,
    MentorFeedbackDocent
  }
})
export default class DocentFeedback extends Vue {
  private docentFeedback: string = ""
  private docentisActive : boolean = true
  private student : TaskStudent = emptytaskstudent()
  private feedback : boolean = false
  private docentFeedforward : string = ""
  private feedbackValid : boolean | null = null
  private feedforwardValid : boolean | null = null


  @Prop() id: string | undefined
  private dataReady: boolean = false


  async mounted() {
    await Promise.all([
      await this.getstudentinfo()
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
        .finally()
  }
  async saveFeedbackDocent(){
    this.feedbackCheck()
    this.feedforwardCheck()
    if(this.student.stage == 3){
      const userId = await this.$auth.fetch()
          .then(function(r: any) {
            return r.data.id
          })
      if((this.feedbackValid && this.feedforwardValid) == true){
        await feedbackService.setdocentfeedback(this.docentFeedback,this.docentFeedforward, this.docentisActive, userId,this.id)
            .then((r) => {
              this.feedback = r
            })
            .catch(()=>{
              Vue.router.push('/404')
              this.launchErrorToast()
            })
        if(this.feedback){
          await this.getstudentinfo()
          await taskService.setStage(this.student, 4)
          await Vue.router.push('/lecturer/dashboard')
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
  @Watch('docentFeedback')
  feedbackCheck() {
    this.feedbackValid = this.docentFeedback !== ''
  }
  @Watch('mentorFeedforward')
  feedforwardCheck() {
    this.feedforwardValid = this.docentFeedforward !== ''
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



  @Prop() value: string | undefined
}
</script>

<style scoped lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
</style>