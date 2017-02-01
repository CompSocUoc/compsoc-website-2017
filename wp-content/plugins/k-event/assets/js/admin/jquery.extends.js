// jQuery extends
/*====== Plugin ======*/
/* Definition of BlueBox (popup) */
(function($){
	"use strict";
	var BlueBox = function(id){
		this.id = typeof id != 'undefined' ? id : '#undefined';
		this.window = window;
		this.window['Bluebox'+id] = this;
		this.width = this.window.innerWidth*0.65;
		this.height = this.window.innerHeight*0.75;
		this.handler = false;//would be equal to 'iframe'
		this.stack = {};
		this.css = {};
		this.subject = '.bluebox-subject';
		this.param = {};
		this.makeCopy = false;
		this._clear = false;
	};
	
	BlueBox.prototype = {
		init: function(subject, options){
			this.subject = subject || this.subject;
			var options = typeof options == 'object' ? options : {};			
			this.setOptions(options);
			this.createBox();
			this.bindEscape();
			this.bindWindowResize();
			return this;
		},
		setOptions: function(options, callback){
			var $this = this;
			$.each(options, function(i,o){
				$this[i] = o;
			});
			
			if( typeof this.needle == 'undefined' ){
				this.needle = '#bluebox-btn';
			}
			
			this.document = this.window.document;
			this._clear = true;
			
			if( typeof callback == 'function' ){
				callback();
			}
			//console.log(this.width,this.height);
			return this;
		},
		set: function(key, value, replace){
			var replace = replace || true;
			if( typeof key == "object" || typeof key == "array" ){
				for(var i in key){
					this.set(i, key[i]);	
				}
			}
			else{
				if(!replace && typeof this[key] != "undefined"){
					return this;
				}
				this[key] = value;	
			}
			
			return this;
		},
		get: function(key){
			return this[key] || null;
		},
		listen: function(Event, needle){
			var $this = this;
			var selector;
			if( typeof needle == 'undefined' ){
				selector = this.needle;
			}
			
			$(document).on(Event, selector, function(e){
				e.preventDefault();
				$this.open(needle, $this.subject);
			});
			
			return this;
		},
		specify: function(elem){
			if( typeof elem != 'undefined' ){
				var element;
				if( elem.jquery != 'undefined' ){
					element = elem;
				}
				else if( $(elem).length > 0 ){
					element = $(elem);
				}
				
				return $(element);
			}
			else{
				return null;
			}
			
		},
		createBox: function(){
			var $this = this, box = '', background = this.background || '#FFF';
			$this.background = background;
			
			box += '<div class="bluebox-bg" style="position:fixed; left:0; top:0; right:0; bottom:0; z-index: 1; background-color: #222; opacity: 0.6;"></div>';
			box += '<div class="bluebox-content"><div class="content-wrapper"></div></div>';
			box = '<div class="bluebox" id="'+$this.id.replace('#','')+'" style="position: fixed; top:0; left:0; z-index: 999999; width:100%; height: 100%; display:none">' + box + '</div>';
			
			$(document).ready(function(e){
				$($this.document).find('body').append(box);
				$this.blueBox = $($this.document).find($this.id);
				$this.blueBoxContent = $this.blueBox.find('.bluebox-content');
				$this.contentWrapper = $this.blueBoxContent.find('.content-wrapper');
				
				$this.blueBox.css({
					'position': 'fixed', 'top': 0, 'left': 0, 'z-index': 999999, 'width': '100%', 'height': '100%', 'display':'none'
				});
				$this.blueBoxContent.css({
					'width'	   : $this.width,
					'height'   : $this.height,
					'position' : 'relative',
					'left'	   : ($this.window.innerWidth - $this.width)/2,
					'top' 	   : ($this.window.innerHeight - $this.height)/2,
					'z-index'  : 2,
					'overflow' : 'hidden',
					'padding'  : 0,
					'background-color': $this.background,
					'border'   : $this.border,
					'border-radius' : $this.border_radius
				});
				$this.contentWrapper.css({
					height: '100%'
				});
				if( $this.styleBg ){
					$this.blueBox.find('.bluebox-bg').css($this.styleBg);
				}
			
			});
			
			
			return $this;
		},
		addEvent: function(Event, selector, callback){
			if( !this.stack[Event] ){
				this.stack[Event] = {};
			}
			this.stack[Event][selector] = callback;
			return this;
		},
		triggerEvents: function(){
			var $this = this;
			$.each(this.stack, function(Event, Obj){
				$.each(Obj, function(selector){
					$this.triggerEvent(Event, selector);
				});
			});
			
			return this;
		},
		triggerEvent: function(Event, selector){
			if( !(this.stack[Event]) ){
				return this;
			}
			
			if( typeof selector != 'undefined' ){
				 if( this.stack[Event][selector] ){
				 	var callback = this.stack[Event][selector];
				 	this.trigger(Event, selector, callback);
				 }
			}
			else{
				var $this = this;
				$.each(this.stack[Event], function(selector, callback){
					$this.trigger(Event, selector, callback);
				});
			}
			
			return this;
		},
		trigger: function(Event, selector, callback){
			var $this = this;
			if( this.specify(selector) ){
				$(this.document).find(selector).unbind(Event).bind(Event, function(e){
					e.preventDefault();
					
					if( typeof callback == 'function' ){
						callback.call(null, $this);
					}
					else if( typeof callback == 'string' ){
						eval(callback);
					}
				});
			}
			
			return this;
		},
		open: function(needle, subject){
			var $this = this;
			needle = this.specify(needle) || this.needle;
			subject = this.specify(subject) || $(this.subject);
			//this.addEvent('click', this.id+' .bluebox-bg', function(){ $this.close(); });
			this.triggerEvents();
			//this.clear();
			if( $this.makeCopy ){
				this.clear();
				$this.contentWrapper.append(subject.html());
			}
			else{
				$this.contentWrapper.append(subject);
			}
			$this.blueBox.fadeIn(200);
			$(this.id).find('.content-wrapper > *').show();
			//this.bindEscape();
			//this.trigger('keypress', document, function(e){ $this.escape(); });
			return $this;
		},
		close: function(fast){
			if( !fast ){
				this.blueBox.fadeOut(100);
			}
			else{
				this.blueBox.hide();
			}
		},
		bindEscape: function(){
			var $this = this;
			$(document).unbind('keydown.bluebox').bind('keydown.bluebox', function(e){
				var keycode = e.charCode || e.keyCode;
				if( keycode == 27 ){
					$this.close();
				}
			});
		},
		bindWindowResize: function(){},
		clear: function(elem){
			var Elem = elem;
			var $this = this;
			
			if( elem ){
				elem = this.specify(elem);
				if( elem.length < 1 ){
					elem = $(this.document).find(Elem);
				}
				
				elem.empty();
			}
			else{
				$this.contentWrapper.empty();
			}
			
			return this;
		},
		styleBackground: function(bg){
			this.styleBg = bg;
			return this;
		},
		issetElem: function(selector){
			return ( $(this.document).find(selector).length > 0 );
		},
		addNode: function(elem, parent){
			if( !elem ) return;
			var subject = $(this.subject);
			if(this.subject[0].tagName == 'IFRAME'){
				
			}
			//console.log(subject);
			if( !parent )
				subject.append(elem);
			else{
				subject.find(parent).append(elem);
			}
			
			return this;
		}
	};
	
	//var Bluebox = new BlueBox();
	$.fn.inbox = function(id, options){
		if( ! window['Bluebox'+id] ){
			new BlueBox(id);
			window['Bluebox'+id].init(this, options);
		}
		return window['Bluebox'+id];
	};
	
})(jQuery);

