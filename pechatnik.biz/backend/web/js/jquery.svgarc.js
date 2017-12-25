/**
 * jQuery plugin for Arc-text in SVG
 * Author: Andriy Bon asingy.com
 */
(function($) {

    Math.radians = function(degrees) {
        return degrees * Math.PI / 180;
    };

    $.fn.svgarc = function (text, radius, start, end, inner) {
        if (inner === false) {
            end = -end;
        }

        var chars = text.split(""),
            deg = ((2 * Math.PI * radius * end) / 360) / chars.length, // угол
            origin = start,  // текущий угол
            result = '';

        chars.forEach(function(symbol) {
            var angleRadians = Math.radians(origin - 1); // радианы
            var left = 0, // коорд. лево
                top = 0; // коорд. вверх


            if (inner === true) { // вывернутый текст
                left = (Math.cos(angleRadians) * radius); // коорд. лево
                top = -(Math.sin(angleRadians) * radius); // коорд. вверх
            }
            else {
                left = -(Math.cos(angleRadians) * radius); // коорд. лево
                top = (Math.sin(angleRadians) * radius); // коорд. вверх
            }

            result += '<text transform="translate('+top+','+left+') rotate('+origin+')"><tspan>'+symbol+'</tspan></text>'; // добавляем готовую строку в результаты
            origin -= deg; // плюсуем к текущему углу шаг
        });

        $(this).html(result);

        return this;
    };

})(jQuery);