<template>
    <div>
        <b-form-group
            label="Time Until:"
            label-for="end-time"
            description="End time of the event."
        >
            <b-form-input
                id="end-time"
                :value="value"
                @input="$emit('input', $event)"
                type="time"
            ></b-form-input>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "EndTime",

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
