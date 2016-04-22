class clickOnce {
    constructor() {
        this.restrict = 'A';
        this.priority = -1;
        this.scope = {
            'ngClick': '&'
        };
    }

    link(scope, element, attrs) {
        var disabled;
        var eventComplete = attrs.clickOnce;

        function onClick(evt) {
            if (disabled) {
                evt.preventDefault();
                evt.stopImmediatePropagation();
            } else {
                disabled = true;
            }
        }

        scope.$on(eventComplete, function () {
            disabled = false;
        });
        element.bind('click', function (evt) {
            onClick(evt)
        });
    }
}

export default clickOnce;