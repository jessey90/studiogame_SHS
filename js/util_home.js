
function isiPhone(){
    return (
        (navigator.platform.indexOf("iPhone") != -1) ||
            (navigator.platform.indexOf("iPod") != -1)
        );
}

function focusMove(){

}

function focusInput(){
    if(isiPhone()) {
        var chrome = navigator.userAgent.match('CriOS');
        if(chrome){
            $("input").focus(function(){
                var pointScroll = $(this).offset().top - 15;
                var hDoc = $(document).height();
                var hW = $(window).height()/2 - 35;
                var hCheck =  hDoc - pointScroll;
                if(hCheck > hW) {
                    $('html,body').animate({
                        scrollTop: $(this).offset().top - 15
                    }, 'slow');
                }
            });
        }
    } else {
        $("input").focus(function(){
            $('html,body').animate({
                scrollTop: $(this).offset().top - 15
            }, 'slow');
        });
    }


    $('input[name="input-pass"]').focus(function() {
        if (this.value == this.defaultValue){
            this.value = '';
            $(this).parent().parent().prev().show();
            $(this).parent().parent().css('margin-right','30px');
            $(this).parent().parent().parent().addClass('vid-active-input');
        }
        if(this.value != this.defaultValue){
            this.select();
        }
        $(this).prop('type', 'password');
    }).blur(function() {
            if (jQuery.trim(this.value) == ''){
                this.value = (this.defaultValue ? this.defaultValue : '');
                $(this).val($(this).attr('title')).prop('type', 'text');
                $(this).parent().parent().prev().hide();
                $(this).parent().parent().css('margin-right','0');
                $(this).parent().parent().parent().removeClass('vid-active-input');
            }
            if (this.value == this.defaultValue){

            }
        });

    $('input[name="input-user"]').focus(function() {
        if (this.value == this.defaultValue){
            //this.value = '';
            $(this).parent().parent().prev().show();
            $(this).parent().parent().css('margin-right','30px');
            $(this).parent().parent().parent().addClass('vid-active-input');
        }
        if(this.value != this.defaultValue){
            this.select();
        }
    }).blur(function() {
            if (jQuery.trim(this.value) == ''){
                this.value = (this.defaultValue ? this.defaultValue : '');
                $(this).parent().parent().prev().hide();
                $(this).parent().parent().css('margin-right','0');
                $(this).parent().parent().parent().removeClass('vid-active-input');
            }
            if (this.value == this.defaultValue){

            }
        });

    $('.vid-profile-name , .vid-profile-birth , .vid-profile-home , .vid-profile-work').focus(function() {
        if(this.value != ''){
            $('.vid-ico-close-hide').hide();
            $(this).parent().parent().parent().children('.vid-ico-close-hide').show();
        }
    });
}

function closePopup(){
    $('#vid-close').click(function(){
        $(".vid-popup-addemail").removeAttr('style');
        var tag = $(this).attr('rel');
        $('#'+tag).parent().hide();
        //        $('#'+tag).hide();
        $('#vid-check-popup-profile').val('0');
        $('.hidescroll').removeAttr('style');
        $('.hidescroll').removeClass('hidescroll');
    });
}

function backPopup(){
    $('#vid-back').click(function(){
        var tag = $(this).attr('rel');
        var pShow = tag.split(':')[0];
        var pHide = tag.split(':')[1];
        $('#'+pShow).parent().show();
        $('#'+pHide).parent().hide();

        $(".vid-body-wrap").removeAttr('style');
        $(".vid-popup-addemail").removeAttr('style');
    });
}

