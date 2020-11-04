<!-- BEGIN: main -->
{FILE "header.tpl"}
	<div id="main">
		{FILE "tv_left.tpl"}
		<div id="left">
            
	    <h3 class="breakcolumn">
	    	<a title="{LANG.Home}" href="{NV_BASE_SITEURL}"><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/icons/home.png" alt="{LANG.Home}" /> Home</a> <!-- BEGIN: mod_title -->
	    	<!-- BEGIN: breakcolumn -->
				<span class="breakcolumn">&raquo;</span>	    	
	    		<a href="{BREAKCOLUMN.link}" title="{BREAKCOLUMN.title}">{BREAKCOLUMN.title}</a>
	    	<!-- END: breakcolumn -->
            <!-- END: mod_title -->  
	    </h3>
         
			[TOP]

			{MODULE_CONTENT}
		</div>
		<div style="width:207px;float:left; margin-left:7px">
			[RIGHT]
		</div>
	</div>
	{FILE "tv_body.tpl"}
</div>
{FILE "footer.tpl"} 
<!-- END: main -->