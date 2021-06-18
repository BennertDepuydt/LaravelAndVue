<template>
    <b-container class="p-0">
        <b-row class="p-0">
            <b-col class="col-lg-6">
                <b-row class="pt-4">
                    <b-col cols="12">
                        <h5 class="border-bottom py-2 d-flex justify-content-between">
                            <span class="pl-1 font-weight-bold">My Progress</span>
                            <loading-frame v-if="progressLoading"/>
                            <date-picker @dateChanged="handleDateChangedProgress"/>
                        </h5>
                    </b-col>
                </b-row>
                <b-row class="pt-4">
                    <b-col cols="12">
                        <statistics-view :date="selectedProgressDate"/>
                    </b-col>
                </b-row>
            </b-col>
            <b-col class="col-lg-6">
                <b-row class="pt-4">
                    <b-col cols="12">
                        <h5 class="border-bottom py-2 d-flex justify-content-between">
                            <span>
                                <span @click="showNotStarted()"
                                      class="dashboard-title-selectable pl-1"
                                      v-bind:class="{ 'font-weight-bold': notStartedSelect }">
                                    Not started
                                </span>
                                <span @click="showCompleted()"
                                      class="dashboard-title-selectable pl-4"
                                      v-bind:class="{ 'font-weight-bold': completedSelect }">
                                    Completed
                                </span>
                            </span>
                            <date-picker @dateChanged="handleDateChangedTasks"/>
                        </h5>
                    </b-col>
                </b-row>
                <b-row class="pt-4">
                    <b-col cols="12" class="min-loading-height">
                        <template v-if="notStartedSelect">
                            <template v-if="notStartedTasks.length > 0">
                                <task-item v-for="task in notStartedTasks"
                                           :key="task.id"
                                           class="mb-2"
                                           :id="task.id"
                                           :title="task.subject.name"
                                           :stage="task.stage"
                                >
                                    <template v-slot:buttons>
                                        <b-link class="ml-3 p-1" :disabled="tasksLoading" @click="updateStage(task)">
                                            <font-awesome-icon icon="arrow-up" size="lg"/>
                                        </b-link>
                                    </template>
                                </task-item>
                            </template>
                            <template v-else-if="tasksLoading">
                                <loading-frame title="Loading"/>
                            </template>
                            <template v-else>
                                <not-found-frame title="No tasks found"/>
                            </template>
                        </template>

                        <template v-if="completedSelect">
                            <template v-if="completedTasks.length > 0">
                                <task-item v-for="task in completedTasks"
                                           :key="task.id"
                                           class="mb-2"
                                           :id="task.id"
                                           :title="task.subject.name"
                                           :stage="task.stage"
                                />
                            </template>
                            <template v-else-if="tasksLoading">
                                <loading-frame title="Loading"/>
                            </template>
                            <template v-else>
                                <not-found-frame title="No tasks found"/>
                            </template>
                        </template>
                    </b-col>
                </b-row>
            </b-col>
        </b-row>
    </b-container>
</template>
<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator'
import TaskItem from "@/modules/dashboard/components/Task.vue";
import Chart from "@/modules/dashboard/components/Chart.vue";
import DatePicker from "@/components/DatePicker.vue";
import {taskService, Task, TaskStudent} from "@/services/tasks/TaskService";
import LoadingFrame from "@/components/LoadingFrame.vue";
import DifficultyRangeSelector from "@/components/DifficultyRangeSelector.vue";
import NotFoundFrame from "@/components/NotFoundFrame.vue";
import StatisticsView from "@/modules/dashboard/views/student/StatisticsView.vue";

@Component({
    components: {
        StatisticsView,
        NotFoundFrame,
        DifficultyRangeSelector,
        LoadingFrame,
        DatePicker,
        TaskItem,
        Chart
    }
})
export default class StudentDashboardView extends Vue {
    private selectedProgressDate = Date.toString()
    private selectedTasksDate = Date.toString()

    private notStartedTasks: Array<Task> = []
    private completedTasks: Array<Task> = []

    private notStartedSelect = true
    private completedSelect = false

    private tasksLoading = false
    private progressLoading = false

    async getDashboardTasks() {
        //if (!this.tasksLoading) {
        this.tasksLoading = true

        const userId = await this.$auth.fetch()
            .then(function (r: any) {
                return r.data.id
            })


        await taskService.getStudentAllTasks(userId, this.selectedTasksDate)
            .then((r: any) => {
                if (r !== null) {
                    this.notStartedTasks = r.filter(function (t: any) {
                            return t.stage === 0
                        }
                    )
                    this.completedTasks = r.filter(function (t: any) {
                            return t.stage === 2 || t.stage === 3 || t.stage === 4 || t.stage === 5
                        }
                    )
                }
            })
            .catch((e: string) => this.launchErrorToast())
            .finally(() => {
                this.tasksLoading = false
            })
        //}
    }

    async updateStage(task: TaskStudent) {
        this.tasksLoading = true
        await taskService.setStage(task, task.stage + 1)
            .then((r) => {
                this.launchSuccesToast()
                this.getDashboardTasks()
            })
            .catch((e) => {
                this.launchErrorToast()
            })
            .finally(() => {
                this.tasksLoading = false
            })
    }

    showNotStarted() {
        this.notStartedSelect = true
        this.completedSelect = false
    }

    showCompleted() {
        this.notStartedSelect = false
        this.completedSelect = true
    }

    handleDateChangedProgress(date: string) {
        this.selectedProgressDate = date;
    }

    handleDateChangedTasks(date: string) {
        this.selectedTasksDate = date;
        this.getDashboardTasks()
    }

    launchErrorToast() {
        Vue.$toast.open({
            message: 'Something went wrong, try again!',
            type: 'error',
            position: 'bottom-right'
        })
    }

    launchSuccesToast() {
        Vue.$toast.open({
            message: 'Update success!',
            type: 'success',
            position: 'bottom-right'
        })
    }
}


</script>

<style scoped lang="scss">
@import "src/styles/dashboard/DashboardLayout";
</style>
