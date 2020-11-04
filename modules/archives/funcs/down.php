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

$id = 0;
if ( ! empty( $array_op[1] ) )
{
    $temp = explode( '-', $array_op[1] );
    if ( ! empty( $temp ) )
    {
        $id = intval( end( $temp ) );
    }
}
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id` = '" . $id . "'";
$result = $db->sql_query( $sql );
$data_content = $db->sql_fetchrow( $result, 2 );
if ( empty( $data_content ) ) die( 'stop!!' );

$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET down=down+1 WHERE `id` = '" . $id . "'";
$result = $db->sql_query( $sql );

if ( ! empty( $data_content['filepath'] ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data_content['filepath'] ) )
{
    $file_basename = $data_content['filepath'];
	$data_content['filepath'] = NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data_content['filepath'];
	require_once ( NV_ROOTDIR . '/includes/class/download.class.php' );
    $directory = NV_UPLOADS_REAL_DIR;
	$download = new download( $data_content['filepath'], $directory, $file_basename );
	$download->download_file();
	exit();
}
elseif (!empty($data_content['otherpath'])) 
{
	 Header( "Location: ".$data_content['otherpath'] );
     die();
}
else { die('no file!!'); }

?>