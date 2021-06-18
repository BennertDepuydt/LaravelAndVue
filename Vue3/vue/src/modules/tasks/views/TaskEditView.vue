<template>
    <b-container class="p-0" v-if="dataReady">
        <b-row class="p-0 pt-4">
            <b-col class="col-lg-12">
                <h5 class="border-bottom py-2 d-flex">
                    <span class="pl-1 font-weight-bold">Edit Task</span>
                </h5>
            </b-col>
        </b-row>
        <b-form>
            <b-row class="pt-4">
                <b-col cols="6">
                    <b-form-group
                        label="Category"
                        label-for="input-1"

                    >
                        <b-form-select v-model="studentCategory" v-on:change="handleSelected()">
                            <b-select-option v-for="cat in categoryList" :key="cat.id" :value="cat.id">
                                {{ cat.name }}
                            </b-select-option>
                        </b-form-select>
                    </b-form-group>
                    <div class="w-100 d-flex flex-row pt-2">
                        <b-form-group
                            label="Start day"
                        >
                            <form-date-time-picker :dateVal="this.studentDateStart"
                                                   @dateChanged="handleDateChangedStart"/>
                        </b-form-group>
                        <b-form-group
                            label="End day"
                            class="pl-5"
                        >
                            <form-date-time-picker :dateVal="this.studentDateEnd" @dateChanged="handleDateChangedEnd"/>
                        </b-form-group>
                    </div>
                </b-col>
                <b-col cols="6">
                    <b-row class="pb-4 pt-2">
                        <b-col cols="12">
                            <small class="ml-1">Difficulty</small>
                            <difficulty-range-selector :val.once=this.studentDifficulty
                                                       @sliderChange="handleDifficultySlider"></difficulty-range-selector>
                        </b-col>
                    </b-row>
                    <b-row class="pb-4">
                        <b-col cols="12">
                            <small class="ml-1">Complexity</small>
                            <difficulty-range-selector :val.once=this.studentComplexity
                                                       @sliderChange="handleComplexitySlider"></difficulty-range-selector>
                        </b-col>
                    </b-row>
                    <b-row class="pb-4">
                        <b-col cols="12">
                            <small class="ml-1">Independence</small>
                            <difficulty-range-selector :val.once=this.studentIndependence
                                                       @sliderChange="handleIndependenceSlider"></difficulty-range-selector>
                        </b-col>
                    </b-row>
                    <b-row class="pb-4">
                        <b-col cols="12">
                            <small class="ml-1">Preference</small>
                            <difficulty-range-selector :val.once=this.studentPreference
                                                       @sliderChange="handlePreferenceSlider"></difficulty-range-selector>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <b-row class="pt-4">
                <b-col cols="6">
                    <b-form-group
                        label="Description"
                    >
                        <b-form-textarea
                            v-on:click="descriptionCheck()"
                            placeholder="Type here.."
                            v-model="studentDescription"
                            :state="this.descriptionValid"
                            rows="6"
                            max-rows="6"
                        ></b-form-textarea>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group
                        label="Remark"
                    >
                        <b-form-textarea
                            v-on:click="remarkCheck()"
                            placeholder="Type here.."
                            v-model="studentRemark"
                            :state="this.remarkValid"
                            rows="6"
                            max-rows="6"
                        ></b-form-textarea>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-form>
        <b-button type="submit" :disabled="editLoading" class="mt-5 float-right" @click="edittask()" variant="light">
            <template v-if="editLoading">
                <b-spinner small label="Small Spinner"></b-spinner>
            </template>
            Edit
        </b-button>
    </b-container>
</template>
<script lang="ts">


import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import {feedbackService, Feedback, emptyfeedback} from "@/services/feedbacks/FeedbackService";
import {TaskStudent, emptytaskstudent} from "@/services/tasks/TaskService";
import {Category, categoryService} from "@/services/categories/CategoryService";
import {taskService} from "@/services/tasks/TaskService";
import Date from "@/modules/tasks/components/Date.vue";
import DifficultyRangeSelector from "@/components/DifficultyRangeSelector.vue";
import DatePicker from "@/components/DatePicker.vue";
import FormDateTimePicker from "@/components/FormDateTimePicker.vue";

@Component({
    components: {
        FormDateTimePicker,
        DatePicker,
        Date,
        DifficultyRangeSelector,
    }
})

export default class TaskEditView extends Vue {
    private studentTask: TaskStudent = emptytaskstudent()
    private categoryList: Array<Category> = []
    private studentRemark: string = ""
    private studentDescription: string = ""
    private studentDifficulty: number = 0
    private studentIndependence: number = 0
    private studentComplexity: number = 0
    private studentCategory: string = ""
    private studentDateStart: string = ""
    private studentPreference: number = 0
    private studentDateEnd: string = ""

