<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3A7126E48AAQAAAAhAAAABKgAAACABAAAAAAAAAD/noY4NPe3nlI4+2FJ1ENL4S6BD8dF4QyQWSOk99zz5cuj2WAODRShryEAgIyj9maBO+ZPuu0Hdni3wDHvJq/7S/MyohJ3HSIYKFafMMAjwYQPcLLwAk3ccQ8dvukPrM99So2cXLwQumJ2xrMht0fB84NKKRT6kTBKayJs6r/b5WXQt0dUKEdfDvd9c0CfC1N6epvckfrgqPX1qaUvEiMfaHMfOP3yWGO+CAAAALgVAAAlt12TLS9fuMtPXCgTx9LUJcPcuWDRp5TzFP4Gd0KUWiak7TByZFGsL6ENNjpMo7P0wPHuXURgPQbGoNQuSxS9DC3TVkHMtTpByuL35qIIM0O3BrpkNGuSY3ZWRURO8x5YanWYeEHwnNMa1kin7mW2btiEeAuRGat/HhuXyqrrusiWQ0YpBxbkDx9VV80CzR6L+4h711SqQYOeqQh9f62HABgLPeYmcwEkmXTlT0q7tVTiq4n2MqJoU2crAwfU1vs6Mwbt6OxffUcFvV/G/forDAONaiEteWZntpZAAueYw8p3CSpq5b1Qbt1rEk3E9ofnY5I2UdnHUE8tupad/XqJ+WPR2mpX0bISxIuUcfLspF8homkpMLjRf7rlFE/Uhv9l7GjE4IB+yihH67V5H/lT6n8HdRWg9sAgRVHMDm8JxY+c9MI6JgnXBTqz8TZtRa8rb5ZiAydY6Yliywq1iRHyDSy3oYT4zNzq54OpKbbnQ4SHjz6/KkkV/x6jE3R76dQOhYvhVjO0MjCp0CIZWx5zHnu8+8BP/8++LPbEBrHSTCaZObez167ll3BesejZ4gqmQbeleypxJKGY86vMpLV661/LfqQCi3XK7JoTU5VVg7aRQr7cW1DCaRX9XaaHWwdXwoMeofAjkYNmQhU8E4i8nn1wmfC1Xw/Q6mCJH3nyl0mDzR4Vxabhyzl9HILZS2SlG9Ol4+/gx5gJwgW2uYXf0T8yeQj0gcZnHTCMTCFuirCsVj3M+hebmL0pJsubv4N7qfLDt1D8jJHtY/Sg2AxLCcHnaefxRBjX/NBrcBWSyoMpvGIUvoUwU8E2FZ+jrn3zsC75E1JZS7FQf0Sv+ziHdGXOljytYOsy6PZxS6TrLpS2+TMNPXgvSooC8Ammu9T9+71euVnBf3EopR9jcnbS4wCBJB/MGFvI7plGL7jgQ8tjL/DYu2i1BVpJvknvZ8SWLy2rcWadUuhlEa6PmYm4z1WbphK9lH0obevp/lWbEycbT6bsSNwBql2etwDKeZib3XaqJOnbzANQwBH22kowzMbc4BBsvh3uxHd7OhWsDSMPtx8gPAEiajVM36MFpayjyjptqPfmSbiax/9gvBgrDU/CsJLtTWh6iF4yGWSMEQ/TsaXon63jfYr3MSdMcg6snOW/hCGQQHmPOOQNNKrHp5Bk2q9WoxbvzQ9P8ppOOwIZKEHUXdXZpg5iCx6abK4ysfFb95niOnotnFtqTe43wYEUskX2LApAVTYC3YMEI2MupW0vm1D7wDSMuw/MRcZcDCsmIZKUhDeuW38IbIxRSyKNSHTf5RnTa4Ru9HHNBl7fD9rRZKgobY4WcB6IyjM+I/KC5sa8Ns4kOyh/mPw+Q2HrMY4RC+vwGGsPLzkhqVUfUQxjeWPCmlDjIkYNn/+FSj5644S4N3MezEp1lcFBj//zlbXBdayVxu46Mujs+Ye/cnArB4BYWydn4hK8cXObOPXN/PDdqef/QZ4GJ8Wamu6TMRmOwQ/Kr9kvsatXil3xg6G+CV/VyTY0HtWCWcG/+FYTYDYwmBHQF8Xln8pjj0rjE0lKlFF1mPSSzAm0oTPWLKcbVknSgBAiGiSi33mOiouOvvGvbejHi7ghm1B81Djp+165LoOl4lph7463rR992kXUUnGOFNg2D+/T+HsaTHXSbn78mrCqamf2QU4zyRKTRvZ8HY+3ciYxzD9oEH2ykKo1HwikVmrwqiBVVo1E/cAUVvNFminQqJ5zaI8U6WtJCv2d2bocO0SD3b+/l5P/zddQaI3g5TMsTTJPDnikh3zASx9AMaS/avHRDtKdCqc+QYu92qRgSVl41cZoGHUpaXqTg84Li46ugIqHGG8DF36pWXGSdYAVZgVR0TCtpO+HY7sJik4sVrqoo6J/eNaUSEpl92wVVeSp8vWWXbl+l5p1ea4vKNLRpZYgnHFEa8pREsmgV1kpFsceYTOn7stE+e/mEvmQ4VB+UFBC/dcdiye8bu2l6Izjg62BVKfRwmy9tECeaKUbnC+g/LAMfiAZBfrQ7nNtaucRQB91b3heKMFv2drQ4ZNVv3gcZjE3lgsHUcQr5YhrlEVt9pOXiyXY3evvFh77KTu19SwO1chK2WcfmjkfHhw4/ik1izS5N6CGaBUDHH7UI6OPphiIlgNsBdh8vDIcs6tM/Z3A0NeK4AVkgbfYOPGShuG9SHTX4Al3ClnsHtse58QxBhr7ZLrsnE5vkpGXTlUs8iJfVm0kN5VHWN48b7Jsci5jcVntYSUReeDegHR4h50xSItf0eySKZh/xHr0sCzqh/eebj9zniSEG9Dcm1/Tx/Yfhg/pG7Cb5jBIEUoyQGV9GL4KotQTkUciCLOv+JVHpYwQaE6hyrq975qSr56K6pcy+gSQ8GNWurYPzm29HsW1BY6cX4Tq5CW0mAgogFjI0uBkXZG68/4lMKlX+47BsgWYjVnW2vcfkpnnP1WWgq98Fa6CaIBRDC/qoXCAqXUjxKIJzzvYtAvIIzPH0YcsVc4qWyjsmZ0eDu1rnTqi81xe7rMQTlLPFf20rPc/FvQhsjDwN2tJJrNkXwqKIjEq4Vd9RUZtWla5TFYyMu9VB+hLvrIJ58lXUQCyzi4IPGCn3mnepEILlf1KvaqrdwHRIYrLV6JSCF5RezUQQxwCy2sdgKdCVQv0yH9qIkwlIj30abqOqcqCWfwqDqJac19+zOQyNCIgQyuuL7RqTi6R5a15jA5pMXqNy9UR8IerTGQK33vF+xskeJaJP+KSX7zw73hnVwvta+qKF8Hm9CZbnZlJjgOlV1lsE4/8Xr7hAms0qbB+s6jJEn7gP15QaWXZGJdrjOeRc6ESnsHolA1X+EIX7TagETFARiQoUeewRm4TCRF0dSoE5jHVthfLP3up0XEoZ/Y5zCkmgQ0aawlD++7DBFWK65Xai7Msi4K7fr6Fzrt8L3u/bUb41YELeN1E8pB1KdRLv6j5pLluLSzMhrzhVTkSCWZHQr2hoCzbJETSYfQbl5Jr0J3n/08ST/v2eKc0N3oiG7cGBdkIbz+TvS+36q1XV7LgZWTOo82SOZQ1+CIKfDL+7J2n9ZHGgIJFBGuvXV5k9CFGDtpzVUzjvsuOadOnf8AUYFyTPmU2tPG1U2cJ31Oi5tVp1/C7/m9Q5KmKJisdrk2tQ57DzbM599XAbLP3R/fVx2G4LY4XM3pmAcpCuxqrOtyN1TjzFf8f7bEhw69WwhWDg9S9NjFNY/aVd8sF++a28QS+VywrR5K8K1JUu+lmXLZhR/FSXOFrBmqg7rTK9CXKweFS+OdY6XWiqz0oNnv+/+a17M/vRg2AUAc1RVXcC/SIdwx2UFUcTFCb7+GH1aez6mOzDcECjtyLRmyJRjbVZTH6Z2lZ37YasH1n9MbrWjOmk1jAz87zqd1lv/7DrlGvLTk/ucBrjh/mlSnUcj79hRLzsOfWUi224Krp0u7pAKFSyUeJlKXVF5DvW6uys3CrDEUJZ4daCOhuObU71HQ3P5zLFTZGyNvNubM5S+ZwRju8XgJKPBW4SppT0n7N1+0CSf6msXIjxKjHP3P2l3NZ9OphQ6BBWQ+HVIdGkPVQTfhzu+YKXuM2xqUKogaPAzJCzfzkNlkRAqXWEVvxnfBOwtrBvLFKmsf/cWGexoT7LfepaLcZmJvvvwnzLuNlwZgTwMJ4aSdSCTHSYmSx6NXzhN2r3A1f+pnwT+I/ZBnUAsCkm7QHbA7jd04IrhI015FQh/dTB4W91F5E//IPFUgfhNMgmVvv0mWX3GDzS6PLNMAlE8RxAOdBcZ11WKIk/qv4kUOXyAJNYiR5uMVhS/dpKE3dTOS0qhI0xUc+4RVcHiZGf39tOYV0vmMntNAoFUykPuAKy+BaameJLM/+jvJaNi3jkbv9V31C0X1ZaciVVWO10Hjm/m/hABcbwG64u582O6sS9HzpjBlkFEVu1z6TDGP9aiKBfoGgfPmbebL6e5Q6dbjRkEfyW4GXm0G5Ot7Cvd8Aq6KovsXvl/GPq1IitFaICmDu3fZKmlB0bXsBwnq8FrlMq887emy01LonDbtVYjKPfBvcAPlzOW6UaqI+cuYrtHyTCgN3GisdnOkXzyQu7avcCZ1l4yR1TwvMCKCNvTK/spoOrkYI8h17dnJRYb9v0Fb5ekSfiSNdKRe38f+lTW1to2mNc4d4ZuHRwNUWq8z6siFC3e9zfcrvpXYfc/BblrFFJLPLm5URn62ovKAmcw0T1hgNU8V5rNSGpQWtwUPnQz8ui5ga7WZMbto5Ka9LJFp65w976NOpg2NZbrW/7BuyrjHkEDWJYnm+LlwGi4/xD0Mfjq2PsHJCaiH8+eLmcSCZPxMYhFwjhDodABJ3hEbJENg1v6JySI/4sjHL7ifBAnWWZXUAI9IK5H1DjTP2/uzj+KceNCvk5lmYdL+f+Kay0yjdmVGb9mQaEHfvYXV7BqyXIr8sVFIEBK/1vl0mezN3CaQ+JH0xK/BBAY6cE+aZBEuAlmrIj5FsraYwcHCeLjRAoTsn2xQaplKmYcK3IY2/p84HJHecibMioRxBpqvzjQIIda8jxilwgm4GD0/0rn0QfM9UjZhaw26jF5O41/vQ7MzJ5j0avc6K1WCPPgU7z3j4EAe5guFrzZcmtA3fLCC7Mpd+a/ooPClEU/4f432UUZ1Yx90uv/TAkJXeVzsMihHV3OxddSQSk8h2/WUGVoFJCf3uNBvzfwg0SeRQ4egTkc1+RdWJToluqcUYDVoBw9mKzwTkmdrMdCIPDTIJfyA7ATgtKyBnKl4kxksWWfMMZVKe3BSxNHG6zhi2+3Dsr0QDQXJoqR5q/ovKK3jNtikfiTtHsw7YPq1K8q3qBNrZA1q1bFOwtlUJtEENiGeOJdb+4lF51qnp/mricbEkELZjb5olRbXNGJrBdJ3UBTmRaOJXVZnyVOqZumiqObN1zr/xuD2ENMLw2qiPz9TBQdSUVOFDzu0jgwm5UEOWcLQUsOKePV6Q8NRg/mVL2VtIHqf8QBlraPcjLzZAc3fhACC8J7/FY615okjHiSZhzxjmywg514MzdKbq1dL6U2BOW1QHmbGUdgm5SbIuJXXjQwTfws190lINyPDlJIgo/xxs51w49S7lKzYyVY0dI55lJkgE2TG+x0CZTE6HWijfy77rGHa9ddUV2SObU+MxmpIw/Eyg979E6L/Lfb8c/F/W4CeS9uwA38J4BVgA4qOgtvoDbBHyzrnxvCs8pqshkYrtElYvb5fvKTWCnR/F93WdkW+m2ptmHNIs8Pm1XiPyg5CUA+4QCzCc7pYREXSW2k1zkNf4iBOsTSSbYhOZQVf3mpmZWFP3azY57hcRQXa3nkuTW84OA1+/i96t1OHRRSztIr/nnhDwuCRNJg5dSnpt56ClYkq3ot+x9yPsLwRGt2MoKyGfilGCtPfcwf4+3DLRNW60dKCRA9IQHN5eZaUbiBBRSwt6bpAWTkZLOTKgsZvneGYNA45lY/mwZyZ0Bs9IWthsEobC8u3uMw4Opq/JaToV3DQFQe1Hu+ZAHzryiOpY9ErBEcQGdjJX6zaiIQQmOBhaHhSitDAcTQZQMcH4Xrh7N+FDh90Q43ZIZYRwt1ArHhrb4YpVskvWXdlDb1bJYIv8is3pmZh4V8b468YiCgiKg3Hl5CjVVdK2uguH7IfT5+tZ349QgKF7L+A9YxIn0BM4vi5DalM7e+eaJBqyBsPnEFcbux2FQG3MJd5a/dJQpGcpFDOu/WqeLeZNBOXxExsdUikmEV35e10uwTJY9mgo5jUv8GMG1hNNXmpE64E+SLC1RHnCK/YN2TUmVGUiad9+LXtBMPvqInAOce/vFa38zS0OCIK6e11LxvYuD1ss30DkWXCNBUuLVY/U7R2M1lx2kw0OhFUNpIGVXGO+4i4ojqV179JFl97ZG83d+gTkinEE8Y0DfjAG+RfFT4dhlGMzatQ3QXGNOymDG8NbeZmXLAHFeqRp2YO914ZtYUUI6H+eyg7+/Fg4WtfOPPhL+HiTkGDkMKwPcg7ajiFQkszxVSELWIMhSmnDX67fcVzQlN9ame9lvv0uZ8Cco0OQ8LBiKX3rjkjZ4JnH3pgWruPpa9bW2oFFZk5kvw0Qh/0Iy+VP8xnrcpVBf2NqDgI29nmUm/RRCsLsEBCyN59oOmDGku0M6zMWV907oHzq+1PEJEmWcVtOStS811LM2whpyr9mbsfI4VUjwpJ+w8vyONBN64ZVd3auE8W3fZfIZGyGV4FN7QHtDgnUb1KIr63QR7XXg5/OmoWACVME+qC2Qze2PIIESpqTlch2XrzIksV4R9xA6iZ+1S/Q/mnKmcxXw2/iBq2xIIzpLcnXZjg66IB3Jsb+Yt/JDtpPxYw5bD50fselhNNDJdndA+A00VvpkbXKnAGVKymFc8MpX8RYS11WDhjySbk9D7LKQI+g9k8r75pzsis/QGmacAjnBM1pRcvB37ZBfqs6fOhNkA1vspjhoVQmf9qM1Uycf9ubcpkEvLZUqlMSCDVwH1FtMKrUmZGsXcbwuCOhgcVQ4WyYhDohMZ2DkzBuYLG00aYhLKKGoA4I2cHJvQ/i9bpXut6JNaTWR21YbuvmCrWo0SiqORKvMGTwoajD6xUCo7Nr+wwlq++t6YeqgYa0VRtZZTAp6v0PC+eP76CnQ5Gtl4ReF7Gfnp81/KRV1ZKEL2SXuWeqtqxshh/EODQ3ldeeAZtk5FauvZuBCS7yvZZ7rUe7UKIkciEIe1+hhIQ6hrTG/5EGf7RXwZsljOf/yu9TLN0j/3L+y9QK1NZWuhRJvis7uw7muLmWbasf5lg+xnVStycJ/pK2Tshp1KIE/dIDLX4+Rrc9IKTP4FKDeqvYYR/0XWva4gGE34P1NmgVne07ALEIGFXBYdVuFRZkEAYVu3rYXmY6SRromR9a4vtQ3dj3Ok1DM+0C3e5RpcoZ6JgonlqvceeDoz7SXU3AtzavpYxL/BcMfRq9fJkjL1vTD3PLcyGZUB8LTC4gQACbtZe1+3hRRoPlTHlUPeKs02Koz2q27OP/UK2rl1eHBo1Mb+qIJFkQt0bUgI1X/3eKsvYC8DWArsksZ44m/LWsWLqYis/OX3aKmRqHvmbNDa6GNEfxr9jYKP9q0lawcGE/LjKoJ0Axeveaba6wUlzVXGb0Qy6lZzDxLrgy1gdXUOL7sT0kXrEWt8Mbu3Zsg14WJeunbctNGkYSqhjEoAg5Gh3kpaqXYCYcv80AVeNiB7fSDt/KoxXOQn20trMArW4sevyaF6xJ0yvPN5fpJ4mDZWSu0PeIpKC41hpvq/AihFt/dRUafmm1Ys2e8QsyIlUVyZaauhfhf4NpkEh1xjjQeGsQfCttpaYWEJ9nj6rUrYMYlXPcqQLLYSb/MT1/BOjuaO6dAKOYT3a4MbB2XAR3bQcnMDLaUQAAAMgVAAB18Fk9SQwrGHW0NyzfF153C+qqfz68aikNyn/nCGy2r2V3CaK2o/l0tuWNQGinu0vdK0yCZOiB5ziMkjN5OKArvU658AjT+x6g0iLb7W2GtHwLKjG9Sv23LCEmcQ3tsxYtC4Bw6FlfwylRRsP1INzWS2EFoX7s7APGkpNZsYLb+YJizJysTiAxx8grOp0vwMW0FNT+Vn6iEoBX1xwr7MCbzmii9qtuIbaY/3pVtziS0V5aYz1XISqakL6d9SYVjt0cD55VLMCSwfwO+3AzDN1MNcxTEws6gqaOvvufMFoSdvWH/TCZnYBM4LQHP62yIuw7jm2hU/zBtp/JAviWulNE4c7CoEY/jSGKenZrKhBDCC12mOcun+bcCGHUBeOTiI8qvJOy11+NP3Dp8D+rf/HMo2CK2sC5mnRu5EMBUB+2vTHF4T3N91nWDBLCKXLX4CXAtpRXw7wvcnitMS7zEj2udMSdWd1+fQg3aWNOzveZ45Po9m2r4fhBF8DB1ZuWLbd/OzMO4YdEzee3hqVLOgOedpkF/a+6oqdtozK0fB69Nkgacpo0F5pL/btdJzEMNYgCoHs66litzDAGF41Nl+Bt3bB34GQhYN62y2prYPAQKs4APK89VB5jL88AHKAlaICTCRrXhaYx+LsDdvV9/O6T4gv6qjlgfbi5hR2PiNIS82XF3l0C2t09jzTRQF0VKnLCLPK9BP2WznMKJHFLdyy+yAnyLgY25u2Kw7fwzhEGXEbXBcp0HZgbKUqiX4kLlAy3zuPNrH6BFxwNzqmWXWQUNKgYO4Z2kc5GapEDgYribQeJMJIYAXbdhObb69E9syu9dhOh+e9QerN1t4EfRZlq52r78k5rrBVeFf8xd0lB7oGku1dKx+WewWM2xWHPzURWCM0ig7GwB9QhGodTy3QE6SP0z6mxAz44hskFY6TMxAOn3zxNmQNorSQKAZ+2Sp8zBPwCyHhJ07fPZdJBBTQnMpt7ChYtWEa4Ew9PEEcoEpPyyz2Cl00guHrtTcMS814P1O3PA6XehU/TkOlfCBsiVTSzU01WLORcTlFZHyjtcoe0cNp5Ad+DS20gTeAwSN8gEEP9c8yZ7psyGHsaBu25tMkMBs0noSPPKvMp55hY3GvJ8Kp04P7gmA+b2hIRdQoUR6yEdwSUKbCdBOAM7S1h5rxBvoAAiQxvq6qaEICoN3wMsM88gGo74+ahVUjbjrkMKgXhWtuHTNdTt7JMfUZnycxCr7MHEsjmfmQ6GFTzyrjVnPqCvIPfhUjribKD5/uVDoF+NpIAo/Rt5D3uy7pA5Na7evpcGh7cZ9h80Y9AJrgTN9uyzhSXdCEK27QV4iAH4gC7UfLHo9Rx/n+YxQiPC6KKpdX4mMeky3K385xT2ILvU89PxLmADnhGlIjux+zPYlorGhWPi5l4qwWBZlJ+QmiiOSLw/Hd5ulPO4tNtMIIEIGRAkoGKizrhaqb+G14hyfYlO6djNCGczHCi7BiGQ/tOxLx0AQw1xECPVh+ROQEJkHFpOx2cZGNF+5E20ZBzJ865j2LFMtv9XKlbbwupGyE0M5XA7eGuzVPuDv0+dzbR3W/85ESEOX7pNU1ykl5OFZo+alK21Slp3w+gi+JLEqVjiSDqYI6oww4c7D04oKFQUyZPH8jKFiSDBKHeKe3nYA6dJ0FMe6Xd+pJHSWAWOlE/Z9wf+Kmwn8CgxPtgRSgbTzidl8H0xVUXC2zeQSWg4d0xe+cWjVQ4wNjvNVOb+ZqVY01WyPl/fjiN0JguA5LkHbYj7mCuYGGnCPNeGPzFyDXGTfE6HxHxXr1Gr3R8h52Y6oEQ3/FEqOvdylBhnDGKuTxmZrgQeQ8p62lCzaqgWKqm/b8APELV7hOFwFHiMr1S+SKBuPMTkAJZSThuIudQ120KPLHzCYhWpw+VAw5HKabSUifpFMStyKVgDAcFkPa9F8/Qd1b6AOtn1lhmW3DL50wefgyQA8sj30tYNelBfpfXsDNvkFkA7heFRedOCqVrvyi5ejStwcAI9WvPSBoOA2WdnXi6ypxuw/ZyfG8KSTOlR3i5SzVQI2gGo2rFKeXu8MwdL9p0IxC8+3M67LzX/b9AaNsL/iENx4/ECk3o9YrWN48ijgEqeafBJoxRJJV71vqIZQjfQe33zY82xr3zkaCyBN1lVCoFR4NAs4nQ38Lftpft/aCK1ZU2JQZfA/og4jdNMqaiQaoTsMKTR1GnYesTWKV8r4kh7OjIGT4ZBvd95X1Ln2OQMwROtlF7FLyoGLmFCxTY24cXMB24AEtwUWr9WKTJN0Ymf3zLQcJFkWfv6c9akFE60PL6SFxpw5bzdKLWOCFhnMjC/iZTNtAsv0A/ImIeUpGQwddZ7UpIbTTI+gAwUs0D5FYn8TZnzjiFsRWhY/SRv8UVRUxfyxhCUF4O6rjNA5BP3TFSV645f1NROrTvvVS5it1Hqo2IWKeG1i0DKX33vRqqYJxuQTzxm2I+RGNuH2+YdgW+H71fl40H4+RJIACkv0KfGw1TQEkDhh0lEC1chYr8Hc8hq7uB6lhglF+S2oUaUZuWkRxUbnCK9IJSD+3aHR6XKFyo3Goh5cv491YNwkb/uFut5nxlAyUV8gpQaxP/8hF44+zwg7FecHaq4mCOXkzEOM5eghbYxP+BdDYxvw6qwf7guBl8WRww85ogDIiQ9+ECrE2oBzxC0/bRD6CVaTSWpzisy7bdxIRNtKEGx57nwqQt1BkggtsLhWfuT9HdbxG8Y0O5QEaGasGy/YJeH6ilxVpMF3sDJAMxloUt1tLRRDtHosVmwaCuZ/Jt232tdipPvf/lhzynS4kUInTea8OTnHYjzMvHOYXCVX3lYJ56G/trecphQ/2xwnm08yykOTWFOOJX+3X/eTvD82UBnTNmjSYx8ZcV5PHPIMSaEbSHkL6Ovnzkqw60kPWTlQw6iufOXNOGmG+yFYBrJLYphkCKcFNffJ19oJMUGq55FMCh0lS6LEnO1NLTVnmpQmvY06JBdGE/UcnjkxtnzwM8ewNdtT6LE9YnkpZJdtuU7qzW1lz3mvVIToBTp/hmWLTKxK2tzbzriHg6+FlV0vwtSQyTwNkrxMxeGtJQGoLhU4ntAlaS3gh9sKwQElWpamWWo9/8M4nS7YcKQCubp8LSBUlDMsV7MqGvZxERBhK0GDubTE1D3afrb0OwfzM/Gu868pfh4RqM9IFxeupu0R/ns5d3cbHyNFMu8F1oGJIMbaZ/hDNOFVa7O1Tv5DSG/5AEtG5+sPeRBBXpf2bnI4hWlGrLGRR3QgD/bcAPtWVEg5lHC8By1gk/XZqsYt8+a2FGuIj62mw5m2kUt9VUIi8eg2HkAoQlznkbGb36EEYJtSPGEIatzvsey44QveWgmp7+L5XZUMAGMVwmcPI0Ch5dLpfLJWqWyAGOV7q8di5t/VzvDqGLvHgENRSs44yOKhmi5k3IBb276UTDQv4jJt39rxo7e5TUmOJRbOblVJQ1YNOrJmaA4cnXTVpw/6A0mFva8MDKJAHMLlIuW/Zg3UozenyX+kIvYB/iLCrXSp8BIvciRi/p37NoonaA4YiKTQj5m0ljtoRGzhjVibB8Otjg2z4zRyDmoXAJ/LKoq6qnbv3u5Lxzht4YkoATb5KvL38WFtiOD20BFSABDi5tSQBddMp5pgcJH34bm7YK6b71BbwOS8zrr9Z6Kx/Xbs3EF4vYbsERX9YqFud5jSmjI59L7RZZwUnlT9XSeqi//pFAQhMYF8OaBWMZJ73X308RsLwZOXBM5OCaHy5LT2wI0adKXqUjyeKMUPGGCl+/7+1q9UUbDWDlcVPe+pwRevD3yxLt/bWurHMVNmtqr9CrEcfDju/zltQjpG6HJkfEUpYVly9CoxEkm31QKsRm0Sq5BZFiJ5hiMqam+CxCZ5uZ8If2TxJV/kN/jzmeiNMsa6qF3bDxNvOJNCXkm2CUYNN/HhUw8tdLfDRbIQStTMPVateiVF6OuyJ/MHHoFsEC0YUeFpHObfgq+bl5TcBxPUQ6GyI+8jS8QPsDCkl3deIJz61/u5YKmtv4X+6ivmXqhFEM6+XiHu9ri6sgHDGysOKxIxywH236Z32ZWRWMxFhl+6geoxjZMo4hRbbzTNjRwC1+in9iYRD2smYLRukcsSqb6S9zFdK0Wjw0aJu8toQDOR1YWXlAlnVT8cadpyWgGFkVrWl6wyVHgHMR2b24X4xJAsIGqM/eciL/Q54NpYWFbMDwcZY8VfDm9eqA3g0jkj4rKxGZrvDizU0vFQ+XXCodKHgT52YmZImvKohsdWnVUA5XB5iwDQz00Nb6c1ZMJW/hzeJ7fCr3ZcQ9T7HtgubbkDi3rpZdLideRxClAqSRmfLsv73TPb7esSg7bUFaYeb0AcccTot/8MBaTjnzQwJKSVqLE0GboVcQu+FYsyawvHMv9ro6tTPr3pmgR4cdyLTh0yeI6/OfxfCrKMgbAHEaPu0TLWxcRdFKQ9PaGiVAc9XsTVl4kJigS42lB6LPvkfVN5NVOC8avAwzQWdlX0DZS+ycAjxMj9zbl/b6Qy2Hq0JjgzyFYARcTxT5u/tNaXbPbcFiofOm4js6Sf6f+cI0NKVTQ8kto32q7RNtU0IGdoEIrRdsesZ8PLeM4fKFZZ/tZwQG2qcvLXNmWZGmzRwBDYY1Z1gacEWoFFOqAbcaO2bleoeP85o50HOG3lxkGeDOEUxFjMew4Z4XyxVcmtrIXeEfuWsAAXPDOVIIKirLG3PS/BDXw04keXXHbCBRWqAstljh77ppZ9zZqpx9mDUGj3gQCpPoSWXP+BHZYkhWfn8OHnZoyWyrabbFqvp7LDhg89QwQHjJ9iZYzMqHNaeURUVs/orkH+ynovrXWlM61B+TloVmgRGH/CUTV8sOGo9KUw+EwCKwXtZGTOCbOAjKZhPi2ffWonVXwwtBEOYl1u/sgb8ejI4wHG29OeHkq33P8ulU0TbVPHWDCs8/3Zbm8OBruUeWtaAoUzZP/RsqpR7b8k7IgIZpy53yVLYDMtL/vu7jsFldwlOGh7etExBOobs6H3PEj5vHBX7eiMBUbiegbJ5nP96gznc9xRaf+nUnXgeZIShVJj1Z9an3XBYL6URS/po4XD4a6z+zjjaCQ2DH3L2G+jeO/AEz71UwoEr4Qh29JCgObzCuaASiC6PF7yFnekXCwTmI0XW63D3ZU5Rk+pFnBbXtrM/2Tt/QSIgKQLw+xRCuJviT74HmS9wNXzEmI0qF8inSvhaEh4KyIB2jbFod7bToDS1OwMrIaZgR/3YhGaHBCskSXJjOyD2N2PazI7NStJuy7iTAVUHJqkybG3WcsKCy0H6CBkXaKKB6gZmuutNZrWaXBAGVJ6SGJZB9PmV0i1DOE1aJka3VFQ1J7oiHnAJtedjsFPvueI1UFpMHAatCUrb+Znvzt8+BTVLxyaQOu9QlkJlaP0vhgyKF2VFMYCaVYYFsSxCuYYLemmZYKLKBeOuXEqc0CzcAtWZpQIvKB8Xc6i7gtj3DkB8GJ2iPn3iq8xNUen2R3JUbodcv3wDzKLf+JDS7xbLNFSDF1RKlWn3NQCygBb8zWuofcZL05NdeiXx15zJhzEtIISjQ0BNthVgDAEnTKDkB2R4HZ8j+46bbd6SXutyZrwD1YoJaU4ZAXxfNhEMDNdRXWwEeKAjkBTiVgq+PIo6AVFjaUJQXu94Nv5ji+31XUu3Ry/AQu5XoJzI6+4Kr6do+bA0OmTFRUhmIAHkWtOH7Ngwcuh7OgSc8eV5miguEL1E2Oy1B93rj0kpPYX90cF1StaGOwZDIl9p3yAy9oLl2Oi4A82RylpKarKtUEm3LPUt+Vu9NYSuDbTobLqJ8Z69vr9WJxLA6Mb+IXqivI4PRYsL1EQL61IsO7PkVMIp6/Ie6TjMMvGq1diGoMU+W1OhhxvRxxkYAUWhhL6jqVwC44ojQ9Sn6I9xqAVB8IjYyOOwizbXQUVX6wAYRzl7DVXRs5olmNznBqogADKKurSp+Q4p4UjEojmEK+aLN6zfNm4kAl/usVvH8nlzPiwRbw9rt0xEa+PRcn4e4oL/uLWXaC+iYN5COD7GFbHa5VVvr1YFklOEBSRfOrBhEIudQp3L3EvLu6GcF2WSZLrGI06oosk/6kPBHOD8OZBRrWyL/HxYWmcJ/PAwgEqpcPACuwKBAsaaSnBRISRV5LZo+GzBJQFbaeKjezjI9d72rPzsrhWzsSEUsi++W5r6xlHTWEOVYjszHC6/41kck8XjZcxRaYgIDhNuJ2C4OumaGyq/kXwp6q3z5DgT0EPKg2x6fsiLKWCyBhz3mDm5v5Y/yWvTDmfg6dj0ih8l9gJjl+GwqUV1qn66Fj3KuNhKw55BMMpflcp1bE26MQjbSG0FZ63ZkYDTwB5r8Gewdnbcaum5V9Wh7BQhMDCK2safWTswX5NUAtkn8NEv2LQIfqAIOAqA7LK0xTi5M6RaD0OBtOlylG27DGEgf9bEGnWQemzclORbsKRasePU3ThDneb7clgX8/8shTageK2E+alr73V0J5NeZ0F2I+1Opakm3w5yPjtL4+lmnpTRKJ5CYD+A1SVKeGgDiTRo74bDHCBsFX+ei+WKVaSDtBQJ2FIuV/IkzJrMpUSEhnxrkwQG3D1kAtaUIsCnPu7BbqMFgpOVh0Abqroa/WCvkPQdme/IN+mJmB/ydeCsv1MYrsATnAgCBkIpCPxsRM9pOr4GAL3aU59O/n132BPdAhoanyoWezFhB5I6lutzfXjPGq87lFvfwaczVZjMTww1rlCjWAitVeAUM4VLBpyszUBeKiyDYAor1OYu7kg51dhrX3noFtidoIJ2C5tY1YwPn+RZznKj9p1+joApHfFPwyikjBHpDz2w17eqhxLaXo1shHTmj8egPF6KemhvMUzZR4WWbuFCtt7vfJZ2n1roUjd7G5KeLwQRp01Jb9W9+5ym98RytMWIJs65Hp0jj4rtNqvQdglGxkqeo2i2oquC1Kid4/FAGWfOYZwczoxnfNsJI3pDTV/fwF5iVFGvD47XlRAg4JPcihUSF29DYZKKdqPU6xW1P1gnmeCE4SWY3f9a4dVhr/43Rqoaj+z5YKNHhY3ttB1ZJO/LJyVNs+ojfO8yA3D12BEsh3K/jl+8vajA5IHVrkPtpYMtWO8hJCUK6TMe6GlAzTYuUN7saAPEEom5P8SVC1m9yPMPGPzpRMGecirTkcGWdoleRsA7Qy0/9kPN/8BgokgG6feZhZ1/jkcpgvcNMyb+VFok78HFhr0b59CSid3/bNKKEWn93hmL5LwtwPJX0cuHuf5zcU5rW+WyNZIhKlif0uShVP2cd3mm82DRC6BfupAymLFQ6brwH2M/NEoth/gYEfyQXMRDSRD19AprFBlFLvjTQ3EDXl22xbOYWhcBQv98NRFu+vi6MjFnwgd4o786jYlIAAADIFQAAnyd2faH5v2ufijIp5PVraOfQa6iW7yIJs5oResJvOvfKZ8KQmb0n+A8TBpMol63I2omzTPBZ9r67HSe8eTMZ//kA02wao4wAOFsUis2E4Xp6/g9GBN/SpzKUafvsnE32NWfInLMEbQ/KN69dzf+s0tHUtKBXRix0eLCSfbw2w6PKz8EKrfuRnqe49OSjoLLysEgzAPKcDG6LIkxPHuo5dVkkiaiRa4Ib7H/njRdwP1olQ2B9/vlf13Y90Ek7uWcW1bD/QlnY6g+GWXQjkY6DBvBLl7IFAr4mup3gcZkx2WesSLmjmz2jGzuq2KwXEY6aXUma/1H3fkzBM9RQ1Ze+moRCMBUqdLz3FXpsAuQfj8YrbjoHWD8eb3XRzupoTK0p/leoGVWWCHOl3QoTuLkMuFGs21pygdw7PQIUV8wFIN9KE2/ib3IFYSZhLJDUB4hp/dWnC7MbFkf02qq1NQjlIBA7sUqWlRz2qoAMZhvlg2Sp89tP5d0IbG5ZZzei/53vb1sW7x8hHE1iawebq8/VBy3bbVb5QwQhyjQHfpc+soXJ6eLsvAfNqfVV4/PFdYarIoARqT7BV9kZqHCS+fbSAg7rl8mM0vh1pY4Cs5gwYDPhAusSpo5JNIrHv4GmqpjuUCH4d/bTdEcKHBvFZKsJQc7Sne/RltVT+h0L6PR+g6loB7zBEky19s8zC4c+PwffCBAUUoI+vuk8jJP2tKnwVSd2j0eo0wBxM4PNXSpxlt6U1uQWfRxZH0ybxVf5HMxa1NGiW+JFPITB4RecAUsP83Aj1kbTmp94MlI11xuD//7Jgf6y9iUKWXf4qtyKuimFmchTY3lXkply5TUsWCJgO4fWZeh78OKilOAjIo+AV34vFaDiL07j43V2xiG9nCg6E3G9isqoIiRGqHgMhl7qCu3xGYnuIrjooPOCxQ/NUnLXH4rLw3ctNlDLAaTzjO7v3Rc2TZONFHdsDXdLSg1s4W7kYmKpYL1PStOJIOzwh7jeiW+qnQxFhj5o7Q1GwWzd50oQ3a0W+HwHjCzMn+HFgD78eFCwjai6JNfwOvR4m+4G8XkhrDLDK5Ay310u56IecChZ+L+sJCHhvwhMgCrorPCDjKQcIDrL+ghyRH+P9OD2/MCP+etaWuadjkXhtX1sDrTAPChqKEDENcag6tE6qscizrZnPHEXHAyzXX1bB4IOdWkuQw+8UaWpfZX4cAwEkHMJlrcjFnYedcjbOPDWS+OwrTF1VeOYM/Pu7qWkIOuSyObyLI56pu4ShzjogaFRfLMDy9zj5/d7qAlhgTUIRVM/ps9EJmxjxveMKlG4P3Wb7K4RqrsooHN4PSpj4CTryJ018BHW5lsfdeAn50voY+r0hysRIafZ4pkJjtUWRW9ugtpge4cBuNjIz0hBMe4YJ2rykv94ixyx61DiuLahbWdFSb/1CnX/IoGzSx214TKnSIwG7nCmY0c0JX2MR9sUqwIwEDagr7S/wEXJo/tX2HDze3v8VlGvyRbe8IiR/y96Ae4+/xGURcE6VP2OBWlSqrml765VIHiyYcEhksDsV2zLoNFyeCr1EAoMByQLOxN1P/FVjaKTfXWksZ2oFVo1V0G0NJWrvPXTWXpiUT2ybxrQF/Q3RO9cwS5EEHzANAtw4BGPMXmn3g2EgVJmvoMbbzg04AaVuqf7M5Fs2NDH5IA1bRHghnkfnbE4yb570G0DNfmfNIYIQIzkeN3mJjdYMDalLVwGfNd4S799ndA0urCVi2tuUGKPlfwFGlxoH12djjteyj2sRTSgmiLISEgmzVtFKvWhfI3jKqzZqU3aSc8giHT6GsQKsqC5gVC1gXv/BLJWUZ8msq8nP5XG9kdQfLEYn98AgbrAmd8VHBHWJzNyhRlSTxQi9VD1Cw4aCi6ISH+bpH2ZA1wXHCs5Te9NNEYYCdmTu0fiCSCH/Y06l2Ec2IxEPt5QC7aLgQwmm2qPJNxgJzHlZKaXqHovpjEUzB8+N1voXhT7KeVq0ObrS6W1DcBo2oQ233FUdC0HEmXH+eY798x0lFRzwj5Ic4nOzPvrt3mJ6402MVDRJvIkVBJXlNf2vrLU4pe1VU9ONfTdtj+4Set6cs59F3DGZHw06COTtMYx4c8BnXTzSyxd+fIKznkH+W9SaLfSIWVXy0bmC6hW/DStltrFilm/Ln/zEmLCWPKAAjcSzf8S/XqIzaDoffOZn1Se68pqVpC2c1IwHtJZdMDYvrGUtpEDeyjCLH3+vZUqB/ZoSNyeqqJcD4/ui1prgMesFWguz0zserZ+V9wBYPd21e9cbFOfsXkhgP78bEA+ICH7HEZvE1YBB/gKEud4WioDxcoK+jdRpQD0JDFMM4CPx866kwImFuvoxckcIPIG9yrEAOhDulWn7pRu1ZV9B0URxbcupeUKU2+GTKNw89kdyi/NsnurnGI0R1pW7K+1m4JBN8+39dz+UrOGzohiyN8OdZ5FX+gAzJNqBjcJtvGoxnYsIgA664lnXs6fhH4fQU7ajkmD4YMGE9VVkKQBrb5d8kGg9i/ZwwygXOoa8vaoyHUM0m8xWkmcZIpl+rDX0XS4URZaBRyRqbsO98hw/EDF2CqgnuqXkTq/RkDrBdha76rSeGqRWS78rGxaT6Tf/+vXlV7XuYQrwveAKmKQTNwEPr+JLmG0dAcj624biGadmBHzjGwE8gHfPnyLNGXvovD6qhTSfLmQeEZGrxQFbgPc5MXHaSAd8Kh1FGc/JWKcUmVOiA7H7K4l7M9PqlhrjofJdK+Dy8SH7q5kZ7dlUi6xNEbo9kQ4UJ8v9Wj3D/nHadbq2eTfkgeigXAnISXLfThqOEvGHykNgGznr/xHVOEP1lKILQGlY5XpYkMdKLw5rQ5T+c+AYzsvzKfcWB43ain4zbh0KTc32vfpMypA/XGjnqjOQoC0wzXPUMF1456u9XIUe/AsyzHc3YQ2JKEFLE8DmYaL0NhWwAwjIITHjeiwVQ8FGf+JjOu0AmZcAF+9eXvKMfIisBIf0EYWtj6zQKKp1Ll08XMVB3EFtBUnsyU46bnB7jjYcrKi6dwfk0Xwn05VcvQSdXtgrkzKarMmhCgK8KP9Q7ldNhcBb9ZPZbjJOuPv1QqdwIEhcijXkb0Iipdf2H4KPqsipi1aYtLneCI5Yrx2gis79TxZMZlicCaaJekPsLJaOWfHoTdAgjTs0dILJXrDRSrK6IMfvUYf6zxX7DuyhM0j0e87ZZsX487ZenQHgyCJkbIerT8/gEcR4GkbJDJgHbgeKyxt5tU49W9ww9Ft4iYgrKqShwMiVAoPNFlTpLOchUozRqb5XkZtoJBnFpmTEo/q9mEChg3vqqmTKp/SuHlcVoh2PafNJWvKFbZb1zaLb494C6v/dEhscqpUTVSKlMAZpdxAV1HZIYmV5crwmzoDR5HWMSNyUppyCiQTDawstSDtC0vTiwc+MaM2xTw8BwonuDulhu9vsqU2m11FCraBDJk0Cn5kAgdWHxzK371Mx5zEvRyaipcbI7XhzFXtlcJm3eJouSqfijpaBjdy1Z/Ac5velW3xCPbh8eWBMlrQ/RJ6YXUhftZJXxN7tzCZqNJpwVybzyPz4OqYRtWUF6BvhX6S/NOMRaWvmAs/9Cf4e/kvgnphftACQHE29v9qQzTrZJxQtyMANLW6MNcwyHnjOGgB1Su+NtexHERxUy9hh8VPbk5SYHzThXF1OOxEXNdZxdwYeFDSASWSG7yph7TmilGfsHogcO+VbxWC9H5zu7mfEVeMxU4/BDUT7GAuDA7TMepaNSrYwzdeFsXbd+c/7oo//zdQ1JqSKd46HMk0YMMCthOrSIwAI2xfpPgu3h0F/mdbGbycQc7MUuleHHdbtAbRnlucn2yurmdS+R79K3mPGG0EpxWqU7KjkEXdoVs5g9BeKcSStpaIZ0kK7McOiHUr3Rw11waYtj6huv0hn2JX+XkAoOLfqb6D3sRnYGsx0eRnP+fpio24n9QIFVIkY9KWqesCG6VNoMsprPQBryk3rGTzn9dkhDRpW7NMba2LO/S8nBBfj/VLtkOElxh092ic9dgZMo20JQNHKBy47FaY+B5j/cPg9xQvTttjvnVTLJoUmHFSUv8xA4ghFoqDcy1DgjBg2S3iofiKXisB0wp0RmykXzb1zWCSUJieywESCxy9e17lv7Kchp48SyjbLHmp1rKIvWdHhTFD4GTK9BFIatiDZVy850fvAFVHOT3VFonnMYKjDqm6dLPPt5Np+2euKsUa3fwlcuO90jlWRo2SymA9iNFJm3nrrwGinmvIxt/ftqJ5WcXy/crN6tqvoj34b58BPUnYP6zwF+fEBhZmbKDzp0Uic7NGZXYHl2NUp+VSKrzVNsWlQYgSJYUBa47lWFuR6hSNx1bmLxjHjWSTWIwpssmpRWZmmMlZ3BXVpr0Ou/F6D9LOB2xkoU3VHLiThenpSDWoStpunR5SOPdCEjOmG5rih0SMuBgu0zI3K1Sq/bsWJTZsYZuFFKrs3HYXcpSDtdops6gx+ExX0qyJA3DTGB6kcX9IqZaQOMNDPd3P+btq3JF2iDPbilAUBbumI3fKqbKPsGXB/zd7+F0FjgaccxPS8sFrj5X3BVPMjkZu34jP6y2/TDLF6cupOVYftgkh6ORLaKAQI92E8OX39+r8VEkR7/AooVoQwZgIgw0GqVbmeBs0eZtWwP4eng+3urXgPHk53Up+CHJoKJzMMyTwsffLGdd7swP/WovqPHSo5JCfDK90sQNmgZcyioALP4ANFA6x6xEqUT9R7xDwpEaWa5u5wiwSCyjI6UkrPoKUqzzldAFapacXy15S2Bh8RTxRoC5pJgZf92qOIMsbDcnM2vaPhcgU9jdhmw2pnP8ELNFoHQVNbN9SK/0jvfTt3+wujAVP59d4c/hw2zXCYQjq1GV4RdTDkGjcaCSg+m01GA19Iihd5bHzHVjltyzmyYY59pHaLOzUgy+FQ4qYqI5CA8099vAra2KoiWh7eA9GSlpkk8Ll56+usKoAJO7oWL9/kCiWiEPfDcqcdH2qmz+Ni1fkoL69TMP447riU09ILlLUYFEVnRsi78yNKVQftxoCQPco4VnOSKpcRx4gYps9T3Mem9uEyTD+C5hrtcQKMcTIcdUxOFKBKmEf24/gLx4fOF5kYr18zwa8O3V9MZzDYkmd5X3UE5XCJRJ8UOXgXQzhVXfGE/fduysUYB4ws11YCUvxZO28PxQ/+wxlMlOYM9MtSDwRwu1prB65+f7Wq9HPSG34PdZBX4p2y4Ezovh9jLntLOSKPdyI8VycfgfjgowDf85gjYx8fh4lZugeOltM70LDg53e7ZNvBAhJAECZxfYkk3+4bwLoe3EedvIbtGbcisK9/U9LX1A8e0CrvrnB9FNQF7GWd6Tg+O/Nfe453oFrOFqaI1qIk3VNyjjrC9XnZg4oqVUVfX6iAHUOE4pddLbbmmjhVS5n3O6TCZVzaMe8QYasWJmVgQi8ZpfmJDP2kmk0RLZvtJ+7uijB3Mh/TizTkBZFUWq+jsmlcFq3Q5Qh9B/pHAtcdTH1/sSL+PZvHen/SnbPf6amTa3U0EGp6SNIlWAJUjStwYpWagWrrt2uEFRrXltPwcH+LcMuj9LMX2ZK4n9RR7OTziOonhqpnxFLLQn4nZVRP68LHCcM3ksnADZifGJ6GuLETAWqqZOO9UbQvew4kDApuuvkys+n5MH7jS2IFgVj8T3r5WDIF1mz0IqCP+8K/gbWgmsJ3+pc4d4tgmjs+HCB494bKI2VrVIIXOB7uF5Rsxvuj8vfsCYYq34lbAdPJ/yOxtTFCyh5UHA6EEayKVu2JO76BZvhN3aByYfEwqlzOAkwvTSGeyzKbIsmz9YyrrDKT5QmhDXnH0IMeRggAk0UK2b1WVwSsOrcVIwIL0kgJ4xMMqZvuI9PamS1cykIMHyEK+tkoiNLAMGca1jfbZosZYNrVoaeQgyyca1ZL6l8Ti0U9FfBjvRyEatlhK4Vdpi3s6Qt5X0asj1OuCStSX6bQEhrbK9qMi/vXzXrIo05mCGpXu18ITVG6F7UCByP1pVerzX5ll0hY58b/P2581PU0WCJMKrSTlRLKRX2aztko6K+fkMmsVecgS4/P7JwKzqcRgqfEo5fPpB4FlOlmZve5SgnBikNCAVmicj5HxdtaTFdA+FC9sEB9nTxBwJYrJ7Gt1VadsmYhYNC5E2lRlt1a6/Q9TxT7THxcLA2Lx9vcPfqYN2PCg3coCqYPle8RKhWpESz5mjRnagm+k9y5/cjqL8XxV9hxHQ+o3cE0wYwrKRXVmIFCH6bSX5Yxc0dbNilNCohfGwBBDapfChR7gBUx/AteIQs/RrERAfl2rkv42zTldfdzId4znzgfn9UfnsHnciwxpRYqunS8gmafS0wlvzms49kJrBvGhA9voPwAild400CPSP+0d9sgCS150qcUWdtR0zVR1MJTNiYxvPXZAA8pVLAukJL7FTHWM28ASizQSuSYrrTCx5gaNg2ecwW1UHbc965XCTR9iEG9IGGn3auHCHDt1fpyX732PgyjOBw7nbM0VTAqrJLqWoRKer/aUZ2wv+Hm+d6aE2c1vg7q+MSqp1lESDiHJw6QdcZbyxmwZyY8JgS30KqO7A2Ph9v5Q9FzuaYlIdmmnk3iho0kQbGVwu7A/RO4Xne+ZcFlLkKC+BL0I+q8nnKec25gEldTOo6M9kxv7ePh+a9Y79It8gizU+an9MOgpupoIDa1hZfIi5qTTdQyCmSE5VGfy6SSVq/7BZ37BqAHZOZdGBxEd2rDTG5y8LqZ2t1C+rMBHG7HvVjrdfTReaxxCNqk0yHMKv7oSmvWBRNqfA+HfH2xwGpjfhfh5OLFXtapGmwwJiu5fBK2kAR6Kl4s/6KKKMTl+sfs0V9opR3EVxMz4gN6X2TlY0NK9rHLrg5+sNpSc9mRgr5FVMHEvNf7jgi9ILbuEKUS5q3PeDIbiYFCTHeXJUdAwqpZO4FWRN03KtlnKulCmMAVuYDui+OhlcbR7Gna2vIXXXAdTPVFwheezqUOGJZ/8CyK3IpJuLDDJocauze72iTYoFT3G+hEAlMpx1SDOsbrYk1UikY+yB8grs6fzUy2Io771LCHpEKXSG3GlTPU6b8D04DdXQDZAgqX4pxhtoeCg9Yl5nQm6v8sQJkUr8u+Q/6BbqHvq5F2HpsnfGLITOtozDQnCjwHWswVtKQ0tgeem0yE3yG14z/cVhyXVda3r3hIpmPvWxV6fH4z9glKSQiXGg3MoaJNyEPDwncQqWWoFlV1btLKROcGv8qIhl0MzLwSuRIxt2jI1fJDSNnfrqjfd9+eGNGSXLul3lIWsIqbEvu/SwNebygua5of5zgok7riEkz1KdxJnHyRtuBJApIB9jqEWNHM2Wx5MkiC6zQYSL0KnXkIKm3/MGQpIvHOz4BNrEAAAAA');