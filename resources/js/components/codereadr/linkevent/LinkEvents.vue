<template>
    <div>
        <v-select @search="onSearch" label="name" :options="events" v-model="event">
            <template slot="no-options">
                Type to search UnionCloud events
            </template>
            <template slot="option" slot-scope="option">
                <div class="d-center">
                    {{ option.name }} ({{option.start_date_time}} - {{option.end_date_time}})
                </div>
            </template>
            <template slot="selected-option" slot-scope="option">
                <div class="selected d-center">
                    {{ option.name }} ({{option.start_date_time}} - {{option.end_date_time}})

                </div>
            </template>
        </v-select>

        <b-button size="lg" variant="secondary" @click="trackEvent" v-if="event !== null">
            Sync event with codereadr
        </b-button>
    </div>
</template>

<script>
    import vSelect from 'vue-select'
    import _ from 'lodash';

    export default {
        name: "LinkEvents",

        components: {
            vSelect
        },

        props: {},

        data() {
            return {
                events: [],
                event: null
            }
        },

        methods: {
            onSearch(search, loading) {
                if(search !== '') {
                    loading(true);
                    this.loadEvents(search, loading, this);
                }
            },

            loadEvents: _.debounce(function(search, loading, vm) {
                loading(true);
                this.$http.get('/api/uc_events/search', {
                    params: {
                        search: search
                    }
                })
                    .then(response => vm.events = response.data)
                    .catch(error => {
                        vm.events = [];
                        console.log(error);
                    })
                    .then(() => loading(false));
            }, 1000),

            trackEvent() {
                if(this.event !== null) {
                    this.$http.post('/api/uc_events/' + this.event.id + '/track')
                        .then(response => {
                            alert('Tracking event!');
                            this.$emit('event', response.data);
                            this.event = null;
                        })
                        .catch(error => alert('Could not track event'));
                }
            }
        },

    }
</script>

<style scoped>

</style>
