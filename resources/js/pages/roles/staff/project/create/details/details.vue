<template>
    <div>
        <ul class="list-group shadow">
            <name-step id="name_step" :name="project_data.name" @name-step-complete="handler($event, 2)" @name-step-incomplete="setStepNumber(1)"></name-step>
            <transition name="fade" mode="out-in">
                <client-step id="client_step" v-show="current_step > 1 || revisit === true" @client-step-complete="handler($event, 3)" @client-step-incomplete="setStepNumber(2)"></client-step>
            </transition>
            <transition name="fade" mode="out-in">
                <event-step id="event_step" v-show="current_step > 2 || revisit === true" @event-step-complete="handler($event, 4)" @event-step-incomplete="setStepNumber(3)"></event-step>
            </transition>
            <transition name="fade" mode="out-in">
                <details-step id="details_step" v-show="current_step > 3 || revisit === true" @details-step-complete="handler($event, 5)" @details-step-incomplete="setStepNumber(4)"></details-step>
            </transition>
            <transition name="fade" mode="out-in">
                <brief-step id="brief_step" v-show="current_step > 4 || revisit === true" @brief-step-complete="handler($event, 6)"></brief-step>
            </transition>
        </ul>
        <div class="text-right">
            <button class="btn btn-lg btn-success" v-show="current_step === 6 || revisit === true" @click="stageComplete">Next</button>
        </div>
    </div>
</template>

<script>
    import NameStep from './steps/name-step';
    import ClientStep from './steps/client-step';
    import EventStep from './steps/event-step';
    import DetailsStep from './steps/details-step';
    import BriefStep from './steps/brief-step';

    export default {
        name: "project-details",
        components: {
            NameStep,
            ClientStep,
            EventStep,
            DetailsStep,
            BriefStep
        },
        data() {
            return {
                current_step: 1,
                revisit: false
            }
        },
        props: {
            project_data: {
                type: Object,
                required: true
            }
        },
        methods: {
            updateProjectData(event) {
                for (const [key, value] of Object.entries(event)) {
                    this.project_data[key] = value;
                }
            },
            stageComplete() {
                this.$emit('stage-complete');
            },
            setStepNumber(step_number) {
                this.current_step = step_number;
            },
            handler(e, step_number) {
                this.updateProjectData(e);
                this.setStepNumber(step_number);
            }
        }
    }
</script>
