<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.0.0 SourceGuardian (01.09.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
