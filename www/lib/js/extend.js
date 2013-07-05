/**
 * Standart objects extend
 *
 * @author Mikhail Miropolskiy <the-ms@ya.ru>
 * @package Lib
 * @copyright (c) 2012. Mikhail Miropolskiy. All Rights Reserved.
 */

/**
 * Remove DOM node yourself
 */
HTMLElement.prototype.remove = function() {
	this.parentNode.removeChild(this);
};

/**
 * Crop number to n digits after dot
 * @param {Number} src Original number
 * @param {Number} digits Num of digits after dot
 * @returns {Number} New number
 */
Math.formatFloat = function(src, digits) {
	// make sure it is number
	if (isNaN(src)) return src;

	// 10^digits
	var powered = Math.pow(10, digits),
		tmp = src * powered;

	// round tmp
	tmp = Math.round(tmp);

	// get result
	var result = tmp/powered;

	result = result.toString();
	var a = result.indexOf("."),
		b = result.substr(a, 10);
	if (b == result) result = result + '.00';
	if (b.length == 0) result = result + '.00';
	if (b.length == 1) result = result + '00';
	if (b.length == 2) result = result + '0';

	return result;
};

/**
 * Return random number between min and max
 * @param {Number} min
 * @param {Number} max
 * @return {Number} Random number
 */
Math.rand = function(min, max) {
	var argc = arguments.length;
	 if (argc === 0) {
		 min = 0;
		 max = 2147483647;
	 } else if (argc === 1) {
		 throw new Error('Warning: rand() expects exactly 2 parameters, 1 given');
	 }
	 return Math.floor(Math.random() * (max - min + 1)) + min;
};