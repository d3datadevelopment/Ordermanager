<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.4.0 SourceGuardian (08.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
