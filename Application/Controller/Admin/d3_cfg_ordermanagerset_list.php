<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3A7126E48AAQAAAAhAAAABKgAAACABAAAAAAAAAD/pEvXy7PC8Qjn/ZhMdu62ffiiPVsrnDnUOU01mxYZTAce+73FjPXgPgT+FVaIloDn4oQkrL/nb/i5ystS0apyh2vPdCPPdkpy9MZdGfiZF6bihruUYO+hMdYhcQzyVfTWY6b89SCzu+jjTWwTgqlh7W1D3rBULZaur1uNvUBFkpGDlxnjOuKypCEvPn8KuK+/rMrp24cKKHFTl3fmKay+8OJXLY9q54Q3CAAAAPADAACaJzaborcvTsDatnAQRpm4GlSoa/PA+OHkpPIuJfp3ejLuBQJJ1/0cPz2nhcGDCc38OKUrulBKMwtGf6Cq5GXz2G64AZJlBgZw0tkurrEXTQQ9qv8s3V1GnVvo7YemoLVvS4OLwVUwJfEay6KvmuIGZfBWnh/QUHpzDUAfmoBgGOwLj+pDRWNBAI0qZ7TQXois5pzrQH9mOWP5J8BTiupVl4hUzWkk/HGgacEMWilZCi9OA6OvQce26T0VO2TnVRObbajx3nCB4wc0dcHodFFyuAczXqgAD5Nmibbthq2AkRyeHN28zRi3EG+4XkTCIWoAQN/NXmsw+FwgF/ClrEs7FfVD3+zxG8HqdaVoCWUbJB5ldpuTrXZe2Bfe9NMOlRXkdbV4ZdQPqdKhmnwP1Zb3YJAA+R2VECCLcFKQEB20kCd5kxYBWPWqVGHsw6hovJynK4qdp83tfIlwL58cJHMRQRppdh6yATvI1LakrcYicbK0915ewkRu7PiJCBnxamQBUDx2k6agPpFjAGDgIKcjgfkw+vBCI7dw8EkLhV0CuME5JY/fqw8kJDbz5/QKMfUPlCAwJ6AzISDIH30858yI5f/lYo3wyxK8RqUp39WTykDAOCPl1rQZl+ds05Zyc1JjJDZ+w6ffolZ1jCVeZ5VBnLRdpdmypeaVTFKxcJI4gu6YFlWpt8WbEnx89Z5bUE8hzbc6ITFFO0fv3LHA3W18aLyGC9qsb4UfGSRa1eXIG+Z7NDNnM9vR9vZStOb603JDvauYLfOCfHZh6tRd2XIduD0qzVQ63f7SgKbDSBXowXsgPChfo2/fmNJNnq1KMtSwOLubnix2KwOkkWuCfVHK/UHxpmF3Onj9UbGw+Quhhrg+H8nDAAQ6/nlgbVdM3y1sdu3n7MRJdh47OtavfgIh89PGAZl+UKLTGxZQL6UJpYBK3TM/LL4ySLEQkpl9rvY3XjYKcZVt2iLIP59HL9uw3gkxuoX66v0aTD0hu++nKk+WwDzVA8zQrIGnj2earG2faS8E/kYPYWpLXPaoHAOajbGiA0Dl1hqzszA6YozFEpX+CPNkXx7FXD68AnLflEjNKoI0o/Z7dNJ2Jieu7ldKbhpa9Y7/PsSi1+VQc2RiOb5nhu4sS1ATALGY2oUzruU7XJK2PpEf27oBAD5SLCTXoAWZtxW/LPKMBSpsqFhoWvX8WSVPIQsUMI+C9tfsvsxuPU7wl4x2jwF7c/g74+jIY5wVnWhHv+K4cRtdrOHS3bW7pNDvd6piZJKF/k6bQrpJuqgKD1MYMM9U+p4fySqUyPqXtJ/N209ye3dizV72F5A/4uqrXuNLZLeabxluLipRAAAA4AMAAGDMkK64vIP/4szRpoMlzIgTlpHaaAsCVVV6ztT4pSEfIU08aVQy8RKDkJAcE0HyGo9JB3srcsOC4Z755xy4CozdndJwjSiandZYeQoUYYFL0UabFf+Vqh8illqlF5jcJYL3ng2OokSal7Kqnh66RP3ecRW34/AQMleFMIZPKNEp8arxcaqUDgn5Emvca4nidWgqY2vquAGWDqLRKJSqSeImXX894TbgfK4txoazoQVN6xAx9at1/ujnuQnfmaMourh2mKUJy2/lZnbaIk6ZqnVFx7Tz8oHupyaO0nQcN1kMqwLxDX2AXIw2yIXZ+aL5d5gB6ATI50Um4C0pzoiVvMZVp4VU0aqprZHTjyucaTXFQRqcOFarnHWi/wnrBX2b1R6D7S6FHSSlJVbxGIVVVycOxuLcUHwxtUV8Smz88gOw/O8B50flz6DPXfncDp0qA+vmEgiRuPhQd8ChR64XI+rFNgPjAg1wZUR8BydWPmVkWOnBfTDkGShTtFcJkqdCT3k/Lr/+U7mxB4Q381c/D19kzysWLTr9U6dpAB33MAYxUdtEqJIbpz/OIakDatWQrYqWqd1Bfogc8ZmqUUd49JM1N7sZ6RhXO5H6axtEok2KNAAzquhuwTSBn0x4gv5JmJcod+J8red6Je8+CyygO5fyRh7e3clW0TR1p2egvdGnkxWARE64sr5ukasUhYveyMTH/ZWn3DHKsA66VNVQsrHgxDDz2LVZvdwK70fLUbzHRv4BKsyc/NK86yoeHPA6ZQvm1CsDRHp5ZuyNYCRyQP8pDhI+4nYQwua/1C3I2grtv4eC0AgP1ooYJXNez+RNxs9dBEwdoQLZYz14ebaGrNByXce/U8eMpXoZkXgPeSIL2ilodE5HTrJQB5TuGYg4WxVuymWP01RhJVbqorFIR1iMRBSN76iv+IqSvOzApsMD1j1lG25z827x9EcfQQW7y3l8vJokIDQPGeBzGDW9v73JUmKOXGmpdZ0xDBRp4EhHSWlhYgcTQ+2m2w94JfAMqSPE8rQMwrZRHHRrYtI8kAeEjkrTM0dIiFIhe2l/YvTmW4PdUywoiGt+j2bH2fnrUGMPhv4UCn+6lmRX67/VFybeZe++kzhmZnfufc9RPJANaaJw1yDIMGxcoX/h+kg7GWB43teRtMxtZ8sX+WKEfzJSfy+4cqWDK67fr1AFa9VPkj/MelVOwaDvewwYPCCjak2L7TW8SA7CBqFug42P1kdDIUrk9Nb4fqvr8wwm05Aynl8G0Sx1+kTJpAjqV9cZfecju0ytk9oIT5cy8VMDV9SBbk4ZeOLril30Ey0/fciWUgAAAOgDAAAgxf+KyABzq7MIzhjDA4SnAhuxeQwX5W1GHDD20wQnWMSNfzMB4jtPai7HZanhqPtsgiMPSQJHOBbqdWcC0XAeZLzYdoiyf6kYG/jmHlLSrv2mZT36OEGsp1hmP8vmV/tUKWynvr/nBt7VMK0Xc9fKGP2NlGjviLkyk21HFTXL+9TYKP/xWzIkXQ28oaEEJpR6sBH3o0zzLNw4QxjbL+EGom+2rVbijLUHSufAV0n5hcH6MXBgjsO7qvG+n9BXLMDs5sfCiLrtY0lnprKA42of/KLtX0jb1sZH4c3C+q/tPPit0sPnN63WFk0ZB/B2wvu+90Hbxcnx2x3Dl/n1KWOaQm6tPu5jrAvEgoZIAGRsmTcZmQolf6l/mcYYpzTTwDEnsj7KdLYFYcBVqM2/o6YEQf1VdJUTqFfSVhEGOd1h6vSKr8UcH14q8QuOoqaaBmUpq8HulmEVL9bNhfHypWkI8EeYCCu887/reCmprvYRJxpO3TAk18esdHZzu7SeiwnVY6p3FWwlIwUaLKMchMDrz1gJ4hmfpaO+yJ1ySdc3B9m7Njo1sOMolafO8nrVQ3rbXrqqILUYhTwbf35V/4xjat99jSYLwnmCQ5DQjWYsDKy5oX/I+BnQ3RjN7WmDRc8o1SJzvBR0CRYS0nzbbVx7YW+6tRxJ3H2KqNa4MOq0p9+whjol9Awj3c1sRwcO10pS4QhIRCbfokmelaM3+ssV/61pf6qn1zOJb9ZcyZnzSvyAIYxrKVtuA+MuukwDzhwIAfwnyjpGNphpDdqJzD5Jd6O6YnV3Iez1LWvciq3GoEhtsyZTxgEgRGu89/NjwS5NH/uqzCY8yslqSeXtulxjvHU5sYiSc2+mZ7f/eOU71EjLcKqqxzHUDF8TEM6hiyxXoWD6munVdxPoSlvabl6kFBgjVY+zr0q4lNvVgn8V+pTLXhIciymqQQHQGXz8T+mJ0tLJAAxwIPsVvJ6Ckzar/V9lIkjARROpJe+LfhcmnMkMpamIXRqv4iJX1YZ4HTeKkxtdM87Up5CT9aPLqCDNZ0ir6F8iK3NzV7f+SVnM0A2H4bHP+RKPEsVgYxzuWK56mVgrraULO3KHDaOI40kbnYYry3pG9WR6IQHQNdPRusH5kUg1gpIL6wnKrZpRH7YSNQIJ9Ko+bviQ6GGDFATq4QRwX6OKk2rR2VMJfBPNEPdpqWbeofaPLSRdQcckfE6JjZJafakn9QXNZFCieYCWrMRUaqp2nnLjdOCXByh7WxAbAigRCCwCVnDe5oKRIXcRcqOdyN08KNGlJGtns/SkHCVn73s2oQL9B0kbgzLg1UcijSN+vpMMAAAAAA==');