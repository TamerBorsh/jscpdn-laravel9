@extends('backend.layouts.master')
@section('stylesheet')
    <style>
        .link a {
            float: left;
            margin-right: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">الرئيسية<i
                                        class="dripicons-chevron-left"></i></a></li>
                            <li class="breadcrumb-item">المشتركين</li>
                        </ol>
                    </div>
                    <h4 class="page-title">عرض المشتركين</h4>
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
                                    <div class="col-md-5">
                                        <form action="" method="get">
                                            <div class="input-group mb-3">
                                                <input type="search" name="search" id="search" class="form-control"
                                                    value="{{ request('search') }}" placeholder="ابحث هنا ثم اضغط انتر" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-7 link">
                                        <a href="{{ route('users.create') }}" class="btn btn-success">أضف جديد</a>
                                        <a href="{{ route('users.export.excel') }}" class="btn btn-primary">تصدير اكسل</a>
                                        <a href="{{ route('users.upload.excel') }}" class="btn btn-info">استيراد اكسل</a>
                                    </div>
                                </div>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الصورة</th>
                                        <th>الاسم</th>
                                        <th>الهوية</th>
                                        <th>الايميل</th>
                                        <th>رقم الاتصال</th>
                                        <th>أنشئ في</th>
                                        <th>التحكم</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="table-user">
                                                @if ($user->photo)
                                                    <img src="{{ asset('images/uploads/users/' . $user->photo) }}"
                                                        alt="user-avatar" class="me-2 rounded-circle">
                                                @else
                                                    <img src="{{ asset('images/uploads/users/user.png') }}"
                                                        alt="user-avatar" class="me-2 rounded-circle">
                                                @endif
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->id_number }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                            <td class="table-action" data-id="{{ $user->id }}">
                                                <span class="dtr-data">
                                                    <a href="{{ route('users.edit', $user->id) }}" class="action-icon"> <i
                                                            class="mdi mdi-square-edit-outline"></i></a>
                                                    <a href="javascript:void(0);" class="action-icon" id="deleteRow"
                                                        data-id="{{ $user->id }}"> <i class="mdi mdi-delete"></i></a>
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    {!! $users->withQueryString()->links() !!}
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
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
                    axios.delete('/dashboard/users/' + id)
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
