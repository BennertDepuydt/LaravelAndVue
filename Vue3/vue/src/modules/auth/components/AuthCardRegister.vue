<template>
    <b-container>
        <b-card class="auth-card" shadow>
            <div class="h-100 d-flex flex-column justify-content-between">
                <div>
                    <h2 class="pb-4 d-flex flex-row justify-content-between">
                        <span class="pt-2">
                            Register
                        </span>
                        <b-img fluid width="100" :src="logo"></b-img>
                    </h2>
                    <slot name="form"/>
                </div>
            </div>
        </b-card>
    </b-container>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';

@Component({
    components: {}
})
export default class AuthCardRegister extends Vue {
    data() {
        return {
            logo: require('@/assets/BaroLogo.png')
        }
    }
}
</script>
s
<style scoped lang="scss">
@import "src/styles/auth/AuthLayout";
</style>
