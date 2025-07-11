<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

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

// Chọn chế độ làm việc
while (true) {
    try {
        echo "\033[1;97m════════════════════════════════════════════════\n";
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mNhập 1 : \033[1;33mChỉ nhận nhiệm vụ Follow\n";
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mNhập 2 : \033[1;33mChỉ nhận nhiệm vụ like\n";
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mNhập 12 : \033[1;33mKết hợp cả Like và Follow\n";
        echo "\033[1;97m════════════════════════════════════════════════\n";
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;34mChọn lựa chọn: ";
        $chedo = intval(trim(fgets(STDIN)));
        
        if ($chedo == 1 || $chedo == 2 || $chedo == 12) {
            break;
        } else {
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mChỉ được nhập 1, 2 hoặc 12!\n";
        }
    } catch (Exception $e) {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mNhập vào 1 số!!!\n";
    }
}

// Xác định loại nhiệm vụ
$lam = array();
if ($chedo == 1) {
    $lam = array("follow");
} elseif ($chedo == 2) {
    $lam = array("like");
} elseif ($chedo == 12) {
    $lam = array("follow", "like");
}

// Bắt đầu làm nhiệm vụ
$dem = 0;
$tong = 0;
$checkdoiacc = 0;
$checkdoiacc1 = 0;
$dsaccloi = array();
$accloi = "";
banner();
echo "\033[1;97m[\033[1;91m❣\033[1;97m]\033[1;97m Địa chỉ Ip\033[1;32m  : \033[1;32m☞\033[1;31m♔ \033[1;32m83.86.8888\033[1;31m♔ \033[1;97m☜\n";
echo "\033[1;97m════════════════════════════════════════════════\n";
echo "\033[1;36m|STT\033[1;97m| \033[1;33mThời gian ┊ \033[1;32mStatus | \033[1;31mType Job | \033[1;32mID Acc | \033[1;32mXu |\033[1;33m Tổng\n";
echo "\033[1;97m════════════════════════════════════════════════\n";
while (true) {
    if ($checkdoiacc == $doiacc) {
        dsacc();
        $idacc = readline("\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mJob fail đã đạt giới hạn nên nhập id acc khác để đổi: ");
        sleep(2);
        banner();
        echo "\033[1;97m[\033[1;91m❣\033[1;97m]\033[1;97m Địa chỉ Ip\033[1;32m  : \033[1;32m☞\033[1;31m♔ \033[1;32m83.86.8888\033[1;31m♔ \033[1;97m☜\n";
        echo "\033[1;97m════════════════════════════════════════════════\n";
        $d = 0;
        for ($i = 0; $i < count($chontktiktok["data"]); $i++) {
            if ($chontktiktok["data"][$i]["unique_username"] == $idacc) {
                $d = 1;
                $account_id = $chontktiktok["data"][$i]["id"];
                break;
            }
        }
        if ($d == 0) {
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;31mAcc chưa thêm vào Golike hoặc ID không đúng!\n";
            continue;
        }
        $checkdoiacc = 0;
    }

    echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;35mĐang Tìm Nhiệm vụ:>        \r";
    while (true) {
        try {
            $nhanjob = nhannv($account_id);
            break;
        } catch (Exception $e) {
            // pass
        }
    }

    // Kiểm tra job trùng (so sánh với job trước đó)
    static $previous_job = null;
    if ($previous_job !== null && 
        $previous_job["data"]["link"] === $nhanjob["data"]["link"] && 
        $previous_job["data"]["type"] === $nhanjob["data"]["type"]) {
        echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mJob trùng với job trước đó - Bỏ qua!        \r";
        sleep(2);
        try {
            baoloi($nhanjob["data"]["id"], $nhanjob["data"]["object_id"], $account_id, $nhanjob["data"]["type"]);
        } catch (Exception $e) {
            // pass
        }
        continue;
    }
    $previous_job = $nhanjob;

    if (isset($nhanjob["status"]) && $nhanjob["status"] == 200) {
        $ads_id = $nhanjob["data"]["id"];
        $link = $nhanjob["data"]["link"];
        $object_id = $nhanjob["data"]["object_id"];
        $loai = $nhanjob["data"]["type"];

        if (!isset($nhanjob["data"]["link"]) || empty($nhanjob["data"]["link"])) {
            static $notified = false; // Biến static giữ giá trị giữa các lần lặp
            
            if (!$notified) {
                echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mJob die - Không có link!        \r";
                sleep(2);
                $notified = true; // Đánh dấu đã thông báo
            }
            
            try {
                baoloi($nhanjob["data"]["id"], $nhanjob["data"]["object_id"], $account_id, $nhanjob["data"]["type"]);
            } catch (Exception $e) {
                // pass
            }
            continue;
        }
        if (!in_array($nhanjob["data"]["type"], $lam)) {
            try {
                baoloi($ads_id, $object_id, $account_id, $nhanjob["data"]["type"]);
                echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mĐã bỏ qua job {$loai}!        \r";
                sleep(1);
                continue;
            } catch (Exception $e) {
                // pass
            }
        }

        if ($loai == "follow") {
            $loainv = "follow";
        } elseif ($loai == "like") {
            $loainv = " like ";
        }

        // Thử mở link và kiểm tra có thành công không
        exec("termux-open-url $link", $output, $return_var);
        if ($return_var !== 0) {
            echo "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mKhông thể mở link - Job die!";
            try {
                baoloi($ads_id, $object_id, $account_id, $nhanjob["data"]["type"]);
            } catch (Exception $e) {
                // pass
            }
            continue;
        }

        for ($remaining_time = $delay; $remaining_time >= 0; $remaining_time--) {
            $colors = array(
                "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;37mH\033[1;36mu\033[1;35mo\033[1;32mn\033[1;31mg \033[1;34mD\033[1;33me\033[1;36mv\033[1;36m🍉 - Tool\033[1;36m Vip \033[1;31m\033[1;32m",
                "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;34mH\033[1;31mu\033[1;37mo\033[1;36mn\033[1;32mg \033[1;35mD\033[1;37me\033[1;33mv\033[1;32m🍉 - Tool\033[1;34m Vip \033[1;31m\033[1;32m",
                "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;31mH\033[1;37mu\033[1;36mo\033[1;33mn\033[1;35mg \033[1;32mD\033[1;34me\033[1;35mv\033[1;37m🍉 - Tool\033[1;33m Vip \033[1;31m\033[1;32m",
                "\033[1;97m[\033[1;91m❣\033[1;97m] \033[1;36m✈ \033[1;32mH\033[1;33mu\033[1;34mo\033[1;35mn\033[1;36mg \033[1;37mD\033[1;36me\033[1;31mv\033[1;34m🍉 - Tool\033[1;31m Vip \033[1;31m\033[1;32m",
                "\033[1;97m[\0
