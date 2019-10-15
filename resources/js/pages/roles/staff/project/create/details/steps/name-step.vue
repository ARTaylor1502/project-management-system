<template>
    <li id="add_project_name_step" class="list-group-item">
        <h2>Name</h2>
        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label" for="project_name">Project Name</label>
                <input v-model="name" class="form-control" id="project_name" name="project_name" type="text" @keyup="infoChanged">
            </div>
            <div class="col-md-6">
                <label class="col-form-label" for="project_type_id">Project Type</label>
                <dropdown
                        :label="label"
                        :options="project_types"
                        :id="'project_type_id'"
                        :triggerName = "triggerName"
                        value-key="id"
                        label-key="name"
                        @input-selected="handler"
                        @trigger-activated="setBlankProject">
                </dropdown>
                <span class="caveat">Selecting the project type will determine the base price and task lists</span>
            </div>
        </div>
    </li>
</template>

<script>
    import dropdown from '../../../../../../../components/drop-down'
    import ProjectHelper from '../../../../../../../components/mixins/project-helper'

    export default {
        name: "name-step",
        components: {
            dropdown
        },
        mixins: [ProjectHelper],
        data() {
            return {
                name: '',
                type: {},
                project_types: [],
                label: 'Select a Project Type...',
                triggerName: 'Use Blank +'
            }
        },
        mounted() {
            this.loadProjectTypes();
        },
        methods: {
            infoChanged() {
                if((this.name.length > 3 && this.type === null) || (this.name.length > 3 && this.type.id)) {
                    this.$emit('name-step-complete', {
                        name: this.name,
                        type: this.type
                    });
                } else {
                    this.$emit('name-step-incomplete');
                }
            },
            handler(e) {
                this.label = 'Select a Project Type...';
                this.type = e;
                this.infoChanged();
            },
            setBlankProject() {
                this.label = 'Blank';
                this.type = null;
                this.infoChanged();
            }
        }
    }
</script>
