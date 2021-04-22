/**
 * Created by nurbek on 11/1/16.
 */



var NAMESPACE, DEFAULT_MIN, DEFAULT_MAX, DEFAULT_STEP, isEmpty, getCss, addCss, getDecimalPlaces, applyPrecision,
    handler, Rating;
NAMESPACE = '.rating';
DEFAULT_MIN = 0;
DEFAULT_MAX = 5;
DEFAULT_STEP = 0.5;

isEmpty = function (value, trim) {
    return value === null || value === undefined || value.length === 0 || (trim && $.trim(value) === '');
};
$.fn.rating.Constructor.prototype._setStars = function (pos) {
    var self = this, out = arguments.length ? self.calculate(pos) : self.calculate(), $el = self.$element;
    if(out.val>0)
        $el.val(out.val);
    else
        $el.val('');

    self.$filledStars.css('width', out.width);
    self._setCaption(out.caption);
    self.cache = out;
    return $el;
};

$.fn.rating.Constructor.prototype._initSlider = function (options) {
    var self = this;
    if (isEmpty(self.$element.val())) {
        self.$element.val('');
    }
    self.initialValue = self.$element.val();
    self._setDefault('min', self._parseAttr('min', options));
    self._setDefault('max', self._parseAttr('max', options));
    self._setDefault('step', self._parseAttr('step', options));
    if (isNaN(self.min) || isEmpty(self.min)) {
        self.min = DEFAULT_MIN;
    }
    if (isNaN(self.max) || isEmpty(self.max)) {
        self.max = DEFAULT_MAX;
    }
    if (isNaN(self.step) || isEmpty(self.step) || self.step === 0) {
        self.step = DEFAULT_STEP;
    }
    self.diff = self.max - self.min;
};