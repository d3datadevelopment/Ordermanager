<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
