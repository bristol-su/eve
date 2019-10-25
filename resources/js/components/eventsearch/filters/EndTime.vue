<template>
    <div>
        <b-form-group
            label="Time Until:"
            label-for="end-time"
            description="End time of the event."
        >
            <b-form-input
                id="end-time-hour"
                :value="hour"
                @input="$emit('hour', $event)"
                type="number"
            ></b-form-input>
            <b-form-input
                id="end-time-minute"
                :value="minute"
                @input="$emit('minute', $event)"
                type="number"
            ></b-form-input>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "EndTime",

        props: {
            hour: {
                required: true,
                default: null
            },
            minute: {
                required: true,
                default: null
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
