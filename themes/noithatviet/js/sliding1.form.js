$(function() {
	/*
	number of fieldsets
	*/
	var fieldsetCount = $('#formElem1').children().length;
	
	/*
	current position of fieldset / navigation1 link
	*/
	var current 	= 1;
    
	/*
	sum and save the widths of each one of the fieldsets
	set the final sum as the total width of the step1s element
	*/
	var step1sWidth	= 0;
    var widths 		= new Array();
	$('#step1s .step1').each(function(i){
        var $step1 		= $(this);
		widths[i]  		= step1sWidth;
        step1sWidth	 	+= $step1.width();
    });
	$('#step1s').width(step1sWidth);
	
	/*
	to avoid problems in IE, focus the first input of the form
	*/
	$('#formElem1').children(':first').find(':input:first').focus();	
	
	/*
	show the navigation1 bar
	*/
	$('#navigation1').show();
	
	/*
	when clicking on a navigation1 link 
	the form slides to the corresponding fieldset
	*/
    $('#navigation1 a').bind('click',function(e){
		var $this	= $(this);
		var prev	= current;
		$this.closest('ul').find('li').removeClass('selected');
        $this.parent().addClass('selected');
		/*
		we store the position of the link
		in the current variable	
		*/
		current = $this.parent().index() + 1;
		/*
		animate / slide to the next or to the corresponding
		fieldset. The order of the links in the navigation1
		is the order of the fieldsets.
		Also, after sliding, we trigger the focus on the first 
		input element of the new fieldset
		If we clicked on the last link (confirmation), then we validate
		all the fieldsets, otherwise we validate the previous one
		before the form slided
		*/
        $('#step1s').stop().animate({
            marginLeft: '-' + widths[current-1] + 'px'
        },500,function(){
			if(current == fieldsetCount)
				validatestep1s();
			else
				validatestep1(prev);
			$('#formElem1').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();	
		});
        e.preventDefault();
    });
	
	/*
	clicking on the tab (on the last input of each fieldset), makes the form
	slide to the next step1
	*/
	$('#formElem1 > fieldset').each(function(){
		var $fieldset = $(this);
		$fieldset.children(':last').find(':input').keydown(function(e){
			if (e.which == 9){
				$('#navigation1 li:nth-child(' + (parseInt(current)+1) + ') a').click();
				/* force the blur for validation */
				$(this).blur();
				e.preventDefault();
			}
		});
	});
	
	/*
	validates errors on all the fieldsets
	records if the Form has errors in $('#formElem1').data()
	*/
	function validatestep1s(){
		var FormErrors = false;
		for(var i = 1; i < fieldsetCount; ++i){
			var error = validatestep1(i);
			if(error == -1)
				FormErrors = true;
		}
		$('#formElem1').data('errors',FormErrors);	
	}
	
	/*
	validates one fieldset
	and returns -1 if errors found, or 1 if not
	*/
	function validatestep1(step1){
		if(step1 == fieldsetCount) return;
		
		var error = 1;
		var hasError = false;
		$('#formElem1').children(':nth-child('+ parseInt(step1) +')').find(':input:not(button)').each(function(){
			var $this 		= $(this);
			var valueLength = jQuery.trim($this.val()).length;
			
			if(valueLength == ''){
				hasError = true;
				$this.css('background-color','#FFEDEF');
			}
			else
				$this.css('background-color','#FFFFFF');	
		});
		var $link = $('#navigation1 li:nth-child(' + parseInt(step1) + ') a');
		$link.parent().find('.error,.checked').remove();
		
		var valclass = 'checked';
		if(hasError){
			error = -1;
			valclass = 'error';
		}
		$('<span class="'+valclass+'"></span>').insertAfter($link);
		
		return error;
	}
	
	/*
	if there are errors don't allow the user to submit
	*/
	$('#registerButton').bind('click',function(){
		if($('#formElem1').data('errors')){
			alert('Please correct the errors in the Form');
			return false;
		}	
	});
});