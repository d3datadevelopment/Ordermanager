<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
