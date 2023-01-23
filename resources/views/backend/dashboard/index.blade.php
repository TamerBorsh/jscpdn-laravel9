@extends('backend.layouts.master')
@section('stylesheet')
    <style>
        .card-body {
            box-shadow: 0 0 12px rgb(0 0 0 / 8%);
            margin: 20px 0;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                    </div>
                </div>
            </div>
        </div>
  
        <div class="row">
            <div class="col-12">
                    <div class="card-body">

                        <div class="row">

                            <table class="table table-hover  table-centered mb-0">
                     
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
            </div>
        </div>

@auth('admin')
<div class="row">
    <div class="col-md-4">
        <div class="card-body text-center">
            <i class="fas fa-hotel" style="font-size: 24px;"></i>
            <h3><span>{{ $admin }}</span></h3>
            <p class="text-muted font-15 mb-0">البلديات</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-body text-center">
            <i class="fas fa-users" style="font-size: 24px;"></i>
            <h3><span>{{ $user }}</span></h3>
            <p class="text-muted font-15 mb-0">المشتركين</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-body text-center">
            <i class="fas fa-exclamation-circle" style="font-size: 24px;"></i>
            <h3><span>{{ $problem_count }}</span></h3>
            <p class="text-muted font-15 mb-0">الشكاوي</p>
        </div>
    </div>
</div>
@endauth



    </div>
@endsection
