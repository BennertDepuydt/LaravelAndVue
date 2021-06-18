<template>
    <b-container class="p-0">
        <b-row class="p-0">
            <b-col class="col-lg-6">
                <b-row class="pt-4">
                    <b-col cols="12">
                        <h5 class="border-bottom py-2 d-flex justify-content-between">
                            <span  class="pl-1 font-weight-bold">Students</span>
                            <loading-frame v-if="studentsLoading"/>
                        </h5>
                        <b-input-group class="mt-3">
                            <template #append>
                                <b-input-group-text>
                                    <font-awesome-icon icon="search"/>
                                </b-input-group-text>
                            </template>
                            <b-form-input autocomplete="off" v-model="studentSearchInput" placeholder="Search student"></b-form-input>
                        </b-input-group>
                    </b-col>
                </b-row>
                <b-row class="pt-4">
                    <b-col cols="12">
                        <template v-if="filteredStudents.length !== 0">
                            <student v-for="student in filteredStudents"
                                     :key="student.id"
                                     class="mb-2"
                                     :name="student.username"
                                     selected="true"
                                     @onStudentClick="handleStudentClick(student.id)"/>
                        </template>
                        <template v-else>
                            <not-found-frame title="No students found"/>
                        </template>
                    </b-col>
                </b-row>
            </b-col>
            <b-col class="col-lg-6">
                <b-row class="pt-4">
                    <b-col cols="12">
                        <h5 class="border-bottom py-2 d-flex justify-content-between">
                            <span  class="pl-1 font-weight-bold">Tasks</span>
                            <loading-frame v-if="tasksLoading"/>
                        </h5>
                        <b-row class="d-flex">
                            <b-col cols="2">
                                <span>Order By:</span>
                            </b-col>
                            <b-col cols="10">
                                <b-form-select class="mt-2" value=""></b-form-select>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
                <b-row class="pt-4">
                    <b-col cols="12" class="min-loading-height">
                        <template v-if="currentTasks.length !== 0">
                            <task-item v-for="task in currentTasks"
                                       class="mb-2"
                                       :key="task.id"
                                       :id="task.id"
                                       :title="task.subject.name"
                                       :stage="task.stage"
                            >
                                <template v-slot:buttons>
                                    <b-link class="ml-3 p-1" :disabled="tasksLoading" @click="updateStage(task)">
                                        <font-awesome-icon icon="thumbs-up"  size="lg"/>
                                    </b-link>
                                </template>
                            </task-item>
                        </template>

                        <template v-else>
                            <not-found-frame title="No tasks found"/>
                        </template>
                    </b-col>
                </b-row>
            </b-col>
        </b-row>
    </b-container>
</template>
<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator'
import TaskItem from "@/modules/dashboard/components/Task.vue";
import DatePicker from "@/components/DatePicker.vue";
import LoadingFrame from "@/components/LoadingFrame.vue";
import DifficultyRangeSelector from "@/components/DifficultyRangeSelector.vue";
import Student from "@/modules/dashboard/components/Student.vue";
import {userService, NameWithId} from "@/services/users/UserService";
import NotFoundFrame from "@/components/NotFoundFrame.vue";
import {taskService, Task, TaskStudent} from "@/services/tasks/TaskService";

@Component({
    components: {
        NotFoundFrame,
        Student,
        DifficultyRangeSelector,
        LoadingFrame,
        DatePicker,
        TaskItem
    }
})
export default class MentorDashboardView extends Vue {
    private currentTasks: Task[] = []
    private currentStudents: NameWithId[] = []
    private filteredStudents: NameWithId[] = []
    private studentSearchInput = ''

    private tasksLoading = false;
    private studentsLoading = false;

    mounted() {
        this.setMentorStudents()
    }

    handleStudentClick(id: string) {
        this.setStudentTasks(id)
    }

    @Watch('studentSearchInput')
    onStudentInputChange() {
        if (this.studentSearchInput !== '') {
            this.filteredStudents = this.currentStudents.filter(
                student => student.username.toLowerCase().startsWith(this.studentSearchInput.toLowerCase())
            )
        } else {
           this.filteredStudents = this.currentStudents
        }
    }

    async updateStage(task: TaskStudent) {
        this.tasksLoading = true
        await taskService.setStage(task, task.stage + 1)
            .then((r) => {
                this.launchSuccesToast()
                this.setStudentTasks(task.userId)
            })
            .catch((e) => {
                this.launchErrorToast()
            })
            .finally(() => {
                this.tasksLoading = false
            })
    }

    async setMentorStudents() {
        this.studentsLoading = true;
        const userId = await this.$auth.fetch()
            .then(function(r: any) {
                return r.data.id
            })

        await userService.getMentorStudents(userId)
            .then((r) => {
                this.currentStudents = r
                this.filteredStudents = r
            })
        .finally(() => this.studentsLoading = false)
    }

    async setStudentTasks(studentId: string) {
        this.tasksLoading = true;
        await taskService.getStudentTasksForMentor(studentId)
            .then((r) => {
                this.currentTasks = r
            })
            .finally(() => this.tasksLoading = false)
    }

    launchErrorToast() {
        Vue.$toast.open({
            message: 'Something went wrong, try again!',
            type: 'error',
            position: 'top'
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