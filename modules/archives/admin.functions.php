<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$submenu['cat'] = $lang_module['category'];
$submenu['organ'] = $lang_module['organ'];
$submenu['room'] = $lang_module['room'];
$submenu['field'] = $lang_module['field'];
$submenu['content'] = $lang_module['addcontent'];
$submenu['config'] = $lang_module['config_title'];
$allow_func = array( 
    'main', 'content', 'cat', 'cat_action', 'room', 'room_action', 'field', 'field_action', 'config', 'alias' ,'organ','organ_action'
);

define( 'NV_IS_FILE_ADMIN', true );

global $global_array_cat;
$global_array_cat = array();
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_cat` ORDER BY `order` ASC";
$result = $db->sql_query( $sql );
while ( $row = $db->sql_fetchrow( $result, 2 ) )
{
    $global_array_cat[$row['catid']] = $row;
}
$array_who_view = array( 
    0 => $lang_global['who_view0'], 1 => $lang_global['who_view1'], 2 => $lang_global['who_view2'], 3 => $lang_global['who_view3'] 
);
/****/
$admin_id = $admin_info['admin_id'];
/****/
global $global_array_room;
$global_array_room = array();
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_room` ORDER BY `order` ASC";
$result = $db->sql_query( $sql );
while ( $row = $db->sql_fetchrow( $result, 2 ) )
{
    $global_array_room[$row['roomid']] = $row;
}
//**//
global $global_array_field;
$global_array_field = array();
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_field` ORDER BY `order` ASC";
$result = $db->sql_query( $sql );
while ( $row = $db->sql_fetchrow( $result, 2 ) )
{
    $global_array_field[$row['fieldid']] = $row;
}

//**//
global $global_array_organ;
$global_array_organ = array();
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_organ` ORDER BY `order` ASC";
$result = $db->sql_query( $sql );
while ( $row = $db->sql_fetchrow( $result, 2 ) )
{
    $global_array_organ[$row['organid']] = $row;
}

//**//
function nv_fix_cat_order ( $parentid = 0, $order = 0, $lev = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `catid`, `parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_cat` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
    $result = $db->sql_query( $query );
    $array_cat_order = array();
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $array_cat_order[] = $row['catid'];
    }
    $db->sql_freeresult();
    $weight = 0;
    if ( $parentid > 0 )
    {
        $lev ++;
    }
    else
    {
        $lev = 0;
    }
    foreach ( $array_cat_order as $catid_i )
    {
        $order ++;
        $weight ++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_cat` SET `weight`=" . $weight . ", `order`=" . $order . ", `lev`='" . $lev . "' WHERE `catid`=" . intval( $catid_i );
        $db->sql_query( $sql );
        $order = nv_fix_cat_order( $catid_i, $order, $lev );
    }
    $numsubcat = $weight;
    if ( $parentid > 0 )
    {
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_cat` SET `numsubcat`=" . $numsubcat;
        if ( $numsubcat == 0 )
        {
            $sql .= ",`subcatid`=''";
        }
        else
        {
            $sql .= ",`subcatid`='" . implode( ",", $array_cat_order ) . "'";
        }
        $sql .= " WHERE `catid`=" . intval( $parentid );
        $db->sql_query( $sql );
    }
    return $order;
}

