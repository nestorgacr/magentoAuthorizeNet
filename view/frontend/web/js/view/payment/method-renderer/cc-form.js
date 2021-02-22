define([
    'Magento_Payment/js/view/payment/cc-form',
], function (Component) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Jnga_Authorizenet/payment/cc-form',
            code: 'jnga_authorizenet'
        },

        getCode: function () {
            return this.code;
        },

        isActive: function () {
            return this.getCode() === this.isChecked();
        }
    });

});