<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
