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
        $metas = array(
            '_thumbnail_id', '_regular_price'
        );
        foreach ($metas as $i=>$meta_key) {
            $meta_fields[] = 'm' . $i . '.meta_value as ' . $meta_key;
            $meta_joins[] = ' left join ' . cwpsec_postmeta . ' as m' . $i . ' on m' . $i . '.post_id=' . cwpsec_posts . '.ID and m' . $i . '.meta_key="' . $meta_key . '"';
        }
        $request = "SELECT ID, post_title,post_name, " .  join(',', $meta_fields) . " FROM cwpsec_posts ";
        $request .=  join(' ', $meta_joins);
        $request .= " WHERE post_status='publish' AND post_type='product' AND cwpsec_posts.post_title like '%$itemName%'";
        $stmt = $this->DBH->prepare($request);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $product_details =$stmt->fetchAll();
        if(!empty($product_details))
        {
            $prefix_url="http://gptec.ir/fa/product/";
            for ($i=0;$i<count($product_details);$i++) {
                $thumb=$product_details[$i]['_thumbnail_id'];
                $qry = "SELECT guid FROM cwpsec_posts WHERE ID="."$thumb";
                $stmtt = $this->DBH->prepare($qry);
                $stmtt->execute();
                $stmtt->setFetchMode(PDO::FETCH_ASSOC);
                $imageUrl=$stmtt->fetchAll();
                $product_details[$i]['_thumbnail_id']=$imageUrl[0]['guid'];
                $product_details[$i]['post_name']=$prefix_url.$product_details[$i]['post_name'];
            }
        }
        $this->cclose();
        return $product_details;
    }


}