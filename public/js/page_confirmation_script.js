$(document).ready(function() {
    window.onbeforeunload = function(){
        return 'Are you sure you want to leave?';
    };
    $("#submit,#CustomerBtn").click(function(){
        window.onbeforeunload = null;
    });
    $('.left-sidebar, .topbar').click(function(e) {
        if(($(e.target).is('a') && $(e.target).attr('href') != 'javascript:void(0)' && $(e.target).attr('href') != 'javascript:;')
         || ($(e.target).parent().is('a') && $(e.target).parent('a').attr('href') != 'javascript:void(0)' && $(e.target).parent('a').attr('href') != 'javascript:;')) {
        // if ($(e.target).is('a') && $(e.target).attr('href') != 'javascript:void(0)' && $(e.target).attr('href') != 'javascript:;') {
            var redirect_ele = '';
            if($(e.target).parent().is('a')) {
                redirect_ele = $(e.target).parent('a').attr("href");
            } else {
                redirect_ele = $(e.target).attr("href");
            }
            if(redirect_ele != '') {
                // Prevent default behavior
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to continue without saving?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: 'Leave'
                }).then((isConfirm) => {
                    if (isConfirm.value == true) {
                        window.onbeforeunload = null;
                        window.location = redirect_ele;
                    }
                })
                return false;
            }
        }
    });
});
