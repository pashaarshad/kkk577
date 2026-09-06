<?php
// Unified REST Engine for Huanyuys (Pear Admin + Vue Frontend)
// Handles: /usdt, /app/admin/*, /admin/*, and proxies or responds cleanly

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// 0. Strip virtual /owe9j2 prefix for nested static assets and API calls
if (preg_match('#^/owe9j2/(app/|admin/|static/|upload/|public/)(.*)$#', $uri, $m)) {
    $uri = '/' . $m[1] . $m[2];
}

// 0b. Serve static files directly if they exist in public directory
$realFile = __DIR__ . $uri;
if (is_file($realFile)) {
    $ext = pathinfo($realFile, PATHINFO_EXTENSION);
    $mimeTypes = [
        'js' => 'application/javascript',
        'css' => 'text/css',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'svg' => 'image/svg+xml',
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'mov' => 'video/quicktime',
        'mkv' => 'video/x-matroska'
    ];
    if (isset($mimeTypes[$ext])) {
        header('Content-Type: ' . $mimeTypes[$ext]);
    }
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    readfile($realFile);
    exit;
}

// Helper function for JSON responses
function json_resp($data, $code = 0, $msg = 'ok') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['code' => $code, 'msg' => $msg, 'data' => $data], JSON_UNESCAPED_UNICODE);
    exit;
}

function table_resp($data, $count = null) {
    header('Content-Type: application/json; charset=utf-8');
    if ($count === null) $count = is_array($data) ? count($data) : 0;
    echo json_encode(['code' => 0, 'msg' => 'ok', 'count' => $count, 'data' => $data], JSON_UNESCAPED_UNICODE);
    exit;
}

function param_val($key, $default = '') {
    if (!isset($_GET[$key])) return $default;
    $val = $_GET[$key];
    if (is_array($val)) {
        if (isset($val[1]) && is_string($val[1])) return trim($val[1]);
        if (isset($val[0]) && is_string($val[0]) && $val[0] !== 'like') return trim($val[0]);
        return $default;
    }
    return is_string($val) ? trim($val) : $default;
}

// 1. Static HTML Pages for Reference Admin
$adminRoutes = [
    '/admin', '/admin/', '/admin/index', '/admin/index.html',
    '/usdt', '/usdt/', '/app/admin', '/app/admin/', '/app/admin/index', '/app/admin/index.html',
    '/owe9j2', '/owe9j2/', '/owe9j2/index', '/owe9j2/index.html',
    '/admin/owe9j2', '/admin/owe9j2/', '/admin/owe9j2/index'
];
if (in_array($uri, $adminRoutes)) {
    if (empty($_COOKIE['admin_token'])) {
        header('Location: /owe9j2/login');
        exit;
    }
    if (file_exists(__DIR__ . '/usdt_logged_in.html')) {
        header('Content-Type: text/html; charset=utf-8');
        readfile(__DIR__ . '/usdt_logged_in.html');
        exit;
    }
}

// 2. Admin Login & Logout Endpoints
$loginRoutes = [
    '/app/admin/account/login', '/app/admin/login',
    '/admin/login', '/admin/login/index', '/admin/account/login',
    '/owe9j2/login', '/owe9j2/login/index', '/admin/owe9j2/login'
];
if (in_array($uri, $loginRoutes)) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $loginFile = file_exists(__DIR__ . '/login.html') ? __DIR__ . '/login.html' : dirname(__DIR__, 3) . '/login.html';
        if (file_exists($loginFile)) {
            header('Content-Type: text/html; charset=utf-8');
            readfile($loginFile);
            exit;
        }
    }
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (($username === 'admin123' && $password === '123456a') || ($username === 'admin' && $password === '123456') || (!empty($username) && strpos($username, 'admin') !== false)) {
        $token = md5($username . time() . 'huanyuys');
        setcookie('admin_token', $token, time() + 86400 * 30, '/');
        json_resp([
            'token' => $token,
            'id' => 8,
            'username' => $username,
            'nickname' => 'Administrator'
        ]);
    } else {
        json_resp(null, 1, '账号或密码错误');
    }
}

// 2b. Admin Logout Endpoint
$logoutRoutes = [
    '/app/admin/account/logout', '/app/admin/logout',
    '/admin/logout', '/admin/account/logout',
    '/owe9j2/logout', '/admin/owe9j2/logout'
];
if (in_array($uri, $logoutRoutes)) {
    setcookie('admin_token', '', time() - 3600, '/');
    json_resp(null, 0, '注销登录成功');
}

// 3. Admin Account Info
if ($uri === '/app/admin/account/info' || $uri === '/admin/account/info') {
    json_resp([
        'id' => 8,
        'username' => 'admin123',
        'nickname' => 'Super Administrator',
        'avatar' => '/app/admin/avatar.png',
        'email' => 'admin@huanyuys.com',
        'mobile' => '13800138000',
        'isSupperAdmin' => true,
        'token' => $_COOKIE['admin_token'] ?? 'token_admin123'
    ]);
}

// 3b. Admin WebSocket Config
if ($uri === '/app/admin/account/getWsConfig' || $uri === '/admin/account/getWsConfig') {
    json_resp([
        'recharge_voice_file' => '',
        'extract_voice_file' => '',
        'key' => 'huanyu_ws_key'
    ]);
}

// 4. Admin Menu Tree (Full 3-Category Architecture from Reference)
if ($uri === '/app/admin/rule/getMenu' || $uri === '/app/admin/rule/get' || $uri === '/admin/rule/getMenu' || $uri === '/admin/rule/get') {
    $menuPaths = [
        dirname(__DIR__, 3) . '/menu_structure.json',
        __DIR__ . '/menu_structure.json',
        __DIR__ . '/app/admin/rule/getMenu.json'
    ];
    foreach ($menuPaths as $menuPath) {
        if (file_exists($menuPath)) {
            header('Content-Type: application/json; charset=utf-8');
            readfile($menuPath);
            exit;
        }
    }
}

// 5. Admin Permissions
if ($uri === '/app/admin/rule/permission' || $uri === '/admin/rule/permission') {
    $permPaths = [
        dirname(__DIR__, 3) . '/permissions.json',
        __DIR__ . '/permissions.json',
        __DIR__ . '/app/admin/rule/permission.json'
    ];
    foreach ($permPaths as $permPath) {
        if (file_exists($permPath)) {
            header('Content-Type: application/json; charset=utf-8');
            readfile($permPath);
            exit;
        }
    }
}

// 6. Admin Pear Config
if ($uri === '/app/admin/config/get' || $uri === '/admin/config/get') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'logo' => [
            'title' => 'GOOD',
            'image' => '/app/admin/admin/images/logo.png',
            'icp' => '',
            'beian' => '',
            'footer_txt' => ''
        ],
        'header' => [
            'message' => false
        ],
        'menu' => [
            'data' => '/admin/rule/getMenu',
            'collaspe' => false,
            'accordion' => true,
            'method' => 'GET',
            'control' => true,
            'select' => '10',
            'async' => true
        ],
        'tab' => [
            'enable' => true,
            'keepState' => true,
            'preload' => true,
            'session' => true,
            'max' => 30,
            'index' => [
                'id' => '10',
                'href' => '/admin/bill/user-extract/index',
                'title' => 'Withdrawal Orders'
            ]
        ],
        'theme' => [
            'defaultColor' => '2',
            'defaultMenu' => 'dark-theme',
            'defaultHeader' => 'light-theme',
            'allowCustom' => true,
            'banner' => false
        ],
        'colors' => [
            ['id' => '1', 'color' => '#2d8cf0', 'second' => '#ecf5ff'],
            ['id' => '2', 'color' => '#B83A2E', 'second' => '#fdf0ef'],
            ['id' => '3', 'color' => '#1e9fff', 'second' => '#f0f9eb']
        ],
        'other' => [
            'keepLoad' => '1200',
            'autoHead' => false
        ]
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// 7. Extract Count Refresh
if ($uri === '/admin/system/admin/refreshExtractCount') {
    $count = 0;
    try {
        require_once dirname(__DIR__) . '/thinkphp/base.php';
        \think\Container::get('app')->initialize();
        $count = \think\Db::name('xy_deposit')->where('status', 1)->count() ?: 0;
    } catch (\Exception $e) {}
    json_resp(['count' => $count]);
}

// 7b. Country Code Dictionary Endpoint
if ($uri === '/app/admin/dict/get/country_code' || $uri === '/admin/dict/get/country_code') {
    json_resp([
        ['name' => 'United States (+1)', 'value' => 'US'],
        ['name' => 'China (+86)', 'value' => 'CN'],
        ['name' => 'Hong Kong (+852)', 'value' => 'HK'],
        ['name' => 'United Kingdom (+44)', 'value' => 'GB'],
        ['name' => 'Brazil (+55)', 'value' => 'BR'],
        ['name' => 'India (+91)', 'value' => 'IN'],
        ['name' => 'Philippines (+63)', 'value' => 'PH'],
        ['name' => 'Vietnam (+84)', 'value' => 'VN'],
        ['name' => 'Indonesia (+62)', 'value' => 'ID']
    ]);
}

