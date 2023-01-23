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
                            <li class="breadcrumb-item">تفاصيل الشكوى</li>
                        </ol>
                    </div>
                    <h4 class="page-title">تفاصيل الشكوى</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="table  table-centered mb-0">
                        <tr>
                            <td>الإسم: {{ $problem->user->name }}</td>
                            <td>رقم الهوية: {{ $problem->user->id_number }}</td>
                            <td>رقم الاشتراك: {{ $problem->user->subscription_number }}</td>
                            <td>رقم الجوال: {{ $problem->user->mobile }}</td>
                            <td>العنوان: {{ $problem->user->address }}</td>
                        </tr>
                    </table>
                    <div class=" col-md-12 alert alert-primary text-center p-2">
                        بيانات الطلب
                    </div>


                    <div class="card-body">

                        <div class="row">

                            <form id="addDataForm" action="" method="" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="col-md-12">

                                    <div class="mb-3">
                                        <label for="title" class="form-label">الموضوع</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ $problem->title }}" disabled>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="admin_id" class="form-label">الجهة المختصة</label>
                                            <select class="form-select" id="admin_id" name="admin_id" disabled>
                                                @forelse ($admins as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $problem->admin_id ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="number_call" class="form-label">رقم الاتصال</label>
                                            <input type="number" class="form-control" id="number_call" name="number_call"
                                                value="{{ $problem->number_call }}" disabled>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="category" class="form-label">التصنيف</label>
                                            <select class="form-select" id="category" name="category" disabled>
                                                <option value="1" @if ($problem->category == '1') selected @endif>
                                                    شكوى</option>
                                                <option value="2" @if ($problem->category == '2') selected @endif>
                                                    اقتراح</option>
                                                <option value="3" @if ($problem->category == '3') selected @endif>
                                                    استفسار</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <label for="content" class="form-label">نص الطلب</label>
                                            <textarea class="form-control" id="content" name="content" rows="5" disabled>{!! $problem->content !!}</textarea>
                                        </div>
                                    </div>

                                    @if ($problem->photo)
                                        <div class=" col-md-12 alert alert-primary text-center p-2"
                                            style=" margin-bottom: 10px; ">
                                            مرفقات
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="card m-1 shadow-none border">
                                                <div class="p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar-sm">
                                                                <span class="avatar-title bg-light text-secondary rounded">
                                                                    <img src="{{ asset('images/uploads/problems/' . $problem->photo) }}"
                                                                        style=" width: 100%; height: 100%; border-radius: 50px; ">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-0">
                                                            <a href="{{ asset('images/uploads/problems/' . $problem->photo) }}"
                                                                target="_blank" class="text-muted fw-bold">اضغط هنا لفتح
                                                                الصورة</a>
                                                        </div>
                                                    </div> <!-- end row -->
                                                </div> <!-- end .p-2-->
                                            </div> <!-- end col -->
                                        </div>
                                    @endif

                                </div>
                                @auth('admin')
                                <div class=" col-md-12 alert alert-primary text-center p-2" style=" margin-bottom: 10px; ">
                                    الرد
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">تحديث الحالة</label>
                                        <select class="form-select" name="status">
                                            <option value="1" @if ($problem->status == '1') selected @endif>
                                                جديد</option>
                                            <option value="2" @if ($problem->status == '2') selected @endif>
                                                مستلم</option>
                                            <option value="3" @if ($problem->status == '3') selected @endif>قيد
                                                المعالجة</option>
                                            <option value="4" @if ($problem->status == '4') selected @endif>تمت
                                                المعالجة</option>
                                            <option value="5" @if ($problem->status == '5') selected @endif>
                                                مرفوض</option>
                                            <option value="6" @if ($problem->status == '6') selected @endif>
                                                لا
                                                يوجد مشكلة</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="importance" class="form-label">مدى الأهمية</label>
                                        <select class="form-select" id="importance" name="importance">
                                            <option value="1" @if ($problem->importance == '1') selected @endif>
                                                عادي</option>
                                            <option value="2" @if ($problem->importance == '2') selected @endif>
                                                هام
                                            </option>
                                            <option value="3" @if ($problem->importance == '3') selected @endif>
                                                هام
                                                جدا</option>
                                        </select>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <label for="reply" class="form-label">الرد</label>
                                            <textarea class="form-control" id="reply" name="reply" rows="3">{{ $problem->reply }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            @endauth

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
                url: "{{ route('problems.update', $problem->id) }}",
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
