<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3A7126E48AAQAAAAhAAAABKgAAACABAAAAAAAAAD/mnY85gOmOIv7Yc03sCcxwYaiRC4D63WCXfufmijunNOH3yG2FoO5wH6ezVohxXHD4Q/A9T6Hi0oBD5dGEbYgooF5SKU0kyeH0ms/SETV6j37eqJEUk1HNR9CLZ6evbslfCwSW7v9UjLKpZjMh0iM32t+MTROd+AwBxSIiiag5I52VkJJIbxPT7LSuT+Ly957MtuE/cYoqxtoYsY62P1yjSTGR7OkueuyCAAAAAAQAAD3PhfHAkYnEBl1fYsbVdQ2Lrvd2R90sn1JGdNn/x9NO/Rgi/qVBbPO0PwwbU/2kwksTUDnf3z47NZ0pzuO99vjJetqRZKq7nEAMVQTDgTilx4lmSmwsmmKxrULlhSn0QL/dUwWvbnEbezDJE5oO5rZGZ/WQn8KyULydCC7om8mkUhdxS7r5rIbHgUDJcicbeO8vOSOsP0+7+dBXCzR7zjgQ85y/FRjNAyYfvLQNjdJAAsMqHWJU3xrsCnUiAuhYi9ZEpOuS6mExuYji3oCRYaC/dRyPCUGDeJXvANhuFLxdXuSxoVZy3K2f+sUCt66XSJZc2u3O0gAgAN1wGs0T5w8E1vqtPLQNEj6Be1ihJ/w7woL0EF/Uk8qiMhTyhpOn5WS5OSLYmSqN4tPjvJjGyIkvNCAlckjFGsBi5k6MZKBUaz3nqYuM/moSGbb7eTCPWMycvCEl/1ZumS0lB2fMYDN5Ywpw2pSETEjndA0E83ZTmsUWq6PxditCMkQ7Y6yCHFV4BqZX+3IhxHt5hEJ/hOR6R1jt/r1/rTywUYdaED6CPasumKJXT4kqGukJUUKQOp+s5ktin+BzXHtpyuEIjC9RTCUygycovz2PisADY7iM9nnmIG+8xaSTIUhd2HFoQB0Zihu7M4K9rx7T848XtA5aGahHjYDUhqBuGS87cCuGIptwpiTCdfg41lu2YklkH7C3v/pPyb0Bgd6d+6t9nIXwU7AoDZRx+4Jj2cXV1Gl1WFuooOT29L0h3sLZ0XQq2xcCONuse0qX0/l63K+kRTQQ2OgT+OwVtKRlI4eDQcOJMaMrO/wTdP+Ma/BdyY1oZIzeUIGq6ciKrf2m9yuDzQ2xa3a/i4smNiiHdCIwBe7uMXtYESoz2PrUVrzx2jjVw+6BH7p/9IfD273I/WPmQEDKrwoulOv8fdU3Z3TBGsbG1+GXGXqQvygMJBS01+zjr42LfyKVu0YFsInUcKtQy6qcfn05sirBRElfh1i7qR7CVK3FYNBX7RY1AGlmNqdNafHQ2rle0hOh1rYuy83A83gXu+ozdq4FOLeyY9ALrXg/Rn6vfYt9dBnlYM18NMuLFvUKNMJJhLD5eeiRGM1ddOSg1AWxxn/uZyp1XoXaJtcEPlSFtvokvBQn4Eh6dG3ZprhFHqsoqnnG3jlPgMqjVB447Wl6bsFbKMQjbbMDlTCkXWANVmK+nHGetyCGKbY/FBEW2lNEGBDq2/TIsU0TyZ3ATdyYpB8CyXDC5kQRFgMjJm9UDnA3YTyEwwMIuGJcclg0juEQuEY/2FsUF8kjcRlwCRTRW2oJgbFTPwqUdYbuM0JO9vxHkZ9QXJ91pDqObYNaz3s9c+Z7UeUH0p+gggSe2JFVDCTtYgSh08nnefk6fDa6/xmuMF0N1Ony7lukPIiwQE8gHzfxL4EIXlpgX4k/AaGkoi3P6pM150V0FcANwxU3XhXI/lAQ31ZNzwjdnEX5KLBjqfWRReExOslna17UMfQIcRFw6H6tX3/Ei05sbrgVNIB+nUYIdawQOn9b9gT7Z3dPeXImhfRMns6erMvfpI28PtCuwdicm+fOmqoCm66H5ZOJr2oF0VeVq5pZjomBLSoeylHb4ZhReCRwEpvkpoXiHrNEAcPCPPIvxyMVUZHXMTKozWjwTfKEca9sW3+bz8FMA4VBMLYUgepr/SgNxoH4iW15k7RgXIorf2VSky/jBAP54OBIQwh8HwIzVDA9/ellfAxQ365WbTWr5YAsQkrgUXtFmvriIjheGDhnVIhCMD229z8i2EFz2aocScZu2p4qxzh2IhtvNleVqP9I7XPoFGb3SWSIvdvEs6h9jc+/DbW8xDtwI9Du7Cg/EzLiEoDv4S2FRIXQFMwLhSQOg+J4pLOWEL5SPxAE6x0/uchXZoqRuloysts9AJPsJatZtR9OPa8sm3RY+afUVuUKm6I0H+WZBK5yafrIz4n5nCUqGTDuwk9mguXSrQBOzU2emDfsEtPhrtqahHrTNGO0fxgoJlUeLavF6fZdWcQrwhsdv18oPtQPRBD5Ncab8tEIESxdD6HcI79bEgwETF425LcqAWo9CuDzgll+s5eH9rwYPlRqSJCRz42G+kn24CWFj0xjIZ9tSL8EimHzUkmhkHj+Qnmu6f/d6PkPLeB/M/YI4RA4lKEfw+CRQnkGQWUbwuI/vDZV1iuLQKwSrpkFMNmx34PgeMTluQOicNHtuJGqmODNRCzGo5ZhRyM2a5abAx9mUrwPpBaoP6GNNel+AV26TcSxHeisOrOj3n26OfgPBCexGYBAYbjGXmTdA5Dcq6GCcR8MY+1TEcNfwxUlek2fzzMJD1MHqsLaumkVxWMHbA8hMqA8smipF0MPJ0ipyvk3lS5faAyorS2ZMkupM60ur4nt3B5O+mv4C5L/oDAF3dRS+3lyQf6rKSQpJV80lQ40PU/Iu2mOE2KMwZh9TaTD5TZIPbcO6Q7uih/8VELswBiXsV+d56f6psg4FhQNiPNFj2UjTjtT+x3rRdj3uAlT8/RLJfoy2ur8lInh+MTqdcfQGpInwUK64tzy+SMpLFfkCRm/W4VLqjjA/VEm90dJdM97r2CK9O4PXCRPHbgn/0CpbEKN5PxPJx6/bg0vkqhv8sMTQ/TmHfKks1pxGWGxAlB+f/ElRyoWjo0FjRMYNpU3TTgwCotU9aCrkAiikT9CmVedj6b1vyGmzMBDr0ptTS7Plf/8P2YLzhUGOyZ3hGHmVGf12IhiwmgOkv0Q7g3gbay+vAD7obv+YvuWnmob535UwiI7Ne6iagonhZLtqoxhSH/4HMDGW24aJwEZT1Ycov9+E9MxeWTJlirU3mJBfWzYfdxiWokq8K5wH7CiieABgrIizw1QknyuQlYmE2ABuHYYYUzTnR6CBTiW5IrzXsH1SXTwTynlNJyQUGCBuANu/9RVFY0iqIns0NsYKQFHBdc/BHoVdzXVIeqdmBOm8+ip3kEilzVuRKg81yPJ0cgpZjIKv+EJcQ35S2H1id8WIwjsF9y7HVUhQfWq/OXZbUhOZpDFlLOmaH1i79jHQ9gq7iiKpI7+QPn5+IvPMxNDD/FJFsWOn2a6Dvlbi00u5FySkUSTR/X1c+FS+AiuTuC8J3wNjgVR7qWbPahQg+UZnLQmofw5V5fcTEzEFL6MHqhzTrC/p3xZYguEIQEOwftErAr4mHSl+wCF1LMCaOUQaeNvPQ2bkK7Fs5qqcnqFYKC6sKcSVhxxgrMgSqL5Zi9oOQy2U6nKMTJikagpWOSgplzJs+BatwbOnX6fYJbpggm/2Ar/kvOdrgdOXFs+zcRv0wY+TOq/7f14KyTglLCZm0xooA3HzcBdi1LJkUwJQaWg3DbanWyDDA9gUYtT1AMCrNpscYmdXWiUEcHsYzWJ+LUUvMHETB9W1zgWa6j/2Ds94dXkpmKhrRJrBhSlWQYR4ubNfTD12a6NbtVk/JQjacTgMTj42ezWiTu3lp/G04qzGhYqdXbiUTfVZ2s3eqGEhV2Vx3v70fazXwWuEd0NpztYGE+Pp7m7J6pl5FZyI9JbdqMfD7WaHybh+tMyJEP8h7Z/GMIFs4ZpzvDs/vAR51GTZwUm1Hrhh9ELC7McT46PQAWMRx4P/4z8UH6APViK1g426qdtJaPfDk9zWu0AlMBq0wEhZJhtEq3CDofrCpFOMgKJKZdz1qv5s+hi2+R0dogzyKBg2jOojHZXV4Vq6JohbJ1aeKIte9Kk62UYHyQZZf2wLRwI4F4B9YO51JixxPR6yYclvKEc5aHwENkegg0YiXwDamr+bG26vRXMRArAoznGasNOyCtMq5LlndCsnhP1D05gFZlIawKQ3IP6P0GaYdsDwZIQINwTsUV6bn8LJHx7yDZigJCnCkVX01904v2C80piSsq1k/KgVWXaDpmkd1i+gf1MOLvamP/Dejzhus0nZg+N6V7DtRSUg5Rj5WuXSZ9XSYXjtoUhA28nPMix/ID8MZKsTxv0NBUeEB7WQUQEL4sF9+bslSRwq9DGHkkHOP8u9mIdhm7QKCZHij7QQEm5psbPV1PQi/rEo0mRMqe4fX301Yp+b40Y0NFHYzbnJtFb5A8UrA8jwQXFcQ1Um3sL7JaAfq6PhkgeKD5MPxGRcvEwXlsUk2Z9OxJq/anP5vob7Zi48Jjf3VaXpvz8vGk+zmsPAqkwbtoVlwDgJ5/oCD6mfyTG0xqj3172lvst771z9IajmgiAFMna0bVj+aOsQ0b+jfNBblj7ebvqyPyvzkk2V5gV2R7uyvocP+3O1mUTlX/ScPZpg4ZjynyG2OZSlmuDKybXekNUOYc2eP2SVNlPe1PTsKTImfXfb4LKPOFuQup5lLMP3+bSsyiEOUKAyh8jyyj4WYbJviiJTSV2B/EuwvCMA1gUWBpTqYAp4podwAX5lX+7WDRH9UDSu86vn/cAguVvbVRVAfHYi9AMP5GnPHIm7zgstNEJdjamoQZTru8z3WHYlyUWEMqlWMOBtYAgv6T8ZZA4mA+dtpr+duzRSfxgLpOnU47jHtzB+VPKfF0XtqVYtDrDeWLvBRkvc6byJXWj8BF7Cufc4QUeU/nHwq+E7nGNLujnWamte1fkSzu/JWwu3iRx8+F/uPsb6m1lHM4h9eXtm/i4jth3wK3rDQNIna0UQ2T2k8tyey3kOIuxI2Xqk6dYhGfz6hjYU5KKYRdUqeaBSz4Ed738/JsQsKIw1hOKnzt0kRZbjAStW/jpPXHMcp0laVlnPum3dHNQPyB16TBqeuUQyLjVDRPaXG+aeoq7yX0mcvjYaqk70nUV8eDFbYApg4+ASHTnSL5mzodLoC80DDFKSFA/zlaQDhK1SSu+fBcZiVeUNIYE1s+6R8yAMymTlUUJfbqdtDAso1g4N+kQGAFPOrCExbscF4y3+BejO8Dks394TbUqgGDrtzxwbxOD/RXbbheI78jInTi7Ywr7Y5j8P2BFYpFeTJ0XEm49oI4F0yDejA5W8dp2L0lCSY5hpHDNsclTJscxqce+ihwHOFkrwAK+1OmsZEU71bTGHqv/E9iwkqPqsKbgSW9dWc2ZRq+Z/OBCmSmhoydeYufHEs/A7iZWwnraYPBXB9DaA5rF3pJHC3rByvNTEL2inQagmBSmGQvyoxmYRyBtOV3G5WOn7OmYsMyOsyJoi7ZPZBeFP8SymfkthMfcdjYQJy5DVa/VJM2Jwll+LDC7ez4i1JNw2AknVBAUDgUN9bQ7w5z/tR0K7ITBf4oLYhpp2CqbKn7y4FKVehpA/dP/UNd9RuWBJtnWfbh3AE0q6aFWs21y0Q95RFCYZGMnAQbl2NE/mOsJU0YwuXNYjsIUnk7egWCc5dxOza5YWtmQmbRUU7phHciQy8tJsWxx2bjpj/68b0UCpMNgPyE2GUICYntxsoglFV8pKfz4PjtBnv0Y9cYrFSVEo4GsyY3psYwpuN40A2FxWDRQ8TDkmgAUQAAAAAQAADkZumj7hF9VLHafoS9AeW7aobrkWBk08gOQe9JRurlU0wSiMIUfj1uVCrwuIMIC0Tv5BTB/d6ZpEPkAqi6i0i4TiYkTOhfiPUCFAgEdptv6AeK9W5BLJb2iX/Y1d3J9reIKguh5aUZbNwYETXrjvBx/iVHuagi+48vVxW0kFETmEhmi/p/c8NLkmthgYxwF0y6kuzkZppMSwO+WeXldhAe2NCGrjECEpXh42OUwoJRUB+lWYycBDmehxeG4ApMdCth7u3EG0bndXsliM1tlOFZNGjtjt2ApeBXb3o5Na+yjMlnpPjMiK8bxHZvjbtv2fYxEZ26m/1a5CPThMBKroSYtAv0MFHcGeIW16g/pdxNNtPyWArVnFbXNJIaJckYIgXcKkH/v0jd1u9mT3Bxgyy43TGrDG5KVxsf08aj4Sq3M4d4XUWnk7LpGTmbS3YGXBBHMmc1PvtIyofTiiB10WWOPWD73JLdiS/nzYFK1M9UaaZA/nHzcVm0qbRoLO6HZZ+6tjOsT9NNR/FfkZEh2+z5JtMqTC6Bpu+ieWxAZ3JO2V+O2T4gzwA0LMjpI8FTLlgSdtmTibuccJS0oc5qNkuVApXqTSN4TWdGIFyt9/8lYlBhGRDLv9ojjegS5Z5/ycQBHeRvAQOvpEzOnNfav0eRTgulN5uP3ip5Oq8c5tIVV/JorXEBV+TEG6EHJPAyA3TKlkCvigq6bRz9E5PcKL0ew8/eG3dSsEitv2+rIV9pYCU/xeRE5Kwb1lnCMYU7vMgvhFHaDFKh65j4jeN62zluSxPVf5srHbg6S//LTK3h0ZfZJkMQbCp763y/Qe3elh1l7KOttSuAVg8IaK4TBtwN8qx4A/o1z9WWTPMvc35B/NarFHGbHtaLsPc7asdKsmRjmntgVcu8Tj1+1vfFNuPw8z8kyWJnrZ/WIgGH1GlidfFrOCVkLrwfCRkVTkgqYm96OnhwRsPT5BcQE5Viu1sGIUG6KaEwgv1otwUEu+iLjjtnWs03RtqAl6Y6oUkX5QPqW0m/2X5MMCnR4mAyi8JhW17evEeKKSYQS1vG+KTcyz7/5l6NzebYfWmYCayzU3xFnX8N7gFP3QVwwBGgB51N8y8HPMPYDMUeWiE1MiKZiVKDeP38HwujE3gNpPwnFKl5/HdV5kA4jomPoYc2c8XgQgI6Pz3TXlRH42twAZdKTRFco1kR14uuDr0JpzYEHSv1aq1arXRXnFcDwpXQSERC6xr1jfjsvmwR8xRN11qq6Mml/rakeZd64nh3FgIUyCia9eAqlTbB91vmqogP9ad5VXPLL6/Py9Q3CXQ1pVe9pcWivkegDXAuOUTcO683xfqo3R0CYk/I/+CTe7uUqr016yVNm/+mfoylfdBBEhqnL4wwWZ2nQHGhtCCp25TLgZiDpctCyOJGLc1JZpPE/cIkOkTUK03UkoQ/gzsMao0AnJ7QrPSDXwXsntPEo57RE+uVgF30Yal56yIuvBpTsyhEcqIgvXOL80mFt5kihA/ZtKkMC7cnkD2dMVIbdg8kgziCcYDMmthLf5IwutaTOBNCjyfWPOVwlTfyxk9gosIkVGzra2Dzk2H9MrDUqQDyOkrGJF2gv3PH8ae5ir/kSQmzR3jSvWna1naZ4a3bYpOjJYwZeyQR8fEIjYq8ROnxlsr2+UKHzlYrB2Mn89SvmJ8z24Kq44Lnn6/YYZITYMMRSZM/Ll7oUmu4/ZYeRioQDPLajyD2TXi7EqSoPXp9yVd0XJLiLnb5TC0j0GtCPG3MVIb687sXI1np2z0Cs9vvBrbYM18l6RwLG60v7FBbffe2aLgnmHWJQdZQ8RDkZ3VP0gTJqI6iH89sCrOuU9EiJ9H/JoF32vNTRPctKyKALfTJbO2L4ZnN05yTAM02RBW6F0wVJUu9BZOJXZBoL2bIo3SnrxSrnigV7UKRW5P/bniURGkJgLGhElgTO7LeeCDqtmGIFm5cdxPjXrbUQFV1nPUAueGwz5A3XEW+9LEbqU/3Dmovge5gGmqTESSnVmuafKzcMgJhmT3iO9jRTmTKyrQow2ijh3UNXqSjNr0NJYFNE/oHen7d3LG8v6WyCCImoB4b4FefzhQakTvxtVxetdl6QZs6FwzKJOZa8ykzxnQweD5dhxeo/LhFrN+p1J9gvOER7MRuz9ereIOj+rjsY1gosh9hHEgdDw8MVVY8CWoAMuIQYEayi8eNnabzs7EPu0GZG7HDAueC7JmDD0h/yLhs1Po27LIPsFV5yyiw4g1txU9SJ5vAysVa7atoKwlwGLbfycDpXvLTxnnyNgVnyK+YBbmn+zEVNYiBHQicKZow4oMhSDXXyVI/NJSIgsTCaVABIL+P6ywITWazR1RnIbQwjVEXDgZxq4bgq1ootod3cFGgr+i0MbdnjBuIwrHsfAmpWNvMK/UnBQgOKQfT41Ny0OdVtK2BtqYnx3tDQPlvjG+nyxO2f1S5LfD6bwkEIeQlhSxif4Dmt9BERJY0vWrAy0f6e7sv5WXn/nOMfx//gMIE7UvbQvtuly9fXH8KQJ88vQM32aAmr00Z62qPsg2wPmzARXOGy8pcNruwJRJkernbvyq3VBKf9n1sPpDKFtXy1czjE5VVyiL6ie6kZtYNNqux2DsRYmdJkP7mCRa7PlDXZG6JLtbbdftg8Z/mypO3KOMtaNkF/JzFncD5DlVg9uEc+geSFklBtcMfPc1Ph81uQgcKR9PaXHPxaJSm23LtZMGee+P16wBm86cCaTVXLbRAhrFYT8HO8B+Fiw97iE8K5k3jhubpEYwAaLmMeUaodS9pmTAtn4s8RLOlQSVkRxKRASnHO4p3f637vn67jSzaZRb5gO3s5H294Nov1bVHPzXVleyCrITwUcvYLGFZQr66IvRNadgrpVeTJShU+M25x7SNqNQKobTO1qm3lgFNnrn+TwTGORXGKFOL60Qo7Kjue3SBIKM8jkPh0pRQ8sSfn3ZAj2/gAW9MDiTbpoB4RW4AR3RG1kNtqSMT32x7/Yzm6c7RrqkMWgSV3mT9lo92Xo3hwjL79odpbdw7ysFH2c8RJLWxz8bjIvbvorCll/ipk7afIGMU8vND02+9i4xZAFOQM5A5AxBlPcEviPyBh8Dw8hjEFQ3s7i8/uqKB71l7qaIAqpWDexMTde97excU8vVurTq017FTuBYw3gBRXnHnEbULweaCJE81poQCFi3iT/0J2Ftdvg8EDyFrCRLbK8CYuNoKdY4DiVCrcBB95ubl5YiPN6n7+/Jnk0/xR4EAAbj4QUtLDg/SP3kFlmZp+3QjjEDWlqX90xgIGo2DuWV3L4i5uyNZ4y2xAcqvBVDy4aCcKohnIrxrAKGyU6MwVsKHCoPjB4tAdUzwk1eODhsrB8QBWpkt3nnYQ/21TytKbrrGw2dUro/0vppCacG+KF5EAkjkG7f7QUFdCkD7vUaDnQicjsEzFk8YljC8WhzuhniY/vipLBCeIZGYMk60hOV2Gp9Qr+1Qf28hG4RqlWEoZqJj19wcPf3yz2Ow1h3iJvbqlQF/CRlFL/v2Y0er+AdW4/VIzp7r1b+RCLRTEvAugHiTsfBlDCkUEdcSMAD4WE+dW2TZVz09qUR5XSNdxTjKvJhB6f+0CaHgZQdFlO1u9maRYLW3s+lVTC27PWLTNdKKlqkO3Qmux3yXZ7Mx/zzorIh2PLPyp08pC9R7tpDCHrWrRYfNL44wHQOGdOTpzVAAg62ygDw53fV2SBSgA8o87ihIGL4CI3HPPrG6G23AVXu+4UweZYNJyl6Nzm3H40mlSE1N0LEv1AmcWYg5h+lVe3kBbrPRkYyWu9DvOV9cwZw97r7hChzaLAOIYEv3XImUQhSagKQjDBBG9ga4IL6DQrJhFw7DhSl5Qu3mhIFkAYUqTxU5zwUmXfu2+NY0ySgSsP8u9Pui/WnMzfAJaDje9GTJDP9z3HCidlOE8QIZOvG6Yz1WGAphKf1xVUd0ebelQCY8FAAPkzd2IO4bgD+cidMLTxPcris8b8pO9yUExh3ywpYewFu3GPT4ylXu38liRYvnJ94ovL7SlNNBfL4rSESU9OFRPiq3vwW3iHj+Hzxj5h1fO6UIHVvNaNTISV/sO7MR04ZnXWOLOk9E/++GqBnPJ9Kio6knZH23diRh7aL9VkN0yndySKNQKSAAvx/TdfAcFO4tDsTdtGe6mH7Qni4VWKXt2jMCgX85obB1MdmwQt3EOzZ2vSIVEc6a821/vNmHXIOkworog5hO+Pdo93dQbwwudsDlhqS0gg3O0JztT8TcXPQAPDXPyPNCbq1eqMybcp7YaNafVw740hu9bEUTkHY2EgjWTHsOu2j89zMl2gTwB1ks77CVvgtDur0JbhHp/JRr38ILYNvJB2FY13DleCFoOUxgMedeQyzc9I31hcUkeDzuscc1l/N43gWs3bJN3rfnoJMUt3itK9UdAmAEarNMJHi1s77V47n8Y6fJdeiZiRR4HQhygK3lzmInI/U0RsznlCDIa3yCW8U8dDg95ROO4xunmURBCV2F4Cyt/+oBYs3OkF5zVCt6riM5m/JorvugAyXumOME5k5nj5lk+gODfFnc9bCf+z7kgXjwqB9Nj5RWVSTTudKf17oK87Pzbp/PPCaqLO9qS0WO6bzfgm40UD/tVWKduRZlDzoSG4URA9C82GP4nNqfVAynq7KF1nDE3jQt2cOKEzrcOY+afuiFs9iFOH6xvcPtbiVe2Pbi3mYyEBxDBhZA4uFnWttOqT+hvGxfql8/T1WT2gPRX1FNR48/jWr9LeXD8pPHFpGser6CSLPNmCeuFf1Y4tIDSmPzHIkR8N0QIG5GfshpflGheUEi8xrq11qlFlSKuje4i3QTzSpOKFwrZ5HUGzCuJzcvZYAFEsrno1QRYvd7YgHoczxfnlHU+atXMBk5NXUs4wNRoaUtFCq+niBUtJdBM2skDQOTOUTkp0nhT24zlxYbV/2AbFbC8PkFtvJp0ECF4ymy7KOcyA1S47C37zPRRxLUtodPUZmcsqz9bplFUs/DBm198skObI/MidWesDTYDUqQaEFoQhht6vQ/M0uag9j5+J1BaaCtXkDfvlVGi0POoEkQCWNvKYZsZOKGoDldr1AdqOeOPwH8dCl6EIcmEzFAcajybWMA19aAPnE8ddeKsbxlBxZwfpsIXCUBVMLqHq/Z3GP5IKanyKlLeMbiYpSgh7OocYyfNVYky1qUOX+/H3OLpwdPv9Trz03GriBo1WfDWKJ3F+bt7010846X1/PMZsV0Ww96+xCs3YlygR18pXeGNcTQYMqdzLJoHyoRoe7bbN2xcDEuIn+m6uQZWsMapQFI7o+Wi2v69In791X3EBiPunsATr1qDSZhYiUnw5ioWzsq7zqN5sZMgNMSqoNGqxUX4uAkk0eI4ey083qY2TiCp1HqgTxPNYH+jFy0rWPA/cHCZcMQsnxuEvJG6Ef792WHUgAAADAQAAB4GKO2estxWXrdhauEHUcw+AhkwX7H+lrxK7iM7Mm5R85pWc9+AUXVtrWKa1Kf2A9IcWrAXBIpA73aUoul80B4KalLDD4CiWvwPrBkulhgpfxaS7M24jTbAtfEwQAEonHRzsiMf5glUU5haLq4s0e7yLNawjui0WKOl/SM3MpKu2zHpo7GfPjGle00tnp7oG2qEN+Df1Pc1C7x/I16t2s8PeVXQSej2cu7oXCeraySeuDqR1bYRV4ISWBHxNVFA2ajkhg07K5V+nkc4ANp3bWmMNvfi7Ki1FW19zve5AuQsUeQk4idKsnAKyGY2UHKPBlah80TSjsSNdKe9hMCgVmpXS1usrKPW2DBdi7xm4sO1wJeFQHx//w4merZ24NDyN49l60EIlLJ6Lkp1aqjBDT3AHg3Spd2z/wY0YZDSU3XGtMUETVotjLQlS4gGih2x5xAy/OESgmJ3DV0E+bZaHVimk2ZYNHwhGVl15ilkslAQBhIuFkrDDjeot0oYX5eHz65xPRi3DegAAAC5hROlI1kwVozEnxhey/oBrIqGBp+qKQxatyS4XDyzChg8fcpy31d2/FpEFduLnpaWiDaH6XYhZSiSbbvHgd6L8O6QAGwEaCiaBJwhX98n9OgO9awazmVZDtJejPeKDzawYiiXv29tY9CpuIteAwcDRngB6dcyPVmRO5uq3nNcvm/mvnHvncOtiEAqLkRMUyD/yQZzsPzXhlQ/j6qqqA2pFRb1jo+UFwie+NOYMZIAT9N5E2JIHgvX4rVIcL6pTWHyW6rz5Ze9H7Rrcw3rKfar2iPj0HCP19750abH1FilfriNxCqxWPpX4H2xeNWR4JkpLcnRljj7h8aAkvVECHr/Vq+0j4a3MjCpp9xTjHEz4cnp/CcbDl5IOUYViCL/Dmt5PxcJCjJBbLzbqtbUozPYnRxVDucTJfcdm5rIRo3dTGdxNr+NHtb91q9teO84aM1qtEbp0/s9aaubhI/ZNTP995Cu2VoapmCnj+/NQDUsqzAzM1I5aPA6bYEgln7hOVEl8jKHYL/IQZfi8EiVRdWdY7ibYobiM4xJIJ1XSQ/zm2aRBrdFSpwnQ8HQjji2bRbLK289NKUXU99mTLFPIiaGGr8hD6Y7OysRDFyNj8MNBby6cVHNBP3OwBlgzmD8dDjfrp3CKrUrbkdIrQqUJ1j8Me6yB1SaF7tczO7uCfS1YgolSygOefi1hlTIC374Kfo+Mh7oeaAeGO0xD+eOAV5LbPxMoJsQB/osBfbwEycMfO5e0F5pRoq5l7b2EwZxfYoHAjTHwfWO1hgxpI6qcHVzLTgJ1RGPahcZiqN9xfksZ2a1N+crfpA5tSRUkuLirsFZlN3ZlL1JE9wUSLSfJO2zxJiziYdt+eGULrDeUqDwg+F7MnacafXOn21UHdAohAl+25NXOYaqeUalvS3Q7+QBH51PJoV75v8DZP8MPVvUhg2ITYSACaZttLkDdfUTez97Lj1g9RlXTiT7yLXrfuc7BWejCrWMiVoWtUDwPxiO0D1DDIzSqB0/zdjflbNXtx17yMVP1f3F1v/D2qzshqZANZzKLegVXJlYKSDO1mKpudZWvEOsisXxUkdep0o7esg0LtCgXGRyzcnw1ceZH3iUcNcC0C0qJ7RT0R0OZ3TKkyfO7r0gtRwOPRGYvUMS0+ur7PA8ofjrKlp5r46oExuYoXaKuFl8ciJo5OLomPXcEJ8VVcgTXH9CrogNNmwqrvSKGh0e3TgzLdW2nv9okBJUj7/KYx2oZvF0KCThvnEFmLZ23oCqw1uGnBuNJ7EqWrwZUFH4MI04Ah1D0hL22NbwgUig8QAxn+jBxyjW9teOb7SlrSxB5vMDkmyn4zgBDyXa1MHG9r1sPEKIcMN0cbrz+9Q9TDetKNENOLRU2udAchC/AcavxP4ZfecpBCBKzOHdkAWCye7UoSqu5irYJY2Vv2qho/VqopRgzX9yqe2e/0khN33P7JXguUg+bap4rrfmPk4Hx472vWMtJ7X3ouciaA5v4XlHOrV3qPPXzxjRlNbqq1JuGDfhSdXg1gVYh6Jf5BYtVDCjE11Rgzpnn0q/agHbk1RlixfacK0Q+kIm532JlhII+0HN15X8wba8XExbURhd7T4BJVmS+8rVMFtKOpzYSNacM3IPTgLROAnq29wEa+HStOm58+0kNXqYwAvyGfmpxmOPWibv6WzTDkONlNNSjeUs/6X1+C5GkwMO5vo7weR8zm8sGGcW3pbhPy+lSS5sTw0K5/zEp2FznxERMgsxvlimFuxDYK0qc06L+CRn2XDEjplNGJvR1Qij8TfH7MYzd8/kVuUBljMA3bU+0cagQSNjt5CB5VsRxMFnOVTe1g75H16t9FOJ91x2YfFTtRULT3GcWjy+9jnAiP2+GLgqOXRji3h5Dbs/MSEAQShGXEWjf/yQ+nJP54J0NgwKvTNnIZN54I6QBpseRFcThOwPhmLUktP6kqImsrGd075iRLrG2gwe5+IsjrhjnHNJ17INWzC2QV4I77/2wpofxUmNum/hhIYTyI570w2RkBbiyEHMjgfRMSAxxT4Q+sw8xQZDPXqDzTunD7nt7GOYSvHcMUxUYrPhRau7wk8pE71O3RR5XLlM3ilmdGVAjbOvRH8I0Y6YfB9wxPWEoWrVvLQHnHckjLdCqDjyj2JwwcAIfTrHpDQAQ9g9BQiic74I/SA2SU2cS3WEqw66oWdP6lSdfExLS1nAYz6KG9W/lgcBvoCoeLdFIZqSjpAmPReY+Dbz56iO1TYht3hrQh/YbcUe9JSIx/HP370JdPem4dr2OzdL4xcqoTEdNqfaMHK8PXXW4ekxI0GOzr6m6FvpjYxkswfBPUncwnMzNa4C8OdXmqWfQhTc5ZUAPGLmsJorO9b5iE8zgdAOmPV/UeDpmbj5UuP5diKQ6b11Hwynh9ktbCDJQ7LjvWx/T98EkEVlWnN3oZb1bKSNLjKhDCy7tB+BPAfpfL5aqrM3Mv8YCXqcKmX2gbyLtqVkiH4DiR8+3PCqbM0Pf1UDOhu0HgjT4njZ9hpxaj5h7fQxcqQV9WhWAr/xzSU0WkX8jK/FbhflJgMeRGN6RptIibJ7anMCwArDy7AjTnHmL+dYiBpcWMSb+/gUaNsx4N+3iqUY18IFUeipXwrq8LMdZUvZuwtYtLrFzvaJi68yHFC+VXsAP8xoyps1Yt2bpb9zdWvQsw0fNP18RfRewDNcViuaFHzlP62dMxMeMC00yCjTAARcVe0XKm8F6vEIFQpTKk3Kar0hUxgLe/xbyfGhi8oavFABfLq9kOFPwUN26wc1A/ixeeTXdFeRFI41rfk8Phmb9m6dhGvZk3qnBtM9/W6LfUDGpuiXeZFrmw09liOgDusg40ESYUi+BdT0FtvFMSbuOEphnqfpd2pBY6IAvGe4UMhxDe305tQ55P1nThl6RkNqQUEL/pkQzrs28N4UOBmQzkqPZigdFMlVdY4GAB6sO8h7jTqZiwU4Uv3FXxB/bapvpH5TDCCYxszYJlUcquyhG8jma57/L/GM78qRH99tH4O+xRIyDYv+VAiZi/FICH5HteR2rTfvEV177hnR9hIh89v4G/yBPPIT1u/UjCpN9voepU5XauFMvev9BjSxKrhMrS4qkN9cDx5pf9ONsunT2+TzNRdkVUCQXiR8jwiBd3PvPppAn2MQH9CAxfdxGp6Kl25Kr0q7Ee/iTbM7BpoRCoNbZ1l9lcHU1jfKI34w9X9oxDce5Xg5kyHV7nHMSlUq7L94VZqhczTDSr/d7FeoIVHJfh1K/Yxkx9AvYJch3plGsQnxAOAC5/Nwfy8kFvm3ow8OQWyRVJWCSECjg7Va1FIlma4Y8AX6DYe1m7Nlyvjk0jCf5gDTonjjiG9ScTXa44zZrYVOvLhBRX16H6jx9onBXrMMKwwII4cSZKry9QFBa+slnCSfqEXKa5RINjlPUt/YPBAe+wdzk1dvGvHhmHM2OTN6shNTPNDNviilqRiOd2MzBH4l80ZVTVwQp3dt/3MKEgBAXbGHJuLNsgKJohMKIt7O1VbHtHlSq5vxfoHryCqlt62vf30gj10biMG1zDamcCClW74OmyGdHUcVy9EyO4BbE0NCxkAN+juALAI1LlmFdA77UzlVOE7Ev7s+Tik+GNNwNACR6zz/LpcZ+AphECG7QxGn0ecS/QR5ClzfGinwUBi96MHl9/ZbMz3yxRi7WRHNB1/3y5MbICquhNdYuvqOLDr9Ijxz7T1YO0e1jjwPGyUtc1yMwMWgym+MKYbirOuJ+Un0y8AsJJsSkbilX+AP4LiiRvLG5RTiY4IdDGD+eunGesHmP7Th3/hscRBZJSHOGZl7Mf/1HpY/u4g1K2bM2lqWXqGMgJj0L1vlXQGnAJLXQU42CRT/YNdP05HJbZTkjqEPh+n5VWfKS2Ftqu/vrq8pZH/ZtihvSIIdEjEM/MRIQ06Lnr8CgvE8S8jwPNl3LlvZPbeWYH+azcPBjJk8Jn6Y+biSSro8Xt2V0HGAKUQvDnwUSjn9XCs6x3GLiUElUq/8mf7aGsKyO1WE8ZyvthlPj0nOTSoa+zN5OfKHaXE4CB0/usjKT+Fiv1JJWdN/V9nt8MJuUsMgMZ0DGLzi5pJIExTYpu1+u/lTQQI0xlrOkoIG1WIquvEi2ThcAuYAHgxzGXuCNVqmUabtM3mJ2O6cJLeOtxSKC0TEBiiDsMUQLuH8PnTPfW66ioonKyxIUhpk87SI7c3/iIYTOhpyTBsByEN9N/F0owLuuzXFCNMmN8j6XP9gW7aI4iSPnxKjVznFgTNPx8VVJRCCxxvexp+RvHC7ADhTEgaB7OKuOQ1VQ453E2Ad8hZ6mxthSrZNhgLMlt2cnSQNqfmtsvJsO36Z+wVi2VVaBaWBRRKygqk69se+++SOzi5654MkW94ENcXEevhVRNer85R3eVk35B0yz2lwBX0nGxY0DX9qFW7HfUFEWkjvFrlsmw7iBrI/ezuw0aoTtLscH5Wq2+gNi74CQOQMEye/QUUGL04W8SH/BW2TqTjk4mpSU4sZYQwM1qQs9WLuv6ON/BTj3fxIGFBh55DFf7k6Y9Fp9KrqjklHT04LzIb5YcYY1ajohJ0MdcRRZDNLDVrBFg6ElAZTV70ZPX2PyMMMMFkUm1r+8XNZwDS7+dtSVsCCwl0k6J1OvjcOtx2zTe9j4wxA1xcqmmgfQZ4ZmkKM9n+7mn+U4ByW9mRMwpKE71qNekEYBfTe1yuNQTUB1BDEGjU2cyR9t9xKZaYHa43j1P2LWkr+1Iyey6huFp2O5GBmclP7TjPe4spVtSSFi1n39mz9zxxYrFoj4ql7XIklDaLmPjwZhx8uHv6RVor4BEpD2+FPzDo8Zq52nc0jAHOB2VVpcotYbkwFN2khNplFvRg1gfoh/jOOEUOuyTxeuJTqiaawr8tX/aB4gx0ou1VMqGFCSoejladQTq1jIU5kJJ9aUVKGlMAim7N5/xUDNqcouk63ZxmFkTRuIpR7U7GEpZEzYRi52pHAAAAAA==');
