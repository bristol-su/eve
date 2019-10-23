<template>
    <div>
        <link-events
        @event="appendEvent"></link-events>


        <current-events
            :events="tracking">

        </current-events>
    </div>
</template>

<script>
    import CurrentEvents from './events/CurrentEvents';
    import LinkEvents from './linkevent/LinkEvents';
    export default {
        name: "Codereadr",
        components: {LinkEvents, CurrentEvents},

        data() {
            return {
                tracking: []
            }
        },

        created() {
            this.loadEvents();
        },

        methods: {
            appendEvent(event) {
                this.tracking.push(event);
            },
            loadEvents() {
                this.$http.get('/api/uc_events/track')
                    .then(response => this.tracking = response.data)
                    .catch(error => alert('Could not find tracking events'));
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
