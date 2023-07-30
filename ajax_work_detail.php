<?php 
     include('dbcon.php');
     include('check.php');
     $st_id = $_POST['st_id'];
     $dt2 = $_POST['dt'];     
    
    if(!isset($errMSG))
    {        
        try{                
            $stmt = $con->prepare("select txt from statement_detail where st_id=:st_id and date_format(datetime, '%Y-%m-%d')=:dt2 ");
            $stmt->bindParam(':st_id', $st_id);
            $stmt->bindParam(':dt2', $dt2);
            $stmt->execute();
            $row = $stmt->fetch();  

        	echo $row['txt'];                

        }catch(PDOException $e) {
            die("Database error. " . $e->getMessage()); 
        }
    }

    
?>
