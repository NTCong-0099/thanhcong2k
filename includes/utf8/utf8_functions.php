<?php

/**
 * @Project NUKEVIET 3.4
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 - 2012 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 08 Apr 2012 00:00:00 GMT GMT
 */

if(!defined('NV_MAINFILE'))die('Stop!!!');function utf8_to_unicode($str){$unicode=array();$values=array();$lookingFor=1;$strlen=strlen($str);for($i=0;$i<$strlen;++$i){$thisValue=ord($str[$i]);if($thisValue<128)$unicode[]=$thisValue;else{if(sizeof($values)==0)$lookingFor=($thisValue<224)?2:3;$values[]=$thisValue;if(sizeof($values)==$lookingFor){$number=($lookingFor==3)?(($values[0]%16)*4096)+(($values[1]%64)*64)+($values[2]%64):(($values[0]%32)*64)+($values[1]%64);$unicode[]=$number;$values=array();$lookingFor=1;}}}return $unicode;}function unicode_to_entities($unicode){$entities='';foreach($unicode as $value){$entities.='&#'.$value.';';}return $entities;}function unicode_to_entities_preserving_ascii($unicode){$entities='';foreach($unicode as $value){$entities.=($value>127)?'&#'.$value.';':chr($value);}return $entities;}function unicode_to_utf8($str){$utf8='';foreach($str as $unicode){if($unicode<128){$utf8.=chr($unicode);}elseif($unicode<2048){$utf8.=chr(192+(($unicode-($unicode%64))/64));$utf8.=chr(128+($unicode%64));}else{$utf8.=chr(224+(($unicode-($unicode%4096))/4096));$utf8.=chr(128+((($unicode%4096)-($unicode%64))/64));$utf8.=chr(128+($unicode%64));}}return $utf8;}function nv_str_split($str,$split_len=1){if(!is_int($split_len)||$split_len<1){return false;}$len=nv_strlen($str);if($len<=$split_len){return array($str);}preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us',$str,$ar);return $ar[0];}function nv_strspn($str,$mask,$start=null,$length=null){if($start!==null||$length!==null){$str=nv_substr($str,$start,$length);}preg_match('/^['.$mask.']+/u',$str,$matches);if(isset($matches[0])){return nv_strlen($matches[0]);}return 0;}function nv_ucfirst($str){switch(nv_strlen($str)){case 0:return '';break;case 1:return nv_strtoupper($str);break;default:preg_match('/^(.{1})(.*)$/us',$str,$matches);return nv_strtoupper($matches[1]).$matches[2];break;}}function nv_ltrim($str,$charlist=false){if($charlist===false)return ltrim($str);$charlist=preg_replace('!([\\\\\\-\\]\\[/^])!','\\\${1}',$charlist);return preg_replace('/^['.$charlist.']+/u','',$str);}function nv_rtrim($str,$charlist=false){if($charlist===false)return rtrim($str);$charlist=preg_replace('!([\\\\\\-\\]\\[/^])!','\\\${1}',$charlist);return preg_replace('/['.$charlist.']+$/u','',$str);}function nv_trim($str,$charlist=false){if($charlist===false)return trim($str);return nv_ltrim(nv_rtrim($str,$charlist),$charlist);}function nv_EncString($string){include(NV_ROOTDIR.'/includes/utf8/lookup.php');return strtr($string,$utf8_lookup['romanize']);}function change_alias($alias){$search=array('&amp;','&#039;','&quot;','&lt;','&gt;','&#x005C;','&#x002F;','&#40;','&#41;','&#42;','&#91;','&#93;','&#33;','&#x3D;','&#x23;','&#x25;','&#x5E;','&#x3A;','&#x7B;','&#x7D;','&#x60;','&#x7E;');$alias=preg_replace(array("/[^a-zA-Z0-9]/",'/[ ]+/',"/^[\-]+/","/[\-]+$/"),array(" ","-","",""),str_replace($search," ",nv_EncString($alias)));return $alias;}function nv_clean60($string,$num=60){global $global_config;$string=nv_unhtmlspecialchars($string);$len=nv_strlen($string);if($num and $num<$len){if(ord(nv_substr($string,$num,1))==32){$string=nv_substr($string,0,$num).'...';}elseif(strpos($string," ")===false){$string=nv_substr($string,0,$num);}else{$string=nv_clean60($string,$num-1);}}return $string;}

?>