var help = (function () {
    var firstElOne = $('.container').parent('div').children('.container').children('div:not(#duty_danger):first');
    var firstElFluid = $('.container-fluid').parent('div').children('.container-fluid').children('div:first');
    var controllerUrl = '/helps/default/',
        onlyHintsAllArray = [],
        mainHintsAllArray = [],
        hintsAllArray = [],
        pageId,
        rootElement,
        hintStepCount = 0;

    /**
     * Если length больше нуля значит элемент container сущ-т
     */
    if (firstElOne.length) {
        pageId = firstClassName(firstElOne);
        rootElement = firstElOne;
    } else {
        pageId = firstClassName(firstElFluid);
        rootElement = firstElFluid;
    }

    /*--------------------------------------*/
    /*    Event                             */
    /*--------------------------------------*/

    /**
     * Запускает показ всех хинтов
     */
    $('.help').click(function() {
        if (mainHintsAllArray.length > 0) {
            help(mainHintsAllArray);
        }
    });

    /**
     * Запускает показ одного хинта
     */
    $('body').delegate('.only_help', 'click', function(event) {
        event.stopPropagation();
        if (onlyHintsAllArray.length > 0) {
            help($(this).data('hint'));
        }
    });

    /*--------------------------------------*/
    /*    Function                          */
    /*--------------------------------------*/

    /**
     * firstClassName Возращает имя первого класса элемента DOM
     * @param elem container
     * @return string class name
     */
    function firstClassName(elem) {
        return $(elem).attr('class').split(' ')[0];
    }

    /**
     * Получает из БД все хинты
     * @return void
     */
    function getAllHintsThisPage() {
        $.ajax({
            url: controllerUrl + 'get-help-json?page_id=' + pageId + '&lang=' + window._CURLANG,
            method: 'get',
            success: function (response) {
                var result = JSON.parse(response);
                result.sort(function (a, b) {
                    return a.step - b.step;
                });
                result.forEach(function (item_hint) {
                    if (item_hint.body == '') { return; }
                    hintsAllArray.push(item_hint);
                });
                getHint(true);
            }

        });
    }

    /**
     * Получает по единственному хинту полученных из БД
     * и готовит их к introjs для показа
     * @param hint object текущии объект
     * @returns object готовые к introjs объект
     */
    function stepObjectHints(hint) {
        var customStepObj = {};
        for (var prop in hint) {
            if (!hint.hasOwnProperty(prop)) { continue; }
            if (hint[prop] === null) { delete hint[prop]; }
        }
        customStepObj.intro = hint.body;
        customStepObj.element = document.getElementById(hint.element_id);
        if (hint.position) { customStepObj.position = hint.position; }
        return customStepObj;
    }

    /**
     * Проверят элемент на видимость
     * @param element DOM элемент
     * @returns boolean
     */
    function isElementVisible(element) {
        var result = false;
        if (element) {
            if ($(element)[0].tagName.toLowerCase() == 'input' && $(element).attr('type') != 'hidden') {
                result = true;
            } else if ($(element).is(':visible')) {
                result =  true;
            }
        }
        return result;
    }

    /**
     * Рендерит знак вопроса для единичных хинтов,
     * также добавляет каждый преденый хинт в общии масив для одиночных хинтов
     * @param hint
     * @returns void
     */
    function onlyHelpRenderQuestion(hint) {
        var currElement, questionElement, labelElement, currTag, regexp;
        currElement = document.getElementById(hint.element_id);
        if (isElementVisible(currElement)) {
            regexp = /select2/;
            currTag = $(currElement)[0].tagName.toLowerCase();
            questionElement = $('<i class="only_help fa fa-question" aria-hidden="true" data-hint="'+ hint.element_id +'"></i>');
            if (currTag == 'input' || currTag == 'textarea' || currTag == 'select') {
                labelElement = $(currElement).closest('.form-group').find('label');
                $(labelElement).after(questionElement);
            } else if (regexp.test($(currElement).attr('id'))) {
                labelElement = $(currElement).closest('div').find('label');
                labelElement.after(questionElement);
            } else {
                $(currElement).after(questionElement);
            }
            onlyHintsAllArray.push(stepObjectHints(hint));
        }
    }

    /**
     * Возвращает один хинт
     * @param need_hint string id hint
     * @returns array one hint
     */
    function getOneHint(need_hint) {
        var hint = [];
        onlyHintsAllArray.forEach(function (item) {
            if ($(item.element).attr('id') == need_hint) {
                hint.push(item);
            }
        });
        return hint;
    }

    /**
     * Показ хинтов
     * @param hints все хинты или один хинт
     * @returns void
     */
    function help(hints) {
        var step,
            intro = introJs();
        if (Array.isArray(hints)) {
            step = hints;
        } else {
            step = getOneHint(hints);
        }
        intro.setOptions({
            steps: step,
            nextLabel: _t('Forward'),
            prevLabel: _t('Back'),
            skipLabel: _t('Skip'),
            doneLabel: _t('Done'),
            hidePrev: true,
            hideNext: true,
            overlayOpacity: 0.2
        });

        intro.onchange(function (targetElement) {
            countHint();
            var currEl = $('#' + targetElement.id);
            var currTag = $(currEl)[0].tagName.toLowerCase();
            if (currTag == 'input' || currTag == 'textarea') {
                $(currEl).focus();
            }
        });

        intro.start();
    }

    function mainHelpQuestion() {
        if (mainHintsAllArray.length < 1) {
            $('.help').addClass('not_main_hints');
        }
    }

    /**
     *
     */
    function getHint(innerCall) {
       /* mainHintsAllArray = [];
        onlyHintsAllArray = [];*/
        $('.only_help').remove();
        if (innerCall) {
            hintsAllArray.forEach(function (item_hint) {
                var element = document.getElementById(item_hint.element_id);
                if (item_hint.is_only == 1) { onlyHelpRenderQuestion(item_hint); }
                if (item_hint.is_main == 1) {
                    if (isElementVisible(element)) {
                        mainHintsAllArray.push(stepObjectHints(item_hint));
                    }
                }
            });
        } else {
            // TODO: для main хинтов в динамической форме
        }
        mainHelpQuestion()
    }

    // TODO: для main хинтов в динамической форме нужен будет
    function countHint() {
        if (mainHintsAllArray.length >= hintStepCount) {
            hintStepCount++;
        } else {
            hintStepCount = 0;
        }
    }
    return {
        getHint: getHint,
        getAllHintsThisPage: getAllHintsThisPage,
        rootElement: rootElement,
        hintsAllArray: hintsAllArray,
        pageId: pageId
    }

}());
help.getAllHintsThisPage();
