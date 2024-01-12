@extends("layouts.admin")
@section("container")
<div class="container-fluid">
    <div class="mt-3"> 
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><a href="#"><img src="{{ asset('images/'.Request::segment(1).'.png') }}" alt="" class="img-fluid"></a></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add New BBN Producer</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            

            <div class="col-2">
                <ul class="list-group">
                <li class="list-group-item"><a href="{{ url('bbn-producer') }}">BBN Producer</a></li>
                    <li class="list-group-item main-border-bottom"><a href="{{ url('bbn-producer/create') }}">Add BBN Producer</a></li>
                    
                </ul>
            </div>
            <div class="col-10"> 
               
                <div class="dashboard-dialog">
                    <div class="row">
                        <form id="form-data" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-2">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group mt-2">
                                <label for="production_capacity">Production Capacity</label>
                                <div class="input-group mb-3">
                                <input type="text" id="production_capacity" name="production_capacity" placeholder="0.00" class="form-control number-format">
                                <span class="input-group-text" id="basic-addon2">Kl</span>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlInput1">Province</label>
                                <select id="province_id" name="province_id" class="form-control">
                                    
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlInput1">Regency</label>
                                <select id="regencie_id" name="regencie_id" class="form-control">
                                    <option value="">Please Choose Regency</option>
                                    
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlInput1">Status</label>
                                <select id="is_active" name="is_active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                            </div>
                                                
                        </form>
                        <div class="form-group mt-2">
                            <button id="save" class="btn button-green" onclick="App.save(event)" >Save</button>
                        </div> 
                    </div>               
                </div>
            </div>   
        </div>
    </div>
</div>

@endsection