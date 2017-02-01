(function($) {

	/*  [ Init Function ]
	- - - - - - - - - - - - - - - - - - - */
	$(document).ready(function() {
		/* Filter
        ------------------------------------ */
        if($( '#cd-dropdown' ).length){
           $( '#cd-dropdown' ).dropdown( {
                gutter : 5,
                stack : false,
                delay : 100,
                slidingIn : 100
            } ); 
        }

		if ( $().masonry && $().isotope && $().imagesLoaded ) {
			if(jQuery('.course-listing-masonry-wrapper').length){
				var $this = $(this);
				var container = document.querySelector('.course-listing-masonry');
				$this.imagesLoaded( function() {
					var msnry = new Masonry( container, {
						itemSelector: '.masonry-item',
						columnWidth: container.querySelector('.grid-sizer'),
						gutter: 0
					});
				});
				
				$('.course-listing-masonry-wrapper').each(function(){
					var $this = $(this);
					var $container = $this.find('.course-listing-masonry');
					
					// filter items when filter link is clicked
					$this.find('.cd-dropdown').find('span').click(function(){
						if ( $(this).parent().parent().parent().hasClass('cd-active') ){
                            var selector = $(this).attr('class');
                            $container.isotope({
                                filter: selector,
                            });
                        }
					});

					
					$this.find('.filter-list').find('li').eq(0).addClass('active');
					$this.find('.filter-list').find('li').click(function(){
						if(jQuery(this).hasClass('active')){
							return false;
						}
						var selector = $(this).attr('class');
						$container.isotope({
							filter: selector,
						});
						$(this).parent().find('li').removeClass('active');
						$(this).addClass('active')
					});
				
				});
			}
		}
	}); // ready
	
})(jQuery);

