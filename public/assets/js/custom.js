/*global jQuery, window, Modernizr, navigator, objLayerSlider, objFlickr, objPostSlider, google, objGoogleMap*/

(function ($, window, Modernizr, document, CONFIG) {

	"use strict";
	
	/* ---------------------------------------------------------------------- */
	/*	Ready																  */
	/* ---------------------------------------------------------------------- */
	
	$(function () {
		
		(function () {
			
			/* ---------------------------------------------------- */
			/*	OnePage Custom Plugin								*/
			/* ---------------------------------------------------- */

			 $('body').OnePage(CONFIG.objOnePage);

			/* ---------------------------------------------------- */
			/*	Init Parallax										*/
			/* ---------------------------------------------------- */

			if (!Modernizr.touch) {
				if ($('.full-bg-image').length) {
					$('.full-bg-image').parallax('center', 0.4);
				}
			}

			/* ---------------------------------------------------- */
			/*	Superslides											*/
			/* ---------------------------------------------------- */

			// Superslides Fullscreen Slider
			if ($('#slides').length) {
				$('#slides').superslides(CONFIG.objSuperSlides);		
			}

			/* ---------------------------------------------------- */
			/*	FitVids												*/
			/* ---------------------------------------------------- */

			$('.container').fitVids();

			/* ---------------------------------------------------- */
			/*	Player Full Width									*/
			/* ---------------------------------------------------- */

			if ($('#bgndVideo').length) {
				$('#bgndVideo').mb_YTPlayer();
			}
	
			/* ---------------------------------------------------- */
			/*	Flex Slider											*/
			/* ---------------------------------------------------- */

			if ($('.flexslider').length) {

				$(window).load(function () {
					$('.flexslider').flexslider({
						animation: "slide",
						controlNav: "thumbnails"
					});
				});			

			}

			/* ---------------------------------------------------- */
			/*	Tabs												*/
			/* ---------------------------------------------------- */

			if ($('.tabs-holder').length) {

				var $tabsHolder = $('.tabs-holder');

				$tabsHolder.each(function(i, val) {

					var $tabsNav = $('.tabs-nav', val),
						tabsNavLis = $tabsNav.children('li'),
					$tabsContainer = $('.tabs-container', val);

					$tabsNav.each(function() {
						$(this).next().children('.tab-content').first().stop(true, true).show();
						$(this).children('li').first().addClass('active').stop(true, true).show();
					});

					$tabsNav.on('click', 'a', function(e) {
						var $this = $(this).parent('li'),
							$index = $this.index();
						$this.siblings().removeClass('active').end().addClass('active');
						$this.parent().next().children('.tab-content').stop(true, true).hide().eq($index).stop(true, true).fadeIn(250);
						e.preventDefault();

					});

				});
			}

			/*----------------------------------------------------*/
			/*	Accordion and Toggle							  */
			/*----------------------------------------------------*/

			if ($('.acc-box').length) {

				var $box = $('.acc-box');

				$box.each(function () {

					var $trigger = $('.acc-trigger', $(this));

					$trigger.on('click', function() {
						var $this = $(this);
						if ($this.data('mode') === 'toggle') {
							$this.toggleClass('active').next().stop(true, true).slideToggle(300);
						} else {
							if ($this.next().is(':hidden')) {
								$trigger.removeClass('active').next().slideUp(300);
								$this.toggleClass('active').next().slideDown(300);
							} else if ($this.hasClass('active')) {
								$this.removeClass('active').next().slideUp(300);
							}
						}
						return false;
					});

				});

			}

			/*----------------------------------------------------*/
			/*	Alert Boxes										  */
			/*----------------------------------------------------*/

			var $notifications = $('.error, .success, .info, .notice');

			if ($notifications.length) {
				$notifications.notifications({ speed: 300 });
			}
			
			/* ---------------------------------------------------- */
			/*	Curtain												*/
			/* ---------------------------------------------------- */

			if ($('.fancybox').length) {
				$('.fancybox').each(function () { $(this).append('<span class="curtain"></span>'); });
				$('.team-image .fancybox .curtain').each(function () { $(this).append('<h6>CLICK TO READ</h6>'); });
			}

			/* ---------------------------------------------------- */
			/*	Portfolio											*/
			/* ---------------------------------------------------- */

			if ($('#portfolio-items').length) {
				$('#portfolio-items').mixitup(CONFIG.objMixitup);
			}

			/* ---------------------------------------------------- */
			/*	CountTo												*/
			/* ---------------------------------------------------- */

			if ($('.counter').length) {
				var counter = $('.counter');
				if (!Modernizr.touch) {
					counter.waypoint(function (direction) {
						if (direction == 'down') {
							counter.countTo();
						}
					}, { offset: '64%'});		
				} else { counter.countTo();	}
			}

			/* ---------------------------------------------------- */
			/*	Tooltip Init										*/
			/* ---------------------------------------------------- */

			if ($('.tooltip').length) {
				$('.tooltip').tooltipster(CONFIG.objTooltipster);
			}
			
			/* ---------------------------------------------------- */
			/*	Init Progress Bar									*/
			/* ---------------------------------------------------- */

			if ($('.progress-bar').length) {
				$('.progress-bar').progressBar();
			}

			/* ---------------------------------------------------- */
			/*	Placeholder											*/
			/* ---------------------------------------------------- */

			if (typeof document.createElement("input").placeholder === 'undefined') {
				$('[placeholder]').focus(function() {
					var input = $(this);
					if (input.val() === input.attr('placeholder')) {
						input.val('');
						input.removeClass('placeholder');
					}
				}).blur(function() {
					var input = $(this);
					if (input.val() === '' || input.val() === input.attr('placeholder')) {
						input.addClass('placeholder');
						input.val(input.attr('placeholder'));
					}
				}).blur().parents('form').submit(function() {
					$(this).find('[placeholder]').each(function() {
						var input = $(this);
						if (input.val() === input.attr('placeholder')) {
							input.val('');
						}
					});
				});
			}

		}());
		
		/* ---------------------------------------------------- */
		/*	Cycles												*/
		/* ---------------------------------------------------- */

		(function () {

			/* ---------------------------------------------------- */
			/*	Custom Function for Cycles							*/
			/* ---------------------------------------------------- */
			
			function swipeFunc(e, dir) {
				
				var $currentTarget = $(e.currentTarget);

				if ($currentTarget.data('slideCount') > 1) {
					$currentTarget.data('dir', '');
					if (dir === 'left') {
						$currentTarget.cycle('next');
					}
					if (dir === 'right') {
						$currentTarget.data('dir', 'prev');
						$currentTarget.cycle('prev');
					}
				}
			}

			// Fixed scrollHorz effect
			$.fn.cycle.transitions.fixedScrollHorz = function ($cont, $slides, opts) {

				$('.post-slider-nav a').on('click', function (e) {
					$cont.data('dir', '');
					if (e.target.className.indexOf('prev') > -1) {
						$cont.data('dir', 'prev');
					}
				});

				$cont.css('overflow', 'hidden');
				opts.before.push($.fn.cycle.commonReset);
				var w = $cont.width();
				opts.animIn.left = 0;
				opts.animOut.left = 0-w;
				opts.cssFirst.left = 0;
				opts.cssBefore.left = w;
				opts.cssBefore.top = 0;

				if ($cont.data('dir') === 'prev') {
					opts.cssBefore.left = -w;
					opts.animOut.left = w;
				}

			};

			/* ---------------------------------------------------- */
			/*	Image Slider										*/
			/* ---------------------------------------------------- */
			
			if ($('.image-slider > ul').length) {
				
				var $imageslider = $('.image-slider > ul');
				
				$(window).load(function () {
					
					$imageslider.each(function (i) {

						var $this = $(this);
						
						if ($this.children('li').length < 2) { return; }

						$this.css('height', $this.children('li:first').height())
							.after('<div id="image-nav-'+ i +'" class="image-control-nav">')
							.after('<div class="image-slider-nav"><a class="prevBtn nav-prev-' + i + '">Prev</a><a class="nextBtn nav-next-' + i + '">Next</a></div>')
							.cycle({ before: function (curr, next, opts) {
								var $this = $(this);
									$this.parent().stop().animate({
									height: $this.height()
								}, opts.speed);
							},
							containerResize: false,
							easing: CONFIG.objImageSlider.easing,
							fx: 'fixedScrollHorz',
							fit: true,
							next: '.nav-next-' + i,
							pause: true,
							prev: '.nav-prev-' + i,
							slideResize: true,
							speed: CONFIG.objImageSlider.speed,
							timeout: $this.data('timeout') ? $this.data('timeout') : CONFIG.objImageSlider.timeout,
							width: '100%',
							pager: '#image-nav-' + i
						}).data('slideCount', $this.children('li').length);
						
					});

					// Pause on Nav Hover
					$('.image-slider-nav a').on('mouseenter', function () {
						$(this).parent().prev().cycle('pause');
					}).on('mouseleave', function () {
						$(this).parent().prev().cycle('resume');
					});

					// Resize
					if ($imageslider.data('slideCount') > 1) {
						$(window).on('resize', function () {
							$imageslider.css('height', $imageslider.find('li:visible').height());
						});		
					}

					// Include Swipe
					if (Modernizr.touch) {
						$imageslider.swipe({
							swipeLeft: swipeFunc,
							swipeRight: swipeFunc,
							allowPageScroll: 'auto'
						});
					}
				
				});
			}	
			
			if ($('.quotes').length) {
				
				var $quotes = $('.quotes');
				
				$(window).load(function () {
					
					$quotes.each(function (i, val) {

						var $this = $(val);
					
						if ($this.children('li').length < 2) { return; }

						$this.css('height', $this.children('li:first').height())
						.after('<div id="quote-nav-'+ i +'" class="quotes-control-nav">') 
						.cycle({
							before: function(curr, next, opts) {
								var $this = $(this);
								$this.parent().stop().animate({
									height: $this.height()
								}, opts.speed);
							},
							containerResize: false,
							easing: CONFIG.objQuotes.easing,
							fit: true,
							pause: true,
							slideResize: true,
							speed: CONFIG.objQuotes.speed,
							timeout: $this.data('timeout') ? $this.data('timeout') : CONFIG.objQuotes.timeout,
							width: '100%',
							pager: '#quote-nav-' + i
						}).data('slideCount', $this.children('li').length);
						
					});	
					
					// Resize
					if ($quotes.data('slideCount') > 1) {
						$(window).on('resize', function () {
							$quotes.css('height', $quotes.find('li:visible').height());
						});			
					}

					// Include Swipe
					if (Modernizr.touch) {
						$quotes.swipe({
							swipeLeft: swipeFunc,
							swipeRight: swipeFunc,
							allowPageScroll: 'auto'
						});
					}

				});
				
			}

			/* ---------------------------------------------------- */
			/*	Tweets												*/
			/* ---------------------------------------------------- */

			if ($('.sidebar-tweet').length) {
				$('.sidebar-tweet').tweet(CONFIG.objSidebarTweet);				
			}
			
			if ($('.tweet').length) {
				
				var $tweet = $('.tweet');
				
				$tweet.tweet(CONFIG.objContentTweet);
				
					var $tweets = $('.tweets', $tweet);

				$tweets.each(function (i) {

					var $this = $(this);

					if ($this.children('li').length < 2) { return; }

					$this.css('height', $this.children('li:first').height())
							.after('<div id="tweets-nav-'+ i +'" class="tweets-control-nav">') 
							.cycle({
						before: function(curr, next, opts) {
							var $this = $(this);
							$this.parent().stop().animate({
								height: $this.height()
							}, opts.speed);
						},
						containerResize: false,
						easing: 'easeInOutExpo',
						fit: true,
						pause: true,
						slideResize: true,
						speed: 600,
						timeout: $this.parent().data('timeout') ? $this.parent().data('timeout') : '',
						width: '100%',
						pager: '#tweets-nav-' + i
					}).data('slideCount', $this.children('li').length);
					
				});

				// Resize
				if ($tweets.data('slideCount') > 1) {
					$(window).on('resize', function() {
						$tweets.css('height', $tweets.find('li:visible').height());
					});				
				}

				// Include Swipe
				if (Modernizr.touch) {
					$tweets.swipe({
						swipeLeft: swipeFunc,
						swipeRight: swipeFunc,
						allowPageScroll: 'auto'
					});
				}

			}	
			
		}());

	});
	
	/* ---------------------------------------------------------------------- */
	/*	OnLoad																  */
	/* ---------------------------------------------------------------------- */
	
		/*----------------------------------------------------*/
		/*	Team											  */
		/*----------------------------------------------------*/

		$(window).load(function () {
			if ($(this).width() > 767) {
				$('.team-member').Team();
			}
		});

	/* ---------------------------------------------------------------------- */
	/*	Plugins																  */
	/* ---------------------------------------------------------------------- */

		/* ---------------------------------------------------- */
		/*	OnePage												*/
		/* ---------------------------------------------------- */
		
		function OnePage(el, options) {
			this.el = $(el);
			this.init(options);
		}
		
		OnePage.DEFAULTS = {
			easing: 'easeInOutExpo',
			animatedElem: true,
			queryLoader: true,
			duration: 1200
		}
		
		OnePage.prototype = {
			init: function (options) {
				var self = this, $window = $(window), 
					windowHeight = $window.height(), support = Modernizr.cssanimations;
					this.o = $.extend({}, OnePage.DEFAULTS, options);
					this.refreshElements();
					this.sections = this.wrapper.children('.page');
					this.scrollingToElement = false;
					this.touch = Modernizr.touch;
					
				// QueryLoader	
				this.o.queryLoader ? this.queryLoader(self) : this.loader.fadeOut(200);
				
				// Navigation
				this.navigation(self);
				
				// LayerSlider
				if (this.layer.length) {
					if (!this.touch) {
						this.layer.css({ height: windowHeight }).children().layerSlider(CONFIG.objLayerSlider);
					} else { this.layer.children().layerSlider(CONFIG.objLayerSlider); }
				}
				
				self.stickyHeader.call(self, $window);
				
				// ScrollSpy 
				self.scrollSpy.call(self);
				
				$window.on('scroll.OnePage', function (e) {
					// Back To Top
					self.backTopScrollHandler.call(self, e.currentTarget);
					// Sticky Header
					self.stickyHeader.call(self, e.currentTarget);
				});
				
				if (!this.touch) {
					
					if (navigator.userAgent.search(/Safari/) != -1) {
						this.el.addClass('safari');
					}
					
					// Animated Elements
					if (support) {
						if (this.o.animatedElem) {
							this.el.addClass('animated');
							this.animatedElem(self);
						}						
					}
					
					// Video Full Container
					if (this.videoFull.length) {
						this.videoFull.height(windowHeight);
					}
					
					$window.on('keydown', function (e) {
						self.keyDownHandler.call(self, e);
					});
					
				}
				
				// Back to Top
				this.backTopClickHanlder();
			},
			elements: {
				'.loader' : 'loader',
				'.section': 'section',
				'#header' : 'header',
				'#layerslider-container': 'layer',
				'#wrapper': 'wrapper',
				'#responsive-nav-button': 'navButton',
				'#navigation': 'nav',
				'#back-top' : 'backTop',
				'.video-full-container' : 'videoFull'
			},
			$: function (selector) { return $(selector); },
			refreshElements: function() {
				for (var key in this.elements) {
					this[this.elements[key]] = this.$(key);
				}
			},
			waypoints: function (el) {
				return el.each(function () {
					var element = $(this);
					setTimeout(function () {
						element.waypoint(function (direction) {
							if (direction == 'down') {
								$(this).trigger('start');
							}
						}, {
							offset: '60%',
							triggerOnce: true				
						});
					}, 100);
				});	
			}, 
			effect: function (el, options) {
				
				var defaults = {
					effect : 'opacity',
					speed: 350,
					beforeCall : function() {}
				}, o = $.extend({}, defaults, options);
				
				return el.each(function () {
					var container = $(this), elements;
						o.beforeCall(container);
						elements = container.find('.' + o.effect);
					container.on('start', function () {
						elements.each(function (i, value) {
							setTimeout(function () {
								$(value).addClass(o.effect + 'Run');
								setTimeout(function () {
									$(value).removeClass(o.effect);
								}, i * o.speed);
							}, i * o.speed);
						});
					});
				});
			},
			animatedElem: function (self) {
				self.waypoints(self.section);
				if ($('.opacity').length) {
					self.effect(self.section, { effect: 'opacity' });
				}
				if ($('.opacity2x').length) {
					self.effect(self.section, { effect: 'opacity2x', speed: 150 });
				}
				if ($('.scale').length) {
					self.effect(self.section, { effect: 'scale' });
				}
				if ($('.slideLeft').length) {
					self.effect(self.section, { effect: 'slideLeft' });
				}
				if ($('.slideRight').length) {
					self.effect(self.section, { effect: 'slideRight' });
				}
				if ($('.slideDown').length) {
					self.effect(self.section, { effect: 'slideDown' });
				}
				if ($('.slideUp').length) {
					self.effect(self.section, { effect: 'slideUp' });
				}
			},
			queryLoader: function (self) {
				this.el.queryLoader2({
					barColor: '#00c2a9',
					backgroundColor: '#fff',
					percentage: true,
					barHeight: 3,
					completeAnimation: 'fade',
					minimumTime: 700,
					onComplete : function () { 
						self.loader.fadeOut(200);
					}
				});
			},
			getCurrentSection: function () {
				var $nearestSection, minDistance = 99999;
				
				this.sections.each(function (idx, val) {
					var $this = $(val),
						top = $this.offset().top,
						currentScroll = $(window).scrollTop(),
						distance = Math.abs(currentScroll - top);
						
					if (distance < minDistance) {
						minDistance = distance;
						$nearestSection = $this;
					}		
				});
				return $nearestSection;			
			},
			keyDownHandler: function (e) {
				var $newSection, $currentSection;
				switch (e.keyCode) {
					case 38:
						$currentSection = this.getCurrentSection();
						$newSection = $currentSection.prev();
						e.preventDefault();
						break;
					case 40:
						$currentSection = this.getCurrentSection();
						$newSection = $currentSection.next();
						e.preventDefault();
						break;
				}
				
				if ($newSection && $newSection.length > 0) {
					this.sectionAnimate($newSection);
				}
				
			},
			sectionAnimate: function (section) {
				var self = this;
				this.scrollingToElement = true;
				$('html, body').stop(true, true).animate({
					scrollTop: section.offset().top + "px"
				}, {
					duration: this.o.duration,
					easing: this.o.easing,
					complete: function () {
						self.scrollingToElement = false;
					}
				});		
			},
			checkHashLink: function (href) { 
				return href.indexOf('.html') != -1 || href.lastIndexOf('http://') != -1; 
			},
			scrollSpy: function () {
				this.el.scrollspy(this.el.data());
			},
			navigation: function (self) {
				
				self.nav.find('ul').parent('li').each(function(idx, val) {
					var $curobj = $(val);
					$curobj.istopheader = $curobj.parents('ul').length === 1 ? true : false;
					$curobj.addClass($curobj.istopheader ? 'downarrowclass' : '');
				});
				
				self.nav.on('mouseenter', 'li', function () {
					var $this = $(this), $subMenu = $this.children('ul');
					if ($subMenu.length) {
						$subMenu.hide().stop(true, true).fadeIn(300);
					}
				}).on('mouseleave', 'li', function() {
					$(this).children('ul').stop(true, true).fadeOut(50);
				});
				
				self.nav.on('click', 'a', function (e) {
					var $this = $(this).parent('li'),
						$href = $this.children('a').attr('href');
					if (!self.checkHashLink($href)) {
						e.preventDefault();
						if (self.touch) {
							if (self.nav.hasClass('active')) {
								self.nav.stop(true, true).slideUp('fast').removeClass('active');
							}
						}	
						self.sectionAnimate($($href));
					}
				});
				
				self.navButton.on('click', function (e) {
					var $this = $(e.target);
					if (!self.nav.hasClass('active')) {
						self.nav.stop(true, true).slideDown('normal', function () {
						}).css('display', 'inline-block').addClass('active');
					} else {
						self.nav.stop(true, true).slideUp('normal').removeClass('active');
					}
					e.preventDefault();
				});
				
				$(window).on('resize', function (e) { self.removeAttrNav.call(self); });
				
			},
			removeAttrNav: function() {
				if ($(window).width() > 959) { this.nav.attr('style', ''); }
			},
			stickyHeader: function (win) {
				$(win).scrollTop() > 0 ? this.header.addClass('header-shrink') : this.header.removeClass('header-shrink');
			},
			backTopScrollHandler: function (win) {
				$(win).scrollTop() > 200 ? this.backTop.fadeIn(400) : this.backTop.fadeOut(400);
			},
			backTopClickHanlder: function() {
				this.backTop.on('click', function (e) {
					$('html, body').animate({ scrollTop: 0 }, 800);
					e.preventDefault();
				});
			}
		}
		
		/* OnePage Plugin Definition
		 * ================================== */
		
		$.fn.OnePage = function (option) {
			return this.each(function () {
				var $this = $(this), data = $this.data('OnePage'), 
					options = typeof option == 'object' && option;
				if (!data) {
					$this.data('OnePage', new OnePage(this, options));
				}
			});
		}
	
		/* ---------------------------------------------------- */
		/*	CountTo												*/
		/* ---------------------------------------------------- */

		$.fn.countTo = function (options) {
			
			options = options || {};

			return $(this).each(function () {
				
				// set options for current element
				var settings = $.extend({}, $.fn.countTo.defaults, {
					from: $(this).data('from'),
					to: $(this).data('to'),
					speed: $(this).data('speed'),
					refreshInterval: $(this).data('refresh-interval'),
					decimals: $(this).data('decimals')
				}, options);

				// how many times to update the value, and how much to increment the value on each update
				var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
				
				// references & variables that will change with each update
				var self = this,
				$self = $(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
				
				$self.data('countTo', data);

				// if an existing interval can be found, clear it first
				if (data.interval) {
					clearInterval(data.interval);
				}
				data.interval = setInterval(updateTimer, settings.refreshInterval);

				// initialize the element with the starting value
				render(value);

				function updateTimer() {
					value += increment;
					loopCount++;

					render(value);

					if (typeof(settings.onUpdate) == 'function') {
						settings.onUpdate.call(self, value);
					}

					if (loopCount >= loops) {
						// remove the interval
						$self.removeData('countTo');
						clearInterval(data.interval);
						value = settings.to;

						if (typeof(settings.onComplete) == 'function') {
							settings.onComplete.call(self, value);
						}
					}
				}

				function render(value) {
					var formattedValue = settings.formatter.call(self, value, settings);
					$self.children('.count').html(formattedValue);
				}
			});
		};

		$.fn.countTo.defaults = {
			from: 0, // the number the element should start at
			to: 0, // the number the element should end at
			speed: 1000, // how long it should take to count between the target numbers
			refreshInterval: 10, // how often the element should be updated
			decimals: 0, // the number of decimal places to show
			formatter: formatter, // handler for formatting the value before rendering
			onUpdate: null, // callback method for every time the element is updated
			onComplete: null // callback method for when the element finishes updating
		};

		function formatter(value, settings) {
			return value.toFixed(settings.decimals);
		}

		/* ---------------------------------------------------- */
		/*	Progress Bar										*/
		/* ---------------------------------------------------- */

		$.fn.progressBar = function(options, callback) {

			var defaults = {
				speed: 600,
				easing: 'swing'
			}, o = $.extend({}, defaults, options);

			return this.each(function() {

				var elem = $(this), methods = {};

				methods = {
					init: function () {
						this.touch = Modernizr.touch ? true : false;
						this.refreshElements();
						this.processing();
					},
					elements: {
						'.bar': 'bar',
						'.percent': 'per'
					},
					$: function(selector) { return $(selector, elem); },
					refreshElements: function () {
						for (var key in this.elements) {
							this[this.elements[key]] = this.$(key);
						}
					},
					getProgress: function() { return this.bar.data('progress'); },
					setProgress: function(self) {
						self.bar.animate({'width': self.getProgress() + '%'}, {
							duration: o.speed,
							easing: o.easing,
							step: function(progress) {
								self.per.text(Math.ceil(progress) + '%');
							},
							complete: function(scope, i, elem) {
								if (callback) {
									callback.call(this, i, elem);
								}
							}
						});
					},
					processing: function() {
						var self = this;
						if (self.touch) {
							self.setProgress(self);
						} else {
							elem.waypoint(function(direction) {
								if (direction == 'down') {
									self.setProgress(self);
								}
							}, { offset: '64%'});
						}
					}
				};
				methods.init();
			});
		};

		/* ---------------------------------------------------- */
		/*	Parallax											*/
		/* ---------------------------------------------------- */
		
		$.fn.parallax = function(xpos, speed) {
			var firstTop, pos;
			return this.each(function (idx, value) {

				var $this = $(value);
					if (arguments.length < 1 || xpos === null)  { xpos = "50%"; }
					if (arguments.length < 2 || speed === null) { speed = 0.4; }

				return ({
					update: function() {
						firstTop = $this.offset().top;
						pos = $(window).scrollTop();
						$this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speed) + "px");
					},
					init: function() {
						var self = this;
							self.update();
						$(window).on('scroll', self.update);
					}
				}.init());
			});

		};

		/* ---------------------------------------------------- */
		/*	Team												*/
		/* ---------------------------------------------------- */

		function Team(el, options) {
			this.el = $(el);
			this.init(options);
		}

		Team.DEFAULTS = {
			duration: 1200,
			speed: 450,
			keyboard: true,
			prevText: '<a href="#" class="prev">Previous</a>',
			nextText: '<a href="#" class="next">Next</a>'
		}

		Team.prototype = {
			init: function (options) {
				var self = this, $window = $(window);
				this.o = $.extend({}, Team.DEFAULTS, options);
				this.contents = this.el.find('.team-contents');
				this.articles = this.contents.children('article');
				this.directionalNav = '';
				this.el.count = this.articles.length;
				this.contents.data('width', (this.articles.eq(0).width() + 40) * this.el.count);
				this.contents.data('position', 0);
				
				if (this.contents.data('width') > 1160) {
					this.directionalNav = $('<div class="team-nav">' + this.o.prevText + this.o.nextText + '</div>');
					this.el.append(this.directionalNav);
					this.directionalNav.prev = $('.prev', this.directionalNav).fadeOut(this.o.speed);
					this.directionalNav.next = $('.next', this.directionalNav);
				}
				
				this.articles.each(function (id, val) {
					var $this = $(val);
					$this.find('.team-content').height($this.find('.team-info').height() - 2);
				});
				
				this.eventListeners(self);
				
				if (this.o.keyboard) {
					$window.on('keyup', function (e)  { 
						if ($window.scrollTop() != 0) {
							self.keyUpHandler.call(self, e); 
						}
					});
				}
				
				if (Modernizr.touch) {
					var touchHandler = function (e, dir) {
						var index = self.contents.data('position'),
						$currentTarget = $(e.currentTarget);
						$currentTarget.data('dir', '');
						if (dir === 'left') {
							self.next(index);
						}
						if (dir === 'right') {
							$currentTarget.data('dir', 'prev');
							self.previous(index);
						}
					}
					
					this.el.swipe({
						swipeLeft: touchHandler,
						swipeRight: touchHandler,
						allowPageScroll: 'auto'
					});
				}

			},
			keyUpHandler: function (e) {
				var index = this.contents.data('position');
				switch (e.keyCode) {
					case 37: 
					this.previous(index);
					e.preventDefault();		
					break;
					case 39:
					this.next(index);
					e.preventDefault();
					break;
				}
			},
			reposition: function (index, navLink) {
				var offset = (40 * index) + (index * 250);
				// console.log(index);
				// console.log(offset);
				this.contents.stop(true, false).animate(
					{ marginLeft:  - offset }, 
					{ duration: 700, queue: false, specialEasing: { marginLeft: 'easeInOutCubic' } });
				this.contents.data('position', index);
				
				if (typeof(this.directionalNav) == 'object') {
					if (typeof navLink !== "undefined") {
						navLink.hasClass('prev') ? this.previous(index, navLink) : this.next(index, navLink);	
					} else {
						if (index > 0) {
							this.directionalNav.prev.fadeIn(400);
							if (index < this.el.count -1 ) {
								this.directionalNav.next.fadeIn(400);
							} else if (index == this.el.count -1) {
								this.directionalNav.next.fadeOut(400);
							}
						} else if (index == 0) {
							this.directionalNav.prev.fadeOut(400);
						}		
					}	
				}
			},
			previous: function (index, el) {
				if (index > 0) {
					this.closeItem(this.articles.eq(index).children('.contents').filter('.open'));
					index--;
					this.reposition(index);
					if (typeof(el) !== "undefined" && typeof(el.next()) !== "undefined") {
						el.next().fadeIn(this.o.speed);
						if (index == 0) {
							el.fadeOut(this.o.speed);
						}		
					}
				}
			},
			next: function (index, el) {
				if (index < (this.el.count - 1)) {
					this.closeItem(this.articles.eq(index).children('.contents').filter('.open'));
					index++;
					this.reposition(index);
					if (typeof(el) !== 'undefined' && typeof(el.next()) !== "undefined") {
						el.prev().fadeIn(this.o.speed);
						if (index == this.el.count - 1) {
							el.fadeOut(this.o.speed);
						}	
					}
				}
			},
			openItem: function (contents) {
				contents.stop(true, false).animate({ width: '660px'}, this.o.speed, 'easeOutCubic').addClass('open');
			},
			closeItem: function (contents) {
				contents.stop(true, false).animate({ width: '250px'}, this.o.speed, 'easeOutCubic').removeClass('open');
			},
			eventListeners: function (self) {
		
				this.articles.on('click', '.fancybox', function (el) {
					var $this = $(this), contents = $this.closest('.contents'),
					index = contents.parent().index();
					self.articles.children('.contents').not(contents).stop(true, false).animate({ width: '250px'}, self.o.speed, 'easeOutCubic' ).removeClass('open');
					
					if (!contents.hasClass('open')) {
						self.openItem.call(self, contents);
						self.reposition(index);
					} else {
						self.closeItem.call(self, contents);
						self.reposition(0);
					}
					el.preventDefault();
				});
				
				if (typeof(this.directionalNav) == 'object') {
					this.directionalNav.on('click', 'a', function (el) {
						self.reposition(self.contents.data('position'), $(el.currentTarget));
						el.preventDefault();
					});
				}
			}
		}
		
		$.fn.Team = function (option) {
			return this.each(function () {
				var $this = $(this), data = $this.data('team'),
				options = typeof option == 'object' && option;
				if (!data) {
					$this.data('team', new Team(this, options));
				}
			});
		}

		/* ---------------------------------------------------- */
		/*	Notifications										*/
		/* ---------------------------------------------------- */

		$.fn.notifications = function (options) {

			var defaults = { speed: 200 }, 
				o = $.extend({}, defaults, options);

			return this.each(function () {
				
				var closeBtn = $('<a class="alert-close" href="#"></a>'),
					closeButton = $(this).append(closeBtn).find('> .alert-close');

				function fadeItSlideIt(object) {
					object.fadeTo(o.speed, 0, function () {
						object.slideUp(o.speed);
					});
				}
				closeButton.click(function () {
					fadeItSlideIt($(this).parent());
					return false;
				});
			});
		};

		/* ---------------------------------------------------- */
		/*	Scroll Spy											*/
		/* ---------------------------------------------------- */

		function ScrollSpy(element, options) {
			var href;
			var process  = $.proxy(this.process, this);
			this.$element       = $(element).is('body') ? $(window) : $(element);
			this.$body          = $('body');
			this.$scrollElement = this.$element.on('scroll.bs.scroll-spy.data-api', process);
			this.options        = $.extend({}, ScrollSpy.DEFAULTS, options);
			this.selector       = (this.options.target || ((href = $(element).attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) || '') + ' > ul > li > a';
			this.offsets        = $([]);
			this.targets        = $([]);
			this.activeTarget   = null;
			this.refresh();
			this.process();
		}

		ScrollSpy.DEFAULTS = {
			offset: 10
		}

		ScrollSpy.prototype.refresh = function () {
			var offsetMethod = this.$element[0] == window ? 'offset' : 'position';

			this.offsets = $([]);
			this.targets = $([]);

			var self     = this;
			var $targets = this.$body.find(this.selector).map(function () {
				var $el   = $(this);
				var href  = $el.data('target') || $el.attr('href');
				var $href = /^#\w/.test(href) && $(href);

				return ($href && $href.length && [[ $href[offsetMethod]().top + (!$.isWindow(self.$scrollElement.get(0)) && self.$scrollElement.scrollTop()), href ]]) || null
			}).sort(function (a, b) {
				return a[0] - b[0]
			}).each(function () {
				self.offsets.push(this[0]);
				self.targets.push(this[1]);
			});
		}

		ScrollSpy.prototype.process = function () {
			var scrollTop    = this.$scrollElement.scrollTop() + this.options.offset,
				scrollHeight = this.$scrollElement[0].scrollHeight || this.$body[0].scrollHeight,
				maxScroll    = scrollHeight - this.$scrollElement.height(),
				offsets      = this.offsets,
				targets      = this.targets,
				activeTarget = this.activeTarget, i;

			if (scrollTop >= maxScroll) {
				return activeTarget != (i = targets.last()[0]) && this.activate(i);
			}

			for (i = offsets.length; i--;) {
				activeTarget != targets[i] && scrollTop >= offsets[i] && (!offsets[i + 1] || scrollTop <= offsets[i + 1]) && this.activate( targets[i] );
			}

		}

		ScrollSpy.prototype.activate = function (target) {
			this.activeTarget = target;
			$(this.selector).parent('li').removeClass('current-menu-item');
			var selector = this.selector + '[data-target="' + target + '"],' + this.selector + '[href="' + target + '"]';
			var active = $(selector).parents('li').addClass('current-menu-item');
			active.trigger('activate');
		}

		// SCROLLSPY PLUGIN DEFINITION
		// ===========================

		$.fn.scrollspy = function (option) {
			return this.each(function () {
				var $this   = $(this),
					data    = $this.data('bs.scrollspy'),
					options = typeof option == 'object' && option;
				if (!data) {
					 $this.data('bs.scrollspy', (data = new ScrollSpy(this, options)));
				}
				if (typeof option == 'string') { data[option](); }
			});
		}
		
		$.fn.scrollspy.Constructor = ScrollSpy;
		 
		/* ---------------------------------------------------- */
		/*	FitVids												*/
		/* ---------------------------------------------------- */

		$.fn.fitVids = function(options) {
			var settings = {
				customSelector: null
			};

			if (!document.getElementById('fit-vids-style')) {

				var div = document.createElement('div'),
				ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0],
				cssStyles = '&shy;<style>.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>';

				div.className = 'fit-vids-style';
				div.id = 'fit-vids-style';
				div.style.display = 'none';
				div.innerHTML = cssStyles;

				ref.parentNode.insertBefore(div,ref);

			}

			if (options) {
				$.extend(settings, options);
			}

			return this.each(function() {
				var selectors = [
					"iframe[src*='player.vimeo.com']",
					"iframe[src*='youtube.com']",
					"iframe[src*='youtube-nocookie.com']",
					"iframe[src*='kickstarter.com'][src*='video.html']",
					"object",
					"embed"
				];

				if (settings.customSelector) {
					selectors.push(settings.customSelector);
				}

				var $allVideos = $(this).find(selectors.join(','));
				$allVideos = $allVideos.not("object object"); // SwfObj conflict patch

				$allVideos.each(function(){
					var $this = $(this);
					if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) {
						return;
					}
					var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
					width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
					aspectRatio = height / width;
					if(!$this.attr('id')) {
						var videoID = 'fitvid' + Math.floor(Math.random()*999999);
						$this.attr('id', videoID);
					}
					$this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
					$this.removeAttr('height').removeAttr('width');
				});
			});

		};
		
}(jQuery, window, Modernizr, document, CONFIG));

