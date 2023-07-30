<?php 
    include_once('./head.php');
    include('./user_function.php');
?>
<style>
    table.user{
        font-size:13px;
    }
</style>
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
    <div class="col-md-12">
        <div class="pull-right">
            <!-- <a type="button" class="modal-with-form mb-xs mt-xs mr-xs btn btn-primary" href="#modalForm"><i class="fa fa-plus"></i>&nbsp; 프로젝트 추가</a> -->
            <a type="button" class="mb-xs mt-xs mr-xs btn btn-primary" href="./project_write.php"><i class="fa fa-plus"></i>&nbsp; 프로젝트 추가</a>
            
            <button type="button" class="mb-xs mt-xs mr-xs btn btn btn-success modal-basic_copy" id="pj_copy" href="#modalCenterIcon_copy"><i class="fa fa-copy"></i>&nbsp; 선택 복사</button>
            <button type="button" class="mb-xs mt-xs mr-xs btn btn btn-danger" id="change_active"><i class="fa fa-check"></i>&nbsp; 적용</button>            
            
            <!-- <a class="modal-with-form btn btn-default" href="#modalForm">Open Form</a> -->
        </div>
    </div>
    <div class="col-md-12 col-lg-12 col-xl-12 ui-sortable" data-plugin-portlet="" id="portlet-1" style="min-height: 150px;">
        <section class="panel" id="panel-1" data-portlet-item="">
            <header class="panel-heading portlet-handler">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>
                <h2 class="panel-title" style="font-family: Noto Sans KR">프로젝트 리스트</h2>
            </header>
            <div class="panel-body">
                <table class="table table-no-more table-bordered table-striped mb-none user">
                    <thead>
                        <tr>
                            <th class="text-center">선택</th>
                            <th class="text-center">ID</th>
                            <th style="width:300px" class="text-center">프로젝트 명</th>
                            <th class="text-center hidden-xs">프로젝트 기간</th>
                            <th class="text-center hidden-xs">기상_방재DB</th>
                            <th class="text-center hidden-xs">기상_종관DB</th>
                            <th class="text-center hidden-xs">미세먼지</th>
                            <th class="text-center hidden-xs">분석기간</th>
                            <th class="text-center hidden-xs">생성자</th>
                            <th class="text-center hidden-xs">최고기온 50%</th>
                            <th class="text-center hidden-xs">주 40시간</th>                                                        
                            <th class="text-center hidden-xs">수정</th>
                            <th class="text-center hidden-xs">삭제</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $stmt = $con->prepare('select * from project_list order by code desc');                            
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                                while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                        ?>
                        <tr>
                            <td class="text-center"><input type="radio" name="op_active" value="<?php echo $code; ?>" <?php if($code==$active_pj) echo "checked" ; ?>></td>
                            <td class="text-center">
                                <?php echo $code; ?>
                            </td>
                            <td >
                                <?php echo $p_name; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $date_start; ?> ~
                                <?php echo $date_end; ?>
                            </td>
                            <td class="text-center">
                                <?php echo get_weather_loc($weather1); ?>
                            </td>
                            
                            <td class="text-center"><?php echo $warther2_loc[$weather2]; ?>(<?php echo $weather2 ?>)</td>
                            <td class="text-center"> <?php echo $finedust; ?></td>
                            <td class="text-center"> <?php echo $period; ?>년</td>
                            <td class="text-center"> <?php echo $owner; ?></td>
                            <td class="text-center">
                                <?php echo is_null($etc1)?"-":"<i class='fa fa-check-square-o'"; ?>
                            </td>
                            <td class="text-center">
                                <?php echo is_null($etc3)?"-":"<i class='fa fa-check-square-o'"; ?>
                            </td>                            
                            <td class="text-center">
                                <? if($owner==$name || $user_id=="admin"){ ?>
                                <a type="button" class="mr-xs btn btn-xs btn-warning" href="./project_update.php?id=<?php echo $code; ?>"><i class="fa fa-pencil"></i> Edit</a>
                                <? } ?>
                            </td>
                            <td class="text-center">
                                <? if($owner==$name || $user_id=="admin" ){ ?>
                                <a type="button" class="mr-xs btn modal-basic1 btn-xs btn-danger" href="#modalCenterIcon" data-var1="<?php echo $code; ?>"><i class="fa  fa-trash-o"></i> Delete</a>
                                <? } ?>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>

            </div>
        </section>
        <a class="mb-xs mt-xs mr-xs modal-basic btn btn-success hide" id="acc" href="#modalSuccess">Success</a>

        <div id="modalCenterIcon" class="modal-block modal-block-primary mfp-hide">
            <section class="panel">
                <div class="panel-body text-center">
                    <div class="modal-wrapper">
                        <div class="modal-icon center">
                            <i class="fa fa-question-circle"></i>
                        </div>
                        <div class="modal-text">
                            <h4>PROJECT DELETE</h4>
                            <p>프로젝트를 삭제 하시겠습니까?</p>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <input type="hidden" id="myVar" name="Var1" />
                            <button class="btn btn-primary modal-confirm_del">Confirm</button>
                            <button class="btn btn-default modal-dismiss">Cancel</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>

        <div id="modalCenterIcon_copy" class="modal-block modal-block-primary mfp-hide">
            <section class="panel">
                <div class="panel-body text-center">
                    <div class="modal-wrapper">
                        <div class="modal-icon center">
                            <i class="fa fa-question-circle"></i>
                        </div>
                        <div class="modal-text">
                            <h4>PROJECT COPY</h4>
                            <p>프로젝트를 복사 하시겠습니까?</p>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary modal-confirm_copy">Confirm</button>
                            <button class="btn btn-default modal-dismiss">Cancel</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>


        <div id="modalSuccess" class="modal-block modal-block-success mfp-hide">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Success!</h2>
                </header>
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="modal-text">
                            <h4>Success</h4>
                            <p>This is a successfull message.</p>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success modal-dismiss">OK</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>
    </div>
    </div>
    <!-- end: page -->
