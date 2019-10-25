<template>
    <div>
        <b-table :items="events"></b-table>
    </div>
</template>

<script>
    export default {
        name: "TableView",

        props: {
            events: {
                type: Array,
                default: function() {
                    return [];
                }
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