;(function(e,t,n,r){function u(t,n){this.element=t;this.options=e.extend({},o,n);this._defaults=o;this._name=s;this.init()}function a(){return!!("ontouchstart"in t)}function f(){var e=n.body||n.documentElement;var t=e.style;var r="transition";if(typeof t[r]=="string"){return true}v=["Moz","Webkit","Khtml","O","ms"],r=r.charAt(0).toUpperCase()+r.substr(1);for(var i=0;i<v.length;i++){if(typeof t[v[i]+r]=="string"){return true}}return false}var s="tooltipster",o={animation:"fade",arrow:true,arrowColor:"",content:"",delay:200,fixedWidth:0,maxWidth:0,functionInit:function(e,t){},functionBefore:function(e,t){t()},functionReady:function(e,t){},functionAfter:function(e){},icon:"(?)",iconDesktop:false,iconTouch:false,iconTheme:".tooltipster-icon",interactive:false,interactiveTolerance:350,interactiveAutoClose:true,offsetX:0,offsetY:0,onlyOne:true,position:"top",speed:350,timer:0,theme:".tooltipster-default",touchDevices:true,trigger:"hover",updateAnimation:true};var l=true;if(!f()){l=false}var c=a();e(t).on("mousemove.tooltipster",function(){c=false;e(t).off("mousemove.tooltipster")});u.prototype={init:function(){var t=e(this.element);var i=this;var s=true;if(!i.options.touchDevices&&c){s=false}if(n.all&&!n.querySelector){s=false}if(s){var o=e.trim(i.options.content).length>0?i.options.content:t.attr("title");var u=i.options.functionInit(t,o);if(u)o=u;t.data("tooltipsterContent",o);t.removeAttr("title");if(i.options.iconDesktop&&!c||i.options.iconTouch&&c){var a=i.options.iconTheme;var f=e('<span class="'+a.replace(".","")+'"></span>');f.data("tooltipsterContent",o).append(i.options.icon).insertAfter(t);t.data("tooltipsterIcon",f);t=f}if(i.options.touchDevices&&c&&(i.options.trigger=="click"||i.options.trigger=="hover")){t.on("touchstart.tooltipster",function(e,t){i.showTooltip()})}else{if(i.options.trigger=="hover"){t.on("mouseenter.tooltipster",function(){i.showTooltip()});if(i.options.interactive){t.on("mouseleave.tooltipster",function(){var n=t.data("tooltipster");var s=false;if(n!==r&&n!==""){n.mouseenter(function(){s=true});n.mouseleave(function(){s=false});var o=setTimeout(function(){if(s){if(i.options.interactiveAutoClose){n.find("select").on("change",function(){i.hideTooltip()});n.mouseleave(function(t){var n=e(t.target);if(n.parents(".tooltipster-base").length===0||n.hasClass("tooltipster-base")){i.hideTooltip()}else{n.on("mouseleave",function(e){i.hideTooltip()})}})}}else{i.hideTooltip()}},i.options.interactiveTolerance)}else{i.hideTooltip()}})}else{t.on("mouseleave.tooltipster",function(){i.hideTooltip()})}}if(i.options.trigger=="click"){t.on("click.tooltipster",function(){if(t.data("tooltipster")===""||t.data("tooltipster")===r){i.showTooltip()}else{i.hideTooltip()}})}}}},showTooltip:function(t){var n=e(this.element);var i=this;if(n.data("tooltipsterIcon")!==r){n=n.data("tooltipsterIcon")}if(!n.hasClass("tooltipster-disable")){if(e(".tooltipster-base").not(".tooltipster-dying").length>0&&i.options.onlyOne){e(".tooltipster-base").not(".tooltipster-dying").not(n.data("tooltipster")).each(function(){e(this).addClass("tooltipster-kill");var t=e(this).data("origin");t.data("plugin_tooltipster").hideTooltip()})}n.clearQueue().delay(i.options.delay).queue(function(){i.options.functionBefore(n,function(){if(n.data("tooltipster")!==r&&n.data("tooltipster")!==""){var t=n.data("tooltipster");if(!t.hasClass("tooltipster-kill")){var s="tooltipster-"+i.options.animation;t.removeClass("tooltipster-dying");if(l){t.clearQueue().addClass(s+"-show")}if(i.options.timer>0){var o=t.data("tooltipsterTimer");clearTimeout(o);o=setTimeout(function(){t.data("tooltipsterTimer",r);i.hideTooltip()},i.options.timer);t.data("tooltipsterTimer",o)}if(i.options.touchDevices&&c){e("body").bind("touchstart",function(t){if(i.options.interactive){var n=e(t.target);var r=true;n.parents().each(function(){if(e(this).hasClass("tooltipster-base")){r=false}});if(r){i.hideTooltip();e("body").unbind("touchstart")}}else{i.hideTooltip();e("body").unbind("touchstart")}})}}}else{i.options._bodyOverflowX=e("body").css("overflow-x");e("body").css("overflow-x","hidden");var u=i.getContent(n);var a=i.options.theme;var h=a.replace(".","");var s="tooltipster-"+i.options.animation;var p="-webkit-transition-duration: "+i.options.speed+"ms; -webkit-animation-duration: "+i.options.speed+"ms; -moz-transition-duration: "+i.options.speed+"ms; -moz-animation-duration: "+i.options.speed+"ms; -o-transition-duration: "+i.options.speed+"ms; -o-animation-duration: "+i.options.speed+"ms; -ms-transition-duration: "+i.options.speed+"ms; -ms-animation-duration: "+i.options.speed+"ms; transition-duration: "+i.options.speed+"ms; animation-duration: "+i.options.speed+"ms;";var d=i.options.fixedWidth>0?"width:"+Math.round(i.options.fixedWidth)+"px;":"";var v=i.options.maxWidth>0?"max-width:"+Math.round(i.options.maxWidth)+"px;":"";var m=i.options.interactive?"pointer-events: auto;":"";var t=e('<div class="tooltipster-base '+h+" "+s+'" style="'+d+" "+v+" "+m+" "+p+'"></div>');var g=e('<div class="tooltipster-content"></div>');g.html(u);t.append(g);t.appendTo("body");n.data("tooltipster",t);t.data("origin",n);i.positionTooltip();i.options.functionReady(n,t);if(l){t.addClass(s+"-show")}else{t.css("display","none").removeClass(s).fadeIn(i.options.speed)}var y=u;var b=setInterval(function(){var r=i.getContent(n);if(e("body").find(n).length===0){t.addClass("tooltipster-dying");i.hideTooltip()}else if(y!==r&&r!==""){y=r;t.find(".tooltipster-content").html(r);if(i.options.updateAnimation){if(f()){t.css({width:"","-webkit-transition":"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms","-moz-transition":"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms","-o-transition":"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms","-ms-transition":"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms",transition:"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms"}).addClass("tooltipster-content-changing");setTimeout(function(){t.removeClass("tooltipster-content-changing");setTimeout(function(){t.css({"-webkit-transition":i.options.speed+"ms","-moz-transition":i.options.speed+"ms","-o-transition":i.options.speed+"ms","-ms-transition":i.options.speed+"ms",transition:i.options.speed+"ms"})},i.options.speed)},i.options.speed)}else{t.fadeTo(i.options.speed,.5,function(){t.fadeTo(i.options.speed,1)})}}i.positionTooltip()}if(e("body").find(t).length===0||e("body").find(n).length===0){clearInterval(b)}},200);if(i.options.timer>0){var o=setTimeout(function(){t.data("tooltipsterTimer",r);i.hideTooltip()},i.options.timer+i.options.speed);t.data("tooltipsterTimer",o)}if(i.options.touchDevices&&c){e("body").bind("touchstart",function(t){if(i.options.interactive){var n=e(t.target);var r=true;n.parents().each(function(){if(e(this).hasClass("tooltipster-base")){r=false}});if(r){i.hideTooltip();e("body").unbind("touchstart")}}else{i.hideTooltip();e("body").unbind("touchstart")}})}}});n.dequeue()})}},hideTooltip:function(t){var n=e(this.element);var i=this;if(n.data("tooltipsterIcon")!==r){n=n.data("tooltipsterIcon")}var s=n.data("tooltipster");if(s===r){s=e(".tooltipster-dying")}n.clearQueue();if(s!==r&&s!==""){var o=s.data("tooltipsterTimer");if(o!==r){clearTimeout(o)}var u="tooltipster-"+i.options.animation;if(l){s.clearQueue().removeClass(u+"-show").addClass("tooltipster-dying").delay(i.options.speed).queue(function(){s.remove();n.data("tooltipster","");e("body").css("overflow-x",i.options._bodyOverflowX);i.options.functionAfter(n)})}else{s.clearQueue().addClass("tooltipster-dying").fadeOut(i.options.speed,function(){s.remove();n.data("tooltipster","");e("body").css("overflow-x",i.options._bodyOverflowX);i.options.functionAfter(n)})}}},positionTooltip:function(n){var s=e(this.element);var o=this;if(s.data("tooltipsterIcon")!==r){s=s.data("tooltipsterIcon")}if(s.data("tooltipster")!==r&&s.data("tooltipster")!==""){var u=s.data("tooltipster");u.css("width","");var a=e(t).width();var f=s.outerWidth(false);var l=s.outerHeight(false);var c=u.outerWidth(false);var h=u.innerWidth()+1;var p=u.outerHeight(false);var d=s.offset();var v=d.top;var m=d.left;var g=r;if(s.is("area")){var y=s.attr("shape");var b=s.parent().attr("name");var w=e('img[usemap="#'+b+'"]');var E=w.offset().left;var S=w.offset().top;var x=s.attr("coords")!==r?s.attr("coords").split(","):r;if(y=="circle"){var T=parseInt(x[0]);var N=parseInt(x[1]);var C=parseInt(x[2]);l=C*2;f=C*2;v=S+N-C;m=E+T-C}else if(y=="rect"){var T=parseInt(x[0]);var N=parseInt(x[1]);var k=parseInt(x[2]);var L=parseInt(x[3]);l=L-N;f=k-T;v=S+N;m=E+T}else if(y=="poly"){var A=[];var O=[];var M=0,_=0,D=0,P=0;var H="even";for(i=0;i<x.length;i++){var B=parseInt(x[i]);if(H=="even"){if(B>D){D=B;if(i===0){M=D}}if(B<M){M=B}H="odd"}else{if(B>P){P=B;if(i==1){_=P}}if(B<_){_=B}H="even"}}l=P-_;f=D-M;v=S+_;m=E+M}else{l=w.outerHeight(false);f=w.outerWidth(false);v=S;m=E}}if(o.options.fixedWidth===0){u.css({width:Math.round(h)+"px","padding-left":"0px","padding-right":"0px"})}var j=0,F=0,I=0;var q=parseInt(o.options.offsetY);var R=parseInt(o.options.offsetX);var U="";function z(){var n=e(t).scrollLeft();if(j-n<0){var r=j-n;j=n;u.data("arrow-reposition",r)}if(j+c-n>a){var r=j-(a+n-c);j=a+n-c;u.data("arrow-reposition",r)}}function W(n,r){if(v-e(t).scrollTop()-p-q-12<0&&r.indexOf("top")>-1){o.options.position=n;g=r}if(v+l+p+12+q>e(t).scrollTop()+e(t).height()&&r.indexOf("bottom")>-1){o.options.position=n;g=r;I=v-p-q-12}}if(o.options.position=="top"){var X=m+c-(m+f);j=m+R-X/2;I=v-p-q-12;z();W("bottom","top")}if(o.options.position=="top-left"){j=m+R;I=v-p-q-12;z();W("bottom-left","top-left")}if(o.options.position=="top-right"){j=m+f+R-c;I=v-p-q-12;z();W("bottom-right","top-right")}if(o.options.position=="bottom"){var X=m+c-(m+f);j=m-X/2+R;I=v+l+q+12;z();W("top","bottom")}if(o.options.position=="bottom-left"){j=m+R;I=v+l+q+12;z();W("top-left","bottom-left")}if(o.options.position=="bottom-right"){j=m+f+R-c;I=v+l+q+12;z();W("top-right","bottom-right")}if(o.options.position=="left"){j=m-R-c-12;F=m+R+f+12;var V=v+p-(v+s.outerHeight(false));I=v-V/2-q;if(j<0&&F+c>a){var J=parseFloat(u.css("border-width"))*2;var K=c+j-J;u.css("width",K+"px");p=u.outerHeight(false);j=m-R-K-12-J;V=v+p-(v+s.outerHeight(false));I=v-V/2-q}else if(j<0){j=m+R+f+12;u.data("arrow-reposition","left")}}if(o.options.position=="right"){j=m+R+f+12;F=m-R-c-12;var V=v+p-(v+s.outerHeight(false));I=v-V/2-q;if(j+c>a&&F<0){var J=parseFloat(u.css("border-width"))*2;var K=a-j-J;u.css("width",K+"px");p=u.outerHeight(false);V=v+p-(v+s.outerHeight(false));I=v-V/2-q}else if(j+c>a){j=m-R-c-12;u.data("arrow-reposition","right")}}if(o.options.arrow){var Q="tooltipster-arrow-"+o.options.position;if(o.options.arrowColor.length<1){var G=u.css("background-color")}else{var G=o.options.arrowColor}var Y=u.data("arrow-reposition");if(!Y){Y=""}else if(Y=="left"){Q="tooltipster-arrow-right";Y=""}else if(Y=="right"){Q="tooltipster-arrow-left";Y=""}else{Y="left:"+Math.round(Y)+"px;"}if(o.options.position=="top"||o.options.position=="top-left"||o.options.position=="top-right"){var Z=parseFloat(u.css("border-bottom-width"));var et=u.css("border-bottom-color")}else if(o.options.position=="bottom"||o.options.position=="bottom-left"||o.options.position=="bottom-right"){var Z=parseFloat(u.css("border-top-width"));var et=u.css("border-top-color")}else if(o.options.position=="left"){var Z=parseFloat(u.css("border-right-width"));var et=u.css("border-right-color")}else if(o.options.position=="right"){var Z=parseFloat(u.css("border-left-width"));var et=u.css("border-left-color")}else{var Z=parseFloat(u.css("border-bottom-width"));var et=u.css("border-bottom-color")}if(Z>1){Z++}var tt="";if(Z!==0){var nt="";var rt="border-color: "+et+";";if(Q.indexOf("bottom")!==-1){nt="margin-top: -"+Math.round(Z)+"px;"}else if(Q.indexOf("top")!==-1){nt="margin-bottom: -"+Math.round(Z)+"px;"}else if(Q.indexOf("left")!==-1){nt="margin-right: -"+Math.round(Z)+"px;"}else if(Q.indexOf("right")!==-1){nt="margin-left: -"+Math.round(Z)+"px;"}tt='<span class="tooltipster-arrow-border" style="'+nt+" "+rt+';"></span>'}u.find(".tooltipster-arrow").remove();U='<div class="'+Q+' tooltipster-arrow" style="'+Y+'">'+tt+'<span style="border-color:'+G+';"></span></div>';u.append(U)}u.css({top:Math.round(I)+"px",left:Math.round(j)+"px"});if(g!==r){o.options.position=g}}},getContent:function(t){var n=t.data("tooltipsterContent");n=e(e.parseHTML("<div>"+n+"</div>")).html();return n}};e.fn[s]=function(t){if(t&&t==="setDefaults"){e.extend(o,arguments[1])}else{if(typeof t==="string"){var n=this;var i=arguments[1];var a=null;if(n.data("plugin_tooltipster")===r){var f=n.find("*");n=e();f.each(function(){if(e(this).data("plugin_tooltipster")!==r){n.push(e(this))}})}n.each(function(){switch(t.toLowerCase()){case"show":e(this).data("plugin_tooltipster").showTooltip();break;case"hide":e(this).data("plugin_tooltipster").hideTooltip();break;case"disable":e(this).addClass("tooltipster-disable");break;case"enable":e(this).removeClass("tooltipster-disable");break;case"destroy":e(this).data("plugin_tooltipster").hideTooltip();var s=e(this).data("tooltipsterIcon");if(s)s.remove();e(this).attr("title",n.data("tooltipsterContent")).removeData("plugin_tooltipster").removeData("tooltipsterContent").removeData("tooltipsterIcon").off(".tooltipster");break;case"elementicon":a=e(this).data("tooltipsterIcon");a=a?a[0]:r;return false;case"update":var o=i;if(e(this).data("tooltipsterIcon")===r){e(this).data("tooltipsterContent",o)}else{var u=e(this).data("tooltipsterIcon");u.data("tooltipsterContent",o)}break;case"reposition":e(this).data("plugin_tooltipster").positionTooltip();break;case"val":a=e(this).data("tooltipsterContent");console.log(a);return false}});return a!==null?a:this}else{return this.each(function(){if(!e.data(this,"plugin_"+s)){e.data(this,"plugin_"+s,new u(this,t))}})}}};if(c){t.addEventListener("orientationchange",function(){if(e(".tooltipster-base").length>0){e(".tooltipster-base").each(function(){var t=e(this).data("origin");t.data("plugin_tooltipster").hideTooltip()})}},false)}e(t).on("scroll.tooltipster",function(){var t=e(".tooltipster-base").data("origin");if(t){t.tooltipster("reposition")}});e(t).on("resize.tooltipster",function(){var t=e(".tooltipster-base").data("origin");if(t!==null&&t!==r){t.tooltipster("reposition")}})})(jQuery,window,document);
									