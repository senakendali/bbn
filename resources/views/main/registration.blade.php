@extends("layouts.main")
@section("container")

<div id="tender-announcement" class="scroll-section">
    <div class="container-1280">
        <div class="row">
            <div class="col-lg-12 align-middle">
                VENDOR REGISTRATION
                <p>Welcome to BBN E-Bidding, Your Gateway to Streamlined Procurement! </p>
            </div>
        </div>
    </div>  
</div>

<div class="container">              
    <div class="mt-3"> 
        <div class="row">
            <div class="col-12"> 
            <form id="form-data" method="post" enctype="multipart/form-data">
                @csrf
                <fieldset class="dashboard-dialog">
                <legend  class="float-none w-auto">Company Information</legend>
                            
                    <div class="form-group mt-2">
                        <label for="name">Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name">
                    </div>

                    <div class="form-group mt-2">
                        <label for="company_address">Company Address</label>
                        <textarea class="form-control" id="company_address" name="company_address" rows="3"></textarea>
                    </div>

                    <div class="form-group mt-2">
                        <label for="factory_address">Factory Address</label>
                        <textarea class="form-control" id="factory_address" name="factory_address" rows="3"></textarea>
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
                        <select id="province_id" name="province_id" class="form-select">
                            
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleFormControlInput1">Regency</label>
                        <select id="regencie_id" name="regencie_id" class="form-select">
                            <option value="">Please Choose Regency</option>
                            
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="exampleFormControlInput1">Supply Point</label>
                        <select id="supply_point_id" name="supply_point_id" class="form-select">
                            <option value="">Please Choose Supply Point</option>
                            
                        </select>
                    </div>
                            
                        
                </fieldset>               
                <fieldset class="dashboard-dialog mt-3">
                        
                    <legend  class="float-none w-auto">User Information</legend>
                        <div class="position-relative">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message  }}
                                </div>
                            @enderror
                        </div>        
                        <div class="position-relative">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror " id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message  }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="position-relative">
                            <label for="email" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message  }}
                                </div>
                            @enderror
                        </div>
                        <div class="position-relative">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('confirm-password') is-invalid @enderror" id="confirm-password" name="confirm-password" value="{{ old('confirm-password') }}">
                            @error('confirm-password')
                                <div class="invalid-feedback">
                                    {{ $message  }}
                                </div>
                            @enderror
                        </div>
                           
                    
                    </div>  
                                
                </fieldset>
            </form>
            <div class="form-group text-center mt-2">
                <button id="save" class="btn button-green" onclick="Registration.save(event)" >Save</button>
            </div> 
        </div>   
    </div>  
</div>

@endsection