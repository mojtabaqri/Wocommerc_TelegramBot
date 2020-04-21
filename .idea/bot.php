<?php
require_once ("config/botcfg.php");
require_once ("config/db-config.php");
spl_autoload_register(function ($classname){
    require "classes/".$classname.".php";
});
#--------End Autoload function -------------
$gptecbot=new robot(robot_token,webhook_url);
$j=json_decode(file_get_contents("php://input"));
$gptecbot->setJson($j);
$gptecbot->setDataBaseInfo(db_name,db_user,db_pass);
$cpost=new cpost(postdb_name,postdb_user,postdb_pass);
$user=$gptecbot->UserInfo();
if($user!=null)
{
    if(strpos($user['Message'],"#")!==false)
    {
        $text= explode("#",$user['Message']);
        $gptecbot->Send2id($user['Chat_id'],$text[1]);
    }


}
switch ($user['Message'])
{
    case "/register":
        $gptecbot->saveUser();
        break;
    case "/start":
        $gptecbot->Send2id($user['Chat_id'],$user['First_name']." ".$user['Last_name']."عزیز"."خوش آمدید"."\n"."با استفاده از دستور /register میتوانید ثبت نام کنید");
        break;
    default:
        $gptecbot->Send2id($user['Chat_id'],"متوجه فرمایش شما نشدم");
}
?>