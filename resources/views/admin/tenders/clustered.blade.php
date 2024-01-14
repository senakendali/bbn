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
                                <label for="bbn_quota">National BBN Quota</label>
                                <input type="text" class="form-control number-format" id="bbn_quota" name="bbn_quota" placeholder="0.00">
                            </div>

                            <div class="form-group mt-2">
                                <label for="exampleFormControlInput1">Currency</label>
                                <div class="row">
                                    <div class="col-12">
                                    <select id="currency" name="currency" class="form-select">
                                        <option value="">Currency</option>
                                        <option value="IDR">IDR</option>
                                        <option value="USD">USD</option>
                                        
                                    </select>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="form-group mt-2">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" id="year" name="year" value="{{ date('Y') }}">
                            </div>

                            <div class="form-group mt-2">
                                <label for="exampleFormControlSelect1">Auction Periode</label>
                                <div class="row">
                                    <div class="col">
                                    <input type="text" id="date_start" name="date_start" class="form-control" placeholder="From">
                                    </div>
                                    <div class="col">
                                    <input type="text" id="date_end" name="date_end" class="form-control" placeholder="To">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label for="closing_date">Closing Date</label>
                                <input type="text" class="form-control" id="closing_date" name="closing_date">
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlTextarea1">Aditional Info</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                        </form>
                        <div class="form-group mt-2">
                            <button id="save" class="btn button-green" onclick="Clustered.save(event)" >Save</button>
                        </div> 
                    </div>   
                </div>            
            </div>
        </div>   
    </div>
</div>




@endsection