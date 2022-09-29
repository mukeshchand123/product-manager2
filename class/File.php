<?php
require_once("Operation.php");
class Filehandling extends Operation{
    function file_upload($filename,$tmp_name,$dirname,$name){
                 $rand = rand('111111','999999');
             
                $newname=$name.'_'.$rand.'_'.$filename;
                
                move_uploaded_file($tmp_name,$dirname.'/'.$newname);
                  $dir = $dirname.'/'.$newname;
                  return $dir;
    }
    function fileValidation($ext, $validext){

        if(in_array($ext,$validext)==true){
            return true;
        }else{
            return false;
        }

    }
    // function filedelete($table,$userid,$id){
    //     //$obj = new query();
    //     $flag = false;
    //     $userdata = $this->getData($table,'*',[$userid=>$id]);
    //     $num_rows = $userdata->rowCount();
    //     //deleting user files from directory
    //     if($num_rows>0){ 
    //       while($rows = $userdata->fetch(PDO::FETCH_ASSOC)){
    //         $userfile = $rows['filedir'];
    //         unlink($userfile);
    //         $flag = true;
    //       }}

    //       return $flag;
    // }
}


?>