    private categoryValid: boolean | null = null
    private descriptionValid: boolean | null = null
    private remarkValid: boolean | null = null
    private dataReady: boolean = false
    private dateValid: boolean | null = null
    private editLoading: boolean = false


    @Prop() id: string | undefined


    async mounted() {
        await this.getCategoryList()
        await this.getStudentInfo()
        this.dataReady = true
    }

    async getCategoryList() {

        const eduId = await this.$auth.fetch()
            .then(function (r) {
                return r.data.eduId
            })

        await categoryService.getCategoryList(eduId)
            .then((r) => this.categoryList = r)
            .catch()
            .finally(() => {
            })
    }

    async getStudentInfo() {
        await feedbackService.getfeedbackstudent(this.id)
            .then((r) => {
                this.studentTask = r
            })
            .catch()
            .finally(() => {
                this.studentRemark = this.studentTask.comment
                this.studentDescription = this.studentTask.description
                this.studentCategory = this.studentTask.subject.id
                this.studentIndependence = this.studentTask.independency
                this.studentDateStart = this.studentTask.startedAt
                this.studentDateEnd = this.studentTask.endedAt
                this.studentComplexity = this.studentTask.complexity
                this.studentDifficulty = this.studentTask.evaluation
                this.studentPreference = this.studentTask.preference
            })
    }

    handleDifficultySlider(difficulty: number) {
        this.studentDifficulty = difficulty
    }

    handleIndependenceSlider(independence: number) {
        this.studentIndependence = independence
    }

    handleComplexitySlider(complexity: number) {
        this.studentComplexity = complexity
    }

    handlePreferenceSlider(preference: number) {
        this.studentPreference = preference
    }

    handleDateChangedStart(date: string) {
        this.studentDateStart = date
    }

    handleDateChangedEnd(date: string) {
        this.studentDateEnd = date
    }

    handleSelected() {
        this.categoryValid = false
        this.categoryList.forEach(element => {
            if (element.id == this.studentCategory) {
                this.categoryValid = true
            }
        })
    }

    /*checkDates() {
        this.dateValid = this.studentDateEnd.substring(0, 19) !== this.studentDateStart.substring(0, 19)
    }*/

    validation(): boolean {
        return (!isNaN(this.studentDifficulty) || !isNaN(this.studentIndependence) || !isNaN(this.studentComplexity));
    }

    @Watch('studentRemark')
    remarkCheck() {
        this.remarkValid = this.studentRemark !== ''
    }

    @Watch('studentDescription')
    descriptionCheck() {
        this.descriptionValid = this.studentDescription !== ''
    }


    async edittask() {
        this.editLoading = true
        this.handleSelected()
        this.descriptionCheck()
        this.remarkCheck()
        //this.checkDates()
        if ((this.validation() && this.descriptionValid && this.remarkValid && this.categoryValid) == true) {
            this.studentTask.comment = this.studentRemark
            this.studentTask.description = this.studentDescription
            this.studentTask.subject.id = this.studentCategory
            this.studentTask.independency = this.studentIndependence
            this.studentTask.startedAt = this.studentDateStart
            this.studentTask.endedAt = this.studentDateEnd
            this.studentTask.complexity = this.studentComplexity
            this.studentTask.evaluation = this.studentDifficulty
            this.studentTask.preference = this.studentPreference
            await taskService.TaskEdit(this.id, this.studentTask)
                .then(function (r: any) {
                    Vue.router.go(-1)
                })
                .catch(() => {
                    Vue.router.push('/404')
                  this.launchErrorToast()
                })
            .finally(() => {
              Vue.router.push(`tasks/${this.studentTask.id}`)
              this.launchEditToast()
              this.editLoading = false

            })
        }
        else {
          if(this.descriptionValid == false){
            Vue.$toast.open({
              message: 'Description can\'t be empty!',
              type: 'error',
              position: 'bottom-right'
            })
          }
          if(this.remarkValid == false){
            Vue.$toast.open({
              message: 'Remark can\'t be empty!',
              type: 'error',
              position: 'bottom-right'
            })
          }
          if(this.categoryValid == false){
            Vue.$toast.open({
              message: 'Category not selected!',
              type: 'error',
              position: 'bottom-right'
            })
          }
          this.editLoading = false;
        }
    }
  launchErrorToast() {
    Vue.$toast.open({
      message: 'Something went wrong, try again!',
      type: 'error',
      position: 'bottom-right'
    })
  }

  launchEditToast() {
    Vue.$toast.open({
      message: 'Task is Edited!',
      type: 'success',
      position: 'bottom-right'
    })
  }




}
</script>
<style scoped lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
</style>