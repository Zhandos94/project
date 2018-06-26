<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Grand Access'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .search{
        padding: 0;
        margin-bottom: 15px;
    }
</style>

<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'logUserStatus.name',
        ],
    ]) ?>

</div>

<div class="row">
    <div class="col-sm-5 block_left">

        <div class="col-lg-12 search search_left" id="left">
            <input class="form-control" placeholder="<?= Yii::t('app', 'Search for avaliable') ?>">
        </div>

        <select id='select_left' multiple size="15" class="form-control list" data-target="avaliable">

            <?php foreach ($leftMass as $key => $values) { ?>
                <optgroup label="<?= $values[0]['description'] ?>" class="left-<?= $values[0]['description'] ?>">
                    <?php foreach ($values as $value) { ?>
                        <option value="<?= $value['name'] ?>"> <?= $value['name'] ?> </option>
                    <?php } ?>
                </optgroup>
            <?php } ?>

        </select>
    </div>
    <div class="col-sm-1">
        <br>
        <br>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-right">',
            ['/myadmin/access/auth-assignment-add', 'id' => $model->id],
            ['class' => 'btn btn-success send', 'id' => 'add']) ?>
        <br>
        <br>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left">',
            ['/myadmin/access/auth-assignment-delete',
                'id' => $model->id],
            ['class' => 'btn btn-danger send', 'id' => 'delete']) ?>
        <br>
        <br>
    </div>
    <div class="col-sm-5 block_right">

        <div class="col-lg-12 search search_right" id="right">
            <input class="form-control" placeholder="<?= Yii::t('app', 'Search for avaliable') ?>">
        </div>

        <select id='select_right' multiple size="15" class="form-control list" data-target="avaliable">

            <?php foreach ($rightMass as $key => $values) { ?>
                <optgroup label="<?= $values[0]['description'] ?>" class="right-<?= $values[0]['description'] ?>">
                    <?php foreach ($values as $value) { ?>
                        <option value="<?= $value['item_name'] ?>"> <?= $value['item_name'] ?> </option>
                    <?php } ?>
                </optgroup>
            <?php } ?>

        </select>
    </div>
</div>


<?php
$js = <<< JS
window.onload = function(){
    var dataLeft = {};
    var dataRight = {};
 
    function isEmptyObject(obj) {
        for (var i in obj) {
            if (obj.hasOwnProperty(i)) {
                return false;
            }
        }
        return true;
    }
        
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
    
    $('div.block_left').on('change', function(e) {
        e.preventDefault();
        var  val = [], val2 = [], val3 = [];
        dataLeft = {};
        
        $( "#select_left option:selected" ).each(function() {
            if($(this).parent('optgroup').attr('label') == 'Role') {
                val.push($( this ).val());
                dataLeft.Role = val;
            }
            if($(this).parent('optgroup').attr('label') == 'Permission') {
                val2.push($( this ).val());
               dataLeft.Permission = val2;
            }
            if($(this).parent('optgroup').attr('label') == 'Router') {
                val3.push($( this ).val());
                dataLeft.Router = val3;
            }
        });
    });
    
    $('div.block_right').on('change', function(e) {
        e.preventDefault();
        var  val = [], val2 = [], val3 = [];
        dataRight = {};
        
        $( "#select_right option:selected" ).each(function() {
            if($(this).parent('optgroup').attr('label') == 'Role') {
                val.push($( this ).val());
                dataRight.Role = val;
            }
            if($(this).parent('optgroup').attr('label') == 'Permission') {
                val2.push($( this ).val());
                dataRight.Permission = val2;
            }
            if($(this).parent('optgroup').attr('label') == 'Router') {
                val3.push($( this ).val());
                dataRight.Router = val3;
            }
        });
    });
    
    $('.send').click( function(e) {
        e.preventDefault();
        var url_j = $(this).attr('href');
        var type = $( this ).attr('id');
        var data, label;
        
        if (type == 'add') {
            data = dataLeft;
            label = 'right';
        } else {
            data = dataRight;
            label = 'left';
        }
        
        if(isEmptyObject(data) == false ) 
        {
            $.ajax({
                url: url_j,
                type: 'post',
                data: data, 
                              
                success: function () {
                    for(var key in data) {
                        if( $('#select_' + label).children('optgroup').hasClass($('.' + label + '-' + key ).attr('class')) == false )
                        {
                            var opt =   '<optgroup label = ' + key + ' ' 
                                                   + 'class = '+ label + '-' + key + '>' ;
                                                       
                            data[key].forEach(function(item) {
                                opt += '<option value="' + item  + '">' + item + '</option>';
                            });
                            
                            opt += '</optgroup>';
                            $('#select_' + label).append(opt);
                        } 
                        else {
                            data[key].forEach(function(item) {
                                opt = '<option value="' + item  + '">' + item + '</option>';
                                $('.' + label + '-' + key ).append(opt);
                            });
                        }
                    }   
                    dataLeft = {};                    
                    dataRight = {};                    
                    $('#select_' + (label == 'right' ? 'left' : 'right') +' '+ 'option:selected').remove();
                }
            });
        }
    });  
}    
JS;
$this->registerJs($js);
?>
