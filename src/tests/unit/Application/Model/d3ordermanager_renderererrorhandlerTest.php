<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.0.0 SourceGuardian (01.09.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
