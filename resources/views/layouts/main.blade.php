<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <title>{{ $title }} | {{ $sub_title }} </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="{{ url('') }}/css/main/style.css?session=<?php echo date('YmdHis'); ?>" rel="stylesheet">
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
</head>
<body>
    <header class="site-header sticky-top py-1 header-border-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    <a class="company-logo" href="#" aria-label="Product">
                    <img src="{{ asset('images/app-logo.png?loadtime='.date('YmdHis')) }}" class="img-fluid"/>
                    </a>
                </div>
                <div class="col-lg-10">
                    <nav class="d-flex flex-column flex-md-row justify-content-between site-nav d-none d-sm-block">
                        
                        @if(!Session::get('is_vendor_login'))
                        <a class="site-nav-item align-items-center text-decoration-none" href="{{ url('vendors/registration') }}">Register</a>
                        <a class="site-nav-item align-items-center text-decoration-none" href="{{ url('vendors/login') }}">Login</a>
                        @endif

                        @auth
                        <a class="site-nav-item align-items-center text-decoration-none" href="{{ url('') }}">Home</a>
                            <a class="site-nav-item dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }} 
                            
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item text-dark" type="submit">Profile</a>
                                    <form action="{{ route('vendor.logout') }}" method="post">
                                        @csrf
                                        <button class="dropdown-item text-dark" type="submit">Logout</button>
                                    </form>
                                    
                                
                                </li>
                            
                            </ul>
                        @endauth
                       
                        
                    </nav>  
                </div>
            </div>
        </div>

       
        <nav class="navbar navbar-dark bg-dark mobile-menu">
            <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            </div>
        </nav>
    </header>
    <main>
        @yield("container")
    </main>   
    
    <footer class="container-fluid py-5 footer">
        

        <div class="row">
            <div class="col-lg-12 text-center">
            © 2023 
            </div>
        </div>

        <div id="snap-container"></div>

        
    </footer>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
   
    <script src="{{ asset('js/admin/app.js') }}"></script>

    @if(Request::segment(1) == '')
    <script src="{{ asset('js/admin/home.js') }}"></script>
    @endif
    
    @if(Request::segment(1))
    <script src="{{ asset('js/admin/'.Request::segment(2).'.js') }}"></script>
    @endif

    <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>

    

    
</body>
</html>