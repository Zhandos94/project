/**
 * Created by BADI on 26.12.2016.
 */

function clearInputs() {
    $('.additional-block input, .additional-block select')
    // $('#additional-3 input, #additional-4 input, #additional-5 input, #additional-common input, #additional-5 select')
        .each(function() {
            if($(this).attr('type') == 'checkbox'){
                $(this).attr('checked', false);
            } else {
                $(this).val('').trigger('change');
            }
        });
}

function displayCreateElems(){
    $('.dim-creating').hide();
    if($('#dimdata-codeid').val() == 9999){
        $('.dim-creating').show();
    }
}

function showElem(number){
    $('.additional-block').hide();
    if(number !== ''){
        $('#additional-'+number).show();
    }
}

function displayRefsBlock(value) {
    $('#dynamic-ref').hide();
    if(value == -1){
        $('#dynamic-ref').show();
    }
}