<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
