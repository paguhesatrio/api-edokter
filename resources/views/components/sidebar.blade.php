<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">

      <ul class="nav flex-column">
          <li class="nav-item">
              <a class="nav-link" href="{{ url('/home') }}">
                  <span data-feather="grid"></span>
                  Kembali Liat Pasien
              </a>
          </li>
      </ul>

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 text-muted">
          <span>Riwayat</span>
      </h6>

      <ul class="nav flex-column">
          <li class="nav-item">
              <a class="nav-link" href="{{ url('/riwayatPengobatan?no_rkm_medis=' . $pasien->no_rkm_medis) }}" target="_blank">
                  <span data-feather="file-text"></span>
                  Riwayat Pengobatan
              </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/riwayatPenunjang?no_rkm_medis=' . $pasien->no_rkm_medis) }}" target="_blank">
                <span data-feather="file-text"></span>
                Riwayat Penunjang
            </a>
        </li>
      </ul>     

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 text-muted">
          <span>Tindakan</span>
      </h6>

      <ul class="nav flex-column">
          <li class="nav-item">
              <a class="nav-link" href="{{ url('/perawatan?no_rawat=' . $no_rawat) }}">
                  <span data-feather="file-text"></span>
                  Soap
              </a>
          </li>
      </ul>

      <ul class="nav flex-column">
          <li class="nav-item">
              <a class="nav-link" href="{{ url('/resepobat?no_rawat=' . $no_rawat) }}">
                  <span data-feather="file-text"></span>
                  Resep Obat
              </a>
          </li>
      </ul>

      <ul class="nav flex-column">
          <li class="nav-item">
              <a class="nav-link" href="{{ url('/resepracikan?no_rawat=' . $no_rawat) }}">
                  <span data-feather="file-text"></span>
                  Resep Racik
              </a>
          </li>
      </ul>

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 text-muted">
        <span>Permintaan</span>
    </h6>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/radiologi?no_rawat=' . $no_rawat) }}">
                <span data-feather="file-text"></span>
                Radiologi
            </a>
        </li>
    </ul>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/lab?no_rawat=' . $no_rawat) }}">
                <span data-feather="file-text"></span>
                lab
            </a>
        </li>
    </ul>

  </div>
</nav>
