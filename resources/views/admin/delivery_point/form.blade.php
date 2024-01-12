@extends("layouts.admin")
@section("container")
<div class="container-fluid">
    <div class="mt-3"> 
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><a href="#"><img src="{{ asset('images/'.Request::segment(1).'.png') }}" alt="" class="img-fluid"></a></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Delivery Point</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('delivery-point') }}">Delivery Point</a></li>
                    <li class="list-group-item main-border-bottom"><a href="{{ url('delivery-point/create') }}">Add Delivery Point</a></li>
                    
                </ul>
            </div>
            <div class="col-10">  
                <div class="dashboard-dialog">

                    <div class="row">
                        <form id="form-data" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-2">
                                <label for="bbu_bbn_location">Delivery Point</label>
                                <input type="text" class="form-control" id="delivery_point" name="delivery_point">
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlInput1">Cluster</label>
                                <select id="cluster" name="cluster" class="form-control">
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="Sulawesi">Sulawesi</option>
                                    <option value="Maluku, NTT dan Papua">Maluku, NTT dan Papua</option>
                                    <option value="Kalimantan Bagian Timur">Kalimantan Bagian Timur</option>
                                    <option value="Kalimantan Bagian Barat">Kalimantan Bagian Barat</option>
                                </select>
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="exampleFormControlInput1">Province</label>
                                <select id="province_id" name="delivery_point_province_id" class="form-control">
                                    
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