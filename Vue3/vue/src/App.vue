<template>
    <div id="app">
        <div v-if="$auth.ready()">
            <router-view/>
        </div>
        <div v-if="!$auth.ready()">
            Loading..
        </div>
    </div>
</template>

<style lang="scss">
#app {
    width: 100vw;
    height: 100vh;
}

@import "./src/styles/common.scss";
</style>