</section>
</div>
</div>
</aside>
<!-- Modal Success -->
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
<script src="assets/javascripts/ui-elements/examples.modals.js"></script>
<script>
$(function() {
    $("#change_active").click(function() {
        var op_active = $('input[name="op_active"]:checked').val();
        var name = "<?php echo $user_id;?>"

        $.ajax({
            url: "ajax_project_active.php",
            data: { op_active: op_active, name: name }, // HTTP 요청과 함께 서버로 보낼 데이터 
            method: "post", // HTTP 요청 메소드(GET, POST 등)                   
            success: function(data) {
                //alert(data);
                $(".modal-text p").text(data);
                $("#acc").trigger('click');
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        })
    })
})

$('.modal-basic1').click(function(){
    $('#myVar').val($(this).data('var1'));
});


$('.modal-basic1').magnificPopup({
    type: 'inline',
    preloader: false,
    modal: true
});

$(document).on('click', '.modal-confirm_del', function (e) {
    e.preventDefault();
    $.magnificPopup.close();

    
    var code = $('#myVar').val();
     $.ajax({
            url: "ajax_project_delete.php",
            data: { code: code }, // HTTP 요청과 함께 서버로 보낼 데이터 
            method: "post", // HTTP 요청 메소드(GET, POST 등)                   
            success: function(data) {
                alert(data);                                
                location.reload();
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        })

});


// $('.modal-basic_copy').click(function(){
//     $('#myVar_code').val($(this).data('var1'));
//     $('#myVar_name').val($(this).data('var2'));
// });


$('.modal-basic_copy').magnificPopup({
    type: 'inline',
    preloader: false,
    modal: true
});


$(document).on('click', '.modal-confirm_copy', function (e) {
    e.preventDefault();
    $.magnificPopup.close();

    
    var code = $('input[name="op_active"]:checked').val();
    var user = "<?php echo $name; ?>";
     $.ajax({
            url: "ajax_project_copy.php",
            data: { code: code, user: user }, // HTTP 요청과 함께 서버로 보낼 데이터 
            method: "post", // HTTP 요청 메소드(GET, POST 등)                   
            success: function(data) {
                alert(data);                                
                location.reload();
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        })

});





</script>
</body>

</html>