<?php

include_once('./head.php');
include_once('./user_function.php');

if( ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit']))
{

    foreach ($_POST as $key => $val)
    {
        if(preg_match('#^__autocomplete_fix_#', $key) === 1){
            $n = substr($key, 19);
            if(isset($_POST[$n])) {
                $_POST[$val] = $_POST[$n];
            }
        }
    } 
    
    $project_name = $_POST['project_name'];
    $date_start = $_POST['start'];
    $date_end = $_POST['end'];
    $location = $_POST['location'];
    $weather1 = $_POST['weather1'];
    $weather2 = $_POST['weather2'];
    $finedust = $_POST['finedust'];
    $period = $_POST['period'];
    $etc1 = @$_POST['etc1'];
    $etc2 = @$_POST['etc2'];
    $etc3 = @$_POST['etc3'];
    $holiday = "true/true/true/true/true/true/true/true/true/true/true/true";
    $holiday_option = "true,true,true/true,true,true/true,true,true/true,true,true/true,true,true/true,true,true/true,true,true/true,true,true/true,true,true/true,true,true/true,true,true/true,true,true";
    // $aa = "aaa";
    //$MSG = "";
    if(empty($project_name)){
        $MSG = "프로젝트 명을 입력하세요";        
    }
    else if(empty($date_start) || empty($date_end)){
        $MSG = "프로젝트 기간을 입력하세요.";
    }


    if(!isset($MSG)){
       try{
            $stmt = $con->prepare('INSERT INTO project_list(p_name, date_start, date_end, location, weather1, weather2, finedust, period, etc1, etc2, etc3, holiday, holiday_option, owner) 
                VALUES(:project_name, :date_start, :date_end, :location, :weather1, :weather2, :finedust, :period, :etc1, :etc2, :etc3, :holiday, :holiday_option, :owner)');
            
            $stmt->bindParam(':project_name', $project_name);
            $stmt->bindParam(':date_start', $date_start);
            $stmt->bindParam(':date_end', $date_end);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':weather1', $weather1);
            $stmt->bindParam(':weather2', $weather2);
            $stmt->bindParam(':finedust', $finedust);
            $stmt->bindParam(':period', $period);
            $stmt->bindParam(':etc1', $etc1);
            $stmt->bindParam(':etc2', $etc2);
            $stmt->bindParam(':etc3', $etc3);
            $stmt->bindParam(':holiday', $holiday);
            $stmt->bindParam(':holiday_option', $holiday_option);
            $stmt->bindParam(':owner', $name);


            if($stmt->execute())
            {
                $MSG = "새로운 프로젝트를 추가했습니다.";
                echo "<script> alert('".$MSG."');</script>";        
                echo "<script> location.href='./project_list.php';</script>";        
            }
            else
            {
                $MSG = "프로젝트 추가 에러";
            }
        } catch(PDOException $e) {
            die("Database error: " . $e->getMessage()); 
        }
    }else{
        echo "<script> alert('".$MSG."');</script>";        
    }

}



?>
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2 style="font-family: Noto Sans KR">프로젝트 리스트</h2>
        <!-- <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="index.html">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Forms</span></li>
                            <li><span>Advanced</span></li>
                        </ol>
                        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
                    </div> -->
    </header>
    <!-- start: page -->
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>
                <h2 class="panel-title">프로젝트 추가</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="post">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputPlaceholder">프로젝트 명</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="프로젝트명을 입력하세요." id="inputPlaceholder" name="project_name" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">프로젝트 기간</label>
                        <div class="col-md-6">
                            <div class="input-daterange input-group" data-plugin-datepicker="" >
                                <span class="input-group-addon" style="border-left:1px solid #ccc">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control" name="start">
                                <span class="input-group-addon">~</span>
                                <input type="text" class="form-control" name="end">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">현장 위치</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="현장 위치 입력" name="location">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">기후 데이터(방재) </label>
                        <div class="col-md-6">
                            <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select a State", "allowClear": true }' name="weather1">
                                <?php  
                                            $stmt = $con->prepare('SELECT loc FROM local group by loc');
                                            $stmt->execute();
                                            if ($stmt->rowCount() > 0){
                                                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                                    extract($row);
                                                    ?>
                                <optgroup label="<?php echo $loc; ?>">
                                    <?
                                                        $stmt1 = $con->prepare('SELECT * FROM local where loc="'.$loc.'"');
                                                        $stmt1->execute();
                                                        if ($stmt1->rowCount() > 0){
                                                            while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
                                                                extract($row1);                               
                                                                ?>
                                    <option value="<?php echo $code; ?>">
                                        <?php echo $name; ?>(<?php echo $code; ?>)</option>
                                    <? } } ?>
                                </optgroup>
                                <? } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">신적설 데이터(종관)</label>
                        <div class="col-md-6">
                            <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select a State", "allowClear": true }' name="weather2">
                                <? foreach ($warther2_loc as $key => $value) { ?>
                                <option value="<? echo $key ?>">
                                    <? echo $value ?>(<?php echo $key; ?>)
                                </option>
                                <? } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">미세먼지 데이터(에어코리아) </label>
                        <div class="col-md-6">
                            <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select a State", "allowClear": true }' name="finedust">
                                <?php  
                                            $stmt = $con->prepare('SELECT loc1 FROM finedust group by loc1');
                                            $stmt->execute();
                                            if ($stmt->rowCount() > 0){
                                                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                                    extract($row);
                                                    ?>
                                <optgroup label="<?php echo $loc1; ?>">
                                    <?
                                                        $stmt1 = $con->prepare('SELECT * FROM finedust where loc1="'.$loc1.'"  group by loc2');
                                                        $stmt1->execute();
                                                        if ($stmt1->rowCount() > 0){
                                                            while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
                                                                extract($row1);                               
                                                                ?>
                                    <option value="<?php echo $loc1."-".$loc2; ?>">
                                        <?php echo $loc2; ?></option>
                                    <? } } ?>
                                </optgroup>
                                <? } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">분석기간(년)</label>
                        <div class="col-md-6">
                            <div data-plugin-spinner="" data-plugin-options='{"value":5, "step":5, "min":5, "max":20 }'>
                                <div class="input-group" style="width:150px;">
                                    <input type="text" class="spinner-input form-control" maxlength="2" readonly="" name="period">
                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn btn-default spinner-up">
                                            <i class="fa fa-angle-up"></i>
                                        </button>
                                        <button type="button" class="btn btn-default spinner-down">
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">기타 설정</label>
                        <div class="col-md-6">
                            <div class="checkbox-custom checkbox-primary">
                                <input type="checkbox" id="checkboxExample2" name="etc1">
                                <label for="checkboxExample2">일 최고기온 불능일 50% 적용</label>
                            </div>
                            <!-- <div class="checkbox-custom checkbox-success">
                                <input type="checkbox" id="checkboxExample3" name="etc2">
                                <label for="checkboxExample3">국토부 훈령 법정 공휴일수 적용 </label>
                            </div> -->
                            <div class="checkbox-custom checkbox-warning">
                                <input type="checkbox" id="checkboxExample4" name="etc3">
                                <label for="checkboxExample4">주 40시간 적용</label>
                            </div>
                        </div>
                    </div>
                
        </section>
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="submit" name="submit" class="btn btn-primary modal-confirm">확인</button>
                <button class="btn btn-default modal-dismiss">취소</button>
            </div>
        </div>
        </form>
    </div>
