<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');