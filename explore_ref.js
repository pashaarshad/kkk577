import fs from 'fs';

async function main() {
  const loginUrl = 'https://api.huanyuys.com/app/admin/account/login';
  const params = new URLSearchParams();
  params.append('username', 'admin123');
  params.append('password', '123456a');
  params.append('captcha1', '');

  console.log('Logging in...');
  const res = await fetch(loginUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
    },
    body: params.toString()
  });

  const loginJson = await res.json();
  console.log('Login Response:', loginJson);
  const cookieHeader = res.headers.get('set-cookie');
  const cookie = cookieHeader ? cookieHeader.split(';')[0] : '';
  const token = loginJson.data?.token || '';

  console.log('Using Cookie:', cookie, 'Token:', token);

  const headers = {
    'Cookie': cookie,
    'authorization': token,
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
  };

  // Test endpoints
  const endpoints = [
    '/app/admin/index/index',
    '/app/admin/rule/getMenu',
    '/app/admin/account/info',
    '/app/admin/config/get',
    '/app/admin/user/select',
    '/app/admin/user/list',
    '/app/admin/withdrawal/list',
    '/app/admin/recharge/list',
    '/app/admin/task/list',
    '/app/admin/rule/permission'
  ];

  for (const ep of endpoints) {
    try {
      const epRes = await fetch('https://api.huanyuys.com' + ep, { headers });
      const text = await epRes.text();
      console.log(`\n--- Endpoint: ${ep} (Status ${epRes.status}) ---`);
      console.log(text.substring(0, 300));
      if (ep === '/app/admin/rule/getMenu' || ep === '/app/admin/index/index') {
        fs.writeFileSync(`d:/freelance/kkk577/${ep.replace(/\//g, '_')}.json`, text);
      }
    } catch (e) {
      console.error(`Failed ${ep}:`, e.message);
    }
  }
}

main().catch(err => console.error(err));
