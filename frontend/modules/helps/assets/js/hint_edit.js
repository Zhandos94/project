(function(){
    var allElemetIds = [],
        controllerUrl = '/helps/default/';

    /*--------------------------------------*/
    /*    Event                             */
    /*--------------------------------------*/

    /**
     * Включает/отключает режим редактирование страницы, для добавление
     * редактировани хинтов
     */
    $('.hints').click(function (e) {
        e.preventDefault();
        if (allElemetIds.length < 1) {
            getAllElementsId();
        }
        if ($(this).hasClass('mode-editor')) {
            $(this).removeClass('mode-editor');
            $('.hnt-edited').removeClass('hnt-edited'); // Скрывает border
        } else {
            $(this).addClass('mode-editor');
            help.hintsAllArray.forEach(function (item) {
                $('#' + item.element_id).addClass('hnt-edited'); // для эл. где есть уже есть хинт рисует border
            });
        }

        /**
         * бегает по массиву
         * значенимии которого являются элементы страницы
         * у которых есть ID, и добавляет класс element-edidor
         * либо удаляет
         */
        $(allElemetIds).each(function () {
            if ($(this).hasClass('hnt-element-edidor')) { $(this).removeClass('hnt-element-edidor'); }
            else { $(this).addClass('hnt-element-edidor'); }
            // $('.element-edidor').off('click');
        });
    });

    /**
     * Открывает модальное окно, с формой
     */
    $('body').delegate('.hnt-element-edidor', 'click', function(event) {
        var modal, elementId;
        event.preventDefault();
        event.stopPropagation();
        elementId = $(this).attr('id');
        modal = $('#hint-modal');
        $('#add-hint').text('Create');
        $('#add-hint').prop('disabled', false); // button submit
        $('.help-intro-form').find('form')[0].reset();
        $('#helpintro-step').val('');
        $('#helpintro-is_frontend').val(1);
        $('#helpintro-page_id').val(help.pageId).prop('readonly', true);
        $('#helpintro-element_id').val(elementId).prop('readonly', true);
        $('#helpintro-message').val(help.pageId + ' - ' + elementId);
        $(modal).modal('show');
        isCheckedMain()

        // если на элементе сущ. хинт то отправляем запрос, чтобы заполнить поля формы
        if ($(this).hasClass('hnt-edited')) {
            $.ajax({
                url: controllerUrl + 'get-element-id-data?page_id=' + help.pageId + '&element_id=' + elementId,
                method: 'get',
                success: function(response) {
                    var result = JSON.parse(response);
                    $('#add-hint').text('Update');
                    $('#helpintro-message').val(result.message);
                    $('#helpintro-body').val(result.body);
                    $('#helpintro-position option').filter(function() {
                        return $(this).val() == result.position;
                    }).prop('selected', true);
                    $('#helpintro-langs option').filter(function() {
                        return $(this).val() == result.lang;
                    }).prop('selected', true);
                    $('#helpintro-is_only').prop('checked', result.is_only);
                    $('#helpintro-is_main').prop('checked', result.is_main);
                    $('#helpintro-step').val(result.step);
                    $('#helpintro-description').val(result.description);
                    $('#helpintro-update_model').val(1);
                    isCheckedMain();
                }
            });
        }
    });

    /**
     * Добавляет хинт
     */
    $('body').delegate('#add-hint', 'click', function(e) {
        e.preventDefault();
        $('#add-hint').prop('disabled', true); // button submit
        var modal = $('#hint-modal'),
            form = $('.help-intro-form').find('form'),
            url = controllerUrl + 'edit',
            dataForm = $(form).serialize();
        $.ajax({
            type: 'post',
            url: url,
            data: dataForm,
            success: function (response) {
                if (response) {
                    var elementID = JSON.parse(response);
                    $('#' + elementID).addClass('hnt-edited');
                    help.hintsAllArray.push({element_id: elementID});
                }
                $(form)[0].reset();
                $(modal).modal('hide');
                $('#helpintro-step').attr('type', 'hidden');
            }
        });
    });

    /**
     * Скрывает или открывает поле step
     */
    $('body').delegate('#helpintro-is_main', 'click', function () {
        isCheckedMain();
    });

    /*--------------------------------------*/
    /*    Function                          */
    /*--------------------------------------*/

    /**
     * Бегает по всем элементам от контейнера и добавляет в массив
     * те у кого есть атрибут ID
     * @returns void
     */
    function getAllElementsId() {
        $(help.rootElement).find('*').each(function() {
            if ($(this).attr('id')) {
                allElemetIds.push(this);
            }
        });
    }

    /**
     * Если main checked, step type='text' иначе type='hidden'
     * @returns void
     */
    function isCheckedMain() {
        if ($('#helpintro-is_main').is(':checked')) {
            $('#helpintro-step').attr('type', 'text');
        } else {
            $('#helpintro-step').attr('type', 'hidden');
        }
    }
}());