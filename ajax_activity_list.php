<?php 

	$conn = mysqli_connect('localhost', 'root', '!Wpghqk@', 'jehovah_dailyreport');
	mysqli_set_charset($conn,"utf8");	

	// $sql= "UPDATE project_list SET active=NULL";			
	// mysqli_query($conn, $sql);	
    $sth = mysqli_query($conn, "SELECT activity_id, activity_name, cons_name, SUM(total_cost) as cost FROM statement GROUP BY activity_id");
    $rows = array();     
    $rows2 = array();     
    $done_cost = 0;
    $done_cost_개별 = 0;
    $arr = array();
    
    while($r = mysqli_fetch_assoc($sth)) {        

        $rows['activity_id'] = $r['activity_id'];    
        $rows['activity_name'] = $r['activity_name'];    
        $rows['cons_name'] = $r['cons_name'];    
        $rows['cost'] = $r['cost'];    

            

            // $sth2 = mysqli_query($conn, "SELECT st_id, cons_name, item, st_standard, unit, vol, total_unit, total_cost FROM statement WHERE activity_id='".$r['activity_id']."'");           
            $sth2 = mysqli_query($conn, "SELECT 
                                        a.activity_id, a.st_id, a.cons_name, a.item, a.st_standard, a.unit, a.vol, a.total_unit, a.total_cost, 
                                        (SELECT sum(b.vol) FROM statement_detail AS b WHERE a.st_id=b.st_id) AS vol2 
                                        FROM statement AS a WHERE a.activity_id='".$r['activity_id']."'");

            while($r2 = mysqli_fetch_assoc($sth2)) {                        
                $rows2[] =  $r2;         
                //$done_vol += $r2['total_cost'];
                
                // $rows2['st_id'] = $r2['st_id'];
                // $rows2['cons_name'] = $r2['cons_name'];
                // $rows2['item'] = $r2['item'];
                // $rows2['st_standard'] = $r2['st_standard'];
                // $rows2['unit'] = $r2['unit'];
                // $rows2['vol'] = $r2['vol'];
                // $rows2['total_unit'] = $r2['total_unit'];
                // $rows2['total_cost'] = $r2['total_cost'];
                // //$rows2['done_cost'] = $done_cost;
                
                
                $sth3 = mysqli_query($conn, "SELECT vol FROM statement_detail WHERE st_id='".$r2['st_id']."'");           
                while($r3 = mysqli_fetch_assoc($sth3)){    
                   if(mysqli_num_rows($sth3)>0) {
                        $done_cost += ($r2['total_unit'] * $r3['vol']);
                    }else{
                        $done_cost = 0;
                    }
                }
                
            }  
            
            $rows['done_vol'] = $done_cost;
            $rows['sts'] = $rows2;            
                 
            //$rows['done_vol'] = $done_vol;
            array_push($arr, $rows);
            
            $rows2 = [];        
            $done_cost = 0;
            $done_cost_개별 = 0;
        
    }

 

    echo json_encode($arr);

	
?>



