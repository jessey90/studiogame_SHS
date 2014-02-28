<?php Yii::app()->facebook->ogTags['og:title'] = "FacebookLogin"; ?>
<?php $this->widget('ext.yii-facebook-opengraph.plugins.LikeButton', array(
    //'href' => 'YOUR_URL', // if omitted Facebook will use the OG meta tag
    'show_faces'=>true,
    'send' => true
)); ?>
