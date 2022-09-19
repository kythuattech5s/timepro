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
		var slide1 = Tech.$('.slide-category__thumbs');
		var slide2 = Tech.$('.slide-category-main');


		var btnPrev = Tech.$('.cate__prev');

		var btnNext = Tech.$('.cate__next');
		if (typeof Tech.$('.slide-category__thumbs') === 'undefined') return;
		if (typeof Tech.$('.slide-category-main') === 'undefined') return;

		if (slide1._element.length > 1) {
			for (i = 0; i < slide1._element.length; i++) {
				slide1._element[i].addClass('slide-category__thumbs-' + i);
				slide2._element[i].addClass('slide-category-main-' + i);
				btnPrev._element[i].addClass('cate__prev-' + i);

				btnNext._element[i].addClass('cate__next-' + i);
				const swiperBanner = new Swiper('.slide-category__thumbs-' + i, {
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
				const swiperBanner1 = new Swiper('.slide-category-main-' + i, {
					slidesPerView: 1,
					disableOnInteraction: true,
					speed: 600,
					spaceBetween: 16,
					navigation: {
						nextEl: ".cate__next-" + i,
						prevEl: ".cate__prev-" + i,
					},
					thumbs: {
						swiper: swiperBanner,
					},
				});
			
			}
		} else {
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

		}



	},
	slideBundledPro: function () {
		if (typeof Tech.$('.slide-bundled__pro') === 'undefined') return;
		const swiperBanner = new Swiper('.slide-bundled__pro', {
			slidesPerView: 1.2,
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
	slideLecturers: function () {
		if (typeof Tech.$('.slide-lecturers') === 'undefined') return;
		const swiperBanner = new Swiper('.slide-lecturers', {
			slidesPerView: 1,
			disableOnInteraction: true,
			speed: 600,
			spaceBetween: 10,
			freeMode: true,
			watchSlidesProgress: true,
			navigation: {
				nextEl: ".lecturers__next",
				prevEl: ".lecturers__prev",
			},
			pagination: {
				el: ".pagination-lecturers",
				clickable: true,
			},
			breakpoints: {
				576: {
					slidesPerView: 1.5,
					spaceBetween: 10
				},
				768: {
					slidesPerView: 2,
					spaceBetween: 15
				},
				991: {
					slidesPerView: 2,
					spaceBetween: 15
				},

				1023: {
					slidesPerView: 3,
					spaceBetween: 24,
				},


			}

		});

	},
	slideFeeling: function () {
		if (typeof Tech.$('.slide-feeling') === 'undefined') return;
		const swiperBanner = new Swiper('.slide-feeling', {
			slidesPerView: 1.2,
			disableOnInteraction: true,
			speed: 600,
			spaceBetween: 10,
			watchSlidesProgress: true,
			centeredSlides: true,
			loop: true,

			pagination: {
				el: ".pagination-feeling",
				clickable: true,
			},
			breakpoints: {
				576: {
					slidesPerView: 1.5,
					spaceBetween: 10
				},
				768: {
					slidesPerView: 2,
					spaceBetween: 15
				},
				991: {
					slidesPerView: 2.5,
					spaceBetween: 15
				},

				1023: {
					slidesPerView: 3.2,
					spaceBetween: 24,
				},


			}

		});

	},
	init: function () {
		SLIDER.slidePackageVip();
		SLIDER.slideCategory();
		SLIDER.slideBundledPro();
		SLIDER.slideLecturers();
		SLIDER.slideFeeling();
	},
}
Tech.Query.ready(function () {
	setTimeout(function () {
		SLIDER.init();
	}, 100);
});