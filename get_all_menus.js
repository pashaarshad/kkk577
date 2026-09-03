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

  // Get menu structure
  const menuRes = await fetch('https://api.huanyuys.com/app/admin/rule/get', { headers });
  const menuJson = await menuRes.json();
  fs.writeFileSync('d:/freelance/kkk577/menu_structure.json', JSON.stringify(menuJson, null, 2));
  console.log('Saved menu_structure.json');

  // Get permissions list
  const permRes = await fetch('https://api.huanyuys.com/app/admin/rule/permission', { headers });
  const permJson = await permRes.json();
  fs.writeFileSync('d:/freelance/kkk577/permissions.json', JSON.stringify(permJson, null, 2));
  console.log('Saved permissions.json');
}

main().catch(err => console.error(err));
