<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
