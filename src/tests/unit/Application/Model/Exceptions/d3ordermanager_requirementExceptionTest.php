<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B31B126EC8AAQAAAAXAAAABHAAAACABAAAAAAAAAD/Ds4ohGC/2zFux1IumiZobJrbFjVhn0I8VeDAwAcYIFgvcTmqJ8unCMPkEbt3s318IOwuCNCrZUEKuiyyqVc6BU2OjVZkB9RNHMUJl6XuIEg8FsZWuNW3rd9RFWpCAudSCHXc6s9xQrbRbDCRnNRZOAgAAAAgDwAAKi8fiIfkPpdNLWyojSJYj1iHI/m+cXM6R9BtazAYQBex56Ezes9hi7zaOAJO9Sq489dJkK/xYMfa+TpUunUVTLZ39zykcdpBQq4IJgQh4cDk4kRHM+rdv0/pvcGyfhUkELye9yrWAPNKAgnQaGGj3iDLr6fE1r5BQSQbh8pX0R3/FyO0l2Ub/QwQrnR8+ZED9NCvcsgMLFQaIyOabiUTyoL0mxAqU1tJwFv4Kbn3SK4G5+wZr/eglQAv6O9+wczd3G/F6ndFlJjYT4+IH4vzF2acsoojT6pFoi89oxO8KqqQy0epUP+yoA/fbsDfosSoAIXVsfa0bi9d+8xXvN8Afivi3Op31+0oVK5TZOOGfxV1ADAOo8hf6IuznSRlW9W0d3B/AzpmEzyBiUh0bvt3VuQCCGeSAbkY4BeeXtBSAz7M0/8mFss/tQ6p1qm+tJirpjVjMN19qVsXdOToxUjh3E4WDX6ydWb++7a/G6wRl3Mejc5XY/FJUAbm7NkHp08Whp5O1Nime2mAkBi9K4QjffoJkxWeH6t1TrqB2/ZXwJRy6saFmelXJiy3id3NHRfff8bZ+w09Sda+a+RNZyJmg8F3ZqPVyit+OQdsHXn9WtsRELMgDU2mU2e+U65FE4mrBBMr5sy8M8r/JLK9nB0dVcMMeUBb0MX+gQjpyCE6JhSQVRl2dGR3s6hRhN1Jo/qZa0hBhFfVXhS9EnW1zPbuaIdUHaZlIWYm5AB5BzJ9Y+V5HPT2Ju7NXTSkzgaTZbXp/AXjSHhynpOnHH5W9Noljx3VXc+y3+sVO3m19gGKYvNVx/Mvht/E1WUr9Z3UMHXns+FxCUTef1ihL/LBo3HV1aqCldnBStUlULt46ApQVq2wjVBtPlzBcASr6VMeVUk4+IOszv2wi4wXYqgJDttUDPz+HxGfA98Pq40oQANH/iziKfjaLhJBQtrQAh3yGan3q72n2A1qPl+HeYyKx1G7fbOhWAmdsBfp60Gz18pY+8jo7TkaRgMzoz+gZGnem24yk38dSzcNu3kRYPydOKh2X4+vT5slekRi4tfWGRBFqFRF3QjsAuiNJDVp50oiAdgzshb6ogCc4ygzN0QiScz4ueZkC1Amk6mHYd73urmC8fTh2G1Fyip1tFCv1rjpQWXeMXMkTpOFDHI1gXf/zvQ+75MG4fG7dUdaKwswLegyy3Jl4gww+phfPz9rzexm8Y8an1vxuRX9qMa1j2RGHX5sbWuP4yuB+HcjlBDo2jebXelRouFIRhFHNx8x0aH0EwHsCiZpPB9h/DlQKGA6kT8+QVj7tVtu+dukqRfJ/WBLNjYpLVnuD2zz46AkfEoGLU9FRoo0xSJiWflLkd3GDL5kf5s8AFtzS/Ty6zY5NSgkvLu4kB/cqXOwgEK10h4dmopkKnrmx0WNebeTxIpAMbzB9YCRiLJ1OS5hTcBAAdKHMY8wRMdFO8NbBX3vh5UIBPg8DGWIDcSMaw5k8vjbTdB4BtgyKUWqCNqAOZ8lk2ZKNCZX/gGZAfjZDYoWODmRX89o8Hrq3O5iaXCUHZ5vvxINes3BddnrrL9CspD27lEXrpGkyxvn5FhG4iJPhFwtFqj5R6QGkdcat9oj1y6CqSUXzOezkhIFfhGeYPjhx+/C+40MFgb+haGTzowIqJy6T4Kkh2v6KuJlnEfrpWeLSLto4c03IP4R9GD/Wrs2qyxeIZSyvFYPj7QKCwDin1DH99bpnG6HESBdMj+nc11AbvVl+Amm4t26L/EXa6utZ+7JhfxTMk1rxEJ3tWo5HGMMAYkg5TW4232qA66T84elyfm5mVAuzvdop4+RYx8zq4VqH61Ejr5jQZS+atjWpIAihi47sRMgVA0R5HYJkLvJu/PjV1vTBy8sPQWBTeWum7aqVGDFl00NfZ6dkXrb4fvXW0v616eO1nXiZP4jK/po3WG97Q9e/RIBA78cnS3hHZzoJv41fjDCNJmqkVHgrUUtcQopznNEJOs8TgqDH1rcLJnlPZrGmrsxrv6WbQOzW63Wp4mIHki5Nptdb6vuACaBiMHOJXOlVubxFY8KJMdhkmxQ+9xDP9Ur86Km7bxGsuHZYTnZayv8N/nEhBwvNzwQFQTzspi7j6Vka+sfXTnMEkqSPpgnu+OGlQT2QY8AW/UJtSPFX4Rs3ytaSQ2iPi4/CeA+1x5+VZMQUCupRoY0cKoriQdiAX3w5zrkeOjPYCz/0rFuJylK1jcn1Kz0xKIEIyFk774eP0RI6FUWffd37MEhUMD/QoQxDfwBeqIgFJG2k/+ksDz5JSYjV4PEuSro6kud+FUBPWIAXUBv5/kg5ssMxJVu8LZSUgq0bTvhmlQRLz2Sp8X4JYrYb+sPKOYIeSfdO4tn2HB1WDSJBqk3VRlxJbNyXlw8Chvpckzrb7NeqpSUVZUJcjBTJAXIME2I8WjLC0R3graVHruc9DKA9xLQ+woY/eVJQ2lpfrT/W6UOvrjMNRyq71oKR+sxK8e7IaK19/f5oITF8WLxGzKY/f9coaP5WvI+gc59RrglUwBUe88ZTK1a2t1sM5WBVphPtQAEPWg+9TSG9hdIEWeMNE/mH52VXvN3uJtAI/qvzMV8WU+1eTPzEgjZPFKyLIXEMQFjFblt23ympb9VZlNio1JatMr3Y+oA3gyx9Gii2lQwq2rHVHXEmD4ENgco/5IAwYjE316SoVIMmOggeZ25q6b3ley7iITFR3ULJCWt7ASGn+YPE6ZlpFThXHXDo9JNfifMm55GgIt9Zg0xpYICbW2KFw+3/ICNue45HCVCmPHZIeoo3Lo/pjHdz49B/+XwYXYzLDzsNYFC4GJnFKEO1SUhFJVyIRwhth9oDMENv1TlGF4fTW81hAyEr4O7l6/qNWBAmmfQMkEC1EHJ6DqXEYXSx0PPEdpbc2auy/9+tVFN3rszu+ent1ImmK2yjzHLuFi3K626eSAXUkUxvgsJnDRa0IGSU7f8bW8nZBMre4/BspjBXVNGTak5LI2/JpZMThknTH5El1p3EJME2/DmWMmKCrVMnTD8KnBr0DHmTY6I7lFaDmN4zvqyoxENVgUf/jxnp+XT7vHj44pKVYQHDcyuUs2cyG90LgwNixaEek3FHAEZQk9irrPSYx+cnvc0yzzjqv1sb0x0XIllZXH0I3qEuXcBNps1us3qpivOzTYBADaqwDkR8WpOH/rF7DIhSx2oy8nP8CkXd51UQxnTmSo16u4HDxRwq08iZL1ogQoq+q1/xpBclFkRSN2KJ+d84IkrNEOweCC4YgqfoasotzZiLWOu9CV/EDcsramiH8d1Z53PXFvNLXbl0VIeq6sHBXZ1A9/pOy/Hlds4A9EMpQkUmKduZwcyWPWOX38V+P5gBAdr0J3KJ5UG+JZabce7IoQ/n31cTqSAs60AMAv7ZFq24r3G9Vq6eHrdj2gmRs5iH8Gq4JOJihA6hXHPEbWMt3W25w2ltUOs8XsTHc3u6TA2yZI6yIFnMRAfcq0gKxB5HSu4CX3uWvIZT5KrFjEXgDLMTYZNzgnFn70aD9q+sExfEtxVOPvvRpheJ8BOn03eOKwx0bleZien4/qvcwIL4w/0QG5rIEleZBqreFGAC8EiSFNkRSw/vV58TGqwViuLQuz1t+jEW+s0CY6n2EaRZhIcac2JbzVij/BvTUhQxoa5x6iOgqX07CQVMNAZ3l3a1OkTpSzTrzZIt/6h6Z3sdFlMztWgIIjHUdW/1ACgv6OM5ilhxule20TNvb9SVzkgZd9P4zOGa4jpzXQsuDWlCpdNjXWYcZ/zFycufF+l24x3Mn7fEIZbgFaJ2J4v5IYopa9loYSirfgl/z7lsvdegEpB+66BtKDG7ILcq6k2/WI8SCeTDGyd3h3byzwzg+YtauqfTxBxixF18UvU1ZUoLzNIAFkTG0sG7e/hhMuNEgrYyDLL+tbGvenFcmXuKbV3og2bX8EY0fcZXIdQtooqssOmY/76PKsj/SXGDomqAX1BTlxSZmF5DgYyVYaPP3ZQ59sY82dF7UfSzw32rQLPEoCqEvCmhN1SrjRl9QomKV1e8upsG1UJHZX8ydtv+AvjRsWppOJ28FKl4zmXnitjE6kqe3xGYbw37UWzcYZNau2z0HEHOTh1SrCybO4gCV8urtujABD1GN5Z0MSeKA7vBe7+fstm4H3QujSzt731YAnrzaN2ruXHbZfDjgNeaMWhygHNQWsf9F+c4fjVjDrzkKNnfzNPmy1oHS9m+XISCeGrlhq58acC1MZDWNhFJW7PYqVFh+kKawv+BaMz04O/nuStWNkSGfw2/nL8i12SUdGUfADH+igPm8GKFldxKci0QW8fiAXD98XvA3w4sQC5KktHg+OYrmNNGEW0hj5X6bqF1ieeHwcSg0y5ME4EdCeInelBphAhovkkDt2QU3bzKzEUsmxOX3t3IiXf8rcd9+OINDZiOfuJ7O1TIx/yJp2kGUw+OQh3RfhpcS02Do4/YG75nZ8yrZMoXH7DJ0Aa8TPQ0mlhhj2IxyHOXg11hycnA+pTT2Ay1wAxyctLy38TbaavXECX/tE7DsZEoYESw41NNS71Vt0PO6gfnJ3CvEFjYdxPKbqM+DfoMMUFoByt7pJR6pIlYYx2ak19gfyRcWGka7H1saeMI6Uk87tRwJ7Ke96ts0MbiTshlmBLIQlano2gNXuh0lTMtaYZ66mnygbIJrCvcbBxN9F8Ubfy+2e7wr7R658frGaalPyYVMzxlEyRd9VM4ovc1pTwiNtNMq6gEnrXxbbN896tWwbxitk3cLbZzNKl3LSN0UavYcNH0AtgflvBArIUf/b0bhyyUuLUw0uJ1IjOe5cZ+0ijZgCeE3kWvQIaCmnVd/STegV2jZE/2wDFhVcta1NmEFfYpdZEkzSf8/NhNFR//ek/cemVpziVXmj5ELp4yujle7Y9QkluKzHIny6+lUis/fvLSOBn3symQGfyiVtgcR9afLj4XSkZaVWpUCns9tZe63TXYst4/lxDwZDRlFKa9UE2DwIx20aR4X1enl6JRkky13aq8nInBQySOaITN5R4APNfQDzCWCHWEKkCvIpqyl3927wsVdEQUy4pG7p+RmAuFZME6AgpaIdn+yvCMEfdgdnvj5HlMk2u1GyW4HH+Ga0IojH2sh+xOG/5dG3fB5EnPpH5iIpRAAAAAA8AAD8Tz/w/n/PWdq6B3K9u2IFPN1VoAx8o/c5oo8CdtefcG2ACCKijHT6ggoXPpK2ntJ8hE5+ea1IYO4YJVfaM52s83Arfcr/yapU2C0Wmmb2Zz4Z11/ljGFtQC8HqZnDgsfHk9sEiJjtTE+BoDswsbIy2m7DcYiEIUf79pVHs8Z/9YMYwhe6ZgzsBn0ra7ASDKyARMsJYQ1rro/ITSZIewg1dmx6UE8ELCp2Kymz8KIrXEXCGj3EoWJtZ0R8IZAMQFo5VgVQboWVh8xtj7AV0VSWMHShTaq6X+WqSzTvyDrPhPeBTW9Xyo7EjUOlC8OEJKal15HN/t9YFOkqSVPMcMugH7hZEppps92C5xBLpJ2C5bp0GMoUM9Vvm/DTjFuP64X6Hr7AZCinMsdA/G9gX0k+/c2nEZ6iYWod9eGnXZcECVrYAgT6ndeTWPNLDf6gq7oWJLkcoWH/ohUKWKaPhUZFjSBwA9MMbv+2CkWJ2KA9DFAxX5E9e6y5fdDtPVCm6MWwYoQCybtyx9qxDlqhFjqhzqc2ilU44BmhcS+1fwuiUg0HjkuvzRpBisvKKNmW7Itql8ce/zPb9XF/lXYLcGizuACDtLJKNsoeCqStiOSj6j6GYEVG0QToYksh3OpUAEYqV45EeVDt3h7lhiSExMXnznGNlSZm7wuWoPkrbKJYhnoSWUborlciNRWrM6utQVT/7F4gWqAnCs3sdZC2vlKIPgOqffbLbFQ7R9+0tnRBTIqlX+bzb2N78hA1shuD0Vw/NXU6R8hIvRK3K4Q3RoGdNUYtPNflNoLJsTb/aRz7f+FuHWbdwa0BzIVuou74DTLHQWVfblOBHqK9SqCbBsjy8M0jKAz9YuAAgCTgOy9dFzlxeV8jSRu0ra0uYW/2kDA3orvqkNL19cqW5C+VIcMquBRpXnURDiRwgVnPwikwnu+gyRRuoLOj/XIWVibrTHGqc9Bu6D/RXmf8fMAsAe4vMTlmExExigLPiu2WRl2jHjCZacICennBOB4lIsg0UKThGz6tvZuYd1XI4/NIOfmmMEcPwqlx2FLd8jJJN/6//XJesvkC77CTmqum3r262ba1M0VIzfRMTYLBU60QXv8DbYuLoSXX8lj3jDJYOlUNHfJ4zqFY6pahQe2xytRZQUmatuYZkLTWJz9Yoj6FdQObNWbQDEie3+DO1fDhH3XwBuRj4id49tZm05ENmZo1Qhvgl5yjXgWEGwBXFlvUpcG2PtEvYtgU6sS1gQuTWXBqNpz6x4d/0X7lQF6OkcpLE8swJsF7NyVREZauuDTlQ68CFgMERsKanbzknfKmX4Zlh2E55oIQ5yQd4oVkHrHj6+jz+8a1RaSay8u76BR/7NMIj14KpQP3i2BVM8ODFo7Qs+rsCPL6rVRDQ/fM6ncckyTDEXOe4E+y8tX8/Dtmx47WwSQop9fec+zBVgVnqMcTwiqnApiyZkhMuI/rcIAHg3Qjlqs54Qvlc1mHiGNMhPBHX0qBzYxwCZt0Kwrr4Z4u57SSjydqiyBhL6aRwLyWjUoAdLinuyfWOOuAbDpBJ0OREshqxGjxDTsO1F4yHN6wlYwXO/KiJnOIXXCBwdvGQiP5xmiPcvjlGnUsPH/mbUykwXicUQK7VnDzSNeMv4d23B6zjmmpOtK5g5Ff6hxoOvyn3w1WHG00fBNtVxX8YWsHdiVm6NMfBQ5MyiCD9ujWtyb4Mp/10gzjIRwZNSkt4F4aZAyssz/ZiJuvK0NRRsbJBC2vicag+W/thIiUYc1e6olU+9T+lUZ0scjLZtbem7e4g998rkVSk8Uydsjl6iOYRra/H2V8aZAHB/P2M34ypVkS+jey3GsfkBitROltf8YTP/4Jvg9Y4LGxRWf8SPTsYT4g/kh316Waj983B8eT18CEtS7kRHXgnzV+7hdcu5/NgG8fmChTkIKCwH+dFNeeYSDJwDr2OABzob6jrwYE0G2/jiGs57A6m1XeCLvi2DdJtete9zOc7gx3lULrUuCugO9yEsfsFJHr7xBtO3i9GDQzDpOm2NHq1Qy6VDE70R5XLE24Ckn92UZVw6ROS+l3/IIjAp/9VdGE8YxuIR8yAjaEoQZkdIGePysFnpMu1bjYEyfLGGTgnwDboXIzuKrF1ow2UfJ2QKGlr29IWCLSlv4LIJ/d92z4RnubfJf12YUIY1ibLGmZgJymLQZprTwatLpZmeFGTp4odK9IzX0NJhVALpFlK34yrltMO6urABEjNbuKDqgdKDHTdXPX5wAbJw1LjfTkZLsFcLSIxCerNCcybBX596sMn/9fuKs9th0j2i8zltV3MI32FamA+sEynR9XaI63DimvN1tIgQ/cvx7ge2Jc6zSKgkRBXc9U9/BXFvW3pmuFfDFUTQUnd0pxswBNUe5raifBUo+Dvq12KIS0mG0+Emdo2wzVUz4/cR5O8JjcVLMV5W6LYLz6it1g70OJwWNv/qk77RUN+adH8InFEHYHcZc+VxLJI4nXCTPXiM5OvL4pfrGWcca/1ySxCUZgu4CZ6mbCO5v1F352PAQ+gO1ImxAN62BAfb7H8imWuQyYmezTT/clHlH9GXU2TBavUpZBxPPNFhLezqD/57ksyWX769fkEaHOqgVCF55RiGVFyH8N6clcCHfouwwZibDxOsBILAtozzhdFplpU7tQolXXZsp55msjaNYQ4MKLxTfqKm/meX0cZSph25uVmxBaPNespV9h5qtWq8amVcySpQjXQ+JIMmbnDNV7191EHhr3AeeKc4RRMkQWMpdwhEoffq5cSVpk/1rA6rESf/GbsjS0dRYs2fe5YzTGDyz3vY6E+KSr1pWphU83HClQvQVEMja1+9Aj3yPta9Befp5yonc1d2KzbSQusmGSZ2r1a40Y4jjgzyGDfHKsyqnf/SNJpoe+tfFdfQ+wzmh2AMZQm36r4iTrmOX/uoiY48JktsA3ral+H9zwhwRRW/CieJt4U0m9cyQ9HHI1NObUZOQR0+nfsn20WCeM07jS4pQ3IOthc8fAdQyRJ3T+EhZqRBVAyg34zm5eiNqiEd8QlSY685C0pbMCEOpM+v1RdrfnS6Fq8HIcnHouZLu459AqHz8F4w1eCvHW/foKoMjm/N0CspF8j3ZtqEeOfxydhHOjtmORU6QEbdK/P4hxo7iwu9BvCta/BGtldkZCQW/Ti/+YqDiSocCqBPTawuXsbSXMTgV9LtYasP6YvLaB40wuBWsBAo4bW2o+MPvxsrXPw08O/F++5cGPqbZk3sJBHmu4veGXM8XFLegh8ykIb74/ZrvkSfcLiIEhuRV24EYe/9j4HOQkcrt2PCqZ3yl2E/hUpO4Ts6n9zJOFsze0wXjYxeTiA6k8Zgh4XKipiTy6EHmpXZ6qkhs9L+Saw/I8I5FjpI1sZopLLpjTz2FrQeHeulwtCkfaT9NfgYISm1X0NaiWQxzeHjM0We99EI9xVcDwo+5i2yyCm0AmYZU6qYZP14XkWwmvh5IFxJ8S1tP4QKAwJj5kVhz1YCAWQCfzH4rItTaN/vvejTvOOziUZEAkBKtSpCxuM2KMGOJgW0MMAgmZ+yekPYGT/o+6ydf7cntLltwAZ32QDE9iwSMPx5uKbaa7BVfuJmB6sVRQGxaD1/v0ILnnMmFcsW+22d6m4kgGK9uHQRJ+/MpJRMfTsNjjWBj6BSU2l7h5ZawuiKIpHdCbJuAKQxhljKyjgs2OqmDmarvE5sUJX4EflAtpxU9U41SHJ7Vx9qaQBvi2dqS8hn17fBZlaLaLMMmeuLVZNgsOLO48nbtJPFLIylMcERO48PtF4jVDtVNc2WLQf0wub1uFTGrWQaIZkt9jP4ErgdZY6gDFkdqRl2UUzI627HtM4PHnMMFztlq9+kkQ5QeJgDie4nHn+e8g/tbQw0xuXVtgJrXN3y7MeUmwHxHM18ZxCjUAwS6VgA2leBWXIT+XPOHZY9jNtDBrDZTow2xcR3M7T/EPtxsx1sV8XOqvIgCjzuRcaeQ7Aw09UJVdg3vq5XI/9wBndqN3z4H0OuLd5VfOSQUtQjeGMoNxBmYiqGFwEv/YN3+YN8WHNCSZ2DwZqn1g9TEBhZuN8aMQugm50WZSoYIGre1mkw+xkW3KKfv6LAZmgcVGbt74jBTDefKB1+GXG9YGkxvnZ5V+qZDAY79xPLfe+7qwvVQNjODpccqEqTtnFEw6G4ZXyEvr3RjqDoHOTQTeIFQEPJSXHwnurLDYb0YLCbsmKDFHKb1PNDvhqhXbUKEtOszgPZ0UtMcHjLxR5zXWQeUYI0gdd0En7xpG9YvhJGp5P7Aq0sN17PKwq30fDVd58oLDFYxE+CD6UPRQnx20uhd6fOaGhrFfp1N6fyGAxNRDlr387LuDyqOEg4JgU8bhndBcxNFfKRv/st4Z6FzTUzrvRkFk7k9HODof/JmW48d3ArUamfIo45UxEG4Xbp7kb7DlN8degRetXzdS1G/Gwxv9Zy0Xc5iQCSkRHT6f6n+/dd4A64opV1o4c9q7svFmnKjaVeJUKW/VpespZVUPS04VRzzaOMEUkHH6RGf2CEKybJideMbDph2kJ1YachW6ifmlUju8KeodwMtHW3AJgqRxQRs4NXAQSRyjMsF8/kbcpsgbTzHJYRF7W0GbeFG/0bv8zr/jS4RskeEFy7ROiOHHkvSGwTZHTVdxf6oLRENjLMTThHQHyXbdFKjzTWeS8kkAahzyeh5FgHxWrSusTH/hWF66++K/EeJ/f4PpeuYZO+H/e3ADRFKlbWwy9IRWKnjT21uf8K+rC+b4d/2ZE6Boe569g7ixwGcmIUh+r1ZfvlRe8d7ABv4nAU6ndpm4h+zbu6VO9XTRpt4CIig0KBnxvLF0wL0HjTA1aBK/INoAM4teor8RNqlbCrY3BCBx47yX7b50QvO222XM80z0sGwbRaOFlmOooqiA+/P46b3YWOVXJuzgVmUqNKcTTTPyusgYfdW72WqZepTGPbig/6RbKJZYT4Ufd6/tIZxxW26HkU2y7LLF0/QwClrzBrqc/KGMW3xti+PV1UAd03weH8y/WDP8ZVktDFa4j3kxOq/zzxQIDxy8a8P2i0bZMVYipC7vCHTdVmMyikq+FUb8MDWo+LpAbFfehKgAAAAA=');
