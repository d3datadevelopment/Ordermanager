<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
