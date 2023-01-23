@extends('backend.layouts.master')
@section('title')
    الأدوار
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
                            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">الأدوار</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">عرض الأدوار</h4>
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
                                        <a href="{{ route('roles.create') }}" class="btn btn-success"
                                            style=" float: left; ">أضف جديد</a>

                                    </div>
                                </div>

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>عدد الصلاحيات</th>
                                        <th>أنشئ في</th>
                                        <th>التحكم</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                              
                                            <td>{{ $role->name }}</td>
                                            <td><a href="{{ route('roles.show', $role->id) }}" class="btn btn-success">{{ $role->permissions_count }} :
                                                صلاحية</a></td>                                     
                                            <td>{{ $role->created_at->format('d-m-Y') }}</td>
                                            <td class="table-action" data-id="{{ $role->id }}">
                                                <span class="dtr-data">
                                                   
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                    <a href="javascript:void(0);" class="action-icon" id="deleteRow"
                                                        data-id="{{ $role->id }}"> <i class="mdi mdi-delete"></i></a>
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
                    {{ $roles->links() }}
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
                    axios.delete('/dashboard/roles/' + id)
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
