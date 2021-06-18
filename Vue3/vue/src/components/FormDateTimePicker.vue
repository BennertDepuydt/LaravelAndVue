<template>
    <div class="d-flex flex-row text-muted">
        <datetime v-model="selectedDate" input-class="datetimepicker-input-style text-muted"></datetime>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';


@Component({
    components: {}
})

export default class FormDateTimePicker extends Vue {
    private selectedDate: string | undefined = new Date().toISOString()

    @Prop() dateVal : string | undefined

    mounted(){
      if(this.dateVal != undefined){
        this.selectedDate = this.dateVal
      }
    }

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