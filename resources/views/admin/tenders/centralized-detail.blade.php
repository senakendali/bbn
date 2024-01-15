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
            <!--div class="col-2">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('tenders') }}">Tenders</a></li>
                    <li class="list-group-item main-border-bottom"><a href="{{ url('tenders/view_centralized_submissions/'.Request::segment(3)) }}">View Submissions</a></li>
                    
                </ul>
            </div-->
            <div class="mt-3 mb-2 text-end">
                <a href="{{ url('tenders/view_centralized_submissions/'.Request::segment(3)) }}" class="site-nav-item align-items-center text-decoration-none active-auction">View Submissions</a>
            </div>
            <div class="col-12"> 
                <div class="d-grid d-md-flex justify-content-md-end shadow-sm p-2 bg-body rounded tool-bar mb-2" style="display:none; ">
                    <form action="{{ url('tenders/publish') }}" method="post">
                        @csrf
                        <input type="hidden" name="tender_id" value="{{ Request::segment(3) }}" autocomplete="off"> 
                        <div class="tender-status"><button class="btn btn-primary" type="submit">Publish</button></div>
                    </form>
                </div>
                <input type="hidden" id="method" name="method" value="{{ Session::get('method') }}"/>            
                <table id="data-detail" class="app-table main-border-bottom">
                    <thead class="header">
                        <tr>
                            <td colspan="4">National BBN Quota</td>
                        </tr>
                        <tr>
                            <td>Tender Number</td>
                            <td>Status</td>
                            <td>Year</td>
                            <td>Quota</td>
                        </tr>
                    </thead>
                    <tbody> 
                        
                    </tbody>
                </table>

                <table id="logs-detail" class="app-table main-border-bottom mt-2">
                    <thead class="header">
                        <tr>
                            <td colspan="5">Tender Progress</td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>Progress</td>
                            
                            <td>User</td>
                            <td>Date</td>
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