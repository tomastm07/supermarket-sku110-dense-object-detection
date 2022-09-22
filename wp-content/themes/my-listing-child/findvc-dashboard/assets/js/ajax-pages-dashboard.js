jQuery(document).ready(function ($) {

    const itemLabel = document.querySelectorAll('.dashboard__link--item__options');
    const containerParent = document.querySelector('.dashboard-founder__init');

    itemLabel.forEach(items => {
        items.addEventListener('click', (e) => {
            const itemsLinks = e.path.find(element => element.classList.contains('dashboard__link--item__options'))
            jQuery.ajax({
                url: dcms_vars.url,
                type: 'post',
                data: {
                    action: dcms_vars.hook,
                    security: dcms_vars.nonce,
                    template: itemsLinks.getAttribute('data-click'),
                    // padre: idCat,
                },
                beforeSend: function () {
                    containerParent.innerHTML = '';
                },
                success: function (result) {
                    containerParent.innerHTML = result;
                }
            });
        })
    });

});