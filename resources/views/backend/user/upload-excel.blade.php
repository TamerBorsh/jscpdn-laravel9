@extends('backend.layouts.master')
@section('stylesheet')
    <style>
        .alert-dismissible .btn-close {
            left: 0;
            right: auto;
        }

        .alert-dismissible {
            padding-right: 20px;
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
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">المشتركين<i
                                        class="dripicons-chevron-left"></i></a></li>
                            <li class="breadcrumb-item">استيراد ملف</li>
                        </ol>
                    </div>
                    <h4 class="page-title">استيراد ملف اكسل</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <form action="{{ route('users.import.excel') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                @error('attachment')
                                    <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show"
                                        role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @enderror
                                <div class="col-md-12">
                                    <label class="attachment">استيراد الملف</label>
                                    <input class="form-control" type="file" id="attachment" name="attachment">
                                </div>


                                <button type="submit" class="btn btn-primary"
                                    style=" margin-top: 20px; padding: 6px 25px; ">استيراد</button>
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
