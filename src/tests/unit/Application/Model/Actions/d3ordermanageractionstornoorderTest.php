<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.0.0 SourceGuardian (01.09.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
