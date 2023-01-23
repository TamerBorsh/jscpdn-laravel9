@extends('backend.layouts.master')
@section('stylesheet')
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
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">المشتركين<i
                                        class="dripicons-chevron-left"></i></a></li>
                            <li class="breadcrumb-item">تعديل بيانات</li>
                        </ol>
                    </div>
                    <h4 class="page-title">أضف مشترك جديد</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <form id="addDataForm" action="" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="name" class="form-label">الاسم</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">الدور</label>
                                                <select class="form-control select2bs4" id="role_id" name="role_id"
                                                    style="width: 100%;" aria-hidden="true">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            @if ($roleAdmin->id == $role->id) selected @endif>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="mb-2 col-md-6">
                                            <label for="id_number" class="form-label">رقم الهوية</label>
                                            <input type="number" class="form-control" id="id_number" name="id_number"
                                                value="{{ $user->id_number }}">
                                        </div>
                                        <div class="mb-2 col-md-6">
                                            <label for="email" class="form-label">الايميل</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}">
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="mb-2 col-md-6">
                                            <label for="password" class="form-label">كلمة المرور</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                        <div class="mb-2 col-md-6">
                                            <label for="mobile" class="form-label">رقم الجوال</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile"
                                                value="{{ $user->mobile }}">
                                        </div>
                                    </div>



                                    <div class="row g-2">
                                        <div class="mb-2  col-md-12">
                                            <label for="address" class="form-label">العنوان</label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                value="{{ $user->address }}">
                                        </div>
                                    </div>


                                    <div class="row g-2">
                                        <div class="col-sm-12">
                                            <label class="form-label">الصورة الشخصية</label>
                                            <input class="form-control" type="file" id="photo_main" name="photo_main"
                                                value="{{ $user->photo }}">
                                            @if ($user->photo)
                                                <a href="{{ asset('images/uploads/users/' . $user->photo) }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <img src="{{ asset('images/uploads/users/' . $user->photo) }}"
                                                        class="img-thumbnail" style=" width: 80px; margin: 10px 0; "></a>
                                            @endif

                                        </div>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary" id="btnSubmit"
                                    style=" margin-top: 20px; padding: 6px 25px; ">حفظ</button>
                            </form>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>
@endsection

@section('script')
    <script>
        //create
        $("#addDataForm").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#addDataForm')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('users.update', $user->id) }}",
                    data: formData
                })
                .then(function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    })
                })
                .catch(function(error) {
                    // console.log(error);
                    if (error.response.status == 422) {
                        var object = error.response.data.errors;
                        for (const key in object) {
                            var message = object[key][0]
                            break;
                        }
                        toastr.error(message);
                    } else {
                        toastr.error(error.response.data.message);
                    }
                });
        });
    </script>
@endsection
