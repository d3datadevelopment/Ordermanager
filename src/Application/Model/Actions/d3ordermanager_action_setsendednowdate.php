<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.0.0 SourceGuardian (01.09.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
