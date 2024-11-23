<script>

import axios from 'axios';

const allowedTypes = [
    'text/plain',
    'image/webp',
    'image/png',
    'image/jpeg',
    'application/pdf',
    'application/zip',
    'application/msword',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

/**
 * the file browser
 */
export default {
    name: 'FileBrowser',
    inject: ['translations'],
    props: {
        csrfToken: {
            type: String,
            required: true
        },
        directoryContent: {
            type: Array
        }
    },
    mounted() {
        M.Modal.init(document.querySelectorAll('.modal'));
    },
    data() {
        return {
            currentDirectory: this.directoryContent[0],
            currentPath: [],
            uploadFiles: [],
            newFolderName: '',
            showFileContextMenu: false,
            showDirectoryContextMenu: false,
            selectedDirectory: null,
            selectedFile: null
        };
    },
    computed: {
        canSaveNewFolder() {
            return this.newFolderName.length > 0;
        }
    },
    methods: {
        // go the main root directory
        goHome() {
            this.currentPath = [];
            this.currentDirectory = this.directoryContent[0];
        },
        // go up one directory
        goUp() {
            if (this.currentPath.length > 0) {
                this.currentPath.pop();
                if (this.currentPath.length === 0) {
                    this.currentDirectory = this.directoryContent[0];
                } else {
                    this.currentDirectory = findDirectory(this.directoryContent,
                        this.currentPath[this.currentPath.length - 1]);
                }
            }
        },
        // open a modal/dialog
        showDialog(dialog) {
            M.Modal.getInstance(this.$refs[dialog]).open();
        },
        // close a dialog/modal
        closeDialog(dialog) {
            M.Modal.getInstance(this.$refs[dialog]).close();
        },
        // Create new folder
        async onCreateFolder() {
            try {
                await axios.post('/admin/media/create-folder', {
                    dir_name: this.newFolderName,
                    path: this.currentPath.join('/')
                }, {
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                });

                this.currentDirectory.children.push({
                    name: this.newFolderName,
                    children: [],
                    type: 'dir'
                });

                this.newFolderName = '';
                this.closeDialog('modalCreateFolder');
                this.currentDirectory.children.sort((a, b) => {
                    if (a.type === 'dir' && b.type === 'dir') {
                        return a.name.localeCompare(b.name);
                    } else if (a.type === 'dir' && b.type !== 'dir') {
                        return -1;
                    } else if (a.type !== 'dir' && b.type === 'dir') {
                        return 1;
                    } else if (a.type !== 'dir' && b.type !== 'dir') {
                        return a.name.localeCompare(b.name);
                    }
                    return 0;
                });
                M.toast({html: this.translations.media.create_dir_success});
            } catch (exception) {
                M.toast({html: this.translations.media.create_dir_error});
                console.error(exception);
                const errors = exception.response?.data?.errors;
                if (errors) {
                    for (const key in exception.response.data?.errors) {
                        M.toast({html: `${key}: ${errors[key]}`});
                    }
                } else {
                    M.toast({html: exception.response?.data?.message || 'error occured'});
                }
                return false;
            }
        },
        // function when file dialot is closed
        async onUploadFile(event) {
            this.uploadFiles = [];

            [...event.target.files].forEach(it => {
                if (allowedTypes.includes(it.type)) {
                    this.uploadFiles.push({
                        name: it.name,
                        uploadProgress: 0,
                        file: it
                    });
                } else {
                    M.toast({html: this.translations.media.filetype_not_allowed});
                }
            });

            if (this.uploadFiles.length > 0) {
                this.showDialog('modalUploadProgress');
                for (const file of this.uploadFiles) {
                    await this.doFileUpload(file);
                }
            }

            this.$refs.fileInput.value = '';
            this.uploadFiles = [];
            this.closeDialog('modalUploadProgress');
        },
        // upload all files to the baclend
        async doFileUpload(file) {
            const data = new FormData();
            data.append('path', this.currentPath.join('/'));
            data.append('file', file.file);

            try {
                const response = await axios.post('/admin/media/upload', data, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    onUploadProgress: (event) => {
                        file.uploadProgress = Math.round((event.loaded * 100) / event.total);
                    }
                });

                const fileName = response.data?.name;
                this.currentDirectory.children.push({
                    name: fileName,
                    path: '/media/' + (this.currentPath ? this.currentPath.join('/') + '/' : ''),
                    type: fileName.slice(fileName.lastIndexOf('.') + 1)
                });

                M.toast({html: this.translations.media.upload_success});
            } catch (exception) {
                console.error(exception);
                const errors = exception.response?.data?.errors;
                if (errors) {
                    for (const key in exception.response.data?.errors) {
                        M.toast({html: `${key}: ${errors[key]}`});
                    }
                } else {
                    M.toast({html: exception.response?.data?.message || 'error occured'});
                }
                return false;
            }

            return true;
        },
        // select a directory as active one
        selectDirectory(name) {
            this.currentDirectory = findDirectory(this.directoryContent, name);
            this.currentPath.push(this.currentDirectory.name);
        },
        // remove a file
        removeFile() {
            Swal.fire({
                icon: 'warning',
                title: this.translations.delete_item,
                text: this.translations.delete_question,
                showCancelButton: true,
                confirmButtonText: this.translations.yes,
                cancelButtonText: this.translations.no
            })
                .then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            await axios.post('/admin/media/remove-file', {
                                path: this.currentPath.join('/'),
                                delete_file: this.selectedFile.name
                            }, {
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken
                                }
                            });

                            this.currentDirectory.children = this.currentDirectory.children.filter(
                                it => it.name !== this.selectedFile.name);
                            M.toast({html: this.translations.media.file_delete_success});
                            this.selectedFile = null;
                        } catch (exception) {
                            console.error(exception);
                            const errors = exception.response?.data?.errors;
                            if (errors) {
                                for (const key in exception.response.data?.errors) {
                                    M.toast({html: `${key}: ${errors[key]}`});
                                }
                            } else {
                                M.toast({html: exception.response?.data?.message || 'error occured'});
                            }
                            return false;
                        }
                    }
                });
        },
        // remove a directory
        deleteDirectory() {
            if (this.selectedDirectory.children.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: this.translations.media.delete_directory,
                    text: this.translations.media.not_empty_dir
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: this.translations.media.delete_directory,
                    text: this.translations.media.delete_dir,
                    showCancelButton: true,
                    confirmButtonText: this.translations.yes,
                    cancelButtonText: this.translations.no
                })
                    .then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                await axios.post('/admin/media/remove-dir', {
                                    path: this.currentPath.join('/'),
                                    dir_name: this.selectedDirectory.name
                                }, {
                                    headers: {
                                        'X-CSRF-TOKEN': this.csrfToken
                                    }
                                });

                                this.currentDirectory.children = this.currentDirectory.children.filter(
                                    it => it.name !== this.selectedDirectory.name);
                                M.toast({html: this.translations.media.dir_delete_success});
                                this.selectedDirectory = null;
                            } catch (exception) {
                                console.error(exception);
                                const errors = exception.response?.data?.errors;
                                if (errors) {
                                    for (const key in exception.response.data?.errors) {
                                        M.toast({html: `${key}: ${errors[key]}`});
                                    }
                                } else {
                                    M.toast({html: exception.response?.data?.message || 'error occured'});
                                }
                                return false;
                            }
                        }
                    });
            }
        },
        onRightClickFile(event, item) {
            this.selectedFile = item;
            this.$refs.fileContextMenu.style.top = `${event.clientY}px`;
            this.$refs.fileContextMenu.style.left = `${event.clientX}px`;
            this.showFileContextMenu = true;
        },
        onRightClickDirectory(event, item) {
            this.selectedDirectory = item;
            this.$refs.directoryContextMenu.style.top = `${event.clientY}px`;
            this.$refs.directoryContextMenu.style.left = `${event.clientX}px`;
            this.showDirectoryContextMenu = true;
        },
        // handle file drop
        async onDrop(event) {
            this.$refs.dropArea.classList.remove('border-dashed');
            event.preventDefault();
            if(event.dataTransfer.items) {
                [...event.dataTransfer.items].forEach(it => {
                    if (it.kind === 'file' && allowedTypes.includes(it.type)) {
                        const file = it.getAsFile();
                        this.uploadFiles.push({
                            name: file.name,
                            uploadProgress: 0,
                            file: file
                        });
                    } else {
                        if (it.kind && it.kind !== 'string') {
                            M.toast({html: this.translations.media.filetype_not_allowed});
                        }
                    }
                })
            } else {
                [...event.dataTransfer.files].forEach(it => {
                    if (allowedTypes.includes(it.type)) {
                        this.uploadFiles.push({
                            name: it.name,
                            uploadProgress: 0,
                            file: it
                        });
                    } else {
                        if (it.kind && it.kind !== 'string') {
                            M.toast({html: this.translations.media.filetype_not_allowed});
                        }
                    }
                });
            }

            if(this.uploadFiles.length > 0) {
                for (const file of this.uploadFiles) {
                    await this.doFileUpload(file);
                }
            }

            this.uploadFiles = [];
        },
    }
};

