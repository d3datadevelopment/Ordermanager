<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
