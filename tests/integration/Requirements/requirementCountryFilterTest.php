<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');