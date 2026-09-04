import fs from 'fs';

async function fetchWithTimeout(url, options = {}, timeout = 3000) {
  const controller = new AbortController();
  const id = setTimeout(() => controller.abort(), timeout);
  try {
    const response = await fetch(url, { ...options, signal: controller.signal });
    clearTimeout(id);
    return response;
  } catch (error) {
    clearTimeout(id);
    throw error;
  }
}

async function main() {
  const loginUrl = 'https://api.huanyuys.com/app/admin/account/login';
  const params = new URLSearchParams();
  params.append('username', 'admin123');
  params.append('password', '123456a');
  params.append('captcha1', '');

  const res = await fetch(loginUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
    },
    body: params.toString()
  });

  const loginJson = await res.json();
  const cookieHeader = res.headers.get('set-cookie');
  const cookie = cookieHeader ? cookieHeader.split(';')[0] : '';
  const token = loginJson.data?.token || '';

  const headers = {
    'Cookie': cookie,
    'authorization': token,
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
  };

  const routesToProbe = [
    '/app/admin/account/info',
    '/app/admin/rule/get',
    '/app/admin/rule/permission',
    '/admin/system/admin/select',
    '/admin/system/system-config/select',
    '/admin/system/system-coin-channel/select',
    '/admin/system/article/select',
    '/admin/system/slide-item/select',
    '/admin/system/share-task/select',
    '/admin/system/lottery/select',
    '/admin/system/task-center/select',
    '/admin/system/system-user-level/select',
    '/admin/system/product/select',
    '/admin/member/user/select',
    '/admin/member/user-cate/select',
    '/admin/member/user-bill/select',
    '/admin/member/task-plan/select',
    '/admin/bill/user-recharge/select',
    '/admin/bill/user-extract/select',
    '/admin/bill/lottery-record/select',
    '/admin/bill/user-collection/select',
    '/admin/bill/user-transfer/select',
    '/admin/bill/task-record/select',
    '/admin/report/complex/select'
  ];

  const results = {};

  for (const route of routesToProbe) {
    try {
      const url = 'https://api.huanyuys.com' + route + '?page=1&limit=5';
      const r = await fetchWithTimeout(url, { headers }, 3000);
      const text = await r.text();
      try {
        results[route] = JSON.parse(text);
      } catch (e) {
        results[route] = { status: r.status, rawSnippet: text.substring(0, 150) };
      }
    } catch (e) {
      results[route] = { error: e.message };
    }
  }

  fs.writeFileSync('d:/freelance/kkk577/probe_results.json', JSON.stringify(results, null, 2));
  console.log('Saved probe_results.json successfully.');
}

main().catch(err => console.error(err));
