<template>
    <div v-if="parseInt(value) < 3">
        <vue-slider
            class="p-0"
            v-model="value"
            :interval="1"
            :marks="true"
            :min="0"
            :max="5"
            :processStyle="{ backgroundColor: '#FFC1C1' }"
            :dotStyle="{ backgroundColor: '#F33737' }"
            :railStyle="{ backgroundColor: '#CCCCCC' }"
            :tooltipStyle="{ backgroundColor: '#F33737' }"
            :stepStyle="{ backgroundColor: '#F33737' }"
        ></vue-slider>
    </div>
      <div v-else-if="parseInt(value) < 4">
        <vue-slider
            class="p-0"
            v-model="value"
            :interval="1"
            :marks="true"
            :min="0"
            :max="5"
            :processStyle="{ backgroundColor: '#FFCF87' }"
            :dotStyle="{ backgroundColor: '#E99312' }"
            :railStyle="{ backgroundColor: '#CCCCCC' }"
            :tooltipStyle="{ backgroundColor: '#E99312' }"
            :stepStyle="{ backgroundColor: '#E99312' }"
        ></vue-slider>
    </div>
    <div v-else>
      <vue-slider
          class="p-0"
          v-model="value"
          :interval="1"
          :marks="true"
          :min="0"
          :max="5"
          :processStyle="{ backgroundColor: '#C1FFC8' }"
          :dotStyle="{ backgroundColor: '#42B86B' }"
          :railStyle="{ backgroundColor: '#CCCCCC' }"
          :tooltipStyle="{ backgroundColor: '#42B86B' }"
          :stepStyle="{ backgroundColor: '#42B86B' }"
      ></vue-slider>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';


@Component({
    components: {}
})

export default class DifficultyRangeSelector extends Vue {
    private value : number = 0

    @Prop() val : number | undefined

    mounted(){
      if(this.val != undefined){
        this.value = this.val
      }
    }
  
    @Watch('value', { immediate: true, deep: true })
    onSliderChange() {
      this.$emit('sliderChange', this.value)
    }
}
</script>

<style scoped lang="scss">
@import "src/styles/dashboard/DashboardLayout";
</style>