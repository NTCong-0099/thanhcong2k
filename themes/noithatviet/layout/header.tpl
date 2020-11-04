<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		{THEME_PAGE_TITLE} {THEME_META_TAGS}
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/template.css" />
		<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/icons.css" />
		<link href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/style.css" rel="stylesheet" type="text/css" />
		{THEME_CSS}
		{THEME_SITE_RSS}
		{THEME_SITE_JS} <script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/jquery.min.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#dropmenu ul").css({
					display : "none"
				});
				// Opera Fix
				jQuery("#dropmenu li").hover(function() {
					jQuery(this).find('ul:first').css({
						visibility : "visible",
						display : "none"
					}).show(268);
				}, function() {
					jQuery(this).find('ul:first').css({
						visibility : "hidden"
					});
				});
			});

		</script>
	
        <style type="text/css">
h2{
	color: red;
}
pre{
	padding: 4px;
	border: #F90 dotted 1px;
}
</style>
<link href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/slide/css/style.css" rel="stylesheet" type="text/css" />
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/desSlideshow.js"></script>
<script language="javascript" type="text/javascript">
    $(function() {
        $("#desSlideshow1").desSlideshow({
            autoplay: 'enable',//option:enable,disable
            slideshow_width: '729',//slideshow window width
            slideshow_height: '350',//slideshow window height
            thumbnail_width: '200',//thumbnail width
            time_Interval: '14000',//Milliseconds
            directory: 'images/'// flash-on.gif and flashtext-bg.jpg directory
        });
        $("#desSlideshow2").desSlideshow({
            autoplay: 'enable',//option:enable,disable
            slideshow_width: '729',//slideshow window width
            slideshow_height: '350',//slideshow window height
            thumbnail_width: '120',//thumbnail width
            time_Interval: '8000',//Milliseconds
            directory: 'images/'// flash-on.gif and flashtext-bg.jpg directory
        });
    });
</script>
	</head>
	<body>
		<div class="banner1"></div>
		<div class="menu">
			<div id="wrapper1">
				<div style="float:left; width:38px; height:38px;">
					<a href="#"><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/home.png" border="0" /></a>
				</div>
				<div style="float:left;margin-top:5px">
					[MENU_SITE]
				</div>
				<div style="float:right">
					<div style=" height:30px; margin:5px 0 0 13px;">
						<form action="{NV_BASE_SITEURL}" method="get" style=" margin:0px" onsubmit="return {THEME_SEARCH_SUBMIT_ONCLICK}">
                        
							<div style="float:left">
								<input name="search_query" type="text"id="topmenu_search_query" value="Tìm kiếm ..." size="30" onblur="if (this.value=='') this.value='Tìm kiếm ...';" onfocus="if (this.value=='Tìm kiếm ...') this.value='';" style="color:#cccccc; background:none; height:26px; border:1px solid #B06309 ;">
							</div>
                            
							<div style="float:left; padding-left:5px; padding-top:5px;">
								<input class="submit" type="button" value="" id="topmenu_search_submit" style="background:url({NV_BASE_SITEURL}themes/{TEMPLATE}/images/nut.png) no-repeat top left; border:0; margin-left:-30px; width:20px;" onclick="{THEME_SEARCH_SUBMIT_ONCLICK}"/>
							</div>
						</form>
						<div style="clear:both"></div>
					</div>
				</div>
				<div class="cl"></div>
			</div>
		</div>
		[THEME_ERROR_INFO]
