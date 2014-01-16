<body>
    <h1>Tạo User mới</h1>
    <div class="dt-content">
        <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'users-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>
        <?php echo $form->errorSummary($model); ?>
        <div class="dt-input dt-input-first">
            <div class="dt-ico-col dt-clear">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imagesv3/close.png" />
            </div>
            <div class="dt-input-col">
                <div>
                    <?php echo $form->textField($model,'email',array('placeholder'=>'Email','class' => 'dt-phone-hide','size'=>60,'maxlength'=>255)); ?>
                </div>
            </div>
        </div>
        <div class="dt-input">
            <div class="dt-ico-col dt-clear">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imagesv3/close.png" />
            </div>
            <div class="dt-input-col">
                <div>
                    <?php echo $form->passwordField($model,'password',array('class' => 'dt-phone-hide dt-pass-input','placeholder'=>'Mật khẩu','size'=>60,'maxlength'=>255)); ?>
                </div>
            </div>
        </div>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Đăng ký' : 'Save',array('class' => 'dt-phone-btn-new dt-email-btn-register')); ?>
        <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    $("#btnEmail").click(function(){$(this).unbind('click').text('Đang xử lý...');});
    /* attach a submit handler to the form */
    $('#btnEmail').click(function() {
        $('#register-email').submit();
        return true;
    });
</script>
<div class="vid-footer">
    <span class="vid-footer-txt">Copyright © 2013 by VC Corp</span>
</div>
</div>
<script type="text/javascript">
    /*GA*/
</script>
<script type="text/javascript">
    function hideAddressBar()
    {
        if(!window.location.hash)
        {
            if(document.height <= window.outerHeight + 10)
            {
                document.body.style.height = (window.outerHeight + 50) +'px';
                setTimeout( function(){ window.scrollTo(0, 1); }, 50 );
            }
            else
            {
                setTimeout( function(){ window.scrollTo(0, 1); }, 0 );
            }
        }
    }

    window.addEventListener("load", hideAddressBar );
    window.addEventListener("orientationchange", hideAddressBar );
</script>

</body>
</html>
