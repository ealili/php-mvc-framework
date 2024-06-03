<?php
loadPartial('head');
loadPartial('navbar');
?>

<div class="d-flex justify-content-center align-items-center mt-4">
  <div class="bg-white p-2 mx-1" style="width: 75vh">
    <h2 class="text-center font-bold mb-4">Register</h2>
    <?php loadPartial('errors', ['errors' => $errors ?? []]) ?>
    <form method="POST" action="/auth/register">
      <div class="mb-4">
        <input type="text" name="name" placeholder="Full Name"
               class="w-100 px-4 py-2 border rounded"
               value="<?= $user['name'] ?? '' ?>"/>
      </div>
      <div class="mb-4">
        <input type="email" name="email" placeholder="Email Address"
               class="w-100 px-4 py-2 border rounded"
               value="<?= $user['email'] ?? '' ?>"/>
      </div>
      <div class="mb-4">
        <input type="text" name="city" placeholder="City"
               class="w-100 px-4 py-2 border rounded"
               value="<?= $user['city'] ?? '' ?>"/>
      </div>
      <div class="mb-4">
        <input type="text" name="state" placeholder="State"
               class="w-100 px-4 py-2 border rounded"
               value="<?= $user['state'] ?? '' ?>"/>
      </div>
      <div class="mb-4">
        <input type="password" name="password" placeholder="Password"
               class="w-100 px-4 py-2 border rounded"/>
      </div>
      <div class="mb-4">
        <input type="password" name="password_confirmation" placeholder="Confirm Password"
               class="w-100 px-4 py-2 border rounded"/>
      </div>
      <button type="submit"
              class="btn btn-block w-100 bg-success text-white px-4 py-2 rounded">
        Register
      </button>

      <p class="mt-4 text-center text-black-50">
        Already have an account?
        <a class="text-blue" href="/auth/login">Login</a>
      </p>
    </form>
  </div>
</div>

<?php loadPartial('footer') ?>
