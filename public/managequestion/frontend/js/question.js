function deepCompare (x,y) {
	var i, l, leftChain, rightChain;
	function compare2Objects (x, y) {
		var p;
	    // and isNaN(undefined) returns true
	    if (isNaN(x) && isNaN(y) && typeof x === 'number' && typeof y === 'number') {
	    	return true;
	    }

	    // Compare primitives and functions.     
	    // Check if both arguments link to the same object.
	    // Especially useful on the step where we compare prototypes
	    if (x === y) {
	    	return true;
	    }

	    // Works in case when functions are created in constructor.
	    // Comparing dates is a common scenario. Another built-ins?
	    // We can even handle functions passed across iframes
	    if ((typeof x === 'function' && typeof y === 'function') ||
	    	(x instanceof Date && y instanceof Date) ||
	    	(x instanceof RegExp && y instanceof RegExp) ||
	    	(x instanceof String && y instanceof String) ||
	    	(x instanceof Number && y instanceof Number)) {
	    	return x.toString() === y.toString();
		}

	    // At last checking prototypes as good as we can
	    if (!(x instanceof Object && y instanceof Object)) {
	    	return false;
	    }

	    if (x.isPrototypeOf(y) || y.isPrototypeOf(x)) {
	    	return false;
	    }

	    if (x.constructor !== y.constructor) {
	    	return false;
	    }

	    if (x.prototype !== y.prototype) {
	    	return false;
	    }

	    // Check for infinitive linking loops
	    if (leftChain.indexOf(x) > -1 || rightChain.indexOf(y) > -1) {
	    	return false;
	    }

	    // Quick checking of one object being a subset of another.
	    // todo: cache the structure of arguments[0] for performance
	    for (p in y) {
	    	if (y.hasOwnProperty(p) !== x.hasOwnProperty(p)) {
	    		return false;
	    	}
	    	else if (typeof y[p] !== typeof x[p]) {
	    		return false;
	    	}
	    }

	    for (p in x) {
	    	if (y.hasOwnProperty(p) !== x.hasOwnProperty(p)) {
	    		return false;
	    	}
	    	else if (typeof y[p] !== typeof x[p]) {
	    		return false;
	    	}

	    	switch (typeof (x[p])) {
	    		case 'object':
	    		case 'function':

	    		leftChain.push(x);
	    		rightChain.push(y);

	    		if (!compare2Objects (x[p], y[p])) {
	    			return false;
	    		}

	    		leftChain.pop();
	    		rightChain.pop();
	    		break;

	    		default:
	    		if (x[p] !== y[p]) {
	    			return false;
	    		}
	    		break;
	    	}
	    }

	    return true;
	}

	if (arguments.length < 1) {
	    return true; //Die silently? Don't know how to handle such case, please help...
	    // throw "Need two or more arguments to compare";
	}
	for (i = 1, l = arguments.length; i < l; i++) {

	      leftChain = []; //Todo: this can be cached
	      rightChain = [];

	      if (!compare2Objects(arguments[0], arguments[i])) {
	      	return false;
	      }
	}
	return true;
}
var MODULE_DRAG_DROP_QUESTION = {
	init:function(){
    	MODULE_DRAG_DROP_QUESTION.creteDragDrop();
	},
	creteDragDrop:function(){
	    var ok_drop = 1;
	    $('.basic_sentence_reorganizing:eq(0)').after('<div class="my-3 py-1 px-2 border">(<strong>Hướng dẫn</strong>: Bạn hãy kéo/click vào từ phía trên sau đó thả/click vào ô bên dưới đúng vị trí của từ trong câu để tạo thành một câu đúng. Bạn có thể click vào các ô bên dưới để đổi chỗ vị trí từ cho nhau.)</div>');
	    $(".basic_drag_re").css('position', 'absolute');
	    $(".basic_drag_re").draggable({
	        start: function(event, ui) {
	        	if ($(event.currentTarget).hasClass('no_drag')) {
	            	event.preventDefault();
	        	}else {
	            	event.stopPropagation();
	        	}
	        },
	        scroll: false,
	        drag: function(event, ui) {
	            $(this).css('z-index', '20');
	            if ($('.drag-hover').length > 1) {
	                ok_drop = 0;
	            } else {
	                ok_drop = 1;
	            }
	        },
	        stop: function() {
	            $(this).css('z-index', '10');
	            if ($(this).attr('draged')) {} else {
	                var inx_drr = $(this).attr('inx_ques');
	                var inx_c = $(this).attr('inx');
	                $(this).prependTo('.basic_sentence_item_' + inx_drr + '[inx=' + inx_c + ']');
	                var mar_cent = $(this).attr('left_drag');
	                $('.basic_static_' + inx_drr + '[inx=' + inx_c + ']').css('margin-left', '-' + mar_cent + 'px');
	                $(this).removeAttr('style').css({
	                    'position': 'absolute'
	                });
	            }
	        }
	    });
	    $('.basic_sentence_re_drop').each(function() {
	        var inx_dr = $(this).attr('inx');
	        $('.basic_drop_' + inx_dr).droppable({
	        	accept: function(d) { 
	            	var classAccept = "basic_drag_" + inx_dr;
			        if(d.hasClass(classAccept) && !d.hasClass('no_drag')){ 
			            return true;
			        }
			    },
	            hoverClass: "drag-hover",
	            drop: function(event, ui) {
	                if (ok_drop == 1) {
	                    var droped_cnt = $(this).index('.basic_drop_re');
	                    if ($(this).children().length > 0) {
	                        var $elm_cnt = $(this).children();
	                        var inx_d = $elm_cnt.attr('inx');
	                        $elm_cnt.css('position', 'absolute');
	                        var inx_ques = $elm_cnt.attr('inx_ques');
	                        $elm_cnt.prependTo('.basic_sentence_item_' + inx_ques + '[inx=' + inx_d + ']');
	                    }
	                    $(this).html(ui.draggable);
	                    var drag_cent = $(ui.draggable).attr('drag');
	                    $(this).attr('droped', drag_cent);
	                    $(ui.draggable).removeAttr('style').css({
	                        'position': 'relative',
	                        'float': 'none'
	                    });
	                    $(ui.draggable).attr('draged', droped_cnt);
	                }
	            },
	            out: function(event, ui) {
	                $(ui.draggable).removeAttr('draged');
	            }
	        });
	    });
	    var inx = '',
	        inx_db = '',
	        drop_att = '';
	    $(".basic_sentence_item").click(function() {
	        if ($(this).children().length == 2) {
	        	if($(this).children('.basic_drag_re').hasClass('no_drag')){
	        		return;
	        	}
	            $('.drag_reor_clicked').removeClass('drag_reor_clicked');
	            $(this).children('.basic_drag_re').addClass('drag_reor_clicked');
	            if ($('.drop_reor_clicked').length == 1) {
	                inx_db = $(this).children(0).attr('inx_ques');
	                if (inx_db != $('.drop_reor_clicked').attr('inx')) return;
	                if ($('.drop_reor_clicked').children().length == 1) {
	                    var inx = $('.drop_reor_clicked').children().attr('inx');
	                    $elm_bdl = $('.drop_reor_clicked').children();
	                    $elm_bdl.prependTo('.basic_sentence_item_' + inx_db + '[inx=' + inx + ']');
	                    $elm_bdl.removeAttr('style').css('position', 'absolute');
	                }
	                $(this).children('.basic_drag_re').removeClass('drag_reor_clicked').css({
	                    'position': 'relative',
	                    'float': 'none'
	                });
	                $('.drop_reor_clicked').html($(this).children('.basic_drag_re'));
	                $('.drop_reor_clicked').removeClass('drop_reor_clicked');
	            }
	        }
	    });

	    $('.basic_drop_re').click(function() {
	    	if ($(this).hasClass('no_drag')) {
	    		return;
	    	}
	        if ($('.drop_reor_clicked').length == 1 && $('.drop_reor_clicked').children().length == 1) {
	        	if ($(this).attr('inx') == $('.drop_reor_clicked').attr('inx')) {
	        		if ($(this).children().length == 0) {
		                $(this).html($('.drop_reor_clicked').children());
		            } else {
		                $child = $(this).children();
		                $(this).html($('.drop_reor_clicked').children());
		                $('.drop_reor_clicked').html($child);
		            }
	        	}
	            $('.drop_reor_clicked').removeClass('drop_reor_clicked');
	        } else {
	            $('.drop_reor_clicked').removeClass('drop_reor_clicked');
	            $(this).addClass('drop_reor_clicked');
	            if ($('.drag_reor_clicked').length == 1) {
	            	if ($(this).attr('inx') == $('.drag_reor_clicked').attr('inx_ques')) {
	            		if ($(this).children().length == 1) {
		                    $elm_bbl = $(this).children();
		                    inx = $elm_bbl.attr('inx');
		                    $elm_bbl.removeAttr('style').css('position', 'absolute');
		                    inx_bl = $(this).children().attr('inx_ques');
		                    $elm_bbl.prependTo('.basic_sentence_item_' + inx_bl + '[inx=' + inx + ']');
		                }
		                $(this).html($('.drag_reor_clicked'));
		                $('.drag_reor_clicked').removeAttr('style').css({
		                    'position': 'relative',
		                    'float': 'none'
		                });
		                $('.drag_reor_clicked').removeClass('drag_reor_clicked').css('float', 'none');
	            	}
	                $(this).removeClass('drop_reor_clicked');
	            }
	        }
	    });
	}
}
var MODULE_MATCHING_QUESTION = {
	init:function(){
		MODULE_MATCHING_QUESTION.createMatching();
		MODULE_MATCHING_QUESTION.initMatchingIndex();
		MODULE_MATCHING_QUESTION.createMatchingMobile();
	},
	createMatching:function(){
		var ok_drop_mt=1, inx_drg_click=0,elm_click=null,attr_drop=0,attr_drag=0,attr_top_drp=0,attr_top_drg=0;
		$('.basic_ques_matching:eq(0)').after('<div class="my-3 py-1 px-2 border">(<strong>Hướng dẫn</strong>: Bạn hãy kéo miếng ghép <strong>màu xanh</strong> với miếng ghép <strong>màu cam</strong> tương ứng, hoặc click lần lượt vào hai miếng ghép đó để tạo thành đáp án đúng.)</div>');
		$('.basic_mt_drg').click(function(){
			if ($(this).hasClass('no_drag')) {
				return;
			}
			inx_drg_click=$(this).attr('inx');
			$('.basic_mt_drg').removeClass('drag_click_'+inx_drg_click);            
			$('.basic_mt_drg').removeClass('drag_hover_mt1');           
			$(this).addClass('drag_click_'+inx_drg_click+ ' drag_hover_mt1');           
			if($('.drop_click_'+inx_drg_click).length==1){
				elm_click=$('.drop_click_'+inx_drg_click);
				attr_drop=elm_click.attr('drop');
				attr_drag=$(this).attr('drag');
				attr_top_drg=$(this).attr('top_drag');
				attr_top_drp=elm_click.attr('top_drop');                
				$('.mt_drg_'+inx_drg_click+'[top_drag='+attr_top_drp+']').not('.drag_click_'+inx_drg_click).css('z-index','5').animate({                      
					top:attr_top_drg,                 
					left:'0px'    
				},400).removeAttr('draged').attr('top_drag',attr_top_drg);   
				elm_click.attr('droped',attr_drag);
				$(this).attr('draged',attr_drop);
				$(this).animate({
					top:attr_top_drp,   
					left:'-23px'    
				},400).attr('top_drag',attr_top_drp);
				$('.drag_click_'+inx_drg_click).removeClass('drag_click_'+inx_drg_click);
				$('.drop_click_'+inx_drg_click).removeClass('drop_click_'+inx_drg_click);
				$('.drag_hover_mt1').removeClass('drag_hover_mt1');
			}               
		});
		$('.basic_mt_drp').click(function(){
			if ($(this).hasClass('no_drag')) {
				return;
			}
			inx_drg_click=$(this).attr('inx');  
			$('.basic_mt_drp').removeClass('drop_click_'+inx_drg_click);
			$('.basic_mt_drp').removeClass('drag_hover_mt1');
			$(this).addClass('drop_click_'+inx_drg_click+ ' drag_hover_mt1');
			if($('.drag_click_'+inx_drg_click).length==1){
				elm_click=$('.drag_click_'+inx_drg_click);
				attr_drop=$(this).attr('drop');
				attr_drag=elm_click.attr('drag');
				attr_top_drg=elm_click.attr('top_drag');
				attr_top_drp=$(this).attr('top_drop');              
				$('.mt_drg_'+inx_drg_click+'[top_drag='+attr_top_drp+']').not('.drag_click_'+inx_drg_click).css('z-index','5').animate({                      
					top:attr_top_drg,                 
					left:'0px'    
				},400).removeAttr('draged').attr('top_drag',attr_top_drg);   
				$(this).attr('droped',attr_drag);
				elm_click.attr('draged',attr_drop);
				elm_click.animate({
					top:attr_top_drp,   
					left:'-23px'    
				},400).attr('top_drag',attr_top_drp);
				$('.drag_click_'+inx_drg_click).removeClass('drag_click_'+inx_drg_click);
				$('.drop_click_'+inx_drg_click).removeClass('drop_click_'+inx_drg_click);
				$('.drag_hover_mt1').removeClass('drag_hover_mt1');             
			}
		});
		$( ".basic_mt_drg").draggable({
			start: function( event, ui ){
				if ($(event.currentTarget).hasClass('no_drag')) {
	            	event.preventDefault();
	        	}else {
	            	event.stopPropagation();
	        	}               
			},
			drag: function(event,ui){           
				$(this).addClass('drag_hover_mt');
				$(this).css('z-index','20');            
				$('.drag_hover_mt1').removeClass('drag_hover_mt1');             
				if($('.drag_hover_mt').length >2){
					var t_drag=$(ui.draggable).attr('top_drag');
					$(ui.draggable).animate({
						top:t_drag, 
						left:'0px'
					},300);
					ok_drop_mt=0;
				}else{                     
					ok_drop_mt=1; 
				}  
			},stop: function(){            
				$(this).css('z-index','10');  
				var inx_mt=$(this).attr('inx'); 
				if($(this).attr('draged')){                                             
				}else{ 
					var drag_m=$(this).attr('drag');
					$('.mt_drp_'+inx_mt+'[droped='+drag_m+']').removeAttr('droped'); 
					var t_drag=$(this).attr('top_drag');                        
					$(this).animate({
						top:t_drag, 
						left:'0px'
					});
					var inx_dr1=$(this).parent().attr('inx');              
				}
				$(this).removeClass('drag_hover_mt');
				setTimeout(function(){
					if($('.drag_click_'+inx_drg_click).length==1){
						$('.drag_click_'+inx_drg_click).removeClass('drag_hover_mt1');  
						$('.drag_click_'+inx_drg_click).removeClass('drag_click_'+inx_drg_click);
					}
					if($('.drop_click_'+inx_drg_click).length==1){
						$('.drop_click_'+inx_drg_click).removeClass('drag_hover_mt1');  
						$('.drop_click_'+inx_drg_click).removeClass('drop_click_'+inx_drg_click);
					}   
				},300); 

			}
		}); 
		$('.basic_mt_drop').each(function(){
			var inx_dr=$(this).attr('inx');
			$('.mt_drp_'+inx_dr).droppable({
				accept: ".mt_drg_"+inx_dr,              
				hoverClass : "drag_hover_mt",
				tolerance: "touch",      
				drop: function(event,ui ){ 
					if(ok_drop_mt==1){
						var drop_mt=$(this).attr('drop');
						var dr_topp=$(ui.draggable).attr('top_drag');  
						var t_dropp=$(this).attr('top_drop');
						$('.mt_drg_'+inx_dr+'[top_drag='+t_dropp+']').not(ui.draggable).css('z-index','5').animate({                        
							top:dr_topp,                  
							left:'0px'    
						},400).removeAttr('draged').attr('top_drag',dr_topp);    
						var drag_mt= $(ui.draggable).attr('drag');
						$('.mt_drp_'+inx_dr+'[droped='+drag_mt+']').removeAttr('droped'); 
						$(this).attr('droped',drag_mt);
						$(ui.draggable).attr('draged',drop_mt);                          
						$(ui.draggable).animate({
							top:t_dropp,    
							left:'-23px'    
						},400).attr('top_drag',t_dropp);
					} 
				},      
				over:function(event,ui){                                    
					$(ui.draggable).removeAttr('draged');  
				}
			});
		});
	},
	initMatchingIndex:function(){
		$('.basic_ques_matching_true_answer').each(function(index, el) {
			var _this = $(this);
			var matchingIdx = _this.attr('match_ridx');
			var itemTarget = $(".basic_ques_matching[match_idx="+matchingIdx+"]");
			if (itemTarget.length == 1) {
				var listDrag = $(itemTarget[0]).find('.mt_drg_'+matchingIdx);
				listDrag.each(function(index, el) {
					var idx = $(this).find('.bs_elm_mc_drg').html();
					_this.find('.basic_mt_drg[drag='+$(this).attr('drag')+']').find('.bs_elm_mc_drg').html(idx);
				});
			}
		});
	},
	createMatchingMobile:function(){
		var n_elm=0,inx_mt=0;
	    $(".m_qzmatching_bitem").click(function(){
	    	if ($(this).hasClass('no_drag')) {
				return;
			}
	        inx_mt=$(this).attr('inx');
	        $('.m_qzmatching_bitem[inx='+inx_mt+']').removeClass('m_qzmatching_bitem_cl bitem_cl_'+inx_mt);
	        $(this).addClass("m_qzmatching_bitem_cl bitem_cl_"+inx_mt);
	        n_elm=$('.titem_cl_'+inx_mt).length;
	        if(n_elm==1){            				
	            var parent =$('.titem_cl_'+inx_mt).parent();
	            var droped=$(parent).attr('droped');				
	            if(droped){					
	                $(parent).find('.m_qzmatching_bitem').css('margin-top','auto').appendTo('.m_qzmatching_bottom[inx='+inx_mt+']');					
	            }
	            var drag=$('.bitem_cl_'+inx_mt).attr('drag');
	            $('.bitem_cl_'+inx_mt).appendTo(parent).css('margin-top','-22px');				
	            $(parent).attr('droped',drag);	
	            $('.bitem_cl_'+inx_mt).removeClass('m_qzmatching_bitem_cl bitem_cl_'+inx_mt);
	            $('.titem_cl_'+inx_mt).removeClass('m_qzmatching_titem_cl titem_cl_'+inx_mt);				
	            }

	    });
	    $(".m_qzmatching_titem").click(function(){
	    	if ($(this).hasClass('no_drag')) {
				return;
			}	
	        inx_mt=$(this).attr('inx');
	        $('.m_qzmatching_titem[inx='+inx_mt+']').removeClass('m_qzmatching_titem_cl titem_cl_'+inx_mt);
	        $(this).addClass("m_qzmatching_titem_cl titem_cl_"+inx_mt); 
	        n_elm=$('.bitem_cl_'+inx_mt).length;
	        if(n_elm==1){
	            var parent =$(this).parent();
	            var droped=$(parent).attr('droped');                   	
	            if(droped){
	               $(parent).find('.m_qzmatching_bitem').css('margin-top','auto').appendTo('.m_qzmatching_bottom[inx='+inx_mt+']');
	            } 
	            var drag= $('.bitem_cl_'+inx_mt).attr('drag');
	            $('.bitem_cl_'+inx_mt).appendTo(parent).css('margin-top','-22px');                   
	            $(parent).attr('droped',drag);	
	            $('.bitem_cl_'+inx_mt).removeClass('m_qzmatching_bitem_cl bitem_cl_'+inx_mt);
	            $('.titem_cl_'+inx_mt).removeClass('m_qzmatching_titem_cl titem_cl_'+inx_mt);
	        }
	    });		
	}
}
var MODULE_CLICK_WORD = {
	init:function(){
		MODULE_CLICK_WORD.initClickWord();
	},
	initClickWord:function(){
		$('.basic_que_click_word:eq(0)').after('<div class="my-3 py-1 px-2 border">(<strong>Hướng dẫn</strong>: Bạn hãy click vào từ để chọn. Click lại từ đã chọn để bỏ chọn.)</div>');
		$(document).on('click', '.basesic-click-word .clickable', function(event) {
			event.preventDefault();
			if ($(this).hasClass('no-click')) return;
			$(this).toggleClass('selected-item-word');
		});
	}
}
var MODULE_QUESTION = {
	init:function(){
		MODULE_QUESTION.initBasicRadio();
		MODULE_QUESTION.initBasicCheckBox();
		MODULE_QUESTION.initInputWith();
		MODULE_DRAG_DROP_QUESTION.init();
		MODULE_MATCHING_QUESTION.init();
		MODULE_CLICK_WORD.init();
	},
	initBasicRadio:function() {
	    $(document).on('click', '.list-question-answer:not(.question-finished) .basic_radio', function(event) {
	    	$(this).closest('.list-question-answer').find('.basic_radio').removeClass('checked');
	    	$(this).addClass('checked');
	    });
	},
	initBasicCheckBox:function() {
	    $(document).on('click', '.list-question-answer:not(.question-finished) .basic_checkbox', function(event) {
	    	$(this).toggleClass('checked');
	    });
	},
	initInputWith:function(){
		$(document).on('input', '.input-content-box input', function(event) {
			$(this).attr('size',parseInt($(this).val().length)+1);
		});
	},
	initBasicCheckBox:function() {
	    $(document).on('click', '.list-question-answer:not(.question-finished) .basic_checkbox', function(event) {
	    	$(this).toggleClass('checked');
	    });
	},
	callInternalFunc:function(fnc,...option){
		if(typeof MODULE_QUESTION[fnc] === "function"){
			return MODULE_QUESTION[fnc](...option);
		}else {
			console.log(fnc + ' Not found!');
		}
	},
	getValueChooseAnswer:function(questionAnswerBox){
		var selectAnswer = questionAnswerBox.find('.checked');
		return selectAnswer.length == 1 ? selectAnswer.attr('value'):'';
	},
	getQuestionDoStatusChooseAnswer:function(questionAnswerBox){
		return questionAnswerBox.find('.checked').length > 0;
	},
	disableAnswerQuestionChooseAnswer:function(questionAnswerBox){
		questionAnswerBox.addClass('question-finished')
	},
	getValueFillAnswer:function(questionAnswerBox){
		var fillAnswers = questionAnswerBox.find('.input_fill_answer');
		var ret = {};
		for (var i = 0; i < fillAnswers.length; i++) {
			var fillAnswer = $(fillAnswers[i]);
			var id = fillAnswer.attr('id');
			ret[id] = fillAnswer.val();
		}
		return ret;
	},
	getQuestionDoStatusFillAnswer:function(questionAnswerBox){
		var fillAnswers = questionAnswerBox.find('.input_fill_answer');
		for (var i = 0; i < fillAnswers.length; i++) {
			var fillAnswer = $(fillAnswers[i]);
			if (fillAnswer.val() == '') {
				return false;
			}
		}
		return true;
	},
	disableAnswerQuestionFillAnswer:function(questionAnswerBox){
		var listInputFillAnswer = questionAnswerBox.find('.input_fill_answer');
		listInputFillAnswer.prop('disabled', 'true');
		listInputFillAnswer.prop('readonly', 'true');
	},
	getValueChooseManyAnswer:function(questionAnswerBox){
		var selectAnswers = questionAnswerBox.find('.checked');
		var ret = '';
		for (var i = 0; i < selectAnswers.length; i++) {
			var selectAnswer = $(selectAnswers[i]);
			ret = ret+','+selectAnswer.attr('value');
		}
		return ret.length > 0 ? ret.slice(1):ret;
	},
	getQuestionDoStatusChooseManyAnswer:function(questionAnswerBox){
		return questionAnswerBox.find('.checked').length > 0;
	},
	disableAnswerQuestionChooseManyAnswer:function(questionAnswerBox){
		questionAnswerBox.addClass('question-finished')
	},
	getQuestionDoStatusDragDrop:function(questionAnswerBox){
		var ret = true;
		questionAnswerBox.find('.basic_drop_re').each(function(index, el) {
			if ($(this).children().length !== 1) {
                ret = false;
            }
		});
		return ret;
	},
	getValueDragDrop:function(questionAnswerBox){
		var dragDrops = questionAnswerBox.find('.basic_drop_re');
		var ret = {};
		for (var i = 0; i < dragDrops.length; i++) {
			var dragDrop = $(dragDrops[i]);
			var id = dragDrop.attr('id');
			ret[id] = dragDrop.find('.basic_drag_re').attr('drag');
		}
		return ret;
	},
	getQuestionDoStatusMatching:function(questionAnswerBox){
		var listItem = questionAnswerBox.find('.basic_elm_matching');
		var ret = true;
		listItem.each(function(index, el) {
			if (typeof $(this).attr('droped') == 'undefined') {
				ret = false;
			}
		});
		return ret;
	},
	getValueMatching:function(questionAnswerBox){
		var listItem = questionAnswerBox.find('.basic_elm_matching');
		var ret = {};
		for (var i = 0; i < listItem.length; i++) {
			var item = $(listItem[i]);
			var id = item.attr('drop');
			ret[id] = item.attr('droped');
		}
		return ret;
	},
	getQuestionDoStatusClickWord:function(questionAnswerBox){
		var listItem = questionAnswerBox.find('.basesic-click-word');
		var ret = true;
		listItem.each(function(index, el) {
			var selectedWord = $(this).find('.selected-item-word');
			if (selectedWord.length == 0) {
				ret = false;
			}
		});
		return ret;
	},
	getValueClickWord:function(questionAnswerBox){
		var listItem = questionAnswerBox.find('.basesic-click-word-content');
		var ret = {};
		for (var i = 0; i < listItem.length; i++) {
			var item = $(listItem[i]);
			ret[item.data('idx')] = [];
			item.find('.selected-item-word').each(function(index, el) {
				ret[item.data('idx')].push($(this).data('clword'));
			});
		}
		return ret;
	},
	disableAnswerQuestionClickWord:function(questionAnswerBox){
		questionAnswerBox.find('.clickable').addClass('no-click');
	},
	disableAnswerQuestionDragDrop:function(questionAnswerBox){
		questionAnswerBox.find('.basic_drag').addClass('no_drag');
		questionAnswerBox.find('.basic_drop_re').addClass('no_drag');
	},
	disableAnswerQuestionMatching:function(questionAnswerBox){
		questionAnswerBox.find('.basic_mt_drg').addClass('no_drag');
		questionAnswerBox.find('.basic_mt_drp').addClass('no_drag');
		questionAnswerBox.find('.m_qzmatching_bitem').addClass('no_drag');
		questionAnswerBox.find('.m_qzmatching_titem').addClass('no_drag');
	},
	checkCompareAnswerChooseAnswer:function(answer,correct){
		return answer == correct;
	},
	checkCompareAnswerFillAnswer:function(answer,correct){
		return deepCompare(answer,correct);
	},
	checkCompareAnswerDragDrop:function(answer,correct){
		return deepCompare(answer,correct);
	},
	checkCompareAnswerMatching:function(answer,correct){
		return deepCompare(answer,correct);
	},
	checkCompareAnswerClickWord:function(answer,correct){
		return deepCompare(answer,correct);
	},
	checkCompareAnswerChooseManyAnswer:function(answer,correct){
		return answer == correct;
	}
}
var MODULE_QUESTION_GUI = {
	init:function(){
		MODULE_QUESTION_GUI.initContentCustomerMathBuild();
	},
	initContentCustomerMathBuild:function(){
		$('.custom-math-fraction-content .fill_answer_resutl_box').each(function(index, el) {
			if ($(el).find('.input_fill_answer').length == 0) {
				$(el).addClass('compensation-box');
			}
		});
		$('.custom-math-tech5s-matrix .number-concatenation .number-box').each(function(index, el) {
			if ($(el).find('.input-content-box').length == 0) {
				$(el).addClass('has-border-box');
			}
		});
		$(document).on('input', '.addition-subtraction-multiplication-content .input_fill_answer', function(event) {
			if ($(this).closest('.addition-subtraction-multiplication-content').hasClass('max-size-1')) {
				var val = $(this).val();
				if (val.length > 1) {
					$(this).val(val.substring(0,1));
				}
			}
		});
	}
}
$(document).ready(function() {
	MODULE_QUESTION.init();
	MODULE_QUESTION_GUI.init();
});