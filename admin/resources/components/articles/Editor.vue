<script>
export default {
    name: 'Editor',
    props: {
        theme: {
            type: String,
            default: 'default'
        },
        disabled: Boolean
    },
    mounted() {
        CKEDITOR.replace('content', {
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

                editor.ui.addButton('Readon', {
                    icon: '/themes/admin/Views/default/img/readon.png',
                    label: 'Insert Readon',
                    command: 'insertReadon',
                    toolbar: 'insert,100'
                });
            }.bind(this)
        });
    }
};
</script>

<template>
    <textarea name="content"
              :disabled="disabled"
              id="content">{{ $slots.default ? $slots.default()[0].children : '' }}</textarea>
</template>

<style scoped>

</style>
