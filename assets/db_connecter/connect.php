<?php
/*ignore it's a warning remover*/
error_reporting(E_ALL ^ E_DEPRECATED);

/*Variables for connection*/
$host = "localhost";
$user = "root";
$pass = "";
$database = "btwofficial";

/*Connection Functions*/
$link = mysql_connect($host,$user,$pass) or die ("Connection was unsuccessful");
mysql_select_db("btwofficial");


/*Custom Functions*/
function userTable($recidentifier,$recwantedColumn){

    $identifier = $recidentifier;
    $wantedColumn = $recwantedColumn;

    $sqlQuery = "SELECT * FROM user WHERE ID = $identifier";
    $rawData = mysql_query($sqlQuery);
    $results = mysql_fetch_array($rawData);

    return $results[$wantedColumn];
}

function profileTable($recidentifier,$recwantedColumn){
    
    $identifier = $recidentifier;
    $wantedColumn = $recwantedColumn;
    
    $sqlQuery = "SELECT * FROM userProfile WHERE PID = $identifier";
    $rawData = mysql_query($sqlQuery);
    $results = mysql_fetch_array($rawData);
    
    return $results[$wantedColumn];
}

function postsTable($recidentifier,$recwantedColumn,$recSeperator){
        
    $identifier = $recidentifier;
    $wantedColumn = $recwantedColumn;
        
    if($recSeperator == "post"){
    $sqlQuery = "SELECT * FROM posts WHERE UID=$identifier";
    }else if($recSeperator == "user"){
    $sqlQuery = "SELECT * FROM posts WHERE ID=$identifier";
    }

    $rawData = mysql_query($sqlQuery);
    $results = mysql_fetch_array($rawData);
        
    return $results[$wantedColumn];
}

function myPosts($recidentifier){
    
    $identifier = $recidentifier;
    
    $sqlQuery = "SELECT PID FROM my WHERE UID = $identifier";
    $rawData = mysql_query($sqlQuery);

    $datas = array();
        if(mysql_num_rows($rawData)>0){
            while($row = mysql_fetch_assoc($rawData)){
                $datas[] = $row;
            }
        }

    return $datas;
}

function favPosts($recidentifier){
    $identifier = $recidentifier;
    
    $sqlQuery = "SELECT PID FROM favorites WHERE UID = $identifier";
    $rawData = mysql_query($sqlQuery);

    $datas = array();
        if(mysql_num_rows($rawData)>0){
            while($row = mysql_fetch_assoc($rawData)){
                $datas[] = $row;
            }
        }

    return $datas;
}

/*Dua Custom Functions*/
function postInserter($userid, $text, $title,$pic, $genre, $location){
    
        $sqlQuery = "INSERT INTO `posts` (`UID`,`Text`,`Title`,`Pic`,`Genre`,`Location`,`FavCount`) VALUES ('$userid', '$text', '$title','$pic', '$genre', '$location','0')";
        mysql_query($sqlQuery) or die(mysql_error());
        
    }


function supInserter($email,$pass,$dob,$gender){

    $sqlQuery = "INSERT INTO `user` (`Email`,`Pass`,`DOB`,`Gender`) VALUES ('$email','$pass','$dob','$gender')";
    mysql_query($sqlQuery) or die(mysql_error());

}

function idAccess($recidentifier){
    
        $identifier = $recidentifier;
    
        $sqlQuery = "SELECT * FROM user WHERE Email = '$identifier'";
        $rawData = mysql_query($sqlQuery);
        $results = mysql_fetch_array($rawData);
    
        return $results["ID"];
    }

function sinValidator($username,$recPassword){

    $sqlQuery = "SELECT * FROM user WHERE Email = '$username'";
    $rawData = mysql_query($sqlQuery);
    $results = mysql_fetch_array($rawData);

    $password = $results["Pass"];
    
    if($password == $recPassword){
        return 1;
    }else {
        return 0;
    }
}

function updatePass($username,$oldPass,$newPass){

    $status = "not set";
    $sqlQuery = "SELECT * FROM user WHERE Email = '$username'";
    $rawData = mysql_query($sqlQuery);
    $results = mysql_fetch_array($rawData);

    $strOldPass = $results["Pass"];

    if ($strOldPass == $oldPass){
        $sqlQuery = "UPDATE user SET Pass = '$newPass' WHERE Email = '$username'";
        mysql_query($sqlQuery) or die (mysql_error());
        $status = "Changed";
        return $status;
    }else{
        $status = "Not Changed, Invalid Old Password or Username";
        return $status;
    }
}


/*Test usage of the Functions for understanding*/
/*these are just demonstration examples, extensive details have been shared in documentation*/

$outside = userTable(1,"Pass");
$outside2 = profileTable(1,"Fname");
$outside3 = postsTable(1,"Title","post");
//supInserter("khan@yahoo.com","newpass","2017-11-19","0");
$outside4 = userTable(2,"Gender");
$outside5 = userTable(2,"Email");
$validator = sinValidator("umaryousafzai9@gmail.com","rechangedit");

$newdatas = myPosts(1);
$favposts = favPosts(1);

$idfromemail = idAccess("khan@yahoo.com");

echo "<br>".$idfromemail."<br><br>";


echo "<br>";

foreach($newdatas as $data){
    echo $data['PID']."<br>";
}

echo "<br>";

foreach($favposts as $data){
    echo $data['PID']."<br>";
}

echo "<br>";

if($validator == 1){
    echo "Returned True <br>";
}else {
    echo "Returned False <br>";
}

$status = updatePass("umaryousafzai9@gmail.com","ichangedit","rechangedit");

echo $status."<br>";

echo $outside4."<br>";
echo $outside5."<br>";
echo $outside."<br>";
echo $outside2."<br>";
echo $outside3."<br>";

echo 'this all ran';

mysql_close($link);

?>