<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
