<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
