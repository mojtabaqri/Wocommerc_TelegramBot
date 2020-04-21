<?php
const db_name="telebot";
const db_user="root";
const db_pass="";

   try {
       $pdo = new PDO('mysql:host=localhost;dbname='.db_name,db_user ,db_pass);
    }
    catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
/*$data = [
    'ucid' => "asdasd",
    'ufname' => "asdadadasdsa",
    'utid' => "3433434",
];
$sql = "INSERT INTO users (chat_id,name,last_name) VALUES (:ucid,:ufname,:utid)";
$stmt= $pdo->prepare($sql);
$res=$stmt->execute($data);*/

/*
 function CheckItem($itemName,$itemValue)
 {
     $pdo = new PDO('mysql:host=localhost;dbname='.db_name,db_user ,db_pass);
     $stmt = $pdo->prepare("SELECT * FROM users WHERE $itemName=:itemValue");
     $stmt->execute(['itemValue' => $itemValue]);
     $user = $stmt->fetch();
     return $user["$itemName"];
 }
 echo CheckItem("id","14");
*/
//$stmt = $pdo->prepare("SELECT * FROM product where Pname LIKE '%hdmi%'");
//$stmt->execute();
//$stmt->setFetchMode(PDO::FETCH_ASSOC);
//$res=$stmt->fetchAll();
//$mainarray=array();
/*foreach ($res as $k)
{
    $data = [
        'Pid' =>$k['Pid'],
        'Pname' => $k['Pname'],
        'Pqty' => $k['Pqty'],
        'Pdescrip' => $k['Pdescrip'],
        'Pprice' => $k['Pprice'],
    ];
array_push($mainarray,$data);
}
$mainarray=json_encode($mainarray);
print_r($mainarray);*/

//                   &&&&&&&&&&&&&&&&&&&&&     Search multiple item row ********************

/*$stmt = $pdo->prepare("SELECT * FROM product where Pname LIKE '%hdmi%'");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$res=$stmt->fetchAll();
$mainarray=array();
foreach ($res as $k)
{
$mainarray[]=$k;
}
$mainarray=json_encode($mainarray);
print_r($mainarray);


*/

//                   &&&&&&&&&&&&&&&&&&&&&     Search multiple item row ********************

