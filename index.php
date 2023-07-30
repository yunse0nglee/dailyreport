<?php include_once('./head.php') ?>

<?php
	$date = empty($_POST['ddate'])?date("Y-m-d"):$_POST['ddate'];
	
	// 전일 작업
	$arr_yesterday_work = [];
	$stmt = $con->prepare('SELECT a.*, b.cons_name, b.item from statement_detail AS a JOIN statement AS b ON a.st_id=b.st_id AND DATE_FORMAT(datetime, "%Y-%m-%d")=adddate("'.$date.'", -1) ORDER BY b.cons_name');
	//$stmt->bindParam(':activity_id', $activity_id);
	$stmt->execute();
	while($row = $stmt->fetch()){	
		$arr_yesterday_work[] = $row;
	};  


	// 금일 작업
	$arr_today_work = [];
	$stmt = $con->prepare('SELECT a.*, b.cons_name, b.item from statement_detail AS a JOIN statement AS b ON a.st_id=b.st_id AND DATE_FORMAT(datetime, "%Y-%m-%d")="'.$date.'" ORDER BY b.cons_name');
	//$stmt->bindParam(':activity_id', $activity_id);
	$stmt->execute();
	while($row = $stmt->fetch()){			
		$arr_today_work[] = $row;
	};  


	// 명일 작업
	$arr_tomm = [];
	$stmt = $con->prepare('SELECT a.*, b.cons_name, b.item from statement_detail AS a JOIN statement AS b 
						   ON a.st_id=b.st_id AND DATE_FORMAT(datetime, "%Y-%m-%d")="'.$date.'" and a.t_flag="true" ORDER BY b.cons_name');
	//$stmt->bindParam(':activity_id', $activity_id);
	$stmt->execute();
	while($row = $stmt->fetch()){	
		$arr_tomm[] = $row;
	};  


	//총 공사비	
	$stmt = $con->prepare('SELECT SUM(total_cost) AS total_cost FROM statement');	
	$stmt->execute();
	$row = $stmt->fetch();
	$total_cost = $row['total_cost'];

	//완료 공사비
	$done_cost_arr = [];
	$stmt = $con->prepare('SELECT a.st_id, b.total_unit, sum(a.vol) AS vol, (b.total_unit*sum(a.vol)) AS total from statement_detail AS a JOIN statement AS b ON a.st_id =b.st_id and DATE_FORMAT(datetime, "%Y-%m-%d")<="'.$date.'" GROUP BY a.st_id ');		
	$stmt->execute();
	$row = $stmt->fetch();
	$done_cost = 0;	
	
	while($row = $stmt->fetch()){	
		$done_cost_arr[] = $row;
		$done_cost += $row['total'];
	};  
	
	$done_rate = ($done_cost/$total_cost)*100;

	//기상청 데이터
	$url = "https://www.weather.go.kr/w/wnuri-fct2021/main/current-weather.do?code=4777000000";

	//$url = "https://www.naver.com" . "?" , http_build_query($data, '', );

	$ch = curl_init();                                 //curl 초기화
	curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
	 
	$response = curl_exec($ch);
	curl_close($ch);
	

?>

	<!-- 날짜 hidden 폼 -->
	<form name="dateform" id="dateform" method="post"> <input type="hidden" name="ddate" id="ddate" value=""/> </form>
	

	


	<!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		
						<!--begin::Subheader-->
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
									<!--end::Page Title-->
									<!--begin::Actions-->
									<div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
									<span class="font-weight-bold mr-4" >판교 제2 테크노밸리 G3-1 획지 신축설계 (G3-1 BL)</span>
									<!-- <a href="#" class="btn btn-light-warning font-weight-bolder btn-sm">Add New</a> -->
									<!--end::Actions-->
								</div>
								<!--end::Info-->
								<!--begin::Toolbar-->
								<div class="d-flex align-items-center">
									<!--begin::Actions-->
									<!-- <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">오늘</a>
									<a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">어제</a>									
                                    -->
									<!--end::Actions-->
									<!--begin::Daterange-->
									<a href="#" class="btn btn-sm btn-light font-weight-bold mr-2" id="kt_dashboard_daterangepicker" data-placement="left">
										<span class="text-muted font-size-base font-weight-bold mr-2" id="kt_dashboard_daterangepicker_title">기준날짜</span>
										<span class="text-primary font-size-base font-weight-bolder" id="standard_date"><?php echo date("Y년 n월 j일", strtotime($date)); ?></span>
									</a>
								                                   
									
								</div>

                               
								<!--end::Toolbar
								<!--end::Toolbar-->
							</div>
						</div>
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Dashboard-->
								
								<!--begin::Row-->
								<div class="row">
									
									<div class="col-xl-8">
										
									<div class="row">
											<div class="col-xl-6">
												<!--begin::Tiles Widget 9-->
												<div class="card card-custom gutter-b">
													<div class="cmp-cur-weather cmp-cur-weather-lifestyle">
														<h3 class="hid">일출/일몰</h3>
														<ul class="wrap-3">
															<li><span class="sym-ic sunrise with-txt">일출</span> <span>00:00</span></li>
															<li><span class="sym-ic sunset with-txt">일몰</span> <span>00:00</span></li>
															<li><div class="cmp-cmn-para odam-updated"><span class="updated-at"><span>00.00.(월) 00:00</span> 갱신</span></div></li>
														</ul>
													</div>

												<div id="current-weather">													
													<div class="cmp-cur-weather wbg wbg-type2 BGDB00">														
														<ul class="wrap-1">
															<li class="w-icon w-temp no-w">
																<!-- <span class="hid">날씨: </span><span class="wic DB00 large"></span> -->
																<span class="hid">기온: </span><span class="tmp">00.0<small>℃</small> <span class="minmax"><span>최저</span><span>-</span><span>최고</span><span>20℃</span></span></span>
																<span class="chill">체감(17.7℃)</span>
															</li>
															
															<!-- <li class="w-txt">어제보다 <strong>5℃</strong> 높아요</li>															 -->
														</ul>
														<ul class="wrap-2 no-underline">
															<li><span class="lbl ic-hm">습도<small>&nbsp;</small></span><span class="val">81 <small class="unit">%</small></span></li>
															<li><span class="lbl ic-wind">바람<small>&nbsp;</small></span><span class="val">남서 3.7 <small class="unit">m/s</small></span></li>															
															<li><span class="lbl rn-hr1 ic-rn">1시간강수량</span><span class="val">- <small class="unit">mm</small></span></li>
														</ul>
														
													</div>		
													
																				
												
												</div>
												</div>
												<!--end::Tiles Widget 9-->
											</div>
											<div class="col-xl-6">
												<!--begin::Mixed Widget 10-->
												<div class="card card-custom gutter-b">
													<!--begin::Body-->
													<div id="current-weather2">				
														<div class="card-body" style="padding:10px;">		
														<div class="cmp-impact-fct"><p>기상특보</p></div>														
																<div class="cmp-cur-weather cmp-cur-weather-air">
																<h3 class="hid">대기질정보</h3>
																<ul class="wrap-2 air-wrap no-underline">
																	<li>
																		<span class="lbl">초미세먼지<small>(PM2.5)</small></span>
																		<strong class="air-level val"><span class="air-lvv-wrap air-lvv-2"><span class="air-lvv">-</span><small class="unit">㎍/m³</small></span><span class="air-lvt" style="color:#000;">자료없음</strong>
																		
																	</li>
																	<li>
																		<span class="lbl">미세먼지<small>(PM10)</small></span>
																		<strong class="air-level val"><span class="air-lvv-wrap air-lvv-0"><span class="air-lvv">-</span><small class="unit">㎍/m³</small></span><span class="air-lvt" style="color:#000;">자료없음</strong>
																		
																	</li>
																	<li>
																		<span class="lbl">오존<small>(O<small>3</small>)</small></span>
																		<strong class="air-level val"><span class="air-lvv-wrap air-lvv-1"><span class="air-lvv">-</span><small class="unit">ppm</small></span><span class="air-lvt" style="color:#000;">자료없음</strong>
																		
																	</li>
																</ul>
																
															</div>													
														</div>
													</div>
													<!--end::Body-->
												</div>
												<!--end::Mixed Widget 10-->
											</div>
										</div>
										<div class="row">
											
											<div class="col-xl-6">
												<!--begin::Mixed Widget 14-->
												<div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b card-stretch" style="background: url(assets/media/stock-600x400/bim-modelling.png) #fff;background-size:100%;background-position:20% 80%; background-repeat: no-repeat;">
													<!--begin::Body-->
													<div class="card-body d-flex flex-column align-items-start justify-content-start">
														<div class="p-1 flex-grow-1">
															<h3 class="font-weight-bolder line-height-lg mb-5">현장 BIM
															<br />3D 모델링</h3>
														</div>
														
													</div>
													<!--end::Body-->
												</div>
												<!--end::Mixed Widget 14-->
											</div>

											<div class="col-xl-6">
												<div class="row">
													<div class="col-xl-6">
														<!--begin::Tiles Widget 11-->
														<div class="card card-custom gutter-b" >
															
														
															<!--begin::Body-->
															<div class="card-body my-2">
																<a href="#" class="card-title font-weight-bolder text-info font-size-h6 mb-4 text-hover-state-dark d-block">계획 공정률</a>
																<div class="font-weight-bold text-muted font-size-sm">
																<span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">67%</span>Avarage</div>
																<div class="progress progress-xs mt-7 bg-info-o-60">
																	<div class="progress-bar bg-info" role="progressbar" style="width: 67%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																</div>
															</div>
															<!--end::Body-->
														</div>															
														
														<!--end::Tiles Widget 11-->
													</div>
													<div class="col-xl-6">
														<!--begin::Tiles Widget 12-->
														<div class="card card-custom gutter-b" style="background: url(assets/media/bg/bg-9.jpg);background-size:cover">
															<div class="card-body my-2">
																<a href="#" class="card-title font-weight-bolder text-danger font-size-h6 mb-4 text-hover-state-dark d-block">실적 공정률</a>
																<div class="font-weight-bold text-muted font-size-sm">
																<span class="text-dark-75 font-weight-bolder font-size-h2 mr-2"><?php echo number_format($done_rate,1)?>%</span>Avarage</div>
																<div class="progress progress-xs mt-7 bg-danger-o-60">
																	<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo number_format($done_rate,1) ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																</div>
															</div>
															
														</div>
														<!--end::Tiles Widget 12-->
													</div>
												</div>
												<!--begin::Tiles Widget 13-->
												<div class="card card-custom wave wave-animate-slow wave-primary  gutter-b" style="height: 200px; ">
													<!--begin::Body-->
													<div class="card-body d-flex flex-column">
														<div class="d-flex align-items-center justify-content-between flex-grow-1">
															<div class="mr-2">
																<h3 class="font-weight-bolder">달성율</h3>
																<div class="text-muted font-size-lg mt-2"><?php echo date("Y년 m월 d일") ?> 기준</div>
															</div>
															<div class="font-weight-boldest font-size-h1 text-success">￦<span class="done_cost"><?php echo number_format($done_cost) ?></span></div>
														</div>
														<div class="pt-8">
															<div class="d-flex align-items-center justify-content-between mb-3">
																<div class="text-muted font-weight-bold mr-2"><?php echo number_format($done_cost) ?> / <?php echo number_format($total_cost); ?></div>
																<div class="text-muted font-weight-bold"><?php echo number_format($done_rate,1)."%"; ?> </div>
															</div>
															<div class="progress bg-light-success progress-xs">
																<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo number_format($done_rate,1) ?>%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
															</div>
														</div>
													</div>
													<!--end::Body-->
												</div>
												<!--end::Tiles Widget 13-->
											</div>
										</div>
										
									</div>
									<div class="col-xl-4">
										<!--begin::Tiles Widget 8-->
										<div class="card card-custom card-stretch gutter-b">
											<!--begin::Header-->
											<div class="card-header border-0 pt-5">
												<h3 class="card-title align-items-start flex-column">
                                                <span class="card-label font-weight-bolder text-dark">협력업체별 공정률 현황</span>
													<span class="text-muted mt-3 font-weight-bold font-size-sm"><?php echo date("Y-m-d") ?> 현재</span>
												</h3>
												
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body pt-2 pb-0 mt-n3">
												<div class="tab-content mt-5" id="myTabTables1">
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_tab_pane_1_1" role="tabpanel" aria-labelledby="kt_tab_pane_1_1">
														<!--begin::Table-->
														<div class="table-responsive">
														
														</div>
														<!--end::Table-->
													</div>
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													<div class="tab-pane fade active show" id="kt_tab_pane_1_3" role="tabpanel" aria-labelledby="kt_tab_pane_1_3">
														<!--begin::Table-->
														<div class="table-responsive">
															<table class="table table-borderless table-vertical-center">
																<thead>
																	<tr>
																		
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-100px"></th>
																		
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		
																		<td class="pl-0">
																			<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">건축</a>
																			<span class="text-muted font-weight-bold d-block">Architecture</span>
																		</td>
																		<td>
																			<div class="d-flex flex-column w-100 mr-2">
																				<div class="d-flex align-items-center justify-content-between mb-2">
																					<span class="text-muted mr-2 font-size-sm font-weight-bold">65%</span>
																					<span class="text-muted font-size-sm font-weight-bold">Progress</span>
																				</div>
																				<div class="progress progress-xs w-100">
																					<div class="progress-bar bg-danger" role="progressbar" style="width: 65%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																				</div>
																			</div>
																		</td>
																		
																	</tr>
																	<tr>
																	
																		<td class="pl-0">
																			<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">토목</a>
																			<span class="text-muted font-weight-bold d-block">Civil engineering</span>
																		</td>
																		<td>
																			<div class="d-flex flex-column w-100 mr-2">
																				<div class="d-flex align-items-center justify-content-between mb-2">
																					<span class="text-muted mr-2 font-size-sm font-weight-bold">83%</span>
																					<span class="text-muted font-size-sm font-weight-bold">Progress</span>
																				</div>
																				<div class="progress progress-xs w-100">
																					<div class="progress-bar bg-success" role="progressbar" style="width: 83%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																				</div>
																			</div>
																		</td>
																		
																	</tr>
																	<tr>
																	
																		<td class="pl-0">
																			<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">기계</a>
																			<span class="text-muted font-weight-bold d-block">Mechanical works</span>
																		</td>
																		<td>
																			<div class="d-flex flex-column w-100 mr-2">
																				<div class="d-flex align-items-center justify-content-between mb-2">
																					<span class="text-muted mr-2 font-size-sm font-weight-bold">47%</span>
																					<span class="text-muted font-size-sm font-weight-bold">Progress</span>
																				</div>
																				<div class="progress progress-xs w-100">
																					<div class="progress-bar bg-primary" role="progressbar" style="width: 47%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																				</div>
																			</div>
																		</td>
																		
																	</tr>
																	<tr>
																		
																		<td class="py-6 pl-0">
																			<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">전기</a>
																			<span class="text-muted font-weight-bold d-block">Electric works</span>
																		</td>
																		<td>
																			<div class="d-flex flex-column w-100 mr-2">
																				<div class="d-flex align-items-center justify-content-between mb-2">
																					<span class="text-muted mr-2 font-size-sm font-weight-bold">71%</span>
																					<span class="text-muted font-size-sm font-weight-bold">Progress</span>
																				</div>
																				<div class="progress progress-xs w-100">
																					<div class="progress-bar bg-danger" role="progressbar" style="width: 71%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																				</div>
																			</div>
																		</td>
																		
																	</tr>
																	<tr>
																	
																		<td class="pl-0">
																			<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">통신</a>
																			<span class="text-muted font-weight-bold d-block">Telecommunication</span>
																		</td>
																		<td>
																			<div class="d-flex flex-column w-100 mr-2">
																				<div class="d-flex align-items-center justify-content-between mb-2">
																					<span class="text-muted mr-2 font-size-sm font-weight-bold">50%</span>
																					<span class="text-muted font-size-sm font-weight-bold">Progress</span>
																				</div>
																				<div class="progress progress-xs w-100">
																					<div class="progress-bar bg-info" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																				</div>
																			</div>
																		</td>
																		
																	</tr>
                                                                    
                                                                    <tr>
																	
																		<td class="pl-0">
																			<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">조경</a>
																			<span class="text-muted font-weight-bold d-block">Landscape architecture</span>
																		</td>
																		<td>
																			<div class="d-flex flex-column w-100 mr-2">
																				<div class="d-flex align-items-center justify-content-between mb-2">
																					<span class="text-muted mr-2 font-size-sm font-weight-bold">75%</span>
																					<span class="text-muted font-size-sm font-weight-bold">Progress</span>
																				</div>
																				<div class="progress progress-xs w-100">
																					<div class="progress-bar bg-warning " role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
																				</div>
																			</div>
																		</td>
																		
																	</tr>
                                                                    
																</tbody>
															</table>
														</div>
														<!--end::Table-->
													</div>
													<!--end::Tap pane-->
												</div>
											</div>
										</div>
										<!--end::Tiles Widget 8-->
									</div>
								</div>
								<!--end::Row-->
								
								<!--begin::Row-->			
                                <div class="row">
                                    <div class="col-lg-4 ">
                                        <!--begin::Card-->
                                        <div class="card card-custom card-stretch gutter-b">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h3 class="card-label"> 전일 작업사항(<?php echo date("n/j", strtotime("-1 days", strtotime($date))) ; ?>)</h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
												<?
													if(!empty($arr_yesterday_work)) { 
													
														foreach($arr_yesterday_work as $k => $v){
															// echo "<div style='display:block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>";
															// echo "· <span style='font-weight:bold;color:#3699ff'>". $arr_yesterday_work[$k]['cons_name']." </span>  ".$arr_yesterday_work[$k]['item'].'<br>';
															// echo "</div>";
															echo "<div style='display:block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>";
															echo "· <span style='font-weight:bold;color:#3699ff'>". $arr_yesterday_work[$k]['cons_name']." </span> <div class='work_title' d_id='".$arr_yesterday_work[$k]['st_id']."' dd='".(date('Y-m-d', strtotime($arr_yesterday_work[$k]['datetime'])))."'> ".$arr_yesterday_work[$k]['item'].'</div>';
															echo "</div>";
														}
													}else{
														echo "작업 내역이 없습니다.";
													}
												?>
                                            </div>
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <div class="col-lg-4">
                                        <!--begin::Card-->
                                        <div class="card card-custom card-stretch gutter-b">
                                            <div class="card-header">
                                                <div class="card-title">
                                                <h3 class="card-label"> 금일 작업사항(<?php echo date("n/j", strtotime($date)); ?>)</h3>
                                                </div>												
                                            </div>
                                            <div class="card-body ">
												<!--<div data-scroll="true" data-height="200">-->
													
												<?
													if(!empty($arr_today_work)) { 													
														foreach($arr_today_work as $k => $v){
															echo "<div style='display:block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>";
															echo "· <span style='font-weight:bold;color:#f64e60'>". $arr_today_work[$k]['cons_name']." </span> <div class='work_title' d_id='".$arr_today_work[$k]['st_id']."' dd='".(date('Y-m-d', strtotime($arr_today_work[$k]['datetime'])))."'> ".$arr_today_work[$k]['item'].'</div>';
															echo "</div>";
														}
													}else{
														echo "작업 내역이 없습니다.";
													}
												?>
												<!--</div>-->

                                            </div>
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <div class="col-lg-4">
                                        <!--begin::Card-->
                                        <div class="card card-custom card-stretch gutter-b">
                                            <div class="card-header">
                                                <div class="card-title">
                                                <h3 class="card-label"> 명일 작업사항(<?php echo date("n/j", strtotime("+1 days", strtotime($date))) ; ?>)</h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
												<?
													if(!empty($arr_tomm)) { 
													
														foreach($arr_tomm as $k => $v){
															echo "<div style='display:block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>";
															echo "· <span style='font-weight:bold;color:#8950fc'>". $arr_tomm[$k]['cons_name']." </span>  ".$arr_tomm[$k]['item'].'<br>';
															echo "</div>";
														}
													}else{
														echo "작업 내역이 없습니다.";
													}
												?>
                                            </div>
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                </div>
                               
                                <!--begin::Row-->
								<div class="row">
																
									<div class="col-xxl-8 order-2 order-xxl-1">
										<!--begin::Advance Table Widget 2-->
										<div class="card card-custom card-stretch gutter-b">
											<!--begin::Header-->
											<div class="card-header border-0 pt-5">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder text-dark">금일 작업 Activity</span>
													<span class="text-muted mt-3 font-weight-bold font-size-sm">금일 작업 완료된 주요 Activity </span>
												</h3>
											
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body pt-2 pb-0 mt-n3">
													<div class="table-responsive">
														<table class="table table-borderless table-vertical-center">
															<thead>
																<tr>
																	
																	<th class="p-0" style="min-width: 200px"></th>
																	<th class="p-0" style="min-width: 120px"></th>
																	<th class="p-0" style="min-width: 70px"></th>
																	<th class="p-0" style="min-width: 70px"></th>
																</tr>
															</thead>
															<tbody>
																<tr>																	
																	<td class="pl-0">
																		<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">1층 금속공사</a>
																		<span class="text-muted font-weight-bold d-block">금속공사</span>
																	</td>
																	<td class="pr-0">
																		<div class="d-flex align-items-center justify-content-end">
																			<span class="mr-1">
																				<span class="svg-icon svg-icon-md svg-icon-gray-600">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Close.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
																								<rect x="0" y="7" width="16" height="2" rx="1"></rect>
																								<rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
																							</g>
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</span>
																			<span class="text-success font-weight-bolder font-size-h5">5</span>
																		</div>
																	</td>
																	<td class="text-right">
																		<span class="text-muted font-weight-bold d-block">단가</span>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg">￦ 120,000</span>
																	</td>
																	<td class="text-right pr-0">
																		<span class="text-muted font-weight-bold d-block">금액</span>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg">￦ 600,000</span>
																	</td>
																</tr>
																<tr>																	
																	<td class="pl-0">
																		<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">1층 목재창호공사</a>
																		<span class="text-muted font-weight-bold d-block">	창호공사</span>
																	</td>
																	<td class="pr-0">
																		<div class="d-flex align-items-center justify-content-end">
																			<span class="mr-1">
																				<span class="svg-icon svg-icon-md svg-icon-gray-600">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Close.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
																								<rect x="0" y="7" width="16" height="2" rx="1"></rect>
																								<rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
																							</g>
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</span>
																			<span class="text-success font-weight-bolder font-size-h5">5</span>
																		</div>
																	</td>
																	<td class="text-right">
																		<span class="text-muted font-weight-bold d-block">단가</span>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg">￦ 800,000</span>
																	</td>
																	<td class="text-right pr-0">
																		<span class="text-muted font-weight-bold d-block">금액</span>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg">￦ 4,000,000</span>
																	</td>
																</tr>
																
															</tbody>
														</table>
													</div>																		
											</div>
											<!--end::Body-->
										</div>
										<!--end::Advance Table Widget 2-->
									</div>
									<div class="col-lg-6 col-xxl-4 order-1 order-xxl-2">
										<!--begin::List Widget 3-->
										<div class="card card-custom card-stretch gutter-b">
											<!--begin::Header-->
											<div class="card-header border-0">
												<h3 class="card-title font-weight-bolder text-dark">인력 투입현황</h3>
												<div class="card-toolbar">
													<div class="dropdown dropdown-inline">
														<a href="#" class="btn btn-light-primary btn-sm font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">August</a>
														<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
															<!--begin::Navigation-->
															<ul class="navi navi-hover">
																<li class="navi-header pb-1">
																	<span class="text-primary text-uppercase font-weight-bold font-size-sm">Add new:</span>
																</li>
																<li class="navi-item">
																	<a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-shopping-cart-1"></i>
																		</span>
																		<span class="navi-text">Order</span>
																	</a>
																</li>
																<li class="navi-item">
																	<a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-calendar-8"></i>
																		</span>
																		<span class="navi-text">Event</span>
																	</a>
																</li>
																<li class="navi-item">
																	<a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-graph-1"></i>
																		</span>
																		<span class="navi-text">Report</span>
																	</a>
																</li>
																<li class="navi-item">
																	<a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-rocket-1"></i>
																		</span>
																		<span class="navi-text">Post</span>
																	</a>
																</li>
																<li class="navi-item">
																	<a href="#" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-writing"></i>
																		</span>
																		<span class="navi-text">File</span>
																	</a>
																</li>
															</ul>
															<!--end::Navigation-->
														</div>
													</div>
												</div>
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body pt-2">
												<!--begin::Item-->
												<div class="d-flex align-items-center mb-10">
													<!--begin::Symbol-->
													<div class="symbol symbol-40 symbol-light-success mr-5">
														<span class="symbol-label">
															<img src="assets/media/svg/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="" />
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Text-->
													<div class="d-flex flex-column flex-grow-1 font-weight-bold">
														<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">태산엔지니어링</a>
														<span class="text-muted">공사관리자(1), 도장공(1), 방소공(2), 지계차 장비기사(1), 철공공(3) </span>
													</div>
													<!--end::Text-->
													
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div class="d-flex align-items-center mb-10">
													<!--begin::Symbol-->
													<div class="symbol symbol-40 symbol-light-success mr-5">
														<span class="symbol-label">
															<img src="assets/media/svg/avatars/011-boy-5.svg" class="h-75 align-self-end" alt="" />
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Text-->
													<div class="d-flex flex-column flex-grow-1 font-weight-bold">
														<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">한바다이엔지</a>
														<span class="text-muted">공사관리자(1), 철근공(4), 조적공(2), 유도원(4), 철공공(3), 열선공(8), 전기공(5) </span>
													</div>
													<!--end::Text-->
													
												</div>
												<!--end::Item-->

<!--begin::Item-->
												<div class="d-flex align-items-center mb-10">
													<!--begin::Symbol-->
													<div class="symbol symbol-40 symbol-light-success mr-5">
														<span class="symbol-label">
															<img src="assets/media/svg/avatars/016-boy-7.svg" class="h-75 align-self-end" alt="" />
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Text-->
													<div class="d-flex flex-column flex-grow-1 font-weight-bold">
														<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">주식회사 제호바</a>
														<span class="text-muted">공사관리자(1), 안전감시단공(2), 신호수(3), 용접공(6), 형틀공(3), 포장공(5), 컷팅공(1) </span>
													</div>
													<!--end::Text-->
													
												</div>
												<!--end::Item-->


												
											</div>

											
											<!--end::Body-->
										</div>
										<!--end::List Widget 3-->
									</div>
								</div>	
								<!--end::Row-->							
								
								<!--end::Dashboard-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					
					<!--end::Content-->

					<!-- Modal-->
					
					<!-- Modal-->
					<div class="modal fade" id="workmodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="ModalLabel">세부 작업내용</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true" class="ki ki-close"></i>
									</button>
								</div>
								<div class="modal-body">	
									
								</div>           
							</div>
						</div>
					</div>

<?php include_once('./tail.php') ?>

<script defer>
	
	$(document).ready(function(){
		var html = `<?php echo $response; ?>`;
		
		$("span.tmp").html($(html).find("span.tmp").html());
		$("span.chill").html($(html).find("span.chill").html());
		$("ul.wrap-2.no-underline > li:nth-child(1) > span.val").html($(html).find("ul.wrap-2.no-underline > li:nth-child(1) > span.val").html());
		$("ul.wrap-2.no-underline > li:nth-child(2) > span.val").html($(html).find("ul.wrap-2.no-underline > li:nth-child(2) > span.val").html());
		$("ul.wrap-2.no-underline > li:nth-child(3) > span.val").html($(html).find("ul.wrap-2.no-underline > li:nth-child(3) > span.val").html());
		$("div.cmp-cur-weather.cmp-cur-weather-lifestyle > ul > li:nth-child(3) > div > span > span").html($(html).find(".updated-at > span").html());
		
		$("span.updated-at > span").html($(html).find(".updated-at > span").html());
		
		$("ul.wrap-3 > li:nth-child(1) > span:nth-child(2)").html($(html).find("ul.wrap-3 > li:nth-child(1) > span:nth-child(2)").html());
		$("ul.wrap-3 > li:nth-child(2) > span:nth-child(2)").html($(html).find("ul.wrap-3 > li:nth-child(2) > span:nth-child(2)").html());
		
		
		
		//$(".air-lvv-wrap.air-lvv-2 > span.air-lvv").html($(html).find(".air-lvv-wrap.air-lvv-2 > span.air-lvv").html());
		//$(".air-lvv-wrap.air-lvv-0 > span.air-lvv").html($(html).find(".air-lvv-wrap.air-lvv-0 > span.air-lvv").html());
		//$(".air-lvv-wrap.air-lvv-1 > span.air-lvv").html($(html).find(".air-lvv-wrap.air-lvv-1 > span.air-lvv").html());
		
		
		$("div.cmp-cur-weather.cmp-cur-weather-air > ul").html($(html).find("ul.wrap-2.air-wrap").html());
		$("div.cmp-impact-fct").html($(html).find("p").parent().html());


		if($("div.cmp-cur-weather.cmp-cur-weather-air > ul a").attr("href")=="#legend"){
			$("div.cmp-cur-weather.cmp-cur-weather-air > ul a").remove();
		}


		

		//$(".air-lvt").html($(html).find(".air-lvt").html());
		//$(".air-lvv-2 > .air-lvv").html($(html).find(".air-lvv-2 > .air-lvv").html());
		
	});
	

	
	$('.work_title').click(function(){
		var st_id = $(this).attr('d_id');
		var dt = $(this).attr('dd');
		var title = $(this).html();
		
		$.ajax({                
                url: 'ajax_work_detail.php',
				type : "POST",            
                data : {
					'st_id':st_id, 					
					'dt':dt
				},          
                success : function(data){ // 비동기통신의 성공일경우 success콜백으로 들어옵니다. 'res'는 응답받은 데이터이다.
                    // 응답코드 > 0000
					$("#ModalLabel").html(title);
					
					if(data==""){
						$("#workmodal .modal-body").html("<p>세부 작업 내용이 없습니다.</p>");
					}else{
						$("#workmodal .modal-body").html(data);						
					}
					
					
					$("#workmodal").modal('show');
					
                },
                error : function(XMLHttpRequest, textStatus, errorThrown){ // 비동기 통신이 실패할경우 error 콜백으로 들어옵니다.
                    alert("통신 실패.")
                }
        });
	});

	var memberCountConTxt= "<?php echo $done_cost ?>";
  
	$({ val : 0 }).animate({ val : memberCountConTxt }, {
	duration: 1000,
	step: function() {
		var num = numberWithCommas(Math.floor(this.val));
		$(".done_cost").text(num);
	},
	complete: function() {
		var num = numberWithCommas(Math.floor(this.val));
		$(".done_cost").text(num);
	}
	});

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}




		
</script>