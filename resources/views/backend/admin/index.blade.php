@extends('backend.layouts.master')
@section('stylesheet')
    <style>

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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">الرئيسية<i
                                        class="dripicons-chevron-left"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">البلديات</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">عرض البلديات</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <table class="table table-hover  table-centered mb-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <form action="" method="get">
                                            <div class="input-group mb-3">
                                                <?php
                                                if (isset($_GET['search'])) {?>
                                                <input type="search" name="search" id="search" class="form-control"
                                                    value="<?php echo $_GET['search']; ?>" />
                                                <?php }else{?>
                                                <input type="search" name="search" id="search" class="form-control"
                                                    placeholder="ابحث هنا ثم اضغط انتر" />
                                                <?php }
                                                ?>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-md-8">
                                        <a href="{{ route('admins.create') }}" class="btn btn-success"
                                            style=" float: left; ">أضف جديد</a>

                                    </div>
                                </div>

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الشعار</th>
                                        <th>الاسم</th>
                                        <th>الايميل</th>
                                        <th>أنشئ في</th>
                                        <th>التحكم</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($admins as $admin)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="table-user">
                                                @if ($admin->photo)
                                                    <img src="{{ asset('images/uploads/users/' . $admin->photo) }}"
                                                        alt="user-avatar" class="me-2 rounded-circle">
                                                @else
                                                    <img src="{{ asset('images/uploads/users/user.png') }}" alt="user-avatar"
                                                        class="me-2 rounded-circle">
                                                @endif
                                            </td>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
           
                                            <td>{{ $admin->created_at->format('d-m-Y') }}</td>

                                            <td class="table-action" data-id="{{ $admin->id }}">
                                                <span class="dtr-data">
                                                    <a href="{{ route('admins.edit', $admin->id) }}" class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i></a>
                                                    <a href="javascript:void(0);" class="action-icon" id="deleteRow"
                                                        data-id="{{ $admin->id }}"> <i class="mdi mdi-delete"></i></a>
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                        <!-- end row -->

                    </div> <!-- end card-body -->
                    {{ $admins->links() }}
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

    </div>
@endsection

@section('script')
    <script>
        //delete
        $('body').on('click', '#deleteRow', function(e) {
            e.preventDefault();
            let id = $(this).data('id')
            Swal.fire({
                title: 'هل أنت واثق؟',
                text: "لن تتمكن من التراجع عن هذا!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم ، احذفها!',
                cancelButtonText: 'إلغاء',

            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('tr').remove();
                    axios.delete('/dashboard/admins/' + id)
                        .then(function(response) {
                            // console.log(response);
                            showMessage(response.data);
                        }).catch(function(error) {
                            // console.log(error);
                            showMessage(error.response.data);
                        })
                }
            });

            function showMessage(data) {
                Swal.fire({
                    position: 'top-end',
                    icon: data.icon,
                    title: data.title,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        });
    </script>
@endsection
