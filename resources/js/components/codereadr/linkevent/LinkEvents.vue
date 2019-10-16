<template>
    <div>
        <v-select label="name" :options="events" v-model="event">
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

        created() {
            this.loadEvents(1);
        },

        methods: {
            loadEvents(page) {
                this.$http.get('/api/uc_events', {
                    params: {
                        page: page
                    }
                })
                    .then(response => {
                        this.events = this.events.concat(response.data);
                        this.loadEvents(page+1);
                    });
            },

            trackEvent() {
                if(this.event !== null) {
                    this.$http.post('/api/uc_events/track', {
                        event_id: this.event.id
                    })
                        .then(response => {
                            alert('Tracking event!');
                            this.$emit('event', response.data);

                        })
                        .catch(error => alert('Could not track event'));
                }
            }
        },

    }
</script>

<style scoped>

</style>
