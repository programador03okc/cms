var Util = ( function () {
    function formato_numero(numero, decimales, punto_decimal, separador_miles) {
        numero = (numero + '')
                .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+numero) ? 0 : +numero,
                prec = !isFinite(+decimales) ? 0 : Math.abs(decimales),
                sep = (typeof separador_miles === 'undefined') ? ',' : separador_miles,
                dec = (typeof punto_decimal === 'undefined') ? '.' : punto_decimal,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + (Math.round(n * k) / k)
                            .toFixed(prec);
                };

        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
                .split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '')
                .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
                    .join('0');
        }
        return s.join(dec);
    }

    function details_item(txt0, txt1, txt2, txt3, txt4, txt5, contador, total, type) {
        var price = formato_numero(txt3, 2, '.', ',');
        content = `
        <tr id="okc-${ contador }">
            <td>
                <input type="hidden" class="form-control input-sm" name="body_producto[]" value="${ txt0 }">
                <input type="hidden" class="form-control input-sm" name="body_descripcion[]" value="${ txt1 }"><span>${ txt1 }</span>
            </td>
            <td align="center">
                <input type="hidden" class="form-control input-sm" name="body_cantidad[]" value="${ txt2 }"><span>${ txt2 }</span>
            </td>
            <td align="center">
                <input type="hidden" class="form-control input-sm" name="body_moneda[]" value="${ txt4 }"><span>${ txt5 }</span>
            </td>
            <td align="right">
                <input type="hidden" class="form-control input-sm" name="body_precio[]" value="${ txt3 }"><span>${ price }</span>
            </td>`;

            if (type == 'copy') {
                content += `
                <td>
                    <button type="button" class="btn btn-xs btn-danger btn-flat" onClick="removeList(${ contador }, ${ total });"><span class="icon-cancel"></span></button>
                </td>`;
            }else{
                content += `<td>-</td>`;
            }
        content += `</tr>`;
        return content;
    }

    function leftZero(canti, number) {
        let vLen = number.toString();
        let nLen = vLen.length;
        let zeros = '';
        for(var i=0; i<(canti-nLen); i++){
            zeros = zeros+'0';
        }
        return zeros+number;
    }

    return {
        formato_numero: formato_numero,
        leftZero: leftZero,
        details_item: details_item,
    };
})();