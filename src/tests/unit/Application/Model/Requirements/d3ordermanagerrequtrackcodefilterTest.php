<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