function findDirectory(elements, name) {
    for (const item of elements) {
        if (item.name === name) {
            return item;
        }

        if (item.children.length > 0) {
            return findDirectory(item.children, name);
        }
    }

    return elements[0];
}
</script>

<template>
    <div class="bg-white">
        <div class="border-bottom flex">
            <div class="file-navbar">
                <ul>
                    <li>
                        <a class="cursor-pointer nav-button"
                           @click="showDialog('modalCreateFolder')">
                            <i data-position="bottom"
                               :data-tooltip="translations.media.create_folder"
                               class="__size2_5 material-icons tooltipped">create_new_folder</i>
                        </a>
                    </li>
                    <li>
                        <a class="cursor-pointer nav-button"
                           @click="() => { this.$refs.fileInput.click() }">
                            <i data-position="bottom"
                               :data-tooltip="translations.media.upload_file"
                               class="__size2_5 material-icons tooltipped">file_upload</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-bottom flex file-breadcrumb-row">
            <div class="flex flex-center">
                <a data-position="bottom"
                   @click="goHome"
                   :data-tooltip="translations.media.start"
                   class="cursor-pointer nav-button tooltipped">
                    <i class="material-icons">home</i>
                </a>
                <a data-position="bottom"
                   @click="goUp"
                   :data-tooltip="translations.media.up"
                   class="cursor-pointer nav-button tooltipped">
                    <i class="material-icons">arrow_upward</i>
                </a>
            </div>
            <div class="flex file-breadcrumb">
                /&nbsp;<span v-for="path in currentPath">{{ path }}&nbsp;/&nbsp;</span>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="file-area"
                     ref="dropArea"
                     @dragover.prevent.stop="() => { $refs.dropArea.classList.add('border-dashed') }"
                     @dragleave.prevent.stop="() => { $refs.dropArea.classList.remove('border-dashed') }"
                     @drop="onDrop">
                    <div class="flex">
                        <div v-for="item in currentDirectory.children"
                             class="inline-block file-item">
                            <div v-if="item.type === 'dir'">
                                <a class="cursor-pointer is-directory"
                                   @contextmenu.prevent.stop="(event) => { onRightClickDirectory(event, item) }"
                                   @click="selectDirectory(item.name)">
                                    <div class="flex flex-center flex-columm">
                                        <div><i class="medium material-icons">folder</i></div>
                                        <span>{{ item.name }}</span>
                                    </div>
                                </a>
                            </div>
                            <div v-else>
                                <div class="flex flex-center flex-columm ">
                                    <a class="cursor-pointer is-file flex flex-center flex-columm"
                                       @contextmenu.prevent.stop="(event) => { onRightClickFile(event, item) }">
                                        <div>
                                            <img v-if="item.type === 'png' || item.type === 'jpg'"
                                                 class="preview-image"
                                                 :alt="item.name"
                                                 :src="item.path + item.name"/>
                                            <span v-else>
                                                <i class="medium material-icons">insert_drive_file</i>
                                            </span>
                                        </div>
                                        <span>{{ item.name }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="invisible">
            <input type="file" ref="fileInput"
                   @change="(event) => { onUploadFile(event) }"/>
        </div>
    </div>

    <teleport to="body">
        <!-- MODAL TO SHOW THE UPLOAD PROGRESS -->
        <div ref="modalUploadProgress" class="modal">
            <div class="modal-content">
                <h5>{{ translations.media.upload_file }}</h5>
                <div v-for="file in uploadFiles" class="mb1rem">
                    <div>
                        <span>{{ file.name }}</span>
                        <div class="progress">
                            <div class="determinate" :style="`width: ${file.uploadProgress}`"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL TO CREATE NEW FOLDER -->
        <div ref="modalCreateFolder" class="modal">
            <div class="modal-content">
                <h5>{{ translations.media.create_folder }}</h5>
                <div class="input-field">
                    <input type="text"
                           v-model="newFolderName"
                           required
                           id="folder-name"/>
                    <label for="folder-name">{{ translations.media.folder_name }}</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        @click="closeDialog('modalCreateFolder')"
                        class="btn waves-effect waves-light">{{ translations.cancel }}
                    <i class="material-icons right">close</i></button>
                <button type="button"
                        @click="onCreateFolder"
                        :disabled="!canSaveNewFolder"
                        class="ml1rem btn waves-effect waves-light">{{ translations.create }}
                    <i class="material-icons right">send</i></button>
            </div>
        </div>

        <div class="context-menu"
             v-show="showFileContextMenu"
             v-click-outside="() => showFileContextMenu = false"
             ref="fileContextMenu">
            <ul>
                <li class="">
                    <a href="#" @click="removeFile">
                        <i class="material-icons">delete</i> <span>{{ translations.delete_item }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="context-menu"
             v-show="showDirectoryContextMenu"
             v-click-outside="() => showDirectoryContextMenu = false"
             ref="directoryContextMenu">
            <ul>
                <li>
                    <a href="#" @click="deleteDirectory">
                        <i class="material-icons">delete</i> <span>{{ translations.delete_directory }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </teleport>
</template>

<style scoped>
.file-navbar {
    padding: .5rem;
}

.file-navbar ul {
    margin: 0;
}

.file-navbar li {
    display: inline-block;
    margin-left: .25em;
}

.file-navbar li:first-child {
    margin-left: 0;
}

.file-breadcrumb-row {
    padding: .5rem;
}

.file-breadcrumb {
    margin-left: .5rem;
    padding: .5rem;
    background: #eee;
    width: 100%;
    text-align: left;
    align-items: center;
    border-radius: .25rem;
}

.file-area {
    margin-top: 2em;
    min-height: 50vh;
}

.file-area.border-dashed {
    background-color: rgba(33, 150, 243, 0.25);
    border: 2px dashed #2196F3;
}

.border-bottom {
    border-bottom: 1px solid #eee;
}

.nav-button {
    display: flex;
    color: rgba(0, 0, 0, .50);
    padding: .2em;
    margin-left: .25em;
}

.is-file,
.is-directory {
    color: rgba(0, 0, 0, .50);
}

.__size2_5 {
    font-size: 2.5em;
}

.cursor-pointer {
    cursor: pointer;
}

.file-item {
    width: 7.5em;
    height: 7.5em;
    display: inline-block;
}

.preview-image {
    height: 58px;
    width: auto;
}

.invisible {
    visibility: hidden;
}

.context-menu ul {
    margin: 0;
}

.context-menu li {
    padding: .5em 0;
}

.context-menu a {
    color: rgba(0, 0, 0, .87);
    display: flex;
    align-items: center;
    font-size: 1em;
    padding: .25em .75em;
}

.context-menu a:hover {
    background: #eee;
}

.context-menu {
    position: absolute;
    color: rgba(0, 0, 0, .87);
    display: block;
    top: 0;
    left: 0;
    z-index: 1000;
    background: #fff;
    box-shadow: 10px 10px 10px rgba(0, 0, 0, .25);
    border-radius: .5em;
}
</style>
