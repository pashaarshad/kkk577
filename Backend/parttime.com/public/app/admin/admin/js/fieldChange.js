function timeChange(value) {
    if (value !== 0) {
        return layui.util.toDateString(value * 1000, "yyyy-MM-dd HH:mm:ss");
    } else return '-';
}

//语言转化和用户状态
function languageAndStatusChange(data, is_only_lang) {
    let lang_data
    switch (data.language) {
        case 'en':
            lang_data = '英语';
            break;
        case 'es':
            lang_data = '西班牙语';
            break;
        case 'ru':
            lang_data = '俄语';
            break;
        case 'de':
            lang_data = '德语';
            break;
        case 'fr':
            lang_data = '法语';
            break;
        case 'it':
            lang_data = '意大利语';
            break;
        case 'pt':
            lang_data = '葡萄牙语';
            break;
        case 'bi':
            lang_data = '印尼语';
            break;
        case 'tr':
            lang_data = '土耳其语';
            break;
        case 'vi':
            lang_data = '越南语';
            break;
        case 'jp':
            lang_data = '日语';
            break;
        case 'ko':
            lang_data = '韩语';
            break;
        case 'zh-TW':
            lang_data = '繁体中文';
            break;
        case 'zh_cn':
            lang_data = '简体中文';
            break;
        case 'fa':
            lang_data = '波斯语';
            break;
        case 'ar':
            lang_data = '阿拉伯语';
            break;
        case 'th':
            lang_data = '泰语';
            break;
        case 'la':
            lang_data = '拉丁文';
            break;
        case 'hi':
            lang_data = '印地语';
            break;
        case 'bn':
            lang_data = '孟加拉文';
            break;
        case 'ur':
            lang_data = '乌尔都语';
            break;
        case 'el':
            lang_data = '希腊文';
            break;
        case 'ms':
            lang_data = '马来语';
            break;
        case 'ka':
            lang_data = '格鲁吉亚语';
            break;
        case 'tk':
            lang_data = '土库曼语';
            break;
        case 'id':
            lang_data = '印度尼西亚语';
            break;
        case 'ja':
            lang_data = '日语';
            break;
        default:
            lang_data = '-'
    }
    if (is_only_lang) {
        return lang_data;
    }

    lang_data += ' ';
    if (!data.status) {//用户状态#1.启用，0.禁用
        lang_data += '<span style="color: red">|禁登</span>';
    }
    if (!data.withdrawal_status) {//提现状态
        lang_data += '<span style="color: red">|禁提</span>';
    }
    if (data.is_upgrade === 1) {//升级做任务状态
        lang_data += '<span style="color: red">|必升</span>';
    }
    if (data.is_invite_do_task === 1) {//升级做任务状态
        lang_data += '<span style="color: red">|邀任</span>';
    }
    if (data.is_invite_extract === 1) {//升级做任务状态
        lang_data += '<span style="color: red">|邀提</span>';
    }
    if (data.is_upgrade_extract === 1) {//升级做任务状态
        lang_data += '<span style="color: red">|升提</span>';
    }
    if (data.plan != null) {//升级做任务状态
        lang_data += '<span style="color: red">|(' + data.plan.name + ')</span>';
    }
    if (data.invest_product_id != '' && data.invest_product_id != null) {//提现买投资
        lang_data += '<span style="color: red">|(提现投资)</span>';
    }
    if (data.is_extract_need_recharge === 1) {//提现补税状态
        lang_data += '<span style="color: red">|补税</span>';
    }
    return lang_data;
}

//推广员信息格式转化
function spreadInfoChange(data, level) {
    var id_array = {'0':'first_spread_uid','1': 'one_spread_uid', '2': 'two_spread_uid', '3': 'third_spread_uid','4':'four_spread_uid','5':'five_spread_uid','6':'six_spread_uid'};
    var name_array = {'0':'firstUser','1': 'userOne', '2': 'userTwo', '3': 'userThree','4':'userFour','5':'userFive','6':'userSix'};
    var s_id = id_array[level];
    var s_name = name_array[level];
    var real_id = '-';
    var real_name = '-';
    if (data[s_id]) {
        real_id = data[s_id];
    }
    if (data[s_name] !== null && data[s_name]['account'] !== null) {
        real_name = data[s_name]['account'];
    }
    return '<a style="color: #1aa094" data-spread-table-info="' + real_id + '">' + real_id + '/' + real_name + '</a>';
}

//在线状态
function onlineStatus(value) {
    if (value === 1) {
        return '<span style="color: mediumseagreen;font-weight: bold ">(在线)</span>'
    } else {
        return '<span style="color: #c8c2b6">(离线)</span>'
    }
}

//会员有效类型
function levelValidTypeChange(value) {
    if (value === 1) {
        return '<span style="color: #3cb3b3;font-weight: bold ">按每24小时次数</span>'
    } else {
        return '<span style="color: #9d3cb3;font-weight: bold ">按总次数</span>'
    }
}

//下级会员状态
function statusChange(value) {
    if (value === 1) {
        return '<span style="color: mediumseagreen;font-weight: bold ">(启用)</span>'
    } else {
        return '<span style="color: #c8c2b6">(禁用)</span>'
    }
}

function userChange(data) {
    var str = '';
    let account = '';
    let add_ip_area = '';
    let first_user = '';
    let one_user = '';
    let first_spread_uid = '';
    let one_spread_uid = '';
    if(data['user'] !== null){
        account = data['user']['account'];
        add_ip_area = data['user']['add_ip_area'];
    }
    if(data['user1'] !== null && data['user1']['firstUser'] !== null){
        first_user = data['user1']['firstUser']['account'];
        first_spread_uid = data['user1']['firstUser']['uid'];
    }
    if(data['user'] !== null && data['user']['userOne'] != null){
        one_user = data['user']['userOne']['account'];
        one_spread_uid = data['user']['userOne']['uid'];
    }

    str = str +
        '<a style="color: #1aa094" data-table-info="' + data['uid'] + '">' + '用户：' + data['uid'] + '/' + account + '</a>' +
        '<li>' + '国家：' + add_ip_area + '</li>' +
        '<li>' + '顶级上级：'+ first_spread_uid + '/' + first_user + '</li>' +
        '<li>' + '一级上级：'+ one_spread_uid + '/' + one_user + '</li>';
    return str;
}

