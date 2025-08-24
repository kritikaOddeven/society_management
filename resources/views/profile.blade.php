@extends('layouts.app')
@section('pagetitle', 'Dashboard | Kulvriksh')
@section('main-content')
    <section class="section">
      <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{url('dashboard')}}">Dashboard</a></div>
          <div class="breadcrumb-item">Profile</div>
        </div>
      </div>
      <div class="section-body">
        <h2 class="section-title">Hi, {{$admin->name}}</h2>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>&times;</span>
              </button>
              {{ session('success') }}
            </div>
          </div>
        @endif

        <div class="row mt-sm-4">
          <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget ">
              <div class="profile-widget-header">                     
                <img  alt="image" src="{{asset('/assets/img/avatar/avatar-1.png')}}" class="rounded-circle profile-widget-picture">
                {{-- <div class="profile-widget-items">
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Posts</div>
                    <div class="profile-widget-item-value">187</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Followers</div>
                    <div class="profile-widget-item-value">6,8K</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Following</div>
                    <div class="profile-widget-item-value">2,1K</div>
                  </div>
                </div> --}}
              </div>
              <div class="profile-widget-description">
                <div class="profile-widget-name">{{$admin->name}}</div>
                <div class="profile-widget-name">{{$admin->email}}</div>
              </div>
              <div class="card-footer text-center">
                <div class="font-weight-bold mb-2"></div>
                <ul class="nav nav-pills row d-flex justify-content-center" id="myTab3" role="tablist">
                    <li class="nav-item col-6">
                      <a class="nav-link {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('password_confirmation') ? '' : 'active show' }}" id="home-tab3" data-toggle="tab" href="#profile" role="tab" aria-controls="home" aria-selected="{{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('password_confirmation') ? 'false' : 'true' }}">Profile</a>
                    </li>
                    <li class="nav-item col-6">
                      <a class="nav-link {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('password_confirmation') ? 'active show' : '' }}" id="profile-tab3" data-toggle="tab" href="#password" role="tab" aria-controls="profile" aria-selected="{{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('password_confirmation') ? 'true' : 'false' }}">Password</a>
                    </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-7">
            <div class="tab-content" id="myTabContent2">
                <div class="tab-pane fade {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('password_confirmation') ? '' : 'active show' }}" id="profile" role="tabpanel" aria-labelledby="home-tab3">
                    <div class="card">
                        <form action="{{route('admin.update.profile')}}" method="POST" class="needs-validation">
                            @csrf
                          <input type="hidden" name="id" value="{{$admin->id}}">
                          <div class="card-header">
                            <h4>Edit Profile</h4>
                          </div>
                          <div class="card-body">
                              <div class="row">                               
                                <div class="form-group col-12 mb-2">
                                  <label>Name</label>
                                  <input type="text" class="form-control" name="name" value="{{$admin->name}}" >
                                  <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                </div>
                                <div class="form-group col-12 mb-2">
                                  <label>Email</label>
                                  <input type="email" class="form-control" name="email" value="{{$admin->email}}">
                                  <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                </div>
                                {{-- <div class="form-group col-12 mb-2">
                                  <label>Status</label>
                                  <input type="text" readonly class="form-control" value="{{$admin->status}}">
                                </div> --}}
                            </div>
                           
                          </div>
                          <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                          </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('password_confirmation') ? 'active show' : '' }}" id="password" role="tabpanel" aria-labelledby="profile-tab3">
                    <div class="card">
                        <form action="{{route('admin.update.password')}}" method="POST" class="needs-validation">
                          @csrf
                          <input type="hidden" name="email" value="{{$admin->email}}">

                          <div class="card-header">
                            <h4>Change Password</h4>
                          </div>
                          <div class="card-body">
                              <div class="row">                               
                                <div class="form-group col-md-12 col-12 mb-2">
                                    <label for="password">Old Password</label>
                                    <input id="password" name="current_password" type="password" class="form-control pwstrength" data-indicator="pwindicator" tabindex="2" >
                                    <span class="text-danger">@error('current_password') {{$message}} @enderror</span>

                                </div>
                                <div class="form-group col-md-12 col-12 mb-2">
                                    <label for="password">New Password</label>
                                    <input id="password" name="new_password" type="password" class="form-control pwstrength" data-indicator="pwindicator" tabindex="2" > 
                                    <span class="text-danger">@error('new_password') {{$message}} @enderror</span>

                                </div>
                                <div class="form-group col-md-12 col-12 mb-2">
                                    <label for="password">Confirm Password</label>
                                    <input id="password" name="password_confirmation" type="password" class="form-control pwstrength" data-indicator="pwindicator" tabindex="2" >
                                    <span class="text-danger">@error('password_confirmation') {{$message}} @enderror</span>

                                </div>
                            </div>
                          </div>
                          <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                        </form>
                    </div>
                    
                </div>
                
              </div>
            
          </div>
        </div>
      </div>
    </section>
@endsection