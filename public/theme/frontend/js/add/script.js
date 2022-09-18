var MORE_FUNCTION = (function(){
	var showModal = function(element){
		var modal_id = element.getAttribute('data-modal');
		console.log(modal_id);
		var modal = document.getElementById(modal_id);
		modal.classList.toggle("d-none");
	}
	var closeModal = function(){
		var button_close_modal = document.querySelectorAll('button[button_close_modal]');
		button_close_modal.forEach((item) => {
			item.addEventListener('click',function() {
				var _this = this;
				_this.closest('div[modal]').classList.add('d-none');
			});
		});
		window.onclick = function(event) {
			var modal = document.querySelector('div[modal]');
			if(event.target == modal){
				modal.classList.add('d-none');
			}
		}
	}
	var configDatetimeRange = function(){
		var time_range_flatpickr = document.querySelectorAll('[time_range_flatpickr]');
		time_range_flatpickr.forEach((item) => {
			flatpickr(item, {
                enableTime: false,
                dateFormat: "d/m/Y",
                mode: "range",
                locale: "vn",
                maxDate: new Date()
            });
		});
	}
	return{
		init:function(){
			closeModal();
			configDatetimeRange();
		},
		showModal:function(element){
			showModal(element);
		}
	}
})();
MORE_FUNCTION.init();