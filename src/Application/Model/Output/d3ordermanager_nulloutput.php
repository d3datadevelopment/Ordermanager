<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B311126DA8AAQAAAAXAAAABHAAAACABAAAAAAAAAD/TuOiSkkvSylXfPqdRYAXRkk/2Ycy3sQA+t/6M6lu3cLhc484dQxmr+ewYht2hZ20dwjVQherRIKSxHM6gax4xRi4H/Mjs5z/0FF83JqG3bEjeIe6KTCNKbozed8marDEysLo0xwHUgIMrWTGf5Dw1QgAAABIAgAADNGD3fbVo8KsdIp8OH/RjFH8iuacXibSRhSRsL5lBc8i0BIZbOIoDyokOMcWgORp9lDqS92dpIttZ3F3yc9pLLszQC7Cj5GXAZApNhRbXUy3B8KrsunG5oO5QAqoSUhMDMOCNbjVajBGtBtQJI8UT6azwkLvBObtv/Yobh5/Se57HFFb0ifiWy5gJh7eVRlhjqZIcc8yiaIvntYlDO8pYqNT5XQwVBu3Nvw/ReZj/D/gXvSUPcpf6b0kiK4Es5snZbMlYW8JyAg9Trk61+bJFJza0gjBliyyV308V9HXsvISyvhjIC/5J3olOFae+z00Cqn/V9BwTvpYGLGDAg6huBTEOT3EvI1qbEFonQDf9ObCYsLtr3GOtJ39dscoYChKsD5783FsuW9AWCyYLwGDqx2V17P8gohRBKck52LuFoIXbBBawq8ypWUeE5mW7lnxUhyjnZr7Vi1zXQfkZt0Qgx0HnW3CdYl52p6PE3M8s3vWnrp/X55QSBsO45bqLGpUqGkDNefSrccyLLM+wDMu0hmjW1alnoYdekqIBrXibizAlOTeSyuLlRUASxH+cduSoStnOgDLPpHowCFDplXz8bXDT9yopYvATV02kXlkTzraXnJXtw2+HJ7GmaHJuGro2eo84wfX9lHJS7oIBYEzwcOXYkTf5KHX/0Rtk+lijfC2/k0qjV1R06iaxVirekkJFxFuyDXwjgp2vpQjgc4BbCDYmjY6903o8AZWuXi5vW/V0bCQWAdAiMe/7ipIVXwemA06URZBZ1tRAAAAUAIAABOAhEjs6l5cGY8eWvLfp8LOExM2vVGCduXUsogHeB6stK/0RoXKYxSmqLc6jdBKJqfMni2UqJvSZGLIIYIMnGy6SvSGaSP+fR/bBOSHFDLXrF5gq3k7pf/vLhmpc1+qkEo/0hX/PiLcXRwVRz/FCMST/U3wd/2RuEuJpH7zOnnKQTGWDHr4uE1LKlumQf4vFaKf2fnwjbMFl14UaKFqjG5yrVMhosoQpgcaOoPj/zv6F2dLmrRjcPeUsBg9wxRVYTB7o3jzega5cH7xO39UNjOrn2kNGHwdC9j02h3g57Lz/eB3l9c+UD8NC6MfCeGI2fgC3nxqyqmjNxoc2ZI4rLOAY29QUR+MjKnIuCIYbjGzmThFi9nsSJEa0z/FCP5oB3LhmciebWEl3dMu24pGkgedLJDpFrLHo91ZvqZs5SZybO3DNVP3N2JRExTaxV0uPYtMJJBINU17qoZNpeMaTO63ajItNSz7GVqMBfgMjZOaURGSeYNGe96YEVKVCnxx/O1E9nhnYvmEh2hrDdhYmbJ77AOLvqQEO3ek74yHEviGffP4NYpFljWx2a+FcyiQ33IYBQAUuR5WfW0BkE2IU1CVuCJkGVscfOrn58bDIM5L6svd+XraZIGRJe/dH8p294Iluncqbxjqe2jkH6JVZKxRFrvThAidRwNM/Ki036gHwsPwC5bCCFbYpjGXwuZQLr9Ht7z9FJluY+WUb3u8OMSp2XtUrrOYt3mYGL0fv5WlJusu+sNNEkkXXIP2SiqRxigkA0DEzhw64mtx26RD8LQAAAAA');
