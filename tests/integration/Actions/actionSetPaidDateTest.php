<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');