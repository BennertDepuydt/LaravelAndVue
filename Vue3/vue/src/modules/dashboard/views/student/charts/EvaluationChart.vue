<template>
    <div>
        <canvas id="line"/>
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
export default class EvaluationChart extends Vue {
    @Prop({ default: [] }) readonly data!: Array<Progress>
    @Prop({
        default: () => {
            return Chart.defaults.line
        }
    })


    readonly options: object | undefined

    private colors = ['#003f5c','#2f4b7c','#665191','#a05195','#d45087', '#f95d6a',
        '#ff7c43', '#ffa600']

    mounted() {
        this.createChart({
            datasets: [
                {
                    label: 'Evaluation',
                    data: this.data.map(x => x.evaluation),
                    backgroundColor: '#003f5c',
                    type: 'bar',
                    fill: false,
                    showLine: true,
                },
                {
                    label: 'Complexity',
                    data: this.data.map(x => x.complexity),
                    backgroundColor: '#d45087',
                    type: 'bar',
                    fill: false,
                    showLine: true,
                },
                {
                    label: 'Independency',
                    data: this.data.map(x => x.independency),
                    backgroundColor: '#ffa600',
                    type: 'bar',
                    fill: false,
                    showLine: true,
                },
            ],
            labels: this.data.map(x => x.date)
        })
    }

    createChart(chartData: object) {
        const canvas = document.getElementById('line') as HTMLCanvasElement
        const options = {
            type: 'bar',
            data: chartData,
            options: {
                legend: {
                    position: "top",
                    align: "start"
                },
                scales: {
                    xAxes: [{
                        time: {
                            displayFormats: {
                                quarter: 'MMM YYYY'
                            }
                        },
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        }
        new Chart(canvas, options)
    }
}
</script>

<style scoped>

</style>