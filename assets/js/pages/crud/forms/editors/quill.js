// Class definition
var KTQuilD = function() {

    // Private functions
    var quil1 = function() {
        var quill = new Quill('#kt_quil_1', {
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            },
            placeholder: '작업 세부사항을 입력하세요..',
            theme: 'snow' // or 'bubble'
        });
    }

  

    return {
        // public functions
        init: function() {
            quil1();            
        }
    };
}();

jQuery(document).ready(function() {
    KTQuilD.init();    
    
});
