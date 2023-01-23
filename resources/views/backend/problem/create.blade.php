@extends('backend.layouts.master')
@section('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css"
        integrity="sha512-ZbehZMIlGA8CTIOtdE+M81uj3mrcgyrh6ZFeG33A4FHECakGrOsTPlPQ8ijjLkxgImrdmSVUHn1j+ApjodYZow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .note-editor.note-frame {
            direction: ltr;
            text-align: center;
            background: white;
        }

        .note-editor .note-toolbar .note-color-all .note-dropdown-menu,
        .note-popover .popover-content .note-color-all .note-dropdown-menu {
            min-width: 350px;
        }

        .note-editable {
            min-height: 100px;
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">الرئيسية<i
                                        class="dripicons-chevron-left"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('problems.index') }}">الشكاوي<i
                                        class="dripicons-chevron-left"></i></a></li>
                            <li class="breadcrumb-item">أضف جديد</li>
                        </ol>
                    </div>
                    <h4 class="page-title">أضف جديد</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="table  table-centered mb-0">
                        <tr>
                            <td>الإسم: {{ auth()->user()->name }}</td>
                            <td>رقم الهوية: {{ auth()->user()->id_number }}</td>
                            <td>رقم الجوال: {{ auth()->user()->mobile }}</td>
                            <td>العنوان: {{ auth()->user()->address }}</td>
                        </tr>
                    </table>
                    <div class=" col-md-12 alert alert-primary text-center p-2">
                        بيانات الطلب
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form id="addDataForm" action="" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">الموضوع</label>
                                        <input type="text" class="form-control" id="title" name="title">
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="admin_id" class="form-label">الجهة المختصة</label>
                                            <select class="form-select" id="admin_id" name="admin_id">
                                                @forelse ($admins as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="category" class="form-label">التصنيف</label>
                                            <select class="form-select" id="category" name="category">
                                                <option value="1">شكوى</option>
                                                <option value="2">اقتراح</option>
                                                <option value="3">استفسار</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-sm-6 mb-3">
                                            <label for="number_call" class="form-label">رقم الاتصال</label>
                                            <input type="number" class="form-control" id="number_call" name="number_call">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="photo_main" class="form-label">مرفقات</label>
                                            <input class="form-control" type="file" id="photo_main" name="photo_main">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <label for="content" class="form-label">نص الطلب</label>
                                            <textarea class="form-control" id="content" name="content" rows="5"></textarea>
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
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"
        integrity="sha512-lVkQNgKabKsM1DA/qbhJRFQU8TuwkLF2vSN3iU/c7+iayKs08Y8GXqfFxxTZr1IcpMovXnf2N/ZZoMgmZep1YQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {
            // Summernote
            $('#content').summernote()
        })

        //create
        $("#addDataForm").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#addDataForm')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('problems.store') }}",
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
