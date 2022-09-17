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
	slideCategory: function () {
		if (typeof Tech.$('.slide-category__thumbs') === 'undefined') return;
		const swiperBanner = new Swiper('.slide-category__thumbs', {
			slidesPerView: 1,
			disableOnInteraction: true,
			speed: 600,
			spaceBetween: 10,
			freeMode: true,
			watchSlidesProgress: true,
		
			breakpoints: {
				576: {
					slidesPerView: 2,
					spaceBetween: 10
				},
				768: {
					slidesPerView: 2.5,
					spaceBetween: 15
				},
				991: {
					slidesPerView: 2.5,
					spaceBetween: 15
				},

				1023: {
					slidesPerView: 2,
					spaceBetween: 16,
				},


			}

		});
		if (typeof Tech.$('.slide-category-main') === 'undefined') return;
		const swiperBanner1 = new Swiper('.slide-category-main', {
			slidesPerView: 1,
			disableOnInteraction: true,
			speed: 600,
			spaceBetween: 16,
			navigation: {
				nextEl: ".cate__next",
				prevEl: ".cate__prev",
			},
			thumbs: {
				swiper: swiperBanner,
			  },
		});
	},
	slideBundledPro: function () {
		if (typeof Tech.$('.slide-bundled__pro') === 'undefined') return;
		const swiperBanner = new Swiper('.slide-bundled__pro', {
			slidesPerView: 1,
			disableOnInteraction: true,
			speed: 600,
			spaceBetween: 10,
			freeMode: true,
			watchSlidesProgress: true,
		
			breakpoints: {
				576: {
					slidesPerView: 2,
					spaceBetween: 10
				},
				768: {
					slidesPerView: 2.5,
					spaceBetween: 15
				},
				991: {
					slidesPerView: 2.5,
					spaceBetween: 15
				},

				1023: {
					slidesPerView: 4,
					spaceBetween: 16,
				},


			}

		});
	
	},
	init: function () {
		SLIDER.slidePackageVip();
		SLIDER.slideCategory();
		SLIDER.slideBundledPro();
	},
}
Tech.Query.ready(function () {
	setTimeout(function () {
		SLIDER.init();
	}, 100);
});