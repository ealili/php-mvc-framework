<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>

<div class="d-flex justify-content-center mt-5">
  <div class="bg-white p-5" style="width: 75vh">
    <h2 class="text-center fw-bold mb-4">Login</h2>
    <?= loadPartial('errors', [
      'errors' => $errors ?? []
    ]) ?>
    <form method="POST" action="/auth/login">
      <div class="mb-4">
        <input type="email" name="email" placeholder="Email Address"
               value="<?php echo $email ?? '' ?>"
               class="w-100 px-4 py-2 border rounded" required/>
      </div>
      <div class="mb-4">
        <input type="password" name="password" placeholder="Password"
               class="w-100 border rounded px-4 py-2"/>
      </div>
      <button type="submit"
              class="btn btn-block bg-success text-white w-100">
        Login
      </button>

      <p class="mt-4 text-gray-500">
        Don't have an account?
        <a class="text-blue-900" href="/auth/register">Register</a>
      </p>
    </form>
  </div>
</div>

<?= loadPartial('footer') ?>
