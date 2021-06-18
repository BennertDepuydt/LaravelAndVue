<template>
    <div>
        <canvas id="pie"/>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import Chart from "chart.js";
import {Progress} from "@/services/statistics/StatisticsService";

@Component({
    components: {

    }
})
export default class StageChart extends Vue {
    @Prop({ default: [] }) readonly data!: Array<Progress>
    @Prop({
        default: () => {
            return Chart.defaults.pie
        }
    })


    readonly options: object | undefined

    private colors = ['#003f5c','#2f4b7c','#665191','#a05195','#d45087', '#f95d6a',
        '#ff7c43', '#ffa600']

    private SelectedColors: Array<string> = []
    private stageStrings: Array<string> = []

    mounted() {
        this.processStages(this.data.map(x => x.stage))
        this.createChart({
            datasets: [
                {
                    data: this.data.map(x => x.amount),
                    backgroundColor: this.SelectedColors
                }
            ],
            labels: this.stageStrings
        })
    }

    processStages(stageNumbers: any) {
        this.stageStrings = []
        this.SelectedColors = []

        for (let i = 0; i < stageNumbers.length; i++) {
            let current = stageNumbers[i]
            if (current === 0) {
                this.stageStrings[i] = 'Not Started'
                this.SelectedColors[i] = '#FFC1C1'
            }
            if (current === 1) {
                this.stageStrings[i] = 'In Progress'
                this.SelectedColors[i] = '#FFD5BE'
            }
            if (current === 2) {
                this.stageStrings[i] = 'Completed'
                this.SelectedColors[i] = '#C1FFC8'
            }
            if (current === 3) {
                this.stageStrings[i] = 'Mentor Feedback'
                this.SelectedColors[i] = '#88FF95'
            }
            if (current === 4) {
                this.stageStrings[i] = 'Lecturer Feedback'
                this.SelectedColors[i] = '#46FF5B'
            }
        }
    }

    createChart(chartData: object) {
        const canvas = document.getElementById('pie') as HTMLCanvasElement
        const options = {
            type: 'pie',
            data: chartData,
            options: {
                legend: {
                    position: "left",
                    align: "start"
                }
            }
        }
        new Chart(canvas, options)
    }
}
</script>

<style scoped>

</style>