<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.4.0 SourceGuardian (08.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
