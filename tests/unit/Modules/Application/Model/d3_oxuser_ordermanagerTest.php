<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');