/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/core/js/custom/documentation/forms/dialer.js":
/*!***********************************************************************!*\
  !*** ./resources/assets/core/js/custom/documentation/forms/dialer.js ***!
  \***********************************************************************/
/***/ (() => {

eval(" // Class definition\n\nvar KTFormsDialerDemos = function () {\n  // Private functions\n  var example1 = function example1(element) {\n    // Dialer container element\n    var dialerElement = document.querySelector(\"#kt_dialer_example_1\"); // Create dialer object and initialize a new instance\n\n    var dialerObject = new KTDialer(dialerElement, {\n      min: 1000,\n      max: 50000,\n      step: 1000,\n      prefix: \"$\",\n      decimals: 2\n    });\n  };\n\n  return {\n    // Public Functions\n    init: function init(element) {\n      example1();\n    }\n  };\n}(); // On document ready\n\n\nKTUtil.onDOMContentLoaded(function () {\n  KTFormsDialerDemos.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2NvcmUvanMvY3VzdG9tL2RvY3VtZW50YXRpb24vZm9ybXMvZGlhbGVyLmpzPzk1MTEiXSwibmFtZXMiOlsiS1RGb3Jtc0RpYWxlckRlbW9zIiwiZXhhbXBsZTEiLCJlbGVtZW50IiwiZGlhbGVyRWxlbWVudCIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvciIsImRpYWxlck9iamVjdCIsIktURGlhbGVyIiwibWluIiwibWF4Iiwic3RlcCIsInByZWZpeCIsImRlY2ltYWxzIiwiaW5pdCIsIktUVXRpbCIsIm9uRE9NQ29udGVudExvYWRlZCJdLCJtYXBwaW5ncyI6IkNBRUE7O0FBQ0EsSUFBSUEsa0JBQWtCLEdBQUcsWUFBVztBQUNoQztBQUNBLE1BQUlDLFFBQVEsR0FBRyxTQUFYQSxRQUFXLENBQVNDLE9BQVQsRUFBa0I7QUFDN0I7QUFDQSxRQUFJQyxhQUFhLEdBQUdDLFFBQVEsQ0FBQ0MsYUFBVCxDQUF1QixzQkFBdkIsQ0FBcEIsQ0FGNkIsQ0FJN0I7O0FBQ0EsUUFBSUMsWUFBWSxHQUFHLElBQUlDLFFBQUosQ0FBYUosYUFBYixFQUE0QjtBQUMzQ0ssU0FBRyxFQUFFLElBRHNDO0FBRTNDQyxTQUFHLEVBQUUsS0FGc0M7QUFHM0NDLFVBQUksRUFBRSxJQUhxQztBQUkzQ0MsWUFBTSxFQUFFLEdBSm1DO0FBSzNDQyxjQUFRLEVBQUU7QUFMaUMsS0FBNUIsQ0FBbkI7QUFPSCxHQVpEOztBQWNBLFNBQU87QUFDSDtBQUNBQyxRQUFJLEVBQUUsY0FBU1gsT0FBVCxFQUFrQjtBQUNwQkQsY0FBUTtBQUNYO0FBSkUsR0FBUDtBQU1ILENBdEJ3QixFQUF6QixDLENBd0JBOzs7QUFDQWEsTUFBTSxDQUFDQyxrQkFBUCxDQUEwQixZQUFXO0FBQ2pDZixvQkFBa0IsQ0FBQ2EsSUFBbkI7QUFDSCxDQUZEIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2Fzc2V0cy9jb3JlL2pzL2N1c3RvbS9kb2N1bWVudGF0aW9uL2Zvcm1zL2RpYWxlci5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xyXG5cclxuLy8gQ2xhc3MgZGVmaW5pdGlvblxyXG52YXIgS1RGb3Jtc0RpYWxlckRlbW9zID0gZnVuY3Rpb24oKSB7XHJcbiAgICAvLyBQcml2YXRlIGZ1bmN0aW9uc1xyXG4gICAgdmFyIGV4YW1wbGUxID0gZnVuY3Rpb24oZWxlbWVudCkge1xyXG4gICAgICAgIC8vIERpYWxlciBjb250YWluZXIgZWxlbWVudFxyXG4gICAgICAgIHZhciBkaWFsZXJFbGVtZW50ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcIiNrdF9kaWFsZXJfZXhhbXBsZV8xXCIpO1xyXG5cclxuICAgICAgICAvLyBDcmVhdGUgZGlhbGVyIG9iamVjdCBhbmQgaW5pdGlhbGl6ZSBhIG5ldyBpbnN0YW5jZVxyXG4gICAgICAgIHZhciBkaWFsZXJPYmplY3QgPSBuZXcgS1REaWFsZXIoZGlhbGVyRWxlbWVudCwge1xyXG4gICAgICAgICAgICBtaW46IDEwMDAsXHJcbiAgICAgICAgICAgIG1heDogNTAwMDAsXHJcbiAgICAgICAgICAgIHN0ZXA6IDEwMDAsXHJcbiAgICAgICAgICAgIHByZWZpeDogXCIkXCIsXHJcbiAgICAgICAgICAgIGRlY2ltYWxzOiAyXHJcbiAgICAgICAgfSk7XHJcbiAgICB9XHJcblxyXG4gICAgcmV0dXJuIHtcclxuICAgICAgICAvLyBQdWJsaWMgRnVuY3Rpb25zXHJcbiAgICAgICAgaW5pdDogZnVuY3Rpb24oZWxlbWVudCkge1xyXG4gICAgICAgICAgICBleGFtcGxlMSgpO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbn0oKTtcclxuXHJcbi8vIE9uIGRvY3VtZW50IHJlYWR5XHJcbktUVXRpbC5vbkRPTUNvbnRlbnRMb2FkZWQoZnVuY3Rpb24oKSB7XHJcbiAgICBLVEZvcm1zRGlhbGVyRGVtb3MuaW5pdCgpO1xyXG59KTtcclxuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/assets/core/js/custom/documentation/forms/dialer.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/core/js/custom/documentation/forms/dialer.js"]();
/******/ 	
/******/ })()
;