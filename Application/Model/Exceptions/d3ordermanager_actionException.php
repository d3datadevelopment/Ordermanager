<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');