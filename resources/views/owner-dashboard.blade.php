  @extends('layouts.app')
  @section('pagetitle', 'Onwer Dashboard | Society Management')
  @section('main-content')
      <section class="section">
          <div class="section-header">
              <h1>Owner Dashboard</h1>
          </div>

          <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                      <div class="card-icon bg-primary">
                          <i class="fas fa-home"></i>
                      </div>
                      <div class="card-wrap">
                          <div class="card-header">
                              <h4>Apartments</h4>
                          </div>
                          <div class="card-body">
                              10
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                      <div class="card-icon bg-danger">
                          <i class="far fa-newspaper"></i>
                      </div>
                      <div class="card-wrap">
                          <div class="card-header">
                              <h4>Maintenance Due</h4>
                          </div>
                          <div class="card-body">
                              42
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                      <div class="card-icon bg-warning">
                          <i class="far fa-file"></i>
                      </div>
                      <div class="card-wrap">
                          <div class="card-header">
                              <h4>Tenant</h4>
                          </div>
                          <div class="card-body">
                              1,201
                          </div>
                      </div>
                  </div>
              </div>

          </div>
      </section>
  @endsection