function addressChange(data) {
    var  str= '';
    var recharge_type = '';
    if (data.money_type === 1) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAW9JREFUOE9jZEADQkvq+bj+/4n4z/DfloGBwZbhP8MfBgaG3f///T/FyMK2+2lM4xNkLYzIHMlFVe6MDIy9jAz/tdENhvLfMjAwLHoa11YEk4cbIL2oeisDw38vHBoxhJ/GtYH1ggmZRZWp/xkYZxGrGaTuPwND5LO4thWMUssaRBj//DrNwMCgAJJY7ZbCYCmuiNWs4y/vM4TumgOTe8D467sxo9SCykRGJsZ5MFGQATAAMwikEQaQDGBgZGRMZ5ReVDWdgYEhA5uVT2JbwcIyi6ux+46RYQnIgDsMDAzKIBUrXZMZrCWU8AbF0Rf3GMJ3z4WoYWR4iGLAMpdEBkMRWYbJlw8wvP/5jcFaEmwuw9HndxkE2bkYcnUdGM6/ecwQtWc+igEYXuBmYWNQFRBj2OKZCVbos306w71Pbxg+/fqB6jqQF9ADEVkFoTAAByJ6NJJgACQa8SUkfC6AJySYjRQlZZghFGUmmCGkZmcAmRGbrUm+nq0AAAAASUVORK5CYII="><span style="color: #8338ec">TRC20-USDT</span>';
    } else if(data.money_type === 2) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAcRJREFUOE+lk01IVGEUhp9jkndKSURmRgmMKO+MQe7a1S7CQNrUbhY1ELSQdupKolWMBOJCBEOcoCIIKpJatAlxJ7jqZxwCGSKdO5I/NY1e0ebEvXjHO9fcNGf1wXfO8533nPcTagwJ1meb2lt1tzyI6HlVugX+APOgGdW68bht5fw1VYCs0XZRpfwaaDmksZKq9MVtK+3dVwAZI3pTRKciIw9YHR5lN28dKk607pJp52edBBeQMaKnRPQTcNws5VHbRkIhyr+KrI9PsjGRDgLXpP6IaRaXf7iAhVA4BTLgnBt7LhMZTWHdHQBVmpMJGnt73G6yx6K+ruRhbMvq3wNE3gC93q25abH98TP5ZB9iNNAx847iy2marl/bhwjvY5uFKx5gCWj3AGeWFvh+9QZtTyaoj4QpvnjFiVsJlhO3XZATCoX4ViH6T0DDuTgnp5+z83WRtZExmu8kKf8uuQAvgoAqCU6SI+Nn+ikbj5/R8eFtQL87fr+E/SF6L5z+Mofa2xyNnWWx6wI7uW+BtfqG6F9jxSAhg87VHCv9Q6yPPQp6onqNe15wjeTPDKfuszJ474ChDhjJy6jJyhVILZ/pf372X9ShzhGtQ6vwAAAAAElFTkSuQmCC"><span style="color: #99d98c">TRX</span>';
    } else if (data.money_type === 3) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAIHUExURVCvlVGwllCvlE+wmAAAAFC2nVCwl06xmE2znk+vlE6fdBEMAAAAAQZ7FlGwllOwllOwl1CvlVCvlU+ulE6ulFCvlVCvlFCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCwllCvlVCvlVCvlUSCY1Csj1CvlVCvlQwPAR80BVCvlVCvlQ0iBVCvlVCvlU+ulBAjBlCvlVCvlVSxlwQlBlGvlVCvlU6ulE+wlkJ4WAkMAAAQAwNCC1CvlVCvlVuxgSM7BwogBAweBQIiBQNDCwemHkytkkuskieWFA5vEA6WFVGvlWO4oGq7pWm7pFWxmMbl3fP6+PH49u/49cjm3lCvlVSxl7Hbz9Xs5djt5/v9/Pv9/djt6NTs5bLc0FSxmE+vlVeymVu0nHC+qez29O339HK+qnC9qGO4oV21nW+9qOz39HC+qFaymYfItn3DsHG+qXfBrcHj2cHj2njBrXHAq37CrojCr1ewl1Gwlma5onzDsOHx7eLy7n3EsGOVfkNOPSszIjBKNE2uk+v28+z49WCSexoYDhoSAntfFyofBk+ulGS4oe718UtOPwgEAHhfGJ17IIptHBIPBN/x7OHp5Dw3KldFEEs8EHNcGEk7D2FNFGu8pm25ojJGMhUPAnlfGYttHIVpGx8ZByohCZl3Hz4wDf///17AECAAAABQdFJOUwAAAAAAAAAAAAAAAAAABBsdSNTZ2UkIr7BD8vNEBqSl7O20tcD+wR+uyyQXqOpaE6HUEJr++A2T/dsLi/z6tuzyaQiBDVG5175aBAQECxsNBTOPxAAAAAFiS0dErFdl8osAAAAHdElNRQfoBgcCJCt6hDLeAAABCUlEQVQY02NgYOTjF4ACfj5GBiAQFBIWAQNhIVEgl0lMPCAwKBgIggIDJMSAIpJSIaFh4RER4WGRIdIyDAyyclHRMbFx8QmJSckpUfKyDJIKUalp6RmZWdnpaalRijIMSlHRObl5+QVZhXm5GSlRygwqUUXFJaVl5RWVVdU1tapqDOoaUXV59Q2NTc0trW3tmloMDNo6UakdgZ1d3T29ff26ekB79Q2iJkzsnDR5ytRp02cYMjAzMBgZmwTOnDV7ztx58xeYMrCwMjCYmVssXLR4ydJly1dYMrCwsDEwWFnb2NrZr1y12sERKMDCzsDg5Ozs4urm7uHpBRJg4WDg9Pbh4vb18+fhBQD2aEdkZKLOdwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyNC0wNi0wN1QwMjozNjozNSswMDowMBgPjd0AAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjQtMDYtMDdUMDI6MzY6MzUrMDA6MDBpUjVhAAAAKHRFWHRkYXRlOnRpbWVzdGFtcAAyMDI0LTA2LTA3VDAyOjM2OjQzKzAwOjAwV1IonQAAAABJRU5ErkJggg=="><span style="color: rgba(166,160,74,0.89)">BEP20-USDT</span>'
    } else if (data.money_type === 4) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAPhJREFUOE+tUysSwjAQzVYgUCh0U4NCokkP0EsgmAHLASgHQOM4BZ6iOQGm7REwNYgubIZ0NplAgbKqeZ197+0PhBNhGKogCBQiTp+/lBAiA4BTXddZWZYZTwH+iKIoRcQ1xyajmzhfeg0EAJs8z1MDNAS+5P3qKohgth1YJOSoKIqYSDTBu2Sj5JIYJ5pASonctlEmjOyTCwqXBBFjcNWXSSUWSWUlcMLxfMi1MovANIwSdod+o04ufJiejpTy+PhQvoZ9gv2PgAr7qQTaPACgMnR800QaZfcxkqrrgjA+Ot8OWIvUto2tq2zq73RM7lXSm13my3O+A/1e72H0cdWdAAAAAElFTkSuQmCC"><span style="color: #08070a">BNB</span>'
    } else if (data.money_type === 5) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAUBJREFUOE+tUzFSw0AMlNKHB5AuFPgDMSXODPkGLY3LkJbQBso0tHyDzGBK7A+YgnThAaTPMXuxbtaCEjV3OulWqz2dirNs3hQyOBQh6GUXKlTDPfbt6mLp85UPssX7MgS980nsA4yBEgBfLmcjqbffUn/u4938bBhX8xkkAvjL5exUrp/aHkB5NYogOIcZSAQ4v60D1uebTOrtXtYvu1Q5H58kH8xgFtegU7XqoIkqVgHJYALa680useEiYJEAEODEdjWRbNHEiogxcD4eml+p0ccF7hu+r26vQeAR4FVECq5oidYWVmODPRiZnwC4N68Hs+NYTwOvsIl4VP0rKc9aHQHmTRE0oA35C4SfDXESUD4ecu0NktHjgTE9jJEJ3RskP41+dH8NEP2H//tM/lfC735m1c3+mxwGVfs4ib7ZDwuW+xwvXGWtAAAAAElFTkSuQmCC"><span style="color: #08070a">BEP20-USDC</span>'
    } else if (data.money_type === 6) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAKWSURBVHgBzVe/T9tAGH1nMTG5Uv8AM7VboWsrJQzMDVuZCO1aKUx0bFi7kEhd24aJsTAzBIbOtBtM+A9AwlNGwvd8d8QxdnxxbMSTHDu+8733/bjv7hQc0cbY94CWPDbGwKrcA7l80xzJFSrgn9zP74DjAVTkMq4q6iDEgRB3xnycELoMPBAh+yIkLOiXS0yLvwnxLhaAEPSMkCinPZM8kIYhtJurQCiGrGd5w8sgX62YnIgN4tjpBpUiD2ogT+KRJ1SC3Jc/FzWSJ0Ws2Zx4CAET7gnIicBwxYg9YFx/jSeEeGGFoYg9kFRUFhsdoCsBfNd266/M9FYm9rcoiVdN4IPIf92cvLsJge/r+j4DEb3gmfJaClsHwNehJh9JSp32NenLQARIQD/9nvl5XNoZggZKYsPUSBLvrQBHu9ryv4f6/ft24RANzywsTqC7v/zRFiZB4pEptPTAzzacQO4lOEy9ZV/H2Vr8tqUtrgCckrNXOGY342nJL89QJfyloh5bvQnxyT5wdaZDMEqsbfQQL7qfYWJyuoICOFThOs/kskhPL5LTSxRppyMFUnABIgoIMUcizoIl56w46U57KQchBfxfVAA9wqT8eKDJGSYXcAvnyY9TdxYVO/3o8nScKeLHpjs5ITulc1uKuRBl5sHngdT37QnJxbGu98umNy0+KrlpkzrwIl4NdzBmrnfyOtLyveF0AUrOijLgpvUX1M5cyzEtZ11gqT3tYSHY5fhhR1TkhSoh5H0hjwPnJV52oadk3QihuTAlgHs0bhhRrwi7KY0eCTAi2GGzJhHx2OmzwfM7mBDGE2vy2MeCYMKZbXiY1e50OFU6abbhDsb4UIh7pQ+nGUJY+1ryQVPub5BzPGd5xRzH83vtWeeOovqPLgAAAABJRU5ErkJggg=="><span style="color: rgba(166,160,74,0.89)">Polygon-USDT</span>';
    } else if (data.money_type === 7) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iMzYwIiBoZWlnaHQ9IjM2MCIgdmlld0JveD0iMCAwIDM2MCAzNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzNjAiIGhlaWdodD0iMzYwIiBmaWxsPSIjNjI3RUVBIi8+CjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yNTkwXzQ1MjMyKSI+CjxwYXRoIGQ9Ik0xODAgMzMwQzI2Mi44NDMgMzMwIDMzMCAyNjIuODQzIDMzMCAxODBDMzMwIDk3LjE1NzMgMjYyLjg0MyAzMCAxODAgMzBDOTcuMTU3MyAzMCAzMCA5Ny4xNTczIDMwIDE4MEMzMCAyNjIuODQzIDk3LjE1NzMgMzMwIDE4MCAzMzBaIiBmaWxsPSIjNjI3RUVBIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDY3LjVWMTUwLjY1NkwyNTQuOTUzIDE4Mi4wNjJMMTg0LjY2OSA2Ny41WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgNjcuNUwxMTQuMzc1IDE4Mi4wNjJMMTg0LjY2OSAxNTAuNjU2VjY3LjVaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTg0LjY2OSAyMzUuOTVWMjkyLjQ1NEwyNTUgMTk1LjE1TDE4NC42NjkgMjM1Ljk1WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgMjkyLjQ1NFYyMzUuOTQxTDExNC4zNzUgMTk1LjE1TDE4NC42NjkgMjkyLjQ1NFoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDIyMi44NzNMMjU0Ljk1MyAxODIuMDYzTDE4NC42NjkgMTUwLjY3NlYyMjIuODczWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+CjxwYXRoIGQ9Ik0xMTQuMzc1IDE4Mi4wNjNMMTg0LjY2OSAyMjIuODczVjE1MC42NzZMMTE0LjM3NSAxODIuMDYzWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yNTkwXzQ1MjMyIj4KPHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMCAzMCkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K"><span style="color:rgba(7, 124, 7, 0.91)">ETH-USDT</span>';
    } else if (data.money_type === 8) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAKWSURBVHgBzVe/T9tAGH1nMTG5Uv8AM7VboWsrJQzMDVuZCO1aKUx0bFi7kEhd24aJsTAzBIbOtBtM+A9AwlNGwvd8d8QxdnxxbMSTHDu+8733/bjv7hQc0cbY94CWPDbGwKrcA7l80xzJFSrgn9zP74DjAVTkMq4q6iDEgRB3xnycELoMPBAh+yIkLOiXS0yLvwnxLhaAEPSMkCinPZM8kIYhtJurQCiGrGd5w8sgX62YnIgN4tjpBpUiD2ogT+KRJ1SC3Jc/FzWSJ0Ws2Zx4CAET7gnIicBwxYg9YFx/jSeEeGGFoYg9kFRUFhsdoCsBfNd266/M9FYm9rcoiVdN4IPIf92cvLsJge/r+j4DEb3gmfJaClsHwNehJh9JSp32NenLQARIQD/9nvl5XNoZggZKYsPUSBLvrQBHu9ryv4f6/ft24RANzywsTqC7v/zRFiZB4pEptPTAzzacQO4lOEy9ZV/H2Vr8tqUtrgCckrNXOGY342nJL89QJfyloh5bvQnxyT5wdaZDMEqsbfQQL7qfYWJyuoICOFThOs/kskhPL5LTSxRppyMFUnABIgoIMUcizoIl56w46U57KQchBfxfVAA9wqT8eKDJGSYXcAvnyY9TdxYVO/3o8nScKeLHpjs5ITulc1uKuRBl5sHngdT37QnJxbGu98umNy0+KrlpkzrwIl4NdzBmrnfyOtLyveF0AUrOijLgpvUX1M5cyzEtZ11gqT3tYSHY5fhhR1TkhSoh5H0hjwPnJV52oadk3QihuTAlgHs0bhhRrwi7KY0eCTAi2GGzJhHx2OmzwfM7mBDGE2vy2MeCYMKZbXiY1e50OFU6abbhDsb4UIh7pQ+nGUJY+1ryQVPub5BzPGd5xRzH83vtWeeOovqPLgAAAABJRU5ErkJggg=="><span style="color:rgb(143, 97, 234)">Polygon-USDC</span>'
    } else if (data.money_type === 9) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iMzYwIiBoZWlnaHQ9IjM2MCIgdmlld0JveD0iMCAwIDM2MCAzNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzNjAiIGhlaWdodD0iMzYwIiBmaWxsPSIjNjI3RUVBIi8+CjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yNTkwXzQ1MjMyKSI+CjxwYXRoIGQ9Ik0xODAgMzMwQzI2Mi44NDMgMzMwIDMzMCAyNjIuODQzIDMzMCAxODBDMzMwIDk3LjE1NzMgMjYyLjg0MyAzMCAxODAgMzBDOTcuMTU3MyAzMCAzMCA5Ny4xNTczIDMwIDE4MEMzMCAyNjIuODQzIDk3LjE1NzMgMzMwIDE4MCAzMzBaIiBmaWxsPSIjNjI3RUVBIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDY3LjVWMTUwLjY1NkwyNTQuOTUzIDE4Mi4wNjJMMTg0LjY2OSA2Ny41WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgNjcuNUwxMTQuMzc1IDE4Mi4wNjJMMTg0LjY2OSAxNTAuNjU2VjY3LjVaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTg0LjY2OSAyMzUuOTVWMjkyLjQ1NEwyNTUgMTk1LjE1TDE4NC42NjkgMjM1Ljk1WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgMjkyLjQ1NFYyMzUuOTQxTDExNC4zNzUgMTk1LjE1TDE4NC42NjkgMjkyLjQ1NFoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDIyMi44NzNMMjU0Ljk1MyAxODIuMDYzTDE4NC42NjkgMTUwLjY3NlYyMjIuODczWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+CjxwYXRoIGQ9Ik0xMTQuMzc1IDE4Mi4wNjNMMTg0LjY2OSAyMjIuODczVjE1MC42NzZMMTE0LjM3NSAxODIuMDYzWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yNTkwXzQ1MjMyIj4KPHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMCAzMCkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K"><span style="color:rgb(103, 47, 215)">ETH-USDC</span>'
    } else if (data.money_type === 10) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iMzYwIiBoZWlnaHQ9IjM2MCIgdmlld0JveD0iMCAwIDM2MCAzNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzNjAiIGhlaWdodD0iMzYwIiBmaWxsPSIjNjI3RUVBIi8+CjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yNTkwXzQ1MjMyKSI+CjxwYXRoIGQ9Ik0xODAgMzMwQzI2Mi44NDMgMzMwIDMzMCAyNjIuODQzIDMzMCAxODBDMzMwIDk3LjE1NzMgMjYyLjg0MyAzMCAxODAgMzBDOTcuMTU3MyAzMCAzMCA5Ny4xNTczIDMwIDE4MEMzMCAyNjIuODQzIDk3LjE1NzMgMzMwIDE4MCAzMzBaIiBmaWxsPSIjNjI3RUVBIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDY3LjVWMTUwLjY1NkwyNTQuOTUzIDE4Mi4wNjJMMTg0LjY2OSA2Ny41WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgNjcuNUwxMTQuMzc1IDE4Mi4wNjJMMTg0LjY2OSAxNTAuNjU2VjY3LjVaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTg0LjY2OSAyMzUuOTVWMjkyLjQ1NEwyNTUgMTk1LjE1TDE4NC42NjkgMjM1Ljk1WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgMjkyLjQ1NFYyMzUuOTQxTDExNC4zNzUgMTk1LjE1TDE4NC42NjkgMjkyLjQ1NFoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDIyMi44NzNMMjU0Ljk1MyAxODIuMDYzTDE4NC42NjkgMTUwLjY3NlYyMjIuODczWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+CjxwYXRoIGQ9Ik0xMTQuMzc1IDE4Mi4wNjNMMTg0LjY2OSAyMjIuODczVjE1MC42NzZMMTE0LjM3NSAxODIuMDYzWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yNTkwXzQ1MjMyIj4KPHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMCAzMCkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K"><span style="color:rgb(103, 47, 215)">ETH</span>'
    } else if (data.money_type === 11) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAKWSURBVHgBzVe/T9tAGH1nMTG5Uv8AM7VboWsrJQzMDVuZCO1aKUx0bFi7kEhd24aJsTAzBIbOtBtM+A9AwlNGwvd8d8QxdnxxbMSTHDu+8733/bjv7hQc0cbY94CWPDbGwKrcA7l80xzJFSrgn9zP74DjAVTkMq4q6iDEgRB3xnycELoMPBAh+yIkLOiXS0yLvwnxLhaAEPSMkCinPZM8kIYhtJurQCiGrGd5w8sgX62YnIgN4tjpBpUiD2ogT+KRJ1SC3Jc/FzWSJ0Ws2Zx4CAET7gnIicBwxYg9YFx/jSeEeGGFoYg9kFRUFhsdoCsBfNd266/M9FYm9rcoiVdN4IPIf92cvLsJge/r+j4DEb3gmfJaClsHwNehJh9JSp32NenLQARIQD/9nvl5XNoZggZKYsPUSBLvrQBHu9ryv4f6/ft24RANzywsTqC7v/zRFiZB4pEptPTAzzacQO4lOEy9ZV/H2Vr8tqUtrgCckrNXOGY342nJL89QJfyloh5bvQnxyT5wdaZDMEqsbfQQL7qfYWJyuoICOFThOs/kskhPL5LTSxRppyMFUnABIgoIMUcizoIl56w46U57KQchBfxfVAA9wqT8eKDJGSYXcAvnyY9TdxYVO/3o8nScKeLHpjs5ITulc1uKuRBl5sHngdT37QnJxbGu98umNy0+KrlpkzrwIl4NdzBmrnfyOtLyveF0AUrOijLgpvUX1M5cyzEtZ11gqT3tYSHY5fhhR1TkhSoh5H0hjwPnJV52oadk3QihuTAlgHs0bhhRrwi7KY0eCTAi2GGzJhHx2OmzwfM7mBDGE2vy2MeCYMKZbXiY1e50OFU6abbhDsb4UIh7pQ+nGUJY+1ryQVPub5BzPGd5xRzH83vtWeeOovqPLgAAAABJRU5ErkJggg=="><span style="color:rgb(143, 97, 234)">POLYGON</span>'
    } else if (data.money_type === 12) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iMzYwIiBoZWlnaHQ9IjM2MCIgdmlld0JveD0iMCAwIDM2MCAzNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzNjAiIGhlaWdodD0iMzYwIiBmaWxsPSIjNjI3RUVBIi8+CjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yNTkwXzQ1MjMyKSI+CjxwYXRoIGQ9Ik0xODAgMzMwQzI2Mi44NDMgMzMwIDMzMCAyNjIuODQzIDMzMCAxODBDMzMwIDk3LjE1NzMgMjYyLjg0MyAzMCAxODAgMzBDOTcuMTU3MyAzMCAzMCA5Ny4xNTczIDMwIDE4MEMzMCAyNjIuODQzIDk3LjE1NzMgMzMwIDE4MCAzMzBaIiBmaWxsPSIjNjI3RUVBIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDY3LjVWMTUwLjY1NkwyNTQuOTUzIDE4Mi4wNjJMMTg0LjY2OSA2Ny41WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgNjcuNUwxMTQuMzc1IDE4Mi4wNjJMMTg0LjY2OSAxNTAuNjU2VjY3LjVaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTg0LjY2OSAyMzUuOTVWMjkyLjQ1NEwyNTUgMTk1LjE1TDE4NC42NjkgMjM1Ljk1WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgMjkyLjQ1NFYyMzUuOTQxTDExNC4zNzUgMTk1LjE1TDE4NC42NjkgMjkyLjQ1NFoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDIyMi44NzNMMjU0Ljk1MyAxODIuMDYzTDE4NC42NjkgMTUwLjY3NlYyMjIuODczWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+CjxwYXRoIGQ9Ik0xMTQuMzc1IDE4Mi4wNjNMMTg0LjY2OSAyMjIuODczVjE1MC42NzZMMTE0LjM3NSAxODIuMDYzWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yNTkwXzQ1MjMyIj4KPHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMCAzMCkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K"><span style="color:rgb(103, 47, 215)">ETH-PYUSD</span>'
    } else if(data.money_type === 21){
        recharge_type = 'BRL';
    } else if(data.money_type === 22){
        recharge_type = 'BRL';
    } else if(data.money_type === 32){
        recharge_type = 'PHP';
    } else if(data.money_type === 50){
        recharge_type = 'BRL1';
    } else if(data.money_type === 51){
        recharge_type = 'BRL2';
    } else if(data.money_type === 52){
        recharge_type = 'BRL3';
    } else if(data.money_type === 53){
        recharge_type = 'BRL4';
    } else if(data.money_type === 54){
        recharge_type = 'BRL(amaspay)';
    } else if(data.money_type === 55){
        recharge_type = 'IDR(jytpay)';
    } else if(data.money_type === 56){
        recharge_type = 'BRL(chzfpay)';
    } else if(data.money_type === 57){
        recharge_type = 'VND(qfpay)';
    } else if(data.money_type === 58){
        recharge_type = 'VND(dayangpay)';
    } else if(data.money_type === 59){
        recharge_type = 'BRL(dayangpay)';
    } else if(data.money_type === 60){
        recharge_type = 'BDT(zenithpay)';
    } else if(data.money_type === 61){
        recharge_type = 'BRL(zenithpay)';
    } else if(data.money_type === 62){
        recharge_type = 'IDR(wowpay)';
    } else if(data.money_type === 63){
        recharge_type = 'IDR(klysnvpay)';
    } else if(data.money_type === 64){
        recharge_type = 'BDT(jytpay)';
    } else if(data.money_type === 65){
        recharge_type = 'BDT(h88pay)';
    } else if(data.money_type === 66){
        recharge_type = 'VND(ttpay)';
    } else if(data.money_type === 67){
        recharge_type = 'BDT(mgmpay)';
    } else if(data.money_type === 68){
        recharge_type = 'VND(vortaqpay)';
    } else if(data.money_type === 69){
        recharge_type = 'VND(nxpay)';
    } else if(data.money_type === 70){
        recharge_type = 'PHP(jytpay)';
    } else if(data.money_type === 71){
        recharge_type = 'PHP(pandapay)';
    } else if(data.money_type === 72){
        recharge_type = 'BDT(vortaqpay)';
    } else if(data.money_type === 73){
        recharge_type = 'ZAR(mgmpay)';
    } else if(data.money_type === 74){
        recharge_type = 'IDR(vortaqpay)';
    } else if(data.money_type === 75){
        recharge_type = 'MYR(vortaqpay)';
    } else if(data.money_type === 76){
        recharge_type = 'BRL(brlcpay)';
    } else if(data.money_type === 77){
        recharge_type = 'PHP(vortaqpay)';
    } else if(data.money_type === 78){
        recharge_type = 'MYR(gctpkpay)';
    } else if(data.money_type === 79){
        recharge_type = 'MXN(mgmpay)';
    } else if(data.money_type === 80){
        recharge_type = 'BRL(vortaqpay)';
    } else if(data.money_type === 81){
        recharge_type = 'VND(nekpay)';
    } else if(data.money_type === 82){
        recharge_type = 'NGN(vortaqpay)';
    } else if(data.money_type === 83){
        recharge_type = 'NGN(shpays)';
    } else if(data.money_type === 84){
        recharge_type = 'PEN(vortaqpay)';
    } else if(data.money_type === 85){
        recharge_type = 'COP(vortaqpay)';
    } else if(data.money_type === 86){
        recharge_type = 'NGN(mgmpay)';
    } else if(data.money_type === 87){
        recharge_type = 'NGN(hpay)';
    } else if(data.money_type === 88){
        recharge_type = 'CDF(ezpay)';
    } else if(data.money_type === 89){
        recharge_type = 'GHS(simpay)';
    } else if(data.money_type === 90){
        recharge_type = 'XAF(simpay)';
    } else if(data.money_type === 91){
        recharge_type = 'IDR(nekpay)';
    } else if(data.money_type === 92){
        recharge_type = 'MXN(vortaqpay)';
    } else if(data.money_type === 93){
        recharge_type = 'IDR(watchpay)';
    } else if(data.money_type === 94){
        recharge_type = 'GTQ(xpay)';
    } else if(data.money_type === 95){
        recharge_type = 'COP(gctpkpay)';
    } else if(data.money_type === 96){
        recharge_type = 'ZAR(gctpkpay)';
    } else if(data.money_type === 97){
        recharge_type = 'MXN(gctpkpay)';
    } else if(data.money_type === 98){
        recharge_type = 'XAF(hipay)';
    } else if(data.money_type === 99){
        recharge_type = 'PHP(bpay)';
    } else if(data.money_type === 100){
        recharge_type = 'PHP(gctpkpay)';
    } else if(data.money_type === 101){
        recharge_type = 'PHP(yunpay)';
    } else if(data.money_type === 102){
        recharge_type = 'BOB(yfpay)';
    } else if(data.money_type === 103){
        recharge_type = 'PHP(mgmPay)';
    } else if(data.money_type === 104){
        recharge_type = 'PHP(wgepay)';
    } else if(data.money_type === 105){
        recharge_type = 'ZMW(ezpay)';
    } else if(data.money_type === 108){
        recharge_type = 'UZS(nicepay)';
    } else if(data.money_type === 109){
        recharge_type = 'ARS(gctpkpay)';
    } else if(data.money_type === 110){
        recharge_type = 'XOF(gctpkpay)';
    } else if(data.money_type === 112){
        recharge_type = 'GHS(ezpay)';
    } else if(data.money_type === 113){
        recharge_type = 'GHS(ppay)';
    } else if(data.money_type === 114){
        recharge_type = 'XOF(nicepay)';
    } else if(data.money_type === 115){
        recharge_type = 'INR(allpay)';
    } else if(data.money_type === 116){
        recharge_type = 'ARS(sunpay)';
    } else if(data.money_type === 117){
        recharge_type = 'GHS(hipay)';
    } else if(data.money_type === 118){
        recharge_type = 'COP(eaPay)';
    } else if(data.money_type === 119){
        recharge_type = 'VND(wstpay)';
    } else if(data.money_type === 120){
        recharge_type = 'PKR(vortaqpay)';
    } else if(data.money_type === 121){
        recharge_type = 'INR(nicepay)';
    } else if(data.money_type === 122){
        recharge_type = 'PHP(smtmPay)';
    } else if(data.money_type === 123){
        recharge_type = 'XAF(hipay2)';
    } else if(data.money_type === 124){
        recharge_type = 'VND(wgepay)';
    } else if(data.money_type === 125){
        recharge_type = 'IDR(gctpkpay)';
    } else if(data.money_type === 126){
        recharge_type = 'PEN(whtPay)';
    } else if(data.money_type === 127){
        recharge_type = 'BDT(hipay)';
    } else if(data.money_type === 128){
        recharge_type = 'EGP(apay)';
    } else if(data.money_type === 129){
        recharge_type = 'TZS(hipay)';
    } else if(data.money_type === 130){
        recharge_type = 'KES(ezpay)';
    } else if(data.money_type === 131){
        recharge_type = 'VND(clickpay)';
    } else if(data.money_type === 132){
        recharge_type = 'EGP(ppay)';
    } else if(data.money_type === 133){
        recharge_type = 'XOF(hypay)';
    } else if(data.money_type === 134){
        recharge_type = 'BRL(gctpkpay)';
    } else if(data.money_type === 135){
        recharge_type = 'NGN(instantpay)';
    } else if(data.money_type === 136){
        recharge_type = 'LRD(ezpay)';
    } else if(data.money_type === 137){
        recharge_type = 'RWF(ezpay)';
    } else if(data.money_type === 138){
        recharge_type = 'PEN(hyPay)';
    } else if(data.money_type === 139){
        recharge_type = 'MXN(fzPay)';
    } else if(data.money_type === 140){
        recharge_type = 'BRL(h88pay)';
    } else if(data.money_type === 141){
        recharge_type = 'VND(gotoopay)';
    } else if(data.money_type === 142){
        recharge_type = 'SYP(wtpay)';
    } else if(data.money_type === 143){
        recharge_type = 'COP(nekpay)';
    } else if(data.money_type === 144){
        recharge_type = 'BRL(lwPay)';
    } else if(data.money_type === 145){
        recharge_type = 'VND(bwtPay)';
    } else if(data.money_type === 146){
        recharge_type = 'BDT(nekpay)';
    } else if(data.money_type === 147){
        recharge_type = 'BDT(axpay)';
    } else if(data.money_type === 148){
        recharge_type = 'XOF(kkpay)';
    } else if(data.money_type === 149){
        recharge_type = 'PHP(nicepay)';
    } else if(data.money_type === 150){
        recharge_type = 'CDF(hipay)';
    } else if(data.money_type === 151){
        recharge_type = 'PHP(htpay)';
    } else if(data.money_type === 152){
        recharge_type = 'USD(nicepay)';
    } else if(data.money_type === 153){
        recharge_type = 'XOF(allpay)';
    } else if(data.money_type === 154){
        recharge_type = 'MAD(upay)';
    } else if(data.money_type === 155){
        recharge_type = 'NGN(gctpkpay)';
    } else if(data.money_type === 156){
        recharge_type = 'PHP(sqpay)';
    } else if(data.money_type === 157){
        recharge_type = 'NGN(kkpay)';
    } else if(data.money_type === 158){
        recharge_type = 'XAF(dzxumPay)';
    } else if(data.money_type === 159){
        recharge_type = 'NGN(lpPay)';
    } else if(data.money_type === 160){
        recharge_type = 'NGN(dailypay)';
    } else if(data.money_type === 161){
        recharge_type = 'PKR(gopay)';
    } else if(data.money_type === 162){
        recharge_type = 'MXN(toppay)';
    } else if(data.money_type === 163){
        recharge_type = 'VND(novolinkpay)';
    } else if(data.money_type === 164){
        recharge_type = 'MXN(ppay)';
    } else if(data.money_type === 165){
        recharge_type = 'VND(dzxumPay)';
    } else if(data.money_type === 166){
        recharge_type = 'GHS(allpay)';
    } else if(data.money_type === 167){
        recharge_type = 'MXN(lpPay)';
    } else if(data.money_type === 168){
        recharge_type = 'PHP(jiefupay)';
    } else if(data.money_type === 169){
        recharge_type = 'AOA(jackpay)';
    } else if(data.money_type === 170){
        recharge_type = 'XOF(nekpay)';
    } else if(data.money_type === 171){
        recharge_type = 'ETB(jackpay)';
    } else if(data.money_type === 172){
        recharge_type = 'IDR(akepay)';
    } else if(data.money_type === 173){
        recharge_type = 'NGN(dzxumPay)';
    } else if(data.money_type === 174){
        recharge_type = 'CDF(nekpay)';
    } else if(data.money_type === 175){
        recharge_type = 'VND(dayangPay)';
    } else if(data.money_type === 178){
        recharge_type = 'VND(q8pay)';
    } else if(data.money_type === 176){
        recharge_type = 'PKR(lpay)';
    } else if(data.money_type === 177){
        recharge_type = 'XOF(ppay)';
    } else if(data.money_type === 179){
        recharge_type = 'XOF(dzxumPay)';
    } else if(data.money_type === 180){
        recharge_type = 'XAF(ppay)';
    } else if(data.money_type === 181){
        recharge_type = 'INR(gctpkpay)';
    } else if(data.money_type === 182){
        recharge_type = 'IDR(lpay)';
    } else if(data.money_type === 111){
        recharge_type = 'PEN(mgmPay)';
    }
    if(data.money_type === 21 || data.money_type === 22){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'CPF号：'+data['bc_cpf']+'</li>'+
            '<li>'+'开户名：'+data['bank_account_name']+'</li>'+
            '<li>'+'PIX税号：'+data['bank_card_number']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    }else if(data.money_type >= 50 && data.money_type <=53){
        // let money_type = '';
        // if(data.money_type == 50){
        //     money_type = 'dcpay1';
        // }else if(data.money_type == 51){
        //     money_type = 'dcpay2';
        // }else if(data.money_type == 52){
        //     money_type = 'dcpay3';
        // }else if(data.money_type == 53){
        //     money_type = 'dcpay4';
        // }
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'PIX类型：'+data['bank_name']+'</li>'+
            '<li>'+'提款账户：'+data['bc_cpf']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    }else if(data.money_type == 54 || data.money_type == 56 || data.money_type == 76 || data.money_type == 80){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'PIX类型：'+data['bank_name']+'</li>'+
            '<li>'+'用户姓名：'+data['bank_account_name']+'</li>'+
            '<li>'+'提款账户：'+data['bc_cpf']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    }else if(data.money_type == 59 || data.money_type == 134 || data.money_type == 140 || data.money_type == 144){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'账户类型：'+data['bank_name']+'</li>'+
            '<li>'+'证件号码：'+data['bc_cpf']+'</li>'+
            '<li>'+'收款人姓名：'+data['bank_account_name']+'</li>'+
            '<li>'+'收款人账户：'+data['bank_card_number']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else if(data.money_type == 126 || data.money_type == 111){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'银行编码：'+data['bank_name']+'</li>'+
            '<li>'+'收款账号：'+data['bank_card_number']+'</li>'+
            '<li>'+'用户名：'+data['bank_account_name']+'</li>'+
            '<li>'+'证件号：'+data['bc_cpf']+'</li>'+
            '<li>'+'CCI：'+data['bl_cci']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else if(data.money_type === 60){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'通道类型：'+data['bank_name']+'</li>'+
            '<li>'+'收款人姓名：'+data['bank_account_name']+'</li>'+
            '<li>'+'收款人账户：'+data['bank_card_number']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else if(data.money_type == 61){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'账户类型：'+data['bank_name']+'</li>'+
            '<li>'+'证件号码：'+data['bc_cpf']+'</li>'+
            // '<li>'+'收款人姓名：'+data['bank_account_name']+'</li>'+
            '<li>'+'收款人账户：'+data['bank_card_number']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else if(data.money_type == 84 || data.money_type == 95){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'银行编码：'+data['bank_name']+'</li>'+
            '<li>'+'身份证：'+data['bc_cpf']+'</li>'+
            '<li>'+'收款人姓名：'+data['bank_account_name']+'</li>'+
            '<li>'+'收款人账户：'+data['bank_card_number']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else if(data.money_type == 109){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'银行名称：'+data['bank_name']+'</li>'+
            '<li>'+'个人身份ID：'+data['bc_cpf']+'</li>'+
            '<li>'+'收款人姓名：'+data['bank_account_name']+'</li>'+
            '<li>'+'收款人账户：'+data['bank_card_number']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else if(data.money_type == 115 || data.money_type == 121){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'IFSC码：'+data['bc_cpf']+'</li>'+
            '<li>'+'收款人姓名：'+data['bank_account_name']+'</li>'+
            '<li>'+'收款人账户：'+data['bank_card_number']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else if(data.money_type == 116 || data.money_type == 128 || data.money_type == 130 || data.money_type == 132 || data.money_type == 136 || data.money_type == 137 || data.money_type == 153){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'收款人姓名：'+data['bank_account_name']+'</li>'+
            '<li>'+'收款人账户：'+data['bank_card_number']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else if(data.money_type == 176){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'银行：'+data['bank_name']+'</li>'+
            '<li>'+'银行开户名：'+data['bank_account_name']+'</li>'+
            '<li>'+'银行卡号：'+data['bank_card_number']+'</li>'+
            '<li>'+'个人身份ID：'+data['bc_cpf']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else if(data.money_type == 181){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'银行：'+data['bank_name']+'</li>'+
            '<li>'+'收款人姓名：'+data['bank_account_name']+'</li>'+
            '<li>'+'收款人账户：'+data['bank_card_number']+'</li>'+
            '<li>'+'IFSC码：'+data['bc_cpf']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    }else if(data.money_type >= 32){
        str  = str+
            '<li>'+'币种：'+recharge_type+'</li>'+
            '<li>'+'银行：'+data['bank_name']+'</li>'+
            '<li>'+'银行开户名：'+data['bank_account_name']+'</li>'+
            '<li>'+'银行卡号：'+data['bank_card_number']+'</li>'+
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    } else {
        str = str +
            '<li>' + '币种：' + recharge_type + '</li>' +
            '<li>' + '提现地址：' + data['withdrawal_address'] + '</li>' +
            '<li>' + '出款地址：' + data['from_address'] + '</li>' +
            '<li>' + '提款IP：' + data['user_ip'] + '</li>';
    }

    return str;
}

function convertChange(data) {
    var  str= '',status = '';
    if (data['tx_status'] === 0) {
        status = '<span class="layui-badge layui-bg-blue">待确认</span>'
    } else if (data['tx_status'] === 1) {
        status = '<span class="layui-badge layui-bg-green">转账成功</span>'
    } else {
        status = '<span class="layui-badge">转账失败</span>'
    }
    str  = str+
        '<li>'+'打款状态：'+status+'</li>'+
        '<li>'+'出款金额：'+data['convert_money']+'</li>'+
        '<li>'+'打款tx：'+data['tx']+'</li>'+
        '<li>' + '平台单号：' + data['platform_order_no'] + '</li>';
    return str;
}

function checkStatusChange(data) {
    var  str= '',status = '';
    if (data['status'] === 1) {
        status = '<span class="layui-badge layui-bg-orange">处理中</span>'
    } else if (data['status'] === 2) {
        status = '<span class="layui-badge layui-bg-green">提现成功</span>'
    } else if (data['status'] === 3) {
        status = '<span class="layui-badge">提现拒绝</span>'
    } else if (data['status'] === 4) {
        status = '<span class="layui-badge layui-bg-gray">提现忽略</span>'
    } else if (data['status'] === 5) {
        status = '<span class="layui-badge">余额不足</span>'
    } else if (data['status'] === 6) {
        status = '<span class="layui-badge">队列中</span>'
    } else {
        status = '<span class="layui-badge layui-bg-blue">待审核</span>'
    }
    str  = str+
        '<li>'+'审核状态：'+status+'</li>'+
        '<li>'+'备注：'+data['mark']+'</li>'+
        '<li>'+'操作员：'+ data['admin_uid'] + '/' + data['operator_user'] +'</li>'+
        '<li>'+'操作时间：'+data['operator_time']+'</li>';
    return str;
}

function moneyChange(data) {
    var str= '';
    var recharge_type = '';
    let payment_type =  '';
    str  = str+
        '<li>'+'提现金额：'+data['extract_price']+'</li>'+
        '<li>'+'手续费：'+data['handling_fee']+'</li>'+
        '<li>'+'税费：'+data['extract_tax']+'</li>'+
        '<li>'+'实际到账：'+data['actual_fee']+'</li>';
    return str;
}

function userRechargeChange(data) {
    var str = '';
    let account = '';
    let add_ip_area = '';
    let first_user = '';
    let one_user = '';
    let first_spread_uid = '';
    let one_spread_uid = '';
    if(data['user'] !== null){
        account = data['user']['account'];
        add_ip_area = data['user']['add_ip_area'];
    }
    if(data['user1'] !== null && data['user1']['firstUser'] !== null){
        first_user = data['user1']['firstUser']['account'];
        first_spread_uid = data['user1']['firstUser']['uid'];
    }
    if(data['user'] !== null && data['user']['userOne'] != null){
        one_user = data['user']['userOne']['account'];
        one_spread_uid = data['user']['userOne']['uid'];
    }

    str = str +
        '<a style="color: #1aa094" data-table-info="' + data['uid'] + '">' + '用户：' + data['uid'] + '/' + account + '</a>' +
        '<li>' + '国家：' + add_ip_area + '</li>' +
        '<li>' + '顶级上级：'+ first_spread_uid + '/' + first_user + '</li>' +
        '<li>' + '一级上级：'+ one_spread_uid + '/' + one_user + '</li>';
    return str;
}

function userExtractOrderChange(data) {
    var str = '';
    let user = '';
    if(data['user'] != null){
        user = data['user']['account'];
    }
    let payment_type = '';
    if (data.payment_type == 1) {
        payment_type = '立即到账';
    } else if (data.payment_type == 3 && data.arrival_hours > 0) {
        const arrivalLabels = {
            24: '24小时到账(1天)',
            48: '48小时到账(2天)',
            72: '72小时到账(3天)',
            96: '96小时到账(4天)',
            120: '120小时到账(5天)',
            144: '144小时到账(6天)',
            168: '168小时到账(7天)',
        };
        payment_type = arrivalLabels[data.arrival_hours] || (data.arrival_hours + '小时到账');
    } else {
        payment_type = '24小时到账';
    }
    str = str +
        '<li>' + '订单号：' + data['order_no'] + '</li>' +
        '<li>'+'到账类型：'+payment_type+'</li>'+
        '<li>' + '申请时间：' + data['add_time'] + '</li>' +
        '<li>' + '最近充值：' + data['last_recharge_time'] + '</li>';
    return str;
}

function userRechargeOrderChange(data) {
    var str = '';
    let account = '';
    if(data['user'] !== null){
        account = data['user']['account'];
    }
    str = str +
        '<li>' + '订单号：' + data['order_no'] + '</li>' +
        '<li>' + '发送地址：' + data['from_address'] + '</li>' +
        '<li>' + '接收地址：' + data['to_address'] + '</li>';
    return str;
}

function moneyRechargeChange(data) {
    var str= '';
    var recharge_type = '';
    var is_first = '';
    if (data.recharge_type === 1) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAW9JREFUOE9jZEADQkvq+bj+/4n4z/DfloGBwZbhP8MfBgaG3f///T/FyMK2+2lM4xNkLYzIHMlFVe6MDIy9jAz/tdENhvLfMjAwLHoa11YEk4cbIL2oeisDw38vHBoxhJ/GtYH1ggmZRZWp/xkYZxGrGaTuPwND5LO4thWMUssaRBj//DrNwMCgAJJY7ZbCYCmuiNWs4y/vM4TumgOTe8D467sxo9SCykRGJsZ5MFGQATAAMwikEQaQDGBgZGRMZ5ReVDWdgYEhA5uVT2JbwcIyi6ux+46RYQnIgDsMDAzKIBUrXZMZrCWU8AbF0Rf3GMJ3z4WoYWR4iGLAMpdEBkMRWYbJlw8wvP/5jcFaEmwuw9HndxkE2bkYcnUdGM6/ecwQtWc+igEYXuBmYWNQFRBj2OKZCVbos306w71Pbxg+/fqB6jqQF9ADEVkFoTAAByJ6NJJgACQa8SUkfC6AJySYjRQlZZghFGUmmCGkZmcAmRGbrUm+nq0AAAAASUVORK5CYII="><span style="color: #8338ec">TRC20-USDT</span>';
    } else if(data.recharge_type === 2) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAcRJREFUOE+lk01IVGEUhp9jkndKSURmRgmMKO+MQe7a1S7CQNrUbhY1ELSQdupKolWMBOJCBEOcoCIIKpJatAlxJ7jqZxwCGSKdO5I/NY1e0ebEvXjHO9fcNGf1wXfO8533nPcTagwJ1meb2lt1tzyI6HlVugX+APOgGdW68bht5fw1VYCs0XZRpfwaaDmksZKq9MVtK+3dVwAZI3pTRKciIw9YHR5lN28dKk607pJp52edBBeQMaKnRPQTcNws5VHbRkIhyr+KrI9PsjGRDgLXpP6IaRaXf7iAhVA4BTLgnBt7LhMZTWHdHQBVmpMJGnt73G6yx6K+ruRhbMvq3wNE3gC93q25abH98TP5ZB9iNNAx847iy2marl/bhwjvY5uFKx5gCWj3AGeWFvh+9QZtTyaoj4QpvnjFiVsJlhO3XZATCoX4ViH6T0DDuTgnp5+z83WRtZExmu8kKf8uuQAvgoAqCU6SI+Nn+ikbj5/R8eFtQL87fr+E/SF6L5z+Mofa2xyNnWWx6wI7uW+BtfqG6F9jxSAhg87VHCv9Q6yPPQp6onqNe15wjeTPDKfuszJ474ChDhjJy6jJyhVILZ/pf372X9ShzhGtQ6vwAAAAAElFTkSuQmCC"><span style="color: #99d98c">TRX</span>';
    } else if (data.recharge_type === 3) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAIHUExURVCvlVGwllCvlE+wmAAAAFC2nVCwl06xmE2znk+vlE6fdBEMAAAAAQZ7FlGwllOwllOwl1CvlVCvlU+ulE6ulFCvlVCvlFCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCvlVCwllCvlVCvlVCvlUSCY1Csj1CvlVCvlQwPAR80BVCvlVCvlQ0iBVCvlVCvlU+ulBAjBlCvlVCvlVSxlwQlBlGvlVCvlU6ulE+wlkJ4WAkMAAAQAwNCC1CvlVCvlVuxgSM7BwogBAweBQIiBQNDCwemHkytkkuskieWFA5vEA6WFVGvlWO4oGq7pWm7pFWxmMbl3fP6+PH49u/49cjm3lCvlVSxl7Hbz9Xs5djt5/v9/Pv9/djt6NTs5bLc0FSxmE+vlVeymVu0nHC+qez29O339HK+qnC9qGO4oV21nW+9qOz39HC+qFaymYfItn3DsHG+qXfBrcHj2cHj2njBrXHAq37CrojCr1ewl1Gwlma5onzDsOHx7eLy7n3EsGOVfkNOPSszIjBKNE2uk+v28+z49WCSexoYDhoSAntfFyofBk+ulGS4oe718UtOPwgEAHhfGJ17IIptHBIPBN/x7OHp5Dw3KldFEEs8EHNcGEk7D2FNFGu8pm25ojJGMhUPAnlfGYttHIVpGx8ZByohCZl3Hz4wDf///17AECAAAABQdFJOUwAAAAAAAAAAAAAAAAAABBsdSNTZ2UkIr7BD8vNEBqSl7O20tcD+wR+uyyQXqOpaE6HUEJr++A2T/dsLi/z6tuzyaQiBDVG5175aBAQECxsNBTOPxAAAAAFiS0dErFdl8osAAAAHdElNRQfoBgcCJCt6hDLeAAABCUlEQVQY02NgYOTjF4ACfj5GBiAQFBIWAQNhIVEgl0lMPCAwKBgIggIDJMSAIpJSIaFh4RER4WGRIdIyDAyyclHRMbFx8QmJSckpUfKyDJIKUalp6RmZWdnpaalRijIMSlHRObl5+QVZhXm5GSlRygwqUUXFJaVl5RWVVdU1tapqDOoaUXV59Q2NTc0trW3tmloMDNo6UakdgZ1d3T29ff26ekB79Q2iJkzsnDR5ytRp02cYMjAzMBgZmwTOnDV7ztx58xeYMrCwMjCYmVssXLR4ydJly1dYMrCwsDEwWFnb2NrZr1y12sERKMDCzsDg5Ozs4urm7uHpBRJg4WDg9Pbh4vb18+fhBQD2aEdkZKLOdwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyNC0wNi0wN1QwMjozNjozNSswMDowMBgPjd0AAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjQtMDYtMDdUMDI6MzY6MzUrMDA6MDBpUjVhAAAAKHRFWHRkYXRlOnRpbWVzdGFtcAAyMDI0LTA2LTA3VDAyOjM2OjQzKzAwOjAwV1IonQAAAABJRU5ErkJggg=="><span style="color: rgba(166,160,74,0.89)">BEP20-USDT</span>'
    } else if (data.recharge_type === 4) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAPhJREFUOE+tUysSwjAQzVYgUCh0U4NCokkP0EsgmAHLASgHQOM4BZ6iOQGm7REwNYgubIZ0NplAgbKqeZ197+0PhBNhGKogCBQiTp+/lBAiA4BTXddZWZYZTwH+iKIoRcQ1xyajmzhfeg0EAJs8z1MDNAS+5P3qKohgth1YJOSoKIqYSDTBu2Sj5JIYJ5pASonctlEmjOyTCwqXBBFjcNWXSSUWSWUlcMLxfMi1MovANIwSdod+o04ufJiejpTy+PhQvoZ9gv2PgAr7qQTaPACgMnR800QaZfcxkqrrgjA+Ot8OWIvUto2tq2zq73RM7lXSm13my3O+A/1e72H0cdWdAAAAAElFTkSuQmCC"><span style="color: #08070a">BNB</span>'
    } else if (data.recharge_type === 5) {
        recharge_type = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAUBJREFUOE+tUzFSw0AMlNKHB5AuFPgDMSXODPkGLY3LkJbQBso0tHyDzGBK7A+YgnThAaTPMXuxbtaCEjV3OulWqz2dirNs3hQyOBQh6GUXKlTDPfbt6mLp85UPssX7MgS980nsA4yBEgBfLmcjqbffUn/u4938bBhX8xkkAvjL5exUrp/aHkB5NYogOIcZSAQ4v60D1uebTOrtXtYvu1Q5H58kH8xgFtegU7XqoIkqVgHJYALa680useEiYJEAEODEdjWRbNHEiogxcD4eml+p0ccF7hu+r26vQeAR4FVECq5oidYWVmODPRiZnwC4N68Hs+NYTwOvsIl4VP0rKc9aHQHmTRE0oA35C4SfDXESUD4ecu0NktHjgTE9jJEJ3RskP41+dH8NEP2H//tM/lfC735m1c3+mxwGVfs4ib7ZDwuW+xwvXGWtAAAAAElFTkSuQmCC"><span style="color: #08070a">BEP20-USDC</span>'
    } else if (data.recharge_type === 999){
        recharge_type = '手动';
    } else if (data.recharge_type === 6) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAKWSURBVHgBzVe/T9tAGH1nMTG5Uv8AM7VboWsrJQzMDVuZCO1aKUx0bFi7kEhd24aJsTAzBIbOtBtM+A9AwlNGwvd8d8QxdnxxbMSTHDu+8733/bjv7hQc0cbY94CWPDbGwKrcA7l80xzJFSrgn9zP74DjAVTkMq4q6iDEgRB3xnycELoMPBAh+yIkLOiXS0yLvwnxLhaAEPSMkCinPZM8kIYhtJurQCiGrGd5w8sgX62YnIgN4tjpBpUiD2ogT+KRJ1SC3Jc/FzWSJ0Ws2Zx4CAET7gnIicBwxYg9YFx/jSeEeGGFoYg9kFRUFhsdoCsBfNd266/M9FYm9rcoiVdN4IPIf92cvLsJge/r+j4DEb3gmfJaClsHwNehJh9JSp32NenLQARIQD/9nvl5XNoZggZKYsPUSBLvrQBHu9ryv4f6/ft24RANzywsTqC7v/zRFiZB4pEptPTAzzacQO4lOEy9ZV/H2Vr8tqUtrgCckrNXOGY342nJL89QJfyloh5bvQnxyT5wdaZDMEqsbfQQL7qfYWJyuoICOFThOs/kskhPL5LTSxRppyMFUnABIgoIMUcizoIl56w46U57KQchBfxfVAA9wqT8eKDJGSYXcAvnyY9TdxYVO/3o8nScKeLHpjs5ITulc1uKuRBl5sHngdT37QnJxbGu98umNy0+KrlpkzrwIl4NdzBmrnfyOtLyveF0AUrOijLgpvUX1M5cyzEtZ11gqT3tYSHY5fhhR1TkhSoh5H0hjwPnJV52oadk3QihuTAlgHs0bhhRrwi7KY0eCTAi2GGzJhHx2OmzwfM7mBDGE2vy2MeCYMKZbXiY1e50OFU6abbhDsb4UIh7pQ+nGUJY+1ryQVPub5BzPGd5xRzH83vtWeeOovqPLgAAAABJRU5ErkJggg=="><span style="color: rgba(166,160,74,0.89)">Polygon-USDT</span>';
    } else if (data.recharge_type === 7) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iMzYwIiBoZWlnaHQ9IjM2MCIgdmlld0JveD0iMCAwIDM2MCAzNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzNjAiIGhlaWdodD0iMzYwIiBmaWxsPSIjNjI3RUVBIi8+CjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yNTkwXzQ1MjMyKSI+CjxwYXRoIGQ9Ik0xODAgMzMwQzI2Mi44NDMgMzMwIDMzMCAyNjIuODQzIDMzMCAxODBDMzMwIDk3LjE1NzMgMjYyLjg0MyAzMCAxODAgMzBDOTcuMTU3MyAzMCAzMCA5Ny4xNTczIDMwIDE4MEMzMCAyNjIuODQzIDk3LjE1NzMgMzMwIDE4MCAzMzBaIiBmaWxsPSIjNjI3RUVBIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDY3LjVWMTUwLjY1NkwyNTQuOTUzIDE4Mi4wNjJMMTg0LjY2OSA2Ny41WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgNjcuNUwxMTQuMzc1IDE4Mi4wNjJMMTg0LjY2OSAxNTAuNjU2VjY3LjVaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTg0LjY2OSAyMzUuOTVWMjkyLjQ1NEwyNTUgMTk1LjE1TDE4NC42NjkgMjM1Ljk1WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgMjkyLjQ1NFYyMzUuOTQxTDExNC4zNzUgMTk1LjE1TDE4NC42NjkgMjkyLjQ1NFoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDIyMi44NzNMMjU0Ljk1MyAxODIuMDYzTDE4NC42NjkgMTUwLjY3NlYyMjIuODczWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+CjxwYXRoIGQ9Ik0xMTQuMzc1IDE4Mi4wNjNMMTg0LjY2OSAyMjIuODczVjE1MC42NzZMMTE0LjM3NSAxODIuMDYzWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yNTkwXzQ1MjMyIj4KPHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMCAzMCkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K"><span style="color:rgba(7, 124, 7, 0.91)">ETH-USDT</span>';
    } else if (data.recharge_type === 8) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAKWSURBVHgBzVe/T9tAGH1nMTG5Uv8AM7VboWsrJQzMDVuZCO1aKUx0bFi7kEhd24aJsTAzBIbOtBtM+A9AwlNGwvd8d8QxdnxxbMSTHDu+8733/bjv7hQc0cbY94CWPDbGwKrcA7l80xzJFSrgn9zP74DjAVTkMq4q6iDEgRB3xnycELoMPBAh+yIkLOiXS0yLvwnxLhaAEPSMkCinPZM8kIYhtJurQCiGrGd5w8sgX62YnIgN4tjpBpUiD2ogT+KRJ1SC3Jc/FzWSJ0Ws2Zx4CAET7gnIicBwxYg9YFx/jSeEeGGFoYg9kFRUFhsdoCsBfNd266/M9FYm9rcoiVdN4IPIf92cvLsJge/r+j4DEb3gmfJaClsHwNehJh9JSp32NenLQARIQD/9nvl5XNoZggZKYsPUSBLvrQBHu9ryv4f6/ft24RANzywsTqC7v/zRFiZB4pEptPTAzzacQO4lOEy9ZV/H2Vr8tqUtrgCckrNXOGY342nJL89QJfyloh5bvQnxyT5wdaZDMEqsbfQQL7qfYWJyuoICOFThOs/kskhPL5LTSxRppyMFUnABIgoIMUcizoIl56w46U57KQchBfxfVAA9wqT8eKDJGSYXcAvnyY9TdxYVO/3o8nScKeLHpjs5ITulc1uKuRBl5sHngdT37QnJxbGu98umNy0+KrlpkzrwIl4NdzBmrnfyOtLyveF0AUrOijLgpvUX1M5cyzEtZ11gqT3tYSHY5fhhR1TkhSoh5H0hjwPnJV52oadk3QihuTAlgHs0bhhRrwi7KY0eCTAi2GGzJhHx2OmzwfM7mBDGE2vy2MeCYMKZbXiY1e50OFU6abbhDsb4UIh7pQ+nGUJY+1ryQVPub5BzPGd5xRzH83vtWeeOovqPLgAAAABJRU5ErkJggg=="><span style="color:rgb(143, 97, 234)">Polygon-USDC</span>'
    } else if (data.recharge_type === 9) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iMzYwIiBoZWlnaHQ9IjM2MCIgdmlld0JveD0iMCAwIDM2MCAzNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzNjAiIGhlaWdodD0iMzYwIiBmaWxsPSIjNjI3RUVBIi8+CjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yNTkwXzQ1MjMyKSI+CjxwYXRoIGQ9Ik0xODAgMzMwQzI2Mi44NDMgMzMwIDMzMCAyNjIuODQzIDMzMCAxODBDMzMwIDk3LjE1NzMgMjYyLjg0MyAzMCAxODAgMzBDOTcuMTU3MyAzMCAzMCA5Ny4xNTczIDMwIDE4MEMzMCAyNjIuODQzIDk3LjE1NzMgMzMwIDE4MCAzMzBaIiBmaWxsPSIjNjI3RUVBIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDY3LjVWMTUwLjY1NkwyNTQuOTUzIDE4Mi4wNjJMMTg0LjY2OSA2Ny41WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgNjcuNUwxMTQuMzc1IDE4Mi4wNjJMMTg0LjY2OSAxNTAuNjU2VjY3LjVaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTg0LjY2OSAyMzUuOTVWMjkyLjQ1NEwyNTUgMTk1LjE1TDE4NC42NjkgMjM1Ljk1WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgMjkyLjQ1NFYyMzUuOTQxTDExNC4zNzUgMTk1LjE1TDE4NC42NjkgMjkyLjQ1NFoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDIyMi44NzNMMjU0Ljk1MyAxODIuMDYzTDE4NC42NjkgMTUwLjY3NlYyMjIuODczWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+CjxwYXRoIGQ9Ik0xMTQuMzc1IDE4Mi4wNjNMMTg0LjY2OSAyMjIuODczVjE1MC42NzZMMTE0LjM3NSAxODIuMDYzWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yNTkwXzQ1MjMyIj4KPHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMCAzMCkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K"><span style="color:rgb(103, 47, 215)">ETH-USDC</span>'
    } else if (data.recharge_type === 10) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iMzYwIiBoZWlnaHQ9IjM2MCIgdmlld0JveD0iMCAwIDM2MCAzNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzNjAiIGhlaWdodD0iMzYwIiBmaWxsPSIjNjI3RUVBIi8+CjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yNTkwXzQ1MjMyKSI+CjxwYXRoIGQ9Ik0xODAgMzMwQzI2Mi44NDMgMzMwIDMzMCAyNjIuODQzIDMzMCAxODBDMzMwIDk3LjE1NzMgMjYyLjg0MyAzMCAxODAgMzBDOTcuMTU3MyAzMCAzMCA5Ny4xNTczIDMwIDE4MEMzMCAyNjIuODQzIDk3LjE1NzMgMzMwIDE4MCAzMzBaIiBmaWxsPSIjNjI3RUVBIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDY3LjVWMTUwLjY1NkwyNTQuOTUzIDE4Mi4wNjJMMTg0LjY2OSA2Ny41WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgNjcuNUwxMTQuMzc1IDE4Mi4wNjJMMTg0LjY2OSAxNTAuNjU2VjY3LjVaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTg0LjY2OSAyMzUuOTVWMjkyLjQ1NEwyNTUgMTk1LjE1TDE4NC42NjkgMjM1Ljk1WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgMjkyLjQ1NFYyMzUuOTQxTDExNC4zNzUgMTk1LjE1TDE4NC42NjkgMjkyLjQ1NFoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDIyMi44NzNMMjU0Ljk1MyAxODIuMDYzTDE4NC42NjkgMTUwLjY3NlYyMjIuODczWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+CjxwYXRoIGQ9Ik0xMTQuMzc1IDE4Mi4wNjNMMTg0LjY2OSAyMjIuODczVjE1MC42NzZMMTE0LjM3NSAxODIuMDYzWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yNTkwXzQ1MjMyIj4KPHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMCAzMCkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K"><span style="color:rgb(103, 47, 215)">ETH</span>'
    } else if (data.recharge_type === 11) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAKWSURBVHgBzVe/T9tAGH1nMTG5Uv8AM7VboWsrJQzMDVuZCO1aKUx0bFi7kEhd24aJsTAzBIbOtBtM+A9AwlNGwvd8d8QxdnxxbMSTHDu+8733/bjv7hQc0cbY94CWPDbGwKrcA7l80xzJFSrgn9zP74DjAVTkMq4q6iDEgRB3xnycELoMPBAh+yIkLOiXS0yLvwnxLhaAEPSMkCinPZM8kIYhtJurQCiGrGd5w8sgX62YnIgN4tjpBpUiD2ogT+KRJ1SC3Jc/FzWSJ0Ws2Zx4CAET7gnIicBwxYg9YFx/jSeEeGGFoYg9kFRUFhsdoCsBfNd266/M9FYm9rcoiVdN4IPIf92cvLsJge/r+j4DEb3gmfJaClsHwNehJh9JSp32NenLQARIQD/9nvl5XNoZggZKYsPUSBLvrQBHu9ryv4f6/ft24RANzywsTqC7v/zRFiZB4pEptPTAzzacQO4lOEy9ZV/H2Vr8tqUtrgCckrNXOGY342nJL89QJfyloh5bvQnxyT5wdaZDMEqsbfQQL7qfYWJyuoICOFThOs/kskhPL5LTSxRppyMFUnABIgoIMUcizoIl56w46U57KQchBfxfVAA9wqT8eKDJGSYXcAvnyY9TdxYVO/3o8nScKeLHpjs5ITulc1uKuRBl5sHngdT37QnJxbGu98umNy0+KrlpkzrwIl4NdzBmrnfyOtLyveF0AUrOijLgpvUX1M5cyzEtZ11gqT3tYSHY5fhhR1TkhSoh5H0hjwPnJV52oadk3QihuTAlgHs0bhhRrwi7KY0eCTAi2GGzJhHx2OmzwfM7mBDGE2vy2MeCYMKZbXiY1e50OFU6abbhDsb4UIh7pQ+nGUJY+1ryQVPub5BzPGd5xRzH83vtWeeOovqPLgAAAABJRU5ErkJggg=="><span style="color:rgb(143, 97, 234)">Polygon</span>'
    } else if (data.recharge_type === 12) {
        recharge_type = '<img style="width:16px;height:16px;border-radius:4px" src="data:image/svg+xml;charset=utf-8;base64,PHN2ZyB3aWR0aD0iMzYwIiBoZWlnaHQ9IjM2MCIgdmlld0JveD0iMCAwIDM2MCAzNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzNjAiIGhlaWdodD0iMzYwIiBmaWxsPSIjNjI3RUVBIi8+CjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yNTkwXzQ1MjMyKSI+CjxwYXRoIGQ9Ik0xODAgMzMwQzI2Mi44NDMgMzMwIDMzMCAyNjIuODQzIDMzMCAxODBDMzMwIDk3LjE1NzMgMjYyLjg0MyAzMCAxODAgMzBDOTcuMTU3MyAzMCAzMCA5Ny4xNTczIDMwIDE4MEMzMCAyNjIuODQzIDk3LjE1NzMgMzMwIDE4MCAzMzBaIiBmaWxsPSIjNjI3RUVBIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDY3LjVWMTUwLjY1NkwyNTQuOTUzIDE4Mi4wNjJMMTg0LjY2OSA2Ny41WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgNjcuNUwxMTQuMzc1IDE4Mi4wNjJMMTg0LjY2OSAxNTAuNjU2VjY3LjVaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTg0LjY2OSAyMzUuOTVWMjkyLjQ1NEwyNTUgMTk1LjE1TDE4NC42NjkgMjM1Ljk1WiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPHBhdGggZD0iTTE4NC42NjkgMjkyLjQ1NFYyMzUuOTQxTDExNC4zNzUgMTk1LjE1TDE4NC42NjkgMjkyLjQ1NFoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik0xODQuNjY5IDIyMi44NzNMMjU0Ljk1MyAxODIuMDYzTDE4NC42NjkgMTUwLjY3NlYyMjIuODczWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+CjxwYXRoIGQ9Ik0xMTQuMzc1IDE4Mi4wNjNMMTg0LjY2OSAyMjIuODczVjE1MC42NzZMMTE0LjM3NSAxODIuMDYzWiIgZmlsbD0id2hpdGUiIGZpbGwtb3BhY2l0eT0iMC42MDIiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yNTkwXzQ1MjMyIj4KPHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMCAzMCkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K"><span style="color:rgb(103, 47, 215)">ETH-PYUSD</span>'
    } else if (data.recharge_type === 21) {
        recharge_type = 'BRL(bbpay)';
    } else if(data.recharge_type === 22){
        recharge_type = 'BRL(speedlypay)';
    } else if(data.recharge_type === 32){
        recharge_type = 'PHP(spcspay)';
    } else if(data.recharge_type === 50){
        recharge_type = 'BRL(dcpay)';
    } else if(data.recharge_type === 51){
        recharge_type = 'BRL(dcpay)';
    } else if(data.recharge_type === 52){
        recharge_type = 'BRL(dcpay)';
    } else if(data.recharge_type === 53){
        recharge_type = 'BRL(dcpay)';
    } else if(data.recharge_type === 54){
        recharge_type = 'BRL(amaspay)';
    } else if(data.recharge_type === 55){
        recharge_type = 'IDR(jytpay)';
    } else if(data.recharge_type === 56){
        recharge_type = 'BRL(chzfpay)';
    } else if(data.recharge_type === 57){
        recharge_type = 'VND(qfpay)';
    } else if(data.recharge_type === 58){
        recharge_type = 'VND(dayangpay)';
    } else if(data.recharge_type === 59){
        recharge_type = 'BRL(dayangpay)';
    } else if(data.recharge_type === 60){
        recharge_type = 'BDT(zenithpay)';
    } else if(data.recharge_type === 61){
        recharge_type = 'BRL(zenithpay)';
    } else if(data.recharge_type === 62){
        recharge_type = 'IDR(wowpay)';
    } else if(data.recharge_type === 63){
        recharge_type = 'IDR(klysnvpay)';
    } else if(data.recharge_type === 64){
        recharge_type = 'BDT(jytpay)';
    } else if(data.recharge_type === 65){
        recharge_type = 'BDT(h88pay)';
    } else if(data.recharge_type === 66){
        recharge_type = 'VND(ttpay)';
    } else if(data.recharge_type === 67){
        recharge_type = 'BDT(mgmpay)';
    } else if(data.recharge_type === 68){
        recharge_type = 'VND(vortaqpay)';
    } else if(data.recharge_type === 69){
        recharge_type = 'VND(nxpay)';
    } else if(data.recharge_type === 70){
        recharge_type = 'PHP(jytpay)';
    } else if(data.recharge_type === 71){
        recharge_type = 'PHP(pandapay)';
    } else if(data.recharge_type === 72){
        recharge_type = 'BDT(vortaqpay)';
    } else if(data.recharge_type === 73){
        recharge_type = 'ZAR(mgmpay)';
    } else if(data.recharge_type === 74){
        recharge_type = 'IDR(vortaqpay)';
    } else if(data.recharge_type === 75){
        recharge_type = 'MYR(vortaqpay)';
    } else if(data.recharge_type === 76){
        recharge_type = 'BRL(brlcpay)';
    } else if(data.recharge_type === 77){
        recharge_type = 'PHP(vortaqpay)';
    } else if(data.recharge_type === 78){
        recharge_type = 'MYR(gctpkpay)';
    } else if(data.recharge_type === 79){
        recharge_type = 'MXN(mgmpay)';
    } else if(data.recharge_type === 80){
        recharge_type = 'BRL(vortaqpay)';
    } else if(data.recharge_type === 81){
        recharge_type = 'VND(nekpay)';
    } else if(data.recharge_type === 82){
        recharge_type = 'NGN(vortaqpay)';
    } else if(data.recharge_type === 83){
        recharge_type = 'NGN(shpays)';
    } else if(data.recharge_type === 84){
        recharge_type = 'PEN(vortaqpay)';
    } else if(data.recharge_type === 85){
        recharge_type = 'COP(vortaqpay)';
    } else if(data.recharge_type === 86){
        recharge_type = 'NGN(mgmpay)';
    } else if(data.recharge_type === 87){
        recharge_type = 'NGN(hpay)';
    } else if(data.recharge_type === 88){
        recharge_type = 'CDF(ezpay)';
    } else if(data.recharge_type === 89){
        recharge_type = 'GHS(simpay)';
    } else if(data.recharge_type === 90){
        recharge_type = 'XAF(simpay)';
    } else if(data.recharge_type === 91){
        recharge_type = 'IDR(nekpay)';
    } else if(data.recharge_type === 92){
        recharge_type = 'MXN(vortaqpay)';
    } else if(data.recharge_type === 93){
        recharge_type = 'IDR(watchpay)';
    } else if(data.recharge_type === 94){
        recharge_type = 'GTQ(xpay)';
    } else if(data.recharge_type === 95){
        recharge_type = 'COP(gctpkpay)';
    } else if(data.recharge_type === 96){
        recharge_type = 'ZAR(gctpkpay)';
    } else if(data.recharge_type === 97){
        recharge_type = 'MXN(gctpkpay)';
    } else if(data.recharge_type === 98){
        recharge_type = 'XAF(hipay)';
    } else if(data.recharge_type === 99){
        recharge_type = 'PHP(bpay)';
    } else if(data.recharge_type === 100){
        recharge_type = 'PHP(gctpkpay)';
    } else if(data.recharge_type === 101){
        recharge_type = 'PHP(yunpay)';
    } else if(data.recharge_type === 102){
        recharge_type = 'BOB(yfpay)';
    } else if(data.recharge_type === 103){
        recharge_type = 'PHP(mgmPay)';
    } else if(data.recharge_type === 104){
        recharge_type = 'PHP(wgepay)';
    } else if(data.recharge_type === 105){
        recharge_type = 'ZMW(ezpay)';
    } else if(data.recharge_type === 108){
        recharge_type = 'UZS(nicepay)';
    } else if(data.recharge_type === 110){
        recharge_type = 'XOF(gctpkpay)';
    } else if(data.recharge_type === 112){
        recharge_type = 'GHS(ezpay)';
    } else if(data.recharge_type === 113){
        recharge_type = 'GHS(ppay)';
    } else if(data.recharge_type === 114){
        recharge_type = 'XOF(nicepay)';
    } else if(data.recharge_type === 115){
        recharge_type = 'INR(allpay)';
    } else if(data.recharge_type === 116){
        recharge_type = 'ARS(sunpay)';
    } else if(data.recharge_type === 117){
        recharge_type = 'GHS(hipay)';
    } else if(data.recharge_type === 118){
        recharge_type = 'COP(eaPay)';
    } else if(data.recharge_type === 119){
        recharge_type = 'VND(wstpay)';
    } else if(data.recharge_type === 120){
        recharge_type = 'PKR(vortaqpay)';
    } else if(data.recharge_type === 121){
        recharge_type = 'INR(nicepay)';
    } else if(data.recharge_type === 122){
        recharge_type = 'PHP(smtmPay)';
    } else if(data.recharge_type === 123){
        recharge_type = 'XAF(hipay2)';
    } else if(data.recharge_type === 124){
        recharge_type = 'VND(wgepay)';
    } else if(data.recharge_type === 125){
        recharge_type = 'IDR(gctpkpay)';
    } else if(data.recharge_type === 126){
        recharge_type = 'PEN(whtPay)';
    } else if(data.recharge_type === 127){
        recharge_type = 'BDT(hipay)';
    } else if(data.recharge_type === 128){
        recharge_type = 'EGP(apay)';
    } else if(data.recharge_type === 129){
        recharge_type = 'TZS(hipay)';
    } else if(data.recharge_type === 130){
        recharge_type = 'KES(ezpay)';
    } else if(data.recharge_type === 131){
        recharge_type = 'VND(clickpay)';
    } else if(data.recharge_type === 132){
        recharge_type = 'EGP(ppay)';
    } else if(data.recharge_type === 133){
        recharge_type = 'XOF(hypay)';
    } else if(data.recharge_type === 134){
        recharge_type = 'BRL(gctpkpay)';
    } else if(data.recharge_type === 135){
        recharge_type = 'NGN(instantpay)';
    } else if(data.recharge_type === 136){
        recharge_type = 'LRD(ezpay)';
    } else if(data.recharge_type === 137){
        recharge_type = 'RWF(ezpay)';
    } else if(data.recharge_type === 138){
        recharge_type = 'PEN(hyPay)';
    } else if(data.recharge_type === 139){
        recharge_type = 'MXN(fzPay)';
    } else if(data.recharge_type === 140){
        recharge_type = 'BRL(h88pay)';
    } else if(data.recharge_type === 141){
        recharge_type = 'VND(gotoopay)';
    } else if(data.recharge_type === 142){
        recharge_type = 'SYP(wtpay)';
    } else if(data.recharge_type === 143){
        recharge_type = 'COP(nekpay)';
    } else if(data.recharge_type === 144){
        recharge_type = 'BRL(lwPay)';
    } else if(data.recharge_type === 145){
        recharge_type = 'VND(bwtPay)';
    } else if(data.recharge_type === 146){
        recharge_type = 'BDT(nekpay)';
    } else if(data.recharge_type === 147){
        recharge_type = 'BDT(axpay)';
    } else if(data.recharge_type === 148){
        recharge_type = 'XOF(kkpay)';
    } else if(data.recharge_type === 149){
        recharge_type = 'PHP(nicepay)';
    } else if(data.recharge_type === 150){
        recharge_type = 'CDF(hipay)';
    } else if(data.recharge_type === 151){
        recharge_type = 'PHP(htpay)';
    } else if(data.recharge_type === 152){
        recharge_type = 'USD(nicepay)';
    } else if(data.recharge_type === 153){
        recharge_type = 'XOF(allpay)';
    } else if(data.recharge_type === 154){
        recharge_type = 'MAD(upay)';
    } else if(data.recharge_type === 155){
        recharge_type = 'NGN(gctpkpay)';
    } else if(data.recharge_type === 156){
        recharge_type = 'PHP(sqpay)';
    } else if(data.recharge_type === 157){
        recharge_type = 'NGN(kkpay)';
    } else if(data.recharge_type === 158){
        recharge_type = 'XAF(dzxumPay)';
    } else if(data.recharge_type === 159){
        recharge_type = 'NGN(lpPay)';
    } else if(data.recharge_type === 160){
        recharge_type = 'NGN(dailypay)';
    } else if(data.recharge_type === 161){
        recharge_type = 'PKR(gopay)';
    } else if(data.recharge_type === 162){
        recharge_type = 'MXN(toppay)';
    } else if(data.recharge_type === 163){
        recharge_type = 'VND(novolinkpay)';
    } else if(data.recharge_type === 164){
        recharge_type = 'MXN(ppay)';
    } else if(data.recharge_type === 165){
        recharge_type = 'VND(dzxumPay)';
    } else if(data.recharge_type === 166){
        recharge_type = 'GHS(allpay)';
    } else if(data.recharge_type === 167){
        recharge_type = 'MXN(lpPay)';
    } else if(data.recharge_type === 168){
        recharge_type = 'PHP(jiefupay)';
    } else if(data.recharge_type === 169){
        recharge_type = 'AOA(jackpay)';
    } else if(data.recharge_type === 170){
        recharge_type = 'XOF(nekpay)';
    } else if(data.recharge_type === 171){
        recharge_type = 'ETB(jackpay)';
    } else if(data.recharge_type === 172){
        recharge_type = 'IDR(akepay)';
    } else if(data.recharge_type === 173){
        recharge_type = 'NGN(dzxumPay)';
    } else if(data.recharge_type === 174){
        recharge_type = 'CDF(nekpay)';
    } else if(data.recharge_type === 175){
        recharge_type = 'VND(dayangPay)';
    } else if(data.recharge_type === 178){
        recharge_type = 'VND(q8pay)';
    } else if(data.recharge_type === 176){
        recharge_type = 'PKR(lpay)';
    } else if(data.recharge_type === 177){
        recharge_type = 'XOF(ppay)';
    } else if(data.recharge_type === 179){
        recharge_type = 'XOF(dzxumPay)';
    } else if(data.recharge_type === 180){
        recharge_type = 'XAF(ppay)';
    } else if(data.recharge_type === 181){
        recharge_type = 'INR(gctpkpay)';
    } else if(data.recharge_type === 182){
        recharge_type = 'IDR(lpay)';
    } else if(data.recharge_type === 111){
        recharge_type = 'PEN(mgmPay)';
    } else {
        recharge_type = '未知';
    }
    if (data.is_first == 1) {
        is_first = '<span style="color: rgba(51,225,110,0.73)">首充</span>'
    } else {
        is_first = '<span style="color: #c8c2b6">累充</span>'
    }
    let giveMoneyText = parseFloat(data['give_money'] || 0) > 0 ? data['give_money'] : '-';
    if(data.recharge_type == 999){
        str  = str+
            '<li>'+'币种/首充：'+recharge_type+'/'+is_first+'</li>'+
            '<li>'+'充值金额：'+data['money']+'</li>'+
            '<li>'+'付款图片：'+'<img src="'+encodeURI(data['pay_image'])+'" style="max-width:32px;max-height:32px;" alt="" />'+'</li>'+
            '<li>'+'付款单号：'+data['pay_order_no']+'</li>';
    }else{
        str  = str+
            '<li>'+'币种/首充：'+recharge_type+'/'+is_first+'</li>'+
            '<li>'+'原始金额：'+data['original_money']+'</li>'+
            '<li>'+'汇率：'+data['exchange_rate']+'</li>'+
            '<li>'+'充值：'+data['money']+' / 赠送：'+giveMoneyText+'</li>';
    }

    return str;
}

