<?php /*a:2:{s:80:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\login\index.html";i:1788098377;s:80:"D:\freelance\kkk577\Backend\parttime.com\application\admin\view\index\index.html";i:1787941024;}*/ ?>
<!DOCTYPE html><html lang="zh"><head><title><?php echo htmlentities((isset($title) && ($title !== '')?$title:'')); if(!empty($title)): ?> · <?php endif; ?><?php echo sysconf('site_name'); ?></title><meta charset="utf-8"><meta name="renderer" content="webkit"><meta name="format-detection" content="telephone=no"><meta name="apple-mobile-web-app-capable" content="yes"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="apple-mobile-web-app-status-bar-style" content="black"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=0.4"><link rel="shortcut icon" href="<?php echo sysconf('site_icon'); ?>"><link rel="stylesheet" href="/static/plugs/awesome/fonts.css?at=<?php echo date('md'); ?>"><link rel="stylesheet" href="/static/plugs/layui/css/layui.css?at=<?php echo date('md'); ?>141234341"><link rel="stylesheet" href="/static/theme/css/console.css?at=<?php echo date('md'); ?>14234"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1"><script>if (location.href.indexOf('#') > -1) location.replace(location.href.split('#')[0])</script><link rel="stylesheet" href="/static/theme/css/login.css"><script>window.ROOT_URL = '';</script><script src="/static/plugs/jquery/pace.min.js"></script><style>
        .layui-badge {
            border-radius: 50%;
            top: 10px !important;
        }

        ::-webkit-scrollbar {
            height: 11px !important;
        }
    </style></head><body class="layui-layout-body"><div class="login-container" data-supersized="/static/theme/img/login/bg1.jpg,/static/theme/img/login/bg2.jpg"><div class="header notselect layui-hide-xs"><a href="<?php echo url('@'); ?>" class="title"><?php echo sysconf('app_name'); ?><span class="padding-left-5 font-s10"><?php echo sysconf('app_version'); ?></span></a></div><form data-login-form onsubmit="return false" method="post" class="layui-anim layui-anim-upbit" autocomplete="off"><h2 class="notselect">系统管理</h2><ul><li class="username"><label><i class="layui-icon layui-icon-username"></i><input class="layui-input" required pattern="^\S{4,}$" name="username" autofocus autocomplete="off" placeholder="登录账号" title="请输入登录账号"></label></li><li class="password"><label><i class="layui-icon layui-icon-password"></i><input class="layui-input" required pattern="^\S{4,}$" name="password" maxlength="32" type="password" autocomplete="off" placeholder="登录密码" title="请输入登录密码"></label></li><!-- <li class="password"><label><i class="layui-icon layui-icon-auz"></i><input class="layui-input" name="google_code" maxlength="6" type="text" autocomplete="off" placeholder="谷歌令牌/未绑定不填写" title="请输入谷歌令牌"></label></li> --><li class="verify"><label class="inline-block relative"><i class="layui-icon layui-icon-picture-fine"></i><input class="layui-input" required pattern="^\S{4,}$" name="verify" value="" maxlength="4" autocomplete="off" placeholder="验证码" title="请输入验证码"></label><img data-refresh-captcha alt="img" src="<?php echo htmlentities($captcha->getData()); ?>"><input type="hidden" name="uniqid" value="<?php echo htmlentities($captcha->getUniqid()); ?>"></li><li class="text-center padding-top-20"><input type="hidden" name="_csrf_" value="<?php echo systoken('index'); ?>"><input type="hidden" name="skey" value="<?php echo htmlentities((isset($loginskey) && ($loginskey !== '')?$loginskey:'')); ?>"><button type="button" id="login-btn" class="layui-btn full-width">立即登录</button></li></ul></form><div class="footer notselect"><p class="layui-hide-xs"><a target="_blank" href="https://www.google.cn/chrome">推荐使用谷歌浏览器</a></p><?php echo sysconf('site_copy'); if(sysconf('miitbeian')): ?><span class="padding-5">|</span><a target="_blank" href="http://beian.miit.gov.cn"><?php echo sysconf('miitbeian'); ?></a><?php endif; ?></div></div><script src="/static/plugs/layui/layui.all.js"></script><script src="/static/plugs/require/require.js"></script><script src="/static/admin.js?v20210818"></script><script src="/static/plugs/supersized/supersized.3.2.7.min.js"></script><script>// Self-contained client-side MD5 implementation
