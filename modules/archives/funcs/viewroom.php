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
$roomid = 0;
if ( ! empty( $array_op[1] ) )
{
    $temp = explode( '-', $array_op[1] );
    if ( ! empty( $temp ) )
    {
        $roomid = intval( end( $temp ) );
    }
}
if ( empty( $global_archives_room[$roomid] ) ) die( 'Stop!!!' );
$page = 0;
if ( ! empty( $array_op[2] ) )
{
    $temp = explode( '-', $array_op[2] );
    if ( ! empty( $temp ) )
    {
        $page = intval( end( $temp ) );
    }
}
$base_url = "" . NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "/".$global_archives_room[$roomid]['alias']."-".$roomid;
$table = "`" . NV_PREFIXLANG . "_" . $module_data . "_rows`";

$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . " WHERE roomid=" . $roomid . " AND status=1 ORDER BY id DESC LIMIT " . $page . "," . $per_page;
$result = $db->sql_query( $sql );
$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
list( $numf ) = $db->sql_fetchrow( $result_all );
$all_page = ( $numf ) ? $numf : 1;
$data_content = array();
$i = $page + 1;
while ( $row = $db->sql_fetchrow( $result, 2 ) )
{
    $row['no'] = $i;
    $data_content[] = $row;
    $i ++;
}
$top_contents = "";
if ( $global_archives_room[$roomid]['parentid'] > 0 )
{
    $parentid_i = $global_archives_room[$roomid]['parentid'];
    $array_room_title = array();
    while ( $parentid_i > 0 )
    {
        $array_room_title[] = $cur_link = "<a href=\"".$global_archives_room[$parentid_i]['link']."\">" . $global_archives_room[$parentid_i]['title'] . "</a>";
        $parentid_i = $global_archives_room[$parentid_i]['parentid'];
    }
    sort( $array_room_title, SORT_NUMERIC );
    $top_contents = implode( " -> ", $array_room_title );
}
$lik = ( empty($top_contents) )? "": " - ";
$cur_link = "<a href=\"".$global_archives_room[$roomid]['link']."\">" . $global_archives_room[$roomid]['title'] . "</a>";
$top_contents = "<div class=\"archives_links\">".$top_contents.$lik.$cur_link."</div>";

$html_pages = nv_archives_page( $base_url, $all_page, $per_page, $page );
$contents = viewcat_list ( $data_content, $top_contents ,$html_pages );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>