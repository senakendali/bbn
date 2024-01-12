@extends("layouts.admin")
@section("container")
<div class="container-fluid">
    <div class="row mt-3">
            
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><a href="#"><img src="{{ asset('images/'.Request::segment(1).'.png') }}" alt="" class="img-fluid"></a></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard {{ Session::get('method') }}</li>
                        </ol>
                    </nav>
                </div>
            
            <div class="col-3">
                <div class="dashboard-count text-center province-border">
                    <h5 class="h5 section-title pb-2">Centralized Auction</h5>
                    5
                </div>
            </div>
                
            <div class="col-3">  
                <div class="dashboard-count text-center city-border">
                <h5 class="h5 section-title pb-2">Scattered Auction</h5>
                2
                </div>
            </div>

            <div class="col-3"> 
                <div class="dashboard-count text-center paid-border">
                <h5 class="h5 section-title pb-2">Clustered Auction</h5>
                5
                </div>    
            </div>
            <div class="col-3"> 
                <div class="dashboard-count text-center unpaid-border">
                <h5 class="h5 section-title pb-2">Total Vendors</h5>
                33
                </div>    
            </div>
    </div>

                
                    
    <!--div class="mt-4">
        <div class="row">
            <div class="col-6">              
                <div class="dashboard-dialog">
                    <canvas id="pieChart"></canvas>
                </div>

                
                
                            
            </div>

            <div class="col-6">              
                <div class="dashboard-dialog">
                    <canvas id="doughnutChart"></canvas>
                </div>

                
                
                            
            </div>
        </div>   
        <div class="row mt-4">
            <div class="col-12">              
                <div class="dashboard-dialog">
                    <canvas id="myChart"></canvas>
                </div>

                
                
                            
            </div>
        </div>   
    </div--> 
</div>

@endsection