<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

$module_version = array( 
    "name" => "Archives", //
    "modfuncs" => "main,view,viewcat,viewroom,viewfield,vieworgan,search,content", //
    "submenu" => "", //
	"is_sysmod" => 0, //
    "virtual" => 1, //
    "version" => "3.2.0.0", //
    "date" => "Fri, 7 May 2010 09:47:15 GMT", //
    "author" => "PCD-GROUP (contact@dinhpc.com)", //
    "note" => "", 
    "uploads_dir" => array( 
        $module_name, $module_name . "/" . date( "Y_m" ) 
    ) 
);

?>