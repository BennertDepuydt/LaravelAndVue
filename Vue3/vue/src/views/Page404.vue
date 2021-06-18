<template>
    <b-container class="p-0">
        <b-row class="vertical-center">
            <b-col cols="4"/>
            <b-col cols="4">
                <b-img fluid width="350" :src="pic"></b-img>
                <div class="pt-4 w-100 text-center">
                    <h4 class="font-weight-bold">Nothing here!</h4>
                    <div>
                        <b-spinner small label="Small Spinner" class="text-primary" type="grow"></b-spinner>
                        <p class="pl-1">Wrong? Contact us: <a href="">problem@barometer.be</a></p>
                    </div>
                </div>
            </b-col>
            <b-col cols="4"/>
        </b-row>

    </b-container>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";

@Component({
    components: {
    }
})
export default class Page404 extends Vue {
    data() {
        return {
            pic: require('@/assets/404.svg')
        }
    }
}
</script>

<style lang="scss" scoped>
@import "src/styles/auth/AuthLayout";
.vertical-center {
    height: 100vh;
    align-items: center;
}
</style>