<?php
loadPartial('head');
loadPartial('navbar')
?>

<section class="d-flex justify-content-center align-items-center mt-5">
  <div class="bg-white" style="width: 75vh">
    <h3 class="text-center fw-bold mb-4">Edit user</h3>
    <form method="POST" action="/users/<?= $user->id ?>">
      <input type="hidden" name="_method" value="PUT">
      <?php loadPartial('errors', [
        'errors' => $errors ?? []
      ]) ?>
      <div class="mb-3">
        <label>Name</label><br>
        <input type="text" name="name" placeholder="User name"
               class="w-100 px-4 py-2 border rounded"
               value="<?= $user->name ?? '' ?>"/>
      </div>
      <div class="mb-3">
        <label>Email</label><br>
        <input type="text" name="email" placeholder="Email"
               class="w-100 px-4 py-2 border rounded"
               value="<?= $user->email ?? '' ?>"/>
      </div>
      <div class="mb-3">
        <label>City</label><br>
        <input type="text" name="city" placeholder="City"
               class="w-100 px-4 py-2 border rounded"
               value="<?= $user->city ?? '' ?>"/>
      </div>
      <div class="mb-3">
        <label>State</label><br>
        <input type="text" name="state" placeholder="State"
               class="w-100 px-4 py-2 border rounded"
               value="<?= $user->state ?? '' ?>"/>
      </div>
      <button class="btn btn-success w-100">
        Save
      </button>
    </form>
  </div>
</section>

<?php
loadPartial('footer');
?>
