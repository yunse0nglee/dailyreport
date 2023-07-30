// Class definition
var KTFormControls = function () {
	// Private functions
	var _initvali = function () {
		FormValidation.formValidation(
			document.getElementById('kt_form_1'),
			{
				fields: {			
					digits: {
						validators: {
							between: {
								min: -90,
								max: 90,
								message: 'The latitude must be between -90.0 and 90.0',
							},
							notEmpty: {
								message: 'Digits is required'
							},
							digits: {
								message: 'The velue is not a valid digits'
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
		init: function() {
			_initvali();
		}
	};
}();

jQuery(document).ready(function() {
	KTFormControls.init();
});
