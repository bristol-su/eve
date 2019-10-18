<template>
    <div>
        <b-form-checkbox
            @input="$emit('input', $event)"
            :value="true"
            :unchecked-value="false"
            v-model="checked"
        >
            Include pencilled events
        </b-form-checkbox>
    </div>
</template>

<script>
    export default {
        name: "Pencils",

        props: {
            value: {
                required: true,
                type: Boolean
            }
        },

        watch: {
            checked() {
                this.$emit('input', this.checked);
            }
        },

        data() {
            return {
                checked: this.value
            }
        },

        methods: {},

        computed: {}
    }
</script>

<style scoped>

</style>
