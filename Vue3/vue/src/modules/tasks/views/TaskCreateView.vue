<template>
  <b-overlay
      :show="!this.dataReady"
      spinner-variant="secondary"
      style="overflow: hidden"
      variant="white"
  >
    <b-container class="p-0">
        <b-row class="p-0 pt-4">
            <b-col class="col-lg-12">
                <h5 class="border-bottom py-2 d-flex">
                    <span class="pl-1 font-weight-bold">Create Task</span>
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
                            <form-date-time-picker @dateChanged="handleDateChangedStart"/>
                        </b-form-group>
                        <b-form-group
                            label="End day"
                            class="pl-5"
                        >
                            <form-date-time-picker @dateChanged="handleDateChangedEnd"/>
                        </b-form-group>
                    </div>
                </b-col>
                <b-col cols="6">

                    <b-row class="pb-4 pt-2">
                        <b-col cols="12">
                            <small class="ml-1">Difficulty</small>
                            <difficulty-range-selector
                                @sliderChange="handleDifficultySlider"></difficulty-range-selector>
                        </b-col>
                    </b-row>
                    <b-row class="pb-4">
                        <b-col cols="12">
                            <small class="ml-1">Complexity</small>
                            <difficulty-range-selector
                                @sliderChange="handleComplexitySlider"></difficulty-range-selector>
                        </b-col>
                    </b-row>
                    <b-row class="pb-4">
                        <b-col cols="12">
                            <small class="ml-1">Independence</small>
                            <difficulty-range-selector
                                @sliderChange="handleIndependenceSlider"></difficulty-range-selector>
                        </b-col>
                    </b-row>
                    <b-row class="pb-4">
                        <b-col cols="12">
                            <small class="ml-1">Preference</small>
                            <difficulty-range-selector
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
                            rows="6"
                            :state="this.descriptionValid"
                            max-rows="6"
                        ></b-form-textarea>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
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
        <b-button type="submit" :disabled="createLoading" class="mt-2 float-right" @click="createTask()" variant="light">
            <template v-if="createLoading">
                <b-spinner small label="Small Spinner"></b-spinner>
            </template>
            Create
        </b-button>
    </b-container>
  </b-overlay>
</template>
<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import Date from "@/modules/tasks/components/Date.vue";
import DifficultyRangeSelector from "@/components/DifficultyRangeSelector.vue";
import DatePicker from "@/components/DatePicker.vue";
import FormDateTimePicker from "@/components/FormDateTimePicker.vue";
import {Category, categoryService} from "@/services/categories/CategoryService";
import {taskService} from "@/services/tasks/TaskService";


@Component({
    components: {
        FormDateTimePicker,
        DatePicker,
        Date,
        DifficultyRangeSelector,
    }
})

export default class TaskCreateView extends Vue {
    @Prop() value: string | undefined

    private categoryList: Array<Category> = []
    private studentRemark: string = ""
    private studentDescription: string = ""
    private studentDifficulty: number = 0
    private studentIndependence: number = 0
    private studentComplexity: number = 0
    private studentCategory: string = ""
    private studentPreference: number = 0
    private studentDateStart: string = ""
    private studentDateEnd: string = ""

    private categoryValid: boolean | null = null
    private descriptionValid: boolean | null = null
    private remarkValid: boolean | null = null
    private dateValid: boolean | null = null

    private createLoading: boolean = false
    private dataReady: boolean = false


    private errors: Array<string> = []

    async mounted() {
      await Promise.all([
        await this.getCategoryList()
      ]).then(() => {
        this.dataReady = true
      }).catch(() => {
        this.dataReady = false
      })
    }

    async getCategoryList() {

        const eduId = await this.$auth.fetch()
            .then(function (r: any) {
                return r.data.eduId
            })
        await categoryService.getCategoryList(eduId)
            .then((r) => this.categoryList = r)
            .catch()
            .finally(() => {
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

    @Watch('studentDateStart')
    handleDateChangedStart(date: string) {
        this.studentDateStart = date
    }

    @Watch('studentDateEnd')
    handleDateChangedEnd(date: string) {
        this.studentDateEnd = date
    }

    @Watch('categoryValid')
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
        return (!isNaN(this.studentDifficulty) || !isNaN(this.studentIndependence) || !isNaN(this.studentComplexity) || !isNaN(this.studentPreference));
    }

    @Watch('studentRemark')
    remarkCheck() {
        this.remarkValid = this.studentRemark !== ''
    }

    @Watch('studentDescription')
    descriptionCheck() {
        this.descriptionValid = this.studentDescription !== ''
    }

    async createTask() {
        //this.checkDates()

        this.createLoading = true

        const userid = await this.$auth.fetch()
            .then(function (r: any) {
                return r.data.id
            })
        if ((this.validation() && this.descriptionValid && this.remarkValid && this.categoryValid) == true) {
            await taskService.postTasks(this.studentDifficulty, this.studentComplexity,
                this.studentIndependence, this.studentPreference, this.studentDescription, this.studentRemark, this.studentDateStart, this.studentDateEnd, this.studentCategory, userid)
                .then((r) => {
                    Vue.router.push('/student/mytasks')
                })
                .catch(() => {
                    Vue.router.push('/404')
                    this.launchErrorToast()
                })
            .finally(() => {
                this.createLoading = false
                this.launchCreatedToast()
            })
        }
        else {
          this.handleSelected()
          this.descriptionCheck()
          this.remarkCheck()
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
          this.createLoading = false
        }
    }
  launchErrorToast() {
    Vue.$toast.open({
      message: 'Something went wrong, try again!',
      type: 'error',
      position: 'bottom-right'
    })
  }
  launchCreatedToast() {
    Vue.$toast.open({
      message: 'Task is Created!',
      type: 'success',
      position: 'bottom-right'
    })
  }
}
</script>
<style scoped lang="scss">
@import "./src/styles/tasks/TaskLayout.scss";
</style>