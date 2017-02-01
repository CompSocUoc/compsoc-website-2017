(function($) {
    function isotopeTeacher(target){
        if(jQuery('.teacher-listing').length){
            var $container = $('.teacher-listing');
            var $this = $(this);
            $this.imagesLoaded( function() {
                $container.isotope({
                    itemSelector: '.teacher-classic-item',
                    layoutMode: 'fitRows',
                    filter: target ,
                });
            });
        }
    }

    $(document).ready(function () {
        isotopeTeacher('*');

        $('.k2t-teacher-filter li').click(function () {

            $('.k2t-teacher-filter li').removeClass('active');

            $(this).addClass('active');

            var target = '*';

            if($(this).attr('data-id') != 'all'){

                target = '.filter-char-' + $(this).attr('data-id');
            }

            isotopeTeacher(target);

        });
    });
    
    $(window).load(function(){
        isotopeTeacher('*');
    });

})(jQuery);

