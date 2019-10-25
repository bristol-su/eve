<template>
    <div>
        <b-form-input
            @input="$emit('input', $event)"
            :value="value"
            placeholder="Enter your name"
            aria-describedby="input-live-help">

        </b-form-input>
        <b-form-text id="input-live-help">Event name to search for.</b-form-text>

    </div>
</template>

<script>
    export default {
        name: "PencilName",

        props: {
            value: {
                required: false,
                type: String,
                default: 'Pencil'
            }
        }
    }
</script>

<style scoped>

</style>
