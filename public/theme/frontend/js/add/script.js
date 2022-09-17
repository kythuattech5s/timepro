var MORE_FUNCTION = (function(){
	var showModal = function(element){
		var modal_id = element.getAttribute('data-modal');
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
	return{
		init:function(){
			closeModal();
		},
		showModal:function(element){
			showModal(element);
		}
	}
})();
MORE_FUNCTION.init();