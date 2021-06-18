<template>
        <b-col cols="12">
          <b-row>
            <b-col class="pl-0">
              <h6 class="pb-2 border-bottom border-dark">Student</h6>
            </b-col>
          </b-row>
            <b-row class="mb-2">
                <small class="ml-1">Evaluation</small>
            </b-row>
            <b-row class="mb-1">
                <progress-bar :val="this.student.evaluation"></progress-bar>
            </b-row>
            <b-row class="mb-2">
                <small class="ml-1">Complexity</small>
            </b-row>
            <b-row class="mb-1">
                <progress-bar :val="this.student.complexity"></progress-bar>
            </b-row>
            <b-row class="mb-2">
                <small class="ml-1">Independence</small>
            </b-row>
            <b-row class="mb-2">
                <progress-bar :val="this.student.independency"></progress-bar>
            </b-row>
            <b-row class="mb-2">
              <small class="ml-1">Preference</small>
            </b-row>
            <b-row class="mb-2">
              <progress-bar :val="this.student.preference"></progress-bar>
            </b-row>
            <b-row class="mb-2">
              <span class="font-weight-bold">Remark</span>
            </b-row>
            <b-row class="mb-3">
              <b-col class="pl-0">
                <b-form-textarea
                    id="textarea-default"
                    v-model="this.student.comment"
                    plaintext
                    rows="5"
                    class="p-3"
                    style="border:solid 1px #CCCCCC"
                ></b-form-textarea>
              </b-col>
            </b-row>
            <b-row class="mb-2">
              <span class="font-weight-bold">Discription</span>
            </b-row>
            <b-row>
              <b-col class="pl-0">
                <b-form-textarea
                    id="textarea-default"
                    v-model="this.student.description"
                    plaintext
                    rows="5"
                    class="p-3"
                    style="border:solid 1px #CCCCCC"
                ></b-form-textarea>
              </b-col>
            </b-row>
        </b-col>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import DifficultyRangeSelector from "@/components/DifficultyRangeSelector.vue";
import ProgressBar from "@/modules/tasks/components/ProgressBar.vue";
import {feedbackService} from "@/services/feedbacks/FeedbackService";
import {TaskStudent, emptytaskstudent} from "@/services/tasks/TaskService";


@Component({
    components: {
        DifficultyRangeSelector,
        ProgressBar
    }
})
export default class StudentFeedback extends Vue {
  private remark: string = ""


  private student : TaskStudent = emptytaskstudent()

  @Prop() id : string | undefined

  mounted() {
    this.getstudentinfo()
  }
  async getstudentinfo() {
    await feedbackService.getfeedbackstudent(this.id)
        .then((r) => {
          this.student = r
        })
        .catch()
        .finally()
  }





}
</script>

<style scoped lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
</style>