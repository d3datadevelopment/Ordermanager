<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');