<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-primary" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand mx-5" href="/">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
        <?php if (\Framework\Session::has('user')): ?>
          <li class="nav-item">
            <a class="nav-link" href="/users">Users</a>
          </li>
        <?php endif; ?>
      </ul>
      <div class="form-inline my-2 my-lg-0 text-sm-center">
        <?php if (\Framework\Session::has('user')): ?>
          <div class="d-flex align-items-center gap-3">
            <div class="text-white">
              Welcome <?php echo \Framework\Session::get('user')->name; ?>
            </div>
            <form method="POST" action="/auth/logout">
              <button type="submit" class="btn btn-danger">Log out</button>
            </form>
          </div>
        <?php else: ?>
          <div class="d-flex align-items-center gap-3">
            <a href="/auth/login" class="text-white mr-3 text-sm-center">Login</a>
            <a href="/auth/register" class="text-white text-sm-center">Register</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
