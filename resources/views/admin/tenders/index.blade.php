@extends("layouts.admin")
@section("container")
<div class="container-fluid">  
    <div class="mt-3"> 
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><a href="#"><img src="{{ asset('images/'.Request::segment(1).'.png') }}" alt="" class="img-fluid"></a></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tenders</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="mt-3 mb-2 text-end">
                <a href="{{ url('tenders/create') }}" class="site-nav-item align-items-center text-decoration-none active-auction">Create New Tender</a>
            </div>
            <div class="col-12">
                <table id="data-list" class="app-table main-border-bottom">
                    <thead class="header">
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td colspan="3" class="text-start">Auction Period</td>
                        </tr>
                        <tr>
                            <td scope="col">No</td>
                            <td scope="col">Tender Number</td>
                            <td scope="col">Method</td>
                            <td scope="col">National BBN Quota</td>
                            
                            <td scope="col" class="text-start">From</td>
                            <td scope="col" class="text-start">To</td>
                            <td scope="col">Action</td>
                        </tr>
                    </thead>
                    <tbody>    
                    </tbody>  
                </table>              
            </div>
        </div>  
    </div>
</div>

@endsection