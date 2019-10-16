<template>
    <div>
        <b-form-group
            label="Date From:"
            label-for="date-from"
            description="Date to search from."
        >
            <b-form-input
                id="date-from"
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
        name: "DateFrom",

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
