@extends('backend.layouts.master')
@section('title')
    أضف جديد
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
                            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">الأدوار<i
                                        class="dripicons-chevron-left"></i></a></li>
                            <li class="breadcrumb-item">أضف جديد</li>
                        </ol>
                    </div>
                    <h4 class="page-title">أضف دور جديد</h4>
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
                                @method('post')

                                <div class="col-md-12">
                                    <div class="row g-2">
                                        <div class="mb-3 col-md-12">
                                            <label for="name" class="form-label">الاسم</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>


                                    </div>


                                </div>

                                <button type="submit" class="btn btn-primary" id="btnSubmit"
                                    style=" margin-top: 20px; padding: 6px 25px; ">حفظ</button>
                            </form>
                        </div>
                        <!-- end row -->

                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

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
                    url: "{{ route('roles.store') }}",
                    data: formData
                })
                .then(function(response) {
                    $('#addDataForm').trigger("reset");
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
