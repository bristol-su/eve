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
                    <pencils v-model="includePencils"></pencils>
                    <pencil-name v-show="includePencils" v-model="inNameSearch"></pencil-name>
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
    import Pencils from './filters/Pencils';
    import PencilName from './filters/PencilName';
    import TextView from './results/TextView';
    import TableView from './results/TableView';
    import moment from 'moment';

    export default {
        name: "Availability",
        components: {TableView, TextView, Location, EndTime, StartTime, DateFrom, DateTo, Pencils, PencilName},
        props: {},

        data() {
            return {
                availability: [],
                pencils: [],
                filters: {
                    dateFrom: null,
                    dateTo: null,
                    hourFrom: 0,
                    minuteFrom: 0,
                    hourTo: 23,
                    minuteTo: 59,
                    location: []
                },
                includePencils: true,
                inNameSearch: 'Pencil'
            }
        },

        methods: {
            search() {
                this.availability = [];
                this.pencils = [];
                this.$http.get('/api/availability', {params: this.params})
                    .then(response => this.availability = response.data)
                    .catch(error => console.log(error));
                if(this.includePencils) {
                    let params = this.params;
                    params.in_name = this.inNameSearch;
                    this.$http.get('/api/pencils', {params: params})
                        .then(response => this.pencils = response.data)
                        .catch(error => console.log(error));
                }
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
                        end: moment(available.to),
                        available: true
                    }
                }).concat(this.pencils.map(pencil => {
                    return {
                        location: pencil.location,
                        start: moment(pencil.start),
                        end: moment(pencil.end),
                        available: false
                    }
                }));
            }
        }
    }
</script>

<style scoped>

</style>
