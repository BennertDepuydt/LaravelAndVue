<template>
    <b-overlay
        :show="!this.dataReady"
        spinner-variant="secondary"
        style="overflow: hidden"
        variant="white"
    >
        <b-container class="p-0 pb-5">
            <div>
                <b-row class="p-0">
                    <b-col class="col-lg-6">
                        <b-row class="pt-4">
                            <b-col cols="12">
                                <h5 class="border-bottom py-2 d-flex justify-content-between">
                                    <span class="pl-1 font-weight-bold">Task</span>
                                    <span class="mr-1">
                                    <b-link>
                                        <font-awesome-icon @click="$router.push({ name: 'edit' })" icon="edit"/>
                                    </b-link>
                                    <b-link>
                                        <font-awesome-icon @click="deleteTask()" icon="trash" class="ml-3"/>
                                    </b-link>
                                </span>
                                </h5>
                            </b-col>
                        </b-row>
                        <b-row class="pt-4">
                            <b-col cols="12">
                                <b-card class="h-100 border-0">
                                    <b-row class="p-3 mb-2 mr-1 ml-1 bg-white">
                                        <b-col>
                                            {{ this.studentTask.subject.name }}
                                        </b-col>
                                    </b-row>
                                    <b-row class="mb-2 mr-1 ml-1">
                                        <b-col class="p-3 mr-2 bg-white">
                                            <span class="pl-3 font-weight-bold">From</span>
                                            <span class="pl-1">
                                                {{ this.studentTask.startedAt.substring(0, 10) }}
                                            </span>
                                        </b-col>
                                        <b-col class="p-3 bg-white">
                                            <span class="pl-3 font-weight-bold">To</span>
                                            <span class="pl-1">
                                                {{ this.studentTask.endedAt.substring(0, 10) }}
                                            </span>
                                        </b-col>
                                    </b-row>
                                    <b-row class="p-3 mb-2 mr-1 ml-1 bg-white">
                                        <b-col>
                                            <span class="font-weight-bold">Evaluation</span>
                                            <!--<progress-bar :val="this.studentTask.evaluation"></progress-bar>-->
                                          <detail-progress-bar
                                                :preference="this.studentTask.preference"
                                                :evaluation="this.studentTask.evaluation"
                                                :complexity="this.studentTask.complexity"
                                                :independency="this.studentTask.independency"
                                            ></detail-progress-bar>
                                        </b-col>
                                    </b-row>
                                    <b-row class="p-3 mb-2 mr-1 ml-1  bg-white">
                                        <b-col cols="12">
                                            <b-row class="pl-3 mb-1">
                                                <span class="font-weight-bold">Description</span>
                                            </b-row>
                                            <b-row class="pl-3">
                                              <b-form-textarea
                                                  id="textarea-default"
                                                  v-model="this.studentTask.description"
                                                  plaintext
                                                  max-rows="5"
                                                  style="border:none;"
                                              ></b-form-textarea>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row class="p-3 mb-2 mr-1 ml-1 bg-white">
                                        <b-col cols="12">
                                            <b-row  class="pl-3 mb-1">
                                                <span class="font-weight-bold">Comment</span>
                                            </b-row>
                                            <b-row class="pl-3">
                                              <b-form-textarea

                                                  v-model="this.studentTask.comment"
                                                  id="textarea-default"
                                                  plaintext
                                                  max-rows="5"
                                                  style="border:none;"
                                              ></b-form-textarea>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                </b-card>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col class="col-lg-6">
                        <b-row class="pt-4">
                            <b-col cols="12">
                                <h5 class="border-bottom py-2 d-flex justify-content-between">
                                    <span class="pl-1 font-weight-bold">Feedback</span>
                                </h5>
                            </b-col>
                        </b-row>

                        <b-row v-if="this.feedbacklist.length !== 0" class="pt-4 mb-1">
                            <b-col cols="12" v-for="feedback in this.feedbacklist" :key="feedback.id" class="mb-4">
                                <b-card v-if="feedback.userId === mentor.id" class="p-1 h-100 mb-3 border-0">
                                  <b-row  class="d-flex mb-1">
                                    <b-col>
                                      <h5>
                                        <b-col>
                                          <b-row class="mb-3" style="border-bottom:solid 1px black">
                                            Mentor
                                          </b-row>
                                          <b-row>
                                            <font-awesome-icon class="text-muted" icon="user"/>
                                            <span class="ml-2">
                                              {{ mentor.firstname }} {{ mentor.lastname }}
                                            </span>
                                          </b-row>
                                        </b-col>
                                      </h5>
                                    </b-col>
                                  </b-row>
                                    <b-row class="mb-2">
                                        <b-col>
                                          <span>
                                          <detail-progress-bar
                                              :evaluation="feedback.evaluation"
                                              :complexity="feedback.complexity"
                                              :independency="feedback.independency"
                                          >
                                          </detail-progress-bar>
                                          </span>
                                        </b-col>
                                    </b-row>
                                  <b-row class="p-3 mb-2 mr-1 ml-1  bg-white">
                                    <b-col cols="12">
                                      <b-row class="pl-3 mb-1">
                                        <span class="font-weight-bold">Feedback</span>
                                      </b-row>
                                      <b-row class="pl-3">
                                        <b-form-textarea
                                            v-model="feedback.feedback"
                                            id="textarea-default"
                                            plaintext
                                            max-rows="5"
                                            style="border:none;"
                                        ></b-form-textarea>
                                      </b-row>
                                    </b-col>
                                  </b-row>
                                  <b-row class="p-3 mb-2 mr-1 ml-1 bg-white">
                                    <b-col cols="12">
                                      <b-row class="pl-3 mb-1">
                                        <span class="font-weight-bold">Feedforward</span>
                                      </b-row>
                                      <b-row class="pl-3">
                                        <b-form-textarea
                                            v-model="feedback.feedforward"
                                            id="textarea-default"
                                            plaintext
                                            max-rows="5"
                                            style="border:none;"
                                        ></b-form-textarea>

                                      </b-row>
                                    </b-col>
                                  </b-row>
                                </b-card>
                              <b-card v-if="feedback.userId === docent.id" class="p-1 h-100 mb-3 border-0" >
                                  <b-row  class="d-flex mb-1">
                                    <b-col>
                                      <h5>
                                        <b-col>
                                          <b-row class="mb-3" style="border-bottom:solid 1px black">
                                            Docent
                                          </b-row>
                                          <b-row>
                                            <font-awesome-icon class="text-muted" icon="user"/>
                                            <span class="ml-2">
                                              {{ docent.firstname }} {{ docent.lastname }}
                                            </span>
                                          </b-row>
                                        </b-col>
                                      </h5>
                                    </b-col>
                                  </b-row>
                                <b-row class="p-3 mb-2 mr-1 ml-1  bg-white">
                                  <b-col cols="12">
                                    <b-row class="pl-3 mb-1">
                                      <span class="font-weight-bold">Feedback</span>
                                    </b-row>
                                    <b-row class="pl-3">
                                      <b-form-textarea
                                          v-model="feedback.feedback"
                                          id="textarea-default"
                                          plaintext
                                          max-rows="5"
                                          style="border:none;"
                                      ></b-form-textarea>
                                    </b-row>
                                  </b-col>
                                </b-row>
                                <b-row class="p-3 mb-2 mr-1 ml-1 bg-white">
                                  <b-col cols="12">
                                    <b-row class="pl-3 mb-1">
                                      <span class="font-weight-bold">Feedforward</span>
                                    </b-row>
                                    <b-row  class="pl-3">
                                      <b-form-textarea
                                          v-model="feedback.feedforward"
                                          id="textarea-default"
                                          plaintext
                                          max-rows="5"
                                          style="border:none;"
                                      ></b-form-textarea>
                                    </b-row>
                                  </b-col>
                                </b-row>
                              </b-card>

                            </b-col>
                        </b-row>
                      <b-row>
                        <b-col>
                          <b-card v-if="this.studentTask.stage === 4 && this.feedbacklist.length === 1" class="p-1 h-100 mb-3 border-0">
                            <b-row  class="d-flex mb-1">
                              <b-col>
                                <h5>
                                  <b-col>
                                    <b-row class="mb-3" style="border-bottom:solid 1px black">
                                      Mentor
                                    </b-row>
                                    <b-row>
                                      <font-awesome-icon class="text-muted" icon="user"/>
                                      <span class="ml-2">
                                              {{ mentor.firstname }} {{ mentor.lastname }}
                                            </span>
                                    </b-row>
                                  </b-col>
                                </h5>
                              </b-col>
                            </b-row>
                            <b-row class="mb-2">
                              <b-col>
                                          <span>
                                          Mentor has no feedback
                                          </span>
                              </b-col>
                            </b-row>
                          </b-card>
                        </b-col>
                      </b-row>
                        <b-row v-if="this.feedbacklist.length == 0" class="pt-4 mb-2">
                            <NotFoundFrame title="No feedback found"/>
                        </b-row>
                    </b-col>

                    <!--<b-row>
                      <b-col class="col-lg-12 pt-4 border-bottom py-2 mr-1 ml-1" >
                        <h5 class="d-flex">
                          <span class="pl-1 font-weight-bold mb-3">Add Comment</span >
                        </h5>

                          <b-form >
                            <difficulty-range-selector class="mb-lg-4"></difficulty-range-selector>
                            <b-input-group >
                              <b-form-textarea
                                  class="mt-3"
                                  id="textarea"
                                  v-model="comment"
                                  placeholder="Type here.."
                                  rows="3"
                                  max-rows="6"
                              ></b-form-textarea>
                            </b-input-group>
                          </b-form>
                        <b-button type="submit" class="d-flex justify-content-start w-30 mt-2" @click="submitfeedback()" variant="outline-primary">
                          Add Comment
                        </b-button>
                      </b-col>
                    </b-row>-->

                </b-row>
            </div>
        </b-container>
    </b-overlay>
