<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
