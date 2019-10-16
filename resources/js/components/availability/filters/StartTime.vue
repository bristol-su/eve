<template>
    <div>
        <b-form-group
            label="Time From:"
            label-for="start-time"
            description="Start time of the event."
        >
            <b-form-input
                id="start-time"
                :value="value"
                @input="$emit('input', $event)"
                type="time"
            ></b-form-input>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "StartTime",

        props: {
            value: {
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
