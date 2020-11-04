<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

/*action del row*/
$ac = $nv_Request->get_string( 'ac', 'get', 0 );
if ($ac=='del')
{
	$id = $nv_Request->get_int( 'id', 'get', 0 );
	$sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id` = '" . intval( $id ) . "'";
    $result = $db->sql_query( $sql );
    nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_content'], $id, $admin_info['userid'] );
    nv_del_moduleCache( $module_name );
    nv_fix_catall_row ();
    die($lang_module['del_complate']);
}
elseif ($ac=='delall')
{
	$listall = $nv_Request->get_string( 'listall', 'post,get' );
    if (!empty($listall))
    {
    	$sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id` IN (" . $listall . ")";
	    $result = $db->sql_query( $sql );
	    nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_content'], $listall, $admin_info['userid'] );
    	nv_del_moduleCache( $module_name );
    	nv_fix_catall_row ();
    	die($lang_module['del_complate']);
    }
    die('no!!');
}
/*********/
$page_title = $lang_module['main'];
$catid = $nv_Request->get_int( 'catid', 'get', 0 );
$roomid = $nv_Request->get_int( 'roomid', 'get', 0 );
$per_page = $nv_Request->get_int( 'per_page', 'get',50);
$page = $nv_Request->get_int( 'page', 'get', 0 );
$q = filter_text_input( 'q', 'get', '', 1 );
$ordername = $nv_Request->get_string( 'ordername', 'get', 'id' );
$order = ( $nv_Request->get_string( 'order', 'get' ) == "desc" ) ? 'asc' : 'desc';
$base_url_id = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=id&order=" . $order . "&page=" . $page;
$base_url_name = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=title&order=" . $order . "&page=" . $page;
$base_url_room = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=roomid&order=" . $order . "&page=" . $page;
$back_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=id&order=" . $order . "&page=" . $page;
$table = "`".NV_PREFIXLANG . "_" . $module_data . "_rows`";
$arr_status = array(0=>$lang_module['status0'],1=>$lang_module['status1']);
/**
 * begin: formview data 
 */
$xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'base_url_name', $base_url_name );
$xtpl->assign( 'base_url_id', $base_url_id );
$xtpl->assign( 'base_url_room', $base_url_room );
$xtpl->assign( 'q', $q );
$xtpl->assign( 'per_page', $per_page );
$xtpl->assign( 'URLBACK', $back_url );
$xtpl->assign( 'DELALL', "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op."&ac=delall" );
$xtpl->assign( 'ADDCONTENT', "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content" );
//begin: view select cat
foreach ( $global_array_cat as $catid_i => $array_value )
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
    $select = ( $catid_i == $catid ) ? 'selected="selected"' : '';
    $array_cat = array( 
        "xtitle" => $xtitle_i . $array_value['title'], "catid" => $catid_i, "select" => $select 
    );
    $xtpl->assign( 'CAT', $array_cat );
    $xtpl->parse( 'main.cloop' );
}
//end: view cat

//begin: listdata
$where = array();
$where_sql="";
if ( $catid > 0 ) $where[] = " catid=".$catid. " "; 
if ( $roomid > 0 ) $where[] = " roomid=".$roomid. " "; 
if ( !empty($q) ) $where[] = " ( title LIKE '%" . $db->dblikeescape( $q ) . "%' OR homtext LIKE '%" . $db->dblikeescape( $q ) . "%' ) "; 
if ( !empty($where) ) 
{
	$where_sql = " WHERE " . implode(" AND ", $where);
}
$ord_sql = "ORDER BY `" . $ordername . "` " . $order . "";
$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . " ".$where_sql." " . $ord_sql . " LIMIT " . $page . "," . $per_page;
$result = $db->sql_query( $sql );
$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
list( $numf ) = $db->sql_fetchrow( $result_all );
$all_page = ( $numf ) ? $numf : 1;
$i=1;
while ( $row = $db->sql_fetchrow($result,2) )
{
	$row['bg'] = ($i%2==0)? "class=\"second\"":"";
	$row['cat_title'] = isset( $global_array_cat[$row['catid']]['title'] ) ? $global_array_cat[$row['catid']]['title'] : "";
	$row['cat_link'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $row['catid'] ."&q=" . $q . "&ordername=id&order=" . $order . "&page=" . $page;
	$row['room_title'] = isset( $global_array_room[$row['roomid']]['title'] )? $global_array_room[$row['roomid']]['title'] : "" ;
	$row['room_link'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&roomid=" . $row['roomid'] ."&q=" . $q . "&ordername=id&order=" . $order . "&page=" . $page;
	$row['del'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&ac=del&id=".$row['id'];
	$row['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content&id=".$row['id'];
	$row['link'] = NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=view/".$row['alias']."-".$row['id'];
	$row['status'] = $arr_status[$row['status']];
	$xtpl->assign( 'ROW', $row );
    $xtpl->parse( 'main.loop' );
    $i++;
}
//end: listdata
$base_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=".$ordername."&order=" . $order;
$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
if ( $generate_page != "" ) 
{
	$xtpl->assign( 'generate_page', $generate_page );
	$xtpl->parse( 'main.page' );
}
$xtpl->parse( 'main' );
$contents .= $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>