@extends('layouts.app')

@section('title', 'Excel for Accounting Course')

@push('styles')
<style>
:root {
    --color-primary: #944e25;
    --color-secondary: #ecac57;
    --color-bg: #f3efec;
}

/* Hero */
.hero-section {
    background-color: #e6f7ff; /* biru muda segar */
}
.hero-section h1 {
    color: #222;
    font-weight: 700;
}

/* Card di Hero */
.hero-section .card {
    border: none;
    border-radius: 12px;
    max-width: 500px;
}

/* Button */
.btn-warning {
    background-color: var(--color-secondary);
    border: none;
    color: #000;
    font-weight: 600;
}
.btn-warning:hover {
    background-color: #d89628;
    color: #000;
}

.btn-info {
    background-color: #00c4ff;
    border: none;
    color: #fff;
    font-weight: 600;
}
.btn-info:hover {
    background-color: #009ec9;
    color: #fff;
}

/* Alumni text */
.alumni-text {
    color: red;
    font-weight: 600;
    font-size: 0.9rem;
}

/* Sidebar */
#sidebar-nav .nav-link {
    color: #444;
    transition: 0.3s;
}
#sidebar-nav .nav-link.active {
    color: var(--color-primary) !important;
    font-weight: bold;
}
</style>
@endpush

@section('content')

    {{-- Hero Section --}}
    <section class="py-5 hero-section">
        <div class="container">
            <div class="row align-items-center g-4">
                <!-- Gambar -->
                <div class="col-md-6">
                    <img src="{{ asset('assets/Bootcamp.jpg') }}" 
                         alt="Excel for Accounting" 
                         class="img-fluid rounded-3 shadow-sm">
                </div>

                <!-- Konten -->
                <div class="col-md-6">
                    <h1 class="h3 mb-4">Digital Marketing Mastery</h1>

                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <p class="fw-semibold mb-1 text-primary">
                                Digital Marketing Mastery
                            </p>
                            <span class="text-success small fw-bold">GRATIS!</span>
                            <p class="text-muted small mb-0">15 Okt 2025 – 15 Okt 2025</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('form_pendaftaran') }}" class="btn btn-warning px-4">
                            ⚡ Daftar Sekarang
                        </a>
                        <!--<a href="{{ route('form_pendaftaran') }}" class="btn btn-info px-4">
                            Dapatkan Promo
                        </a>-->
                    </div>

                    <p class="mt-3 alumni-text">
                        5.000+ Alumni Bootcamp Tiap Bulan
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- Content Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">

                {{-- Sidebar --}}
                <aside class="col-md-3">
                    <div class="card shadow-sm sticky-top" style="top: 100px;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Detail</h5>
                            <ul class="nav flex-column small" id="sidebar-nav">
                                <li class="nav-item"><a href="#tentang" class="nav-link">Tentang Bootcamp</a></li>
                                <li class="nav-item"><a href="#prospek" class="nav-link">Prospek Karir</a></li>
                                <li class="nav-item"><a href="#skill" class="nav-link">Skill Yang Akan Kamu Miliki</a></li>
                                <li class="nav-item"><a href="#benefit" class="nav-link">Benefit Bootcamp</a></li>
                                <li class="nav-item"><a href="#kurikulum" class="nav-link">Kurikulum & Silabus</a></li>
                                <li class="nav-item"><a href="#testimoni" class="nav-link">Testimoni</a></li>
                            </ul>
                            <a href="{{ route('form_pendaftaran') }}" 
                               class="btn btn-warning w-100 mt-4">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </aside>

                {{-- Main Content --}}
                <main class="col-md-9">
                    <div class="card shadow-sm mb-4" id="tentang">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Tentang Bootcamp</h5>
                            <p class="text-muted">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem 
                                accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore 
                                veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, 
                                quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, 
                                qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, 
                                amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, 
                                ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, 
                                quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea 
                                commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, 
                                quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? 
                                [33] At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium 
                                voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati 
                                cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est 
                                laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero 
                                tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime 
                                placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus 
                                autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates 
                                repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, 
                                ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores 
                                repellat.</p>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="prospek">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Prospek Karir</h5>
                            <p class="text-muted">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem 
                                accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore 
                                veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, 
                                quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, 
                                qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, 
                                amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, 
                                ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, 
                                quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea 
                                commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, 
                                quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? 
                                [33] At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium 
                                voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati 
                                cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est 
                                laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero 
                                tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime 
                                placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus 
                                autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates 
                                repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, 
                                ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores 
                                repellat.</p>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="skill">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Skill Yang Akan Kamu Miliki</h5>
                            <p class="text-muted">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem 
                                accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore 
                                veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, 
                                quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, 
                                qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, 
                                amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, 
                                ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, 
                                quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea 
                                commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, 
                                quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? 
                                [33] At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium 
                                voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati 
                                cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est 
                                laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero 
                                tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime 
                                placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus 
                                autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates 
                                repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, 
                                ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores 
                                repellat.</p>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="benefit">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Benefit Bootcamp</h5>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi 
                                ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in 
                                voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat 
                                cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="kurikulum">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Kurikulum & Silabus</h5>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut 
                                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in 
                                voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint 
                                occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim 
                                id est laborum.</p>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4" id="testimoni">
                        <div class="card-body">
                            <h5 class="fw-bold text-warning mb-3">Testimoni</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100 text-center">
                                        <div class="card-body">
                                            <p class="small text-muted">Lorem ipsum dolor sit amet...</p>
                                            <span class="fw-semibold">Nama</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100 text-center">
                                        <div class="card-body">
                                            <p class="small text-muted">Lorem ipsum dolor sit amet...</p>
                                            <span class="fw-semibold">Nama</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100 text-center">
                                        <div class="card-body">
                                            <p class="small text-muted">Lorem ipsum dolor sit amet...</p>
                                            <span class="fw-semibold">Nama</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sections = document.querySelectorAll("main .card");
        const navLinks = document.querySelectorAll("#sidebar-nav .nav-link");

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => link.classList.remove("active"));
                    const activeLink = document.querySelector(`#sidebar-nav a[href="#${entry.target.id}"]`);
                    if (activeLink) {
                        activeLink.classList.add("active");
                    }
                }
            });
        }, { threshold: 0.5 });

        sections.forEach(section => observer.observe(section));
    });
</script>
@endpush
