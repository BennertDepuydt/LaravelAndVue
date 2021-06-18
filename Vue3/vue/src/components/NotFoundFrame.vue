<template>
    <div class="w-100 text-center">
        <span class="text-muted align-middle">
            {{ title }}
            <font-awesome-icon style="margin-bottom: 1px" class="text-muted" icon="exclamation-triangle"/>
        </span>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';


@Component({
    components: {}
})

export default class NotFoundFrame extends Vue {
    @Prop() title: string | undefined
}
</script>

<style scoped lang="scss">

</style>