<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
