/**
 * @param {any} value
 *
 * @returns {String|true}
 */
window.required = (value) =>  {
  let isValid = value !== '' && value.length > 0 && value !== false && value !== null && typeof value !== "undefined";

  return isValid ? true : 'The field %s is required';
}

/**
 * @param {any} value
 *
 * @returns {String|true}
 */
window.email = (value) => {
  const regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

  let isValid = regex.test(value);

  return isValid ? true : 'The field %s must be a valid email';
}

/**
 * @param {any} value
 * @param {String} haystack
 *
 * @returns {String|true}
 */
window.inArray = (value, haystack) => {
  let values = haystack.split(',');

  return values.includes(value) ? true : 'The field %s must be in possible valid values';
}

export default class Validator {
  /**
   * @param {any} value
   * @param {Array} rules
   *
   * @returns {Array}
   */
  static validate(value, rules) {
    let errors = [];

    for(let rule of rules) {
      let result = this.validateRule(value, rule);

      if (result !== true) {
        errors[rule] = result;
      }
    }

    return errors;
  }

  /**
   * @param {any} value
   * @param {String} rule
   *
   * @returns {String|true}
   */
  static validateRule(value, rule) {
    if (rule.includes(':')) {
      let ruleWithParams = rule.split(':');

      return window[ruleWithParams[0]](value, ruleWithParams[1]);
    }

    return window[rule](value);
  }
}
