<template>
    <div>
        <b-form-input
            type="text"
            @input="$emit('input', $event)"
            :value="value"
        >
        </b-form-input>
    </div>
</template>

<script>
    export default {
        name: "PencilName",

        props: {
            value: {
                required: false,
                default: 'Pencil',
                type: String
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
