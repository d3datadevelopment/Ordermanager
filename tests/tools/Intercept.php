<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');