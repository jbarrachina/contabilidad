/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function ()
{
    $("body").css("font-size", "12px");
    $(".btn-delete-desglose").button(
            {
                icons:
                        {
                            primary: "ui-icon ui-icon-grip-diagonal-se"
                        },
                text: false
            });
    $("button.btn-delete-desglose").button(
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
    
    
    $('button.btn-delete-desglose').on("click", deleteDesglose);
    
    function deleteDesglose(event){
        var my_url = $(this).attr("id").substring(2).split("-");
        $.getJSON("/php/contabilidad/desglose/"+my_url[0]+"/"+my_url[1], {}, function (datos) {
            //no hace nada
        }).done(function (datos) {
            $("#dt"+my_url[0]+"-"+my_url[1]).remove();
            $("#dd"+my_url[0]+"-"+my_url[1]).remove();
            var num_desgloses = $("#btn-des"+my_url[0]).children('span').html();
            num_desgloses--;
            $("#btn-des"+my_url[0]).children('span').html(num_desgloses);
            //$("bt"+my_url[0]+"-"+my_url[1]).remove();
            
        }).fail(function () {
            alert('Error en la conexión con el servidor');
        });
        return false;
    }


});