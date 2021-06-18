<template>
    <div class="w-100 h-100">
        <b-card class="w-100 border-0 mb-1" style="height: 70px;">
            <div class="d-flex flex-row justify-content-between pt-1">
                <div class="d-flex flex-row justify-content-start">
                    <b-link class="text-decoration-none pr-3" @click="handleClick(1)">
                        Stages
                    </b-link>
                    <b-link class="text-decoration-none pr-3" @click="handleClick(2)">
                        Subjects
                    </b-link>
                    <b-link class="text-decoration-none pr-3" @click="handleClick(3)">
                        Evaluation
                    </b-link>
                </div>
                <div>
                    <b-link class="text-muted text-decoration-none" @click="refreshClicked()">
                        Refresh
                        <font-awesome-icon icon="sync-alt"/>
                    </b-link>
                </div>
            </div>
        </b-card>
        <b-overlay
            :show="isLoading"
            spinner-variant="secondary"
            style="overflow: hidden"
            variant="white"
        >
            <b-card class="h-100 border-0">
                <div v-if="ProgressTab">
                    <div v-if="progressData.length > 0">
                        <stage-chart
                            v-if="!isLoading"
                            :data="progressData"
                        />
                    </div>
                    <div v-else>
                        <not-found-frame title="We have no data to process"/>
                    </div>
                </div>
                <div v-if="SubjectTab">
                    <div v-if="subjectData.length > 0">
                        <subject-chart
                            v-if="!isLoading"
                            :data="subjectData"
                        />
                    </div>
                    <div v-else>
                        <not-found-frame title="We have no data to process"/>
                    </div>
                </div>
                <div v-if="EvaluationTab">
                    <div v-if="subjectData.length > 0">
                        <evaluation-chart
                            v-if="!isLoading"
                            :data="evaluationData"
                        />
                    </div>
                    <div v-else>
                        <not-found-frame title="We have no data to process"/>
                    </div>
                </div>
            </b-card>
        </b-overlay>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import StageChart from "@/modules/dashboard/views/student/charts/StageChart.vue";
import {Evaluation, Progress, statisticsService, Subject} from "@/services/statistics/StatisticsService";
import NotFoundFrame from "@/components/NotFoundFrame.vue";
import SubjectChart from "@/modules/dashboard/views/student/charts/SubjectChart.vue";
import EvaluationChart from "@/modules/dashboard/views/student/charts/EvaluationChart.vue";

@Component({
    components: {
        EvaluationChart,
        SubjectChart,
        NotFoundFrame,
        StageChart
    }
})
export default class StatisticsView extends Vue {
    @Prop({required: true}) date: string

    private isLoading: boolean = false


    private progressData: Progress[] = []
    private subjectData: Subject[] = []
    private evaluationData: Evaluation[] = []

    private ProgressTab: boolean = false
    private SubjectTab: boolean = false
    private EvaluationTab: boolean = false

    private currentTab: number = 1

    get currentSelectedDate() {
        let currentDate = this.date
        return currentDate
    }

    mounted() {
        this.getProgressData()
        this.handleClick(1)
    }

    @Watch('date')
    dateChanged() {
        this.refreshClicked()
    }

    async getProgressData() {
        this.isLoading = true
        const userId = await this.$auth.fetch()
            .then(function (r: any) {
                return r.data.id
            })

        await statisticsService.getProgress(userId, this.currentSelectedDate)
            .then((r) => {
                if (r !== null) {
                    this.progressData = r
                }
            })
            .catch((r) => {

            })
            .finally(() => {
                this.isLoading = false
            })
    }

    async getSubjectData() {
        this.isLoading = true
        const userId = await this.$auth.fetch()
            .then(function (r: any) {
                return r.data.id
            })

        await statisticsService.getSubject(userId, this.currentSelectedDate)
            .then((r) => {
                if (r !== null) {
                    this.subjectData = r
                }
            })
            .catch((r) => {

            })
            .finally(() => {
                this.isLoading = false
            })
    }

    async getEvaluationData() {
        this.isLoading = true
        const userId = await this.$auth.fetch()
            .then(function (r: any) {
                return r.data.id
            })

        await statisticsService.getEvaluationByStudent(userId)
            .then((r) => {
                if (r !== null) {
                    this.evaluationData = r
                }
            })
            .catch((r) => {

            })
            .finally(() => {
                this.isLoading = false
            })
    }

    refreshClicked() {
        if (this.currentTab === 1) {
            this.getProgressData()
        }

        if (this.currentTab === 2) {
            this.getSubjectData()
        }

        if (this.currentTab === 3) {
            this.getEvaluationData()
        }
    }


    handleClick(clicked: number) {
        if (clicked === 1) {
            this.ProgressTab = true;
            this.SubjectTab = false;
            this.EvaluationTab = false;
            this.currentTab = 1
            this.refreshClicked()
        }

        if (clicked === 2) {
            this.ProgressTab = false;
            this.SubjectTab = true;
            this.EvaluationTab = false;
            this.currentTab = 2
            this.refreshClicked()
        }

        if (clicked === 3) {
            this.ProgressTab = false;
            this.SubjectTab = false;
            this.EvaluationTab = true;
            this.currentTab = 3
            this.refreshClicked()
        }
    }
}
</script>

<style scoped lang="scss">
@import "./src/styles/dashboard/DashboardLayout.scss";
</style>
