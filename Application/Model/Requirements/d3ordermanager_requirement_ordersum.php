<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
