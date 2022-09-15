var SLIDER = {



	slidePackageVip: function () {
		if (typeof Tech.$('.slide-package__vip') === 'undefined') return;
		const swiperBanner = new Swiper('.slide-package__vip', {
			slidesPerView: 1.2,
			disableOnInteraction: true,
			speed: 600,
			spaceBetween: 8,
			navigation: {
				nextEl: ".package-next",
				prevEl: ".package-prev",
			},
			pagination: {
				el: ".pagintion-package",
				clickable: true,
			},
			breakpoints: {
				576: {
					slidesPerView: 2,
					spaceBetween: 10
				},
				768: {
					slidesPerView: 2.5,
					spaceBetween: 15
				},
				992: {
					slidesPerView: 3,
					spaceBetween: 15
				},

				1023: {
					slidesPerView: 4,
					spaceBetween: 15,
				},


			}

		});
	},
	
	init: function () {
		SLIDER.slidePackageVip();
	},
}
Tech.Query.ready(function () {
	setTimeout(function () {
		SLIDER.init();
	}, 100);
});