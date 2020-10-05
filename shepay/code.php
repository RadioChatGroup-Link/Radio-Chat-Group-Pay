<?php
class ValidateCode
{

    private $charset = '1234567890';//随机因子

    private $code;//验证码

    private $codelen = 4;//验证码长度

    private $width = 150;//宽度

    private $height = 36;//高度

    private $img;//图形资源句柄


    private $fontsize = 60;//指定字体大小

    private $fontcolor;//指定字体颜色

    //构造方法初始化

    public function __construct()
    {
    }

    //生成随机码

    private function createCode()
    {

        $_len = strlen($this->charset) - 1;

        for ($i = 0; $i < $this->codelen; $i++) {

            $this->code .= $this->charset[mt_rand(0, $_len)];

        }

    }

    //生成背景
    private function createBg()
    {

        $this->img = imagecreatetruecolor($this->width, $this->height);

        $color = imagecolorallocate($this->img, 243, 251, 254);

        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);

    }


    //生成文字

    private function createFont()
    {

        $_x = $this->width / $this->codelen;

        for ($i = 0; $i < $this->codelen; $i++) {

            $this->fontcolor = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));

            imagestring($this->img, $this->fontsize, $_x * $i + mt_rand(1, 5), $this->height / 3, $this->code[$i], $this->fontcolor);

        }

    }


    //生成线条、雪花

    private function createLine()
    {

        //线条

        for ($i = 0; $i < 6; $i++) {

         

        }

        //雪花

        for ($i = 0; $i < 100; $i++) {



        }

    }
    //输出

    private function outPut()
    {

        header('Content-type:image/png');

        imagepng($this->img);

        imagedestroy($this->img);

    }

    //对外生成

    public function doimg()
    {

        $this->createBg();

        $this->createCode();

        $this->createLine();

        $this->createFont();

        $this->outPut();

    }

    //获取验证码

    public function getCode()
    {

        return strtolower($this->code);

    }

}


session_start();

$_vc = new ValidateCode();  //实例化一个对象

$_vc->doimg();

$_SESSION['vc_code'] = $_vc->getCode();//验证码保存到SESSION中

exit();