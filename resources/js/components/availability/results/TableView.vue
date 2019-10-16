<template>
    <div>
        <b-table :items="availability"></b-table>
    </div>
</template>

<script>
    export default {
        name: "TableView",

        props: {
            availability: {
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