</template>

<script lang="ts">
import NotFoundFrame from "@/components/NotFoundFrame.vue";
import {feedbackService, Feedback, emptyfeedback} from "@/services/feedbacks/FeedbackService";
import {emptyUserProfileInfo, UserProfileInfo, userService} from "@/services/users/UserService";
import {TaskStudent, emptytaskstudent, taskService} from "@/services/tasks/TaskService";
import {Category} from "@/services/categories/CategoryService";
import {Component, Prop, Vue} from 'vue-property-decorator';
import TaskFeedbackList from "@/modules/tasks/components/TaskFeedbackList.vue";
import DatePicker from "@/components/DatePicker.vue";
import ProgressBar from "@/modules/tasks/components/ProgressBar.vue";
import DetailProgressBar from "@/modules/tasks/components/DetailProgressBar.vue";
import DifficultyRangeSelector from "@/components/DifficultyRangeSelector.vue";
import MentorFeedback from "@/modules/tasks/views/mentor/MentorFeedback.vue";
import DocentFeedback from "@/modules/tasks/views/docent/DocentFeedback.vue";


@Component({
    components: {
        NotFoundFrame,
        DocentFeedback,
        MentorFeedback,
        DifficultyRangeSelector,
        TaskFeedbackList,
        DatePicker,
        ProgressBar,
        DetailProgressBar
    }
})
export default class TaskDetailView extends Vue {
    private studentTask: TaskStudent = emptytaskstudent()
    private mentorFeedback: Feedback = emptyfeedback()
    private docentFeedback: Feedback = emptyfeedback()
    private categoryTask: string = ""
    private categoryList: Array<Category> = []
    private feedbacklist: Array<Feedback> = []
    private mentor: UserProfileInfo = emptyUserProfileInfo()
    private docent: UserProfileInfo = emptyUserProfileInfo()
    private count: number = 0
    private dataReady: boolean = false
    private role: string = ""


