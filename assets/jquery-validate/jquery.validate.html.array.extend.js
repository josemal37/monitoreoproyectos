/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$.extend($.validator.prototype, {
    showErrors: function(errors) {
        if (errors) {
            // add items to error list and map
            $.extend(this.errorMap, errors);
            this.errorList = [];
            for (var name in errors) {
                this.errorList.push({
                    message: errors[name],
                    /* NOTE THAT IM COMMENTING THIS OUT
                     element: this.findByName(name)[0]
                     */
                    element: this.findById(name)[0]
                });
            }
            // remove items from success list
            this.successList = $.grep(this.successList, function(element) {
                return !(element.name in errors);
            });
        }
        this.settings.showErrors
                ? this.settings.showErrors.call(this, this.errorMap, this.errorList)
                : this.defaultShowErrors();
    },
    findById: function(id) {
        // select by name and filter by form for performance over form.find(“[id=…]”)
        var form = this.currentForm;
        return $(document.getElementById(id)).map(function(index, element) {
            return element.form == form && element.id == id && element || null;
        });
    },
    checkForm: function() {
        this.prepareForm();
        for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
            if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
                for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                    this.check(this.findByName(elements[i].name)[cnt]);
                }
            } else {
                this.check(elements[i]);
            }
        }
        return this.valid();
    }
});