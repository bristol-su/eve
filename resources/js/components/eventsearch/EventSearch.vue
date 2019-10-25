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
                    <start-time :hour="filters.hourFrom" :minute="filters.minuteFrom"  @hour="filters.hourFrom = $event" @minute="filters.minuteFrom = $event"></start-time>
                </b-col>
                <b-col lg="3" sm="6" xs="12">
                    <end-time :hour="filters.hourTo" :minute="filters.minuteTo"  @hour="filters.hourTo = $event" @minute="filters.minuteTo = $event"></end-time>
                </b-col>
            </b-row>
            <b-row >
                <b-col lg="9" sm="6" xs="12">
                    <location v-model="filters.location"></location>
                </b-col>
                <b-col lg="3" sm="6" xs="12">
                    <pencil-name v-model="filters.in_name"></pencil-name>
                </b-col>
            </b-row>
            <b-button type="submit" variant="secondary">Search</b-button>

        </b-form>



        <b-tabs content-class="mt-3" v-if="events.length > 0">
            <b-tab title="Table View"><table-view :events="events"></table-view></b-tab>
        </b-tabs>


    </div>
</template>

<script>
    import DateTo from './filters/DateTo';
    import DateFrom from './filters/DateFrom';
    import StartTime from './filters/StartTime';
    import EndTime from './filters/EndTime';
    import Location from './filters/Location';
    import TableView from './results/TableView';
    import PencilName from './filters/PencilName';
    export default {
        name: "EventSearch",
        components: {TableView, Location, EndTime, StartTime, DateFrom, DateTo, PencilName},
        props: {},

        data() {
            return {
                events: [],
                filters: {
                    dateFrom: null,
                    dateTo: null,
                    hourFrom: 0,
                    minuteFrom: 0,
                    hourTo: 23,
                    minuteTo: 59,
                    location: [],
                    in_name: 'pencil'
                }
            }
        },

        methods: {
            search() {
                this.events = [];
                let params = this.params;
                this.$http.get('/api/pencils', {params: params})
                    .then(response => this.events = response.data)
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

        }
    }
</script>

<style scoped>

</style>
