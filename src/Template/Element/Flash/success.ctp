<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-success container" onclick="this.classList.add('hidden')"><strong>SUCCESS </strong><?= $message ?></div>