function clickSetting(){
    $("#vid-setting-action").click(function(){
        var hW = parseInt($(window).height());
        $('#vid-popup-profile').parent().show();
        $('#vid-popup-profile').parent().addClass('animated fadeInUpBig');
        $('body').children().addClass('hidescroll');
        var hPopup = parseInt($('#vid-popup-profile').height());
        if(hW > hPopup) {
            $('#vid-popup-profile').parent().css('height',(hW-100)+'px');
            //$('body').children().css('height',hW+'px');
        } else {
            $('#vid-popup-profile').parent().css('height',hPopup+'px');
            //$('body').children().css('height',hPopup+'px');
        }
        $('#vid-check-popup-profile').val('1');
        $('html,body').animate({
            scrollTop: 0
        }, 'fast');
        closePopup();
        addEmail();
        clearTextVid();
        focusMove();
    });
}
function addEmail(){
    $('#vid-add-email').click(function(){
        var hW = parseInt($(window).height());
        $('#vid-popup-addemail').parent().addClass('animated fadeInUpBig');
        $('#vid-popup-addemail').parent().show();
        var hPopupEmail = parseInt($('#vid-popup-addemail').height());
        if(hW > hPopupEmail) {
            $('body').children(":not(.vid-footer)").css('height',(hW)+'px');
            $('#vid-popup-addemail').parent().css('height',(hW)+'px');
        } else {
            $('body').children(":not(.vid-footer)").css('height',hPopupEmail+'px');
            $('#vid-popup-addemail').parent().css('height',(hPopupEmail)+'px');
        }
        $('#vid-check-popup-profile').val('2');
        $('.vid-body-wrap').removeAttr('style');
        backPopup();
        setTimeout(function(){
            $('#vid-popup-profile').parent().hide();
            $('#vid-popup-profile').parent().removeClass('animated fadeInUpBig');
        },1000);
        clearTextVid();
        //addNewEmail();
        focusMove();
    });
}
//function addEmail(){
//    $('#vid-add-email').click(function(){
//        $("#mess_user_update_email").html('');
//        $("#mess_user_update_email").hide();
//
//        var hW = parseInt($(window).height());
//        alert(hW);
//        $('#vid-popup-addemail').parent().addClass('animated fadeInUpBig');
//        $('#vid-popup-addemail').parent().show();
//        var hPopupEmail = parseInt($('#vid-popup-addemail').height());
//        if(hW > hPopupEmail) {
//$('body').children().css('height',hW+'px');
//            $('#vid-popup-addemail').parent().css('height',hW+'px');
//        } else {
//$('body').children().css('height',hPopupEmail+'px');
//            $('#vid-popup-addemail').parent().css('height',hPopupEmail+'px');
//        }
//        $('#vid-check-popup-profile').val('2');
//        backPopup();
//        setTimeout(function(){
//            $('#vid-popup-profile').parent().hide();
//            $('#vid-popup-profile').parent().removeClass('animated fadeInUpBig');
//        },1000);
//        clearTextVid();
//        addNewEmail();
//        focusMove();
//    });
//}

var i = 2;
function addNewEmail(){
    $('#vid-add-new-email').unbind().click(function(){
        if(i<=1){
            var fmrAddEmail = $('#vid-clone-new-email').clone().html();
            $('#vid-content-new-email').append(fmrAddEmail);
            $('#vid-new-email-append').attr("id",'vid-new-email'+i);
            $('.vid-profile-txt','#vid-new-email'+i).html('Email '+i);
            $('input','#vid-new-email'+i).attr('class','vid-add-mail'+i);
            $('.vid-clear-txt','#vid-new-email'+i).attr('rev','vid-add-mail'+i);
            $('input','#vid-new-email'+i).focus();
            clearTextVid();
            i++;
        }
    });
}

function clearTextVid(){
    $('.vid-clear-txt').click(function(){
        var divClear = $(this).attr('rev');
        $('.'+divClear).val('');
        $('.'+divClear).focus();
    });
}

$(window).resize(function(){
    var hW = parseInt($(window).height());
    var check = parseInt($('#vid-check-popup-profile').val());
    if(check == 1){
        var hPopup = parseInt($('#vid-popup-profile').height());
        if(hW > hPopup) {
            $('body').children(":not(.vid-footer)").css('height',hW+'px');
            $('#vid-popup-profile').parent().css('height',hW+'px');
        } else {
            $('body').children(":not(.vid-footer)").css('height',hPopup+'px');
            $('#vid-popup-profile').parent().css('height',hPopup+'px');
        }
    }

    if(check == 2){
        var hPopupEmail = parseInt($('#vid-popup-addemail').height());
        if(hW > hPopupEmail) {
            $('body').children(":not(.vid-footer)").css('height',hW+'px');
            $('#vid-popup-addemail').parent().css('height',hW+'px');
        } else {
            $('body').children(":not(.vid-footer)").css('height',hPopupEmail+'px');
            $('#vid-popup-addemail').parent().css('height',hPopupEmail+'px');
        }
    }

});

function closeErr(){
    $('.vid-err').click(function(){
        $(this).hide();
    });
}

jQuery(function(){
    $("input").unbind('focus');
    focusInput();
    clearTextVid();
    clickSetting();
    closePopup();
    backPopup();
    addNewEmail();
    focusMove();
    closeErr();
});
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}