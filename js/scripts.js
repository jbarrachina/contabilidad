/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function ()
{
    $("body").css("font-size", "12px");
    $(".btn-des").button(
            {
                icons:
                        {
                            primary: "ui-icon ui-icon-grip-diagonal-se"
                        },
                text: false
            });
    $(".btn-add").button(
            {
                icons:
                        {
                            primary: "ui-icon ui-icon-grip-diagonal-se"
                        },
                text: false
            });
    $("#btn-des").button(
            {
                icons:
                        {
                            primary: "ui-icon ui-icon-grip-diagonal-se"
                        },
                text: false
            });
    $('.btn-add').on("click", addCuenta);
    function addCuenta(event) {
        var apunte = $(this).attr('id').substring(7);
        var $contenido = $('<div id="dialog" title="Añadir cuenta">Añadiendo una cuenta</div>');
        $("body").append($contenido);
        $("#dialog").dialog(
                {
                    modal: true,
                    width : 600,
                    open: function () {
                        $(this).load("/php/contabilidad/desglose/"+apunte);
                        //$(this).append("<input type='hide' value='"+apunte+"'>");
                    },
                    show: {effect: "slide", duration: 600},
                    hide: {effect: "explode", duration: 600},
                    title: "Añadir cuenta",
                    closeOnEscape: false,
                    buttons:
                            {
                                "Sí": function ()
                                {
                                    $("#addDesglose").submit();
                                   // $(this).dialog("close");
                                },
                                "No": function ()
                                {
                                    $(this).dialog("close");
                                }
                            },
                    
                    close: function (evento) {
                        $contenido.remove();
                    }
                }
        );
    }


});