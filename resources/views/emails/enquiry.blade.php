<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <table>
        <tr>
            <td>Xin chào, Admin</td>
        </tr>
        <tr>
            <td>Bạn có một khách hàng gừi câu hỏi đến! Thông tin như bên dưới:</td>
        </tr>
        <tr>
            <td>Tên Khách Hàng: {{ $name }}</td>
        </tr>
        <tr>
            <td>Email Khách Hàng: {{ $email }}</td>
        </tr>
        <tr>
            <td>Chủ Đề Câu Hỏi: {{ $subject }}</td>
        </tr>
        <tr>
            <td>Lời Nhắn/Câu Hỏi: {{ $comment }}</td>
        </tr>
        <tr>
            <td>Đây là tin nhắn tự động từ website Minhhungjsc.com.vn, vui lòng không trả lời qua hòm thư này.</td>
        </tr>
    </table>
</body>
</html>
