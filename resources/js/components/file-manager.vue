<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="tabs">
                        <ul class="tab-list">
                            <li class="tab-header" v-for="dir in top_level_directories" :class="{'is-active': dir.name === selectedTopLevelDirectory}" v-model="selectedTopLevelDirectory" @click="selectTopLevelDirectory(dir)"><span>{{dir.name}} <span class="badge">{{dir.files.length}}</span></span></li>
                        </ul>
                        <pill-button @clicked="addNewDirectoryModalActive = true">
                            <template slot="button_text">Add</template>
                            <template slot="cta_text"><i class="fal fa-plus"></i></template>
                        </pill-button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="search_documents">Search</label>
                    <input type="text" class="form-control" id="search_documents" placeholder="Find a document" v-model="searchQuery">
                </div>
                <div class="col-md-2">
                    <label for="filter_documents">Filter by</label>
                    <select id="filter_documents" class="form-control" v-model="filterByQuery">
                        <option disabled value="">--</option>
                        <option value="file_type">File Type</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="sort_documents">Sort by</label>
                    <select id="sort_documents" class="form-control" v-model="orderByQuery">
                        <option disabled value="">--</option>
                        <option value="name_asc">A - Z</option>
                        <option value="name_desc">Z- A</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">{{selectedTopLevelDirectory}}</li>
            </ul>
            <ul class="list">
                <li class="list-item" v-for="file in filtered_files">
                    <span class="row">
                        <span class="col-md-3">
                            <i :class="file.icon_class" class="icon"></i>
                            <span class="item-title">{{file.name}}</span>
                        </span>
                        <span class="right-container col-md-6">
                            <span class="item-title">Last modified - {{file.last_modified}}</span>
                            <a :href="file.path" class="btn btn-primary btn-sm cta-item" download><i class="fal fa-download"></i></a>
                            <button class="btn ellipsis cta-item" @click="assignCategoryHandler(file)"><i class="fas fa-ellipsis-h"></i></button>
                        </span>
                    </span>
                </li>
            </ul>
            <button class="btn primary-custom" @click="addNewDocumentModalActive = true">Add New <i class="fal fa-plus"></i></button>
        </div>
        <add-directory-modal v-show="addNewDirectoryModalActive === true" :base_folder_name="base_folder_name" :item_id="item_id" @add-directory-modal-closed="addNewDirectoryModalActive = false" @directory-added="directoryAddedHandler"></add-directory-modal>
        <add-document-modal v-show="addNewDocumentModalActive === true" :base_folder_name="base_folder_name" :item_id="item_id" :category="selectedTopLevelDirectory" @add-document-modal-closed="addNewDocumentModalActive = false" @documents-added="documentAddedHandler"></add-document-modal>
        <assign-file-category-modal :base_folder_name="base_folder_name" :item_id="item_id" :file="selectedFile" :file_categories="top_level_directories" :selectedCategory="selectedTopLevelDirectory" v-show="assignFileCategoryModalActive" @assign-file-category-modal-closed="assignFileCategoryModalActive = false" @file-assigned="fileAssignedHandler"></assign-file-category-modal>
        <modal v-show="successModalActive === true"
               @close-modal="successModalActive = false">
            <template slot="header">Success</template>
            <template slot="body">{{successBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import addDocumentModal from './modals/document/add-document-modal'
    import AddDirectoryModal from "./modals/document/add-directory-modal";
    import AssignFileCategoryModal from "./modals/document/assign-file-category-modal";
    import Modal from "./modal";

    export default {
        name: "documents",
        components: {
            AddDirectoryModal,
            addDocumentModal,
            Modal,
            AssignFileCategoryModal
        },
        props: ['base_folder_name', 'item_id'],
        data() {
            return {
                files: [],
                addNewDirectoryModalActive: false,
                addNewDocumentModalActive: false,
                assignFileCategoryModalActive: false,
                successModalActive: false,
                selectedFile: {},
                defaultCategory: '',
                selectedTopLevelDirectory: '',
                searchQuery: '',
                filterByQuery: '',
                orderByQuery: '',
                successBodyContent: ''
            }
        },
        mounted() {
          this.loadDocuments();
        },
        computed: {
            filtered_files() {
                let self = this;
                let filteredFiles = [];

                if(self.selectedTopLevelDirectory !== '') {
                    filteredFiles = self.files.filter(function (file) {
                        return file.name === self.selectedTopLevelDirectory;
                    });

                    if(filteredFiles.length > 0) {
                        filteredFiles = filteredFiles[0].files;
                    }
                }

                if(self.searchQuery !== '') {
                    filteredFiles = filteredFiles.filter(function (file) {
                        return file.name.indexOf(self.searchQuery) !== -1;
                    });
                }

                if(self.orderByQuery !== '') {
                    switch(self.orderByQuery) {
                        case 'name_asc':
                            filteredFiles = filteredFiles.sort(function(a, b) {
                                let nameA = a.name.toUpperCase();
                                let nameB = b.name.toUpperCase();
                                if (nameA < nameB) {
                                    return -1;
                                }
                                if (nameA > nameB) {
                                    return 1;
                                }

                                return 0;
                            });
                            break;
                        case 'name_desc':
                            filteredFiles = filteredFiles.sort(function(a, b) {
                                let nameA = a.name.toUpperCase();
                                let nameB = b.name.toUpperCase();
                                if (nameA < nameB) {
                                    return +1;
                                }
                                if (nameA > nameB) {
                                    return -1;
                                }

                                return 0;
                            });
                            break;
                    }
                }

                if(self.filterByQuery !== '') {
                    switch(self.filterByQuery) {
                        case 'file_type':
                            filteredFiles = filteredFiles.sort(function (a, b) {
                                let nameA = a.file_ext.toUpperCase();
                                let nameB = b.file_ext.toUpperCase();
                                if (nameA < nameB) {
                                    return -1;
                                }
                                if (nameA > nameB) {
                                    return 1;
                                }

                                return 0;
                            });
                            break;
                    }
                }

                return filteredFiles;
            },
            top_level_directories() {
                let self = this, topLevelDirectories = [];

                self.files.forEach((file) => {
                    if(file.type === 'folder') {
                        topLevelDirectories.push(file);
                    }
                });

                if(topLevelDirectories.length > 0) {
                    self.selectedTopLevelDirectory = topLevelDirectories[0].name
                }

                return topLevelDirectories;
            }
        },
        methods: {
            loadDocuments() {
                let self = this;

                self.files = [];

                axios.get(this.$route('api.file.list', this.base_folder_name, this.item_id))
                .then(response => {
                    response.data.forEach((file) => {
                        self.setFileIcon(file);
                        if(file.files) {
                            file.files.forEach((file) => {
                                self.setFileIcon(file);
                            });
                        }
                        self.files.push(file);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            setFileIcon(file) {
                if(file.file_ext) {
                    switch(file.file_ext) {
                        case 'jpg':
                            file.icon_class = 'fal fa-file-image';
                            break;
                        case 'pdf':
                            file.icon_class = 'fal fa-file-pdf';
                            break;
                        default:
                            file.icon_class = 'fal fa-file';
                            break;
                    }
                }
            },
            assignCategoryHandler(file) {
                this.selectedFile = file;
                if(this.top_level_directories.length > 0) {
                    this.defaultCategory = this.top_level_directories[0].name;
                }
                this.assignFileCategoryModalActive = true;
            },
            directoryAddedHandler(directory_added_message) {
                this.showSuccessModal(directory_added_message);
                this.loadDocuments();
            },
            documentAddedHandler(document_added_message) {
                this.showSuccessModal(document_added_message);
                this.loadDocuments();
            },
            fileAssignedHandler(file_assigned_message) {
                this.showSuccessModal(file_assigned_message);
                this.loadDocuments();
            },
            showSuccessModal(modal_content) {
                this.successBodyContent = modal_content;
                this.successModalActive = true;
            },
            selectTopLevelDirectory(file) {
                this.selectedTopLevelDirectory = file.name;
            }
        }
    }
</script>
