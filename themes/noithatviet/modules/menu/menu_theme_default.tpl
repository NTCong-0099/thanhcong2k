<!-- BEGIN: main -->
<div id="nav">
	<ul id="dropmenu">
        <!-- BEGIN: top_menu -->
		<li {TOP_MENU.current}>
			<a href="{TOP_MENU.link}">{TOP_MENU.title}</a>
             <!-- BEGIN: sub -->
			<ul style="display:block; visibility:hidden;">
             <!-- BEGIN: item -->
				<li>
					<a href="{SUB.link}" style="font-weight:normal;">&rsaquo; {SUB.title}</a>
				</li>
              <!-- END: item -->
			</ul>
             <!-- END: sub -->
		</li>
        <!-- END: top_menu -->
	</ul>
     
</div>

<!-- END: main -->