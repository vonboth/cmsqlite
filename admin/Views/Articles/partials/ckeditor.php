<?php
/** @var string $editor_style the style for the CKEDITOR. Set in backend in system settings */
?>
<script src="//cdn.ckeditor.com/4.22.1/<?= $editor_style ?>/ckeditor.js"></script>
<script type="text/javascript">
  CKEDITOR.replace('content', {
    height: 500,
    filebrowserBrowseUrl: '/admin/media/ckbrowse',
    filebrowserUploadUrl: '/admin/media/ckupload',
    uploadUrl: '/admin/media/ckupload?responseType=json',
    fileTools_requestHeaders: {
      'X-CSRF-TOKEN': adminVue.getCsrfToken()
    },
    extraPlugins: 'readon',
    extraAllowedContent: ['hr(*); div(*)'],
    clipboard_handleImages: false
  });

  // CUSTOM PLUGINS
  CKEDITOR.plugins.add('readon', {
    init: function(editor) {
      editor.addContentsCss('/themes/admin/Views/default/css/ckeditor.styles.css');
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
    }
  });
</script>
