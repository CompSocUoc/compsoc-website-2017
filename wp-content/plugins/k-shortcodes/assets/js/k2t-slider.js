/**
 * Swiper slider.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

(function($) {
    "use strict";

    $(window).load(function() {
        $('.swiper-container').each(function(index, element) {
            var height = $(this).children('.k2t-slide').height();
            var mode = $(this).attr('data-mode');
            var speed = $(this).attr('data-speed');
            var pagin = $(this).attr('data-pagination');
            var mouse_swipe = ($(this).attr('data-mouse_swipe') === 'false');
            var column = $(this).attr('data-column');
            var infinite_scroll = ($(this).attr('data-infinite_scroll') === 'true');
            var mousewheelcontrol = ($(this).attr('data-mousewheelcontrol') === 'true');
            //if(pagin === 'true'){ paginti = true;} else { paginti = false;}

            var pagging = '.swiper-container.k2t' + index + ' .pagination';
            $(this).addClass('k2t' + index);
            var mySwiper = new Swiper(".swiper-container.k2t" + index, {
                //createPagination: paginti,
                loop: infinite_scroll,
                onlyExternal: mouse_swipe, //disable slide by mouse
                speed: speed,
                mousewheelControl: mousewheelcontrol, //disable or enable infinite scroll
                mode: mode,
                paginationClickable: true,
                slidesPerView: column,
            });
            k2t_resize_width_window(this);
            $(window).resize(function() {
                k2t_resize_width_window('.swiper-container.k2t' + index);
            });

            function k2t_resize_width_window(e) {
                var maxHeight = Math.max.apply(null, $(e).find('.k2t-slide').map(function() {
                    return $(this).height();
                }).get());
                $(e).css("height", maxHeight);
            }
        });
    });
})(jQuery);