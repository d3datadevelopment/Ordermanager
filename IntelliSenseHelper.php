<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');