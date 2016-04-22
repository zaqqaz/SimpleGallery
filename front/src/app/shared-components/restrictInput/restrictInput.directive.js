class restrictInput {
    constructor() {
        this.restrict = 'A';
    }

    link(scope, element, attrs) {
        var ele = element[0];
        var regex = new RegExp(attrs.restrictInput);

        scope.$watch(function () {
            return ele.value
        }, function () {
            if (!regex.test(ele.value)) {
                ele.value = '';
                angular.element(ele).triggerHandler('input');
            }
        });
    }
}

export default restrictInput;