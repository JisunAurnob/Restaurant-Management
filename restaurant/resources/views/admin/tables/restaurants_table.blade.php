@extends('layouts.app')
@push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('something.css') }}"> --}}
@endpush
@section('title', 'Restaurants')
@section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1>All Restaurants</h1>
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">All Restaurants</li>
                      </ol>
                    </div>
                  </div>
                </div><!-- /.container-fluid -->
              </section>
          
              <!-- Main content -->
              <section class="content">
                      <div class="card">
                        @if (!empty(request('msg')))
                          
                        <div class="alert alert-success"> {{request('msg')}} </div>
                        @endif
                        {{-- <div class="card-header">
                          <h3 class="card-title">Bordered Table</h3>
                        </div> --}}
                        <!-- /.card-header -->
                        {{-- {{dd($restaurants[0]['id'])}} --}}
                        <div class="card-body">
                          @if (!empty($restaurants[0]['id']))
                          <table class="table table-bordered table-hover table-responsive-xl">
                            <thead class="thead-dark">
                              <tr>
                                <th style="width: 10px">#</th>
                                <th>Restaurant Name</th>
                                {{-- <th>Email</th> --}}
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Restaurant Picture</th>
                                {{-- <th>Experience</th>
                                <th>Salary</th>
                                <th>Vacation</th>
                                <th>City</th> --}}
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              {{-- {{dd($restaurants->id)}} --}}
                                @foreach ($restaurants as $restaurant)
                              <tr>
                                <td>{{$restaurant->id}}</td>
                                <td>{{$restaurant->restaurant_name}}</td>
                                {{-- <td>{{$employee->email}}</td> --}}
                                <td>{{$restaurant->phone}}</td>
                                <td>{{$restaurant->address}}</td>
                                <td><img src="{{ asset('storage/'.$restaurant->restaurant_photo) }}" style="max-height: 200px; max-width: 200px;"></td>
                                {{-- <td>{{$employee->experience}}</td>
                                <td>{{$employee->salary}}</td>
                                <td>{{$employee->vacation}}</td>
                                <td>{{$employee->city}}</td> --}}
                                
                                <td><a href="edit-restaurant/{{$restaurant->id}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>&nbsp;
                                  <a href="delete-restaurant/{{$restaurant->id}}" onclick="return confirm('Are you sure you want to delete this restaurant?');" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                            {{-- {{dd($staffs->links())}} --}}
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                          <ul class="pagination pagination-sm m-0 float-right">
                            
                            <div class="d-flex justify-content-center">
                          </div>
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                          </ul>
                        </div>
                        
                        @else
                        <div class="text-info">You Haven't Added Any Restaurant Yet</div>
                        @endif
                      </div>
                    </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->
        @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

            });
        </script>

        {{-- <script src="{{ asset('something.js') }}"></script> --}}
    @endpush
    @endsection
