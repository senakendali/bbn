@extends("layouts.admin")
@section("container")
<div class="container-fluid">   
    <div class="mt-3"> 
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><a href="#"><img src="{{ asset('images/'.Request::segment(1).'.png') }}" alt="" class="img-fluid"></a></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Supply Point</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('supply-point') }}">Supply Point</a></li>
                    <li class="list-group-item main-border-bottom"><a href="{{ url('supply-point/create') }}">Add Supply Point</a></li>
                    
                </ul>
            </div>
            <div class="col-10">              
                <div class="dashboard-dialog">
                    <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">BBN Location</th>
                                <th scope="col">Province</th>
                                
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                </div>              
            </div>
        </div>   
    </div>
</div>

@endsection