</section>
<!-- Vendor -->
<script src="assets/vendor/jquery/jquery.js"></script>
<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
<!-- Specific Page Vendor -->
<script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
<script src="assets/vendor/select2/select2.js"></script>
<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
<script src="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="assets/vendor/fuelux/js/spinner.js"></script>
<script src="assets/vendor/dropzone/dropzone.js"></script>
<script src="assets/vendor/bootstrap-markdown/js/markdown.js"></script>
<script src="assets/vendor/bootstrap-markdown/js/to-markdown.js"></script>
<script src="assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script src="assets/vendor/codemirror/lib/codemirror.js"></script>
<script src="assets/vendor/codemirror/addon/selection/active-line.js"></script>
<script src="assets/vendor/codemirror/addon/edit/matchbrackets.js"></script>
<script src="assets/vendor/codemirror/mode/javascript/javascript.js"></script>
<script src="assets/vendor/codemirror/mode/xml/xml.js"></script>
<script src="assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="assets/vendor/codemirror/mode/css/css.js"></script>
<script src="assets/vendor/summernote/summernote.js"></script>
<script src="assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
<script src="assets/vendor/ios7-switch/ios7-switch.js"></script>
<!-- Theme Base, Components and Settings -->
<script src="assets/javascripts/theme.js"></script>
<!-- Theme Custom -->
<script src="assets/javascripts/theme.custom.js"></script>
<!-- Theme Initialization Files -->
<script src="assets/javascripts/theme.init.js"></script>
<!-- Examples -->
<script src="assets/javascripts/forms/examples.advanced.form.js" />
</script>
</body>

</html>