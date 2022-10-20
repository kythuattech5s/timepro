@extends('vh::master')
@section('css')
    <link rel="stylesheet" href="admin/statical/css/daterangepicker.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="admin/statical/css/statical.css" type="text/css" media="screen" />
@stop
@section('content')
<div id="maincontent">
    <div class="admin-main-report">
        <p class="all-title text-center">Báo cáo tổng quan</p>
        <div class="row d-flex flex-wrap">
            <div class="col-xs-12 col-lg-6 mt-4">
                <div class="box-item pb-0">
                    <p class="title-header">Đơn hàng tháng {{now()->month.'/'.now()->year}}</p>
                    <div class="px-3 box-info-item">
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            </div>
                            <div class="content d-flex justify-content-between flex-wrap fs-16">
                                <p><span class="mr-1 d-inline-block" style="min-width: 130px;">Đơn hàng đã hoàn thành</span>:<strong>{{$infoOrderToday['orderToDayPass']['total']}} đơn</strong></p>
                                @if (isset($infoOrderToday['orderToDayPass']['link']))
                                    <a href="{{$infoOrderToday['orderToDayPass']['link']}}" class="admin-btn-all" style="margin: revert" target=_blank>Xem</a>
                                @endif
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </div>
                            <div class="content d-flex justify-content-between flex-wrap fs-16">
                                <p><span class="mr-1 d-inline-block" style="min-width: 130px;">Đơn hàng chưa hoàn thành</span>:<strong>{{$infoOrderToday['orderToDayWait']['total']}} đơn</strong></p>
                                @if (isset($infoOrderToday['orderToDayWait']['link']))
                                    <a href="{{$infoOrderToday['orderToDayWait']['link']}}" class="admin-btn-all" style="margin: revert" target=_blank>Xem</a>
                                @endif
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                            </div>
                            <div class="content d-flex justify-content-between flex-wrap fs-16">
                                <p><span class="mr-1 d-inline-block" style="min-width: 130px;">Đơn hàng bị hủy</span>:<strong>{{$infoOrderToday['orderToDayFail']['total']}} đơn</strong></p>
                                @if (isset($infoOrderToday['orderToDayFail']['link']))
                                    <a href="{{$infoOrderToday['orderToDayFail']['link']}}" class="admin-btn-all" style="margin: revert" target=_blank>Xem</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-6 mt-4">
                <div class="box-item pb-0">
                    <p class="title-header">Nguồn tiền</p>
                    <div class="px-3 box-info-item">
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            </div>
                            <div class="content d-flex justify-content-between flex-wrap fs-16">
                                <p><span class="mr-1 d-inline-block" style="min-width: 130px;">Số tiền đã nhận</span>:<strong>{{$revenueMonth['totalRevenuePaid']}}</strong></p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </div>
                            <div class="content d-flex justify-content-between flex-wrap fs-16">
                                <p><span class="mr-1 d-inline-block" style="min-width: 130px;">Số tiền đang chờ</span>:<strong>{{$revenueMonth['totalRevenueWait']}}</strong></p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                            </div>
                            <div class="content d-flex justify-content-between flex-wrap fs-16">
                                <p><span class="mr-1 d-inline-block" style="min-width: 130px;">Số tiền đã hủy:</span>:<strong>{{$revenueMonth['totalRevenueCancel']}}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-6 mt-4">
                <div class="box-item pb-0">
                    <p class="title-header">Thành viên trong hệ thống</p>
                    <div class="px-3 box-info-item">
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                            <div class="content fs-16">
                                <span class="mr-1 d-inline-block" style="min-width: 160px;">Tổng số thành viên</span>:<strong>{{$listUserInfo['totalUser']}}</strong>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                            </div>
                            <div class="content fs-16">
                                <span class="mr-1 d-inline-block" style="min-width: 160px;">Số giáo viên</span>:<strong>{{$listUserInfo['totalUserTeacher']}}</strong>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-user-times" aria-hidden="true"></i>
                            </div>
                            <div class="content fs-16">
                                <span class="mr-1 d-inline-block" style="min-width: 160px;">Số học viên nội bộ</span>:<strong>{{$listUserInfo['totalUserInternal']}}</strong>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </div>
                            <div class="content fs-16">
                                <span class="mr-1 d-inline-block" style="min-width: 160px;">Số học viên ngoài</span>:<strong>{{$listUserInfo['totalUserNormal']}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-6 mt-4">
                <div class="box-item pb-0">
                    <p class="title-header">Rank thành viên trong hệ thống</p>
                    <div class="px-3 box-info-item">
                        <div class="table-list-user scrollstyle">
                            <table class="table table-bordered table-hover all-table-statiscal">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">STT</th>
                                        <th>Tên</th>
                                        <th>Tên đăng nhập</th>
                                        <th>Ngày Vip còn lại</th>
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
                                        <?php 
                                            $userCourseCombo = $itemUserVip->userCourseCombo()->first();
                                            $expirationDate = \Carbon\Carbon::createFromDate($userCourseCombo->expired_time);
                                        ?>
                                        <td>{{Support::show($itemUserVip,'phone')}}</td>
                                        <td>
                                            <strong>{{$expirationDate->diffInDays(now())}}</strong> ngày
                                        </td>
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
</div>
@endsection
@section('js')
    <script type="text/javascript" src="admin/statical/js/chart.min.js" defer></script>
    <script type="text/javascript" src="admin/statical/js/moment.min.js" defer></script>
    <script type="text/javascript" src="admin/statical/js/daterangepicker.js" defer></script>
    <script type="text/javascript" src="admin/statical/js/statical.js" defer></script>
@stop