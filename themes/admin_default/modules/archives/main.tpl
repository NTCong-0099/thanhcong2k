<!-- BEGIN: main -->
<form action="{NV_BASE_ADMINURL}index.php" method="GET">
<table summary="" class="tab1" style="margin:1px 0px">
    <tbody>
    <tr>
        <td>
        	{LANG.search_cat} :
            <select name="catid" id="catid">
                <option value="0">{LANG.search_cat_all}</option>
                <!-- BEGIN: cloop -->
                <option value="{CAT.catid}" {CAT.select}>{CAT.xtitle}</option>
                <!-- END: cloop -->
            </select>
         	{LANG.search_per_page}
         	<input type="text" name="per_page" value="{per_page}" id="idper_page" style="width:50px" />
         </td>
    </tr>
    </tbody>
</table>
<table summary="" class="tab1" style="margin:1px 0px">   
    <tbody class="second">
    <tr>
        <td>
        	<input type="text" value="{q}" maxlength="64" name="q" id="idq" style="width: 265px">
        	<input type="button" value="{LANG.search}" onClick="search_rows()">
        	{LANG.search_note}
        </td>
    </tr>
    </tbody>
</table>
<input type="hidden" name ="checkss" value="{session_id}"/>
</form>

<form name="block_list">
<table summary="" class="tab1" style="margin-bottom:5px">
    <thead>
        <tr>
            <td align="center" width="20">
               <input name="check_all" id="checkall" type="checkbox"/>
            </td>
            <td width="50" align="center"><a href="{base_url_id}">ID</a></td>
            <td><a href="{base_url_name}">{LANG.doc_name}</a></td>
            <td>{LANG.search_cat}</td>
            <td>{LANG.doc_of_room}</td>
            <td align="center" width="60">{LANG.status}</td>
        	<td width="90"></td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {ROW.bg}>
    	<tr>
        	<td align="center" width="20">
              <input type="checkbox" value="{ROW.id}" class="idlist"/>
            </td>
            <td align="center" width="20">
              {ROW.id}
            </td>
            <td>
            	<a href="{ROW.link}" target="_blank"><b>{ROW.title}</b></a>
            </td>
            <td><a href="{ROW.cat_link}">{ROW.cat_title}</a></td>
            <td><a href="{ROW.room_link}">{ROW.room_title}</a></td>
            <td align="center">{ROW.status}</td>
        	<td align="center">
            	<span class="edit_icon"><a href="{ROW.edit}">{LANG.edit}</a></span> - 
                <span class="delete_icon"><a href="{ROW.del}" class="adel">{LANG.del}</a></span> 
            </td>
        </tr>
    </tbody>
    <!-- END: loop -->
    <tfoot>
    	<tr align="left">
	   		<td colspan="3">
                <span class="delete_icon"><a href="#" class="delall">{LANG.del_select}</a></span>&nbsp;
                <span class="add_icon"><a href="{ADDCONTENT}">{LANG.addcontent}</a></span>
			</td>
            <td colspan="5" align="right"><!-- BEGIN: page -->{generate_page}<!-- END: page --></td>
		</tr>
	</tfoot>
</table>
</form>
<script type="text/javascript">
clickcheckall();
delete_one('adel','{LANG.del_confim}','{URLBACK}');
delete_all('idlist','delall','{LANG.del_confim}','{LANG.no_select_items}','{DELALL}','{URLBACK}');
</script>
<!-- END: main -->