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
            <div class="col-2">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('tenders') }}">Tenders</a></li>
                    <li class="list-group-item main-border-bottom"><a href="{{ url('tenders/view_centralized_submissions/'.Request::segment(3)) }}">View Submissions</a></li>
                    
                </ul>
            </div>
            <div class="col-10"> 
                
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

                <table id="participant" class="app-table main-border-bottom mt-2">
                    <thead class="header">
                        <tr>
                            <td colspan="4">Offered Volume and Price</td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>Vendor</td>
                            <td>Volume</td>
                            <td>Price</td>
                            
                           
                        </tr>
                    </thead>
                    <tbody> 
                        
                    </tbody>
                    <tfoot class="footer">

                    </tfoot>
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