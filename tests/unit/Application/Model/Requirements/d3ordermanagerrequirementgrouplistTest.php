<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
