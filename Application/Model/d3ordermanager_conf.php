<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
