<?php
/** Captcha
* @author: DreamCraft Development Team
*/
    
class Captcha{
    
    private $sname = '';
    
    public function __construct($sname=''){ // $sname captcha session name
        $this->sname = $sname==''? 'dreamProt' : $sname;
    }
    
    /** gen img
     * @param int $length
     * @param Array $param
     * @return IMG
     */
    public function create($length=4,$param=array()){
        Header("Content-type: image/PNG");
        $authnum = $this->random($length); //gen chars
        
        $width = isset($param['width'])? $param['width'] : 13; //txt wid
        $height = isset($param['height'])? $param['height'] : 18; //txt hig
        $pnum = isset($param['pnum'])? $param['pnum'] : 100; //obf pix
        $lnum = isset($param['lnum'])? $param['lnum'] : 2; //obf line
        
        $this->captcha_session($this->sname,$authnum);
        
        $pw = $width*$length+10;
        $ph = $height+6;
        
        $im = imagecreate($pw,$ph);// new a img
        $black = ImageColorAllocate($im, 238,238,238); //bg col
        
        $values = array(
            mt_rand(0,$pw), mt_rand(0,$ph),
            mt_rand(0,$pw), mt_rand(0,$ph),
            mt_rand(0,$pw), mt_rand(0,$ph),
            mt_rand(0,$pw), mt_rand(0,$ph),
            mt_rand(0,$pw), mt_rand(0,$ph),
            mt_rand(0,$pw), mt_rand(0,$ph)
        );
        imagefilledpolygon($im, $values, 6, ImageColorAllocate($im, mt_rand(170,255),mt_rand(200,255),mt_rand(210,255))); //设置干扰多边形底图
        
        /* text */
        for ($i = 0; $i < strlen($authnum); $i++){
            $font = ImageColorAllocate($im, mt_rand(0,50),mt_rand(0,150),mt_rand(0,200));//设置文字颜色
            $x = $i/$length * $pw + rand(1, 6); //x-rot
            $y = rand(1, $ph/3);   //y-rot
            imagestring($im, mt_rand(4,6), $x, $y, substr($authnum,$i,1), $font); 
        }
        
        /* obf px */
        for($i=0; $i<$pnum; $i++){
            $dist = ImageColorAllocate($im, mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)); //col
            imagesetpixel($im, mt_rand(0,$pw) , mt_rand(0,$ph) , $dist); 
        } 
        
        /* obf line */
        for($i=0; $i<$lnum; $i++){
            $dist = ImageColorAllocate($im, mt_rand(50,255),mt_rand(150,255),mt_rand(200,255)); //col
            imageline($im,mt_rand(0,$pw),mt_rand(0,$ph),mt_rand(0,$pw),mt_rand(0,$ph),$dist);
        }
        
        return $im;
    }
    
    /** check
     * @param String $captcha
     * @param int $flag 0: do not clear the session   1: clear the session
     * @return boolean
     */
    public function check($captcha,$flag=1){
        if(empty($captcha)){
            return false;
        }
        else{
            if(strtoupper($captcha)==$this->captcha_session($this->sname)){
                if($flag==1){
                    $this->captcha_session($this->sname,'');
                }
                return true;
            }
            else{
                return false;
            }
        }
    }
    
    /* bgen random
    * @param int $length
    * @return String
    */
    private function random($length){
    $hash = '';
    $chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
    }
    
    /** session
     * @param String $name captcha session name
     * @param String $value
     * @return String
     */
    private function captcha_session($name,$value=null){
        if(isset($value)){
            if($value!==''){
                $_SESSION[$name] = $value;
            }
            else{
                unset($_SESSION[$name]);
            }
        }
        else{
            return isset($_SESSION[$name])? $_SESSION[$name] : '';
        }
    }
}
?>