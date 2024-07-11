<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 text-muted">
          <span>Riwayat</span>
      </h6>

      <ul class="nav flex-column">
          <li class="nav-item">
              <a class="nav-link" href="{{ url('/riwayatPengobatan?no_rkm_medis=' . $pasien->no_rkm_medis) }}">
                  <span data-feather="file-text"></span>
                  Riwayat Pengobatan
              </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/riwayatPenunjang?no_rkm_medis=' . $pasien->no_rkm_medis) }}">
                <span data-feather="file-text"></span>
                Riwayat Penunjang
            </a>
        </li>
      </ul>

  </div>
</nav>
