function seleccionarMenu(url) {
    $('ul.sidebar-menu a').filter(function () {
        return this.href == url;
    }).parent().addClass('active');

    $('ul.treeview-menu a').filter(function () {
        return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
}

function mensaje($element, $class, $message) {
    $($element).html('<div class="alert '+ $class +'"><span class="close" data-dismiss="alert" aria-label="close">×</span>'+ $message +'</div>');
}

function notify (tipo, mensaje) {
    Lobibox.notify(tipo, {
        size: 'mini',
        rounded: true,
        sound: false,
        delayIndicator: false,
        msg: mensaje
    });
}