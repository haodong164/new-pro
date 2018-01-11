<?php
namespace app\intention\controller;

use think\Loader;
use think\Controller;
use PHPMailer\PHPMailer\PHPMailer;
class Sendemail extends Controller
{
    public function index(){
        return $this->fetch();
    }
    public function send(){
        $data=input('post.');
        $tomail=$data['email'];
        $title=$data['content'];
        $body="我叫史磊";
        $mail=new PHPMailer();
        $toemail = $tomail;//定义收件人的邮箱
        $mail->isSMTP();// 使用SMTP服务
        $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
        $mail->Host = "smtp.163.com";// 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;// 是否使用身份验证
        $mail->Username = "lihaodong164@163.com";// 发送方的邮箱用户名，就是自己的邮箱名
        $mail->Password = "qq1648009866";// 发送方的邮箱密码，不是登录密码,是qq的第三方授权登录码,要自己去开启,在邮箱的设置->账户->POP3/IMAP/SMTP/Exchange/CardDAV/CalDAV服务 里面
        //$mail->SMTPSecure = "ssl";// 使用ssl协议方式,
        $mail->Port = 25;// QQ邮箱的ssl协议方式端口号是465/587
        $mail->setFrom("lihaodong164@163.com","李浩东");// 设置发件人信息，如邮件格式说明中的发件人,
        $mail->addAddress($toemail,'test111');// 设置收件人信息，如邮件格式说明中的收件人
        $mail->addReplyTo("lihaodong164@163.com","Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
        //$mail->addCC("xxx@163.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址(这个人也能收到邮件)
        //$mail->addBCC("xxx@163.com");// 设置秘密抄送人(这个人也能收到邮件)
        //$mail->addAttachment("bug0.jpg");// 添加附件
        $mail->Subject = $title;// 邮件标题
        $mail->Body = $body;// 邮件正文
        //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用
        if(!$mail->send()){// 发送邮件
            echo "Message could not be sent.";
            echo "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
        }else{
            echo '发送成功';
        }
    }
    //用封装的
    public function sends (){
        $data=input('post.');
        $email=$data['email'];
        $username=$data['content'];
        $title="你好,".$username.'欢迎注册相亲网';
        $body="你好，".$username.',相亲网欢迎你的加入，以下是激活链接：http://localhost/tp5';
        sendmail($email,$title,$body);
    }
    public function suanshu(){
        /*表达式一*/
        if($a = 10 && $b = 7) {
            ++$a;
            $b++;
        }
        echo $a."表达式一".$b."表达式一<br>";
        /*表达式二*/
        if($a = 10 || $b = 7) {
            ++$a;
            $b++;
        }
        echo $a."表达式二".$b."表达式二<br>";
        /*表达式三*/
        if($a = 10 || $b = 7) {
            $a++;
            $b++;
        }
        // 分别等于多少 
        echo $a."表达式三".$b."表达式三<br>";

    }
}