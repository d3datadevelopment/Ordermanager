<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
