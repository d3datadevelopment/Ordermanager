<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');