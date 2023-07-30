<?php 

	$conn = mysqli_connect('localhost', 'root', '!Wpghqk@', 'jehovah_dailyreport');
	mysqli_set_charset($conn,"utf8");	

	// $sql= "UPDATE project_list SET active=NULL";			
	// mysqli_query($conn, $sql);	
    $sth = mysqli_query($conn, "SELECT * from statement_detail where st_id='".$_POST['st_id']."' order by datetime desc");
    $rows = array();         
    $arr = array();
    
    $td = "";
    $total_vol = $_POST['vol'];
    $vol_stack = 0;
    $vol_stack2 = 0;
    $t_flag="false";
    $txt="";
    
    while($r = mysqli_fetch_assoc($sth)) {        
        
        if(date('Y-m-d', strtotime($r['datetime']))!=date("Y-m-d")){
            $vol_stack += $r['vol'];
        }elseif(date('Y-m-d', strtotime($r['datetime']))==date("Y-m-d")){
            $t_flag = $r['t_flag'];
            $txt = $r['txt'];
        }

        $vol_stack2 += $r['vol'];        
        $td .= "<tr>";
        $td .= "<td style='text-align:center;'>".date('Y-m-d', strtotime($r['datetime']))."</td>";        
        $td .= "<td  style='text-align:center;'>".$r['vol']."</td>";
        $td .= '<td>
                <div class="d-flex flex-column w-100 mr-2" >
                    <div class="d-flex align-items-center justify-content-between mb-2" >
                        <span class="text-muted mr-2 font-size-sm font-weight-bold">'.$vol_stack2."/".$total_vol.'</span>
                        <span class="text-muted font-size-sm font-weight-bold">'.number_format(($vol_stack2/$total_vol)*100, 1).'%</span>
                    </div>
                    <div class="progress progress-xs w-100" >
                        <div class="progress-bar bg- bg-danger" role="progressbar" style="width: '.number_format(($vol_stack2/$total_vol)*100,0).'%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" ></div>
                    </div>
                </div>
                </td>';    
        //$td .= "<td>".$vol_stack."/".$total_vol."</td>";
        $td .= "</tr>";

                                                                            

    }

    $max_input= $total_vol-$vol_stack;
    echo $td."###".$max_input."###".$t_flag."###".$txt;
    
    
    //echo $td;
    

	
?>
