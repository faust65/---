<?php
//echo 'hello world';
$dbh=new PDO('mysql:host=localhost; dbname=restful; charset=utf8','root','');

$method=$_SERVER['REQUEST_METHOD'];
$request=isset($_GET['request']) ? $_GET['request']:'';
//echo "METHOD={$method},request={$request}";
$uri=explode("/",$request);
$api=isset($uri[0]) ? $uri[0]:'';
$id=isset($uri[1]) ? (int)$uri[1]:0;


if($api=='friend') {
    if($method=='GET') {
        $sql='SELECT * FROM friends';
        if($id) $sql.=" WHERE id={$id}";
        $sql .=' ORDER BY id DESC';
        $friends=array();
        if($sth=$dbh->query($sql)){
            $friends=$sth->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($friends);
    } else if($method=='POST') {
        $res=array('success'=>false);
        $name=isset($_POST['name']) ? $_POST['name']:'';
        $phone=isset($_POST['phone']) ? $_POST['phone']:'';
        $email=isset($_POST['email']) ? $_POST['email']:'';
        $city=isset($_POST['city']) ? $_POST['city']:'';
        if($name && $phone && $email && $city){
            $sql='INSERT INTO friends(name,phone,email,city) VALUES(:name,:phone,:email,:city)';
            if($sth=$dbh->prepare($sql)){
                $sth->bindParam(':name',$name);
                $sth->bindParam(':phone',$phone);
                $sth->bindParam(':email',$email);
                $sth->bindParam(':city',$city);
                if($sth->execute()){
                    if($sth->rowCount()) $res['success']=true;
                }
            }
        }
        echo json_encode($res);
    } else if($method=='PUT') {
        $res=array('success'=>false);
        if($id){
            $putdata=file_get_contents('php://input');
            $data=array();
            parse_str($putdata,$data);
            $name=isset($data['name']) ? $data['name']:'';
            $phone=isset($data['phone']) ? $data['phone']:'';
            $email=isset($data['email']) ? $data['email']:'';
            $city=isset($data['city']) ? $data['city']:'';
            if($name && $phone && $email && $city){
                $sql='UPDATE friends SET name=:name,phone=:phone,email=:email,city=:city WHERE id=:id';
                if($sth=$dbh->prepare($sql)){
                    $sth->bindParam(':name',$name);
                    $sth->bindParam(':phone',$phone);
                    $sth->bindParam(':email',$email);
                    $sth->bindParam(':city',$city);
                    $sth->bindParam(':id',$id);
                    if($sth->execute()){
                        if($sth->rowCount()) $res['success']=true;
                    }
                }
            }

        }
        echo json_encode($res);
    } else if($method=='DELETE') {
        $res=array('success'=>false, "id"=>$id);
        if($id){
            $sql='DELETE from friends WHERE id=:id';
            if($sth=$dbh->prepare($sql)){
                $sth->bindParam(':id',$id);
                if( $sth->execute() ){
                    if($sth->rowCount()) $res['success']=true;
                }
            }
        }
        echo json_encode($res);
    }
}