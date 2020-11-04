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
$page = 0;
if ( ! empty( $array_op[1] ) )
{
    $temp = explode( '-', $array_op[1] );
    if ( ! empty( $temp ) )
    {
        $page = intval( end( $temp ) );
    }
}
$base_url = "" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op;
$table = "`".NV_PREFIXLANG . "_" . $module_data . "_rows`";
if ( $data_config['view_type'] == "view_listall")
{
	$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . " WHERE status=1 ORDER BY id DESC LIMIT " . $page . "," . $per_page;
	$result = $db->sql_query( $sql );
	$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
	list( $numf ) = $db->sql_fetchrow( $result_all );
	$all_page = ( $numf ) ? $numf : 1;
	$data_content = array();
	$i = $page+1;
	while ( $row = $db->sql_fetchrow($result,2) )
	{
		$row['no'] = $i;
		$data_content[] = $row;
		$i ++;
	}
	$html_pages = nv_archives_page( $base_url, $all_page, $per_page, $page );
	$contents = call_user_func( $data_config['view_type'], $data_content, $html_pages );
}
elseif ( $data_config['view_type'] == "view_listcate") 
{
	$data_content = array();
	foreach ( $global_archives_cat as $catid_i => $catinfo_i)	
	{
		if ( $catinfo_i['parentid'] == 0 and $catinfo_i['inhome'] == '1' )
        {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . " WHERE catid=" . $catid_i . " AND status=1 ORDER BY id DESC LIMIT 0," . $catinfo_i['numlinks'];
            $result = $db->sql_query( $sql );
            $result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
            list( $numf ) = $db->sql_fetchrow( $result_all );
            $all_page = ( $numf ) ? $numf : 1;
            $data_content_temp = array();
            $i = $page + 1;
            while ( $row = $db->sql_fetchrow( $result, 2 ) )
            {
                $row['no'] = $i;
                $data_content_temp[] = $row;
                $i ++;
            }
            $data_content[] = array( 
                "catinfo" => $catinfo_i, "data" => $data_content_temp 
            );
        }
    }
    $contents = call_user_func( $data_config['view_type'], $data_content, "" );
}
else $contents = "";

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>