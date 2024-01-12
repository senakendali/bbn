@extends("layouts.admin")
@section("container")
<div class="container-1280">
                    
                <div class="mt-5">
                    
                    <div class="row">
                        <div class="col-2">
                            <ul class="list-group">
                                <li class="list-group-item">Users</li>
                                <li class="list-group-item main-border-bottom">User Registration</li>
                               
                            </ul>
                        </div>
                        <div class="col-10">              
                            <div class="dashboard-dialog">

                                <form class="row g-3" method="post" action="{{ route('auth.store') }}" enctype="multipart/form-data">
                                    
                                    @csrf
                                    
                                    <div class="position-relative">
                                        <label for="email" class="form-label form-label-absolute">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror " id="email" name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message  }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="position-relative">
                                        <label for="name" class="form-label form-label-absolute">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message  }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="position-relative">
                                        <label for="email" class="form-label form-label-absolute">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message  }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="position-relative">
                                        <label for="confirm-password" class="form-label form-label-absolute">Confirm Password</label>
                                        <input type="password" class="form-control @error('confirm-password') is-invalid @enderror" id="confirm-password" name="confirm-password" value="{{ old('confirm-password') }}">
                                        @error('confirm-password')
                                            <div class="invalid-feedback">
                                                {{ $message  }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="position-relative">
                                        <label for="groups" class="form-label form-label-absolute">Groups</label>
                                        <select class="form-control @error('confirm-password') is-invalid @enderror" id="group" name="group">
                                            @if($groups)
                                                @foreach($groups as $group){
                                                    <option value="{{ $group['id'] }}">{{ $group['name'] }}</option>
                                                }

                                                @endforeach
                                            @endif
                                        </select>
                                        @error('confirm-password')
                                            <div class="invalid-feedback">
                                                {{ $message  }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="position-relative text-center">
                                        <!--a href='/confirm/{{ date("YmdHis") }}' class="btn btn-dark">Konfirmasi</a-->
                                        <button type="submit" class="btn button-green">Submit</button>
                                    </div>    
                                </form>
                            </div>
                            
                                        
                        </div>
                    </div>


                    

                    

                    
                </div>

                
           
   
</div>

@endsection