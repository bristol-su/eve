<template>
    <div>
        <b-table :items="events"></b-table>
    </div>
</template>

<script>
    export default {
        name: "CurrentEvents",

        props: {
            events: {
                type: Array,
                required: true
            }
        },

        data() {
            return {}
        },

        methods: {},

        computed: {}
    }
</script>

<style scoped>

</style>
