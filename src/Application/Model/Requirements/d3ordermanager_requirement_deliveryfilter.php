<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.0 SourceGuardian (05.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
