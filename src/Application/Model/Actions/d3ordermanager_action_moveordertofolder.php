<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
