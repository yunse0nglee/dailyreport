// Class definition
var KTFormControls = function (maxinput) {
	// Private functions
	
	var _initvali = function (maxinput) {		
		FormValidation.formValidation(
			document.getElementById('kt_form_1'),
			{
				fields: {			
					digits: {
						validators: {
							
							notEmpty: {
								message: '입력값이 없습니다.'
							},
							numeric: {
								message: '숫자만 입력해주세요',
								thousandsSeparator: '',
                                decimalSeparator: '.',
							},							
							between: {
								min: 0,
								max: maxinput,
								message: '최대값 ' + maxinput + '을 초과할 수 없습니다.',
							},
                            
                            
						}
					},

				},

				plugins: { //Learn more: https://formvalidation.io/guide/plugins
					
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
            		defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
			
				}
			}
		);
	}
	

	return {
		// public functions
		init: function(maxinput) {
			_initvali(maxinput);			
		}
	};
}();


//jQuery(document).ready(function() {

	
//});
