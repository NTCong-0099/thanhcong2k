<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['listroom'] ;
$contents = "";
$error = "";
$parentid = $nv_Request->get_int( 'parentid', 'get', 0 );
$roomid = $nv_Request->get_int( 'roomid', 'get', 0 );
$data = array(
	"roomid"=>0, "parentid"=>0, "title"=>"", "alias"=>"", "description"=>"", "weight"=>0, "order"=>0, 
	"lev"=>0, "numsubroom"=>0, "subroomid"=>"", "keywords"=>"", "admins"=>0, 
	"add_time"=>NV_CURRENTTIME,"edit_time"=>NV_CURRENTTIME
);

//post data
if ( $nv_Request->get_int( 'save', 'post', 0 ) == '1' )
{
    $parentid_old = $nv_Request->get_int( 'parentid_old', 'post', 0 );
    $data['parentid'] = $nv_Request->get_int( 'parentid', 'post', 0 );
    $data['title'] = filter_text_input( 'title', 'post', '', 1 );
    $data['keywords'] = filter_text_input( 'keywords', 'post', '', 1 );
    $alias = filter_text_input( 'alias', 'post', '' );
    $data['alias'] = ( $alias == "" ) ? change_alias( $data['title'] ) : change_alias( $alias );
    $description = $nv_Request->get_string( 'description', 'post', '' );
    $data['description'] = nv_nl2br( nv_htmlspecialchars( strip_tags( $description ) ), '<br />' );
    if ( empty($data['title']) ) $error = $lang_module['room_title_erorr'];
    else 
    {
    	if ($roomid==0)
    	{
    		//insert data
	    	list( $weight ) = $db->sql_fetchrow( $db->sql_query( "SELECT max(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_room` WHERE `parentid`=" . $db->dbescape( $data['parentid'] ) . "" ) );
	        $weight = intval( $weight ) + 1;
	        $query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_room` (`roomid`, `parentid`, `title`, `alias`, `description`, `weight`, `order`, `lev`, `numsubroom`, `subroomid`,`keywords`, `admins`, `add_time`, `edit_time`)
	         		  VALUES (NULL, " . $db->dbescape( $data['parentid'] ) . ", " . $db->dbescape( $data['title'] ) . ", " . $db->dbescape( $data['alias'] ) . ", " . $db->dbescape( $data['description'] ) . ", " . $db->dbescape( $weight ) . ", '0', '0', '0', " . $db->dbescape( $data['subroomid'] ) . ", " . $db->dbescape( $data['keywords'] ) . ", '', UNIX_TIMESTAMP(), UNIX_TIMESTAMP())";
	        $newroomid = intval( $db->sql_query_insert_id( $query ) );
	        if ( $newroomid > 0 )
	        {
	        	nv_fix_room_order();
	        	nv_del_moduleCache( $module_name );
	            nv_insert_logs( NV_LANG_DATA, $module_name,$lang_module['add_room'], $data['title'], $admin_info['userid'] );
	            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&parentid=" . $data['parentid'] . "" );
	            die();
	        }
	    	else
	        {
	            $error = $lang_module['errorsave'];
	        }
	        $db->sql_freeresult();
    	}
    	elseif($roomid>0) 
    	{
    		//update data
    		$query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_room` SET `parentid`=" . $db->dbescape( $data['parentid'] ) . ", `title`=" . $db->dbescape( $data['title'] ) . ", `alias` =  " . $db->dbescape( $data['alias'] ) . ", `description`=" . $db->dbescape( $data['description'] ) . ", `keywords`= " . $db->dbescape( $data['keywords'] ) . ", `edit_time`=UNIX_TIMESTAMP( ) WHERE `roomid` =" . $roomid . "";
        	$db->sql_query( $query );
        	if ( $db->sql_affectedrows() > 0 )
	        {
	        	if ( $data['parentid'] != $parentid_old )
	        	{
	        		list( $weight ) = $db->sql_fetchrow( $db->sql_query( "SELECT max(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_room` WHERE `parentid`=" . $db->dbescape( $data['parentid'] ) . "" ) );
	                $weight = intval( $weight ) + 1;
	                $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_room` SET `weight`=" . $weight . " WHERE `roomid`=" . intval( $roomid );
	                $db->sql_query( $sql );
	                nv_fix_room_order();
	        	}
	        	nv_insert_logs( NV_LANG_DATA, $module_name,$lang_module['edit_room'], $data['title'], $admin_info['userid'] );
	        	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&parentid=" . $data['parentid'] . "" );
	            die();
	        }
	        else
	        {
	            $error = $lang_module['errorsave'];
	        }
	        $db->sql_freeresult();
    	}
    }
}
//select data
if ( $roomid > 0)
{
	$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_room` WHERE `roomid` = '" . $roomid . "' ORDER BY `weight` ASC";
	$result = $db->sql_query( $sql );
	$data = $db->sql_fetchrow( $result,2 );
}
/**
 * begin: listview data 
 */
$xtpl = new XTemplate( "room.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
if ( $parentid > 0 )
{
    $parentid_i = $parentid;
    $array_room_title = array();
    while ( $parentid_i > 0 )
    {
        $array_room_title[] = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=" . $parentid_i . "\"><strong>" . $global_array_room[$parentid_i]['title'] . "</strong></a>";
        $parentid_i = $global_array_room[$parentid_i]['parentid'];
    }
    sort( $array_room_title, SORT_NUMERIC );
    $ptemp = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=0\"><strong>" . $lang_module['root_room'] . "</strong></a>";
    $contents .= $ptemp." -> ".implode( " -> ", $array_room_title );
}

$num = 1;
foreach ( $global_array_room as $row )
{
    if ( $row['parentid'] == $parentid ) $num++;
}
if ( $num > 0 )
{
    $array_inhome = array( 
        0 => $lang_global['no'], 1 => $lang_global['yes'] 
    );
    $a = 1;
    foreach ( $global_array_room as $row )
    {
    	if ( $row['parentid'] == $parentid )
    	{
	        $row['sweight'] = drawselect_number( "weight", 1, $num-1, $row['weight'],"ChangeActiveRoom(this,".$row['roomid'].",'weight')" );
    		$row['class'] = ( $a % 2 ) ? " class=\"second\"" : "";
	        $row['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=" . $row['parentid']."&amp;roomid=" . $row['roomid'];
	        $row['del'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room_action&amp;ac=del&amp;roomid=" . $row['roomid'];
	        $row['add'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;roomid=" . $row['roomid'];
	        $row['linkparent'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=" . $row['roomid'];
	        $xtpl->assign( 'ROW', $row );
	        $xtpl->parse( 'main.list.loop' );
    	}
    }
    $xtpl->parse( 'main.list' );
}
/**
 * end: listview data 
 */

/** 
 * view form data
 */
if ( ! empty( $error ) )
{
    $xtpl->assign( 'ERROR', $error );
    $xtpl->parse( 'main.form.error' );
}
foreach ( $global_array_room as $roomid_i => $array_value )
{
	if ( $roomid_i != $roomid )
	{
	    $xtitle_i = "";
	    if ( $array_value['lev'] > 0 )
	    {
	        $xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
	        for ( $i = 1; $i <= $array_value['lev']; $i ++ )
	        {
	            $xtitle_i .= "---";
	        }
	        $xtitle_i .= "&nbsp;";
	    }
	    $select = ( $roomid_i == $parentid ) ? 'selected="selected"' : '';
	    $array_room = array( "xtitle"=> $xtitle_i.$array_value['title'], "roomid"=>$roomid_i,"select"=>$select);
	    $xtpl->assign( 'ROW', $array_room );
	    $xtpl->parse( 'main.form.roomlist' );
	}
}
if ( empty( $data['alias'] ) )
{
    $xtpl->parse( 'main.form.getalias' );
}
$xtpl->assign( 'DATA', $data );
$xtpl->parse( 'main.form' );
$xtpl->parse( 'main' );
$contents .= $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>