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
                        <h1>Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard', ['slug' => Auth::user()->role])}}">Admin</a></li>
                            <li class="breadcrumb-item active">Orders</li>
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
                        <select name="restaurant_id" id="restaurant_id" class="form-control"  data-live-search="true" aria-label="Select Restaurant">
                          <option value="">Select Your Restaurant</option>
                          @foreach ($restaurants as $restaurant)
                            <option value="{{$restaurant->id}}">{{$restaurant->restaurant_name}}</option> 
                            @endforeach                   
                            </select> 
                        @error('restaurant_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                    {{-- @if (!empty($menus[0]['id'])) --}}
                        <table class="table table-bordered table-hover table-responsive-xl">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 12px">Order Number</th>
                                    <th style="width: 10px"><center>Table No</center></th>
                                    <th style="width: 10px">Total Quantity</th>
                                    <th>Total Price</th>
                                    <th>Time & Date</th>
                                    <th>Status</th>
                                    {{-- <th>Experience</th>
                                <th>Salary</th>
                                <th>Vacation</th>
                                <th>City</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="order-row">
                               
                            </tbody>
                        </table>
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
                    $('#menu-row').empty();
                    // var url = '{{route("search_menu", ["id" =>'id'])}}'
                    var url = '{{ route("orderById",":id") }}';
                    url = url.replace(':id', id);
                    console.log(url);
                    // var firstDropVal = $('#').val();
                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: {},
                        dataType: 'json',
                        success: function(data) {
                          console.log(data);
                            $.each(data, function(key, value) {
                              console.log(data);
                              // '<td>'+value.menu_name'</td>'+'<td>'+value.menu_description'</td>'+'<td>'+value.menu_description'</td>'
                              
                                $('#order-row').append('<tr><td>'+value.id+'</td>'+'<td>'+value.order_number+'</td>'+'<td style="max-width: 250px;">'+value.table_number+'</td>'+'<td>'+
                                    value.totalQty+'</td>'+'<td>'+value.total_amount+'</td>'+'<td>'+value.created_at+'</td>'+'<td>'+value.status+'</td>'+
                                  '<td><a href="order-details/'+value.id+'" class="btn btn-warning"><i class="fas fa-eye"></i></a>&nbsp;<a id="delete_button" href="delete-menu/'+value.id+'" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>'
                                  +'</tr>')
                            });

                        }
                    })
                });

                $("#delete_button").click(function() {
                    confirm('Are you sure you want to delete this menu? All products under this menu will be gone!');
                });

            });
        </script>

        {{-- <script src="{{ asset('something.js') }}"></script> --}}
    @endpush
@endsection
