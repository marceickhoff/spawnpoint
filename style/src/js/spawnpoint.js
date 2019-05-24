$(document).ready(function() {
	if (typeof Modernizr !== "undefined") {
		Modernizr.addTest("bug-free-flexbox", function () {
			var testObject = $('<div><div></div><div></div></div>');
			$("body").append(testObject);
			var testObjectChildren = testObject.children();
			testObject.css({display: "flex", "flex-flow": "row wrap", width: "10px"});
			testObjectChildren.css({"flex-basis": "50%", padding: "1px"});
			var supports = testObjectChildren.outerWidth() === 5;
			testObject.remove();
			return supports;
		})
	}
	var $members = $('.member');
	$.get('members.json', function(data) {
		$members.each(function(id) {
			var $member = $(this);
			setTimeout(function() {
				var $avatar = $member.find('.member-avatar');
				var $avatarImage = $avatar.find('.member-avatar-image');
				var $recentlyPlayed = $member.find('.member-recently-played');
				var $mostPlayed = $member.find('.member-most-played');
				$avatar.attr('href', data[id].profileurl);
				$avatarImage.attr('src', data[id].avatar);
				if (data[id].recentlyplayed === null && data[id].mostplayed === null) {
					$recentlyPlayed.parent().parent().on('transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd', function() {
						$(this).hide().siblings().first().removeClass('col-s-4')
					}).addClass('member-fade-out');
				}
				else {
					if (data[id].recentlyplayed === null) $recentlyPlayed.parent().on('transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd', function() {$(this).hide();}).addClass('member-fade-out');
					else $recentlyPlayed.html(data[id].recentlyplayed);
					if (data[id].mostplayed === null) $mostPlayed.parent().on('transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd', function() {$(this).hide();}).addClass('member-fade-out');
					else $mostPlayed.html(data[id].mostplayed);
				}
				$member.addClass('member-loaded');
			}, id * 50);
		});
	});

	function refresh_tsviewer(count) {
		$.get('ts3/viewer.php', function(data) {
			var clientCount = $('#tsviewer').html(data).children('.ts3_viewer.client').length;
			var $clientCounter = $('.tscounter');
			var $clientCount = $clientCounter.find('#tscount');
			var activeClass = 'tscounter-active';
			if (clientCount === 0) $clientCounter.removeClass(activeClass);
			else $clientCounter.addClass(activeClass);
			if (count) {
				var i = 0;
				var timer = setInterval(function(){
					$clientCount.html(i);
					if (i >= clientCount) clearInterval(timer);
					i++;
				}, Math.min(750 / Math.max(1, clientCount), 35));
			}
			else $clientCount.html(clientCount);
		});
	}
	refresh_tsviewer(true);
	setInterval(function(){
		refresh_tsviewer(false);
	}, 2000);

	$(document).on('click', 'a[href^="#"]', function (event) {
		event.preventDefault();
		var id = $.attr(this, 'href');
		$('html, body').animate({
			scrollTop: $(id).offset().top
		}, 500, 'swing', function() {
			window.location.hash = id;
		});
	});

	function tilt() {
		var maxAngle = 30;
		var $element = $('.tilt');

		function getCenter($element) {
			return {
				x: $element.offset().left + $element.width() / 2,
				y: $element.offset().top + $element.height() / 2,
			}
		}

		function getArea(center) {
			return {
				x: Math.max($(window).width() - center.x, center.x),
				y: Math.max($(window).height() - center.y, center.y),
			}
		}

		var center = getCenter($element);
		var area = getArea(center);

		$(window).on('load resize', function() {
			center = getCenter($element);
			area = getArea(center);
		});

		$(document).on('mousemove scroll', function(e) {
			var cursorPercent = {
				x: Math.max(area.x * -1, Math.min(e.pageX - center.x, area.x)) / area.x,
				y: Math.max(area.y * -1, Math.min(e.pageY - center.y, area.y)) / area.y,
			};
			var transform = 'rotateY('+ (cursorPercent.x * maxAngle) +'deg) rotateX('+ (cursorPercent.y * maxAngle * -1) +'deg)';
			$element.css('transform', transform);
		});
	}
	tilt();
});