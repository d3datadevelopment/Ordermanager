<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