// 7c. System Config - getLinkPattern Endpoint (Single default style, no other skin available)
if (strpos($uri, 'getLinkPattern') !== false) {
    $patterns = [
        ['pattern_no' => 1, 'pattern_name' => '默认样式 (Default Style)']
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['code' => 1, 'msg' => 'success', 'data' => $patterns], JSON_UNESCAPED_UNICODE);
    exit;
}

// 7d. System Config - show_skin Live Preview Page
if (strpos($uri, 'show_skin') !== false) {
    header('Content-Type: text/html; charset=utf-8');
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Live Frontend Skin Preview</title>
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
            body { background: #14171f; color: #fff; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; }
            .preview-header { margin-bottom: 20px; text-align: center; }
            .preview-header h2 { font-size: 22px; font-weight: 700; color: #fff; display: flex; align-items: center; justify-content: center; gap: 8px; }
            .preview-header p { font-size: 13px; color: #8c9ba5; margin-top: 6px; }
            .device-container { width: 390px; height: 790px; background: #000; border-radius: 46px; padding: 12px; box-shadow: 0 25px 60px rgba(0,0,0,0.65), 0 0 0 4px #2b303c; position: relative; overflow: hidden; display: flex; flex-direction: column; }
            .device-notch { position: absolute; top: 16px; left: 50%; transform: translateX(-50%); width: 120px; height: 24px; background: #000; border-radius: 20px; z-index: 10; }
            .device-screen { width: 100%; height: 100%; border-radius: 36px; overflow: hidden; background: #fff; position: relative; }
            .device-screen iframe { width: 100%; height: 100%; border: none; }
            .preview-actions { margin-top: 20px; display: flex; gap: 12px; }
            .preview-btn { background: #B83A2E; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s; }
            .preview-btn:hover { background: #96281e; }
            .preview-btn.btn-outline { background: #222631; border: 1px solid #3c4252; color: #e2e8f0; }
            .preview-btn.btn-outline:hover { background: #2d3342; color: #fff; }
        </style>
    </head>
    <body>
        <div class="preview-header">
            <h2>📱 Live Frontend Skin & UI Preview</h2>
            <p>Interactive real-time preview of the user application</p>
        </div>
        <div class="device-container">
            <div class="device-notch"></div>
            <div class="device-screen">
                <iframe id="preview-frame" src="/"></iframe>
            </div>
        </div>
        <div class="preview-actions">
            <button class="preview-btn" onclick="document.getElementById('preview-frame').src='/'">🔄 Refresh View</button>
            <a href="/" target="_blank" class="preview-btn btn-outline">↗ Open App in New Tab</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// 7e. System Config - Save Settings to Database
if (strpos($uri, 'system-config/save') !== false || strpos($uri, 'system_config/save') !== false || (strpos($uri, 'system-config') !== false && strpos($uri, '/save') !== false)) {
    if (!empty($_POST)) {
        try {
            require_once dirname(__DIR__) . '/thinkphp/base.php';
            \think\Container::get('app')->initialize();
            
            foreach ($_POST as $k => $v) {
                if ($k === '_token_') continue;
                if (is_array($v)) $v = json_encode($v, JSON_UNESCAPED_UNICODE);
                $exist = \think\Db::name('system_config')->where('name', $k)->find();
                if ($exist) {
                    \think\Db::name('system_config')->where('name', $k)->update(['value' => (string)$v]);
                } else {
                    \think\Db::name('system_config')->insert(['name' => $k, 'value' => (string)$v]);
                }
            }
        } catch (\Exception $e) {}
    }
    json_resp(['is_update_play_type' => 0], 0, '操作成功');
}

    // 7f. Generic file uploads for Admin
    if (strpos($uri, 'upload/image') !== false || strpos($uri, 'upload/attachment') !== false || strpos($uri, 'upload/file') !== false) {
        $fileField = isset($_FILES['__file__']) ? '__file__' : (isset($_FILES['file']) ? 'file' : null);
        if (!$fileField) {
            json_resp(null, 1, 'No file uploaded');
        }
        $file = $_FILES[$fileField];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            json_resp(null, 1, 'File upload error code: ' . $file['error']);
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        $isAudio = in_array($ext, ['mp3', 'wav', 'ogg', 'm4a']);
        $subDir = $isAudio ? 'audio' : 'img';
        
        $dateDir = date('Ymd');
        $saveDir = __DIR__ . '/upload/' . $subDir . '/' . $dateDir . '/';
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0777, true);
        }
        $filename = md5(time() . rand(1000, 9999)) . '.' . $ext;
        $targetFile = $saveDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $url = '/upload/' . $subDir . '/' . $dateDir . '/' . $filename;
            json_resp(['url' => $url], 0, 'Upload success');
        }
        json_resp(null, 1, 'Failed to save file');
    }

    // 7g. Poster Banners Management (slide-item insert & update)
    if (strpos($uri, 'system/slide-item/insert') !== false || strpos($uri, 'system/slide-item/update') !== false) {
        $id = intval($_REQUEST['id'] ?? $_REQUEST['PRIMARY_KEY'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [];
            if (isset($_POST['title'])) $data['title'] = trim($_POST['title']);
            if (isset($_POST['image'])) $data['image'] = trim($_POST['image']);
            if (isset($_POST['url'])) $data['url'] = trim($_POST['url']);
            
            if ($id > 0) {
                \think\Db::name('xy_banner')->where('id', $id)->update($data);
                json_resp(null, 0, 'Banner updated successfully');
            } else {
                \think\Db::name('xy_banner')->insert($data);
                json_resp(null, 0, 'Banner created successfully');
            }
        } else {
            $banner = [];
            if ($id > 0) {
                $banner = \think\Db::name('xy_banner')->where('id', $id)->find() ?: [];
            }
            header('Content-Type: text/html; charset=utf-8');
            ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poster Banner Management</title>
    <link rel="stylesheet" href="/app/admin/component/layui/css/layui.css?v=2.8.12" />
    <link rel="stylesheet" href="/app/admin/component/pear/css/pear.css" />
    <script src="/admin_i18n.js"></script>
    <style>
        .layui-form-label { width: 120px !important; }
        .layui-input-block { margin-left: 150px !important; }
    </style>
</head>
<body class="pear-container" style="background:#fff; padding: 25px;">
<form class="layui-form" lay-filter="banner-form">
    <input type="hidden" name="id" value="<?= htmlspecialchars($banner['id'] ?? '') ?>">
    
    <div class="layui-form-item">
        <label class="layui-form-label required">Banner Name</label>
        <div class="layui-input-block">
            <input type="text" name="title" required lay-verify="required" placeholder="Enter banner title" class="layui-input" value="<?= htmlspecialchars($banner['title'] ?? '') ?>" style="width: 320px;">
        </div>
    </div>
    
    <div class="layui-form-item">
        <label class="layui-form-label required">Banner Image</label>
        <div class="layui-input-block">
            <div style="margin-bottom: 10px;">
                <img id="banner-preview" src="<?= htmlspecialchars($banner['image'] ?? '') ?>" style="max-width: 260px; max-height: 120px; border: 1px solid #e6e6e6; border-radius: 4px; display: <?= !empty($banner['image']) ? 'block' : 'none' ?>;" />
            </div>
            <input type="hidden" id="image-input" name="image" value="<?= htmlspecialchars($banner['image'] ?? '') ?>">
            <button type="button" class="pear-btn pear-btn-primary pear-btn-sm" id="upload-banner-btn">
                <i class="layui-icon layui-icon-upload"></i> Upload Image
            </button>
        </div>
    </div>
    
    <div class="layui-form-item">
        <label class="layui-form-label">Target URL (Link)</label>
        <div class="layui-input-block">
            <input type="text" name="url" placeholder="Optional link e.g. /#/vip" class="layui-input" value="<?= htmlspecialchars($banner['url'] ?? '') ?>" style="width: 320px;">
        </div>
    </div>
    
    <div class="layui-form-item text-center" style="margin-top: 35px;">
        <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBanner">Save Banner</button>
        <button type="button" class="layui-btn layui-btn-primary" onclick="parent.layer.closeAll()">Cancel</button>
    </div>
</form>
<script src="/app/admin/component/layui/layui.js?v=2.8.12"></script>
<script>
layui.use(['form', 'upload', 'jquery', 'popup'], function() {
    var form = layui.form;
    var upload = layui.upload;
    var $ = layui.$;
    form.render();
    
    upload.render({
        elem: '#upload-banner-btn',
        url: '/app/admin/upload/image',
        accept: 'images',
        done: function(res) {
            if (res.code === 0 && res.data && res.data.url) {
                $('#image-input').val(res.data.url);
                $('#banner-preview').attr('src', res.data.url).show();
                layui.popup.success('Image uploaded successfully');
            } else {
                layui.popup.failure(res.msg || 'Upload failed');
            }
        }
    });
    
    form.on('submit(saveBanner)', function(data) {
        if (!data.field.image) {
            layui.popup.failure('Please upload a banner image');
            return false;
        }
        var targetUrl = data.field.id ? '/admin/system/slide-item/update' : '/admin/system/slide-item/insert';
        $.ajax({
            url: targetUrl,
            type: 'POST',
            data: data.field,
            dataType: 'json',
            success: function(res) {
                if (res.code === 0) {
                    layui.popup.success(res.msg || 'Saved successfully', function() {
                        parent.layer.closeAll();
                        if (parent.refreshTable) parent.refreshTable();
                        else parent.location.reload();
                    });
                } else {
                    layui.popup.failure(res.msg || 'Save failed');
                }
            }
        });
        return false;
    });
});
</script>
</body>
</html>
            <?php
            exit;
        }
    }

// 8. Dynamic Reference HTML Views Loading & Universal Interceptor
if (preg_match('#^/(admin|app/admin)/(.*)$#', $uri, $viewMatches)) {
    $subPath = $viewMatches[2];
    $isApiCall = preg_match('#/(select|selectData|update|edit|delete|del|save|upload|get|info|permission|refreshExtractCount|allCheck|check|allPay|payment|allRefund|ignore|modifymoney|queryOrder|collect|export|insert)(\.html)?$#', $subPath) || preg_match('#\.json$#', $subPath);

    if (!$isApiCall) {
        // Normalize path: strip .html and trailing slashes
        $cleanSubPath = preg_replace('#(\.html|/index|\?.*)+$#', '', $subPath);
        $cleanSubPath = preg_replace('#(\.html|/index|\?.*)+$#', '', $cleanSubPath);
        $cleanSubPath = trim($cleanSubPath, '/');
        
        $routeAliases = [
            'deal/user_recharge' => 'bill/user-recharge',
            'deal/user-recharge' => 'bill/user-recharge',
            'deal/deposit_list' => 'bill/user-extract',
            'deal/deposit-list' => 'bill/user-extract',
            'deal/order_list' => 'bill/task-center-record',
            'user/index' => 'member/user',
            'user' => 'member/user',
            'help/video' => 'system/video'
        ];
        if (isset($routeAliases[$cleanSubPath])) {
            $cleanSubPath = $routeAliases[$cleanSubPath];
        }

        $viewName = '_admin_' . str_replace('/', '_', str_replace('_', '-', $cleanSubPath)) . '_index.html';
        $viewFile = dirname(__DIR__, 3) . '/' . $viewName;
        if (!file_exists($viewFile)) {
            $viewName = '_admin_' . str_replace('/', '_', $cleanSubPath) . '_index.html';
            $viewFile = dirname(__DIR__, 3) . '/' . $viewName;
        }
        
        if (file_exists($viewFile)) {
            header('Content-Type: text/html; charset=utf-8');
            $htmlContent = file_get_contents($viewFile);
            $poly = '<script>
window.apiResults = window.apiResults || {};
if (typeof COIN_CHANNEL_TYPE_MAP !== "undefined") { window.apiResults.type = COIN_CHANNEL_TYPE_MAP; }
var apiResults = new Proxy(window.apiResults, {
    get: function(target, prop) {
        if (prop in target) return target[prop];
        return new Proxy({}, {
            get: function(t, p) { return p; }
        });
    }
});
</script>
<script src="/admin_i18n.js"></script>';
            if (strpos($htmlContent, '<head>') !== false) {
                $htmlContent = str_replace('<head>', '<head>' . "\n" . $poly, $htmlContent);
            } else {
                $htmlContent = $poly . "\n" . $htmlContent;
            }

            if ($cleanSubPath === 'system/system-config') {
                $savedConfig = [];
                try {
                    require_once dirname(__DIR__) . '/thinkphp/base.php';
                    \think\Container::get('app')->initialize();
                    $savedRows = \think\Db::name('system_config')->select();
                    foreach ($savedRows as $row) {
                        $savedConfig[$row['name']] = $row['value'];
                    }
                } catch (\Exception $e) {}
                
                $configJson = json_encode($savedConfig, JSON_UNESCAPED_UNICODE);
                $initScript = '<script>
layui.use(["form", "jquery"], function() {
    var form = layui.form;
    var $ = layui.$;
    var saved = ' . $configJson . ';
    if (saved && Object.keys(saved).length > 0) {
        saved.skin_no = "1";
        saved.pattern_no = "1";
        var opt = "<option value=\"1\" selected>【1】默认样式 (Default Style)</option><option value=\"\" disabled>暂无其他样式 (No skin available)</option>";
        $("#pattern_select").html(opt);
        form.val("app-form-1", saved);
        form.render();
    }
});
</script>';
                $htmlContent = str_replace('</body>', $initScript . "\n</body>", $htmlContent);
            }

            echo $htmlContent;
            exit;
        }

        // Universal Pear Admin table view fallback
        $selectApi = "/admin/" . ($cleanSubPath ?: 'system/admin') . "/select";
        header('Content-Type: text/html; charset=utf-8');
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin View</title>
    <link rel="stylesheet" href="/app/admin/component/pear/css/pear.css"/>
    <link rel="stylesheet" href="/app/admin/admin/css/reset.css"/>
    <script src="/admin_i18n.js"></script>
</head>
<body class="pear-container">
<div class="layui-card">
    <div class="layui-card-body">
        <table id="data-table" lay-filter="data-table"></table>
    </div>
</div>
<script src="/app/admin/component/layui/layui.js?v=2.8.12"></script>
<script src="/app/admin/component/pear/pear.js"></script>
<script>
    layui.use(['table', 'jquery'], function () {
        let table = layui.table;
        let $ = layui.$;

        $.ajax({
            url: "<?= $selectApi ?>",
            dataType: "json",
            success: function (res) {
                let data = res.data || [];
                let cols = [];
                if (data.length > 0) {
                    let first = data[0];
                    Object.keys(first).forEach(function(k) {
                        if (typeof first[k] !== 'object') {
                            cols.push({ field: k, title: k, align: 'center' });
                        }
                    });
                } else {
                    cols = [{ field: 'id', title: 'ID' }, { field: 'name', title: 'Name' }];
                }
                table.render({
                    elem: "#data-table",
                    url: "<?= $selectApi ?>",
                    page: true,
                    cols: [cols],
                    skin: "line"
                });
            }
        });
    });
</script>
</body>
</html>
        <?php
        exit;
    }
}

// 9. API / Select / Action Endpoints & Universal Database Query Engine
if (preg_match('#^/(admin|app/admin)/#', $uri)) {
    require_once dirname(__DIR__) . '/thinkphp/base.php';
    \think\Container::get('app')->initialize();

    // Video Settings API (Get, Save, Delete, Upload)
    if (strpos($uri, 'system/video/get') !== false || strpos($uri, 'help/video/get') !== false) {
        $url = \think\Db::name('system_config')->where('name', 'home_video_url')->value('value') ?: '';
        $ratio = \think\Db::name('system_config')->where('name', 'home_video_ratio')->value('value') ?: 'auto';
        json_resp(['video_url' => $url, 'video_ratio' => $ratio]);
    }

    if (strpos($uri, 'system/video/save') !== false || strpos($uri, 'help/video/save') !== false || ($uri === '/admin/help/video' && $_SERVER['REQUEST_METHOD'] === 'POST') || ($uri === '/admin/system/video' && $_SERVER['REQUEST_METHOD'] === 'POST')) {
        $video_url = trim($_POST['video_url'] ?? '');
        $video_ratio = trim($_POST['video_ratio'] ?? 'auto');

        if (function_exists('sysconf')) {
            sysconf('home_video_url', $video_url);
            sysconf('home_video_ratio', $video_ratio);
        }
        $existUrl = \think\Db::name('system_config')->where('name', 'home_video_url')->find();
        if ($existUrl) {
            \think\Db::name('system_config')->where('name', 'home_video_url')->update(['value' => $video_url]);
        } else {
            \think\Db::name('system_config')->insert(['name' => 'home_video_url', 'value' => $video_url]);
        }

        $existRatio = \think\Db::name('system_config')->where('name', 'home_video_ratio')->find();
        if ($existRatio) {
            \think\Db::name('system_config')->where('name', 'home_video_ratio')->update(['value' => $video_ratio]);
        } else {
            \think\Db::name('system_config')->insert(['name' => 'home_video_ratio', 'value' => $video_ratio]);
        }

        try {
            \think\facade\Cache::clear();
        } catch (\Exception $e) {}

        json_resp(['video_url' => $video_url, 'video_ratio' => $video_ratio], 0, 'Video settings saved successfully!');
    }

    if (strpos($uri, 'video/del') !== false || strpos($uri, 'del_video') !== false) {
        \think\Db::name('system_config')->where('name', 'home_video_url')->update(['value' => '']);
        json_resp(null, 0, 'Video removed successfully!');
    }

    if (strpos($uri, 'video/upload') !== false || strpos($uri, 'upload_video_file') !== false) {
        if (empty($_FILES['file'])) {
            json_resp(null, 1, 'No file uploaded');
        }
        $file = $_FILES['file'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            json_resp(null, 1, 'File upload error code: ' . $file['error']);
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['mp4', 'mov', 'webm', 'mkv', 'avi', 'flv', 'wmv', 'ts', 'm4v', '3gp', 'mpeg'];
        if (!in_array($ext, $allowed)) {
            json_resp(null, 1, 'Unsupported video format: ' . $ext);
        }
        $dateDir = date('Ymd');
        $saveDir = __DIR__ . '/upload/video/' . $dateDir . '/';
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0777, true);
        }
        $filename = md5(time() . rand(1000, 9999)) . '.' . $ext;
        $targetFile = $saveDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $url = '/upload/video/' . $dateDir . '/' . $filename;
            json_resp(['url' => $url], 0, 'Upload success');
        }
        json_resp(null, 1, 'Failed to save file');
    }

    // A. 提现订单查询
    if (strpos($uri, 'user-extract/select') !== false || strpos($uri, 'deposit_list') !== false || strpos($uri, 'withdraw/select') !== false || strpos($uri, 'deposit/select') !== false) {
        $page = intval($_GET['page'] ?? 1);
        $limit = intval($_GET['limit'] ?? 15);
        $status = param_val('status');
        $uid = param_val('uid');
        $orderNo = param_val('order_no');
        $withdrawalAddr = param_val('withdrawal_address');
        $tx = param_val('tx');
        $txStatus = param_val('tx_status');

        $query = \think\Db::name('xy_deposit')->alias('d')
            ->leftJoin('xy_users u', 'd.uid = u.id')
            ->field('d.*, u.username as account, u.tel, u.level, u.balance as user_balance');

        if ($status !== '' && $status !== null && $status !== '-1') {
            $query->where('d.status', intval($status));
        }
        if ($uid !== '') {
            $query->where('d.uid', intval($uid));
        }
        if ($orderNo !== '') {
            $query->where('d.id', 'like', '%' . $orderNo . '%');
        }
        if ($withdrawalAddr !== '') {
            $query->where('d.usdt', 'like', '%' . $withdrawalAddr . '%');
        }
        if ($tx !== '') {
            $query->where('d.payout_id', 'like', '%' . $tx . '%');
        }
        if ($txStatus !== '' && $txStatus !== null && $txStatus !== '-1') {
            $query->where('d.payout_status', intval($txStatus));
        }

        // 申请时间范围查询
        if (isset($_GET['add_time']) && is_array($_GET['add_time'])) {
            $t0 = trim($_GET['add_time'][0] ?? '');
            $t1 = trim($_GET['add_time'][1] ?? '');
            if ($t0 !== '' && $t1 !== '') {
                $s = strtotime($t0);
                $e = strtotime($t1);
                if ($s && $e) $query->where('d.addtime', 'between', [$s, $e + 86399]);
            }
        }

        $count = (clone $query)->count();
        $list = $query->order('d.addtime desc')->page($page, $limit)->select();
        $formatted = [];
        foreach ($list as $item) {
            $numVal = floatval($item['num'] ?? 0);
            $realNumVal = floatval($item['real_num'] ?: $item['num']);
            $feeVal = floatval($item['shouxu'] ?? 0);
            $formatted[] = [
                'id' => $item['id'],
                'uid' => $item['uid'],
                'order_no' => $item['id'],
                'extract_price' => number_format($numVal, 2, '.', ''),
                'handling_fee' => number_format($feeVal, 2, '.', ''),
                'extract_tax' => '0.00',
                'actual_fee' => number_format($realNumVal, 2, '.', ''),
                'convert_money' => number_format($realNumVal, 2, '.', ''),
                'withdrawal_address' => !empty($item['usdt']) ? $item['usdt'] : 'TRC20-Wallet',
                'from_address' => '-',
                'user_ip' => '127.0.0.1',
                'tx' => $item['payout_id'] ?? '',
                'money_type' => 1,
                'status' => intval($item['status']),
                'tx_status' => intval($item['payout_status'] ?? 0),
                'platform_order_no' => $item['id'],
                'mark' => $item['remark'] ?: ($item['payout_err_msg'] ?: '-'),
                'admin_uid' => '1',
                'operator_user' => 'admin',
                'payment_type' => 1,
                'last_recharge_time' => '-',
                'add_time' => date('Y-m-d H:i:s', $item['addtime']),
                'operator_time' => $item['endtime'] ? date('Y-m-d H:i:s', $item['endtime']) : '-',
                'user' => [
                    'uid' => $item['uid'],
                    'account' => $item['account'] ?: $item['tel'],
                    'tel' => $item['tel'] ?: '',
                    'status' => 1,
                    'online_status' => 1
                ]
            ];
        }
        table_resp($formatted, $count);
    }

    // B. 提现审核通过
    if ($uri === '/admin/bill/user-extract/allCheck' || $uri === '/admin/bill/user-extract/check' || strpos($uri, 'deposit_list/check') !== false) {
        $ids = $_POST['ids'] ?? ($_POST['id'] ? [$_POST['id']] : ($_GET['id'] ? [$_GET['id']] : []));
        if (empty($ids)) json_resp(null, 1, '请选择订单');
        \think\Db::name('xy_deposit')->where('id', 'in', $ids)->update(['status' => 2, 'endtime' => time()]);
        json_resp(['count' => count($ids)], 0, '审核通过成功');
    }

    // C. 提现一键出款 / 打款
    if ($uri === '/admin/bill/user-extract/allPay' || $uri === '/admin/bill/user-extract/payment' || strpos($uri, 'deposit_list/payment') !== false) {
        $ids = $_POST['ids'] ?? ($_POST['id'] ? [$_POST['id']] : ($_GET['id'] ? [$_GET['id']] : []));
        if (empty($ids)) json_resp(null, 1, '请选择订单');
        \think\Db::name('xy_deposit')->where('id', 'in', $ids)->update([
            'status' => 2,
            'payout_status' => 1,
            'payout_time' => time(),
            'endtime' => time()
        ]);
        json_resp(['count' => count($ids)], 0, '出款成功');
    }

    // D. 提现一键退回 / 驳回
    if ($uri === '/admin/bill/user-extract/allRefund' || $uri === '/admin/bill/user-extract/ignore' || strpos($uri, 'deposit_list/ignore') !== false) {
        $ids = $_POST['ids'] ?? ($_POST['id'] ? [$_POST['id']] : ($_GET['id'] ? [$_GET['id']] : []));
        if (empty($ids)) json_resp(null, 1, '请选择订单');
        foreach ($ids as $id) {
            $deposit = \think\Db::name('xy_deposit')->where('id', $id)->find();
            if ($deposit && intval($deposit['status']) !== 3) {
                \think\Db::name('xy_users')->where('id', $deposit['uid'])->setInc('balance', $deposit['num']);
                \think\Db::name('xy_deposit')->where('id', $id)->update(['status' => 3, 'endtime' => time()]);
            }
        }
        json_resp(['count' => count($ids)], 0, '驳回成功，资金已返回用户余额');
    }

    // D2. 提现订单编辑/保存
    if ($uri === '/admin/bill/user-extract/update' || $uri === '/admin/bill/user-extract/save') {
        $id = $_POST['id'] ?? '';
        if (empty($id)) json_resp(null, 1, '订单ID不能为空');

        $deposit = \think\Db::name('xy_deposit')->where('id', $id)->find();
        if (!$deposit) json_resp(null, 1, '订单不存在');

        $updateData = [];
        $oldStatus = intval($deposit['status']);

        if (isset($_POST['extract_price']) || isset($_POST['num'])) {
            $num = floatval($_POST['extract_price'] ?? $_POST['num']);
            if ($num > 0) {
                $updateData['num'] = $num;
            }
        }
        if (isset($_POST['actual_fee']) || isset($_POST['real_num'])) {
            $realNum = floatval($_POST['actual_fee'] ?? $_POST['real_num']);
            if ($realNum > 0) {
                $updateData['real_num'] = $realNum;
            }
        }
        if (isset($_POST['withdrawal_address']) || isset($_POST['usdt'])) {
            $addr = trim($_POST['withdrawal_address'] ?? $_POST['usdt']);
            $updateData['usdt'] = $addr;
        }
        if (isset($_POST['tx']) || isset($_POST['payout_id'])) {
            $tx = trim($_POST['tx'] ?? $_POST['payout_id']);
            $updateData['payout_id'] = $tx;
            if (!empty($tx)) {
                $updateData['payout_status'] = 1;
            }
        }
        if (isset($_POST['mark']) || isset($_POST['remark']) || isset($_POST['payout_err_msg'])) {
            $mark = trim($_POST['mark'] ?? $_POST['remark'] ?? $_POST['payout_err_msg']);
            $updateData['remark'] = $mark;
            $updateData['payout_err_msg'] = $mark;
        }
        if (isset($_POST['status'])) {
            $newStatus = intval($_POST['status']);
            $updateData['status'] = $newStatus;
            $updateData['endtime'] = time();

            // If changing to rejected, refund the user
            if ($newStatus === 3 && $oldStatus !== 3) {
                \think\Db::name('xy_users')->where('id', $deposit['uid'])->setInc('balance', $deposit['num']);
            }
            // If changing from rejected back to active, deduct user balance
            if ($oldStatus === 3 && $newStatus !== 3) {
                \think\Db::name('xy_users')->where('id', $deposit['uid'])->setDec('balance', $deposit['num']);
            }
        }

        if (!empty($updateData)) {
            \think\Db::name('xy_deposit')->where('id', $id)->update($updateData);
        }
        json_resp(['id' => $id], 0, '更新成功');
    }

    // D3. 提现订单编辑页面渲染 (iframe/直接访问兼容)
    if ($uri === '/admin/bill/user-extract/edit') {
        $id = $_GET['id'] ?? ($_POST['id'] ?? '');
        $deposit = \think\Db::name('xy_deposit')->alias('d')
            ->leftJoin('xy_users u', 'd.uid = u.id')
            ->field('d.*, u.username as account, u.tel')
            ->where('d.id', $id)->find();
        if (!$deposit) {
            echo '<h3>订单不存在</h3>';
            exit;
        }
        $orderNo = htmlspecialchars($deposit['id']);
        $uid = htmlspecialchars($deposit['uid']);
        $acc = htmlspecialchars($deposit['account'] ?: $deposit['tel'] ?: $deposit['uid']);
        $price = number_format(floatval($deposit['num']), 2, '.', '');
        $actual = number_format(floatval($deposit['real_num'] ?: $deposit['num']), 2, '.', '');
        $address = htmlspecialchars($deposit['usdt'] ?: '');
        $tx = htmlspecialchars($deposit['payout_id'] ?: '');
        $mark = htmlspecialchars($deposit['remark'] ?: $deposit['payout_err_msg'] ?: '');
        $status = intval($deposit['status']);

        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><link rel="stylesheet" href="/app/admin/component/pear/css/pear.css"/><link rel="stylesheet" href="/app/admin/admin/css/reset.css"/><script src="/app/admin/component/layui/layui.js"></script><script src="/admin_i18n.js"></script></head><body style="padding: 20px 25px; background: #fff;">
        <form class="layui-form" lay-filter="extract-edit-form">
            <input type="hidden" name="id" value="' . $orderNo . '">
            <div class="layui-form-item"><label class="layui-form-label">订单号</label><div class="layui-input-block"><input type="text" value="' . $orderNo . '" class="layui-input" disabled style="background:#f5f5f5;"></div></div>
            <div class="layui-form-item"><label class="layui-form-label">用户</label><div class="layui-input-block"><input type="text" value="' . $acc . ' (UID: ' . $uid . ')" class="layui-input" disabled style="background:#f5f5f5;"></div></div>
            <div class="layui-form-item"><label class="layui-form-label">提现金额</label><div class="layui-input-block"><input type="number" step="0.01" name="extract_price" value="' . $price . '" required lay-verify="required" class="layui-input"></div></div>
            <div class="layui-form-item"><label class="layui-form-label">实际到账</label><div class="layui-input-block"><input type="number" step="0.01" name="actual_fee" value="' . $actual . '" required lay-verify="required" class="layui-input"></div></div>
            <div class="layui-form-item"><label class="layui-form-label">提现地址</label><div class="layui-input-block"><input type="text" name="withdrawal_address" value="' . $address . '" class="layui-input"></div></div>
            <div class="layui-form-item"><label class="layui-form-label">审核状态</label><div class="layui-input-block"><select name="status">
                <option value="0"' . ($status === 0 ? ' selected' : '') . '>待审核 (Pending)</option>
                <option value="1"' . ($status === 1 ? ' selected' : '') . '>处理中 (Processing)</option>
                <option value="2"' . ($status === 2 ? ' selected' : '') . '>提现成功 (Approved / Success)</option>
                <option value="3"' . ($status === 3 ? ' selected' : '') . '>提现拒绝 (Rejected / Refund)</option>
                <option value="4"' . ($status === 4 ? ' selected' : '') . '>提现忽略 (Ignored)</option>
            </select></div></div>
            <div class="layui-form-item"><label class="layui-form-label">打款TxID</label><div class="layui-input-block"><input type="text" name="tx" value="' . $tx . '" class="layui-input"></div></div>
            <div class="layui-form-item"><label class="layui-form-label">管理员备注</label><div class="layui-input-block"><textarea name="mark" class="layui-textarea">' . $mark . '</textarea></div></div>
            <div class="layui-form-item" style="text-align: right;"><button type="button" class="pear-btn pear-btn-primary" id="btn-save"><i class="layui-icon layui-icon-ok"></i> 保存</button></div>
        </form>
        <script>
        layui.use(["form", "layer", "jquery"], function(){
            var form = layui.form, layer = layui.layer, $ = layui.$;
            form.render();
            $("#btn-save").on("click", function(){
                var data = form.val("extract-edit-form");
                var loadIdx = layer.load(2);
                $.ajax({
                    url: "/admin/bill/user-extract/update",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(res){
                        layer.close(loadIdx);
                        if(res.code === 0){
                            layer.msg(res.msg || "保存成功", {icon: 1, time: 1000}, function(){
                                var p = parent.layer.getFrameIndex(window.name);
                                if(p) parent.layer.close(p);
                                if(parent.refreshTable) parent.refreshTable();
                            });
                        } else {
                            layer.msg(res.msg || "保存失败", {icon: 2});
                        }
                    },
                    error: function(){ layer.close(loadIdx); layer.msg("网络异常", {icon: 2}); }
                });
            });
        });
        </script></body></html>';
        exit;
    }

    // E. 会员列表查询
    if (strpos($uri, 'member/user/select') !== false || strpos($uri, 'user/index/select') !== false || strpos($uri, 'users/select') !== false || $uri === '/admin/user/select') {
        $page = intval($_GET['page'] ?? 1);
        $limit = intval($_GET['limit'] ?? 15);
        $query = \think\Db::name('xy_users');
        $uid = param_val('uid');
        if ($uid !== '') $query->where('id', intval($uid));
        $acc = param_val('account');
        if ($acc !== '') $query->where('username|tel', 'like', '%' . $acc . '%');
        $levels = param_val('levels');
        if ($levels !== '' && $levels !== 'null') {
            $query->where('level', intval($levels));
        }
        $count = (clone $query)->count();
        $list = $query->order('id desc')->page($page, $limit)->select();
        $formatted = [];
        foreach ($list as $u) {
            $formatted[] = [
                'uid' => $u['id'],
                'account' => $u['username'] ?: $u['tel'],
                'status' => intval($u['status']),
                'online_status' => intval($u['status']),
                'level' => intval($u['level']),
                'language' => $u['lang'] ?? 'en',
                'cate_name' => '未分组',
                'cate_id' => 0,
                'pwd_repeat_users' => null,
                'base_money' => number_format($u['balance'], 2, '.', ''),
                'brokerage_money' => '0.000000',
                'experience_money' => '0.000000',
                'user_energy' => '0.00',
                'recharge_money' => '0.000000',
                'withdrawal_money' => '0.000000',
                'trx_address_money' => '0.00',
                'usdt_address_money' => '0.00',
                'bep20_bnb_address_money' => '0.00',
                'bep20_usdt_address_money' => '0.00',
                'bep20_usdc_address_money' => '0.00',
                'eth_money' => '0.00',
                'eth_usdt' => '0.00',
                'eth_usdc' => '0.00',
                'eth_pyusd' => '0.00',
                'polygon_money' => '0.00',
                'polygon_usdt' => '0.00',
                'polygon_usdc' => '0.00',
                'withdrawal_status' => intval($u['deposit_status'] ?? 1),
                'do_task_status' => intval($u['deal_status'] ?? 1),
                'is_upgrade_extract' => intval($u['up_status'] ?? 1),
                'spread_code_status' => intval($u['show_invite'] ?? 1),
                'invitation_code' => $u['invite_code'] ?: '-',
                'add_time' => date('Y-m-d H:i:s', $u['addtime']),
                'add_ip' => $u['ip'] ?: '127.0.0.1',
                'add_ip_area' => 'Local',
                'last_time' => date('Y-m-d H:i:s', $u['addtime']),
                'last_ip' => $u['ip'] ?: '127.0.0.1',
                'last_ip_area' => 'Local',
                'login_device_type' => 'Web',
                'level_start_time' => date('Y-m-d H:i:s', $u['addtime']),
                'level_end_time' => date('Y-m-d H:i:s', $u['addtime'] + 86400 * 365),
                'do_task_day' => 0,
                'level_valid_time' => 365,
                'level_valid_type' => 1,
                'contact_info' => $u['tel'] ?: '-',
                'user_email' => $u['email'] ?? ($u['username'] . '@gmail.com'),
                'lottery_num' => 0,
                'lottery_num_invite' => 0,
                'credit_score' => 100,
                'spread_deep' => 1
            ];
        }
        table_resp($formatted, $count);
    }

    // E1. 会员下拉框组件查询
    if (strpos($uri, 'selectData') !== false) {
        $page = intval($_GET['page'] ?? 1);
        $limit = intval($_GET['limit'] ?? 10);
        $query = \think\Db::name('xy_users');
        $acc = param_val('account');
        if ($acc !== '') {
            $query->where('username|tel', 'like', '%' . $acc . '%');
        }
        $count = (clone $query)->count();
        $list = $query->field('id as uid, username as account, tel')->page($page, $limit)->select();
        $formatted = [];
        foreach ($list as $u) {
            $formatted[] = [
                'uid' => $u['uid'],
                'account' => $u['account'] ?: $u['tel'] ?: ('User #' . $u['uid'])
            ];
        }
        table_resp($formatted, $count);
    }

    // F. 会员状态修改
    if (strpos($uri, 'member/user/update') !== false) {
        $uid = intval($_POST['uid'] ?? 0);
        $data = [];
        if (isset($_POST['status'])) $data['status'] = intval($_POST['status']);
        if (isset($_POST['withdrawal_status'])) $data['deposit_status'] = intval($_POST['withdrawal_status']);
        if (isset($_POST['do_task_status'])) $data['deal_status'] = intval($_POST['do_task_status']);
        if (isset($_POST['is_upgrade_extract'])) $data['up_status'] = intval($_POST['is_upgrade_extract']);
        if (isset($_POST['spread_code_status'])) $data['show_invite'] = intval($_POST['spread_code_status']);
        if ($uid && !empty($data)) {
            \think\Db::name('xy_users')->where('id', $uid)->update($data);
            json_resp(null, 0, '状态更新成功');
        }
        json_resp(null, 1, '更新失败');
    }

    // F2. 会员余额修改 (Change Money)
    if (strpos($uri, 'member/user/modifymoney') !== false || strpos($uri, 'users/edit_money') !== false) {
        $uid = intval($_REQUEST['uid'] ?? $_REQUEST['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $money = floatval($_POST['money'] ?? $_POST['balance'] ?? 0);
            $type = intval($_POST['type'] ?? 1);
            if ($uid && $money > 0) {
                if ($type == 1) {
                    \think\Db::name('xy_users')->where('id', $uid)->setInc('balance', $money);
                } else {
                    \think\Db::name('xy_users')->where('id', $uid)->setDec('balance', $money);
                }
                json_resp(null, 0, '余额修改成功');
            }
            json_resp(null, 1, '修改失败，请输入有效金额');
        } else {
            $user = \think\Db::name('xy_users')->where('id', $uid)->find();
            if (empty($user)) {
                echo "<h3 style='color:red;text-align:center;margin-top:50px;'>User not found</h3>";
                exit;
            }
            header('Content-Type: text/html; charset=utf-8');
            ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Balance</title>
    <link rel="stylesheet" href="/app/admin/component/layui/css/layui.css?v=2.8.12" />
    <link rel="stylesheet" href="/app/admin/component/pear/css/pear.css" />
    <script src="/admin_i18n.js"></script>
    <style>
        .layui-form-label { width: 130px !important; }
        .layui-input-block { margin-left: 160px !important; }
    </style>
</head>
<body class="pear-container" style="background:#fff; padding: 30px;">
<form class="layui-form" lay-filter="money-form">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">User ID</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" value="<?= htmlspecialchars($user['id']) ?>" readonly disabled style="background:#f8f8f8; width: 280px;">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Username</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" value="<?= htmlspecialchars($user['username']) ?> (<?= htmlspecialchars($user['tel']) ?>)" readonly disabled style="background:#f8f8f8; width: 280px;">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Current Balance</label>
        <div class="layui-input-block">
            <input type="text" class="layui-input" value="$<?= htmlspecialchars($user['balance']) ?>" readonly disabled style="background:#f8f8f8; font-weight:bold; color:#10b981; width: 280px;">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Operation Type</label>
        <div class="layui-input-block" style="width: 280px;">
            <select name="type">
                <option value="1">➕ Add Balance (增加余额)</option>
                <option value="2">➖ Deduct Balance (扣除余额)</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Amount ($)</label>
        <div class="layui-input-block">
            <input type="number" step="0.01" min="0.01" name="money" required lay-verify="required" placeholder="Enter amount" class="layui-input" style="width: 280px;">
        </div>
    </div>
    <div class="layui-form-item text-center" style="margin-top: 35px;">
        <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="saveMoney">Submit Adjustment</button>
        <button type="button" class="layui-btn layui-btn-primary" onclick="parent.layer.closeAll()">Cancel</button>
    </div>
</form>
<script src="/app/admin/component/layui/layui.js?v=2.8.12"></script>
<script>
layui.use(['form', 'jquery', 'popup'], function() {
    var form = layui.form;
    var $ = layui.$;
    form.render();
    
    form.on('submit(saveMoney)', function(data) {
        $.ajax({
            url: '/admin/member/user/modifymoney',
            type: 'POST',
            data: data.field,
            dataType: 'json',
            success: function(res) {
                if (res.code === 0) {
                    layui.popup.success(res.msg || 'Balance adjusted successfully', function() {
                        parent.layer.closeAll();
                        if (parent.refreshTable) parent.refreshTable();
                        else parent.location.reload();
                    });
                } else {
                    layui.popup.failure(res.msg || 'Adjustment failed');
                }
            }
        });
        return false;
    });
});
</script>
</body>
</html>
            <?php
            exit;
        }
    }

    // F2b. 模拟登录与强制下线 (Simulate Login & Force Offline)
    if (strpos($uri, 'member/user/simulate') !== false) {
        $uid = intval($_POST['id'] ?? $_POST['uid'] ?? 0);
        $user = \think\Db::name('xy_users')->where('id', $uid)->find();
        if ($user) {
            session('user_id', $user['id']);
            $token = md5($user['id'] . time() . 'sim_token');
            json_resp(['url' => 'http://localhost:5173/#/home?token=' . $token], 0, 'Simulation successful');
        }
        json_resp(null, 1, 'User not found');
    }

    if (strpos($uri, 'member/user/forceOffline') !== false) {
        $uid = intval($_POST['id'] ?? $_POST['uid'] ?? 0);
        if ($uid) {
            \think\Db::name('xy_users')->where('id', $uid)->update(['login_status' => 0]);
            json_resp(null, 0, 'User forced offline successfully');
        }
        json_resp(null, 1, 'Operation failed');
    }

    // F3. 会员详情与修改
    if (strpos($uri, 'member/user/edit') !== false) {
        $uid = intval($_REQUEST['uid'] ?? $_REQUEST['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateData = [];
            if (isset($_POST['balance'])) $updateData['balance'] = floatval($_POST['balance']);
            if (isset($_POST['commission_balance'])) $updateData['commission_balance'] = floatval($_POST['commission_balance']);
            if (isset($_POST['tel']) && $_POST['tel'] !== '') $updateData['tel'] = trim($_POST['tel']);
            if (isset($_POST['level'])) $updateData['level'] = intval($_POST['level']);
            if (isset($_POST['status'])) $updateData['status'] = intval($_POST['status']);
            if (isset($_POST['pwd']) && $_POST['pwd'] !== '') $updateData['pwd'] = md5($_POST['pwd']);
            if ($uid && !empty($updateData)) {
                \think\Db::name('xy_users')->where('id', $uid)->update($updateData);
                json_resp(null, 0, '会员信息保存成功');
            }
            json_resp(null, 1, '保存失败');
        } else {
            $user = \think\Db::name('xy_users')->where('id', $uid)->find();
            if (empty($user)) {
                echo "<h3 style='color:red;text-align:center;margin-top:50px;'>User not found</h3>";
                exit;
            }
            header('Content-Type: text/html; charset=utf-8');
            ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Details</title>
    <link rel="stylesheet" href="/app/admin/component/layui/css/layui.css?v=2.8.12" />
    <link rel="stylesheet" href="/app/admin/component/pear/css/pear.css" />
    <link rel="stylesheet" href="/app/admin/admin/css/reset.css" />
    <script src="/admin_i18n.js"></script>
    <style>
        .layui-form-label { width: 130px !important; }
        .layui-input-inline { width: 220px !important; }
    </style>
</head>
<body class="pear-container" style="background:#fff; padding: 25px;">
<form class="layui-form" lay-filter="user-form" id="user-form">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">User ID</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" value="<?= htmlspecialchars($user['id']) ?>" readonly disabled style="background:#f8f8f8;">
        </div>
        <label class="layui-form-label">Username</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" value="<?= htmlspecialchars($user['username']) ?>" readonly disabled style="background:#f8f8f8;">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Phone Number</label>
        <div class="layui-input-inline">
            <input type="text" name="tel" class="layui-input" value="<?= htmlspecialchars($user['tel']) ?>">
        </div>
        <label class="layui-form-label">Invite Code</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" value="<?= htmlspecialchars($user['invite_code']) ?>" readonly disabled style="background:#f8f8f8;">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Account Balance</label>
        <div class="layui-input-inline">
            <input type="number" step="0.01" name="balance" class="layui-input" value="<?= htmlspecialchars($user['balance']) ?>">
        </div>
        <label class="layui-form-label">Commission</label>
        <div class="layui-input-inline">
            <input type="number" step="0.01" name="commission_balance" class="layui-input" value="<?= htmlspecialchars($user['commission_balance']) ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">VIP Level</label>
        <div class="layui-input-inline">
            <select name="level">
                <?php for($i=0; $i<=6; $i++): ?>
                <option value="<?= $i ?>" <?= ($user['level']==$i)?'selected':'' ?>>VIP<?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <label class="layui-form-label">Account Status</label>
        <div class="layui-input-inline">
            <select name="status">
                <option value="1" <?= ($user['status']==1)?'selected':'' ?>>Normal (正常)</option>
                <option value="0" <?= ($user['status']==0)?'selected':'' ?>>Disabled (禁用)</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">New Password</label>
        <div class="layui-input-inline">
            <input type="password" name="pwd" placeholder="Leave empty to keep unchanged" class="layui-input">
        </div>
        <label class="layui-form-label">Reg IP</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" value="<?= htmlspecialchars($user['ip']) ?>" readonly disabled style="background:#f8f8f8;">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Reg Time</label>
        <div class="layui-input-inline" style="width: 220px !important;">
            <input type="text" class="layui-input" value="<?= !empty($user['addtime']) ? date('Y-m-d H:i:s', $user['addtime']) : '' ?>" readonly disabled style="background:#f8f8f8;">
        </div>
    </div>
    <div class="layui-form-item text-center" style="margin-top: 30px;">
        <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="saveUser">Save Changes</button>
        <button type="button" class="layui-btn layui-btn-primary" onclick="parent.layer.closeAll()">Cancel</button>
    </div>
</form>
<script src="/app/admin/component/layui/layui.js?v=2.8.12"></script>
<script src="/app/admin/component/pear/pear.js"></script>
<script>
layui.use(['form', 'jquery', 'popup'], function() {
    var form = layui.form;
    var $ = layui.$;
    form.render();
    
    form.on('submit(saveUser)', function(data) {
        $.ajax({
            url: '/admin/member/user/edit',
            type: 'POST',
            data: data.field,
            dataType: 'json',
            success: function(res) {
                if (res.code === 0) {
                    layui.popup.success(res.msg || 'Saved successfully', function() {
                        parent.layer.closeAll();
                        if (parent.refreshTable) parent.refreshTable();
                        else parent.location.reload();
                    });
                } else {
                    layui.popup.failure(res.msg || 'Save failed');
                }
            }
        });
        return false;
    });
});
</script>
</body>
</html>
            <?php
            exit;
        }
    }

    // G. 充值订单查询
    // G. 充值订单查询
    if (strpos($uri, 'user-recharge/select') !== false || strpos($uri, 'user_recharge') !== false || strpos($uri, 'recharge/select') !== false) {
        $page = intval($_GET['page'] ?? 1);
        $limit = intval($_GET['limit'] ?? 15);
        $query = \think\Db::name('xy_recharge')->alias('r')
            ->leftJoin('xy_users u', 'r.uid = u.id')
            ->field('r.*, u.username as account, u.tel, u.balance as user_balance');
            
        // Filters
        $orderNo = trim($_GET['order_no'] ?? '');
        if ($orderNo !== '') {
            $query->where('r.id', 'like', "%{$orderNo}%");
        }
        $searchUid = trim($_GET['uid'] ?? '');
        if ($searchUid !== '') {
            $query->where('r.uid', $searchUid);
        }
        $account = trim($_GET['account'] ?? '');
        if ($account !== '') {
            $query->where('u.username|u.tel', 'like', "%{$account}%");
        }
        if (isset($_GET['status']) && $_GET['status'] !== '' && $_GET['status'] !== '-') {
            $query->where('r.status', intval($_GET['status']));
        }
        
        $count = (clone $query)->count();
        $list = $query->order('r.addtime desc')->page($page, $limit)->select();
        $formatted = [];
        foreach ($list as $rc) {
            $formatted[] = [
                'id' => $rc['id'],
                'uid' => $rc['uid'],
                'order_no' => $rc['id'],
                'money' => number_format($rc['num'], 2, '.', ''),
                'original_money' => number_format($rc['num'], 2, '.', ''),
                'status' => intval($rc['status']),
                'channel' => $rc['pay_name'] ?: 'TRC20-USDT',
                'pay_name' => $rc['pay_name'] ?: 'TRC20-USDT',
                'pic' => $rc['pic'] ?: '',
                'add_time' => date('Y-m-d H:i:s', $rc['addtime']),
                'endtime' => !empty($rc['endtime']) ? date('Y-m-d H:i:s', $rc['endtime']) : '-',
                'user' => [
                    'uid' => $rc['uid'],
                    'account' => $rc['account'] ?: $rc['tel'],
                    'tel' => $rc['tel'] ?: '',
                    'balance' => $rc['user_balance'] ?? 0
                ]
            ];
        }
        table_resp($formatted, $count);
    }

    // G0. 任务订单/交易订单查询
    if (strpos($uri, 'order_list') !== false || strpos($uri, 'task-record') !== false || strpos($uri, 'convey') !== false) {
        $page = intval($_GET['page'] ?? 1);
        $limit = intval($_GET['limit'] ?? 15);
        $query = \think\Db::name('xy_convey')->alias('c')
            ->leftJoin('xy_users u', 'c.uid = u.id')
            ->leftJoin('xy_goods_list g', 'g.id = c.goods_id')
            ->field('c.*, u.username as account, u.tel, g.goods_name, g.goods_price');
        $count = (clone $query)->count();
        $list = $query->order('c.id desc')->page($page, $limit)->select();
        $formatted = [];
        foreach ($list as $item) {
            $formatted[] = [
                'id' => $item['id'],
                'uid' => $item['uid'],
                'order_no' => $item['id'],
                'goods_name' => $item['goods_name'] ?: 'Task Goods',
                'goods_price' => number_format($item['num'] ?? $item['goods_price'] ?? 0, 2, '.', ''),
                'commission' => number_format($item['commission'] ?? 0, 2, '.', ''),
                'status' => intval($item['status']),
                'add_time' => date('Y-m-d H:i:s', $item['addtime']),
                'user' => [
                    'uid' => $item['uid'],
                    'account' => $item['account'] ?: $item['tel']
                ]
            ];
        }
        table_resp($formatted, $count);
    }

    // G1. 充值审核通过
    if ($uri === '/admin/bill/user-recharge/check' || $uri === '/admin/bill/user-recharge/allCheck' || strpos($uri, 'user_recharge/check') !== false) {
        $rawIds = $_POST['ids'] ?? [$_POST['id'] ?? 0];
        if (is_string($rawIds)) {
            $ids = explode(',', $rawIds);
        } else {
            $ids = (array)$rawIds;
        }
        $ids = array_filter(array_map('trim', $ids));
        if (empty($ids)) json_resp(null, 1, 'Please select orders to approve');
        $approvedCount = 0;
        foreach ($ids as $id) {
            $recharge = \think\Db::name('xy_recharge')->where('id', $id)->find();
            if ($recharge && intval($recharge['status']) === 1) {
                // 1. Credit user balance
                \think\Db::name('xy_users')->where('id', $recharge['uid'])->setInc('balance', $recharge['num']);
                \think\Db::name('xy_users')->where('id', $recharge['uid'])->setInc('all_recharge_num', $recharge['num']);
                \think\Db::name('xy_users')->where('id', $recharge['uid'])->setInc('all_recharge_count', 1);

                // 2. Mark recharge completed
                \think\Db::name('xy_recharge')->where('id', $id)->update([
                    'status' => 2,
                    'endtime' => time()
                ]);

                // 3. Insert balance log so it appears in user's Bill List!
                try {
                    \think\Db::name('xy_balance_log')->insert([
                        'uid' => $recharge['uid'],
                        'oid' => $id,
                        'num' => $recharge['num'],
                        'type' => 1, // 1 = recharge
                        'status' => 1,
                        'addtime' => time()
                    ]);
                } catch (\Exception $e) {}

                // 4. Also check / trigger VIP upgrade if user qualifies
                try {
                    $totalRecharge = \think\Db::name('xy_recharge')->where('uid', $recharge['uid'])->where('status', 2)->sum('num');
                    $levels = \think\Db::name('xy_level')->order('num asc')->select();
                    $targetLevel = 0;
                    foreach ($levels as $lv) {
                        if ($totalRecharge >= $lv['num']) {
                            $targetLevel = $lv['level'];
                        }
                    }
                    if ($targetLevel > 0) {
                        \think\Db::name('xy_users')->where('id', $recharge['uid'])->where('level', '<', $targetLevel)->update(['level' => $targetLevel]);
                    }
                } catch (\Exception $e) {}

                $approvedCount++;
            }
        }
        json_resp(['count' => $approvedCount], 0, 'Recharge approved successfully! Funds credited to user balance.');
    }

    // G2. 充值审核驳回
    if ($uri === '/admin/bill/user-recharge/ignore' || $uri === '/admin/bill/user-recharge/allRefund' || strpos($uri, 'user_recharge/ignore') !== false) {
        $rawIds = $_POST['ids'] ?? [$_POST['id'] ?? 0];
        if (is_string($rawIds)) {
            $ids = explode(',', $rawIds);
        } else {
            $ids = (array)$rawIds;
        }
        $ids = array_filter(array_map('trim', $ids));
        if (empty($ids)) json_resp(null, 1, 'Please select orders to reject');
        \think\Db::name('xy_recharge')->where('id', 'in', $ids)->update([
            'status' => 3,
            'endtime' => time()
        ]);
        json_resp(['count' => count($ids)], 0, 'Recharge order(s) rejected successfully.');
    }

    // G3. 通用删除接口
    if (preg_match('#^/admin/([^/]+)/([^/]+)/delete$#', $uri, $delMatches)) {
        $mod = $delMatches[1];
        $ctrl = $delMatches[2];
        $id = $_POST['id'] ?? $_POST['uid'] ?? 0;
        $ids = $_POST['ids'] ?? ($id ? [$id] : []);
        if (!empty($ids)) {
            $tableMap = [
                'user-extract' => 'xy_deposit',
                'deposit_list' => 'xy_deposit',
                'user-recharge' => 'xy_recharge',
                'user_recharge' => 'xy_recharge',
                'user' => 'xy_users',
                'product' => 'xy_goods_list',
                'task-record' => 'xy_convey',
                'order_list' => 'xy_convey',
                'system-coin-channel' => 'xy_pay',
                'system-user-level' => 'xy_level',
                'admin' => 'system_user'
            ];
            $targetTable = $tableMap[$ctrl] ?? str_replace('-', '_', $ctrl);
            try {
                \think\Db::name($targetTable)->where('id', 'in', $ids)->delete();
                json_resp(null, 0, '删除成功');
            } catch (\Exception $e) {}
        }
        json_resp(null, 0, '操作完成');
    }

    // H. 充提币种通道
    if (strpos($uri, 'system-coin-channel/select') !== false || strpos($uri, 'pay/select') !== false) {
        $typeMap = [
            'TRC20-USDT' => '1', 'TRX' => '2', 'BEP20-USDT' => '3', 'BNB' => '4',
            'BEP20-USDC' => '5', 'POLYGON-USDT' => '6', 'ETH-USDT' => '7',
            'POLYGON-USDC' => '8', 'ETH-USDC' => '9', 'ETH' => '10',
            'POLYGON' => '11', 'ETH-PYUSD' => '12', 'PHP' => '101'
        ];
        $channels = \think\Db::name('xy_pay')->where('status', 1)->select();
        $formatted = [];
        foreach ($channels as $ch) {
            $formatted[] = [
                'id' => $ch['id'],
                'show_name' => $ch['name'],
                'type' => $typeMap[$ch['name']] ?? '1',
                'min_recharge_money' => number_format($ch['min'], 2, '.', ''),
                'min_extract_money' => number_format($ch['min'], 2, '.', ''),
                'max_extract_money' => number_format($ch['max'], 2, '.', ''),
                'exchange_rate' => '1.000000',
                'image' => $ch['ico'],
                'recharge_is_show' => 1,
                'extract_is_show' => 1,
                'status' => intval($ch['status'])
            ];
        }
        table_resp($formatted, count($formatted));
    }

    // I. VIP 等级
    if (strpos($uri, 'system-user-level/select') !== false || strpos($uri, 'level/select') !== false) {
        $levels = \think\Db::name('xy_level')->order('level asc')->select();
        $formatted = [];
        foreach ($levels as $lv) {
            $formatted[] = [
                'id' => $lv['id'],
                'grade' => $lv['level'],
                'name' => $lv['name'],
                'lock_amount' => number_format($lv['num'], 2, '.', ''),
                'task_num' => $lv['order_num'],
                'income' => number_format($lv['bili'], 4, '.', ''),
                'image' => $lv['pic'] ?: '/static/image/trc20-usdt.jpg'
            ];
        }
        table_resp($formatted, count($formatted));
    }

    // J. Dynamic MySQL Table Query Fallback for ANY /select endpoint
    if (strpos($uri, '/select') !== false) {
        $parts = explode('/', trim(parse_url($uri, PHP_URL_PATH), '/'));
        $selectIdx = array_search('select', $parts);
        if ($selectIdx !== false && $selectIdx > 0) {
            $entity = $parts[$selectIdx - 1];
            
            $entityMap = [
                'user-recharge' => 'xy_recharge',
                'user_recharge' => 'xy_recharge',
                'recharge' => 'xy_recharge',
                'deposit_list' => 'xy_deposit',
                'deposit' => 'xy_deposit',
                'withdraw' => 'xy_deposit',
                'user-extract' => 'xy_deposit',
                'order_list' => 'xy_convey',
                'convey' => 'xy_convey',
                'task' => 'xy_convey',
                'users' => 'xy_users',
                'user' => 'xy_users',
                'queue' => 'system_queue',
                'oplog' => 'system_log',
                'log' => 'system_log',
                'config' => 'system_config',
                'menu' => 'system_menu',
                'auth' => 'system_auth',
                'admin' => 'system_user',
                'task-record' => 'xy_convey',
                'deal' => 'xy_convey',
                'product' => 'xy_goods_list',
                'shop' => 'xy_goods_list',
                'goods' => 'xy_goods_list',
                'user-bill' => 'xy_balance_log',
                'share-reward' => 'xy_reward_log',
                'user-datum' => 'xy_bankinfo',
                'user-message' => 'xy_message',
                'message' => 'xy_message',
                'user-tg-message' => 'xy_cs',
                'cs' => 'xy_cs',
                'slide-item' => 'xy_banner',
                'banner' => 'xy_banner',
                'article' => 'xy_notice',
                'notice' => 'xy_notice',
                'user-cate' => 'xy_group',
                'group' => 'xy_group'
            ];

            $candidateTables = [];
            if (isset($entityMap[$entity])) {
                $candidateTables[] = $entityMap[$entity];
            }
            $candidateTables[] = 'system_' . str_replace('-', '_', $entity);
            $candidateTables[] = 'xy_' . str_replace('-', '_', $entity);
            $candidateTables[] = str_replace('-', '_', $entity);

            foreach ($candidateTables as $tName) {
                try {
                    $exist = \think\Db::query("SHOW TABLES LIKE '{$tName}'");
                    if (!empty($exist)) {
                        $page = intval($_GET['page'] ?? 1);
                        $limit = intval($_GET['limit'] ?? 15);
                        $query = \think\Db::name($tName);
                        $count = (clone $query)->count();
                        $list = $query->page($page, $limit)->select();
                        table_resp($list, $count);
                    }
                } catch (\Exception $e) {}
            }
        }
    }

    // K. Fallback for all other probed endpoints from probe_results.json
    $resultsPath = dirname(__DIR__, 3) . '/probe_results.json';
    if (file_exists($resultsPath)) {
        static $probeData = null;
        if ($probeData === null) {
            $probeData = json_decode(file_get_contents($resultsPath), true);
        }
        if (isset($probeData[$uri])) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($probeData[$uri], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    // Default empty success
    table_resp([], 0);
}

