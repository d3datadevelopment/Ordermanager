<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.0.0 SourceGuardian (01.09.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
