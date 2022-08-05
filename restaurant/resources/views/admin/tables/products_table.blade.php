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
                        <h1>All Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">All Products</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                @if (!empty(request('msg')))
                    <div class="alert alert-success"> {{ request('msg') }} </div>
                @endif
                {{-- <div class="card-header">
                          <h3 class="card-title">Bordered Table</h3>
                        </div> --}}
                <!-- /.card-header -->
                {{-- {{ dd($menus) }} --}}
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="restaurant_id"
                        class="col-md-4 col-form-label text-md-end">Restaurant</label>
                        <select name="restaurant_id" id="restaurant_id" class="form-control"  data-live-search="true" aria-label="Select Restaurant">
                          <option value="">Select Your Restaurant</option>
                          @foreach ($restaurants as $restaurant)
                            <option value="{{$restaurant->id}}">{{$restaurant->restaurant_name}}</option> 
                            @endforeach                   
                            </select>
                    </div>

                    <div class="col-md-6">
                        <label for="menu_id" class="col-md-4 col-form-label text-md-end">Menu</label>
                        <select name="menu_id" id="menu_id" class="form-control"
                            data-live-search="true" aria-label="Select Menu">
                            <option>Select Menu</option>
                        </select>
                    </div>
                </div>
                    {{-- @if (!empty($menus[0]['id'])) --}}
                        <table class="table table-bordered table-hover table-responsive-xl">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Product Name</th>
                                    {{-- <th>Email</th> --}}
                                    <th>Product Description</th>
                                    <th>Product Picture</th>
                                    {{-- <th>Experience</th>
                                <th>Salary</th>
                                <th>Vacation</th>
                                <th>City</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="menu-row">
                                {{-- {{dd($restaurants->id)}} --}}
                                {{-- @foreach ($menus as $menu)
                                    <tr>
                                        <td>{{ $menu->id }}</td>
                                        <td>{{ $menu->menu_name }}</td>
                                        <td style="max-width: 20px">{{ $menu->menu_description }}</td>
                                        <td><img src="{{ asset('storage/' . $menu->menu_picture) }}"
                                                style="max-height: 200px; max-width: 200px;"></td>

                                        <td><a href="edit-menu/{{ $menu->id }}" class="btn btn-warning"><i
                                                    class="fas fa-edit"></i></a>&nbsp;
                                            <a href="menu/delete/{{ $menu->id }}"
                                                onclick="return confirm('Are you sure you want to delete this Menu?');"
                                                class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach --}}
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
            {{-- @else
                <div class="text-info">You Haven't Added Any Restaurant Yet</div>
                @endif --}}
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

                $("#restaurant_id").change(function() {
                    var id = $(this).val();
                    $('#menu_id').empty();

                    $('#menu_id').append('<option value="">Select Menu</option>');
                    // var url = '{{ route('search_menu', ['id' => 'id']) }}'
                    var url = '{{ route('search_menu', ':id') }}';
                    url = url.replace(':id', id);
                    // console.log(url);
                    // var firstDropVal = $('#').val();
                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: {},
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                // '<td>'+value.menu_name'</td>'+'<td>'+value.menu_description'</td>'+'<td>'+value.menu_description'</td>'

                                $('#menu_id').append('<option value="' + value.id + '">' +
                                    value.menu_name + '</option>')
                            });

                        }
                    })
                });


                $("#menu_id").change(function() {
                    var id = $(this).val();
                    $('#menu-row').empty();
                    // var url = '{{route("search_menu", ["id" =>'id'])}}'
                    var url = '{{ route("search_product",":id") }}';
                    url = url.replace(':id', id);
                    // var firstDropVal = $('#').val();
                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: {},
                        dataType: 'json',
                        success: function(data) {
                          console.log(data);
                            $.each(data, function(key, value) {
                              // '<td>'+value.menu_name'</td>'+'<td>'+value.menu_description'</td>'+'<td>'+value.menu_description'</td>'
                              
                                $('#menu-row').append('<tr><td>'+value.id+'</td>'+'<td>'+value.product_name+'</td>'+'<td style="max-width: 250px;">'+value.product_description+'</td>'+'<td>'+
                                  '<img src="'+'{{asset('storage').'/'}}'+value.product_picture+'" style="max-height: 250px; max-width: 250px;">'+'</td>'+
                                  '<td><a href="edit-menu/'+value.id+'" class="btn btn-warning"><i class="fas fa-edit"></i></a>&nbsp;<a href="menu/delete/'+value.id+'" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>'
                                  +'</tr>')
                            });

                        }
                    })
                });

            });
        </script>

        {{-- <script src="{{ asset('something.js') }}"></script> --}}
    @endpush
@endsection
