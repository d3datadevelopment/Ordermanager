<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.0.0 SourceGuardian (01.09.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
