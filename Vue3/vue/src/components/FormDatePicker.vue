<template>
    <div class="d-flex flex-row text-muted">
        <datetime v-model="selectedDate" input-class="datetimepicker-input-style text-muted"></datetime>
        <font-awesome-icon class="datetimepicker-input-style" icon="calendar-day" style="margin-top: 3px"/>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';


@Component({
    components: {}
})

export default class DatePicker extends Vue {
    private selectedDate: string | undefined = new Date().toISOString()

    @Watch('selectedDate', { immediate: true, deep: true })
    onDateChange() {
        this.$emit('dateChanged', this.selectedDate)
    }

    /*
    * Add this to parent to receive changed date
    */
    /*handleDateChanged(date: string) {
        console.log(date)
    }*/
}
</script>
s
<style scoped lang="scss">

</style>