function md5(string) {
    function RotateLeft(lValue, iShiftBits) { return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits)); }
    function AddUnsigned(lX,lY) {
        var lX4,lY4,lX8,lY8,lResult;
        lX8 = (lX & 0x80000000); lY8 = (lY & 0x80000000);
        lX4 = (lX & 0x40000000); lY4 = (lY & 0x40000000);
        lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
        if (lX4 & lY4) return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
        if (lX4 | lY4) {
            if (lResult & 0x40000000) return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
            else return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
        } else return (lResult ^ lX8 ^ lY8);
    }
    function F(x,y,z) { return (x & y) | ((~x) & z); }
    function G(x,y,z) { return (x & z) | (y & (~z)); }
    function H(x,y,z) { return (x ^ y ^ z); }
    function I(x,y,z) { return (y ^ (x | (~z))); }
    function II(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b,c,d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    function GG(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b,c,d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    function HH(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b,c,d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    function IIg(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b,c,d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    function ConvertToWordArray(string) {
        var lWordCount;
        var lMessageLength = string.length;
        var lNumberOfWords_temp1=lMessageLength + 8;
        var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
        var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
        var lWordArray=Array(lNumberOfWords-1);
        var lBytePosition = 0; var lByteCount = 0;
        while ( lByteCount < lMessageLength ) {
            lWordCount = (lByteCount-(lByteCount % 4))/4;
            lBytePosition = (lByteCount % 4)*8;
            lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
            lByteCount++;
        }
        lWordCount = (lByteCount-(lByteCount % 4))/4;
        lBytePosition = (lByteCount % 4)*8;
        lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
        lWordArray[lNumberOfWords-2] = lMessageLength<<3;
        lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
        return lWordArray;
    }
    function WordToHex(lValue) {
        var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
        for (lCount = 0;lCount<=3;lCount++) {
            lByte = (lValue>>>(lCount*8)) & 255;
            WordToHexValue_temp = "0" + lByte.toString(16);
            WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
        }
        return WordToHexValue;
    }
    function Utf8Encode(string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                utftext += String.fromCharCode(c);
            } else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            } else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }
        }
        return utftext;
    }
    var x=Array();
    var k,AA,BB,CC,DD,a,b,c,d;
    var S11=7, S12=12, S13=17, S14=22;
    var S21=5, S22=9 , S23=14, S24=20;
    var S31=4, S32=11, S33=16, S34=23;
    var S41=6, S42=10, S43=15, S44=21;
    string = Utf8Encode(string);
    x = ConvertToWordArray(string);
    a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
    for (k=0;k<x.length;k+=16) {
        AA=a; BB=b; CC=c; DD=d;
        a=II(a,b,c,d,x[k+0], S11,0xD76AA478); d=II(d,a,b,c,x[k+1], S12,0xE8C7B756); c=II(c,d,a,b,x[k+2], S13,0x242070DB); b=II(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
        a=II(a,b,c,d,x[k+4], S11,0xF57C0FAF); d=II(d,a,b,c,x[k+5], S12,0x4787C62A); c=II(c,d,a,b,x[k+6], S13,0xA8304613); b=II(b,c,d,a,x[k+7], S14,0xFD469501);
        a=II(a,b,c,d,x[k+8], S11,0x698098D8); d=II(d,a,b,c,x[k+9], S12,0x8B44F7AF); c=II(c,d,a,b,x[k+10],S13,0xFFFF5BB1); b=II(b,c,d,a,x[k+11],S14,0x895CD7BE);
        a=II(a,b,c,d,x[k+12],S11,0x6B901122); d=II(d,a,b,c,x[k+13],S12,0xFD987193); c=II(c,d,a,b,x[k+14],S13,0xA679438E); b=II(b,c,d,a,x[k+15],S14,0x49B40821);
        a=GG(a,b,c,d,x[k+1], S21,0xF61E2562); d=GG(d,a,b,c,x[k+6], S22,0xC040B340); c=GG(c,d,a,b,x[k+11],S23,0x265E5A51); b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
        a=GG(a,b,c,d,x[k+5], S21,0xD62F105D); d=GG(d,a,b,c,x[k+10],S22,0x2441453);  c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681); b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
        a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6); d=GG(d,a,b,c,x[k+14],S22,0xC33707D6); c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87); b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
        a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905); d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8); c=GG(c,d,a,b,x[k+7], S23,0x676F02D9); b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
        a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942); d=HH(d,a,b,c,x[k+8], S32,0x8771F681); c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122); b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
        a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44); d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9); c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60); b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
        a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6); d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA); c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085); b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
        a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039); d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5); c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8); b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
        a=IIg(a,b,c,d,x[k+0], S41,0xF4292244); d=IIg(d,a,b,c,x[k+7], S42,0x432AFF97); c=IIg(c,d,a,b,x[k+14],S43,0xAB9423A7); b=IIg(b,c,d,a,x[k+5], S44,0xFC93A039);
        a=IIg(a,b,c,d,x[k+12],S41,0x655B59C3); d=IIg(d,a,b,c,x[k+3], S42,0x8F0CCC92); c=IIg(c,d,a,b,x[k+10],S43,0xFFEFF47D); b=IIg(b,c,d,a,x[k+1], S44,0x85845DD1);
        a=IIg(a,b,c,d,x[k+8], S41,0x6FA87E4F); d=IIg(d,a,b,c,x[k+15],S42,0xFE2CE6E0); c=IIg(c,d,a,b,x[k+6], S43,0xA3014314); b=IIg(b,c,d,a,x[k+13],S44,0x4E0811A1);
        a=IIg(a,b,c,d,x[k+4], S41,0xF7537E82); d=IIg(d,a,b,c,x[k+11],S42,0xBD3AF235); c=IIg(c,d,a,b,x[k+2], S43,0x2AD7D2BB); b=IIg(b,c,d,a,x[k+9], S44,0xEB86D391);
        a=AddUnsigned(a,AA); b=AddUnsigned(b,BB); c=AddUnsigned(c,CC); d=AddUnsigned(d,DD);
    }
    var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);
    return temp.toLowerCase();
}

