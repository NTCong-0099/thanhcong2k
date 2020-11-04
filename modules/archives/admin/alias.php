<?php

/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */


if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$title = filter_text_input( 'title', 'post,get', '' );
$alias = change_alias( $title );
include ( NV_ROOTDIR . "/includes/header.php" );
echo $alias;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>