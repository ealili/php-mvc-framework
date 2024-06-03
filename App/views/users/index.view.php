<?php
loadPartial('head');
loadPartial('navbar');
?>

<div
  class="d-flex flex-column justify-content-center p-4">
  <h3>
    Users
  </h3>
  <?php loadPartial('message'); ?>
  <div>
    <div class="table-responsive">
      <table class="table">
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th></th>
        <th></th>
        <?php foreach ($users as $user): ?>
          <tr>
            <td class="fw-bold">
              <?= $user->id ?>
            </td>
            <td>
              <?= $user->name ?>
            </td>
            <td>
              <?= $user->email ?>
            </td>
            <td>
              <form action="/users/<?= $user->id ?>" method="POST">
                <input type="hidden" name="_method" value="delete">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
            <td>
              <a href="/users/edit/<?= $user->id ?>">
                <button type="submit" class="btn btn-primary">Edit</button>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
<?php
loadPartial('footer');
?>
