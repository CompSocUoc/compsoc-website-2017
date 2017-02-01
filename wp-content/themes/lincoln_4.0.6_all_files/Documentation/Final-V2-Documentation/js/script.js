/*!
 * Documenter 1.6
 * http://rxa.li/documenter
 *
 * Copyright 2011, Xaver Birsak
 * http://revaxarts.com
 *
 */
//if Cufon replace headings
if(typeof Cufon == 'function') Cufon.replace('h1, h2, h3, h4, h5, h6');

$(window).load(function(){

	if ( $().mCustomScrollbar ) $("#documenter_sidebar").mCustomScrollbar();

});
 
$(document).ready(function() {
	var timeout,
		sections = new Array(),
		sectionscount = 0,
		win = $(window),
		sidebar = $('#documenter_sidebar'),
		nav = $('#documenter_nav'),
		logo = $('#documenter_logo'),
		navanchors = nav.find('a'),
		timeoffset = 50,
		hash = location.hash || null;
		iDeviceNotOS4 = (navigator.userAgent.match(/iphone|ipod|ipad/i) && !navigator.userAgent.match(/OS 5/i)) || false,
		badIE = $('html').prop('class').match(/ie(6|7|8)/)|| false;

	$('#documenter_nav ul').each(function(){
		$(this).slideUp();
	});

	$('#documenter_nav a').click(function(){
		if ( ! $(this).hasClass('current') ) {
			if( ! $(this).hasClass('current') ) $('.current').parent().find('ul').each(function(){ $(this).slideUp().removeClass('slide-down') });
			$('.current').removeClass('current');
			$(this).addClass('current');
			$(this).parent().parent().addClass('parent-scroll');
			$('.current').next().slideDown().addClass('slide-down');
		}
	});
		
	//handle external links (new window)
	$('a[href^=http]').bind('click',function(){
		window.open($(this).attr('href'));
		return false;
	});

	$("#documenter_sidebar").bind('mousewheel', function(e, d)  {
	    var t = $(this);
	    if (d > 0 && t.scrollTop() === 0) {
	        e.preventDefault();
	    }
	    else {
	        if (d < 0 && (t.scrollTop() == t.get(0).scrollHeight - t.innerHeight())) {
	            e.preventDefault();
	        }
	    }
	})
	
	//IE 8 and lower doesn't like the smooth pagescroll
	if(!badIE){
		window.scroll(0,0);
		
		$('a[href^=#]').bind('click touchstart',function(){
			hash = $(this).attr('href');
			$.scrollTo.window().queue([]).stop();
			goTo(hash);
			return false;
		});
		
		//if a hash is set => go to it
		if(hash){
			setTimeout(function(){
				goTo(hash);
			},500);
		}
	}
	
	
	//We need the position of each section until the full page with all images is loaded
	win.bind('load',function(){
		
		var sectionselector = 'section';
		
		//Documentation has subcategories		
		if(nav.find('ol').length){
			sectionselector = 'section, h4';
		}
		//saving some information
		$(sectionselector).each(function(i,e){
			var _this = $(this);
			var p = {
				id: this.id,
				pos: _this.offset().top
			};
			sections.push(p);
		});
		
		
		//iPhone, iPod and iPad don't trigger the scroll event
		if(iDeviceNotOS4){
			nav.find('a').bind('click',function(){
				setTimeout(function(){
					win.trigger('scroll');				
				},duration);
				
			});
			//scroll to top
			window.scroll(0,0);
		}

		//how many sections
		sectionscount = sections.length;
		
		//bind the handler to the scroll event
		win.bind('scroll',function(event){
			clearInterval(timeout);
			//should occur with a delay
			timeout = setTimeout(function(){
				//get the position from the very top in all browsers
				pos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
				
				//iDeviceNotOS4s don't know the fixed property so we fake it
				if(iDeviceNotOS4){
					sidebar.css({height:document.height});
					logo.css({'margin-top':pos});
				}
				//activate Nav element at the current position
				activateNav(pos);
			},timeoffset);
		}).trigger('scroll');

	});
	
	//the function is called when the hash changes
	function hashchange(){
		goTo(location.hash, false);
	}
	
	//scroll to a section and set the hash
	function goTo(hash,changehash){
		win.unbind('hashchange', hashchange);
		hash = hash.replace(/!\//,'');
		win.stop().scrollTo(hash,duration,{
			easing:easing,
			axis:'y'			
		});
		if(changehash !== false){
			var l = location;
			location.href = (l.protocol+'//'+l.host+l.pathname+'#!/'+hash.substr(1));
		}
		win.bind('hashchange', hashchange);
	}
	
	//activate current nav element
	function activateNav(pos){
		var offset = 100,
		current, next, parent, isSub, hasSub;
		win.unbind('hashchange', hashchange);
		for(var i=sectionscount;i>0;i--){
			if(sections[i-1].pos <= pos+offset){
				$('.current').removeClass('current');
				$('a[href="' + '#' + sections[i-1].id + '"]').next().addClass('parent-scroll');
				$('a[href="' + '#' + sections[i-1].id + '"]').parent().parent().addClass('parent-scroll');
				$('#documenter_nav').find('ul:not(.parent-scroll)').slideUp();
				var crr_a = $('a[href="' + '#' + sections[i-1].id + '"]');
				crr_a.addClass('current');
				crr_a.parent().parent().slideDown().addClass('slide-down');
				$('.parent-scroll').removeClass('parent-scroll');
				win.bind('hashchange', hashchange);
				break;
			};
		}	
	}
	$(window).scroll(function() {
	    if ($(this).scrollTop()) {
	        $('.gototop').stop(true, true).fadeIn();
	    } else {
	        $('.gototop').stop(true, true).fadeOut();
	    }
	});
	$(".gototop").click(function() {
	  $("html, body").animate({ scrollTop: 0 }, "slow");
	  return false;
	});
	
});