<template>
    <b-container class="p-0">
        <b-row class="vertical-center">
            <b-col cols="4"/>
            <b-col cols="4">
                <b-img fluid width="350" :src="pic"></b-img>
                <div class="pt-4 w-100 text-center">
                    <h4 class="font-weight-bold">Server down!</h4>
                    <p>We currently have some issues behind the scenes</p>
                    <div>
                        <b-spinner small label="Small Spinner" class="text-primary" type="grow"></b-spinner>
                        <p class="pl-1"><a href="" @click="$router.push('/auth/login')">Try again</a> in 10 minutes.</p>
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
export default class ServerError extends Vue {
    data() {
        return {
            pic: require('@/assets/ServerDown.svg')
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