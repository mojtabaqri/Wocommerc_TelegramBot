<?php
class robot{
    private $Token,$Url,$Json;
    protected $db_name,$db_user,$db_pass,$DBH;
    public function __construct($token,$url)
    {
        $this->Token=$token;
        $this->Url=$url;
    }

    public function setDataBaseInfo($db_name,$db_user,$db_pass)
    {
        $this->db_name=$db_name;
        $this->db_user=$db_user;
        $this->db_pass=$db_pass;
    }

    public function setJson($value)
    {
        $this->Json=$value;
    }
    protected  function getJson()
    {
        return $this->Json;
    }
    protected function ali($method,$datas=[]){
        $url = "https://api.telegram.org/bot".$this->Token."/".$method;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
        $res = curl_exec($ch);
        if(curl_error($ch)){
            var_dump(curl_error($ch));
        }else{
            return json_decode($res);
        }
    }
   public function Send2id($chat_id, $Message)
    {
        $this->ali('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>$Message,
            'parse_mode'=>"MarkDown"
        ]);
    }
    private function copen()
    {
        try {
            $this->DBH = new PDO('mysql:host=localhost;dbname='."$this->db_name", $this->db_user, $this->db_pass);
       echo "اتصال برقرار است .";
            $this->DBH->exec("set names utf8");
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    private function cclose()
    {
        $this->DBH=null;
    }
    //Check Single Item in Single Row Method
    private function CheckItem($fieldName,$fieldValue)
    {
        $this->copen();
        $stmt = $this->DBH->prepare("SELECT * FROM users WHERE $fieldName=:itemValue");
        $stmt->execute(['itemValue' => $fieldValue]);
        $result = $stmt->fetch();
        $this->cclose();
        return $result["$fieldName"];
    }

    public function saveUser()
    {
        if($this->CheckItem("ucid",$this->UserInfo()['Chat_id'])==$this->UserInfo()['Chat_id'])
        {
            $this->Send2id($this->UserInfo()['Chat_id'], "شما قبلا ثبت نام کرده اید دوست عزیز !");
            return 0;
        }
      $this->copen();
      $data = [
          'ucid' => $this->UserInfo()['Chat_id'],
          'ufname' => $this->UserInfo()['First_name'],
          'utid' => $this->UserInfo()['Telegram_id'],
          'ulang' => $this->UserInfo()['Language'],
          'ulname' => $this->UserInfo()['Last_name'],
      ];
      $sql = "INSERT INTO users (ucid,ufname,utid,ulang,ulname) VALUES (:ucid,:ufname,:utid,:ulang,:ulname)";
      $stmt = $this->DBH->prepare($sql);
      $res = $stmt->execute($data);
      $this->cclose();
      if ($res) {
          $this->Send2id($this->UserInfo()['Chat_id'], $this->UserInfo()['First_name'] . "عزیز خوش آمدید اطلاعات شما ثبت شد ");
      } else {
          $this->Send2id($this->UserInfo()['Chat_id'], "ثبت نام ناموفق بود متاسفانه ! ");
      }



    }
    public function UserInfo()
    {
    $json=$this->getJson();
    $info = array(
    "Chat_id" => $json->message->from->id,
    "Message_id" => $json->message->message_id,
    "Update_id" => $json->update_id,
    "Telegram_id" => $json->message->from->username,
    "Language" => $json->message->from->language_code,
    "Message" => $json->message->text,
    "First_name" => $json->message->from->first_name,
    "Last_name" => $json->message->from->last_name,
     );
     return $info;
    }











}
