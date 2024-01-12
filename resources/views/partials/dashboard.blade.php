<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <a class="company-logo" href="#" aria-label="Product">
            <img src="{{ asset('images/app-logo.png?loadtime='.date('YmdHis')) }}" class="img-fluid"/>
            </a>
        </div>
        <div class="col-lg-10">
            <nav id="bstNavigation" class="d-flex flex-column flex-md-row justify-content-between site-nav d-none d-sm-block">
               
               
                <!--a class="site-nav-item align-items-center text-decoration-none" href="#">Tentang Kami</a>
                <a class="site-nav-item align-items-center text-decoration-none" href="#">Produk</a>
                <a class="site-nav-item align-items-center text-decoration-none" href="#">Divisi</a>
                <a class="site-nav-item align-items-center text-decoration-none" href="#">Ikuti Kami</a-->
                
                @auth
                    @if(Session::get('method'))
                        
                        <a class="site-nav-item align-items-center text-decoration-none" href="{{ url('') }}/dashboard">Dashboard</a>
                        <a class="site-nav-item align-items-center text-decoration-none" href="{{ url('tenders') }}">Tenders</a>
                        
                        <a class="site-nav-item dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Master Data
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url('bbn-producer') }}" class="dropdown-item text-dark" type="submit">BBN Producer</a>
                                <a href="{{ url('supply-point') }}" class="dropdown-item text-dark" type="submit">Supply Point</a>
                                <a href="{{ url('delivery-point') }}" class="dropdown-item text-dark" type="submit">Delivery Point</a>  
                            </li>
                        
                        </ul>

                        <a class="site-nav-item dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Report
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                
                            
                                <a class="dropdown-item text-dark" type="submit">Report 1</a>
                                <a class="dropdown-item text-dark" type="submit">Report 2</a>
                            </li>
                        
                        </ul>

                        <a class="site-nav-item dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Setting
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                
                            
                                <a class="dropdown-item text-dark" type="submit">Users</a>
                                <a class="dropdown-item text-dark" type="submit">Groups</a>
                            </li>
                        
                        </ul>

                    @endif   
                    
                    
                    <a class="site-nav-item dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ auth()->user()->name }} 
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item text-dark" type="submit">Profile</a>
                            <form action="{{ route('auth.logout') }}" method="post">
                                @csrf
                                <button class="dropdown-item text-dark" type="submit">Logout</button>
                            </form>
                            
                        
                        </li>
                    
                    </ul>
                    @if(Session::get('method'))
                    <a class="site-nav-item align-items-center text-decoration-none active-auction" href="{{ url('') }}/dashboard">{{ Session::get('method') }} Auction</a>
                    @endif
                @endauth
                
            </nav>  
        </div>
    </div>
</div>

<!--div class="collapse mobile-menu" id="navbarToggleExternalContent">
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
</div-->
<nav class="navbar navbar-dark bg-dark mobile-menu">
    <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    </div>
</nav>