<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
