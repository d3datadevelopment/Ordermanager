<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
