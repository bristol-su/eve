<template>
    <div>
        <b-form @submit.prevent="search">
            <b-row>
                <b-col lg="3" sm="6" xs="12">
                    <date-from v-model="filters.dateFrom"></date-from>
                </b-col>
                <b-col lg="3" sm="6" xs="12">
                    <date-to v-model="filters.dateTo"></date-to>
                </b-col>
                <b-col lg="3" sm="6" xs="12">
                    <start-time v-model="filters.timeFrom"></start-time>
                </b-col>
                <b-col lg="3" sm="6" xs="12">
                    <end-time v-model="filters.timeTo"></end-time>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <location v-model="filters.location"></location>
                </b-col>
            </b-row>
            <b-button type="submit" variant="secondary">Search</b-button>

        </b-form>



        <b-tabs content-class="mt-3" v-if="availability.length > 0">
            <b-tab title="Text View" active><text-view :availability="results"></text-view></b-tab>
            <b-tab title="Table View"><table-view :availability="results"></table-view></b-tab>
        </b-tabs>


    </div>
</template>

<script>
    import DateTo from './filters/DateTo';
    import DateFrom from './filters/DateFrom';
    import StartTime from './filters/StartTime';
    import EndTime from './filters/EndTime';
    import Location from './filters/Location';
    import TextView from './results/TextView';
    import TableView from './results/TableView';
    import moment from 'moment';

    export default {
        name: "Availability",
        components: {TableView, TextView, Location, EndTime, StartTime, DateFrom, DateTo},
        props: {},

        data() {
            return {
                availability: [],
                filters: {
                    dateFrom: null,
                    dateTo: null,
                    timeTo: null,
                    timeFrom: null,
                    location: []
                }
            }
        },

        methods: {
            search() {
                this.$http.get('/api/availability', {
                    params: this.params
                })
                    .then(response => this.availability = response.data)
                    .catch(error => console.log(error));
            }
        },

        computed: {
            params() {
                let filters = this.filters;
                Object.keys(filters).forEach(key => {
                    if (filters[key] === null) {
                        delete filters[key];
                    }
                });
                return filters;
            },

            results() {
                return this.availability.map(available => {
                    return {
                        location: available.location,
                        start: moment(available.from),
                        end: moment(available.to)
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
