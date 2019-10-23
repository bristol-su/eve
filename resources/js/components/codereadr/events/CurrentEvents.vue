<template>
    <div>
        <b-table :items="events" :fields="fields"></b-table>
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
            return {
                fields: [
                    {key: 'id', label: 'Event ID', sortable: true},
                    {key: 'name', label: 'Name', sortable: true},
                    {key: 'start_date_time', label: 'Start Date', sortable: true},
                    {key: 'ticket_sold_count', label: 'Tickets Sold', sortable: true},
                    {key: 'ticket_redeem_count', label: 'Tickets Redeemed', sortable: true}
                ]
            }
        },

        methods: {

        },

        computed: {}
    }
</script>

<style scoped>

</style>
