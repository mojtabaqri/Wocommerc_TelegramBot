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
        if($gptecbot->CheckItem("ucid",$user['Chat_id'])==$user['Chat_id'])
        {
            $text= explode("#",$user['Message']);
            $result=$cpost->searchItem($text[1]);
            if($result!=null){
                foreach ($result as $item)
                {
                    $data=[
                        'productPhoto'=>$item['_thumbnail_id'],
                        'productCaption'=>"\t \t \t "."✅".$item['post_title']."\n"." قیمت : ".$item['_regular_price']."تومان 💳 ",
                        'productUrl'=>$item['post_name'],
                    ];
                    $gptecbot->sendProduct($data);
                }
            }
            else
                $gptecbot->Send2id($user['Chat_id'],"محصولی یافت نشد ....");
        }
        else
            $gptecbot->Send2id($user['Chat_id'],"   شما عضو ربات نیستید بنا بر این نمیتوانید جستجو را انجام دهید با استفاده از دستور /register"." \t ثبت نام کنید⚠️ ");


    }
    else if(($user['Message'])=="/start")
        $gptecbot->Send2id($user['Chat_id'],$user['First_name']." ".$user['Last_name']."عزیز"."خوش آمدید"."\n"."با استفاده از دستور /register میتوانید ثبت نام کنید");
    else if(($user['Message'])=="/register")
        $gptecbot->saveUser();
    else
        $gptecbot->Send2id($user['Chat_id'],"دوست عزیز من ربات هستم ادم که نیستم اینا چیه برام میفرستی من چ بدونم یعنی چی عجب!");
}
?>