@extends('backend.layouts.master')
@section('title')
    عرض الشكاوي | مجلس الخدمات المشترك للتخطيط والتطوير في محافظة شمال غزة
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
                            <li class="breadcrumb-item"><a href="{{ route('problems.index') }}">الشكاوي</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">عرض الشكاوي</h4>
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
                                    @auth('admin')
                                        <form action="" method="get">

                                            <div class="col-md-12 mb-3">
                                                <input type="search" class="form-control" name="search"
                                                    placeholder="ابحث هنا ثم اضغط انتر" value="{{ request('search') }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <select class="form-select" name="status">
                                                    <option value="">الحالة</option>
                                                    <option value="1" @selected(request('status') == '1')>جديد</option>
                                                    <option value="2" @selected(request('status') == '2')>مستلم</option>
                                                    <option value="3" @selected(request('status') == '3')>قيد المعالجة
                                                    </option>
                                                    <option value="4" @selected(request('status') == '3')>تمت المعالجة
                                                    </option>
                                                    <option value="5" @selected(request('status') == '3')>مرفوض</option>
                                                    <option value="6" @selected(request('status') == '4')>لا يوجد مشكلة
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <select class="form-select" id="category" name="category">
                                                    <option value="">التصنيف</option>
                                                    <option value="1" @selected(request('category') == '1')>شكوى</option>
                                                    <option value="2" @selected(request('category') == '2')>اقتراح</option>
                                                    <option value="4" @selected(request('category') == '3')>استفسار</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <select class="form-select" id="importance" name="importance">
                                                    <option value="">مدى الأهمية</option>
                                                    <option value="1" @selected(request('importance') == '1')>عادي</option>
                                                    <option value="2" @selected(request('importance') == '2')>هام</option>
                                                    <option value="3" @selected(request('importance') == '3')>هام جدا</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <button type="submit" class="btn btn-primary"
                                                    style=" width: 100%; ">بحث</button>
                                            </div>
                                        </form>
                                    @endauth
                                    @auth('web')
                                        <div class="col-md-12">
                                            <a href="{{ route('problems.create') }}" class="btn btn-success"
                                                style=" float: left; ">أضف جديد</a>

                                        </div>
                                    @endauth

                                </div>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>عنوان الطلب</th>
                                        <th>الجهة المختصة</th>
                                        <th>حالة الطلب</th>
                                        <th>التصنيف</th>
                                        <th>تاريخ التقديم</th>
                                        @auth('web')
                                            <th>التفاصيل</th>
                                        @endauth
                                        @auth('admin')
                                            <th>رقم الاتصال</th>
                                            <th>التحكم</th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($problems as $problem)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Str::limit($problem->title, 40, '...') }}</td>
                                            <td>{{ $problem->admin->name }}</td>
                                            <td><span
                                                    @if ($problem->State == 'جديد') class="badge bg-info" style=" padding: 0.5em; " 
                                                    @elseif ($problem->State == 'مستلم') class="badge bg-primary" style=" padding: 0.5em; " 
                                                    @elseif ($problem->State == 'قيد المعالجة') class="badge badge-info-lighten" style=" padding: 0.5em; "   
                                                    @elseif ($problem->State == 'تمت المعالجة') class="badge bg-success" style=" padding: 0.5em; "   
                                                    @else class="badge bg-danger" style=" padding: 0.5em; " @endif>{{ $problem->State }}</span>
                                            </td>
                                            <td>{{ $problem->categories }}</td>
                                            <td>{{ $problem->created_at->format('d-m-Y') }}</td>
                                            @auth('web')
                                                <td class="table-action" data-id="{{ $problem->id }}">
                                                    <span class="dtr-data">
                                                        <a href="{{ route('problems.show', $problem->id) }}"
                                                            class="action-icon">
                                                            <i class="fas fa-eye"></i>
                                                    </span>
                                                </td>
                                            @endauth
                                            @auth('admin')
                                                <td>{{ $problem->user->mobile }}</td>
                                                <td class="table-action" data-id="{{ $problem->id }}">
                                                    <span class="dtr-data">
                                                        <a href="{{ route('problems.edit', $problem->id) }}"
                                                            class="action-icon">
                                                            <i class="fas fa-reply"></i></a>
                                                        <a href="javascript:void(0);" class="action-icon" id="deleteRow"
                                                            data-id="{{ $problem->id }}"> <i class="mdi mdi-delete"></i></a>
                                                    </span>
                                                </td>
                                            @endauth
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {!! $problems->withQueryString()->links() !!}
                </div>
            </div>
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
                    axios.delete('/dashboard/problems/' + id)
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
