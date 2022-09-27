@extends('vh::master')
@section('content')
    <div class="container-fluid site-wrap" data-menu="off">
        <style type="text/css">
            .col-mar-0 {
                margin-left: 0px;
                margin-right: 0px;
            }
            .col-mar-0 > div[class^="col-"] {
                padding-left: 0px;
                padding-right: 0px;
            }
            .col-mar-5 {
                margin-left: -5px;
                margin-right: -5px;
            }
            .col-mar-5 > div[class^="col-"] {
                padding-left: 5px;
                padding-right: 5px;
            }
            .col-mar-8 {
                margin-left: -8px;
                margin-right: -8px;
            }
            .col-mar-8 > div[class^="col-"] {
                padding-left: 8px;
                padding-right: 8px;
            }
            .col-mar-10 {
                margin-left: -10px;
                margin-right: -10px;
            }
            .col-mar-10 > div[class^="col-"] {
                padding-left: 10px;
                padding-right: 10px;
            }
            .root {
                background: #f9f9f9;
            }
            .dashboard-statistics {
                color: #333333;
                margin-bottom: 20px;
            }
            .dashboard-statistics .big-title {
                font-size: 20px;
            }
            .dashboard-statistics .overview .item-over-view,
            .dashboard-statistics .item-total {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: start;
                align-items: center;
                justify-content: space-between;
                -webkit-transition: all 0.3s ease 0s;
                -moz-transition: all 0.3s ease 0s;
                -ms-transition: all 0.3s ease 0s;
                -o-transition: all 0.3s ease 0s;
                transition: all 0.3s ease 0s;
                border-radius: 5px;
                margin-bottom: 15px !important;
                padding: 8px !important;
                position: relative;
                z-index: 2;
                background-color: #fff !important;
                box-shadow: 0px 1px 5px 1px #ddd !important;
            }
            .dashboard-statistics .overview .item-over-view:hover,
            .dashboard-statistics .item-total:hover {
                background-color: #fefefe !important;
                box-shadow: 0px 1px 10px 1px #ddd !important;
            }
            .dashboard-statistics .overview .item-over-view .icon,
            .dashboard-statistics .item-total .icon {
                -webkit-transition: all 0.8s ease 0s;
                -moz-transition: all 0.8s ease 0s;
                -ms-transition: all 0.8s ease 0s;
                -o-transition: all 0.8s ease 0s;
                transition: all 0.8s ease 0s;
                font-size: 26px;
                width: 50px;
                border-radius: 50%;
                color: white;
                height: 50px;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: start;
                align-items: center;
                justify-content: center;
                opacity: 0.8;
            }
            .dashboard-statistics .overview .item-over-view:hover .icon,
            .dashboard-statistics .item-total:hover .icon {
                transform: rotate(360deg);
                opacity: 1;
            }
            .dashboard-statistics .overview .item-over-view .content,
            .dashboard-statistics .item-total .content {
                padding-left: 15px;
                width: calc(100% - 58px);
                border-left: solid 1px #e1e1e1;
            }
            .dashboard-statistics .overview .item-over-view .name,
            .dashboard-statistics .item-total .name {
                margin-bottom: 5px;
                font-size: 16px;
                font-family: Robob;
            }
            .dashboard-statistics .overview .item-over-view a,
            .dashboard-statistics .item-total a {
                -webkit-transition: all 0.8s ease 0s;
                -moz-transition: all 0.8s ease 0s;
                -ms-transition: all 0.8s ease 0s;
                -o-transition: all 0.8s ease 0s;
            }
            .dashboard-statistics .overview .item-over-view a:hover,
            .dashboard-statistics .item-total a:hover {
                color: #fcaf17;
            }
            .dashboard-statistics .list-total-posts {
                margin-top: 15px;
                box-shadow: 0px 1px 5px 1px #ddd !important;
                background: #ffffff;
            }
            .dashboard-statistics .header-list {
                padding: 35px 15px;
                background-color: #428bca !important;
                color: white;
                font-size: 20px;
                border-radius: 5px 5px 0px 0px;
                font-family: Robob;
                text-align: center;
            }
            .dashboard-statistics .list-total {
                padding: 0px 20px 20px 20px;
                position: relative;
            }
            .dashboard-statistics .list-total:before {
                content: "";
                position: absolute;
                width: 100%;
                height: 30px;
                left: 0;
                right: 0;
                background-color: #428bca !important;
            }
            .dashboard-statistics .item-total {
                box-shadow: none !important;
                border: solid 1px #ddd;
            }
            .dashboard-statistics .item-total .icon {
                font-size: 22px;
                width: 45px;
                height: 45px;
            }
            .dashboard-statistics .item-total:hover {
                box-shadow: none !important;
            }
            .dashboard-statistics .list-user-box {
                margin-top: 15px;
                box-shadow: 0px 1px 5px 1px #ddd !important;
                background: #ffffff;
            }
            .header-list-user {
                padding: 8px 15px;
                background: #f9f9f9;
                font-size: 22px;
                border-bottom: solid 1px #ddd;
            }
            .all-table-statiscal {
                width: 100%;
                font-size: 14px;
            }
            .all-table-statiscal th {
                position: sticky;
                top: 0;
                background: #343a40 !important;
                color: #f8f9fa !important;
                padding: 8px 10px;
                white-space: nowrap;
                font-size: 16px;
                border: solid 1px #343a40;
                text-align: left;
            }
            .all-table-statiscal th:not(:last-child) {
                border-right: solid 1px #f9f9f9;
            }
            .all-table-statiscal td {
                padding: 6px 10px;
                text-align: left;
                vertical-align: middle !important;
            }
            .all-table-statiscal td {
                -webkit-transition: all 0.3s ease 0s;
                -moz-transition: all 0.3s ease 0s;
                -ms-transition: all 0.3s ease 0s;
                -o-transition: all 0.3s ease 0s;
                transition: all 0.3s ease 0s;
                border-right: solid 1px #8888;
                border-bottom: solid 1px #8888;
            }
            .all-table-statiscal td:first-child {
                border-left: solid 1px #8888;
            }
            .all-table-statiscal span {
                display: inline-block;
                padding: 1px 6px;
                border-radius: 3px;
                background: #ebebeb;
            }
            .all-table-statiscal span.success {
                color: white;
                background: #28a745 !important;
            }
            .all-table-statiscal span.fail {
                color: white;
                background: #dc3545 !important;
            }
            .all-table-statiscal .active_point {
                background: yellow;
            }
            .img-user {
                width: 35px;
                height: 35px;
                display: inline-block;
                margin-right: 5px;
                border-radius: 5px;
                overflow: hidden;
                vertical-align: middle;
                box-shadow: 0px 1px 3px 1px rgba(0, 0, 0, 0.1);
            }
            .img-user img {
                max-width: 100%;
                object-fit:contant;
            }
            .table-list-user {
                overflow: auto;
                height: 347px;
                position: relative;
            }
            .scrollstyle::-webkit-scrollbar-track {
                background-color: #f7f7f7;
                height: 6px;
                width: 6px;
            }
            .scrollstyle::-webkit-scrollbar {
                background-color: #2891cc;
                margin: 6px;
                height: 6px;
                width: 6px;
            }
            .scrollstyle::-webkit-scrollbar-thumb {
                background-color: #2891cc;
                border-radius: 3px;
                width: 6px;
            }
        </style>
        <div class="dashboard-statistics">
            <div class="overview">
                <p class="big-title" style="margin-bottom:12px">Tổng quan</p>
                <div class="row">
                    <div class="col-xs-6 col-lg-3">
                        <div class="item-over-view">
                            <div class="icon" style="background-color:#46be8a !important">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                                <p class="name">{{\DB::table('orders')->where('order_type_id',App\Models\OrderType::ORDER_COURSE)->count()}}</p>
                                <a href="esystem/view/order_video_lectures" class="smooth" title="Đăng kí khóa học mới">Đơn hàng đăng ký khóa học và nâng cấp vip hôm nay</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-3">
                        <div class="item-over-view">
                            <div class="icon" style="background-color:#ffa615 !important">
                                <i class="fa fa-commenting-o" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                                <p class="name">0</p>
                                <a href="esystem/search/comments?raw_content=&amp;raw_user_id=&amp;raw_map_table=video_lectures&amp;orderkey=id&amp;ordervalue=desc&amp;limit=20" class="smooth" title="Bình luận khóa học mới">Bình luận khóa học mới</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-3">
                        <div class="item-over-view">
                            <div class="icon" style="background-color:#1b74e4 !important">
                                <i class="fa fa-comments-o" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                                <p class="name">0</p>
                                <a href="esystem/search/comments?raw_content=&amp;raw_user_id=&amp;raw_map_table=videos&amp;orderkey=id&amp;ordervalue=desc&amp;limit=20" class="smooth" title="Bình luận video mới">Bình luận chi tiết video mới</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-3">
                        <div class="item-over-view">
                            <div class="icon" style="background-color:#17a2b8 !important">
                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                                <p class="name">1</p>
                                <a href="esystem/view/subscribes" class="smooth" title="Đăng ký tư vấn mới">Đăng ký tư vấn mới</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-lg-5">
                    <div class="list-total-posts">
                        <div class="header-list">
                            <p>Tổng số bài đăng</p>
                        </div>
                        <div class="list-total">
                            <div class="row col-mar-8">
                                <div class="col-xs-6">
                                    <div class="item-total">
                                        <div class="icon" style="background-color:#dc3545">
                                            <i class="fa fa-video-camera"></i>
                                        </div>
                                        <div class="content">
                                            <p class="name">4</p>
                                            <a href="esystem/view/video_lectures" class="smooth">Video bài giảng</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="item-total">
                                        <div class="icon" style="background-color:#ffb1ba">
                                            <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="content">
                                            <p class="name">21</p>
                                            <a href="esystem/view/videos" class="smooth">Videos</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="item-total">
                                        <div class="icon" style="background-color:#0087ff">
                                            <i class="fa fa-gamepad"></i>
                                        </div>
                                        <div class="content">
                                            <p class="name">43</p>
                                            <a href="esystem/view/learning_plays" class="smooth">Đề bài học mà chơi</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="item-total">
                                        <div class="icon" style="background-color:#428bca ">
                                            <i class="fa fa-file-text"></i>
                                        </div>
                                        <div class="content">
                                            <p class="name">27</p>
                                            <a href="esystem/view/documents" class="smooth">Tài liệu</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="item-total">
                                        <div class="icon" style="background-color:#aea8a8">
                                            <i class="fa fa-newspaper-o"></i>
                                        </div>
                                        <div class="content">
                                            <p class="name">{{\DB::table('news')->count()}}</p>
                                            <a href="esystem/view/news" class="smooth">Tin tức</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-7">
                    <div class="list-user-box">
                        <div class="header-list-user">
                            <span>Tổng số tài khoản giáo viên: <strong>{{\DB::table('users')->where('user_type_id',2)->count()}}</strong> tài khoản.</span>
                        </div>
                        <div class="header-list-user">
                            <span>Tổng số tài khoản học sinh: <strong>{{\DB::table('users')->where('user_type_id',1)->count()}}</strong> tài khoản.</span>
                        </div>
                        <?php 
                            $listUserVip = App\Models\User::whereHas('userCourseCombo',function($q){
                                $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
                            })->with(['userCourseCombo'=>function($q){
                                $q->where('expired_time','>',now());
                            }])->get();
                        ?>
                        <div class="list-user">
                            <p style="font-size:18px;padding: 10px 15px;">Tài khoản vip: <strong>{{count($listUserVip ?? [])}}</strong> tài khoản.</p>
                        </div>
                        <div class="table-list-user scrollstyle">
                            <table class="table table-bordered table-hover all-table-statiscal">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">STT</th>
                                        <th>Tên</th>
                                        <th>Tên đăng nhập</th>
                                        <th>Ngày Vip còn lại</th>
                                        <th>Đã tham gia</th>
                                        <th style="text-align:center">Cộng Vip</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listUserVip as $k => $itemUserVip)
                                    <tr>
                                        <td style="text-align:center"><strong>{{$k+1}}</strong></td>
                                        <td style="padding:1px 6px">
                                            <div class="img-user">
                                                @if (Support::show($itemUserVip, 'img'))
                                                    @include('image_loader.tiny', ['keyImage' => 'img', 'itemImage' => $itemUserVip])
                                                @else
                                                    @include('image_loader.config.tiny', ['config_key' => 'logo'])
                                                @endif
                                            </div>
                                            {{Support::show($itemUserVip,'name')}}
                                        </td>
                                        {{-- <?php 
                                            $userCourseCombo = $itemUserVip->userCourseCombo->first();
                                            $expirationDate = \Carbon\Carbon::createFromDate($userCourseCombo->expired_time);
                                        ?>
                                        <td>{{Support::show($itemUserVip,'phone')}}</td>
                                        <td>
                                            <strong>{{$expirationDate->diffInDays(now())}}</strong> ngày
                                        </td>
                                        <td><strong></strong> ngày</td>
                                        <td style="text-align:center"><a href="esystem/add-vip/users/1" class="btn btn-info"><i class="fa fa-plus-square" aria-hidden="true"></i></a></td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @if (isset($gaViewKey) && $gaViewKey !='')
        @include('vh::statistical_google_analytics')
    @else
        <p>Xin chào <strong>{{Auth::guard('h_users')->user()->name}}</strong></p>
    @endif --}}
@stop