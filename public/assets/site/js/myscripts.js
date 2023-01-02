/*=================================
// Ballon
==================================*/
$('#ballon-area').mouseenter(function(){
var cur = Number($('#ballon-area .color').attr('data-level'));
  
var next = cur+1;
$('#ballon-area .color').addClass('level'+next , {duration:500})
}).mouseleave(function(){

var cur = Number($('#ballon-area .color').attr('data-level'));
  var next = cur+1;
$('#ballon-area .color').removeClass('level'+next , {duration:500}).addClass('level'+cur , {duration:500})
})

/*=================================
// Animated Menu Icon
==================================*/
$('[data-toggle="collapse"]').on('click', function() {
    var $this = $(this),
            $parent = typeof $this.data('parent')!== 'undefined' ? $($this.data('parent')) : undefined;
    if($parent === undefined) { /* Just toggle my  */
        $this.find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
        return true;
    }

    /* Open element will be close if parent !== undefined */
    var currentIcon = $this.find('.glyphicon');
    currentIcon.toggleClass('glyphicon-plus glyphicon-minus');
    $parent.find('.glyphicon').not(currentIcon).removeClass('glyphicon-minus').addClass('glyphicon-plus');

});
/*=================================
// Animation Script Single Effect
==================================*/
jQuery(document).ready(function() {
	   $('#menu,#logo-area .title-big').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated2 slideInRight', // Class to add to the elements when they are visible
	    offset: 100    
	   });
	   $('#welcome-area, #logo-area .title-small,#copyright').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated2 slideInLeft', // Class to add to the elements when they are visible
	    offset: 100    
	   });

	   $('#logo-area a').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated bounce', // Class to add to the elements when they are visible
	    offset: 200    
	   })

	   $('#logo-area img').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated shake', // Class to add to the elements when they are visible
	    offset: 500    
	   })

});

