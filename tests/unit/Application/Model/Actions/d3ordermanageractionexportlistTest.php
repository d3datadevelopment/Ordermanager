<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');