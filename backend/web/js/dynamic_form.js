/**
 * Created by BADI on 26.12.2016.
 */

function removeInit() {
    $('.remove-btn').on('click', function () {
        removeElem();
    });
}

function removeElem() {
    $('.remove-btn').parent().parent().remove();
}

function addLabel(name) {
    var meta_div = document.createElement('div');
    meta_div.setAttribute('id', 'label-div' + j);
    meta_div.appendChild(createDiv('Name'+j, name + '[' + j + ']'));
    meta_div.appendChild(createRemoveDiv());
    $('#labels').append(meta_div);
    removeInit();
    j++;
}

function createTextinput(name) {
    var textinput = document.createElement('input');
    textinput.setAttribute('type', 'text');
    textinput.setAttribute('name', name);
    textinput.setAttribute('class', 'form-control');
    return textinput;
}

function createLabel(name) {
    var label = document.createElement('label');
    label.setAttribute('class', 'control-label');
    label.innerHTML = name;
    return label;
}

function createDiv(label_name, input_name) {
    var div = document.createElement('div');
    div.setAttribute('class', 'col-md-5');
    div.appendChild(createLabel(label_name));
    div.appendChild(createTextinput(input_name));
    return div;
}

function createRemoveDiv() {
    var remove_btn = document.createElement('button');
    remove_btn.setAttribute('type', 'button');
    remove_btn.setAttribute('class', 'btn btn-danger remove-btn');
    remove_btn.textContent = '-';
    var remove_div = document.createElement('div');
    remove_div.setAttribute('class', 'col-md-1');
    remove_div.appendChild(remove_btn);
    return remove_div;
}

/**
 * this function uses only on form for creating dimension with static id if elements
 * */
function dropdownService() {
    var form = $('#dynamic-ref-form');
    var formData = form.serialize();
    var url = form.attr('action');
    $.ajax({
        type:'post',
        data:formData,
        url:url,
        success:function(response){
            response = JSON.parse(response);
            var item = response.success;
            if(typeof item !== 'undefined'){
                $('#dimdata-ref_group_id').append($('<option>', {
                    value:item.id,
                    text:item.name
                }));
                $('#dimdata-ref_group_id').val(item.id).trigger('change');
            } else {
                item = response.error;
                $('#dynamic-ref-error').addClass('alert alert-danger').html(item.message);
            }
            $('#dynamic-ref-form')[0].reset();
            $('#dynamic-ref-add').modal('toggle')
        }
    });
}