<?php

use Framework\Session;

?>

<?php $successMessage = Session::getFlashMessage('success_message'); ?>
<?php if ($successMessage !== null) : ?>
  <div class="alert alert-success p-3 my-3">
    <?= $successMessage ?>
  </div>
<?php endif; ?>

<?php $errorMessage = Session::getFlashMessage('error_message'); ?>
<?php if ($errorMessage !== null) : ?>
  <div class="alert alert-danger p-3 my-3">
    <?= $errorMessage ?>
  </div>
<?php endif; ?>
