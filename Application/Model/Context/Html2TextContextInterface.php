<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
