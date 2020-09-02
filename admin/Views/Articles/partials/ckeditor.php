<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
  CKEDITOR.replace('content', {
    height: 500,
    filebrowserBrowseUrl: '/admin/media/ckbrowse',
    filebrowserUploadUrl: '/admin/media/ckupload',
    fileTools_requestHeaders: {
      'X-CSRF-TOKEN': adminVue.getCsrfToken()
    }
  });
</script>