function timeRechargeChange(data) {
    var str= '';
    var account_type = '';
    if (data.account_type === 1) {
        account_type = '基础账户';
    } else {
        account_type = '理财账户';
    }
    str  = str+
        '<li>'+'账户类型：'+account_type+'</li>'+
        '<li>'+'充值tx：'+data['tx']+'</li>'+
        '<li>'+'充值时间：'+data['add_time']+'</li>'+
        '<li>'+'tx时间：'+data['tx_time']+'</li>';
    return str;
}

function collectChange(data) {
    var str= '';
    var status_text = '';
    switch (data.status) {
        case 0:
            status_text =  '<span class="layui-badge layui-bg">待审核</span>'
            break;
        case 1:
            status_text =  '<span class="layui-badge layui-bg-blue">充值入账</span>'
            break;
        case 2:
            status_text = '<span class="layui-badge">入队归集</span>'
            break;
        case 3:
            status_text = '<span class="layui-badge layui-bg-orange">购买能量</span>'
            break;
        case 4:
            status_text = '<span class="layui-badge layui-bg-blue">发起转账</span>'
            break;
        case 5:
            status_text = '<span class="layui-badge layui-bg-green">归集成功</span>'
            break;
        case 6:
            status_text = '<span class="layui-badge">归集失败</span>'
            break;
        case 7:
            status_text = '<span class="layui-badge layui-bg-red">审核拒绝</span>'
            break;
        default:
            status_text = '未知';
    }
    var collect_status_text = ''
    if(data['collect'] === null){
        collect_status_text =  '--';
    }else{
        if (data['collect']['status'] === 1) {
            collect_status_text =  '<span class="layui-badge layui-bg-blue">待确认</span>'
        }else if(data['collect']['status'] === 2){
            collect_status_text = '<span class="layui-badge layui-bg-green">归集成功</span>'
        }else{
            collect_status_text = '<span class="layui-badge">归集失败</span>'
        }
    }

    var status_msg = '';
    if(data['status_msg'] !== ''){
        status_msg = data['status_msg'];
    }else{
        status_msg = '--';
    }
    str  = str+
        '<li>'+'归集进度：'+status_text+'</li>'+
        '<li>'+'状态信息：<span style="font-weight:bold">'+status_msg+'</li>'+
        '<li>'+'购买能量：'+data['buy_energy_time']+'</li>'+
        '<li>'+'归集状态：'+collect_status_text+'</li>';
    return str;
}

function collectInfoChange(data) {
    if(data['collect'] === null){
        return '--';
    }
    var str= '';
    str  = str+
        '<li>'+'归集金额：'+data['collect']['money']+'</li>'+
        '<li>'+'tx手续费：'+data['collect']['tx_fee']+'</li>'+
        '<li>'+'发送地址：'+data['collect']['from_address']+'</li>'+
        '<li>'+'接收地址：'+data['collect']['to_address']+'</li>';
    return str;
}

function collectTxChange(data) {
    if(data['collect'] === null){
        return '--';
    }
    var str= '';
    str  = str+
        '<li>'+'txID：'+data['collect']['tx']+'</li>'+
        '<li>'+'tx时间：'+data['collect']['tx_time']+'</li>'+
        '<li>'+'操作员：'+data['collect']['admin_uid']+'/'+data['collect']['operator_user']+'</li>'+
        '<li>'+'操作时间：'+data['collect']['add_time']+'</li>';
    return str;
}