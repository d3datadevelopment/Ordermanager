<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');