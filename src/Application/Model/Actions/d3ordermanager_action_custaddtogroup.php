<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B30D126E98AAQAAAAXAAAABHAAAACABAAAAAAAAAD/FoRI810Uvk/kc0VeUYKJp98jmkrcmqhYigFtQEqqkIWG+M/CFoVnelxhB7KuyKu/v0ujc/iBE1xp4gUxGBK1PmkWB+xcoV9Qm4pHKg4nmfnzhqoXHBNPDcvMAh9rLnGwIqh6ntlNlS/Y2FgtJfXFcggAAACgEwAAUdvenXJvMWTRcvBbtjhf3xC6yqYfWGI0WWd+HPnqIXk8kfjmkbWbZ9K4Di1a/5BZmsHjJ4msRoLs4ra0wZuUYLJFPwig5qd04xKxrq3d79v3zUGt1tpf+6NmZ1srytL7kkfMmAFE7Frwtae5VKA+cRX8TIgNLVhjTIbXEH8Tl/eEnUOhlgXgv0OEIvlY+gpZeGreNqmsl3nP/fS6TUb7+8SDXexQopORKx2h09nM/GkIJHDv+iPyl2XLHD/5VBtSRlY3dOecurtZLyimOZUjmuF2EUv7MzZhPwBG4fCXmXpWNKiLj9qBOSCxR9N4m9j0Bedjpx5o9C6oB1qJ0cqdXPT1bZjFNtFYBTGJEBOZg0AMaG5wVRonfik95YO73LjuWnWMAUY5Urh05xoDQqGfLt+nC0oyB9TXPFTF9q6s8/xnNJ/cV0zl0VvUdwCfrQAk6YLxxwQh21bIAGn8WIsMVoheCgtlnv/RI1Yi975deKAqobo0sPUTgZl1n0iJJkA3Dt3uJa0a1Gja1LfpU+0FH6bCmpiCpY+Bcvy4y/hxENN+2BkP07HuTcSWwast3d41yUiV1ufZpgN1NRSOBEoDIPQYF5TUwVLdo0KnjXpptxNZT0Mefu9zsvHsmtYNQvgdYYqe1CaQcAd3+ho1L50NZAF0Kko6RsGnhkXh2jDUA2FAhf6I0/bTT1Kw3BnEwEyuMa9nKrcyZ5S8ND1IlWiFVdTwXtim0MA5WwoprPGxD+YMzAYYRAISrAgMm4TZZIsaDMcNi6mdJA+PLocSvuiMRYjEx5E/qDX/uJuc8A7b6YqmnH0R5ToJw3cXQEwuQ5dY+Lca36/Hcmw2Ml6VaRp0yY4UQVuuYTH4nSHAu+PvnnDiym+NGrOhdGU2489x7ZdXW7BmYdheGTE8+A5KrCw+iDP9N9nxBtcYagRb4SDxuiiPnabyKQI58CSIK/DfcHA4WDI37Lr5YvSlPQZbmpeKJXqotpxtP7YgHY3a1SUHY5kT2AwIUDcOhc/VOMHVdxpYaCghurK64f6GzcyGd9Dk71F0gzA1cdEGJSR9E5Ylrm3nhBL+/leBp5YrLA2z88GTyLB8CYTWofxwnEndo++Leu5iE6V5caQKNUPjpa/5Gq2uQQFBVjv6A977/CWsFoHILPjKLaF9ZtXN0gwLlYv67gIE0/doF01C6pWdGdOOjdr0v1MNgQsb9tAQnu9bzRsEuIrrP1Nkdu/NhkqKxTSvB4boD+ixtPOizMhz08HuVcunSgegjVHoC7nzL6L+OKBJT6+3utYG3dq2kTp4LjnUcS5Ml7MTEoXekGXF1p3aoFRE8JFGo+DyUtZUApDMnx/skfVRwCSocAXWOEUQ1VjUUmD993BRJ0GgjHJPwoWqQpZHHPea1GtSb4BgWeGf5Ffxhhy3rVCUlxCBz/vUnOtH3zuNxZGoEBcNBT42d2dGW+PjjNADpqSiFdd6bUHVK4YCHXk2Q40PJm12BEjMyMI7OQOB/KoAP5X4joCF4cViheZ3SUJZILYcqHZy40r21RD/63+YiWq7jG4w9Gu6PkiQ3Zh9pRBvWYM5bUP3wVmfLItkr0BPuzy87PZr/ULSWVKkDAFsfLNalw7ABMXyns14Gww1s+ltLVdojyVWk8wADPOc6yCX2kRqRwcVKGVvnqqA3mr4SE4uZcOI1OtZHSwCHBft++1vlbO4DEkIVccU3aNnDem0+n6uXkLkZQlVGweR7csW2oxQQCkXhdk1v2GEyTGKHydYYhaZh8qwBGRIFi27ei/rlQFJ+6ElM5Wf6sxHrJc2fF/bRkDDpioM2PaIAC7fD++GdZVzbp8IOqZQ+IICsRZnmji5X33+oVryTQQhsUbwaBVnAkMToE6APAMs3BqwSv/BOJ9WShULn16IaCiVRMNEPOo+rqVW5QIRIWrmh2zQ53wvXdICQq2GssAbks/mekwFiyHUdLCcuRCv4wHBVH4QK8oRjpGkEI6D1msvj7zg4wdIZHbVSQT87eBeCRnUg/9QCkX/kb3y7cPQebvOwnH4l9emdvVD2atQwrI9u5BPiGUuNUm3efv6NIYSngWKa+T1HtfZYjTBLIkIrfxBWHiuXDVywaOzfi41eO30Fk35vVkY9e+icSxpeXoa5JcgloIMt33DBpLtoYW+MLVIjdVVFeOo2D6ukC5AH+nYk8ifLGOlnx6vTiJZOdPK+dM369Fcz8SFFiMPZPf9+XCzFMLPXqqG/BIuAAFVA135tkIKDObdW2wrymyFQnEFjI+w1U+VPg6Ag4Bs65dgRBsF7Is4XpROL/8efb8aShxFoyBZhcmxX3JVcsiLggmBnT7Fr88gBnlamOgfdVLvHwfZpqQgAs/CDXNd4vulybSKIOUerl8zmOh3enPgAyh5DQFQJmGAbbPjpuKaADgrawrqYx9zbREF2hrZSNn7B55cg3lo3rDUGBrjoNUqCBPau8c1y7NeCxoW24YlL0oqqSWS36rjOU4dzGn4Diz9rLCtscu0pAOnrVyolpvhDFmq2kOyvzCEvtHJImDrTOXe/FU6GMhZCunmUAaXc0HoCY9mcywgSS7mDTuPm1/8g6CtPWZuEPQDyeLmAgXLYSDLnhJpUBixOoYmNchZyL1hYt7Zf4czZKduHMwYSB59sy/MnIiFULmxuA4/UQ4OhIsROoMBWIx990wgys49cVuK3vvOT4HXsnIGekIaL3FdPE6IMGddWTrYS2z66Fu4t3Kj8+fW8NUAU/GvSxqgEqAJkGS4j7X6/uGeeet33UZscx1aqyZYelbITFnZIeVIszGMmixE73l7I1Erc8VLKGiCuNRR1dJr0nFpHKOuU7+XtZSPAoDYZPkA7AyI2BYNZ4HdmPEf0nnRc8TG8/pQZpvwn+Ih3RKdByP1/4J3lClRNhiXQORFPkXFxvw9TboZKoxqF0CXMVYG03BS+7VswbjBI4XyRYR7vObLLuRWfxpXyp7jQr8HA++tHFlbVEAc9SC/BNhOLjcIW6BsbV9zW97Gi1R2FwsVjnif6iyqQmILsl5nfrdCmchBM7DTwSvfjDs8lHZDEzPwl3I08V5hlLVB976ZHTFCtdfUly23FkJB0V5z75m2sPG/22MX3oxoSrJFBbobSYs5ytd/P9PDPTgGEDvM+4vDulE0TEuu4Nukx4WJotr6woD/RJ5vn7DCfKm6ZgPi/fZwOLLxUl0rsDnGbNodNi0GSUr2Bb1g614QrJCzDOetUavbzqpp4mbrodhWJf7yuTo5Y5WKXevFPB4k/21IGOYj1nU3DPMTORJRYFMkiCocQUtt1zOufjV438vITfl36YtLTMgjswhylS6eT6XZrPHArPyDqxwssbvlohULL1pXbOawb59oxZSec5ygZfP3RObMs3crjrcc6QM6U1bJskf4Zve6BEXio0jkRwtFBw7FpqHhDfUpKvmeTuieIQ05esws36JRY1DuErT0KPdwLlA/7/I+bRevLkl7GGpHmFVH1/fkLtLytPH61zuKLmatEDWWTAPoK1J6Y5J/6jAK177y3fcBEKMdfUsX6p44IL3USXgOGvhiZg2T1kPFS4dhbS+/Kjn7GxM9F0o9HaRxtlx/yqCeJJyDxF7rZpiryUHNF3wgB3awX0xmiElNr6mQcn8LYmNh8GURglMtS2d8Ni0IbCOHCrfHtldUFuNnnj88og9J+h4Ot1P3Mm5i0lvZ1jPG7+te4WWDLgdlFUUFBW3RbAZKEsAsND0bcsD6wQrSxGQupw7iDp36Dk1IKs8bY4fLfmIxc3FdV3ZuWvAEr8fEegKz+kRPMRbIsj2oJ/soK5yvf83wOT8430VT4cHoRxGiOUO0aFtSiVIbfmRzjc1cqpzzX8aiFnOiq0YeAW9Yy/GA3Gl+WoaPxjoA0oIkK0FaI6bG/GsJ9qDFlnCJGMgvJZNu95QiWpm1Ol0w/os7AkDkKbejKHWlHnG4EXOZRTqurucBSVoBhgHZM86vgCDaSQxcXDADCJdxElH4iQstwpYLECyELipMKEfEdGb4gMUwDNA+eH3TeToCDCVVLpQdHrZqScNXIkqGAfUWNHwIfEsQmARUXVyVLHGLxeLeF7FKWrSNswZFeU3PkWaQPAe4seLE9AlOpM1dKCacwgOc001eWyAGmgYlpVixczGCsJnVG1Cjv6OL/lyJWgXIk4GhZajyLiYeR0/ywjkJrYyuzp/3txRX3POcylK60AGLpga/PhoMQ0gCRGzrNGcevamItlH2GZqVpdiqBaMhSiDFzjYwjxdDQWpWJe8YhMWhanTmAmvta4vf433L3/fwaIbgE4AqLGCTGQqdlrTEmnqNeEquUAvXkbkvLDHljvvNafKlNSmgtQyC0x02d/yaNWbXp3xuJf2o8fxUiVyvCkXfvO1hem24fJcoW9883GdXxkQUYcixx2dLkSK9/gyDhqjOsMMs5qFr491PF2eMVI9N7Q3PAvCldZAPHSOko1b2NYUZbh73LGMQZBllmYL7R58xHjUsNCCV3hKtU8cysxRdGaXAJQLFi8R7+nBOFGvvJeupYyMVTS5fjq6en9Zwu5acQ0W34pyY1RIopWGqm8eF0ukGLiBvrQy4x7ivhyprnZpoHl2DwCReGIYaplHgzmv3xoAcK47Y6fwGHncmZKZfaUXYs3qqhqgbFPck/1eXwpm/OgX++HHMLjRfQm2hgrrxZzgBuHu293kgb7ddja1eT13Qg2rS1a0C2FJZor2oDJqmH1A9l755vUqbaBmi0K2dl7HXk9hIfzILrhr4OU5yvdAoIzZJhy3dh09ieGfGjUth6wuY6jJNjFZPXW68UnQ02Pi/X83CF1G386iT2l+d2BOWbuKiviiNwINVxt//D2jueMDTrZ3iTxb5dq67MBy6RwbHSZPnnJ7jbhCtzuxKRHJvsnEkc98tBA7HE0Z4V4vABuGgtPJIQMddUogJupFj9JTGXmFi+8AX9Qf9h+fgFcU2jKXVVnQIHDlmthdPkcvToNukV0ct8T9V0596CUptAo0ml3jI74JwVPVzDKro4K3+RpQ3voSQ6IwRn/eiL0ts4kFYrj7xOLxNnFu+OiFKlYl2uyTz6i0n1tZ/TM+GNATw/yr4fow1Cck5B3CiklRGxYiqC5vb1jHcOs1SbVRtoKFIInS2vCQc0gklg6VQ+4F6aaQ2Gujg9/B5ZJ0D6v1yrDy1YWlwo9WlcZdvx5LVH8N2JYnNR25qKB02YMqY15qshYc0KrJjbl0XYLdDlLHr0bsHCpfI+/d5mqXbKWvf+4gNdrCNXKlLxS4GUxTzaUftvstjsyqtCPRbISa0Q23w1ihicTPt+h1g1/H9ry03p3BRYtm4++AJC8MTmgB/8bL2CfCqwX0UOmWCl8Zlg6v6mTwGXJ6XPNnx3AukSz+OFNBRuXFy9Z2tELp3N6TtrCFWgYQz0+0YcTD6VeVnSDvEEZbUQK9W9znw9v+Aaibfy3+uTmW65vU0kzgCDBYiLb95YXHTlUrtm5++MTXGC541DbwLl1OawFKX5S1Mvh1aHN93h2EpvLCWMFKU0VHh5f9nLo1aaxzj0SzE13OQ/6H2a57z0j9fXRNrBkPUtx+WbejM+bfZOKZhivrhBVyo+MWyFHJ/pFSXh4vEsZodM5S8eyhe+5dwVp61kxxHIn4sfK3Je5AgzqjNVSEBt5DCXPjhJv9onHAHthtNO0yMtE1WcltJlo6glckqe0qDrv6YNiwqqZ+/27t8sMQAYUr6wY33HJsxYL69/zsRHuJIJNwBaJu6qTcfpHCvKIVEZnBPgOlvC/CqY3D6DWmGhyilyk20RjgT2Sil2v7aa3ailA9usI3IfxGx4q+eJwEFXmO42e+4VA2uuO7MguBJ9HetMdKD8yo4lQybwYIc0Krv/Z3KAlqnkC71iucinoP6js+r1y1tQEkvQpfp2GFmGmAWbKdSMf7Ron/gYR8l/4D6iepMP5vchuL4SBhCLrOOAm7VrV0GIEBzdfNJPfx2Atq0EZNyjXrRkn7AWQq8lcUyMbLxu524oIS59Uhtb+/7wJmMb9ct8HuVxWubWY8/AC4ncy9zZr30WJNNrDxwKeWRZtGhCv5PT+BwsZBKl8oHvf7tRAY2B4yyDSEQfhJqNKQ8eQ0vWFCZUpKxLVm9S8HLq0wObuon6ejSi0YGDVM+YNleAWh73h+8PcnqrlHkS98fiieuDQo0mUi9jgoVGuSb8KwDLE4S9k0HJ1pjMmRUj9vtdDSr5uJWzsL6aWBjpKQQ4jH+aFUpIzOU3V2QDrwWBs3QLIqm3hjN+m/meB8IeSo2OFRJX6Ec3zIR38bvBHHeDBU9Zs6Y42U6vx+dUHtP1uV5nelBVj/vy15Wenfij5JXbXzLkdvbw6NUsPXvPmUOzTT7G+wl9OiKArVilEm5r8a/4sBQkPRM9vRXiwSxIGA9KO7dZw3rc89feEvDlkBWbqLX7n/AMk9QI1mOPLUsQP++klF6BksGK+wUkLFqkqGNUm/an4ma0sv2cjg0t4v8G4mGE7UlwNRaf9mX2eV92RWUShIGwDcl2Z63ar+ny09wu1MJ2fRnxpznBxG3dEbyVuGUfv9xf8h3P7Ed5Hoenugtral7aggcr/HPyFJ180Llb+OIBVY0Zj+CxvloHzCnpDJiQIPtPPwQ7JNAqfKrDNbK3hzxjB/4s7U4xPdN+aPVC8o07j8smBu0LOI9sqt0w9FC+KhTHwFSccgODZ1RAAAAiBMAANWM6hl8ZmFPwX0+QNlFf5uXXyhKDgCO/o7ak+mYO15WKyA0PwlTQBSRR+Ro88SURU6N6tvvBK4CdHMceMO5ENU9IJbeiTTZRzSS93icanJaGAhuVukwoa84+zRvPUeQg0ZgeZU6cpQrobUJqyokIdc+z+7MHp2+c2NlReMawXojU3XifHk8PeKCZRda0nAshg9QeZBIVjs1RmuF4uLtBCosDKeTX3d7G38XDoaXI3HyMWAHXjZ2YeLbt8Bmrqw40bzjdo1OELojXMmYNTVoGcfsqH5D5+BS4gANlAVPED0lvBiTcNg9qcXs1EL19cFtQQYoHIahdvWKOCfj0bblvtBlkAHt+x9o2XRvpCrHda9pncXR5AH79gI6qXipsPzRvI5cccDLonRxaqydsFn5UnrQJ5YdjtCzW/Vm+gkDsBTgw2cZYC37s4QOQJ6Yo3+BxF9Zo8XXmBhBUPPJEdUwcJnvIhtYOi4ds9ko0SdlOCO8tJ+/QTAmFsbc34sOYvr26aT0QKAJef53eZp1qJeUWJazJdYPYKcn0totCRIe17WV30Xur3LMrYDz2h6v9oUrly2jNZQ0/2cuHnNCCxnnqub/VTaaMnG2Zz4SgH18yJrRu1zYTqxhppHkWNp8AMoLcTW8PmneDymPmOlEmFeFAvQq6vChwEThX1sWZ6S5WDg+vcrFBbZbOl8su4filrySNwb+3DEQKT9wOtHQwaf4VjgN0eQdjGyLYpfepdKmb9tAXEb58pDjV0/lAD/dM3tPsUTNoKeSmeJW3HHWrDMWeDougWD2vb1U9ZkZwTgHcyiDnnC6cSqjgkrZ8SCHdTdFXS2IjdAllDoClWkWrs3YkuVJhqxC+Lr7i1hIR6BY1p8Fb/S2dcDQl0MRhKG6sZoquxv6BQ4XdupLlTJ5r4ZTAFFS8tN70yDG07unM9r3QqqX/YNLdkLGFBtSWe8wMFYYulIR/eTmHps3/M+zfnsM6N8CI7myUHvMwA1PBQYKVU6w2Knuz+FyEh4sDWObAEtYhTR886EtdLnK80zgMuBHu8Asd7ntNOQVXSv9KgAuHGRr7juWV5fctXGmRsG1HAPiPkmkHLCELL5fb1miZe9wHCTVwFasHMqup3mXkbTplsyAtmJfMVPvyRenbzCecfAYstIuGPJ11zRUAdY7dx2lqHfjyFoW4JQlnN8iFOuJ+Wv8e80AfeF3qvHRx1mGEfYl5PQZ5PBEGgM+qC4IVNTYPcRyK9tlc/uhEHx/kWMmTCfxlRgKAjWhDZHXRMi1nVPhWWTkiWVlN4YW9hIvWQbue+Zbi2gUbemm10ub/VUELu+p40HpsC6BhOCFIMHr58bvi9O00ZYAZ8SR2zizIFXsTzwgqp0VGvnffm+oYnbE3DkOTneUbd8iYKZIyVira+LHVPCpAdiCGmxnj4IksdpZLvUtFuRliKGFZoX8mrOrjXSN46sRxj3MVy/cPh0JM8fRGyOO7wIIGFzPZDEePvCxaCvRaclkrToufAM1OYcbnJDMMT0DfjkGPxR1dqY5D3mcqveGc/vBp/7IXVau5yDVutIiTYKp+ZEQQ3hYa8hHR4DXq+d+hXIfoJHIkW+eHGdTjPh09zGyXeHOA6uhReDUK7vJcyr0X2r0dkLIxxBWC7wmLSEyang3xa4a1BEYxJiF/YuVVP3svFlk2zcT03/FvDAkY0ErK7e4/1ejKT9FoMEjzHGLyGlQKwNz+o4WF6wEjVU2YW5b1HyoA5HiZU8DMcS5I6N31nXczeKh6WvLRLoCySBxxe1oaw0PAkhLP5b9/TPVUmnTEEsWa98jkHlr9oRHQyuJ1/oZ59bG8synf8JFice4DgVTCN2miXKGOH5PN5258COztIX+9pyN8Gl5F1ZdxA65QLmgsmxGs5F8t8qkOv+TpXPiaWztY4rG6lc6Kg3aMosgu/g+F5CcLlC7nCCVnxf7uOxFqwhNYHtsi/RE6d7ljyJPl37F1MqtU3NzE0HtWoUtG5BVKTBfwdQO4L0WSvbSdqYG7N6mqqu2zUDeMxB3ACWuNYy4WFOxcZgdSX48fNI9IjPPgTAXo3RjurAYvpfNzrBrWhpBJc1/Aw9PPaLBs3eZK3QhdstYO6MjDFXJ8fY1IBuBJJ9kPpyKxnPiWOrKop34GzXOGwt+5qRtlCGdeaB3MjUcmYsTJlxqweyrZ74jCWT1PxYB6DYXyEVcMAS/RauQpkmnJmIiLt+bYneSOCO+8y7meQyuV4rwMJei36YjdNOWgWs1MPGsmavvmqdhjQ/T/jiMPJfc4l3hREsTzBnOVvIDG2gzALXcvgUD/Zq+1SbnZwWWJwUwxtNaSLE3LW4hJEKDmaNzJokjjJw1t7dT+b7E73c1A0BeRwl4mTy7Mr0OQbcXdRyXAYCVhGqhXBW9Ve9/KUDHGzZrLzXllDOPl81PXsia1lSBsWmu+SDnZ1guCaK+uZGgPsbVGUSZWWzCw5dlWqRK1va7SEE4OWdfSHN0tIrgxEv3hIn73CMt5lvjxlehWot6hi0+FBPjPPZsAzmEaDK2NGW/ZNt2RF2zwQ2FE7RxvpIKM8XhKfZiCaQZqLWm10lkPD6KZEtJU83LlcSit0ygxxik8T2pSz9C2Ef3M3kS3fHTaZgNAgKQK45QVQ5QX+H/nZbkaclcM/xJcl3+rtZQCjIUjJJHpds5GycL1gWPmzedCVyMVgwpqea4pdRXMJdmjxwhR+kRA9qHgl2c0RPGFUqi4beKneW0TItsNUlGjdWy1srQgzJhNoARBwcA4DYDmJiUXwoMtiSpciz/Wr/cHAFZl+5/3IISzOuOyD2vRkgJ9pR7EyPoIzBV74HmbftQOQjxgAoyuLLSVkkz/J+hkWyT82UrfZxWEtCeZnJ8g9ywATo4E+OozjnB3+LjxYuFlFYF750W8Yd7vqvCC51Q2Y+v+6g2XXrlvkzN7QoYhWIfBQg2dgmvCB41SAS+PcPxrQLkgoqc68Om4KWTQwidzsVbJCS2AhcgiaatSseOW1ZRQhaEUM3kbCmwO2u/WmCkh0KMHgcK5LbLH5dCWVvgttmyh9pANyH869weu4XFSAqE0mR5bQm8bfiR3aELRVrBDX4fq4x3i3TGrEYNT8zGnh2lhTNnez9Ht1hyzgy/nGncUe7Xk/itDdvNuRbJhQdrjeXi+k1Tsx4rZgypVbEPDspHcxpzBx8/M3NSMQ8/FGiePm0nQcNYl/KHxES/6sMDbq7tHufV1D5n8/UsDkh4fRzhNjQhkLYg1jglt4lfbwmzpv4ALh9SxvF3ubz3Dz8hY4+qFcChoIti4NOGxLJJST/YEVVsaTUMNgWzghWcGHKQ14B8/By57lEDYlvmblv8EMs75rxQ54P5scSfQo3xdWsQ6VN0/7lZ5tkjSzWa0zkvBl+27pxG+5phHmYU1QAJrOzPyyvBH1XjxhrsiuTO8MVihoeffXezi350tFVYp/KYDL2yfvRZf/xABB+ZKcpGpiLtkA/xhwgDdNBhbAQNxGvIFHtPrBSZSY6SvZlWuUrC95FnHdTCK7bGPBxqkvP+UCdceD8hHER7jZsHFe8V7xCIp4kPxNYTGuS1gji4WhOx62yiZkPQSmA28XW1NxA5VfWiSOou1lYAGPKV7OO/egDH7lxPCl6n96kpslnd/nmhvVlJavhxo7HDuEj6SkX6naZezfsijE9BeoAzkR08QpMn+lYJDQAai4koiD4s6BVsuhT1Ddc/4ZIieCoavNDXGbzAQT98fTw2ad55b0PAKIzJDmC+IucW4q7fnCmyVQYwe9/x46bxmFvWfVckU9oX63xn6OfnH3TXrMJoj38l+aTexEnBJ5BN12UDm/+r0XD1Sv/r7Yfhh5f+OsD7V3qeF9Ik+XW4FVNPe8+YfiMgHCp8I5Uj4NjYssS+qoFaXDwpktIo2aWDymrQUE9GXNkDSG9zdOoX43F0PmG6GshwLRcvopGcVInyUMwWhr8m4zTumrRMpNAg5rsISpdko0sTZdHQ2H4IcBH28vjcYVP0aSe9JgRPdNfsDUS3M15gxk71zv394T0aTVEl+PPmXmx+VqwDZNMoF7XVxpMOiLkhcUmJfOsBdcP+QG6AUKy+ysRVTIn0xQNQghjyPp4ZC6KIsmeVlgPOxtRiWuqxqEyEvbROhHut2S84j+I+aw+FPhVQc6ZYNCsm+ff5iRzx8eKcqo07tjmeHWoQKlpjFOmG6v+nTsDNhi2LizT4ypI2P1hx6sFydJdbwguEvY8sj1+E4HU6+7NJv6Sp4jGG1Ge8SUt2KaG81c4euWzFs8aAA5+b+kCr+qtRjw9W3BpSeceUhnv02tndO7/Wq6odrIk8t9dPhontuB49A3s7r+0I2kpjpMuZmuvqdRIh+3OFi/EWvFW43kWmuZmTAXBevNx9EUC5ztViNEUxIwMceCph0VYUD+VCKs5l+y53sqzk8l4Fhtm3966VLZF9RWa0DuhOeVGgzqf5YKSdJcHdpBJwuRMV+qiwbG7fyE7+XSi8F1z/QArxzVw4LD7jcEdjJ/0ZgoSxdqSJdL2YrmGpJTw/zPaX1Me/uHydJ4OnSSwegIY5CSnLrDyQExGXHwYBMZtzHDT78WS6xnWit8jk++s6NQy6Yz3xym4U8zURtp/wPx7TIKTZUxuq8F6uQkuYpqD2XfoKbn1fGs8xbYRuqxb5TT1e1u6O0StgblAhW4LH7uk42Y/pxBMjjNqJh3bPBGsBxspH1LO9BfayEFU9xlBIJpNMWUSkreDP9GUE2w2FaIYYQR8wxlMPHTQ5zZg7mreSMaCTeAzY7EG4w5EdVH4tMsyjfU9F+5N5dGhY1IHqSu+isW90GkuD+CpC99xG91pcC4oQLeYfSqSge8VeW3Cw+BY3kipQEj4rm8M73u5uHp6i8/dcJjFrl/GLL7O9WEUJmGfIPOmefd7ml/5ZI/iz2vUeAPn9NT5a62p47NZMzfHjTlJJ7tESL3TG54HMBua5UPX2VNtTwM7DnpjvRI9p2UsLUuo0x8O/qV+uD9dizXXHakstZynDfC2ZNwIxXC3xu29oNdmSETW5UfTKaftUDKmqS2VA13/4Zgff8jGAB520L7y5a04uWh87Z78uSzfKoMh3VnhCFpUQiBpdq8dqgg7OJzDD9YdA2ex1nF3sFtd33EbXEAQYV1//FozBH4jR+sbxMbLFhW5AAFx7lopP3pKtH00vT+hRpniXZQcajENIGBXkxFqcQiBUi2Bzgo6CirILjh/IGyMigUSPmaeCTuwh/VqfYWPrnrt2QKTBLVwWfFqkmCfY5fKzdzFMSoHH1ACPWQ91tAZkE3Si0j5J9MLUllEacVMH57g0OwN3cEx5V53vv1lvOkg8Hp0dGAi2y5Zbvtv1Ylt2L8e2+yR4eJzvMjR1Vvd2yznBEdBtJ/cPPPnikyZS+t+dlaBLEDBlAbHJChHZJ2VMMugNemN+XNfEx+kAI/A8xnMreOjTSwicLV0aWRga3jIxt6i37GC9+AM29ZUQlGJ792y83S6XCDl3R/edm6jKJIqr/eidyytSx+qJQwfiUIW7lX+jKW94+s0OEdl8ecygp9HM3QCM0rcKzD/e/PWICgFEqRkWqytxD6awcmbukFYGEe7B1VTjKFTFnv7RlHLVBab172FThUyeQCwttfsso7FiqgPt8BcEEKKZ7dD7ThCiGY9v/WxewaW/p7af5ZR5hohq2Rmmuh5mqZ5zJi2PeviexF2VZMQY0ZhtkkO1PmmUXQbQJBX5CjurVC4E42DM6D9hlFkIs6DIh7NsyGies6VXEccuzoog9lks3q+0TdD8+NtJhptAC+f7JnYP/ixRGbvgwZ06FUywN/30RLUYZxzfgSV25pXKkgtdi6fh3vIgnRVisbTSRZ8ZvGvc/sVACAgBBScqs4MBMzr2H4CwvX+2mKpPjySQ2FPTSruvsLO2/uyU70ihZ/oMjuQkjo0Kq68KikGHW3oBozCjr7Jp3nwuOM1WusYDdi6IbSTlHT4RLBCnboRVDXl+WNjvsCTBGjV3YtdmyF9/pm5qHGqt4azK8vVIZDJVHhYsjgFF0VEQD8xU47fM6rI/h5Guu0q02C/3yRFcxTTwWCof8NaSwIeN28MGlkJfPEJVhF7g/nZ9+NpCkG4ASEXlvtJDIPnrWW7j0UuMZV1xJuObfNK4nYSoEVVoHbtaK3omrB+wyUgCjsCFNC+H4hCA2jeZtMnSGnw4ExASeuey/OZ1dGbvtptBWxM+rGNT8KvYzas/VWwJaTyQge9TlNFDyOUx9oAG8lQo7Q3FUCcvI5ZoYZmfRLRLhZips5g9YDYLFm6TN2pbRnDBmPgyo/pJTdo6OZKHX0cSvR4+Ctq/bnRsAMm1oKTndnmXG6p+XmqQ+DgsGTaiWbam8x0I9Pv9kiJkXxuSKM2nPnofQHOEMXfCYrYHg94mqGDlrL/S3zxZ4fkIoOT5n7GPEP1Usxy9yb3d16S//0lw68g5Dpcl91Ddkvr0F8nsCufgZ4y5Ik5FNlNw90HeZgawh9XbjGGiVyC/s6Sl++xyNFQq1EjLtwdGjNTsrUv7duzcwjZyF7YBKdXIgqxLwa3+6JpFb6ym0hBSqc41+9BC6NFuj7jRsQr3xOa5Sk4ieuTX/bD1H4vn7v8qNqT7o9yNlSYMkHxoHpyAZESgCqFsxF7YrQiUkRgerJkMnaDLAAAAAA==');
