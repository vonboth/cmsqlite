<?php
$session = session();
?>
<script type="text/javascript">
    <?php if ($session->has('flash')): ?>
    (function() {
      M.toast({html: '<?= $session->get('flash') ?>'})
    })()
    <? endif; ?>
</script>
