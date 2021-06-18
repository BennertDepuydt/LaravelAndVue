<template>
    <b-card class="dashboard-small-card border-0"
            v-bind:class="{ 'selectedBorder': selectedValue}"
            @click="studentClicked(id)">
        <div class="d-flex flex-row justify-content-between mt-sm-1">
            <span>{{ name }}</span>
            <span>
                <font-awesome-icon class="text-muted" icon="chevron-right"/>
            </span>
        </div>
    </b-card>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';

@Component({
    components: {}
})
export default class Student extends Vue {
    @Prop() id: string | undefined
    @Prop() name: string | undefined
    @Prop() selected: boolean | undefined

    studentClicked(id: string) {
        this.$emit('onStudentClick', id)
    }

    get selectedValue(): boolean {
        if (this.selected !== undefined) {
            return this.selected
        } else return false
    }
}
</script>

<style scoped lang="scss">
@import "./src/styles/dashboard/DashboardLayout.scss";

.selectedBorder {
    border: 1px solid #FFC1C1 !important;
    border-radius: 4px !important;
}
</style>

