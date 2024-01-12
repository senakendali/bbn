<div class="container-1140">
    <div class="row">
        <div class="col-lg-2">
            <a class="company-logo" href="#" aria-label="Product">
            <img src="{{ url('') }}/images/bst.webp"/>
            </a>
        </div>
        <div class="col-lg-10">
            <nav id="bstNavigation" class="d-flex flex-column flex-md-row justify-content-between site-nav d-none d-sm-block">
                <a class="site-nav-item align-items-center text-decoration-none" href="#">Beranda</a>
                <a class="site-nav-item align-items-center text-decoration-none" href="#">Tentang Kami</a>
                <a class="site-nav-item align-items-center text-decoration-none" href="#">Produk</a>
                <a class="site-nav-item align-items-center text-decoration-none" href="#">Divisi</a>
                <a class="site-nav-item align-items-center text-decoration-none" href="#">Ikuti Kami</a>
                <a class="site-nav-item align-items-center text-decoration-none btn btn-dark btn-order" href="{{ url('') }}/product">Pesan Sekarang</a>
            </nav>  
        </div>
    </div>
</div>

<div class="collapse mobile-menu" id="navbarToggleExternalContent">
    <div class="bg-white p-4">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="#">Beranda</a></li>
            <li class="list-group-item"><a href="#">Tentang Kami</a></li>
            <li class="list-group-item"><a href="#">Produk</a></li>
            <li class="list-group-item"><a href="#">Divisi</a></li>
            <li class="list-group-item"><a href="#">Ikuti Kami</a></li>
            <li class="list-group-item"><a href="{{ url('') }}/product">Pesan Sekarang</a></li>
        </ul>
    </div>
</div>
<nav class="navbar navbar-dark bg-dark mobile-menu">
    <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    </div>
</nav>