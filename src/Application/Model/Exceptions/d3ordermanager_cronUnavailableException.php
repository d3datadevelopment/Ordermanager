<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.0 SourceGuardian (02.01.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
