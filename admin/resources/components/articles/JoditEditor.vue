<script>
import {Jodit} from 'jodit/es2015/jodit';
import 'jodit/es2015/jodit.min.css';
import {readonIcon} from '@/assets/readonIcon';
import axios from 'axios';
import {folderIcon} from '@/assets/folderIcon';

class readon {
    buttons = [{name: 'readon'}];
}

class imageBrowser {
    buttons = [{name: 'imageBrowser'}];
}

Jodit.plugins.add('readon', readon);
Jodit.plugins.add('readon', imageBrowser);
Jodit.modules.Icon.set('readon', readonIcon);
Jodit.modules.Icon.set('imageBrowser', folderIcon);

export default {
    name: 'JoditEditor',
    inject: ['translations'],
    props: {
        id: {
            type: String,
            required: true
        },
        disabled: Boolean,
        name: {
            type: String,
            default: 'content'
        }
    },
    data() {
        return {
            editor: null,
            images: []
        };
    },
    methods: {
        browseImages() {
            axios.get('/admin/media/jo-browse')
                .then(response => {
                    this.images = response.data.images;
                    M.Modal.getInstance(this.$refs.modalMediaBrowser).open();
                })
                .catch((errror) => {
                    console.log(error);
                });
        },
        selectImage(image) {
            this.closeMediaBrowser();
            this.editor.s.insertImage(image.path);
        },
        closeMediaBrowser() {
            M.Modal.getInstance(this.$refs.modalMediaBrowser).close();
        }
    },
    mounted() {
        // init modals
        M.Modal.init(document.querySelectorAll('.modal'));

        // Make Jodit editor
        this.editor = Jodit.make(`#${this.id}`, {
            buttons: 'undo,redo,|,bold,italic,eraser,|,copy,paste,|,paragraph,align,|,ol,ul,|,table,image,imageBrowser,link,readon,|,source',
            enter: 'DIV',
            language: 'de',
            uploader: {
                url: '/admin/media/jo-upload',
                headers: {
                    'X-CSRF-TOKEN': document.querySelectorAll('meta[name="X-CSRF-TOKEN"]')[0].content
                },
                isSuccess: (response) => {
                    return response.files && response.files.length && !response.error;
                },
                getMessage: (response) => {
                    return response.message;
                },
                process: (response) => {
                    return {
                        files: [],
                        path: '/', // {string} Real relative path
                        baseurl: '', // {string} Base url for filebrowser
                        error: response.error ? parseInt(response.error) : 0, // {int}
                        msg: response.message // {string}
                    };
                },
                defaultHandlerSuccess: (data, response, a, b, c) => {
                    if (data.files.length) {
                        for (let item of data.files) {
                            if (item.success) {
                                this.editor.s.insertImage(item.file.path);
                            } else {
                                M.toast({html: `<span>${file.name}: ${file.message}</span>`});
                            }
                        }
                    }
                },
                error: function(error) {
                    console.log('error', error);
                    M.toast({html: error.getMessage()});
                    this.message.message(error.getMessage(), 'error', 500);
                }
            },
            controls: {
                readon: {
                    icon: 'readon',
                    tooltip: 'Insert Readon',
                    exec: (editor) => {
                        if (!editor.value.match(/<hr class="readon"/)) {
                            editor.s.insertHTML('<hr class="readon" />');
                            editor.synchronizeValues();
                        }
                    }
                },
                imageBrowser: {
                    icon: 'imageBrowser',
                    tooltip: 'Browser images in Media',
                    exec: (editor) => {
                        this.browseImages();
                    }
                }
            }
        });
    }
};
</script>

<template>
<textarea :name="name"
          class="cmsql-editor"
          :disabled="disabled"
          :id="id">{{ $slots.default ? $slots.default()[0].children : '' }}</textarea>

    <teleport to="body">
        <div ref="modalMediaBrowser" class="modal">
            <div class="modal-content flex">
                <div class="images">
                    <h5>{{ translations.media.select_image }}</h5>
                    <div class="card browse-image-card" v-for="image in images">
                        <div class="card-image flex flex-center">
                            <img :src="image.path" :alt="image.name"/>
                        </div>
                        <div class="card-content center-align">
                            <span>{{ image.name }}</span>
                        </div>
                        <div class="card-action">
                            <button type="button"
                                    class="btn waves-effect waves-light green darken-2"
                                    @click="selectImage(image)">
                                {{ translations.select }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn waves-effect waves-light"
                        @click="closeMediaBrowser()">{{ translations.cancel }}
                    <i class="material-icons right">close</i>
                </button>
            </div>
        </div>
    </teleport>
</template>

<style scoped>
.images {
    width: 100%;
    max-height: 45vh;
    overflow: auto;
}
</style>
