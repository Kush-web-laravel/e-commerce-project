<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" href="#" role="button" id="user" data-toggle="modal" data-target="#modal-default">
          <i class="fas fa-user-alt"></i>
        </a>
      </li>
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content" style="width: 300px;margin-top: 55px;">             
            <div class="modal-footer justify-content-between">
              <a href="{{ route('changePassword-view') }}" class="btn btn-default">Change Password</a>
              <a href="{{ route('profile-view') }}" class="btn btn-primary">Profile</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- Logout -->
      <li class="nav-item">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-power-off"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script>
    $('#user').on('click', function() {
        $('.modal-backdrop').remove();
    });
</script>
