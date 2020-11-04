/*##############################
# JQUERY LOADING
##############################*/
function jquery_loading(element) {
	$("#"+element).show().fadeOut('slow');
}
/*##############################
# ADD TEXT
##############################*/
function add_text(str, id) {
	if(id == null) id = 'E-source';
	$('#'+id).val($('#'+id).val()+str); 
	$('#'+id).focus();
}
/*##############################
# ADD TEXT
##############################*/
function resize_img(which, max_size) {
  var elem = document.getElementById(which);
  if (elem == undefined || elem == null) return false;
  if (max_size == undefined) max_size = 450;
  if (elem.width > elem.height) {
    if (elem.width > max_size) elem.width = max_size;
  } else {
    if (elem.height > max_size) elem.height = max_size;
  }
}
/*##############################
# SELECT OPTION
##############################*/
function do_select(targ, selObj, restore){
    eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
    if (restore) selObj.selectedIndex = 0;
}
/*##############################
# POLL
##############################*/
function do_poll(questions_id, answer_id)
{   
	$.post
	(
	       'index.php',
		   {
			    poll: true,
				questions_id: questions_id,
				answer_id: answer_id
		   },
		   function(data)
		   {
		        $('#poll_loading').html(data);
				jquery_loading('jquery_loading');
		   }
	);
   return false;
}
/*##############################
# SEARCH
##############################*/
function do_search() {
	keyword = encodeURIComponent($('#keyword').val());
	type = $('#type').val();
	window.location.href = './?do='+type+'&keyword='+keyword;
	return false;
}