$(document).ready(function () {
    var i = 0;
    var posts = $('#center-items li,#top-footer .row .col-md-4,#mid-footer .form-group,#foot-slider .item .col-md-2').children();

    function animateCircle() {
        if (i % 2 === 0) {
            $(posts[i]).viewportChecker({
                classToAdd: 'visible animated fadeInDown',
                offset: 100
            });
        } else {
            $(posts[i]).viewportChecker({
                classToAdd: 'visible animated fadeInUp',
                offset: 100
            });
        }
        i++;
        if (i <= posts.length) {
            startAnimation();
        }
    }

    function startAnimation() {
        setTimeout(function () {
            animateCircle();
        }, 100);
    }

    posts.addClass('hidden');
    animateCircle(posts);
});	
/*=================================
// Right Menu
==================================*/
$(document).ready(function(){
	$(document).on("click", "#left ul.nav li.parent > a > span.sign", function () {
		$(this).find('i:first').toggleClass("icon-minus");
	});

	// Open Le current menu
	$("#left ul.nav li.parent.active > a > span.sign").find('i:first').addClass("icon-minus");
	$("#left ul.nav li.current").parents('ul.children').addClass("in");
	$('#right-dr-menu ul').each(function(index, object){
		$(object).removeClass('in')
	})
});
/*=================================
// Nav Icon
==================================*/
$(document).ready(function(){
	$('#menu a.main').click(function(){
		$('#nav-icon').toggleClass('open');
	});
});
/*=================================
// MY Accordion
==================================*/
$('#myaccordion li').click(function (e) {
	var id = e.target.id;
	$('#myaccordion li').removeClass('active').addClass('deactive');
	$(this).addClass('active').removeClass('deactive');
	$('.content').hide();
	$('#accordion-content #content' + id).show();
})
/*=================================
// Tags
==================================*/
$('#tags').select2({
	data: [],
	tags: true,
	tokenSeparators: [','],
	placeholder: "توانایی خود را انتخاب کنید"
});
/*=================================
// Add Input 
==================================*/
/* Register Form */
$(function () {
	var scntDiv = $('#input-wrap');
	var i = $('#input-wrap div').size() + 1;

	$('#addinput').on('click', function () {
		$('<div class="form-group  form-inline "><label style="opacity:0;visibility:hidden">عنوان مقاله شما : </label><input type="text" class="form-control"><a href="#" id="remScnt"> حذف </a></div>').appendTo(scntDiv);
		i++;
		return false;
	});

	$('#input-wrap').on('click', 'a', function () {
		if (i > 2) {
			$(this).parent('div').remove();
			i--;
		}
		return false;
	});
});
$(function () {
	var scntDiv = $('#input-wrap2');
	var i = $('#input-wrap2 div').size() + 1;

	$('#addinput2').on('click', function () {
		$('<div class="form-group  form-inline "><label style="opacity:0;visibility:hidden">عنوان ثبت اختراع : </label><input type="text" class="form-control"><a href="#" id="remScnt2"> حذف </a></div>').appendTo(scntDiv);
		i++;
		return false;
	});

	$('#input-wrap2').on('click', 'a', function () {
		if (i > 2) {
			$(this).parent('div').remove();
			i--;
		}
		return false;
	});
});
$(function () {
	var scntDiv = $('#input-wrap3');
	var i = $('#input-wrap3 div').size() + 1;

	$('#addinput3').on('click', function () {
		$('<div class="form-group  form-inline "><label style="opacity:0;visibility:hidden">  عنوان ایده : </label><input type="text" class="form-control"><a href="#" id="remScnt3"> حذف </a></div>').appendTo(scntDiv);
		i++;
		return false;
	});

	$('#input-wrap3').on('click', 'a', function () {
		if (i > 2) {
			$(this).parent('div').remove();
			i--;
		}
		return false;
	});
});
/*=================================
// Sticky Menu
==================================*/
$(document).ready(function () {
	var stickyNavTop = $('.menu-area').offset().top;

	var stickyNav = function () {
		var scrollTop = $(window).scrollTop();

		if (scrollTop > stickyNavTop) {
			$('.menu-area').addClass('menu-sticky');
		} else {
			$('.menu-area').removeClass('menu-sticky');
		}
	};

	stickyNav();

	$(window).scroll(function () {
		stickyNav();
	});
});
/*=================================
// Close Notification
==================================*/
$('.notification-area .close').click(function (e) {
	e.preventDefault();
	$('.notification-area').hide()

})
/*=================================
// Welcome Area
==================================*/
$('#welcome-area .msg').click(function () {
		$('#welcome-area').toggleClass('closed')
})
/*=================================
// Main Menu
==================================*/
$('#menu .main').click(function () {
		$('#menu').toggleClass('closed')
})
/*=================================
// Tooltip Plugin
==================================*/
$(function () {
	$('.social-items ul li img').powerTip({
		placement: 'ne' // north-east tooltip position
	});
	$('#video-wrapper .animation img').powerTip({
		placement: 'ne' // north-east tooltip position
	});
});
/*=================================
// Animate Scroll Top
==================================*/
$('a[href=#top]').click(function () {
	$('html, body').animate({
		scrollTop: 0
	}, 'slow');
});
/*=================================
// Bootstrap Tooltip
==================================*/

