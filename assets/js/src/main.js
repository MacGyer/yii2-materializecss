$(document).ready(function () {
    $('[data-materialize-scrollspy="true"]').scrollSpy();
    $('.button-collapse').sideNav();

    $(".dropdownTrigger").dropdown({
        hover: false
    });

    var clipboard = new Clipboard('.clipboard > button');
    clipboard.on('success', function(e) {
        Materialize.toast('Copied!', 2500);

        e.clearSelection();
        e.trigger.blur();
    });
});