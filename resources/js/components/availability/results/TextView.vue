<template>
    <div>
        <b-row>
            <b-col>
                <b-form-group label="Grouping">
                    <b-form-radio-group id="group-group" v-model="grouping" name="radio-sub-component">
                        <b-form-radio value="none">None</b-form-radio>
                        <b-form-radio value="location">Group by Location</b-form-radio>
                        <b-form-radio value="date">Group by Date</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </b-col>
        </b-row>


    </div>
</template>

<script>
    export default {
        name: "TextView",

        props: {
            availability: {
                type: Array,
                default: function() {
                    return [];
                }
            }
        },

        data() {
            return {
                grouping: 'none'
            }
        },

        methods: {},

        computed: {
            results() {
                if(this.grouping === 'none') {
                    return this.availability;
                }
                if(this.grouping === 'location') {
                    let locationGroups = {};
                    this.availability.forEach(available => {
                        if(locationGroups[available.location] === undefined) {
                            locationGroups[available.location] = [];
                        }
                        locationGroups[available.location].push(available);
                    });
                    return locationGroups;
                }
                if(this.grouping === 'date') {
                    let dateGroups = {};
                    this.availability.forEach(available => {
                        let date = available.start.format('DD/MM/YYYY');
                        if(dateGroups[date] === undefined) {
                            dateGroups[date] = [];
                        }
                        dateGroups[date].push(available);
                    });
                    return dateGroups;
                }
            }
        }
    }
</script>

<style scoped>

</style>
