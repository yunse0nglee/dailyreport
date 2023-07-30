'use strict';
// Class definition
var KTDatatableChildDataLocalDemo = function() {
	// Private functions
	
	var subTableInit = function(e) {
		var datatable2 = $('<div/>').attr('id', 'child_data_local_' + e.data.activity_id).appendTo(e.detailCell).KTDatatable({
			data: {
				type: 'local',
				source: e.data.sts,
				pageSize: 5,
			},

			// layout definition
			layout: {
				scroll: true,
				height: 400,
				footer: false,
			},

			sortable: true,

			// columns definition
			columns: [
				{
					field: 'st_id',
					title: 'ID',					
					textAlign: 'center'
				}, {
					field: 'item',
					title: '품명',						
					width: 200,	
				}, {
					field: 'st_standard',
					title: '규격',										
					width: 200,	
				}, {
					field: 'unit',
					title: '단위',		
					width: 50,		
					textAlign: 'center'
				},  {
					field: 'vol',
					title: '수량',		
					width: 50,		
					textAlign: 'center'
				}, {
					field: 'total_unit',
					title: '단가',
					type: 'number',
					template: function(row) {
						return '<span>' + number_format(row.total_unit) + '</span>';
					},	
					width:70,
					textAlign: 'right'
				}, {
					field: 'total_cost',
					title: '금액',
					type: 'number',
					template: function(row) {
						return '<span>' + number_format(row.total_cost) + ' 원</span>';
					},			
					width: 90,		
					textAlign: 'right'
				},{
					field: 'rate',
					title: '진행률',
					autoHide: false,
					width: 150,
					textAlign: 'right',
					// callback function support for column rendering
					template: function(row) {						

						//var RandomNum2 = Math.ceil(Math.random()*(98-40)+40);		
						//var randomNum = Math.ceil(Math.random()*4);				
						var status2 = {
							1: {'title': '진행', 'class': 'primary'},
							2: {'title': '완료', 'class': 'danger'},
							3: {'title': '준비', 'class': ''},
						};
						
						var vol2 = row.vol2;
						
						if(vol2==null){
							vol2 =  0;
						}else{
							vol2 = Number(vol2);
						}

						vol2 = vol2.toFixed(0);
						var done_cost = (row.vol2*row.total_unit);
						var numObj = ((done_cost/row.total_cost)*100);
						
						var stat = 3;						
						if(numObj===0){
							stat = 3;
						}else if(numObj===100){
							stat = 2;							
						}else{
							stat = 1;							
						}

						
						

						return `<div class="d-flex flex-column w-100 mr-2" >
																				<div class="d-flex align-items-center justify-content-between mb-2" >																					
																				 	<span class="text-muted mr-2 font-size-sm font-weight-bold">  </span>
																					<span class="jin2 text-muted font-size-sm font-weight-bold">`+ vol2 + " / " + row.vol + "(" + numObj.toFixed(1) +`%)</span>
																				</div>
																				<div class="progress progress-xs w-100" >
																					<div class="progress-bar bg-`+status2[stat].class+`" role="progressbar" style="width: `+  numObj.toFixed(1) +`%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" ></div>
																				</div>
																			</div>`;
						
					},
				},{
					field: 'Action',
					width: 42,
					title: '',
					sortable: false,					
					autoHide: false,
					template: function(row, index) {
						return `\							                        
							<button data-record-id="` + row.st_id + `" data-item="` + row.item + `" data-wbs="` + row.cons_name + `" data-vol="` + row.vol + `" data-unit="` + row.total_unit + `" data-total_cost="` + row.total_cost + `" data-index="` + index + `" maxinput="1" class="btn btn-sm btn-clean" title="View records">\
	                            <span class="svg-icon svg-icon-md">\
	                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
	                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
	                                        <rect x="0" y="0" width="24" height="24"/>\
	                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero"\ transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
	                                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
	                                    </g>\
	                                </svg>\
	                            </span>\
	                        </button>\	  
	                    `;
					},
				}],
		});
		
		datatable2.on('click', '[data-record-id]', function() {            
			
            //$('#kt_datatable_modal .modal-title').text($(this).data('record-id'));
			var wbs = $(this).data('wbs');
			var item = $(this).data('item');
			var vol = $(this).data('vol');
			var st_id = $(this).data('record-id');
			var total_cost = $(this).data('total_cost');
			var unit = $(this).data('unit');
			var index = $(this).data('index');
			
			//alert(datatable2.columns('item').dataSet[index].total_unit);

		
			
			var $this = $(this);
			var activity_id = $(this).closest("div").attr('id');
			activity_id = activity_id.replace("child_data_local_", "");

			
			
			$('#kt_datatable_modal .modal-title').text(wbs + " - " + item);			
			$('#kt_form_1')[0].reset();
			$('#kt_datatable_modal input[name=digits]').removeClass('is-invalid');
			$('#kt_datatable_modal input[name=digits]').removeClass('is-valid');			
			$('.fv-plugins-message-container').remove();

			$("input[name=Checkboxes1_1]").prop("checked", false);
			$("#kt_quil_1 .ql-editor").html("");
				  
			$("#tbl_detail tbody").html("");
			$.ajax({                
                url: 'ajax_activity_list_detail.php',
				type : "POST",            
                data : {
					'st_id':st_id, 
					'vol':vol, 
					'item':item
				},          
                success : function(data){ // 비동기통신의 성공일경우 success콜백으로 들어옵니다. 'res'는 응답받은 데이터이다.
                    // 응답코드 > 0000
					var d = data.split("###");
                    
					if(d[0]==""){
						$("#tbl_detail tbody").append("<td colspan=4 align=center>작업 기록이 없습니다.</td>");						
					}else{						
						$("#tbl_detail tbody").append(d[0]);												
					}

					KTFormControls.init(d[1]);		
					$("#m_vol").text(d[1]);

					if(d[2]=="true"){
						$("input[name=Checkboxes1_1]").prop("checked", true);						
					}
					
					$("#kt_quil_1 .ql-editor").html(d[3]);
					
					
                },
                error : function(XMLHttpRequest, textStatus, errorThrown){ // 비동기 통신이 실패할경우 error 콜백으로 들어옵니다.
                    alert("통신 실패.")
                }
            });
			
			
			$(".btnSubmit").on('click', function(ev){

				var inputVal = $("input[name=digits]").val();
				var t_flag = $("input[name=Checkboxes1_1]").is(":checked");
				var txt = $("#kt_quil_1 .ql-editor").html();
				
				// console.log(t_flag);

				
				
				if($("input[name=digits]").hasClass("is-valid")===true && $("input[name=digits]").val()>0){
					
						
					$.ajax({                
						url: 'ajax_activity_list_detail_write.php',
						type : "POST",            
						data : {
							'st_id':st_id, 
							'vol':inputVal,							
							't_flag':t_flag,							
							'txt':txt,							
							'activity_id':activity_id
						},          
						success : function(v){ // 비동기통신의 성공일경우 success콜백으로 들어옵니다. 'res'는 응답받은 데이터이다.									
							
							$("#kt_datatable_modal").modal("hide");
							$(".btnSubmit").unbind('click');																							
							
							var vv = v.split('@');
							var c_done_cost = vv[0] * unit;
							var c_orig_cost = vol * unit;
							var change_rate = ((c_done_cost/c_orig_cost)*100).toFixed(1);
							var status = {
								1: {'title': '진행', 'class': 'primary'},
								2: {'title': '완료', 'class': 'danger'},
								3: {'title': '준비', 'class': ''},	
							};
							
							
							
							// 자식노드 숫자 수정
							var tr = $this.parents('tr[data-row=' + index + ']');							
							tr.find('td[data-field=rate]').find('.progress-bar').css({width: change_rate + "%"});
							tr.find('td[data-field=rate]').find('.jin2').html(vv[0] + " / " + vol + "(" + change_rate+"%)");
							
							
							//alert(cost);
							//부모노드 숫자
							var tr_p = $this.parents('tr[data-row=' + index + ']').closest('table').closest('tr').prev();
							// var c_cost = 0;

							// $this.parents('tr[data-row=' + index + ']').closest('table').find('tr').each(function (i, item) {
							// 	if(i>0){
							// 		var cc_cost = $(item).find('td[data-field=total_cost] span span').text();
							// 		cc_cost = Number(cc_cost.replace(/[^0-9]/g,''));									
							// 		c_cost += cc_cost;
							// 	}
								
						    // });	

							// console.log(c_cost);
							 
							

							var p_done_cost = vv[1];
							var p_orig_cost = tr_p.find('td[data-field=cost]').attr("aria-label");
							var p_change_rate = ((p_done_cost/p_orig_cost)*100).toFixed(1)
							
							tr_p.find('td[data-field=done_vol] span').html(number_format(vv[1]) + '원');
							tr_p.find('td[data-field=rate]').find('.progress-bar').css({width: p_change_rate + "%"});
							tr_p.find('td[data-field=rate]').find('.jin1').html(p_change_rate + "%");							
							

							if(p_change_rate < 99){
								tr_p.find('td[data-field=rate]').find('.progress-bar').removeClass( "bg-primary" ).addClass( "bg-info" );								
							}else if(p_change_rate==100){
								tr_p.find('td[data-field=rate]').find('.progress-bar').removeClass( "bg-info" ).addClass( "bg-danger" );
							}else{
								tr_p.find('td[data-field=rate]').find('.progress-bar').removeClass( "bg-primary" );
								tr_p.find('td[data-field=rate]').find('.progress-bar').removeClass( "bg-danger" );
							}
							
							
							$(".btnSubmit:").unbind("click"); // click 이벤트만 해제 
							ev.preventDefault();


						},
						error : function(XMLHttpRequest, textStatus, errorThrown){ // 비동기 통신이 실패할경우 error 콜백으로 들어옵니다.
							alert("통신 실패")
						}
					});
					

				}else{
					return 0;
				}	

			});
			
			$('#kt_datatable_modal').on('shown.bs.modal', function () {
				$("input[name=digits]").focus();
			})  

			$(document).keypress(function(e){						
				if (e.which == 13){
					$('.btnSubmit').trigger('click');		
					e.preventDefault();			
					//alert('a');
				}						
			});
			
	

			$('#kt_datatable_modal').modal('show');		
			
        });
	};




	// demo initializer
	
	var mainTableInit = function(op) {
		
		var datatable = $('#kt_datatable').KTDatatable({
			// datasource definition
			
			data: {
                type: 'remote',
                source: 'ajax_activity_list.php',
                pageSize: 10,
            },

			// layout definition
			layout: {
				scroll: false,
				height: null,
				footer: false,
			},

			sortable: true,
			filterable: false,
			pagination: true,
			
			detail: {
				title: 'Load sub table',
				content: subTableInit,
			},

			search: {
				input: $('#kt_datatable_search_query'),
				key: 'generalSearch'
			},

			// columns definition
			columns: [
				{
					field: 'activity_id',
					title: '',
					sortable: false,
					width: 30,
					textAlign: 'center',
				}, {
					field: 'activity_name',
					title: '액티비티',
				}, {
					field: 'cons_name',
					title: '내역 WBS',
				}, {
					field: 'cost',
					title: '금액',		
					type: 'number',													
					template: function(row) {
						return '<span>' + number_format(row.cost) + ' 원</span>';
					},	
					textAlign: 'right'
				}, {
					field: 'done_vol',
					title: '완료',		
					type: 'number',													
					template: function(row) {
						return '<span>' + number_format(row.done_vol) + ' 원</span>';
					},	
					textAlign: 'right'
				},  {
					field: 'Status',
					title: '상태',
					// callback function support for column rendering
					template: function(row) {
						var status = {
							1: {'title': '진행', 'class': 'label-light-primary'},
							2: {'title': '완료', 'class': ' label-light-danger'},
							3: {'title': '준비', 'class': ' label-light-'},						
						};
						
						var numObj = ((row.done_vol/row.cost)*100);
						var stat = 3;						
						if(numObj===0){
							stat = 3;
						}else if(numObj===100){
							stat = 2;							
						}else{
							stat = 1;							
						}						
						return '<span class="label ' + status[stat].class + ' label-inline label-bold" style="font-size:1rem">' +  status[stat].title + '</span>';
					},
					textAlign: 'center'
				},{
					field: 'rate',
					title: '진행률',
					autoHide: false,
					width: 150,
					// callback function support for column rendering
					template: function(row) {						

						//var RandomNum2 = Math.ceil(Math.random()*(98-40)+40);		
						//var randomNum = Math.ceil(Math.random()*4);				
						var status2 = {
							1: {'title': '진행', 'class': 'info'},
							2: {'title': '완료', 'class': 'danger'},
							3: {'title': '준비', 'class': ''},
						};
						
						var numObj = ((row.done_vol/row.cost)*100);
						var stat = 3;						
						if(numObj===0){
							stat = 3;
						}else if(numObj===100){
							stat = 2;							
						}else{
							stat = 1;							
						}

						return `<div class="d-flex flex-column w-100 mr-2" >
																				<div class="d-flex align-items-center justify-content-between mb-2" >
																					<span class="text-muted mr-2 font-size-sm font-weight-bold"> 진행률 </span>
																					<span class="jin1 text-muted font-size-sm font-weight-bold">`+ numObj.toFixed(1) +`%</span>
																				</div>
																				<div class="progress progress-xs w-100" >
																					<div class="progress-bar bg-`+status2[stat].class+`" role="progressbar" style="width: `+  numObj.toFixed(1) +`%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" ></div>
																				</div>
																			</div>`;
						
					},
				}],
		});

		$('#kt_datatable_search_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Status');
		});

		$('#kt_datatable_search_type').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();

		

	};

	

	
	return {
		// Public functions
		init: function(op) {
			// init dmeo
			mainTableInit(op);
		},
	};
}();

jQuery(document).ready(function(e) {
	KTDatatableChildDataLocalDemo.init();		

});




function number_format(num){ return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g,','); }

