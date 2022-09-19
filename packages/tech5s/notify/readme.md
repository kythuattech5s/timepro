# Chạy thêm Provider vào file app/config 
# sử dụng trait NotificationUserTrait trong Model cần
# Send Notification;

$data = [
    'body' => 1231,
    'link' =>  12321,
    'title' => 'ok ok',
    'img' => 'test',
    'icon' => 'ok'
];

$type = 1;
$user->sendNotification($data, $type);