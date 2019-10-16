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
        props: {
            tracking: {
                type: Array,
                default: function() {
                    return [];
                }
            }
        },

        data() {
            return {}
        },

        methods: {
            appendEvent(event) {
                this.tracking.push(event);
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
