'use strict';
var Core = function (options) {
    var Window = $(window);
    var Body = $('body');
    var Navbar = $('.navbar');
    var Topbar = $('#topbar');
    var windowH = Window.height();
    var bodyH = Body.height();
    var navbarH = 0;
    var topbarH = 0;
    if (Navbar.is(':visible')) {
        navbarH = Navbar.height();
    }
    if (Topbar.is(':visible')) {
        topbarH = Topbar.height();
    }
    var contentHeight = windowH - (navbarH + topbarH);
    var runSideMenu = function (options) {
        if ($('.nano.affix').length) {
            $(".nano.affix").nanoScroller({preventPageScrolling: true});
        }
        var sidebarLeftToggle = function () {
            if ($('body.sb-top').length) {
                return;
            }
            if (Body.hasClass('sb-l-c') && options.collapse === "sb-l-m") {
                Body.removeClass('sb-l-c');
            }
            Body.toggleClass(options.collapse).removeClass('sb-r-o').addClass('sb-r-c');
            triggerResize();
        };
        var sidebarRightToggle = function () {
            if ($('body.sb-top').length) {
                return;
            }
            if (options.siblingRope === true && !Body.hasClass('mobile-view') && Body.hasClass('sb-r-o')) {
                Body.toggleClass('sb-r-o sb-r-c').toggleClass(options.collapse);
            }
            else {
                Body.toggleClass('sb-r-o sb-r-c').addClass(options.collapse);
            }
            triggerResize();
        };
        var sidebarTopToggle = function () {
            Body.toggleClass('sb-top-collapsed');
        };
        $('.sidebar-toggler').on('click', function (e) {
            e.preventDefault();
            if ($('body.sb-top').length) {
                return;
            }
            Body.addClass('sb-l-c');
            triggerResize();
            if (!Body.hasClass('mobile-view')) {
                setTimeout(function () {
                    Body.toggleClass('sb-l-m sb-l-o');
                }, 250);
            }
        });
        var sbOnLoadCheck = function () {
            if ($('body.sb-top').length) {
                if ($(window).width() < 900) {
                    Body.addClass('sb-top-mobile').removeClass('sb-top-collapsed');
                }
                return;
            }
            if (!$('body.sb-l-o').length && !$('body.sb-l-m').length && !$('body.sb-l-c').length) {
                $('body').addClass(options.sbl);
            }
            if (!$('body.sb-r-o').length && !$('body.sb-r-c').length) {
                $('body').addClass(options.sbr);
            }
            if (Body.hasClass('sb-l-m')) {
                Body.addClass('sb-l-disable-animation');
            }
            else {
                Body.removeClass('sb-l-disable-animation');
            }
            if ($(window).width() < 1281) {
                Body.removeClass('sb-r-o').addClass('mobile-view sb-l-m sb-r-c');
            }
            resizeBody();
        };
        var sbOnResize = function () {
            if ($('body.sb-top').length) {
                if ($(window).width() < 900 && !Body.hasClass('sb-top-mobile')) {
                    Body.addClass('sb-top-mobile');
                } else if ($(window).width() > 900) {
                    Body.removeClass('sb-top-mobile');
                }
                return;
            }
            if ($(window).width() < 1281 && !Body.hasClass('mobile-view')) {
                Body.removeClass('sb-r-o').addClass('mobile-view sb-l-m sb-r-c');
            } else if ($(window).width() > 1281) {
                Body.removeClass('mobile-view');
            } else {
                return;
            }
            resizeBody();
        };
        var resizeBody = function () {
            var sidebarH = $('#sidebar_left').outerHeight();
            var cHeight = (topbarH + navbarH + sidebarH + 21);
            Body.css('min-height', cHeight);
        };
        var triggerResize = function () {
            setTimeout(function () {
                $(window).trigger('resize');
                if (Body.hasClass('sb-l-m')) {
                    Body.addClass('sb-l-disable-animation');
                }
                else {
                    Body.removeClass('sb-l-disable-animation');
                }
            }, 300)
        };
        sbOnLoadCheck();
        $("#sidebar_top_toggle").on('click', sidebarTopToggle);
        $("#sidebar_left_toggle").on('click', sidebarLeftToggle);
        $("#sidebar_right_toggle").on('click', sidebarRightToggle);
        var rescale = function () {
            sbOnResize();
        };
        var lazyLayout = _.debounce(rescale, 300);
        $(window).resize(lazyLayout);
        var authorWidget = $('#sidebar_left .author-widget');
        $('.sidebar-menu-toggle').on('click', function (e) {
            e.preventDefault();
            if ($('body.sb-top').length) {
                return;
            }
            if (authorWidget.is(':visible')) {
                authorWidget.toggleClass('menu-widget-open');
            }
            $('.menu-widget').toggleClass('menu-widget-open').slideToggle('fast');
        });
        $('.sidebar-menu li a.accordion-toggle').on('click', function (e) {
            e.preventDefault();
            if ($('body').hasClass('sb-l-m') && !$(this).parents('ul.sub-nav').length) {
                return;
            }
            if (!$(this).parents('ul.sub-nav').length) {
                if ($(window).width() > 900) {
                    if ($('body.sb-top').length) {
                        return;
                    }
                }
                $('a.accordion-toggle.menu-open').next('ul').slideUp('fast', 'swing', function () {
                    $(this).attr('style', '').prev().removeClass('menu-open');
                });
            }
            else {
                var activeMenu = $(this).next('ul.sub-nav');
                var siblingMenu = $(this).parent().siblings('li').children('a.accordion-toggle.menu-open').next('ul.sub-nav');
                activeMenu.slideUp('fast', 'swing', function () {
                    $(this).attr('style', '').prev().removeClass('menu-open');
                });
                siblingMenu.slideUp('fast', 'swing', function () {
                    $(this).attr('style', '').prev().removeClass('menu-open');
                });
            }
            if (!$(this).hasClass('menu-open')) {
                $(this).next('ul').slideToggle('fast', 'swing', function () {
                    $(this).attr('style', '').prev().toggleClass('menu-open');
                });
            }
        });
    };
    var runFooter = function () {
        var pageFooterBtn = $('.footer-return-top');
        if (pageFooterBtn.length) {
            pageFooterBtn.smoothScroll({offset: -55});
        }
    };
    var runHelpers = function () {
        $.fn.disableSelection = function () {
            return this.attr('unselectable', 'on').css('user-select', 'none').on('selectstart', false);
        };
        $.fn.hasScrollBar = function () {
            return this.get(0).scrollHeight > this.height();
        };

        function msieversion() {
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");
            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                var ieVersion = parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));
                if (ieVersion === 9) {
                    $('body').addClass('no-js ie' + ieVersion);
                }
                return ieVersion;
            }
            else {
                return false;
            }
        }

        msieversion();
        if (!(window.mozInnerScreenX == null)) $('html').addClass('ff');
        setTimeout(function () {
            $('#content').removeClass('animated fadeIn');
        }, 800);
    };
    var runAnimations = function () {
        if (!$('body.boxed-layout').length) {
            setTimeout(function () {
                $('body').addClass('onload-check');
            }, 100);
        }
        $('.animated-delay[data-animate]').each(function () {
            var This = $(this)
            var delayTime = This.data('animate');
            var delayAnimation = 'fadeIn';
            if (delayTime.length > 1 && delayTime.length < 3) {
                delayTime = This.data('animate')[0];
                delayAnimation = This.data('animate')[1];
            }
            var delayAnimate = setTimeout(function () {
                This.removeClass('animated-delay').addClass('animated ' + delayAnimation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    This.removeClass('animated ' + delayAnimation);
                });
            }, delayTime);
        });
        $('.animated-waypoint').each(function (i, e) {
            var This = $(this);
            var Animation = This.data('animate');
            var offsetVal = '35%';
            if (Animation.length > 1 && Animation.length < 3) {
                Animation = This.data('animate')[0];
                offsetVal = This.data('animate')[1];
            }
            var waypoint = new Waypoint({
                element: This, handler: function (direction) {
                    console.log(offsetVal)
                    if (This.hasClass('animated-waypoint')) {
                        This.removeClass('animated-waypoint').addClass('animated ' + Animation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                            This.removeClass('animated ' + Animation);
                        });
                    }
                }, offset: offsetVal
            });
        });
    };
    var runHeader = function () {
        $('.search-form').on('click', function (e) {
            var This = $(this);
            var searchForm = This.find('input');
            var searchRemove = This.find('.search-remove');
            if ($('body.mobile-view').length || $('body.sb-top-mobile').length) {
                This.addClass('search-open');
                if (!searchRemove.length) {
                    This.append('<div class="search-remove"></div>');
                }
                setTimeout(function () {
                    This.find('.search-remove').fadeIn();
                    searchForm.focus().one('keydown', function () {
                        $(this).val('');
                    });
                }, 250);
                if ($(e.target).attr('class') == 'search-remove') {
                    This.removeClass('search-open').find('.search-remove').remove();
                }
            }
        });
        if (jQuery(".info-circle").length > 0) {
            jQuery(".info-circle").each(function () {
                var circle_color = jQuery(this).attr("data-circle-color");
                var circle_color_class = 'circle-text-' + circle_color;
                jQuery(this).addClass(circle_color_class);
            });
        }
        if (jQuery(".progress.vertical").length > 0) {
            jQuery(".progress.vertical").each(function () {
                var skillBar = $(this).find('.progress-bar');
                var skillVal = skillBar.attr("aria-valuenow");
                $(skillBar).css({height: skillVal + '%'});
            });
        }
        if (jQuery(".progress:not(.vertical)").length > 0) {
            jQuery(".progress:not(.vertical)").each(function () {
                var skillBar = $(this).find('.progress-bar');
                var skillVal = skillBar.attr("aria-valuenow");
                $(skillBar).css({width: skillVal + '%'});
            });
        }
        var btnClass = "btn-primary";
        if ($("#user-status").length) {
            $('#user-status').multiselect({
                buttonClass: 'btn ' + btnClass + ' btn-sm btn-bordered btn-bordered',
                buttonWidth: 100,
                dropRight: false
            });
        }
        if ($("#user-role").length) {
            $('#user-role').multiselect({
                buttonClass: 'btn ' + btnClass + ' btn-sm btn-bordered btn-bordered',
                buttonWidth: 100,
                dropRight: true
            });
        }
        var menu = $('#topbar-dropmenu-wrapper');
        var items = menu.find('.service-box');
        var serviceModal = $('.service-modal');
        $('.topbar-dropmenu-toggle').on('click', function () {
            menu.slideToggle(230).toggleClass('topbar-dropmenu-open');
            serviceModal.fadeIn();
        });
        $('body').on('click', '.service-modal', function () {
            serviceModal.fadeOut('fast');
            setTimeout(function () {
                menu.slideToggle(150).toggleClass('topbar-dropmenu-open');
            }, 250);
        });
    };
    var runChutes = function () {
        var chuteFormat = $('#content .chute');
        if (chuteFormat.length) {
            chuteFormat.each(function (i, e) {
                var This = $(e);
                var chuteScroll = This.find('.chute-scroller');
                This.height(contentHeight);
                chuteScroll.height(contentHeight);
                if (chuteScroll.length) {
                    chuteScroll.scroller();
                }
            });
            $('#content').scrollLock('on', 'div');
        }
        var rescale = function () {
            if ($(window).width() < 1281) {
                Body.addClass('chute-rescale');
            }
            else {
                Body.removeClass('chute-rescale chute-rescale-left chute-rescale-right');
            }
        };
        var lazyLayout = _.debounce(rescale, 300);
        if (!Body.hasClass('disable-chute-rescale')) {
            $(window).resize(lazyLayout);
            rescale();
        }
        var navAnimate = $('.chute-nav[data-nav-animate]');
        if (navAnimate.length) {
            var Animation = navAnimate.data('nav-animate');
            if (Animation == null || Animation == true || Animation == "") {
                Animation = "fadeIn";
            }
            setTimeout(function () {
                navAnimate.find('li').each(function (i, e) {
                    var Timer = setTimeout(function () {
                        $(e).addClass('animated animated-short ' + Animation);
                    }, 50 * i);
                });
            }, 500);
        }
        var dataChute = $('.chute[data-chute-mobile]');
        var dataAppend = dataChute.children();

        function fcRefresh() {
            if ($('body').width() < 585) {
                dataAppend.appendTo($(dataChute.data('chute-mobile')));
            }
            else {
                dataAppend.appendTo(dataChute);
            }
        }

        fcRefresh();
        var fcResize = function () {
            fcRefresh();
        };
        var fcLayout = _.debounce(fcResize, 300);
        $(window).resize(fcLayout);
    };
    var chuteIconStyle = function () {
        $('.chute-icon').on("click", function (e) {
            if (jQuery(this).parent().hasClass("hover")) {
                jQuery('.chute-icon-style').removeClass("hover");
            } else {
                jQuery('.chute-icon-style').removeClass("hover");
                jQuery(this).parent().addClass("hover");
            }
        });
        $(document).on("click", function (e) {
            var target = e.target;
            if (!$(target).is('.chute-icon-style') && !$(target).parents().is('.chute-icon-style')) {
                jQuery('.chute-icon-style').removeClass("hover");
            }
        });
    }
    var HorizontalMenu = function () {
        if (jQuery("body.sb-top").length > 0) {
            $(".sidebar-menu > li > a", ".sidebar-left-content").click(function (event) {
                if ($(this).hasClass("menu-open")) {
                    $("a.menu-open", ".sidebar-menu").removeClass("menu-open");
                } else {
                    $("a.menu-open", ".sidebar-menu").removeClass("menu-open");
                    $(this).toggleClass('menu-open')
                }
                if ($(this).attr('href') == '#') {
                    return false;
                } else {
                }
            });
            $(".sidebar-menu > li > .sub-nav > li > a", ".sidebar-left-content").click(function (event) {
                if ($(this).hasClass("menu-open")) {
                    $("a.menu-open", ".sub-nav").removeClass("menu-open");
                } else {
                    $("a.menu-open", ".sub-nav").removeClass("menu-open");
                    $(this).toggleClass('menu-open')
                }
                if ($(this).attr('href') == '#') {
                    return false;
                } else {
                }
            });
        }
    }
    var runFormElements = function () {
        var Tooltips = $("[data-toggle=tooltip]");
        if (Tooltips.length) {
            if (Tooltips.parents('#sidebar_left')) {
                Tooltips.tooltip({
                    container: $('body'),
                    template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                });
            } else {
                Tooltips.tooltip();
            }
        }
        var Popovers = $("[data-toggle=popover]");
        if (Popovers.length) {
            Popovers.popover();
        }
        $('.dropdown-menu.keep-dropdown').on('click', function (e) {
            e.stopPropagation();
        });
        $('.dropdown-menu .nav-tabs li a').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).tab('show')
        });
        $('.dropdown-menu .btn-group-nav a').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).siblings('a').removeClass('active').end().addClass('active').tab('show');
        });
        if ($('.btn-states').length) {
            $('.btn-states').on('click', function () {
                $(this).addClass('active').siblings().removeClass('active');
            });
        }
        var panelScroller = $('.panel-scroller');
        if (panelScroller.length) {
            panelScroller.each(function (i, e) {
                var This = $(e);
                var Delay = This.data('scroller-delay');
                var Margin = 5;
                if (This.hasClass('scroller-thick')) {
                    Margin = 0;
                }
                var DropMenuParent = This.parents('.dropdown-menu');
                if (DropMenuParent.length) {
                    DropMenuParent.prevAll('.dropdown-toggle').on('click', function () {
                        setTimeout(function () {
                            This.scroller();
                            $('.navbar').scrollLock('on', 'div');
                        }, 50);
                    });
                    return;
                }
                if (Delay) {
                    var Timer = setTimeout(function () {
                        This.scroller({trackMargin: Margin,});
                        $('#content').scrollLock('on', 'div');
                    }, Delay);
                }
                else {
                    This.scroller({trackMargin: Margin,});
                    $('#content').scrollLock('on', 'div');
                }
            });
        }
        var SmoothScroll = $('[data-smoothscroll]');
        if (SmoothScroll.length) {
            SmoothScroll.each(function (i, e) {
                var This = $(e);
                var Offset = This.data('smoothscroll');
                var Links = This.find('a');
                Links.smoothScroll({offset: Offset});
            });
        }
    };
    return {
        init: function (options) {
            var defaults = {sbl: "sb-l-o", sbr: "sb-r-c", sbState: "save", collapse: "sb-l-m", siblingRope: true};
            var options = $.extend({}, defaults, options);
            runHelpers();
            runAnimations();
            runHeader();
            runSideMenu(options);
            runFooter();
            runChutes();
            runFormElements();
            chuteIconStyle();
            HorizontalMenu();
        }
    }
}();
var bgPrimary = '#6d5cae', bgPrimaryL = '#48b0f7', bgPrimaryLr = '#10cfbd', bgPrimaryD = '#aedbfa',
    bgPrimaryDr = '#40c1d0', bgSuccess = '#C3D62D', bgSuccessL = '#CADB47', bgSuccessLr = '#10cfbd',
    bgSuccessD = '#AEBF25', bgSuccessDr = '#a2b31c', bgInfo = '#12c7b7', bgInfoL = '#68DEBB', bgInfoLr = '#78e8c7',
    bgInfoD = '#9fede6', bgInfoDr = '#29c598', bgWarning = '#FF7022', bgWarningL = '#FF8441', bgWarningLr = '#ff8e51',
    bgWarningD = '#FF5C03', bgWarningDr = '#f05704', bgDanger = '#F5393D', bgDangerL = '#F6565A',
    bgDangerLr = '#6d5cae', bgDangerD = '#F41C20', bgDangerDr = '#e61418', bgAlert = '#FFBC0B', bgAlertL = '#FFC42A',
    bgAlertLr = '#ffc837', bgAlertD = '#EBAB00', bgAlertDr = '#dca001', bgSystem = '#c3b4ef', bgSystemL = '#6852b2',
    bgSystemLr = '#756da5', bgSystemD = '#4D4773', bgSystemDr = '#413b67', bgLight = '#FAFAFA', bgLightL = '#FEFEFE',
    bgLightLr = '#ffffff', bgLightD = '#F2F2F2', bgLightDr = '#e7e7e7', bgDark = '#2a2f43', bgDarkL = '#363C56',
    bgDarkLr = '#404661', bgDarkD = '#1E2230', bgDarkDr = '#171b28', bgBlack = '#273847', bgBlackL = '#2a3241',
    bgBlackLr = '#34495a', bgBlackD = '#1a2620', bgBlackDr = '#0e151a';
