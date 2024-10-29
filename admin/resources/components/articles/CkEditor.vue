<script>
import {
    Bold,
    ClassicEditor,
    Essentials,
    Font,
    Italic,
    Paragraph,
    Link,
    AutoLink,
    List,
    Table,
    TableToolbar,
    Heading,
    TableCellProperties,
    TableProperties,
    SimpleUploadAdapter,
    Image,
    ImageInsert,
    ImageUpload,
    ImageInsertViaUrl,
    SourceEditing,
    GeneralHtmlSupport,
    AutoImage,
    Plugin,
    ButtonView
} from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';
import './ckeditor.styles.css';

class Readon extends Plugin {
    init() {
        const editor = this.editor;

        editor.ui.componentFactory.add('readon', locale => {
            const button = new ButtonView(locale);

            button.set({
                label: 'Insert Readon',
                icon: '<hr class="readon" />',
                tooltip: true
            });

            button.on('execute', () => {
                const model = editor.model;
                const selection = model.document.selection;
                const readon = model.schema.create('hr', {class: 'readon'});

                model.insertContent(readon, selection);
            });

            return button;
        });
    }
}

export default {
    name: 'CkEditor',
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
    data() {
        return {
            editor: null
        };
    },
    mounted() {
        ClassicEditor.create(document.getElementById(this.id), {
            plugins: [
                Essentials,
                Heading,
                Bold,
                Italic,
                Font,
                Paragraph,
                Link,
                AutoLink,
                List,
                Table,
                TableToolbar,
                TableCellProperties,
                TableProperties,
                SimpleUploadAdapter,
                Image,
                ImageInsert,
                ImageUpload,
                ImageInsertViaUrl,
                AutoImage,
                SourceEditing,
                GeneralHtmlSupport,
                Readon
            ],
            toolbar: [
                'undo', 'redo',
                '|', 'heading',
                '|', 'bold', 'italic',
                '|', 'link',
                '|', 'insertTable',
                '|', 'insertImage',
                '|', 'numberedList', 'bulletedList',
                '|', 'readon',
                '|', 'sourceEditing'
            ],
            htmlSupport: {
                //allow: [{name: 'hr', classes: ['readon']}, 'div']
                allow: [{name: /.*/, attributes: true, classes: true, styles: true}]
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
            },
            image: {
                toolbar: [
                    'imageStyle:alignLeft',
                    'imageStyle:full',
                    'imageStyle:alignRight'],
                styles: [
                    'full',
                    'alignLeft',
                    'alignRight'
                ]
            },
            simpleUpload: {
                uploadUrl: '/admin/media/ckupload?responseType=json',
                headers: {
                    'X-CSRF-TOKEN': document.querySelectorAll('meta[name="X-CSRF-TOKEN"]')[0].content
                }
            }
        }).then((editor) => {
            this.editor = editor;
        })
            .catch(error => {
                M.toast(error);
                console.error(error);
            });
        /*CKEDITOR.replace(this.id, {
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
        }*/
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
