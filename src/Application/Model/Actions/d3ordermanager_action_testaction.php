<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