$('#welcome .clickable').click(function () {
	$('#color li ul').hide();
	$('#welcome li ul').toggle()
});
$('#color .clickable').click(function () {
	$('#welcome li ul').hide();
	$('#color li ul').toggle()
})
/*=================================
// Bootstrap Tooltip
==================================*/
$(document).ready(function () {
	$('[data-toggle="tooltip"]').tooltip();
});
/*=================================
// Animated Canvas Background
==================================*/
(function () {

	var width, height, largeHeader, canvas, ctx, points, target, animateHeader = true;

	// Main
	initHeader();
	initAnimation();
	addListeners();

	function initHeader() {
		width = window.innerWidth;
		height = window.innerHeight;
		target = {
			x: width / 2,
			y: height / 2
		};

		largeHeader = document.getElementById('large-header');
		largeHeader.style.height = height + 'px';

		canvas = document.getElementById('demo-canvas');
		canvas.width = width;
		canvas.height = height;
		ctx = canvas.getContext('2d');

		// create points
		points = [];
		for (var x = 0; x < width; x = x + width / 20) {
			for (var y = 0; y < height; y = y + height / 20) {
				var px = x + Math.random() * width / 20;
				var py = y + Math.random() * height / 20;
				var p = {
					x: px,
					originX: px,
					y: py,
					originY: py
				};
				points.push(p);
			}
		}

		// for each point find the 5 closest points
		for (var i = 0; i < points.length; i++) {
			var closest = [];
			var p1 = points[i];
			for (var j = 0; j < points.length; j++) {
				var p2 = points[j]
				if (!(p1 == p2)) {
					var placed = false;
					for (var k = 0; k < 5; k++) {
						if (!placed) {
							if (closest[k] == undefined) {
								closest[k] = p2;
								placed = true;
							}
						}
					}

					for (var k = 0; k < 5; k++) {
						if (!placed) {
							if (getDistance(p1, p2) < getDistance(p1, closest[k])) {
								closest[k] = p2;
								placed = true;
							}
						}
					}
				}
			}
			p1.closest = closest;
		}

		// assign a circle to each point
		for (var i in points) {
			var c = new Circle(points[i], 2 + Math.random() * 2, 'rgba(255,255,255,0.3)');
			points[i].circle = c;
		}
	}

	// Event handling
	function addListeners() {
		if (!('ontouchstart' in window)) {
			window.addEventListener('mousemove', mouseMove);
		}
		window.addEventListener('scroll', scrollCheck);
		window.addEventListener('resize', resize);
	}

	function mouseMove(e) {
		var posx = posy = 0;
		if (e.pageX || e.pageY) {
			posx = e.pageX;
			posy = e.pageY;
		} else if (e.clientX || e.clientY) {
			posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
			posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
		}
		target.x = posx;
		target.y = posy;
	}

	function scrollCheck() {
		if (document.body.scrollTop > height) animateHeader = false;
		else animateHeader = true;
	}

	function resize() {
		width = window.innerWidth;
		height = window.innerHeight;
		largeHeader.style.height = height + 'px';
		canvas.width = width;
		canvas.height = height;
	}

	// animation
	function initAnimation() {
		animate();
		for (var i in points) {
			shiftPoint(points[i]);
		}
	}

	function animate() {
		if (animateHeader) {
			ctx.clearRect(0, 0, width, height);
			for (var i in points) {
				// detect points in range
				if (Math.abs(getDistance(target, points[i])) < 40000) {
					points[i].active = 0.3;
					points[i].circle.active = 0.6;
				} else if (Math.abs(getDistance(target, points[i])) < 20000) {
					points[i].active = 0.1;
					points[i].circle.active = 0.3;
				} else if (Math.abs(getDistance(target, points[i])) < 40000) {
					points[i].active = 0.02;
					points[i].circle.active = 0.1;
				} else {
					points[i].active = 0;
					points[i].circle.active = 0;
				}

				drawLines(points[i]);
				points[i].circle.draw();
			}
		}
		requestAnimationFrame(animate);
	}

	function shiftPoint(p) {
		TweenLite.to(p, 1 + 1 * Math.random(), {
			x: p.originX - 50 + Math.random() * 100,
			y: p.originY - 50 + Math.random() * 100,
			ease: Circ.easeInOut,
			onComplete: function () {
				shiftPoint(p);
			}
		});
	}

	// Canvas manipulation
	function drawLines(p) {
		if (!p.active) return;
		for (var i in p.closest) {
			ctx.beginPath();
			ctx.moveTo(p.x, p.y);
			ctx.lineTo(p.closest[i].x, p.closest[i].y);
			ctx.strokeStyle = 'rgba(156,217,249,' + p.active + ')';
			ctx.stroke();
		}
	}

	function Circle(pos, rad, color) {
		var _this = this;

		// constructor
		(function () {
			_this.pos = pos || null;
			_this.radius = rad || null;
			_this.color = color || null;
		})();

		this.draw = function () {
			if (!_this.active) return;
			ctx.beginPath();
			ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
			ctx.fillStyle = 'rgba(156,217,249,' + _this.active + ')';
			ctx.fill();
		};
	}

	// Util
	function getDistance(p1, p2) {
		return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
	}

})();