    @Prop() id: string | undefined

    async mounted() {
        await Promise.all([
            await this.getStudentInfo(),
        ]).then(() => {
            this.dataReady = true
        }).catch(() => {
            this.dataReady = false
        })
    }

    async getStudentInfo() {
        await feedbackService.getfeedbackstudent(this.id)
            .then((r) => {
                this.studentTask = r
            })
            .catch(() => {
                Vue.router.push('/404')
                this.launchErrorToast()
            })
            .finally(() => {
              this.getfeedbacks()
            })
    }

    async getfeedbacks() {
        //if(this.studentTask.stage != 0 || 1 || 2){
        await feedbackService.getfeedbacks(this.id)
            .then((r) => {
                this.feedbacklist = r
            })
            .catch(() => {
                Vue.router.push('/404')
                this.launchErrorToast()
            })
            .finally(() => {
              this.getDocent()
              this.getMentor()
            })
        //}
    }
    async deleteTask() {
        await taskService.TaskDelete(this.id)
            .then(()=> {
               this.launchDeleteToast()
                Vue.router.go(-1)
            })
            .catch(() => {
                Vue.router.push('/404')
                this.launchErrorToast()
            })
    }
    async getDocent(){
        await userService.getStudentDocent(this.studentTask.userId)
            .then((r) => {
              this.docent = r
            })
    }
    async getMentor(){
        await userService.getStudentMentor(this.studentTask.userId)
            .then((r) => {
              this.mentor = r
            })
    }

  launchErrorToast() {
    Vue.$toast.open({
      message: 'Something went wrong, try again!',
      type: 'error',
      position: 'bottom-right'
    })
  }
  launchDeleteToast() {
    Vue.$toast.open({
      message: 'Task is Deleted!',
      type: 'success',
      position: 'bottom-right'
    })
  }

    /*deletetask(){
      feedbackservice.TaskDelete(this.id)
    }*/


}
</script>

<style scoped lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
</style>