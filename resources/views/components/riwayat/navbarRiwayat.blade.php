<nav class="navbar navbar-expand-lg bg-white sticky-top navbar-light p-3 shadow-sm">
  <div class="container">
    <a class="navbar-brand" style="color: #9c5518;"><i class="bi bi-hospital"></i> {{ auth()->user()->pegawai->nama }} </a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="nav-link mx-3">
          @csrf
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
