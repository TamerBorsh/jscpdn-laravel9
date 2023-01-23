@extends('backend.layouts.master')
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

                            <li class="breadcrumb-item">تعديل البروفايل</li>
                        </ol>
                    </div>
                    <h4 class="page-title">تعديل البروفايل</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
             
                        @if (!auth()->user()->photo)
                        <img src="{{ asset('images/uploads/users/user.png') }}" alt="user-image"
                            class="rounded-circle avatar-lg img-thumbnail">
                    @else
                        <img src="{{ asset('images/uploads/users/' . auth()->user()->photo) }}" alt="user-image"
                            class="rounded-circle avatar-lg img-thumbnail">
                    @endif

                        <h4 class="mb-0 mt-2">{{ auth()->user()->name }}</h4>
                        <p class="text-muted font-14">{{ auth()->user()->name }}</p>

                        <div class="text-end mt-3">

                            <p class="text-muted mb-2 font-13"><strong>الاسم : </strong> <span
                                    class="ms-2">{{ auth()->user()->name }}</span></p>

                            <p class="text-muted mb-2 font-13"><strong>البريد الالكتروني</strong> <span
                                    class="ms-2 ">{{ auth()->user()->email }}</span></p>
                            </p>
                            <p class="text-muted mb-2 font-13"><strong>رقم الاتصال : </strong><span
                                    class="ms-2">{{ auth()->user()->mobile }}</span></p>
                            <p class="text-muted mb-2 font-13"><strong>رقم الهوية : </strong><span
                                    class="ms-2">{{ auth()->user()->id_number }}</span></p>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->

            </div> <!-- end col-->

            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="prorle_user">
                                <form id="addDataForm" action="" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="col-md-12">
                                        <div class="row">
                                            <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="name" class="form-label">الاسم</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ auth()->user()->name }}" disabled>
                                            </div>
                                            @auth('web')
                                                <div class="mb-2 col-md-6">
                                                    <label for="id_number" class="form-label">رقم الهوية</label>
                                                    <input type="number" class="form-control" id="id_number" name="id_number"
                                                        value="{{ auth()->user()->id_number }}" disabled>
                                                </div>
                                            @endauth
                                            <div class="mb-2 col-md-6">
                                                <label for="email" class="form-label">الايميل</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ auth()->user()->email }}" disabled>
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="mobile" class="form-label">رقم الجوال</label>
                                                <input type="number" class="form-control" id="mobile" name="mobile"
                                                    value="{{ auth()->user()->mobile }}">
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="password" class="form-label">كلمة المرور</label>
                                                <input type="password" class="form-control" id="password" name="password">
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="password" class="form-label">تأكيد كلمة المرور</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation">
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-sm-12">
                                                <label class="form-label">الصورة الشخصية</label>
                                                <input class="form-control" type="file" id="photo_main"
                                                    name="photo_main">
                                                @if (auth()->user()->photo)
                                                    <a href="{{ asset('images/uploads/users/' . auth()->user()->photo) }}"
                                                        target="_blank" rel="noopener noreferrer">
                                                        <img src="{{ asset('images/uploads/users/' . auth()->user()->photo) }}"
                                                            class="img-thumbnail"
                                                            style=" width: 80px; margin: 10px 0; "></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="btnSubmit"
                                        style=" margin-top: 20px; padding: 6px 25px; ">حفظ</button>
                                </form>
                            </div>
                        </div> <!-- end tab-content -->
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
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
                    url: "{{ route('users.update_profile', auth()->user()->id) }}",
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
