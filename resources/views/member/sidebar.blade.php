<div class="card card-custom p-3">
  <h6 class="text-muted">Navigasi Profil</h6>
  <ul class="list-unstyled mt-3">
    <li class="mb-2">
      <a href="{{ route('profile.edit') }}"
         class="d-block py-2 px-3 rounded {{ request()->is('profile') ? 'bg-primary text-white' : 'text-dark' }}">
        👤 Profil Saya
      </a>
    </li>
    <li class="mb-2">
      <a href="#" class="d-block py-2 px-3 rounded text-dark">🛒 Akses Pembelian</a>
    </li>
    <li class="mb-2">
      <a href="#" class="d-block py-2 px-3 rounded text-dark">⏱️ Aktivitas Saya</a>
    </li>
    <li>
      <a href="#" class="d-block py-2 px-3 rounded text-dark">📑 Riwayat Transaksi</a>
    </li>
  </ul>
</div>
