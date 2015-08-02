$(window).load(function () {
    $('#main').animate({opacity: 1}, 500, function () {
        $(".loader-holder").fadeOut(500);
    });
});
//  functions ------------------
function initGroovi() {
    //  Your date ------------------
    $(".countdown").downCount({
        date: "09/12/2016",
        offset: 0
    });
    //  Swiper ------------------
    var b = new Swiper(".swiper-container", {
        speed: 1500,
        keyboardControl: true,
        tdFlow: {
            rotate: 120,
            depth: 2100
        },
        initialSlide: 1,
        grabCursor: false,
        onSlideChangeStart: function (c) {
            var $current = $("#menu a").eq(b.activeIndex);
            switch ($current.attr('data-page')) {
                // home, video playing, stream paused
                case '0':
                    player.playVideo();
                    break;
                // stream playing, video stopped.
                case '1':
                    player.pauseVideo();
                    break;
                // static page, no strem and no vid
                default:
                    player.pauseVideo();
                    break;
            }
            $("#menu .active").removeClass("active");
            $current.addClass("active");
        }
    });
    $(".go-contact").on("click", function (a) {
        a.preventDefault();
        b.swipeTo(2);
    });
    $(".arrow-left").on("click", function (a) {
        a.preventDefault();
        b.swipePrev();
    });
    $(".arrow-right").on("click", function (a) {
        a.preventDefault();
        b.swipeNext();
    });
    //  Menu ------------------
    $("#menu  a").on("touchstart mousedown", function (a) {
        a.preventDefault();
        $("#menu .active ").removeClass("active");
        $(this).addClass("active");
        b.swipeTo($(this).index());
        setTimeout(function () {
            hideMenu();
        }, 1750);
    });
    function showMenu() {
        $("#nav").removeClass("vis");
        $('.wrapper').addClass('vis-menu');
        $('.nav-button').addClass('cmenu');
        $(".elem").fadeIn(10);
        setTimeout(function () {
            $(".elem-anim").each(function (a) {
                var b = $(this);
                setTimeout(function () {
                    b.animate({opacity: 1, 'margin-top': 0}, 600, "easeOutCubic")
                }, 150 * a);
            });
        }, 650);
    }

    function hideMenu() {
        $("#nav").addClass("vis");
        $('.nav-button').removeClass('cmenu');
        $(".elem-anim").each(function (a) {
            var b = $(this);
            setTimeout(function () {
                b.animate({opacity: 0, 'margin-top': '-150px'}, 600, "easeOutCubic")
            }, 150 * a);
        });
        setTimeout(function () {
            $(".elem").fadeOut(10);
            $('.wrapper').removeClass('vis-menu');
        }, 650);
    }

    $(".nav-button").on("click", function () {
        if ($("#nav").hasClass("vis")) {
            showMenu();
        } else {
            hideMenu();
        }
        return false;
    });
    //  Contact form ------------------
    $("#contactform").submit(function () {
        var a = $(this).attr("action");
        $("#message").slideUp(750, function () {
            $("#message").hide();
            $("#submit").attr("disabled", "disabled");
            $.post(a, {
                name: $("#name").val(),
                email: $("#email").val(),
                comments: $("#comments").val()
            }, function (a) {
                document.getElementById("message").innerHTML = a;
                $("#message").slideDown("slow");
                $("#submit").removeAttr("disabled");
                if (null != a.match("success")) $("#contactform").slideDown("slow");
            });
        });
        return false;
    });
    $("#contactform input, #contactform textarea").keyup(function () {
        $("#message").slideUp(1500);
    });
    $('.show-form').on("click", function () {
        $('.hide-con-info').addClass('vis-form');
        $('.contact-form-holder').addClass('vis-form2');
    });
    $('.close-form').on("click", function () {
        $('.hide-con-info').removeClass('vis-form');
        $('.contact-form-holder').removeClass('vis-form2');
    });
    //  Responsive wideo ------------------
    $(".video-holder").height($(".media-container").height());
    if ($(window).width() > 1024) {
        if ($(".video-holder").size() > 0) if (($(".media-container").height() + 150) / 9 * 16 > $(".media-container").width()) {
            $("iframe , #player").height($(".media-container").height() + 150).width(($(".media-container").height() + 150) / 9 * 16);
            $("iframe , #player").css({
                "margin-left": -1 * $("iframe").width() / 2 + "px",
                top: "-75px",
                "margin-top": "0px"
            });
        } else {
            $("iframe , #player").width($(window).width()).height($(window).width() / 16 * 9);
            $("iframe , #player").css({
                "margin-left": -1 * $("iframe").width() / 2 + "px",
                "margin-top": -1 * $("iframe").height() / 2 + "px",
                top: "50%"
            });
        }
    } else if ($(window).width() < 760) {
        $(".video-holder").height($(".media-container").height());
        $("iframe , #player").height($(".media-container").height());
    } else {
        $(".video-holder").height($(".media-container").height());
        $("iframe , #player").height($(".media-container").height());
    }
}
var playing = true;
$('#audio-control').on("click", function () {
    if (playing == false) {
        document.getElementById('player').play();
        playing = true;

        $(this).removeClass('as');
    } else {
        document.getElementById('player').pause();
        playing = false;
        $(this).addClass('as');
    }

});
//   if mobile------------------
var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows();
    }
};

trueMobile = isMobile.any();

if (trueMobile) $("iframe , #player").remove();
// init  functions ------------------
$(document).ready(function () {
    initGroovi();
});
