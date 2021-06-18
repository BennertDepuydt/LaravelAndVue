<template>
    <b-card class="dashboard-small-card border-0"
            v-bind:class="{
        'CompletedTaskBackground': isCompleted,
        'ProgressTaskBackground': isProgress,
        'NotStartedTaskBackground': isNotStarted

    }" v-b-hover="cardHover">
        <div class="d-flex flex-row justify-content-between align-items-center mt-sm-1">
            <span v-bind:class="{'font-weight-bold': cardHoverCheck}" @click="$router.push(`tasks/${id}`)">{{
                    title
                }}</span>
            <div class="float-right">
              <b-link class="ml-3 p-1 text-muted" @click="$router.push(`tasks/${id}`)">
                <b-badge variant="secundary" v-if="this.stage===3">1</b-badge>
                <b-badge variant="secundary" v-else-if="this.stage===4">2</b-badge>
                <b-badge variant="secundary" v-else>0</b-badge>
                <font-awesome-icon icon="comment" size="lg"/>
              </b-link>
                <b-link class="ml-3 p-1 text-muted">
                  <font-awesome-icon @click="$router.push(`tasks/${id}`)" icon="eye" size="lg"/>
                </b-link>
                <slot name="buttons"/>
            </div>
        </div>
    </b-card>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {emptytaskstudent, taskService, TaskStudent} from "@/services/tasks/TaskService";
import {feedbackService} from "@/services/feedbacks/FeedbackService";

@Component({
    components: {}
})
export default class Task extends Vue {
    @Prop() id: string | undefined
    @Prop() title: string | undefined
    @Prop() stage: number | undefined
    //private studentTask : TaskStudent = emptytaskstudent()

    private isCompleted: boolean = false
    private isProgress: boolean = false
    private isNotStarted: boolean = false
    private isMentorChecked: boolean = false
    private isLecturerChecked: boolean = false
    private cardHoverCheck: boolean = false

    /*
    *
    *
        0 - not started
        1 - in progress
        2 - finished (mentor krijgt taak)
        3 - mentor heeft feedback gegeven (lectur krijgt taak)
        4 - lecturer heeft feedback gegeven
    *
    *
    * */

    mounted() {
        this.checkStage()
    }
    cardHover(isHovered: any) {
        this.cardHoverCheck = !!isHovered;
    }

    checkStage() {
        this.setStagesFalse()

        if (this.stage === 0) {
            this.isNotStarted = true
        }

        if (this.stage === 1) {
            this.isProgress = true
        }

        if (this.stage === 2) {
            this.isCompleted = true
        }

        if (this.stage === 3) {
            this.isCompleted = true
        }
        if (this.stage === 4) {
            this.isCompleted = true
        }
    }

    setStagesFalse() {
        this.isNotStarted = false
        this.isProgress = false
        this.isCompleted = false
        this.isMentorChecked = false
        this.isLecturerChecked = false
    }

    getPushStatus(): boolean {
        return this.isNotStarted && this.isProgress
    }

    /*async setTaskToProgress() {
        await feedbackService.getfeedbackstudent(this.id)
            .then((r) => {
                this.studentTask = r
            })
            .catch()
            .finally(() => {
                console.log(this.studentTask)
                taskService.SetStage(this.id, this.studentTask, 1)
            })
    }*/
}
</script>

<style scoped lang="scss">
@import "./src/styles/dashboard/DashboardLayout.scss";
</style>

