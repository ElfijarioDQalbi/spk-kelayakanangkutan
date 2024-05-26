
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="beranda.php" class="brand-link">
        <img src="dist/img/dishub.png" alt="Dishub" class="brand-image img-circle" ">
        <span class=" brand-text font-weight-light" style="font-size: large;">Dinas Perhubungan</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
                <li class="nav-item ">
                    <a href="beranda.php" class="nav-link ">
                        <i class="nav-icon fas fa-exclamation"></i>
                        <p> Informasi</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="hasil.php" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Hasil</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="user.php" class="nav-link ">
                        <i class="nav-icon fas fa-user"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="akun.php" class="nav-link ">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>Account</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="logout.php" class="nav-link ">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- /.main sidebar container -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil semua elemen dengan class "nav-link" dan "nav-treeview"
        var navLinks = document.querySelectorAll('.nav-link');
        var navTreeviews = document.querySelectorAll('.nav-treeview');

        // Tentukan URL halaman saat ini
        var currentPage = window.location.pathname.split('/').pop(); // Mendapatkan nama file PHP

        // Fungsi untuk menandai "nav-link" dan "nav-treeview" yang aktif berdasarkan URL
        function markActiveLinks() {
            navLinks.forEach(function (link) {
                var href = link.getAttribute('href'); // Mendapatkan atribut href
                var filename = href.split('/').pop(); // Mendapatkan nama file dari href

                // Memeriksa jika nama file PHP sama dengan currentPage
                if (filename === currentPage) {
                    link.classList.add('active');

                    // Jika "nav-link" aktif memiliki parent "nav-treeview", buka parentnya
                    var parentTreeview = link.closest('.nav-treeview');
                    if (parentTreeview) {
                        parentTreeview.style.display = 'block';
                        // Juga tandai parent "nav-link" jika ada
                        var parentLink = parentTreeview.closest('.nav-item').querySelector('.nav-link');
                        if (parentLink) {
                            parentLink.classList.add('active');
                        }
                    }
                }
            });
        }

        // Panggil fungsi untuk menandai "nav-link" dan "nav-treeview" yang aktif
        markActiveLinks();

        // Tambahkan event listener untuk setiap "nav-link"
        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                // Hapus kelas 'active' dari semua "nav-link"
                navLinks.forEach(function (navLink) {
                    navLink.classList.remove('active');
                });

                // Tambahkan kelas 'active' hanya pada "nav-link" yang diklik
                link.classList.add('active');

                // Jika "nav-link" yang diklik memiliki parent "nav-treeview", buka parentnya
                var parentTreeview = link.closest('.nav-treeview');
                if (parentTreeview) {
                    parentTreeview.style.display = 'block';
                }
            });
        });
    });
</script>