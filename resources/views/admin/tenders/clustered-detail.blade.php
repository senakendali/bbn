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
                    <li class="list-group-item main-border-bottom"><a href="{{ url('tenders/view_submissions/'.Request::segment(3)) }}">View Submissions</a></li>
                    
                </ul>
            </div>
            
            <div class="col-10"> 
                <div class="d-grid d-md-flex justify-content-md-end shadow-sm p-2 bg-body rounded tool-bar mb-2" style="display:none; ">
                    <form action="{{ url('tenders/publish') }}" method="post">
                        @csrf
                        <input type="hidden" name="tender_id" value="{{ Request::segment(3) }}" autocomplete="off"> 
                        
                        <div class="tender-status">
                            <a class="btn add-cluster" data-bs-toggle="collapse" data-bs-target="#cluster-modal">Add Cluster</a> 
                            <a class="btn add-delivery-point" data-bs-toggle="collapse" data-bs-target="#delivery-point-modal">Add Delivery Point</a> 
                            <button class="btn publish" type="submit">Publish</button>
                        </div>
                    </form>
                </div>
                
                <div class="collapse" id="cluster-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">   
                    <form id="form-data" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tender_id" value="{{ Request::segment(3) }}" autocomplete="off">
                        <table class="app-table main-border-bottom">
                            <thead class="header">
                                <tr>
                                    <td colspan="2">1. Define Cluster</td>
                                </tr>
                                <tr>
                                    <td>Cluster Name</td>
                                    <td>Quota</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" id="cluster_name" name="cluster_name" placeholder=""></td>
                                    <td><input type="text" class="form-control number-format cluster_quota" id="cluster_quota" name="cluster_quota" placeholder="0.00"></td>    
                                </tr>
                            </tbody>
                        </table>  
                        <div id="response" class="alert alert-danger mt-3" role="alert" style="display:none; ">Nilai yang di input tidak boleh lebih dari Cluster Quota</div>
                        <table id="choose-delivery-point" class="app-table main-border-bottom mt-2">
                            <thead class="header">
                                <tr>
                                    <td colspan="3">2. Choose Delivery Point</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <select name="select-delivery-point" class="form-select" id="select-delivery-point">
                                        <option value="">Select Delivery Point</option>
                                    
                                        </select>
                                    </td>
                                </tr>
                                <tr> 
                                    <td>Delivery Point</td>
                                    <td>Quota</td>
                                    <td width="20%">Action</td>
                                </tr>
                            </thead>
                            <tbody>   
                            </tbody>
                            <tfoot class="footer">
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td class="total-cluster"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                    <div class="mb-2 text-end">
                        <button type="button" class="btn btn-primary mt-2" onclick="Clustered.storeCluster(event)">Add Cluster</button>
                    </div>        
                </div>
                <div class="collapse" id="delivery-point-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form id="form-data-delivery_point" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tender_id" value="{{ Request::segment(3) }}" autocomplete="off">
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
                    </form>
                        
                  
                   <div class="mt-2 mb-2 text-end">
                        <button type="button" class="btn btn-primary" onclick="Clustered.storeDeliveryPoint(event)">Add Delivery Point</button>
                   </div>        
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
                <table id="clusters-table" class="app-table main-border-bottom mt-2">
                    <thead class="header">
                        <tr>
                            <td colspan="4">Clusters</td>
                        </tr>
                        <tr>
                            
                            <td>Cluster Name</td>
                            <td>Cluster Quota</td>
                            <td>Delivery Point</td>
                            <td>Quota</td>
                            <!--td width="25%">Action</td-->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot class="footer">
                    </tfoot>
                </table>
                <table id="delivery-point-list" class="app-table main-border-bottom mt-2">
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

<div class="fixed-bottom auto-sum">
  <div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">BBN Quota</div>
        <div class="col-lg-4 quota">0.00</div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-8">Total</div>
        <div class="col-lg-4 total-in">0.00</div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-8">Difference</div>
        <div class="col-lg-4 difference">0.00</div>    
    </div>
  </div>
</nav>
@endsection