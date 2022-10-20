var STATICAL_GUI = {
	init:function(){
		STATICAL_GUI.initRangePicker();
	},
	formatCurrency:function(number){
        var n = number.toString().split('').reverse().join("");
        var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
        return  n2.split('').reverse().join('') + ' đ';
    },
	initRangePicker:function(){
		if ($('.module-date-range-picker').length == 0) {
			return;
		}
		var start = moment().subtract(7, 'days');
	    var end = moment();
	    function callBackDateRange(start, end) {
	    	htmlShow = start.format('D/M/YYYY') + '-' + end.format('D/M/YYYY');
	    	return htmlShow;
	    }
	    $('.inner-date-range').daterangepicker({
	        startDate: start,
	        endDate: end,
	        locale:{
	        	"customRangeLabel": "Tùy Chọn",
		        "separator": " - ",
		        "applyLabel": "Xác nhận",
		        "cancelLabel": "Hủy",
		        "fromLabel": "Từ",
		        "toLabel": "Đến",
		        "weekLabel": "W",
		        "daysOfWeek": ["CN","T2","T3","T4","T5","T6","T7"],
		        "monthNames": ["Tháng 1","Tháng 2","Tháng 3","Tháng 4","Tháng 5","Tháng 6","Tháng 7","Tháng 8","Tháng 9","Tháng 10","Tháng 11","Tháng 12"]
	        },
	        ranges: {
	           'Hôm nay': [moment(), moment()],
	           'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Tuần này': [moment().subtract(7, 'days'), moment()],
	           'Tuần trước': [moment().startOf('week').subtract(7, 'days'), moment().endOf('week').subtract(7, 'days')],
	           'Tháng này': [moment().startOf('month'), moment().endOf('month')],
	           'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        }
	    }, function(start,end){
	    	var parent = $(this.element.context).closest('.module-date-range-picker');
	    	parent.find('.inner-date-range .text-show').html(callBackDateRange(start,end));
	    	parent.find('input').val(callBackDateRange(start,end)).trigger('change');
	    });
	    $('.module-date-range-picker .inner-date-range .text-show').html(callBackDateRange(start,end));
	    $('.module-date-range-picker input').val(callBackDateRange(start,end));
	}
}
let revenueChartAll = null;
let userJoinSystemChart = null;
var STATICAL_ALL = {
	init:function(){
		STATICAL_ALL.initRevenueChartAll();
		STATICAL_ALL.initUserJoinSystemChart();
		$(document).on('change', 'input[name=date_range_revenue_chart_all]', function(event) {
			STATICAL_ALL.initRevenueChartAll();
		});
		$(document).on('change', 'input[name=date_range_user_join_system]', function(event) {
			STATICAL_ALL.initUserJoinSystemChart();
		});
	},
	initRevenueChartAll:function(){
		if ($('#revenueChartAll').length == 0) return;
		var time = $('input[name=date_range_revenue_chart_all]').val();
		$.ajax({
			url: 'esystem/statical-all',
			type: 'POST',
			dataType: 'json',
			global:false,
			data: {
				time: time,
				mode: 'revenue'
			}
		})
		.done(function(json) {
			STATICAL_ALL.createStaticalRevenueAll(json);
		})
	},
	createStaticalRevenueAll:function(revenueChartAllData){
        var lineData = {
            labels: revenueChartAllData.labels,
            datasets: [
            	{
                    label: 'Tổng doanh thu',
                    backgroundColor: '#17a2b8',
                    borderColor: "#17a2b8",
                    pointBackgroundColor: "#17a2b8",
                    pointBorderColor: "#17a2b8",
                    fill: false,
                    data: revenueChartAllData.totalOrderArray
                },
                {
                    label: 'Lợi nhuận thuần',
                    backgroundColor: '#5eb858',
                    borderColor: "#5eb858",
                    pointBackgroundColor: "#5eb858",
                    pointBorderColor: "#5eb858",
                    fill: false,
                    data: revenueChartAllData.revenueArray
                },
                {
                    label: 'Hoa hồng tri trả',
                    backgroundColor: '#ff5246',
                    borderColor: "#ff5246",
                    pointBackgroundColor: "#ff5246",
                    pointBorderColor: "#ff5246",
                    fill: false,
                    data: revenueChartAllData.totalCommissionArray
                }
            ]
        };
        var lineOptions = {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + STATICAL_GUI.formatCurrency(tooltipItem.value);
                    }
                }
            },
            scales: {
                yAxes: [
                    {
                        ticks: {
                        	beginAtZero: true,
                        	precision: 0,
                            callback: function(label, index, labels) {
                                return STATICAL_GUI.formatCurrency(label);
                            }
                        }
                    }
                ]
            }
        };
        if($('#revenueChartAll').length) {
            var ctx = document.getElementById("revenueChartAll").getContext("2d");
            if (!revenueChartAll) {
                revenueChartAll = new Chart(ctx, { type: 'line', data: lineData, options: lineOptions });
                revenueChartAll.render();
            } else {
                revenueChartAll.destroy();
                revenueChartAll = new Chart(ctx, { type: 'line', data: lineData, options: lineOptions }); 
                revenueChartAll.render();
            }
        }
	},
	initUserJoinSystemChart:function(){
		if ($('#userJoinSystemChart').length == 0) return;
		var time = $('input[name=date_range_user_join_system]').val();
		$.ajax({
			url: 'esystem/statical-all',
			type: 'POST',
			dataType: 'json',
			global:false,
			data: {
				time: time,
				mode: 'join_system'
			}
		})
		.done(function(json) {
			STATICAL_ALL.createUserJoinSystemChart(json);
		})
	},
	createUserJoinSystemChart:function(revenueChartAllData){
        var lineData = {
            labels: revenueChartAllData.labels,
            datasets: [
            	{
                    label: 'Thành viên gia nhập hệ thống',
                    backgroundColor: '#17a2b8',
                    borderColor: "#17a2b8",
                    pointBackgroundColor: "#17a2b8",
                    pointBorderColor: "#17a2b8",
                    fill: false,
                    data: revenueChartAllData.userJoinArray
                }
            ]
        };
        var lineOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [
                    {
                        ticks: {
                        	beginAtZero: true,
                        	precision: 0,
                        }
                    }
                ]
            }
        };
        if($('#userJoinSystemChart').length) {
            var ctx = document.getElementById("userJoinSystemChart").getContext("2d");
            if (!userJoinSystemChart) {
                userJoinSystemChart = new Chart(ctx, { type: 'line', data: lineData, options: lineOptions });
                userJoinSystemChart.render();
            } else {
                userJoinSystemChart.destroy();
                userJoinSystemChart = new Chart(ctx, { type: 'line', data: lineData, options: lineOptions }); 
                userJoinSystemChart.render();
            }
        }
	},
}
var STATICAL_TOP_USER = {
	init:function(){
		STATICAL_TOP_USER.moduleAjaxPaginate();
	},
	moduleAjaxPaginate:function(){
		$('.module-ajax-paginate').each(function(index, el) {
			var _this = $(this);
			$.ajax({
				url: _this.data('action'),
				type: 'GET',
				dataType: 'html',
				data:{
					type: _this.data('type')
				}
			})
			.done(function(html) {
				_this.html(html);
			})
		});
		$(document).on('click', '.module-ajax-paginate .pagination a', function(event) {
			event.preventDefault();
			var _this = $(this);
			var linkTarget = _this.attr('href');
			if (typeof linkTarget === undefined || typeof linkTarget == 'undefined' || linkTarget== '') return;
			$.ajax({
				url: _this.attr('href'),
				type: 'GET',
				dataType: 'html'
			})
			.done(function(html) {
				_this.closest('.module-ajax-paginate').html(html);
			})
		});
	}
}
var MEMBER_NOTICE_KE = {
	init:function(){
		MEMBER_NOTICE_KE.selectUserMode();
		MEMBER_NOTICE_KE.sendNotice();
	},
	selectUserMode:function(){
		if ($('.user-selecter-result').length == 0) return;
		$(document).on('change', 'input[name=user_mode]', function(event) {
			var val = $(this).val();
			if (val == 4) {
 				$.ajax({
 					url: 'esystem/member-notice',
 					type: 'GET',
 					dataType: 'html',
 					data: {
 						mode: 'load_all_user'
 					}
 				})
 				.done(function(data) {
 					$('.user-selecter-result').html(data);
 					$('.user-selecter-result').find('select').select2();
 				})
			}else {
				$('.user-selecter-result').html('');
			}
		});
	},
	sendNotice:function(){
		if ($('.user-selecter-result').length == 0) return;
		$(document).on('click', '.btn-send-member-notice', function(event) {
			event.preventDefault();
			var user_mode = $('input[name=user_mode]:checked').val();
			var member_notice = $('textarea[name=member_notice]').val();
			var title_member_notice = $('input[name=title_member_notice]').val();
			var listUserId = '';
			if ($('select[name=list_user_notice]').length > 0) {
				listUserId = $('select[name=list_user_notice]').val();
			}
			$.ajax({
				url: 'esystem/member-notice',
				type: 'POST',
				dataType: 'json',
				data: {
					title_member_notice: title_member_notice,
					member_notice: member_notice,
					user_mode: user_mode,
					listUserId: listUserId
				},
			})
			.done(function(json) {
				if (json.code == 200) {
					$.simplyToast(json.message, 'success');
					setTimeout(function(){ 
						window.location.reload();
					}, 800);
				}else {
					$.simplyToast(json.message, 'danger');
				}
			})
		});
	}
}
$(document).ready(function($) {
	STATICAL_GUI.init();
	STATICAL_ALL.init();
	STATICAL_TOP_USER.init();
	MEMBER_NOTICE_KE.init();
});