$(function () {
	"use strict";

	$(function () {
		$("#menu").metisMenu()
	}),

	$(".mobile-toggle-menu").on("click", function () {
		$(".wrapper").addClass("toggled")
	}),

	// Set theme from localStorage on page load
	(function () {
		const savedTheme = localStorage.getItem('theme');
		if (savedTheme === 'dark') {
			$(".dark-mode-icon i").attr("class", "bx bx-sun");
			$("html").attr("class", "dark-theme");
		} else {
			$(".dark-mode-icon i").attr("class", "bx bx-moon");
			$("html").attr("class", "light-theme");
		}
	})(),

	$(".dark-mode").on("click", function () {
		if ($(".dark-mode-icon i").attr("class") == 'bx bx-sun') {
			$(".dark-mode-icon i").attr("class", "bx bx-moon");
			$("html").attr("class", "light-theme");
			localStorage.setItem('theme', 'light');
		} else {
			$(".dark-mode-icon i").attr("class", "bx bx-sun");
			$("html").attr("class", "dark-theme");
			localStorage.setItem('theme', 'dark');
		}
	}),
	
	$(".toggle-icon").click(function () {
		$(".wrapper").hasClass("toggled") ? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover")) : ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function () {
			$(".wrapper").addClass("sidebar-hovered")
		}, function () {
			$(".wrapper").removeClass("sidebar-hovered")
		}))
	}),

	$(document).ready(function () {
		$(window).on("scroll", function () {
			$(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
		}), $(".back-to-top").on("click", function () {
			return $("html, body").animate({
				scrollTop: 0
			}, 600), !1
		})
	}),

	$(function () {
		for (var e = window.location, o = $(".metismenu li a").filter(function () {
			return this.href == e
		}).addClass("").parent().addClass("mm-active"); o.is("li");) o = o.parent("").addClass("mm-show").parent("").addClass("mm-active")
	})
});