<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
