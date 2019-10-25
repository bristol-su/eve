<template>
    <div>
        <b-form-group label="Location">
            <b-form-select @input="$emit('input', $event)" :value="value" :options="locations" multiple></b-form-select>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "Location",

        props: {
            value: {
                required: true,
                default: function() {
                    return [];
                }
            }
        },

        data() {
            return {
                locations: [
                    'Odlum',
                    'Anson Rooms (AR5)'
                ]
            }
        },

        methods: {},

        computed: {}
    }
</script>

<style scoped>

</style>
