<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">   

   
    <title>{{ $title }} | {{ $sub_title }} </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="{{ url('') }}/css/admin/style.css?session=<?php echo date('YmdHis'); ?>" rel="stylesheet">
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/admin/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/admin/css_bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
   
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
</head>
<body>
    <header class="site-header sticky-top py-1 header-border-top">
       @include("partials.dashboard")
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
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-autocomplete.js') }}"></script>
    

   

    @if(Request::segment(1) === 'dashboard')
    <script src="{{ asset('js/chart.js') }}"></script>
    @endif
    <script src="{{ asset('js/'.Request::segment(1).'.js') }}"></script>
   
    @if(Request::segment(1) === 'tenders')
        @if(Request::segment(2) === 'create' || Request::segment(2) === 'view')
            <script src="{{ asset('js/'.Session::get('method').'.js') }}"></script>

        @elseif(Request::segment(2) === 'view_centralized_submissions')
          <script src="{{ asset('js/centralized.js') }}"></script>   
        @endif
    @endif
    

    <script type="text/javascript">
    

    
    </script>

    

<!-- Modal -->
<div class="modal fade" id="warning-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id="warning-message" class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>
</body>
</html>