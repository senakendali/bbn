@extends("layouts.admin")
@section("container")
<div class="container position-relative">
                    
                <div class="login-dialog mt-5">
                    
                    <div class="row">
                        <div class="col-12">              
                            <h5 class="h5 section-title pb-2 text-center">Login</h5>

                            <form class="row g-3" method="post" action="{{ route('auth.authenticate') }}" enctype="multipart/form-data">
                                 
                                @csrf
                                
                                <div class="position-relative">
                                    <label for="email" class="form-label form-label-absolute">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror " id="email" name="email" value="{{ old('email') }}" autofocus required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message  }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="position-relative">
                                    <label for="password" class="form-label form-label-absolute">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message  }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="position-relative text-center">
                                    <!--a href='/confirm/{{ date("YmdHis") }}' class="btn btn-dark">Konfirmasi</a-->
                                    <button type="submit" class="btn button-green">Login</button>
                                </div>    
                            </form>
                            
                                        
                        </div>
                    </div>


                    

                    

                    
                </div>

                
           
   
</div>

@endsection