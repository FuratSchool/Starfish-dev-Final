(function ($) {
    $.fn.recursiveTree = function (branchClass, bodyClass, inputClass) {
        var tree = this;
        tree.branchClass = branchClass;
        tree.bodyClass = bodyClass;
        tree.inputClass = inputClass;

        tree.fixTree = function () {
            $(this).children(tree.branchClass).each(function () {
                tree.fixBranch($(this));
            });
        };

        tree.fixBranch = function (element) {
            var ell = $(element);
            var branches = ell.children(tree.bodyClass).children(tree.branchClass);
            if (branches.length > 0) {
                var bCheck = [];
                branches.each(function () {
                    var branch = $(this);
                    bCheck.push(tree.fixBranch(branch));
                });

                var checked = false;
                var indeterminate = false;
                bCheck.forEach(function (element, index) {
                    if (element === -1) {
                        indeterminate = true;
                    } else if (index === 0) {
                        checked = element;
                    } else if (checked !== element) {
                        checked = false;
                        indeterminate = true;
                    }
                });
                var input = ell.children(tree.inputClass).find("input");
                input.prop({checked: checked, indeterminate: indeterminate});
                return (indeterminate) ? -1 : (checked ? 1 : 0);
            } else {
                return ell.children(tree.inputClass).find("input").is(":checked") ? 1 : 0;
            }
        };

        tree.getActiveNames = function(){
            return $(this).find('input:checkbox:checked').map(function() {
                return this.name;
            }).get();
        };

        $(this).find("input").change(function () {
            var input = $(this);
            input.parent().parent().children(tree.bodyClass).find("input").prop({
                checked: input.is(":checked"),
                indeterminate: false
            });
            tree.fixTree();
        });

        return this;
    };
}(jQuery));
