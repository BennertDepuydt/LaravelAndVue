<template>

    <b-container class="p-0">
        <b-row class="p-0 pt-4">
            <b-col class="col-lg-12">
                <h5 class="border-bottom py-2 d-flex justify-content-between">
                    <span class="d-flex">
                      <span v-bind:class="{ 'font-weight-bold': notStartedSelect }" @click="showNotStarted()"
                            class="pl-1 tasks-title-selectable ">Not Started</span>
                    <span v-bind:class="{ 'font-weight-bold': inProgressSelect }" @click="showInProgress()"
                          class="d-flex justify-content-between pl-4 tasks-title-selectable  ">In Progress</span>
                    <span v-bind:class="{ 'font-weight-bold': completedSelect }" @click="showCompleted()"
                          class="d-flex justify-content-between pl-4 tasks-title-selectable  ">Completed</span>
                    </span>
                    <span class="d-flex">
                        <date-picker class="pl-4" @dateChanged="handleDateChangedTasks"/>
                        <b-link to="createtask"
                                class="pl-4 text-decoration-none text-muted">Add Task +</b-link>
                    </span>
                </h5>
            </b-col>
        </b-row>
        <b-row class="pt-4">
            <b-col cols="12">
                <template v-if="notStartedSelect">
                    <template v-if="notStartedTasks.length > 0">
                        <task-item v-for="task in notStartedTasks"
                                   :key="task.id"
                                   class="mb-2"
                                   :id="task.id"
                                   :stage="task.stage"
                                   :title="task.subject.name"
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
                                   :stage="task.stage"
                                   :title="task.subject.name"
                        />
                    </template>
                    <template v-else-if="tasksLoading">
                        <loading-frame title="Loading"/>
                    </template>
                    <template v-else>
                        <not-found-frame title="No tasks found"/>
                    </template>
                </template>

                <template v-if="inProgressSelect">
                    <template v-if="inProgressTasks.length > 0">
                        <task-item v-for="task in inProgressTasks"
                                   :key="task.id"
                                   class="mb-2"
                                   :id="task.id"
                                   :stage="task.stage"
                                   :title="task.subject.name"
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
            </b-col>
        </b-row>
    </b-container>
</template>
<script lang="ts">


import {Component, Prop, Vue} from 'vue-property-decorator';
import TaskItem from "@/modules/dashboard/components/Task.vue";
import MentorFeedback from "@/modules/tasks/views/mentor/MentorFeedback.vue";
import DocentFeedback from "@/modules/tasks/views/docent/DocentFeedback.vue";
import DatePicker from "@/components/DatePicker.vue";
import LoadingFrame from "@/components/LoadingFrame.vue";
import NotFoundFrame from "@/components/NotFoundFrame.vue";
import {taskService, Task, TaskStudent} from "@/services/tasks/TaskService";

@Component({
    components: {
        NotFoundFrame,
        LoadingFrame,
        TaskItem,
        DatePicker,
        MentorFeedback,
        DocentFeedback
    }
})
export default class MyTasksView extends Vue {
    private selectedTasksDate = Date.toString()
    private tasksLoading = false;

    private notStartedSelect = true;
    private completedSelect = false;
    private inProgressSelect = false;

    private notStartedTasks: Array<Task> = []
    private completedTasks: Array<Task> = []
    private inProgressTasks: Array<Task> = []

    private modal: boolean = false

    showMentor() {
        this.modal = true
    }

    async getDashboardTasks() {
        //if (!this.tasksLoading) {
            this.tasksLoading = true
            const userId = await this.$auth.fetch()
                .then(function (r: any) {
                    return r.data.id
                })
            await taskService.getStudentAllTasks(userId, this.selectedTasksDate)
                .then((r) => {
                    if (r !== null) {
                        this.notStartedTasks = r.filter(function (t) {
                                return t.stage === 0
                            }
                        )
                        this.completedTasks = r.filter(function (t) {
                                return t.stage === 2 || t.stage === 3 || t.stage === 4 || t.stage === 5
                            }
                        )
                        this.inProgressTasks = r.filter(function (t) {
                                return t.stage === 1
                            }
                        )
                    }
                })
                .catch((r) => this.launchErrorToast())
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

    handleDateChangedTasks(date: string) {
        this.selectedTasksDate = date;
        this.getDashboardTasks()
    }

    showNotStarted() {
        this.notStartedSelect = true;
        this.completedSelect = false;
        this.inProgressSelect = false;

    }

    showInProgress() {
        this.notStartedSelect = false;
        this.completedSelect = false;
        this.inProgressSelect = true;
    }

    showCompleted() {
        this.notStartedSelect = false;
        this.completedSelect = true;
        this.inProgressSelect = false;
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
@import "src/styles/tasks/TaskLayout";

</style>