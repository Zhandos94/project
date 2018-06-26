<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\User */

$this->title = Yii::t('app', 'Route');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .search{
        padding: 0;
        margin-bottom: 15px;
    }
</style>

<div class="row">

    <div class="col-lg-12">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="col-sm-5 block_left">

        <div class="col-lg-12 search search_left" id="left">
            <input class="form-control" placeholder="<?= Yii::t('app', 'Search for avaliable') ?>">
        </div>

        <select id='select_left' multiple size="15" class="form-control list" data-target="avaliable">

            <optgroup label="Routes" class="left-route">
                <?php foreach ($leftArray as $value) { ?>
                    <option value="<?= $value ?>"> <?= $value ?> </option>
                <?php } ?>
            </optgroup>

        </select>
    </div>
    <div class="col-sm-1 block_right">
        <br>
        <br>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-right">',
            ['/myadmin/route/add-route',],
            ['class' => 'btn btn-success send', 'id' => 'add']) ?>
        <br>
        <br>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left">',
            ['/myadmin/route/delete-route',],
            ['class' => 'btn btn-danger send', 'id' => 'delete']) ?>
        <br>
        <br>
    </div>
    <div class="col-sm-5 block_right">

        <div class="col-lg-12 search search_right" id="right">
            <input class="form-control"
                   placeholder="<?= Yii::t('app', 'Search for avaliable') ?>">
        </div>

        <select id='select_right' multiple size="15" class="form-control list" data-target="avaliable">

            <optgroup label="Routes" class="right-route">
                <?php foreach ($rightArray as $value) { ?>
                    <option value="<?= $value ?>"> <?= $value ?> </option>
                <?php } ?>
            </optgroup>

        </select>
    </div>
</div>


<?php
$js = <<< JS
window.onload = function(){
    var dataLeft = [];
    var dataRight = [];

    $( ".search input" ).focus(function() {
        var search_class = $(this).parent().attr('id');
        $('.search_'+ search_class +' input').on("keyup", function(){
            var filterN = $(this).val();
            $('#select_' + search_class + ' option').each(function() {
                var n = $(this).val();
                if (n.search(new RegExp(filterN,"i")) < 0 ) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    });
        
    $('div.block_left select').on('change', function(e) {
        e.preventDefault();
        dataLeft.splice(0, dataLeft.length);

        $( "#select_left option:selected" ).each(function() {
            dataLeft.push( $( this ).val());
        });
        console.log(dataLeft);
    });
    
    $('div.block_right select').on('change', function(e) {
        e.preventDefault();
        dataRight = [];

        $("#select_right option:selected").each(function() {
            dataRight.push($( this ).val());
        });
        console.log(dataRight);
    }); 

    $('.send').click( function(e) {
        e.preventDefault();
        var url_j = $(this).attr('href');
        var type = $( this ).attr('id');
        var data, label, forechData;
        
        if (type == 'add') {
            data = {key:dataLeft};
            label = 'right';
            forechData = dataLeft;
        } else {
            data = {key:dataRight};
            label = 'left';
            forechData = dataRight;
        }
    
        if(forechData.length > 0)
        {
            $.ajax({
                url: url_j,
                type: 'post',
                data: data,
                
                success: function () {
                    for (var i=0; i < forechData.length; i++) {
                       var opt2 = '<option value="' +  forechData[i]  + '">' +  forechData[i]  + '</option>';
                       $('.' + label + '-route').append(opt2);
                    }
                    dataLeft.splice(0, dataLeft.length);
                    dataRight.splice(0, dataRight.length);
                    $('#select_' + (label == 'right' ? 'left' : 'right') +' '+ 'option:selected').remove();
                }
            });
        }
    });
    
}    
JS;
$this->registerJs($js);
?>
