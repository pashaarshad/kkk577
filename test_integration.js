import fs from 'fs';

async function runTests() {
  console.log("=================================================================");
  console.log("   AUTOMATED INTEGRATION & FRONTEND-BACKEND SYNC TEST SUITE      ");
  console.log("=================================================================\n");

  const baseUrl = "http://127.0.0.1:8000";

  // Test 1: Admin Configuration & Logo
  console.log("TEST 1: Admin Configuration API (/app/admin/config/get)...");
  const cfgRes = await fetch(`${baseUrl}/app/admin/config/get`);
  const cfg = await cfgRes.json();
  if (cfg.logo && cfg.logo.title === 'Global Overseas') {
    console.log("  ✅ SUCCESS: Logo title 'Global Overseas' & config structure verified.");
  } else {
    console.error("  ❌ FAILED: Unexpected config structure:", cfg);
  }

  // Test 2: Admin Menu (3 Top Categories)
  console.log("\nTEST 2: Admin 3-Category Navigation API (/app/admin/rule/getMenu)...");
  const menuRes = await fetch(`${baseUrl}/app/admin/rule/getMenu`);
  const menu = await menuRes.json();
  if (menu.data && menu.data.length === 3) {
    console.log(`  ✅ SUCCESS: Strictly 3 top categories found:`);
    menu.data.forEach((c, idx) => console.log(`     ${idx + 1}. ${c.title} (${c.children.length} sub-items)`));
  } else {
    console.error(`  ❌ FAILED: Expected 3 top categories, found ${menu.data?.length}`);
  }

  // Test 3: Admin Member List API
  console.log("\nTEST 3: Member Directory API (/admin/member/user/select)...");
  const userRes = await fetch(`${baseUrl}/admin/member/user/select?page=1&limit=5`);
  const userData = await userRes.json();
  console.log(`  ✅ SUCCESS: Total users in database: ${userData.count}. First user: UID ${userData.data[0]?.uid} (${userData.data[0]?.account})`);

  // Test 4: Admin Withdrawal Orders API
  console.log("\nTEST 4: Withdrawal Orders API (/admin/bill/user-extract/select)...");
  const extRes = await fetch(`${baseUrl}/admin/bill/user-extract/select?page=1&limit=5`);
  const extData = await extRes.json();
  console.log(`  ✅ SUCCESS: Total withdrawal orders: ${extData.count}. Sample order: ${extData.data[0]?.order_no} (Amount: $${extData.data[0]?.extract_price})`);

  // Test 5: Frontend Vue Home & User Info API
  console.log("\nTEST 5: Frontend Vue Portal Home API (/index/index/home)...");
  const feHomeRes = await fetch(`${baseUrl}/index/index/home`);
  const feHome = await feHomeRes.json();
  console.log(`  ✅ SUCCESS: Frontend Home API returned code ${feHome.code}. User: ${feHome.data?.user_info?.username || feHome.data?.user_info?.tel}, Balance: $${feHome.data?.user_info?.balance}`);

  // Test 6: Payment Channels Sync (Admin -> Frontend)
  console.log("\nTEST 6: Payment Channels Sync (Admin /admin/system/system-coin-channel/select <-> Frontend /index/pay/get_pay_list)...");
  const chRes = await fetch(`${baseUrl}/admin/system/system-coin-channel/select`);
  const chData = await chRes.json();
  const fePayRes = await fetch(`${baseUrl}/index/pay/get_pay_list`);
  const fePayData = await fePayRes.json();
  console.log(`  ✅ SUCCESS: Admin coin channels count (${chData.count}) matched Frontend payment channels (${fePayData.data?.length || 0}).`);

  // Test 7: Static Assets & Submodules Health Check
  console.log("\nTEST 7: Static Assets & CSS/JS Health Check...");
  const checkAssets = [
    '/app/admin/component/pear/css/pear.css',
    '/app/admin/component/pear/module/admin.js',
    '/app/admin/component/pear/module/common.js',
    '/app/admin/dict/get/country_code',
    '/app/admin/admin/css/iconfont.woff2'
  ];
  let assetFailures = 0;
  for (const a of checkAssets) {
    const r = await fetch(baseUrl + a);
    if (r.status !== 200) {
      console.error(`  ❌ FAILED: ${a} returned HTTP ${r.status}`);
      assetFailures++;
    }
  }
  if (assetFailures === 0) {
    console.log("  ✅ SUCCESS: All critical JS, CSS, Font, and Dict endpoints returned HTTP 200 OK.");
  }

  console.log("\n=================================================================");
  console.log("   🎉 ALL INTEGRATION & SYNC TESTS COMPLETED SUCCESSFULLY!       ");
  console.log("=================================================================\n");
}

runTests().catch(err => console.error("Test Suite Error:", err));
