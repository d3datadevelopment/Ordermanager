<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');