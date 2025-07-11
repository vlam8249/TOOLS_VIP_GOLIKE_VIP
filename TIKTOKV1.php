<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Hàm kiểm tra kết nối ADB
function check_adb_connection() {
    try {
        $result = shell_exec("adb devices 2>&1");
        $devices = array();
        $lines = explode("\n", $result);
        foreach ($lines as $line) {
            if (strpos($line, "\tdevice") !== false) {
                $parts = explode("\t", $line);
                $devices[] = $parts[0];
            }
        }
        if (count($devices) > 0) {
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;32m✈ \033[1;32mThiết bị đã được kết nối qua ADB.\033[0m\n";
            return array(true, $devices[0]);
        } else {
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mKhông có thiết bị nào được kết nối qua ADB.\033[0m\n";
            return array(false, null);
        }
    } catch (Exception $e) {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;31m✈ \033[1;31mKhông thể chạy lệnh ADB. Vui lòng kiểm tra lại cài đặt ADB.\033[0m\n";
        return array(false, null);
    }
}

// Hàm lưu thông tin thiết bị
function save_device_info($device_id) {
    file_put_contents("device_info.txt", $device_id);
    echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32m✅ Đã lưu thông tin thiết bị.\033[0m\n";
}

// Hàm đọc thông tin thiết bị
function load_device_info() {
    if (file_exists("device_info.txt")) {
        $device_id = file_get_contents("device_info.txt");
        $device_id = trim($device_id);
        echo "\033[1;97m════════════════════════════════════════════════\n";
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;33mĐã tải thông tin kết nối từ thiết bị.\033[0m\n";
        return $device_id;
    } else {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mKhông tìm thấy file thông tin thiết bị.\033[0m\n";
        return null;
    }
}

// Hàm lưu tọa độ vào file
function save_coordinates($follow_x, $follow_y, $back_x, $back_y, $like_x, $like_y) {
    $content = "follow_x=$follow_x\nfollow_y=$follow_y\nback_x=$back_x\nback_y=$back_y\nlike_x=$like_x\nlike_y=$like_y\n";
    file_put_contents("coordinates.txt", $content);
    echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;33m✅ Đã lưu tọa độ vào thiết bị.\033[0m\n";
}

// Hàm đọc tọa độ từ file
function load_coordinates() {
    if (file_exists("coordinates.txt")) {
        $coordinates = array();
        $lines = file("coordinates.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($key, $value) = explode("=", $line);
            $coordinates[$key] = intval($value);
        }
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mĐã tải tọa độ từ thiết bị.\033[0m\n";
        return $coordinates;
    } else {
        echo "\033[1;97m════════════════════════════════════════════════\n";
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mKhông tìm thấy file tọa độ.\033[0m\n";
        return null;
    }
}

// Hàm kết nối thiết bị Android 11
function connect_android_11() {
    while (true) {
        try {
            echo "\033[1;36mNhập IP của thiết bị (ví dụ: 192.168.100.3): ";
            $ip = trim(fgets(STDIN));
            echo "\033[1;36mNhập cổng khi bật gỡ lỗi không dây (ví dụ: 43487): ";
            $debug_port = trim(fgets(STDIN));
            echo "\033[1;36mNhập cổng khi ghép nối thiết bị (ví dụ: 40833): ";
            $pair_port = trim(fgets(STDIN));
            echo "\033[1;36mNhập mã ghép nối Wi-Fi: ";
            $wifi_code = trim(fgets(STDIN));

            shell_exec("adb pair $ip:$pair_port $wifi_code");
            shell_exec("adb connect $ip:$debug_port");

            list($is_connected, $device_id) = check_adb_connection();
            if ($is_connected) {
                save_device_info($device_id);
                echo "\033[1;32mThiết bị đã kết nối thành công qua ADB!\033[0m\n";
                return true;
            } else {
                echo "\033[1;31mKhông thể kết nối thiết bị. Vui lòng kiểm tra lại thông tin.\033[0m\n";
            }
        } catch (Exception $e) {
            echo "\033[1;31mĐã xảy ra lỗi: " . $e->getMessage() . "\033[0m\n";
        }
    }
}

// Hàm kết nối thiết bị Android 10
function connect_android_10() {
    while (true) {
        try {
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;36mNhập IP của thiết bị (ví dụ: 192.168.100.3): ";
            $ip = trim(fgets(STDIN));
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;36mNhập cổng khi bật gỡ lỗi không dây (ví dụ: 5555): ";
            $debug_port = trim(fgets(STDIN));

            shell_exec("adb connect $ip:$debug_port");

            list($is_connected, $device_id) = check_adb_connection();
            if ($is_connected) {
                save_device_info($device_id);
                echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mThiết bị đã kết nối thành công qua ADB!\033[0m\n";
                return true;
            } else {
                echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31m❌ Không thể kết nối thiết bị. Vui lòng kiểm tra lại IP và cổng.\033[0m\n";
            }
        } catch (Exception $e) {
            echo "\033[1;31mĐã xảy ra lỗi: " . $e->getMessage() . "\033[0m\n";
        }
    }
}

// Hàm để thực hiện thao tác chạm trên màn hình
function tap_screen($x, $y) {
    shell_exec("adb shell input tap " . intval($x) . " " . intval($y));
}

function bes4($url) {
    try {
        $response = file_get_contents($url, false, stream_context_create([
            'http' => ['timeout' => 5]
        ]));
        
        if ($response !== false) {
            $doc = new DOMDocument();
            @$doc->loadHTML($response);
            $xpath = new DOMXPath($doc);
            
            $version_tag = $xpath->query("//span[@id='version_keyADB']")->item(0);
            $maintenance_tag = $xpath->query("//span[@id='maintenance_keyADB']")->item(0);
            
            $version = $version_tag ? trim($version_tag->nodeValue) : null;
            $maintenance = $maintenance_tag ? trim($maintenance_tag->nodeValue) : null;
            
            return array($version, $maintenance);
        }
    } catch (Exception $e) {
        return array(null, null);
    }
    return array(null, null);
}

function checkver() {
    $url = 'https://checkserver.hotrommo.com/';
    list($version, $maintenance) = bes4($url);
    if ($maintenance == 'on') {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mTool đang được bảo trì. Vui lòng thử lại sau. \nHoặc vào nhóm Tele: \033[1;33mhttps://t.me/+77MuosyD-yk4MGY1\n";
        exit();
    }
    return $version;
}

$current_version = checkver();
if ($current_version) {
    echo "Phiên bản hiện tại: $current_version\n";
} else {
    echo "Không thể lấy thông tin phiên bản hoặc tool đang được bảo trì.\n";
    exit();
}
system('clear');
// Hàm hiển thị banner

if (!function_exists('banner')) {
    function banner() {
        system('clear');
        $banner = "
        \033[1;33m██      ██╗      ████████╗ █████╗  █████╗ ██╗
        \033[1;35m██╗    ╔██║      ╚══██╔══╝██╔══██╗██╔══██╗██║
        \033[1;36m██║████║██║ █████╗  ██║   ██║  ██║██║  ██║██║
        \033[1;37m██║    ╚██║ ╚════╝  ██║   ██║  ██║██║  ██║██║
        \033[1;32m██║     ██║         ██║   ╚█████╔╝╚█████╔╝██████╗
        \033[1;31m╚═╝     ╚═╝         ╚═╝    ╚════╝  ╚════╝ ╚═════╝\n
        \033[1;97mTool By: \033[1;32mTrịnh Hướng            \033[1;97mPhiên Bản: \033[1;32m4.0     
        \033[97m════════════════════════════════════════════════  
        \033[1;97m[\033[1;91m❣\033[1;97m]\033[1;97m Tool\033[1;31m     : \033[1;97m☞ \033[1;31mTik - Tok\033[1;33m♔ \033[1;97m🔫
        \033[1;97m[\033[1;91m❣\033[1;97m]\033[1;97m Youtube\033[1;31m  : \033[1;97m☞ \033[1;36mHướng Dev - Kiếm Tiền Online\033[1;31m♔ \033[1;97m☜
        \033[1;97m[\033[1;91m❣\033[1;97m]\033[1;97m Tik Tok\033[1;31m  : \033[1;33mhttps:\033[1;32m//www.tiktok.com\033[1;31m/m@huongdev27
        \033[1;97m[\033[1;91m❣\033[1;97m]\033[1;97m Zalo\033[1;31m     : \033[1;97m☞\033[1;31m0\033[1;37m3\033[1;36m2\033[1;35m1\033[1;34m6\033[1;33m6\033[1;33m8\033[1;34m6\033[1;35m3☜
        \033[1;97m[\033[1;91m❣\033[1;97m]\033[1;97m Telegram\033[1;31m : \033[1;97m☞\033[1;32mhttps://t.me/+77MuosyD-yk4MGY1🔫\033[1;97m☜
        \033[97m════════════════════════════════════════════════
        \033[1;97m[\033[1;91m❣\033[1;97m]\033[1;91m Lưu ý\033[1;31m    : \033[1;97m☞ \033[1;32mTool Sử Dụng ALL Thiết Bị\033[1;31m♔ \033[1;97m☜
        \033[97m════════════════════════════════════════════════
        ";
        foreach (str_split($banner) as $X) {
            echo $X;
            usleep(1250);
        }
    }
}


banner();
echo "\033[1;97m[\033[1;91m❣\033[1;97m]\033[1;97m Địa chỉ Ip\033[1;32m  : \033[1;32m☞\033[1;31m♔ \033[1;32m83.86.8888\033[1;31m♔ \033[1;97m☜\n";
echo "\033[1;97m════════════════════════════════════════════════\n";
// In menu lựa chọn
echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mNhập \033[1;31m1 \033[1;33mđể vào \033[1;34mTool Tiktok\033[1;33m\n"; 
echo "\033[1;31m\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mNhập 2 Để Xóa Authorization Hiện Tại'\n";

// Vòng lặp để chọn lựa chọn (Xử lý cả trường hợp chọn sai)
while (true) {
    try {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mNhập Lựa Chọn (1 hoặc 2): ";
        $choose = trim(fgets(STDIN));
        $choose = intval($choose);
        if ($choose != 1 && $choose != 2) {
            echo "\033[1;31m\n❌ Lựa chọn không hợp lệ! Hãy nhập lại.\n";
            continue;
        }
        break;
    } catch (Exception $e) {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mSai định dạng! Vui lòng nhập số.\n";
    }
}

// Xóa Authorization nếu chọn 2
if ($choose == 2) {
    $file = "Authorization.txt";
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "\033[1;32m[✔] Đã xóa $file!\n";
        } else {
            echo "\033[1;31m[✖] Không thể xóa $file!\n";
        }
    } else {
        echo "\033[1;33m[!] File $file không tồn tại!\n";
    }
    echo "\033[1;33m👉 Vui lòng nhập lại thông tin!\n";
}

// Kiểm tra và tạo file nếu chưa có
$file = "Authorization.txt";
if (!file_exists($file)) {
    if (file_put_contents($file, "") === false) {
        echo "\033[1;31m[✖] Không thể tạo file $file!\n";
        exit(1);
    }
}

// Đọc thông tin từ file
$author = "";
if (file_exists($file)) {
    $author = file_get_contents($file);
    if ($author === false) {
        echo "\033[1;31m[✖] Không thể đọc file $file!\n";
        exit(1);
    }
    $author = trim($author);
}

// Yêu cầu nhập lại nếu Authorization trống
while (empty($author)) {
    echo "\033[1;97m════════════════════════════════════════════════\n";
    echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mNhập Authorization: ";
    $author = trim(fgets(STDIN));

    // Ghi vào file
    if (file_put_contents($file, $author) === false) {
        echo "\033[1;31m[✖] Không thể ghi vào file $file!\n";
        exit(1);
    }
}

// Chạy tool
$headers = [
    'Accept-Language' => 'vi,en-US;q=0.9,en;q=0.8',
    'Referer' => 'https://app.golike.net/',
    'Sec-Ch-Ua' => '"Not A(Brand";v="99", "Google Chrome";v="121", "Chromium";v="121"',
    'Sec-Ch-Ua-Mobile' => '?0',
    'Sec-Ch-Ua-Platform' => "Windows",
    'Sec-Fetch-Dest' => 'empty',
    'Sec-Fetch-Mode' => 'cors',
    'Sec-Fetch-Site' => 'same-site',
    'T' => 'VFZSak1FMTZZM3BOZWtFd1RtYzlQUT09',
    'User-Agent' => 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36',
    "Authorization" => $author,
    'Content-Type' => 'application/json;charset=utf-8'
];

echo "\033[1;97m════════════════════════════════════════════════\n";
echo "\033[1;32m🚀 Đăng nhập thành công! Đang vào Tool Tiktok...\n";
sleep(1);

// Hàm chọn tài khoản TikTok
function chonacc() {
    global $headers;
    $json_data = array();
    $response = file_get_contents('https://gateway.golike.net/api/tiktok-account', false, stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => buildHeaders($headers),
            'content' => json_encode($json_data)
        ]
    ]));
    return json_decode($response, true);
}

// Hàm nhận nhiệm vụ
function nhannv($account_id) {
    global $headers;
    $params = array(
        'account_id' => $account_id,
        'data' => 'null'
    );
    $json_data = array();
    $url = 'https://gateway.golike.net/api/advertising/publishers/tiktok/jobs?' . http_build_query($params);
    $response = file_get_contents($url, false, stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => buildHeaders($headers),
            'content' => json_encode($json_data)
        ]
    ]));
    return json_decode($response, true);
}

// Hàm hoàn thành nhiệm vụ
// Ẩn tất cả lỗi và cảnh báo PHP
error_reporting(0);
ini_set('display_errors', 0);

function hoanthanh($ads_id, $account_id) {
    global $headers;
    
    $json_data = array(
        'ads_id' => $ads_id,
        'account_id' => $account_id,
        'async' => true,
        'data' => null
    );

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => buildHeaders($headers),
            'content' => json_encode($json_data),
            'ignore_errors' => true // Không hiển thị lỗi của file_get_contents
        ]
    ]);

    $response = @file_get_contents('https://gateway.golike.net/api/advertising/publishers/tiktok/complete-jobs', false, $context);

    if ($response === false) {
        return ['error' => 'Không thể kết nối đến server!'];
    }

    // Lấy mã HTTP từ phản hồi
    $http_code = 0;
    if (isset($http_response_header) && preg_match('/HTTP\/\d\.\d\s(\d+)/', $http_response_header[0], $matches)) {
        $http_code = (int)$matches[1];
    }

    // Trả về lỗi nếu mã HTTP không phải 200
    if ($http_code !== 200) {
        return ['error' => "Lỗi HTTP $http_code"];
    }

    return json_decode($response, true);
}

// Hàm báo lỗi
function baoloi($ads_id, $object_id, $account_id, $loai) {
    global $headers;
    
    $json_data1 = array(
        'description' => 'Báo cáo hoàn thành thất bại',
        'users_advertising_id' => $ads_id,
        'type' => 'ads',
        'provider' => 'tiktok',
        'fb_id' => $account_id,
        'error_type' => 6
    );
    $response1 = file_get_contents('https://gateway.golike.net/api/report/send', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => buildHeaders($headers),
            'content' => json_encode($json_data1)
        ]
    ]));
    
    $json_data = array(
        'ads_id' => $ads_id,
        'object_id' => $object_id,
        'account_id' => $account_id,
        'type' => $loai
    );
    $response = file_get_contents('https://gateway.golike.net/api/advertising/publishers/tiktok/skip-jobs', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => buildHeaders($headers),
            'content' => json_encode($json_data)
        ]
    ]));
    return json_decode($response, true);
}

// Hàm hỗ trợ xây dựng headers
function buildHeaders($headers) {
    $headerString = "";
    foreach ($headers as $key => $value) {
        $headerString .= "$key: $value\r\n";
    }
    return $headerString;
}

// Lấy danh sách tài khoản TikTok
$chontktiktok = chonacc();

// Hiển thị danh sách tài khoản
function dsacc() {
    global $chontktiktok;
    while (true) {
        try {
            if ($chontktiktok["status"] != 200) {
                echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mAuthorization hoặc T sai hãy nhập lại!!!\n";
                echo "\033[1;97m════════════════════════════════════════════════\n";
                exit();
            }
            banner();
            echo "\033[1;97m[\033[1;91m❣\033[1;97m]\033[1;97m Địa chỉ Ip\033[1;32m  : \033[1;32m☞\033[1;31m♔ \033[1;32m83.86.8888\033[1;31m♔ \033[1;97m☜\n";
            echo "\033[1;97m════════════════════════════════════════════════\n";
            echo "\033[1;97m[\033[1;91m❣\033[1;97m]\033[1;33m Danh sách acc Tik Tok : \n";
            echo "\033[1;97m════════════════════════════════════════════════\n";
            for ($i = 0; $i < count($chontktiktok["data"]); $i++) {
                echo "\033[1;36m[".($i + 1)."] \033[1;36m✈ \033[1;97mID\033[1;32m㊪ :\033[1;93m ".$chontktiktok["data"][$i]["unique_username"]." \033[1;97m|\033[1;31m㊪ :\033[1;32m Hoạt Động\n";
            }
            echo "\033[1;97m════════════════════════════════════════════════\n";
            break;
        } catch (Exception $e) {
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32m".json_encode($chontktiktok)."\n";
            sleep(10);
        }
    }
}

// Hiển thị danh sách tài khoản
dsacc();

// Chọn tài khoản TikTok
$d = 0;
while (true) {
    echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mNhập \033[1;31mID Acc Tiktok \033[1;32mlàm việc: ";
    $idacc = trim(fgets(STDIN));
    for ($i = 0; $i < count($chontktiktok["data"]); $i++) {
        if ($chontktiktok["data"][$i]["unique_username"] == $idacc) {
            $d = 1;
            $account_id = $chontktiktok["data"][$i]["id"];
            break;
        }
    }
    if ($d == 0) {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mAcc này chưa được thêm vào golike or id sai\n";
        continue;
    }
    break;
}

// Nhập thời gian làm job
while (true) {
    try {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mNhập thời gian làm job : ";
        $delay = intval(trim(fgets(STDIN)));
        break;
    } catch (Exception $e) {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mSai định dạng!!!\n";
    }
}

// Nhận tiền lần 2 nếu lần 1 fail
while (true) {
    try {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mNhận tiền lần 2 nếu lần 1 fail? (y/n): ";
        $lannhan = trim(fgets(STDIN));
        if ($lannhan != "y" && $lannhan != "n") {
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mNhập sai hãy nhập lại!!!\n";
            continue;
        }
        break;
    } catch (Exception $e) {
        // Bỏ qua
    }
}

// Nhập số job fail để đổi acc TikTok
while (true) {
    try {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mSố job fail để đổi acc TikTok (nhập 1 nếu k muốn dừng) : ";
        $doiacc = intval(trim(fgets(STDIN)));
        break;
    } catch (Exception $e) {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mNhập vào 1 số!!!\n";
    }
}

// Hỏi xem người dùng có muốn sử dụng ADB không
while (true) {
    try {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mBạn có muốn sử dụng Auto Like + Follow? (y/n): ";
        $auto_follow = strtolower(trim(fgets(STDIN)));
        
        if ($auto_follow != "y" && $auto_follow != "n") {
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mNhập sai hãy nhập lại!!!\n";
            continue;
        }
        
        if ($auto_follow == "y") {
            // Kiểm tra xem đã có thông tin thiết bị được lưu chưa
            $device_id = load_device_info();

            // Nếu không có thông tin thiết bị, yêu cầu kết nối ADB
            if (!$device_id) {
                echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mThiết bị chưa được kết nối qua ADB. Vui lòng thêm thiết bị.\033[0m\n";
                while (true) {
                    try {
                        echo "\033[1;97m════════════════════════════════════════════════\n";
                        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;33mNhập 1 Để kết nối thiết bị Android 10 .\033[0m\n";
         
