<template>
    <b-row>
        <b-col cols="4">
            <b-form-group
                label="Date"
            >
                <b-row>
                    <b-form-input
                        required
                        type="date"
                        v-model="date"
                        v-on:click="dateCheck()"
                    ></b-form-input>
                </b-row>
            </b-form-group>
        </b-col>
        <b-col cols="3">
            <b-form-group
                label="Start"
            >
                <b-row>
                    <b-form-input
                        required
                        type="time"
                        v-model="starttime"
                        v-on:click="starttimeCheck()"
                    ></b-form-input>
                </b-row>
            </b-form-group>
        </b-col>
        <b-col cols="3">
            <b-form-group
                label="End"
            >
                <b-row>
                    <b-form-input
                        required
                        type="time"
                        v-model="endtime"
                        v-on:click="endtimeCheck()"
                    ></b-form-input>
                </b-row>
            </b-form-group>
        </b-col>
    </b-row>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';


@Component({
    components: {}
})


export default class Date extends Vue {
    private date: string = ''

}

</script>


<style scoped lang="scss">
@import "./src/styles/dashboard/DashboardLayout.scss";
</style>

