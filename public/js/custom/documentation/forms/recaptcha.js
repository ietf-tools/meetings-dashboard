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

/***/ "./resources/assets/core/js/custom/documentation/forms/recaptcha.js":
/*!**************************************************************************!*\
  !*** ./resources/assets/core/js/custom/documentation/forms/recaptcha.js ***!
  \**************************************************************************/
/***/ (() => {

eval(" // Class definition\n\nvar KTFormsGoogleRecaptchaDemos = function () {\n  // Private functions\n  var example = function example(element) {\n    document.querySelector(\"#kt_form_submit_button\").addEventListener(\"click\", function (e) {\n      e.preventDefault();\n      grecaptcha.ready(function () {\n        if (grecaptcha.getResponse() === \"\") {\n          alert(\"Please validate the Google reCaptcha.\");\n        } else {\n          alert(\"Successful validation! Now you can submit this form to your server side processing.\");\n        }\n      });\n    });\n  };\n\n  return {\n    // Public Functions\n    init: function init(element) {\n      example();\n    }\n  };\n}(); // On document ready\n\n\nKTUtil.onDOMContentLoaded(function () {\n  KTFormsGoogleRecaptchaDemos.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2NvcmUvanMvY3VzdG9tL2RvY3VtZW50YXRpb24vZm9ybXMvcmVjYXB0Y2hhLmpzPzU2OWUiXSwibmFtZXMiOlsiS1RGb3Jtc0dvb2dsZVJlY2FwdGNoYURlbW9zIiwiZXhhbXBsZSIsImVsZW1lbnQiLCJkb2N1bWVudCIsInF1ZXJ5U2VsZWN0b3IiLCJhZGRFdmVudExpc3RlbmVyIiwiZSIsInByZXZlbnREZWZhdWx0IiwiZ3JlY2FwdGNoYSIsInJlYWR5IiwiZ2V0UmVzcG9uc2UiLCJhbGVydCIsImluaXQiLCJLVFV0aWwiLCJvbkRPTUNvbnRlbnRMb2FkZWQiXSwibWFwcGluZ3MiOiJDQUVBOztBQUNBLElBQUlBLDJCQUEyQixHQUFHLFlBQVk7QUFDMUM7QUFDQSxNQUFJQyxPQUFPLEdBQUcsU0FBVkEsT0FBVSxDQUFVQyxPQUFWLEVBQW1CO0FBQzdCQyxZQUFRLENBQUNDLGFBQVQsQ0FBdUIsd0JBQXZCLEVBQWlEQyxnQkFBakQsQ0FBa0UsT0FBbEUsRUFBMkUsVUFBVUMsQ0FBVixFQUFhO0FBQ3BGQSxPQUFDLENBQUNDLGNBQUY7QUFFQUMsZ0JBQVUsQ0FBQ0MsS0FBWCxDQUFpQixZQUFZO0FBQ3pCLFlBQUlELFVBQVUsQ0FBQ0UsV0FBWCxPQUE2QixFQUFqQyxFQUFxQztBQUNqQ0MsZUFBSyxDQUFDLHVDQUFELENBQUw7QUFDSCxTQUZELE1BRU87QUFDSEEsZUFBSyxDQUFDLHFGQUFELENBQUw7QUFDSDtBQUNKLE9BTkQ7QUFPSCxLQVZEO0FBV0gsR0FaRDs7QUFjQSxTQUFPO0FBQ0g7QUFDQUMsUUFBSSxFQUFFLGNBQVVWLE9BQVYsRUFBbUI7QUFDckJELGFBQU87QUFDVjtBQUpFLEdBQVA7QUFNSCxDQXRCaUMsRUFBbEMsQyxDQXdCQTs7O0FBQ0FZLE1BQU0sQ0FBQ0Msa0JBQVAsQ0FBMEIsWUFBWTtBQUNsQ2QsNkJBQTJCLENBQUNZLElBQTVCO0FBQ0gsQ0FGRCIsImZpbGUiOiIuL3Jlc291cmNlcy9hc3NldHMvY29yZS9qcy9jdXN0b20vZG9jdW1lbnRhdGlvbi9mb3Jtcy9yZWNhcHRjaGEuanMuanMiLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcclxuXHJcbi8vIENsYXNzIGRlZmluaXRpb25cclxudmFyIEtURm9ybXNHb29nbGVSZWNhcHRjaGFEZW1vcyA9IGZ1bmN0aW9uICgpIHtcclxuICAgIC8vIFByaXZhdGUgZnVuY3Rpb25zXHJcbiAgICB2YXIgZXhhbXBsZSA9IGZ1bmN0aW9uIChlbGVtZW50KSB7XHJcbiAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcIiNrdF9mb3JtX3N1Ym1pdF9idXR0b25cIikuYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuXHJcbiAgICAgICAgICAgIGdyZWNhcHRjaGEucmVhZHkoZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgaWYgKGdyZWNhcHRjaGEuZ2V0UmVzcG9uc2UoKSA9PT0gXCJcIikge1xyXG4gICAgICAgICAgICAgICAgICAgIGFsZXJ0KFwiUGxlYXNlIHZhbGlkYXRlIHRoZSBHb29nbGUgcmVDYXB0Y2hhLlwiKTtcclxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgYWxlcnQoXCJTdWNjZXNzZnVsIHZhbGlkYXRpb24hIE5vdyB5b3UgY2FuIHN1Ym1pdCB0aGlzIGZvcm0gdG8geW91ciBzZXJ2ZXIgc2lkZSBwcm9jZXNzaW5nLlwiKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfSk7XHJcbiAgICB9XHJcblxyXG4gICAgcmV0dXJuIHtcclxuICAgICAgICAvLyBQdWJsaWMgRnVuY3Rpb25zXHJcbiAgICAgICAgaW5pdDogZnVuY3Rpb24gKGVsZW1lbnQpIHtcclxuICAgICAgICAgICAgZXhhbXBsZSgpO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbn0oKTtcclxuXHJcbi8vIE9uIGRvY3VtZW50IHJlYWR5XHJcbktUVXRpbC5vbkRPTUNvbnRlbnRMb2FkZWQoZnVuY3Rpb24gKCkge1xyXG4gICAgS1RGb3Jtc0dvb2dsZVJlY2FwdGNoYURlbW9zLmluaXQoKTtcclxufSk7XHJcbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/assets/core/js/custom/documentation/forms/recaptcha.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/core/js/custom/documentation/forms/recaptcha.js"]();
/******/ 	
/******/ })()
;