<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
