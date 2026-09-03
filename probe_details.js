import fs from 'fs';

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
    // System Management
    '/admin/system/admin/select',
    '/admin/system/system-config/select',
    '/admin/system/system-coin-channel/select',
    '/admin/system/article/select',
    '/admin/system/slide-item/select',
    '/admin/system/supervision-item/select',
    '/admin/system/share-task/select',
    '/admin/system/lottery/select',
    '/admin/system/sign-config/select',
    '/admin/system/task-center/select',
    '/admin/system/system-spread/select',
    '/admin/system/system-user-level/select',
    '/admin/system/product/select',
    '/admin/system/lang-type/select',
    '/admin/system/lang-code/select',
    '/admin/system/cf-black-ip/select',
    '/admin/system/cloudflare-ip/select',
    // Member Management
    '/admin/member/user/select',
    '/admin/member/user-cate/select',
    '/admin/member/user-log/select',
    '/admin/member/user-bill/select',
    '/admin/member/user-message/select',
    '/admin/member/user-tg-message/select',
    '/admin/member/user-level-record/select',
    '/admin/member/share-reward/select',
    '/admin/member/user-examination/select',
    '/admin/member/task-plan/select',
    '/admin/member/user-datum/select',
    '/admin/member/lottery-user-config/select',
    '/admin/member/task-plan-auto/select',
    // Bill Management
    '/admin/bill/user-recharge/select',
    '/admin/bill/user-extract/select',
    '/admin/bill/lottery-record/select',
    '/admin/bill/user-collection/select',
    '/admin/bill/user-transfer/select',
    '/admin/bill/task-record/select',
    '/admin/bill/task-center-record/select',
    '/admin/bill/user-pay-order/select',
    // Report Management
    '/admin/report/complex/select',
    '/admin/report/proxy/select',
    '/admin/report/daily/select',
    '/admin/report/rank/select',
    '/admin/report/statistics/select'
  ];

  const results = {};

  for (const route of routesToProbe) {
    try {
      const url = 'https://api.huanyuys.com' + route + '?page=1&limit=10';
      const r = await fetch(url, { headers });
      const text = await r.text();
      try {
        results[route] = JSON.parse(text);
      } catch (e) {
        results[route] = { status: r.status, rawSnippet: text.substring(0, 200) };
      }
    } catch (e) {
      results[route] = { error: e.message };
    }
  }

  fs.writeFileSync('d:/freelance/kkk577/probe_results.json', JSON.stringify(results, null, 2));
  console.log('Saved probe_results.json with', Object.keys(results).length, 'endpoints probed.');
}

main().catch(err => console.error(err));
