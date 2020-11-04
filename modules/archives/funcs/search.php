<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_MOD_ARCHIES' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];
$q = $nv_Request->get_string( 'q', 'get', '' );
$type = $nv_Request->get_int( 'type', 'get', 0 );
$catid = $nv_Request->get_int( 'catid', 'get', 0 );
$roomid = $nv_Request->get_int( 'roomid', 'get', 0 );
$fieldid = $nv_Request->get_int( 'fieldid', 'get', 0 );
$organid = $nv_Request->get_int( 'organid', 'get', 0 );
$page = $nv_Request->get_int( 'page', 'get', 0 );
$btime = $nv_Request->get_string( 'btime', 'get', '' );
$etime = $nv_Request->get_string( 'etime', 'get', '' );
if ( empty( $etime ) ) $etime = date( "d/m/Y" );

$data_form = array( 
    "q" => $q, "type" => $type, "btime" => $btime, "etime" => $etime, "catid" => $catid, "roomid" => $roomid, "fieldid" => $fieldid, "organid" => $organid 
);

//time
$bval = 0;
if ( ! empty( $btime ) and ! preg_match( "/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $btime ) ) $btime = "";
if ( empty( $btime ) )
{
    $bval = 0;
}
else
{
    $phour = date( 'H' ); $pmin = date( 'i' ); unset( $m );
    preg_match( "/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $btime, $m );
    $bval = mktime( $phour, $pmin, 0, $m[2], $m[1], $m[3] );
}
$eval = 0;
if ( ! empty( $etime ) and ! preg_match( "/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $etime ) ) $etime = "";
if ( empty( $etime ) )
{
    $eval = 0;
}
else
{
    $phour = date( 'H' );  $pmin = date( 'i' ); unset( $m );
    preg_match( "/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $etime, $m );
    $eval = mktime( $phour, $pmin, 0, $m[2], $m[1], $m[3] );
}
//end time

$where = array();
if ( $type == 0 )
{
    if ( ! empty( $q ) ) $where[] = " ( `title` LIKE '%" . $db->dblikeescape( $q ) . "%' OR `hometext` LIKE '%" . $db->dblikeescape( $q ) . "%' ) ";
}
elseif ( $type == 1 )
{
    if ( ! empty( $q ) ) $where[] = " `title` LIKE '%" . $db->dblikeescape( $q ) . "%' ";
}
elseif ( $type == 2 )
{
    if ( ! empty( $q ) ) $where[] = " `hometext` LIKE '%" . $db->dblikeescape( $q ) . "%' ";
}
if ( $catid > 0 )
{
    $where[] = " `catid` = " . intval( $catid ) . " ";
}
if ( $roomid > 0 )
{
    $where[] = " `roomid` = " . intval( $roomid ) . " ";
}
if ( $fieldid > 0 )
{
    $where[] = " `fieldid` = " . intval( $fieldid ) . " ";
}
if ( $organid > 0 )
{
    $where[] = " `organid` = " . intval( $organid ) . " ";
}
if ( ( $eval > 0 && $eval>$bval ) && ( $bval > 0 ) )
{
    $where[] = " ( `signtime` >= " . intval( $bval ) . "  AND `signtime` <= ".intval($eval)." ) ";
}
$wh_str = "";
if ( ! empty( $where ) )
{
    $wh_str = implode( ' AND ', $where );
}
$where_str = "WHERE " . $wh_str . " AND status=1 ";
$base_url = "" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&catid=" . $catid . "&q=" . $q;
$table = "`" . NV_PREFIXLANG . "_" . $module_data . "_rows`";
$data_content = array();
$all_page = 1;
if ( ! empty( $where ) )
{
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . " " . $where_str . " ORDER BY id DESC LIMIT " . $page . "," . $per_page;
    $result = $db->sql_query( $sql );
    $result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
    list( $numf ) = $db->sql_fetchrow( $result_all );
    $all_page = ( $numf ) ? $numf : 1;
    $i = $page + 1;
    while ( $row = $db->sql_fetchrow( $result, 2 ) )
    {
        $row['no'] = $i;
        $data_content[] = $row;
        $i ++;
    }
}
$html_pages = nv_archives_page2( $base_url, $all_page, $per_page, $page );
$contents = call_user_func( "view_search", $data_content, $html_pages, $data_form );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>