function nv_fix_cat_row ( $catid = 0 )
{
    global $db, $db_config, $module_name, $module_data;
    $query = "SELECT count(*) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `catid`=" . $catid . " AND status=1";
    $result = $db->sql_query( $query );
    list( $num ) = $db->sql_fetchrow( $result );
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_cat` SET `numrow`=" . $num . " WHERE `catid`=" . intval( $catid );
    $db->sql_query( $sql );

}
function nv_fix_catall_row ( )
{
    global $global_array_cat;
    foreach ( $global_array_cat as $catid_i=>$catinfo_i)
    {
    	nv_fix_cat_row ( $catid_i );
    }
}
function nv_fix_room_order ( $parentid = 0, $order = 0, $lev = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `roomid`, `parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_room` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
    $result = $db->sql_query( $query );
    $array_room_order = array();
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $array_room_order[] = $row['roomid'];
    }
    $db->sql_freeresult();
    $weight = 0;
    if ( $parentid > 0 )
    {
        $lev ++;
    }
    else
    {
        $lev = 0;
    }
    foreach ( $array_room_order as $roomid_i )
    {
        $order ++;
        $weight ++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_room` SET `weight`=" . $weight . ", `order`=" . $order . ", `lev`='" . $lev . "' WHERE `roomid`=" . intval( $roomid_i );
        $db->sql_query( $sql );
        $order = nv_fix_room_order( $roomid_i, $order, $lev );
    }
    $numsubroom = $weight;
    if ( $parentid > 0 )
    {
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_room` SET `numsubroom`=" . $numsubroom;
        if ( $numsubroom == 0 )
        {
            $sql .= ",`subroomid`=''";
        }
        else
        {
            $sql .= ",`subroomid`='" . implode( ",", $array_room_order ) . "'";
        }
        $sql .= " WHERE `roomid`=" . intval( $parentid );
        $db->sql_query( $sql );
    }
    return $order;
}

function nv_fix_field_order ( $parentid = 0, $order = 0, $lev = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `fieldid`, `parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_field` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
    $result = $db->sql_query( $query );
    $array_field_order = array();
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $array_field_order[] = $row['fieldid'];
    }
    $db->sql_freeresult();
    $weight = 0;
    if ( $parentid > 0 )
    {
        $lev ++;
    }
    else
    {
        $lev = 0;
    }
    foreach ( $array_field_order as $fieldid_i )
    {
        $order ++;
        $weight ++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_field` SET `weight`=" . $weight . ", `order`=" . $order . ", `lev`='" . $lev . "' WHERE `fieldid`=" . intval( $fieldid_i );
        $db->sql_query( $sql );
        $order = nv_fix_field_order( $fieldid_i, $order, $lev );
    }
    $numsubfield = $weight;
    if ( $parentid > 0 )
    {
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_field` SET `numsubfield`=" . $numsubfield;
        if ( $numsubfield == 0 )
        {
            $sql .= ",`subfieldid`=''";
        }
        else
        {
            $sql .= ",`subfieldid`='" . implode( ",", $array_field_order ) . "'";
        }
        $sql .= " WHERE `fieldid`=" . intval( $parentid );
        $db->sql_query( $sql );
    }
    return $order;
}
function nv_fix_organ_order ( $parentid = 0, $order = 0, $lev = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `organid`, `parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_organ` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
    $result = $db->sql_query( $query );
    $array_organ_order = array();
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $array_organ_order[] = $row['organid'];
    }
    $db->sql_freeresult();
    $weight = 0;
    if ( $parentid > 0 )
    {
        $lev ++;
    }
    else
    {
        $lev = 0;
    }
    foreach ( $array_organ_order as $organid_i )
    {
        $order ++;
        $weight ++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_organ` SET `weight`=" . $weight . ", `order`=" . $order . ", `lev`='" . $lev . "' WHERE `organid`=" . intval( $organid_i );
        $db->sql_query( $sql );
        $order = nv_fix_organ_order( $organid_i, $order, $lev );
    }
    $numsuborgan = $weight;
    if ( $parentid > 0 )
    {
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_organ` SET `numsuborgan`=" . $numsuborgan;
        if ( $numsuborgan == 0 )
        {
            $sql .= ",`suborganid`=''";
        }
        else
        {
            $sql .= ",`suborganid`='" . implode( ",", $array_organ_order ) . "'";
        }
        $sql .= " WHERE `organid`=" . intval( $parentid );
        $db->sql_query( $sql );
    }
    return $order;
}
///////////////////////
function drawselect_number ( $select_name = "", $number_start = 0, $number_end = 1, $number_curent = 0, $func_onchange = "", $enable = "" )
{
    $html = '<select name="' . $select_name . '" id="id_' . $select_name . '" onchange="' . $func_onchange . '" ' . $enable . '>';
    for ( $i = $number_start; $i <= $number_end; $i ++ )
    {
        $select = ( $i == $number_curent ) ? 'selected="selected"' : '';
        $html .= '<option value="' . $i . '" ' . $select . '>' . $i . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function drawselect_status ( $select_name = "", $array_control_value, $value_curent = 0, $func_onchange = "", $enable = "" )
{
    $html = '<select name="' . $select_name . '" id="id_' . $select_name . '" onchange="' . $func_onchange . '" ' . $enable . '>';
    foreach ( $array_control_value as $val => $title )
    {
        $select = ( $val == $value_curent ) ? "selected=\"selected\"" : "";
        $html .= '<option value="' . $val . '" ' . $select . '>' . $title . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function GetCatidInParent ( $catid )
{
    global $global_array_cat;
    $array_cat = array();
    $array_cat[] = $catid;
    $subcatid = explode( ",", $global_array_cat[$catid]['subcatid'] );
    if ( ! empty( $subcatid ) )
    {
        foreach ( $subcatid as $id )
        {
            if ( $id > 0 )
            {
                if ( $global_array_cat[$id]['numsubcat'] == 0 )
                {
                    $array_cat[] = $id;
                }
                else
                {
                    $array_cat_temp = GetCatidInParent( $id );
                    foreach ( $array_cat_temp as $catid_i )
                    {
                        $array_cat[] = $catid_i;
                    }
                }
            }
        }
    }
    return array_unique( $array_cat );
}

?>