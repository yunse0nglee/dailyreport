<?php 
     include('dbcon.php');
     include('check.php');
     $st_id = $_POST['st_id'];
     $vol = $_POST['vol'];
     $user = "관리자";
     $dt = date("Y-m-d H:i:s");
     $dt2 = date("Y-m-d");
     $activity_id = $_POST['activity_id'];
     $txt = $_POST['txt'];
     $t_flag = $_POST['t_flag'];
     $data_ok = false;
    
    if(!isset($errMSG))
    {
        
        try { 
            $stmt2 = $con->prepare("select * from statement_detail where st_id=:st_id and date_format(datetime, '%Y-%m-%d')=:dt2");
            $stmt2->bindParam(':st_id', $st_id);
            $stmt2->bindParam(':dt2', $dt2);
            $stmt2->execute();

            if ($stmt2->rowCount() > 0) {
               //데이터가 있으면 업데이트
               $stmt = $con->prepare("UPDATE statement_detail SET activity_id = :activity_id, vol = :vol, t_flag = :t_flag, txt = :txt, datetime = :dt2 WHERE st_id = :st_id and date_format(datetime, '%Y-%m-%d')=:dt2");
               $stmt->bindParam(':activity_id',$activity_id);
               $stmt->bindParam(':st_id',$st_id);
               $stmt->bindParam(':vol', $vol);               
               $stmt->bindParam(':txt', $txt);
               $stmt->bindParam(':t_flag', $t_flag);		                 
               $stmt->bindParam(':dt2', $dt2);   
               $MSG = "수정이 완료 되었습니다";

           }else{
               //데이터가 없으면 INSERT
               $stmt = $con->prepare('INSERT INTO statement_detail(activity_id, st_id, vol, user, t_flag, txt, datetime) VALUES(:activity_id, :st_id, :vol, :user, :t_flag, :txt, :dt)');               
               $stmt->bindParam(':activity_id',$activity_id);
               $stmt->bindParam(':st_id',$st_id);
               $stmt->bindParam(':vol',$vol);		
               $stmt->bindParam(':user',$user);		
               $stmt->bindParam(':txt',$txt);
               $stmt->bindParam(':t_flag',$t_flag);	
               $stmt->bindParam(':dt',$dt);
               $MSG = "입력이 완료 되었습니다";		
           }

           if($stmt->execute()){                
                $stmt3 = $con->prepare("select sum(vol) as vol from statement_detail where st_id=:st_id");
                $stmt3->bindParam(':st_id', $st_id);
                $stmt3->execute();
                $row = $stmt3->fetch();  

                $total = 0;
                $stmt4 = $con->prepare("SELECT a.st_id, b.total_unit, sum(a.vol) AS vol, (total_unit*sum(a.vol)) AS total from statement_detail AS a JOIN statement AS b ON a.st_id =b.st_id AND  a.activity_id=:activity_id GROUP BY a.st_id");
                $stmt4->bindParam(':activity_id', $activity_id);
                $stmt4->execute();
                while($row2 = $stmt4->fetch()){
                    $total += $row2['total'];
                };  


				echo $row['vol']."@".$total;
                //$stmt3->execute();
                //echo $MSG;
           }
           else{                
               echo "오류가 발생 했습니다";
           }

        } catch(PDOException $e) {
            die("Database error. " . $e->getMessage()); 
        }

    }


    
?>