/*====== Plugin ======*/
// Definitions of taskList
(function($){
	var taskList = function(option){
	this.task = [];
	this.content = $('<ul class="task-list" />');
	this.object_choosen = null;
	this.init();
	};
	taskList.prototype = {
		init: function(){
			var $this = this;
			this.addTask('download', 'click', function(){}, 'Tải về thư mục', true)
			.addTask('album','mouseenter', function(){}, 'Thêm vào album', true)
			.addTask('album-item-remove','click', function(){}, 'Xóa khỏi album', true)
			.addTask('rename', 'click', function(){}, 'Đổi tên', true)
			.addTask('delete', 'click', function(){}, 'Xóa', true);
		},
		addTask: function(task, event, callback, label, disable, noop){
			if( !this.task[task] ) this.task[task] = [];
			this.task[task]['label'] = label || task;
			this.task[task]['event'] = event || 'click';
			this.task[task]['handler'] = typeof callback == "function" ? callback : function(){/*Do nothing*/};
			this.task[task]['disable'] = disable || false;
			this.task[task]['noop'] = noop || false;
			
			this.render(task);
			return this;
		},
		updateTask: function(task, option){
			if( typeof option == "object" && this.task[task] ){
				for(var i in option){
					if( this.task[task][i] ){
						this.task[task][i] = option[i];
						this.render(task);
					}
				}
			}
			return this;
		},
		disableTask: function(task){
			if( this.task[task] ){
				this.task[task]['disable'] = true;
				this.render(task);
			}
			return this;
		},
		enableTask: function(task){
			if( this.task[task] ){
				this.task[task]['disable'] = false;
				this.render(task);
			}
			return this;
		},
		removeTask: function(task){
			if( typeof task == "array" || typeof task == "object" ){
				for(var i in task){
					this.removeTask(task[i]);	
				}	
			}else{
				if( this.task[task] ){
					this.task[task]	= null;
					this.content.find('[data-task="'+task+'"]').remove();
				}
			}
			return this;
		},
		render: function(task){
			var $this = this, task_jobject;
			disable_class = $this.task[task]['disable'] == true ? 'disabled' : '';
			if((task_jobject = $this.content.find('li[data-task="'+task+'"]')).length > 0)
				task_jobject.replaceWith('<li class="task '+disable_class+'" data-task="'+task+'">'+$this.task[task]['label']+'</li>');
			else{
				$this.content.append('<li class="task '+disable_class+'" data-task="'+task+'">'+$this.task[task]['label']+'</li>');	
			}
			
			task_jobject = $this.content.find('li[data-task="'+task+'"]');
			if( !$this.task[task]['disable'] && typeof $this.task[task]['handler'] == "function" ){
				var event = $this.task[task]['event'];
				$this.content.find('[data-task="'+task+'"]').unbind(event).bind(event, function(e){
					$this.task[task]['handler'].call(null, task_jobject, $this);
				});
			}
			
			if( $this.task[task]['noop'] == true ){
				task_jobject.unbind('click').bind('click', function(e){
					e.preventDefault();return false;
				});	
			}
			return this;
		},
		clear: function(){
			for(var task in this.task){
				this.removeTask(task);
			}
			return this;
		},
		getObject: function(){
			return this.object_choosen;	
		}
	}
	
	// jQuery extends
	$.fn.getTaskList = function(id){
		var id = typeof id != "undefined" ? id : 1;
		if( !window['taskList-'+id] ){
			window['taskList-'+id] = new taskList();	
		}
		if( $('ul#task-list-'+id).length < 1 ){
			var content = window['taskList-'+id].content.attr('id', 'task-list-'+id);
			$('body').append(content);
		}
		return window['taskList-'+id];
	}
	
	$.fn.bindTaskList = function(id){
		var $this = this;
		// Add task list to document first
		if( !window['taskList-'+id] ){
			$(document).getTaskList(id);	
		}
		if( !$this.hasClass('task-list-'+id) ){
			$this.addClass('task-list-'+id);
		}
		// Display context menu (shown on broswer click event)
		$(document).off('contextmenu.tasklist').on('contextmenu.tasklist','[data-has-tasklist="true"]',
			function(e){
				return false;
			});
		
		//$(document).off('mousedown.tasklist').on('mousedown.tasklist', '[data-has-tasklist="true"]', function(event){
		$this.off('mousedown.tasklist').on('mousedown.tasklist', function(event){
			var event = event || window.event,
				task_list = $('#task-list-'+id);
				task_list.removeClass('rtl');
			if( event.which == 3 && window['taskList-'+id] ){
				// Add task-list to element
				task_list.css({
					top: event.clientY+2,
					left: event.clientX+2,
					right: 'auto',
					bottom: 'auto'
				}).show().data('display', true);
				//alert(event.clientY+'-'+task_list.height()+'-'+screen.height);
				if( (event.clientY + task_list.height()) >= window.innerHeight ){
					task_list.css({
						top: 'auto',
						bottom : 5
					});
				}
				if( (event.clientX + task_list.width()) >= window.innerWidth ){
					task_list.css({
						left: 'auto',
						right : 5
					}).addClass('rtl');
				}
				
				task_list.find('>li>*').each(function(i,el){
					if( (event.clientX + task_list.width() + $(el).width()) > window.innerWidth ){
						task_list.addClass('rtl');
						return;
					}
				});
				
				// Hide task list when click event triggered but not on element which has task list
				$('body').unbind('click.tasklist.hide').bind('click.tasklist.hide', function(e){
					if( !$(e.target).hasClass('task disabled') ){
						$('.task-list').hide().data('display', false);
					}
				});
				// This object is choosen now
				window['taskList-'+id].object_choosen = $(this);
			}
		});
		
		//$(document).unbind('click.hide.tastlist');
		return window['taskList-'+id];
	}
	
	
	
	// 
	window.taskList = new taskList();
})(jQuery);
