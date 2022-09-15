<?php
    use App\Models\OrderStatus;
?>

<?php $__env->startSection('content'); ?>
<div class="header-top aclr">
	<div class="breadc pull-left">
		<ul class="aclr pull-left list-link">
			<li class="active"><a href="javascript:void(0)">Thông tin đơn hàng gói Vip</a></li>
		</ul>
	</div>
	<div>
		<a class="pull-right bgmain1 viewsite" href="<?php echo e($returnUrl); ?>">
			<i class="fa fa-backward" aria-hidden="true"></i>
			<span class="clfff">Back</span> 
		</a>
	</div>
</div>
<div id="maincontent">
	<div id="main_view_order">
	    <div class="row d-flex flex-wrap justify-content-center">
            <div class="col-lg-4 mt-4">
	    		<p class="title text-center">Thông tin đơn hàng</p>
	    		<table class="table-view-order">
					<tbody>
						<tr>
							<td>Mã đơn hàng</td>
							<td><?php echo e(Support::show($orderCourseCombo,'code')); ?></td>
						</tr>
                        <tr>
							<td>Ngày tạo đơn</td>
							<td><?php echo e(Support::showDateTime($orderCourseCombo->created_at)); ?></td>
						</tr>
                        <tr>
							<td>Phương thức thanh toán</td>
							<td><span class="select-value"><?php echo e(Support::show($orderCourseCombo->paymentMethod,'name')); ?></span></td>
						</tr>
						<tr>
							<td>Trạng thái đơn hàng</td>
							<td><span class="select-value"><?php echo e(Support::show($orderCourseCombo->orderStatus,'name')); ?></span></td>
						</tr>
					</tbody>
	    		</table>
	    	</div>
	    	<div class="col-lg-4 mt-4">
	    		<p class="title text-center">Thông tin khách hàng</p>
	    		<table class="table-view-order">
					<tbody>
						<tr>
							<td>Tên người mua</td>
							<td><?php echo e(Support::show($orderCourseCombo,'name')); ?></td>
						</tr>
						<tr>
							<td>Số điện thoại</td>
							<td><?php echo e(Support::show($orderCourseCombo,'phone')); ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo e(Support::show($orderCourseCombo,'email')); ?></td>
						</tr>
						<tr>
							<td>Ghi chú</td>
							<td><?php echo e(Support::show($orderCourseCombo,'content')); ?></td>
						</tr>
					</tbody>
	    		</table>
	    	</div>
	    	<div class="col-lg-8 mt-4">
                <?php if($orderCourseCombo->changeStatusAble()): ?>
                    <div class="text-center mb-3">
                        <button type="button" class="btn btn-success mx-2 btn-change-order-course-status" data-status="<?php echo e(OrderStatus::PAID); ?>" style="font-size: 16px;">Xác nhận đã thanh toán <i class="fa fa-check-square-o ms-2" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger mx-2 btn-change-order-course-status" data-status="<?php echo e(OrderStatus::CANCEL); ?>" style="font-size: 16px;">Hủy đơn hàng <i class="fa fa-times ms-2" aria-hidden="true"></i></button>
                    </div>
                <?php endif; ?>
                <table class="table-view-order-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align: center!important;width: 60px">STT</th>
                            <th>Tên gói vip</th>
                            <th>Gói thời gian</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orderCourseCombo->orderCourseComboDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $itemOrderCourseComboDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="text-align: center!important"><strong><?php echo e($key + 1); ?></strong></td>
                                <td><?php echo e(Support::show($itemOrderCourseComboDetail,'name')); ?></td>
                                <td><?php echo e(Support::show($itemOrderCourseComboDetail,'name_time_package')); ?></td>
                                <td><strong><?php echo e(Currency::showMoney($itemOrderCourseComboDetail->price)); ?></strong></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
	    		<div class="total-info text-right">
		    		<p class="item-total">Tổng tiền: <span><?php echo e(Currency::showMoney($orderCourseCombo->total)); ?></span></p>
		    		<p class="item-total item-total-final">Tổng tiền cuối cùng: <span><?php echo e(Currency::showMoney($orderCourseCombo->total_final)); ?></span></p>
	    		</div>
	    	</div>
	    </div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        var MANAGE_ORDER = (function(){
            var initButtonChangeStatus = function(){
                $(document).on('click','.btn-change-order-course-status',function(){
                    $.ajax({
                        url: 'esystem/course-manage/change-order-course-combo-status',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            order_course_combo: <?php echo e($orderCourseCombo->id); ?>,
                            status: $(this).data('status')
                        }
                    })
                    .done(function(data) {
                        alert(data.message);
                        window.location.reload();
                    })
                });
            }
            return {
                _(){
                    initButtonChangeStatus();
                }
            };
        })();
        $(document).ready(function () {
            MANAGE_ORDER._();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('vh::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\dethi\packages\course_manage\src\Providers/../AdminViews/view_orders/view_order_course_combo.blade.php ENDPATH**/ ?>