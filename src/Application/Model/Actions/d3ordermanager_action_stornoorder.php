<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.0 SourceGuardian (05.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
