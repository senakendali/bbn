@extends("layouts.admin")
@section("container")
<div class="container-fluid">
    <div class="mt-3"> 
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><a href="#"><img src="{{ asset('images/'.Request::segment(1).'.png') }}" alt="" class="img-fluid"></a></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Tender</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('tenders') }}">Tenders</a></li>
                    <li class="list-group-item"><a href="{{ url('tenders/create') }}">Create New Tender</a></li>
                </ul>
            </div>
            <div class="col-10">  
                <div class="dashboard-dialog">
                    <div class="row">
                        <form id="form-data" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="method" name="method" value="{{ Session::get('method') }}"/>
                            <input type="hidden" name="tender_id" value="{{ Str::uuid()->toString(); }}" autocomplete="off"> 
                            
                            <div class="form-group mt-2">
                                <label for="tender_number">Tender Number</label>
                                <input type="text" class="form-control" id="tender_number" name="tender_number" placeholder="">
                            </div>

                            <div class="form-group mt-2">
                                <label for="bbn_quota">BBN Quota</label>
                                <input type="text" class="form-control number-format" id="bbn_quota" name="bbn_quota" placeholder="0.00">
                            </div>

                            <div class="form-group mt-2">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" id="year" name="year" placeholder="{{ date('Y') }}">
                            </div>

                            <div class="form-group mt-2">
                                <label for="exampleFormControlSelect1">Registration Periode</label>
                                <div class="row">
                                    <div class="col">
                                    <input type="text" id="date_start" name="date_start" class="form-control" placeholder="From">
                                    </div>
                                    <div class="col">
                                    <input type="text" id="date_end" name="date_end" class="form-control" placeholder="To">
                                    </div>
                                </div>
                            </div>

                            

                            <div class="cluster-container">

                            </div>

                            <div class="form-group mt-5 text-end">
                                
                                <button type="button" class="btn btn-primary" onclick="Clustered.createCluster()">
                                    Create Cluster
                                </button>               
                                
                            </div>

                            <div class="form-group mt-2 scatered-auction">
                                <table id="delivery-point" class="app-table main-border-bottom">
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
                            <div class="form-group mt-2">
                                <label for="exampleFormControlTextarea1">Aditional Info</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                        </form>
                        <div class="form-group mt-2">
                            <button id="save" class="btn button-green" onclick="Scattered.save(event)" >Save</button>
                        </div> 
                    </div>   
                </div>            
            </div>
        </div>   
    </div>
</div>


<div class="fixed-bottom auto-sum" style="display:none; ">
  <div class="container-fluid">
    <div class="row">
        <!--div class="col-lg-8">BBN Quota</div-->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">BBN Quota</label>
                <div class="quota">0.00</div>
            </div> 
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Total</label>
                <div class="total-in">0.00</div>
            </div> 
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Difference</label>
                <div class="difference">0.00</div>
            </div>
        </div>  
    </div>
    
  </div>
</nav>

@endsection