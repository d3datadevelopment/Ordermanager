<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');