<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');