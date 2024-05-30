<script>
import {popScopeId} from 'vue';

export default {
    name: 'Editor',
    props: {
        id: {
            type: String,
            required: true
        },
        theme: {
            type: String,
            default: 'default'
        },
        disabled: Boolean,
        name: {
            type: String,
            default: 'content'
        }
    },
    mounted() {
        CKEDITOR.replace(this.id, {
            height: 500,
            filebrowserBrowseUrl: '/admin/media/ckbrowse',
            filebrowserUploadUrl: '/admin/media/ckupload',
            uploadUrl: '/admin/media/ckupload?responseType=json',
            fileTools_requestHeaders: {
                'X-CSRF-TOKEN': document.querySelectorAll('meta[name="X-CSRF-TOKEN"]')[0].content
            },
            extraPlugins: 'readon',
            extraAllowedContent: ['hr(*); div(*)'],
            clipboard_handleImages: false
        });

        // CUSTOM PLUGINS
        if (!CKEDITOR.plugins.registered['readon']) {
            CKEDITOR.plugins.add('readon', {
                init: function(editor) {
                    editor.addContentsCss(`/themes/admin/Views/${this.theme}/css/ckeditor.styles.css`);
                    editor.addCommand('insertReadon', {
                        exec: function(editor) {
                            if (editor.getData().indexOf('<hr class="readon" />') < 0) {
                                editor.insertHtml('<hr class="readon" />', 'unfiltered_html');
                            }
                        }
                    });

                    if (!editor.ui.items.Readon) {
                        editor.ui.addButton('Readon', {
                            icon: '/themes/admin/Views/default/img/readon.png',
                            label: 'Insert Readon',
                            command: 'insertReadon',
                            toolbar: 'insert,100'
                        });
                    }
                }.bind(this)
            });
        }
    }
};
</script>

<template>
    <textarea :name="name"
              :disabled="disabled"
              :id="id">{{ $slots.default ? $slots.default()[0].children : '' }}</textarea>
</template>

<style scoped>

</style>
