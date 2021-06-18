<template>
    <div class="w-100 text-center">
        <span class="text-muted align-middle">
            {{ title }}
            <b-spinner small style="margin-bottom: 1px"></b-spinner>
        </span>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';


@Component({
    components: {}
})

export default class LoadingFrame extends Vue {
    @Prop() title: string | undefined
}
</script>

<style scoped lang="scss">

</style>