<template>
    <div>
        <div>
            <jars-component v-if="this.$store.state.stage == 1"></jars-component>
        </div>
        <div>
            <jams-component v-if="this.$store.state.stage == 2"></jams-component>
        </div>
        <div>
            <result-component v-if="this.$store.state.stage == 3"></result-component>
        </div>
    </div>
</template>
<script>
    export default {
        name: "MainComponent",
        methods: {
            change: function () {
                this.$store.state.stage = 1;
            }
        }
    }
</script>
<style scoped>

</style>