@extends("layouts.admin")
@section("container")
<div class="container-fluid">        
    <div class="row mt-3">      
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><a href="#"><img src="{{ asset('images/'.Request::segment(1).'.png') }}" alt="" class="img-fluid"></a></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Choose Auction Type</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-8">
            <img src="{{ asset('images/chose-dashboard.png') }}" class="img-fluid" alt="">
        </div>
        <div class="col-lg-4">
            <div class="choose-dashboard-container">
                <div class="choose-dashboard-type">
                    <p>Greetings, <strong>{{ auth()->user()->name }}</strong>! We hope you had a fantastic day. </p>
                    <p>Before you start, please choose auction Method first.</p>

                    <form id="form-data" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="method" id="exampleRadios1" value="centralized">
                            <label class="form-check-label" for="exampleRadios1">
                                Centralized Auctiont
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="method" id="exampleRadios2" value="scattered">
                            <label class="form-check-label" for="exampleRadios2">
                                Scattered Auction
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="method" id="exampleRadios3" value="clustered">
                            <label class="form-check-label" for="exampleRadios3">
                                Clustered Auction
                            </label>
                        </div>
                        
                    </form>
                    <div class="form-group mt-2">
                        <button id="save" class="btn button-green" onclick="App.setDashboard(event)" >Next</button>
                    </div>
                </div>
            </div>
            
        </div>       
    </div>             
</div>

@endsection