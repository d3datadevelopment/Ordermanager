<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
