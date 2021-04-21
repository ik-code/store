(function($){
window._klarnaCheckout(function (api) {
    api.on({
        "customer": function (customer) {
            let customer_type = customer.type;
            let input_user_role = document.getElementById('user_role');
            let tax = 0;
            if (customer_type === 'organization') {
                input_user_role ? input_user_role.value = 'business' : '';
                tax = 25;
            } else {
                input_user_role ? input_user_role.value = 'customer' : '';
                tax = 0;
            }

            $('body').trigger('update_checkout');
        }
    })
});
})(jQuery);
