<?php

/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! nv_function_exists( 'nv_block_up_archives' ) )
{
    function nv_block_up_archives ( $block_config )
    {
        global $module_info, $global_config, $site_mods,$db;
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $mod_file . "/block_uparchives.tpl" ) )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block_uparchives.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file );
    	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    	$xtpl->assign( 'TEMPLATE', $block_theme );
    	$xtpl->assign( 'LINK_UP', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module . "&" . NV_OP_VARIABLE . "=content" );
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}

if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods;
    $module = $block_config['module'];
    if ( isset( $site_mods[$module] ) )
    {
    	if ( check_upload2())
        $content = nv_block_up_archives( $block_config );
        else $content = "";
    }
}

?>