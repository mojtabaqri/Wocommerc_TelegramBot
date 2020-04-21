<?php

class cpost
{
    protected $db_name,$db_user,$db_pass,$DBH;
    public function __construct($db_name,$db_user,$db_pass)
    {
        $this->db_name=$db_name;
        $this->db_user=$db_user;
        $this->db_pass=$db_pass;
    }
    private function copen()
    {
        try {
            $this->DBH = new PDO('mysql:host=localhost;dbname='."$this->db_name", $this->db_user, $this->db_pass);
            echo "اتصال برقرار شد .";
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

    public function searchItem($itemName){
        $this->copen();
        $stmt = $this->DBH->prepare("SELECT * FROM `cwpsec_posts` WHERE `post_excerpt` LIKE '%$itemName%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $res=$stmt->fetchAll();
        $mainarray=array();
        foreach ($res as $k){
        $mainarray[]=$k;
        }
        $this->cclose();
        return $mainarray;
    }

}