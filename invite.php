<?php
// 获取URL参数
$mini_injection = [
    'miniuid' => isset($_GET['miniuid']) ? $_GET['miniuid'] : '1000', 
    'inviter_name' => isset($_GET['inviter_name']) ? $_GET['inviter_name'] : '#RCAPOO',
    'room_name' => isset($_GET['room_name']) ? $_GET['room_name'] : 'Capoooo',
    'max_players' => isset($_GET['max_players']) ? $_GET['max_players'] : '6',
    'current_players' => isset($_GET['current_players']) ? $_GET['current_players'] : '1'
];

// 确认迷你号是否有效
$miniuid = $mini_injection['miniuid'];
if (!is_numeric($miniuid) || (int)$miniuid < 1000000000) {
    $miniuid = (int)$miniuid + 1000000000;
    echo "已确认迷你号: " . $miniuid . "<br>";
} else {
    echo "已确认迷你号: " . $miniuid . "<br>";
}

// 定义目标 URL 和参数
$host_url = "http://friend.miniworldgame.com:8180//server/friend";
$Target_uid = $miniuid;
$positions = [
    ['myuid' => 1300738565, 's2t' => 1736348402, 'time' => 1736348472, 'token' => '38e5ddc3a9ba3219dcb12478673a8ae0', 'auth' => 'eaaa5586221daf616fe04a084b404ca7'],
    ['myuid' => 1300740304, 's2t' => 1737212771, 'time' => 1737212972, 'token' => '8192157199ac0e568591ebd4261fa954', 'auth' => '659797a7cb728b4111aacd6b66bc0457'],
    ['myuid' => 1300738565, 's2t' => 1737213700, 'time' => 1737214041, 'token' => 'e468d41511b1c593df27d2ff6e6d9eda', 'auth' => 'c38f72bd24215ff177d120daaae6cdce']
];

// 编码函数
function to_base64($data) {
    return base64_encode($data);
}

// URL编码函数
function url_encode($str) {
    return urlencode($str);
}

// 创建JSON数据
$json_data = json_encode([
    "InviterName" => $mini_injection['inviter_name'],
    "Password" => "",
    "PlayerMaxNum" => (int)$mini_injection['max_players'],
    "PlayerNum" => (int)$mini_injection['current_players'],
    "RoomId" => 0,
    "RoomName" => $mini_injection['room_name'],
    "RoomType" => "Omekey_Rent_Room",
    "RoomUin" => 1000,
    "RoomVer" => 67343,
    "Standby1" => 11,
    "Type" => "InviteJoinRoomA",
    "WorldID" => 0
]);

// Base64编码
$base64_encoded = to_base64($json_data);

// URL编码
$url_encoded = url_encode($base64_encoded);

// 执行请求
foreach ($positions as $pos) {
    $msg = "%E6%88%BF%E9%96%93%E9%82%80%E8%AB%8B%E4%BF%A1%E6%81%AF";
    $params = [
        'apiid' => 303,
        'cmd' => 'send_chat_msg',
        'country' => 'HK',
        'des_uin' => $Target_uid,
        'extend_data' => $url_encoded,
        'lang' => 2,
        'msg' => $msg,
        'show_type' => 1,
        'src_uin' => $pos['myuid'],
        'ver' => '1.1.1',
        'msgtype' => 3,
        'pushchannel' => 1,
        's2t' => $pos['s2t'],
        'time' => $pos['time'],
        'uin' => $pos['myuid'],
        'token' => $pos['token'],
        'auth' => $pos['auth']
    ];

    // 构建URL并发送请求
    $url = $host_url . '?' . http_build_query($params);
    file_get_contents($url);  // 发送请求
    sleep(1);  // 延时1秒
}

echo "脚本执行完成";
?>
