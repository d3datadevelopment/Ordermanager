<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.0.0 SourceGuardian (01.09.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
