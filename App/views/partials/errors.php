<?php if (isset($errors)) : ?>
  <?php foreach ($errors as $error) : ?>
    <div class="bg-danger text-white px-3 py-1 rounded my-3"><?= $error ?></div>
  <?php endforeach; ?>
<?php endif; ?>
