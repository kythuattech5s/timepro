@extends('vh::master')
@section('css')
    <link rel="stylesheet" href="admin/statical/css/daterangepicker.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="admin/statical/css/statical.css" type="text/css" media="screen" />
@stop
@section('content')
<div id="maincontent">
    <div class="admin-main-report">
        <div class="row d-flex flex-wrap gx-3">
            <div class="col-lg-6 mt-4">
                <div class="box-item">
                    <div class="title-header d-flex justify-content-center align-items-center flex-wrap">
                        <span>Tài khoản Giáo viên</span>
                    </div>
                    <div data-action="esystem/statical-user" data-type="{{App\Models\UserType::TEACHER_ACCOUNT}}" class="module-ajax-paginate">    
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-4">
                <div class="box-item">
                    <div class="title-header d-flex justify-content-center align-items-center flex-wrap">
                        <span>Tài khoản học viên nội bộ</span>
                    </div>
                    <div data-action="esystem/statical-user" data-type="{{App\Models\UserType::INTERNAL_STUDENT_ACCOUNT}}" class="module-ajax-paginate">    
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-4">
                <div class="box-item">
                    <div class="title-header d-flex justify-content-center align-items-center flex-wrap">
                        <span>Tài khoản học viên thường</span>
                    </div>
                    <div data-action="esystem/statical-user" data-type="{{App\Models\UserType::NORMAL_ACCOUNT}}" class="module-ajax-paginate">    
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-4">
                <div class="box-item">
                    <div class="title-header d-flex justify-content-center align-items-center flex-wrap">
                        <span>Khóa học</span>
                    </div>
                    <div data-action="esystem/statical-course" data-type="default" class="module-ajax-paginate">    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript" src="admin/statical/js/chart.min.js" defer></script>
    <script type="text/javascript" src="admin/statical/js/moment.min.js" defer></script>
    <script type="text/javascript" src="admin/statical/js/daterangepicker.js" defer></script>
    <script type="text/javascript" src="admin/statical/js/statical.js" defer></script>
@stop