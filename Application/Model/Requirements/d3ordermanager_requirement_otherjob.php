<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');