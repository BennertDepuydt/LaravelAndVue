<template>
    <div>
        <canvas id="pie2"/>
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
export default class SubjectChart extends Vue {
    @Prop({ default: [] }) readonly data!: Array<Progress>
    @Prop({
        default: () => {
            return Chart.defaults.pie
        }
    })


    readonly options: object | undefined

    private colors = ['#003f5c','#2f4b7c','#665191','#a05195','#d45087', '#f95d6a',
        '#ff7c43', '#ffa600']

    mounted() {
        this.createChart({
            datasets: [
                {
                    data: this.data.map(x => x.amount),
                    backgroundColor: this.colors
                }
            ],
            labels: this.data.map(x => x.subject)
        })
    }

    createChart(chartData: object) {
        const canvas = document.getElementById('pie2') as HTMLCanvasElement
        const options = {
            type: 'pie',
            data: chartData,
            options: {
                legend: {
                    position: "right",
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