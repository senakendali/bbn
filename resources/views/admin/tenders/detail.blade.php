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
                    <li class="list-group-item main-border-bottom"><a href="{{ url('tenders/create') }}">Create New Tender</a></li>
                    
                </ul>
            </div>
            <div class="col-10">  
                <input type="hidden" id="method" name="method" value="{{ Session::get('method') }}"/>            
                <table id="data-detail" class="app-table main-border-bottom">
                    <thead class="header">
                        <tr>
                            <td colspan="3">National BBN Quota for 1 Year</td>
                        </tr>
                        <tr>
                            <td>Tender Number</td>
                            <td>Year</td>
                            <td>Quota</td>
                        </tr>
                    </thead>
                    <tbody>    
                    </tbody>
                    
                </table>


                <div class="form-group mt-2 clustered-auction">
                    <table id="clusters-table" class="app-table main-border-bottom">
                            <thead class="header">
                                <tr>
                                    <td colspan="4">Clusters</td>
                                </tr>
                                <tr>
                                    <td width="10%">No</td>
                                    <td>Cluster Name</td>
                                    <td>Quota</td>
                                    <td width="25%">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                            </tbody>
                            

                    </table>

                    <table id="cluster-delivery-point" class="app-table main-border-bottom mt-3" style="display:none; ">
                            <thead class="header">
                                <tr>
                                    <td colspan="4">Delivery Point</td>
                                </tr>
                                
                                <tr>
                                    <td>No</td>
                                    <td>Delivery Point</td>
                                    <td>Quota</td>
                                    <td width="20%">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                            </tbody>
                            <tfoot class="footer">
                                <tr>
                                    <td colspan="3">Total</td>
                                    <td></td>
                                </tr>
                            </tfoot>

                    </table>
                </div>
                
                <div class="form-group mt-2  scatered-auction">
                    <table id="delivery-point" class="app-table main-border-bottom mt-3">
                        <thead class="header">
                            
                            <tr>
                                <td colspan="3">Delivery Point</td>
                            </tr>
                            <tr>
                                <td>No</td>
                                <td>Delivery Point</td>
                                <td>Quota</td>
                            </tr>
                        </thead>
                        <tbody>    
                        </tbody>
                        <tfoot class="footer">
                            <tr>
                                <td colspan="2">Total</td>
                                <td></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection