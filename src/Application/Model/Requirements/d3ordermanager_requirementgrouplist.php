<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.0.0 SourceGuardian (01.09.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