if (jQuery("body.with-customizer").length > 0) {
    var custom_options = '<div id="customizer" class="hidden-xs">';
    custom_options += '<div class="panel">';
    custom_options += '<div class="panel-heading">';
    custom_options += '<span class="panel-icon">';
    custom_options += '<i class="fa fa-cogs"></i>';
    custom_options += '</span>';
    custom_options += '<span class="panel-title"> Theme Options</span>';
    custom_options += '</div>';
    custom_options += '<div class="panel-body pn">';
    custom_options += '<ul class="nav nav-list nav-list-sm" role="tablist">';
    custom_options += '<li class="active">';
    custom_options += '<a href="#customizer-header" role="tab" data-toggle="tab">Navbar</a>';
    custom_options += '</li>';
    custom_options += '<li>';
    custom_options += '<a href="#customizer-sidebar" role="tab" data-toggle="tab">Sidebar</a>';
    custom_options += '</li>';
    custom_options += '<li>';
    custom_options += '<a href="#customizer-settings" role="tab" data-toggle="tab">Misc</a>';
    custom_options += '</li>';
    custom_options += '</ul>';
    custom_options += '<div class="tab-content p20 ptn pb15">';
    custom_options += '<div role="tabpanel" class="tab-pane active" id="customizer-header">';
    custom_options += '<form id="customizer-header-skin">';
    custom_options += '<h6 class="mv20">Header Skins</h6>';
    custom_options += '<div class="customizer-sample">';
    custom_options += '<table>';
    custom_options += '<tr>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom fill checkbox-dark mb10">';
    custom_options += '<input type="radio" name="headerSkin" id="headerSkin5" value="bg-dark">';
    custom_options += '<label for="headerSkin5">Dark</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom fill checkbox-warning mb10">';
    custom_options += '<input type="radio" name="headerSkin" id="headerSkin2" value="bg-warning">';
    custom_options += '<label for="headerSkin2">Warning</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '</tr>';
    custom_options += '<tr>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom fill checkbox-danger mb10">';
    custom_options += '<input type="radio" name="headerSkin" id="headerSkin3" value="bg-danger">';
    custom_options += '<label for="headerSkin3">Danger</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom fill checkbox-success mb10">';
    custom_options += '<input type="radio" name="headerSkin" id="headerSkin4" value="bg-success">';
    custom_options += '<label for="headerSkin4">Success</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '</tr>';
    custom_options += '<tr>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom fill checkbox-primary mb10">';
    custom_options += '<input type="radio" name="headerSkin" id="headerSkin6" value="bg-primary">';
    custom_options += '<label for="headerSkin6">Primary</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom fill checkbox-info mb10">';
    custom_options += '<input type="radio" name="headerSkin" id="headerSkin7" value="bg-info">';
    custom_options += '<label for="headerSkin7">Info</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '</tr>';
    custom_options += '<tr>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom fill checkbox-alert mb10">';
    custom_options += '<input type="radio" name="headerSkin" id="headerSkin8" value="bg-alert">';
    custom_options += '<label for="headerSkin8">Alert</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom fill checkbox-system mb10">';
    custom_options += '<input type="radio" name="headerSkin" id="headerSkin9" value="bg-system">';
    custom_options += '<label for="headerSkin9">System</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '</tr>';
    custom_options += '</table>';
    custom_options += '<div class="checkbox-custom checkbox-disabled fill mb10">';
    custom_options += '<input type="radio" name="headerSkin" id="headerSkin1" checked value="bgc-light">';
    custom_options += '<label for="headerSkin1">Light</label>';
    custom_options += '</div>';
    custom_options += '</div>';
    custom_options += '</form>';
    custom_options += '<form id="customizer-footer-skin">';
    custom_options += '<h6 class="mv20">Footer Skins</h6>';
    custom_options += '<div class="customizer-sample">';
    custom_options += '<table>';
    custom_options += '<tr>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom fill checkbox-dark mb10">';
    custom_options += '<input type="radio" name="footerSkin" id="footerSkin1" checked value="">';
    custom_options += '<label for="footerSkin1">Dark</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '<td>';
    custom_options += '<div class="checkbox-custom checkbox-disabled fill mb10">';
    custom_options += '<input type="radio" name="footerSkin" id="footerSkin2" value="footer-light">';
    custom_options += '<label for="footerSkin2">Light</label>';
    custom_options += '</div>';
    custom_options += '</td>';
    custom_options += '</tr>';
    custom_options += '</table>';
    custom_options += '</div>';
    custom_options += '</form>';
    custom_options += '</div>';
    custom_options += '<div role="tabpanel" class="tab-pane" id="customizer-sidebar">';
    custom_options += '<form id="customizer-sidebar-skin">';
    custom_options += '<h6 class="mv20">Sidebar Skins</h6>';
    custom_options += '<div class="customizer-sample">';
    custom_options += '<div class="checkbox-custom fill checkbox-dark mb10">';
    custom_options += '<input type="radio" name="sidebarSkin" checked id="sidebarSkin2" value="">';
    custom_options += '<label for="sidebarSkin2">Dark</label>';
    custom_options += '</div>';
    custom_options += '<div class="checkbox-custom fill checkbox-disabled mb10">';
    custom_options += '<input type="radio" name="sidebarSkin" id="sidebarSkin1" value="sidebar-light">';
    custom_options += '<label for="sidebarSkin1">Light</label>';
    custom_options += '</div>';
    custom_options += '</div>';
    custom_options += '</form>';
    custom_options += '</div>';
    custom_options += '<div role="tabpanel" class="tab-pane" id="customizer-settings">';
    custom_options += '<form id="customizer-settings-misc">';
    custom_options += '<h6 class="mv20 mtn">Layout Options</h6>';
    custom_options += '<div class="form-group">';
    custom_options += '<div class="checkbox-custom fill mb10">';
    custom_options += '<input type="checkbox" checked="" id="header-option">';
    custom_options += '<label for="header-option">Fixed Header</label>';
    custom_options += '</div>';
    custom_options += '</div>';
    custom_options += '<div class="form-group">';
    custom_options += '<div class="checkbox-custom fill mb10">';
    custom_options += '<input type="checkbox" checked="" id="sidebar-option">';
    custom_options += '<label for="sidebar-option">Fixed Sidebar</label>';
    custom_options += '</div>';
    custom_options += '</div>';
    custom_options += '<div class="form-group">';
    custom_options += '<div class="checkbox-custom fill mb10">';
    custom_options += '<input type="checkbox" id="breadcrumb-option">';
    custom_options += '<label for="breadcrumb-option">Fixed Breadcrumbs</label>';
    custom_options += '</div>';
    custom_options += '</div>';
    custom_options += '<div class="form-group">';
    custom_options += '<div class="checkbox-custom fill mb10">';
    custom_options += '<input type="checkbox" id="breadcrumb-hidden">';
    custom_options += '<label for="breadcrumb-hidden">Hide Breadcrumbs</label>';
    custom_options += '</div>';
    custom_options += '</div>';
    custom_options += '</form>';
    custom_options += '</div>';
    custom_options += '</div>';
    custom_options += '<div class="form-group mn pb35 pt25 text-center">';
    custom_options += '<a href="#" id="clearAll" class="btn btn-primary btn-bordered btn-sm">Clear All</a>';
    custom_options += '</div>';
    custom_options += '</div>';
    custom_options += '</div>';
    custom_options += '</div>';

}