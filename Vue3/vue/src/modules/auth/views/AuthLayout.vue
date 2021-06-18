<template>
    <div class="general-page">
        <router-view/>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';

@Component({
    components: {}
})
export default class AuthLayout extends Vue {
}
</script>

<style scoped lang="scss">

</style>
