
function focusPhone(){
    $('input[name="input-phone"]').focus(function(){
        if (this.value == this.defaultValue){
            this.value = '';
            $("#dt-input-phone").addClass('dt-active');
            $("#dt-phone-btn").addClass('dt-btn-active');
        }
        if(this.value != this.defaultValue){
            this.select();
        }
    }).blur(function(){
            if (jQuery.trim(this.value) == ''){
                this.value = (this.defaultValue ? this.defaultValue : '');
                $("#dt-input-phone").removeClass('dt-active');
                $("#dt-phone-btn").removeClass('dt-btn-active');
            }
            if (this.value == this.defaultValue){

            }
        });

    $('.dt-pass-input').focus(function() {
        if (this.value == this.defaultValue){
            this.value = '';
            $(this).parent().parent().parent().addClass('dt-active');
        }
        if(this.value != this.defaultValue){
            this.select();
        }
        $(this).prop('type', 'password');
    }).blur(function() {
            if (jQuery.trim(this.value) == ''){
                this.value = (this.defaultValue ? this.defaultValue : '');
                $(this).val($(this).attr('title')).prop('type', 'text');
                $(this).parent().parent().parent().removeClass('dt-active');
            }
            if (this.value == this.defaultValue){

            }
        });

    $('input[name="name"] , input[name="Users[email]"], input[name="input-phone"], input[name="name_ID"], input[name="fullname"], input[name="find"], input[name="Users[password]"], input[name="repassword"]').focus(function() {
        if (this.value == this.defaultValue){
            //this.value = '';
            $(this).parent().parent().parent().addClass('dt-active');
        }
        if(this.value != this.defaultValue){
            this.select();
        }
    }).blur(function() {
            if (jQuery.trim(this.value) == ''){
                //this.value = (this.defaultValue ? this.defaultValue : '');
                $(this).parent().parent().parent().removeClass('dt-active');
            }
            if (this.value == this.defaultValue){

            }
        });
}

function clearText(){
    $('.dt-clear').unbind('click').click(function(){
        $('input',$(this).parent()).val('');
        $('input',$(this).parent()).focus();
    });
}

jQuery(function(){
    focusPhone();
    clearText();
});