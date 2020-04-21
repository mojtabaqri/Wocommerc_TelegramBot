<?php
require_once ("config/db-config.php");
//$metas = array(
//    '_thumbnail_id', '_regular_price'
//);
//
//foreach ($metas as $i=>$meta_key) {
//    $meta_fields[] = 'm' . $i . '.meta_value as ' . $meta_key;
//    $meta_joins[] = ' left join ' . cwpsec_postmeta . ' as m' . $i . ' on m' . $i . '.post_id=' . cwpsec_posts . '.ID and m' . $i . '.meta_key="' . $meta_key . '"';
//}
//$request = "SELECT ID, post_title, " .  join(',', $meta_fields) . " FROM cwpsec_posts ";
//$request .=  join(' ', $meta_joins);
//$request .= " WHERE post_status='publish' AND post_type='product' AND cwpsec_posts.post_title like '%hdmi%'";
//$stmt = $pdo->prepare($request);
//$stmt->execute();
//$stmt->setFetchMode(PDO::FETCH_ASSOC);
//$product_details =$stmt->fetchAll();
//print_r(json_encode($product_details));



/*$sql = "SELECT guid FROM cwpsec_posts WHERE ID=143";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$product_details =$stmt->fetchAll();
var_dump($product_details);*/

//function GetProductDetails($productName)
//{
//        $pdo = new PDO('mysql:host=localhost;dbname=' . postdb_name, postdb_user, postdb_pass);
//        $pdo->exec("set names utf8");
//    $metas = array(
//    '_thumbnail_id', '_regular_price'
//);
//
//foreach ($metas as $i=>$meta_key) {
//    $meta_fields[] = 'm' . $i . '.meta_value as ' . $meta_key;
//    $meta_joins[] = ' left join ' . cwpsec_postmeta . ' as m' . $i . ' on m' . $i . '.post_id=' . cwpsec_posts . '.ID and m' . $i . '.meta_key="' . $meta_key . '"';
//}
//$request = "SELECT ID, post_title,post_name, " .  join(',', $meta_fields) . " FROM cwpsec_posts ";
//$request .=  join(' ', $meta_joins);
//$request .= " WHERE post_status='publish' AND post_type='product' AND cwpsec_posts.post_title like '%$productName%'";
//$stmt = $pdo->prepare($request);
//$stmt->execute();
//$stmt->setFetchMode(PDO::FETCH_ASSOC);
//$product_details =$stmt->fetchAll();
//if(!empty($product_details))
//{
//    $prefix_url="http://gptec.ir/fa/product/";
//    for ($i=0;$i<count($product_details);$i++) {
//        $thumb=$product_details[$i]['_thumbnail_id'];
//        $qry = "SELECT guid FROM cwpsec_posts WHERE ID="."$thumb";
//        $stmtt = $pdo->prepare($qry);
//        $stmtt->execute();
//        $stmtt->setFetchMode(PDO::FETCH_ASSOC);
//        $imageUrl=$stmtt->fetchAll();
//        $product_details[$i]['_thumbnail_id']=$imageUrl[0]['guid'];
//        $product_details[$i]['post_name']=$prefix_url.$product_details[$i]['post_name'];
//    }
//}
//print_r(json_encode($product_details));
//}
//GetProductDetails("hdmi");
$userChatid="468822221";
    $pdo = new PDO('mysql:host=localhost;dbname=' . db_name, db_user, db_pass);
    $pdo->exec("set names utf8");
    $statement=$pdo->prepare("SELECT * FROM users WHERE ucid=:ivalue");
    $statement->execute(['ivalue' => $userChatid]);
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result=$statement->fetchAll();
    foreach ($result as $item)
    {
        $text= "Your Profile :  "."\n".$item['id']."\t".$item['ucid']."\t".$item['ufname']."\t".$item['ulname']."\t".$item['unumber'];
    }
    print_r($text);

