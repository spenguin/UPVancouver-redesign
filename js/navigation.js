(function($) {
    $(document).ready(function(){
        $('#btn').click(function(){
            if( $('.nav-sidebar').hasClass('active') ) {
                $('.nav-sidebar').removeClass('active');
            } else {
                $('.nav-sidebar').addClass('active');
            }
        })        
    });
}(jQuery));


// (function($){
//     $(document).ready(function() {
//         $("#br-button").click(function() {
//             alert("Hello World");
//         });
//     });
// }(jQuery));