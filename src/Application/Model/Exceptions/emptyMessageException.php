<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
