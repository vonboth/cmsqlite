<?php
$session = session();
$message = null;
if ($session->has('flash')) {
  $message = $session->get('flash');
  if (is_array($message)) {
    $message = implode('<br/>', $message);
  }
}
?>
<script type="text/javascript">
    <?php if ($message): ?>
    (function() {
      M.toast({html: '<?= $message ?>'})
    })()
    <? endif; ?>
</script>