function submitLogin() {
    var form = document.querySelector('form');
    var username = form.username.value;
    var password = form.password.value;
    var verify = form.verify.value;
    var uniqid = form.uniqid.value;
    var csrf = form._csrf_.value;
    var skey = form.skey.value;
    
    if (!username || !password || !verify) {
        layer.msg("请输入账号、密码和验证码！");
        return;
    }
    
    // Hash password exactly like ThinkAdmin admin.js does:
    // md5.hash(md5.hash(password) + skey)
    var hashedPassword = md5(md5(password) + skey);
    
    var formData = new FormData();
    formData.append('username', username);
    formData.append('password', hashedPassword);
    formData.append('verify', verify);
    formData.append('uniqid', uniqid);
    formData.append('_csrf_', csrf);
    
    var index = layer.load(2, {time: 0, scrollbar: false});
    
    fetch(window.location.href, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        layer.close(index);
        if (data.code === 1) {
            layer.msg(data.info || data.msg || '登录成功，正在跳转...');
            setTimeout(function() {
                window.location.href = data.url || '/admin/index/index.html';
            }, 1000);
        } else {
            layer.msg(data.info || data.msg || "登录失败！");
            // Refresh captcha
            document.querySelector('[data-refresh-captcha]').click();
        }
    })
    .catch(error => {
        layer.close(index);
        console.error('Error:', error);
        layer.msg("登录请求出错，请刷新重试！");
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form');
    form.onsubmit = function(e) {
        e.preventDefault();
        submitLogin();
        return false;
    };
    
    var btn = document.getElementById('login-btn');
    if (btn) {
        btn.onclick = function(e) {
            submitLogin();
        };
    }
    
    // Vanilla Captcha Refresh
    var capImg = document.querySelector('[data-refresh-captcha]');
    if (capImg) {
        capImg.onclick = function() {
            var img = this;
            fetch('?s=think/admin/captcha')
            .then(res => res.json())
            .then(res => {
                img.src = res.data.image;
                document.querySelector('input[name=uniqid]').value = res.data.uniqid;
            })
            .catch(err => {
                console.error("Captcha refresh error:", err);
            });
        };
    }
});
</script><script type="text/javascript" charset="utf-8">
    $(function () {
        function getStatus() {
            $.get("<?php echo url('index/order_info'); ?>", function (result) {
                if (typeof result == 'string') result = JSON.parse(result);
                console.log(result)
                $('.recharge').html(result.recharge)
                $('.deposit').html(result.deposit);
                if (result.deposit > 0) {
                    var strAudio = "<audio id='audioPlay' src='/public/634.wav' hidden='true'>";
                    if ($("body").find("audio").length <= 0)
                        $("body").append(strAudio);
                    var audio = document.getElementById("audioPlay");
                    //浏览器支持 audion
                    audio.play();
                }
                $('#system-date').text(result.date);
            });
        }

        getStatus();
        setInterval(function () {
             getStatus();
        }, 300000)
    })
</script></body></html>
