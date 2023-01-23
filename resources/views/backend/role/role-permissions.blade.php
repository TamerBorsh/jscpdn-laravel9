@extends('backend.layouts.master')
@section('title')
    ربط الصلاحيات بالدور
@endsection
@section('stylesheet')
    <style>
        .form-group {
            display: inline-block;
            margin: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">الرئيسية</a></li>
                          
                        </ol>
                    </div>
                    <h4 class="page-title">ربط الدور بالصلاحيات</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table class="table table-hover text-nowrap">

                            @forelse ($permissions as $permission)
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="{{ $permission->id }}"
                                            onchange="update('{{ $role->id }}', '{{ $permission->id }}')"
                                            @if ($permission->assigned) checked="" @endif>
                                        <label for="{{ $permission->id }}"
                                            class="custom-control-label">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </table>

                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

    </div>
@endsection

@section('script')
    <script>
        function update(roleId, permissionId) {
            axios.put('/dashboard/roles/' + roleId + '/permissions', {
                permission_id: permissionId,
            }).then(function(response) {
                //   console.log(response);
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })
            }).catch(function(error) {
                // console.log(error);
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: error.response.data.message
                })
            })
        }
    </script>
@endsection
