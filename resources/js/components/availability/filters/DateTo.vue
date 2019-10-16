<template>
    <div>
        <b-form-group
            label="Date To:"
            label-for="date-to"
            description="Date to search until."
        >
            <b-form-input
                id="date-to"
                :value="value"
                @input="$emit('input', $event)"
                type="date"
                required
            ></b-form-input>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "DateTo",

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
