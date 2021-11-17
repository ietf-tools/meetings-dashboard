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

/***/ "./resources/assets/extended/js/custom/authentication/password-reset/new-password.js":
/*!*******************************************************************************************!*\
  !*** ./resources/assets/extended/js/custom/authentication/password-reset/new-password.js ***!
  \*******************************************************************************************/
/***/ (() => {

eval(" // Class Definition\n\nvar KTPasswordResetNewPassword = function () {\n  // Elements\n  var form;\n  var submitButton;\n  var validator;\n  var passwordMeter;\n\n  var handleForm = function handleForm(e) {\n    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/\n    validator = FormValidation.formValidation(form, {\n      fields: {\n        'password': {\n          validators: {\n            notEmpty: {\n              message: 'The password is required'\n            },\n            callback: {\n              message: 'Please enter valid password',\n              callback: function callback(input) {\n                if (input.value.length > 0) {\n                  return validatePassword();\n                }\n              }\n            }\n          }\n        },\n        'confirm-password': {\n          validators: {\n            notEmpty: {\n              message: 'The password confirmation is required'\n            },\n            identical: {\n              compare: function compare() {\n                return form.querySelector('[name=\"password\"]').value;\n              },\n              message: 'The password and its confirm are not the same'\n            }\n          }\n        },\n        'toc': {\n          validators: {\n            notEmpty: {\n              message: 'You must accept the terms and conditions'\n            }\n          }\n        }\n      },\n      plugins: {\n        trigger: new FormValidation.plugins.Trigger({\n          event: {\n            password: false\n          }\n        }),\n        bootstrap: new FormValidation.plugins.Bootstrap5({\n          rowSelector: '.fv-row',\n          eleInvalidClass: '',\n          eleValidClass: ''\n        })\n      }\n    });\n    submitButton.addEventListener('click', function (e) {\n      e.preventDefault();\n      validator.revalidateField('password');\n      validator.validate().then(function (status) {\n        if (status == 'Valid') {\n          // Show loading indication\n          submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click\n\n          submitButton.disabled = true; // Simulate ajax request\n\n          axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {\n            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/\n            Swal.fire({\n              text: \"You have successfully reset your password!\",\n              icon: \"success\",\n              buttonsStyling: false,\n              confirmButtonText: \"Ok, got it!\",\n              customClass: {\n                confirmButton: \"btn btn-primary\"\n              }\n            }).then(function (result) {\n              if (result.isConfirmed) {\n                window.location.href = '/login';\n                form.querySelector('[name=\"email\"]').value = \"\";\n                form.querySelector('[name=\"password\"]').value = \"\";\n                form.querySelector('[name=\"confirm-password\"]').value = \"\";\n                passwordMeter.reset(); // reset password meter\n              }\n            });\n          })[\"catch\"](function (error) {\n            var dataMessage = error.response.data.message;\n            var dataErrors = error.response.data.errors;\n\n            for (var errorsKey in dataErrors) {\n              if (!dataErrors.hasOwnProperty(errorsKey)) continue;\n              dataMessage += \"\\r\\n\" + dataErrors[errorsKey];\n            }\n\n            if (error.response) {\n              Swal.fire({\n                text: dataMessage,\n                icon: \"error\",\n                buttonsStyling: false,\n                confirmButtonText: \"Ok, got it!\",\n                customClass: {\n                  confirmButton: \"btn btn-primary\"\n                }\n              });\n            }\n          }).then(function () {\n            // always executed\n            // Hide loading indication\n            submitButton.removeAttribute('data-kt-indicator'); // Enable button\n\n            submitButton.disabled = false;\n          });\n        } else {\n          // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/\n          Swal.fire({\n            text: \"Sorry, looks like there are some errors detected, please try again.\",\n            icon: \"error\",\n            buttonsStyling: false,\n            confirmButtonText: \"Ok, got it!\",\n            customClass: {\n              confirmButton: \"btn btn-primary\"\n            }\n          });\n        }\n      });\n    });\n    form.querySelector('input[name=\"password\"]').addEventListener('input', function () {\n      if (this.value.length > 0) {\n        validator.updateFieldStatus('password', 'NotValidated');\n      }\n    });\n  };\n\n  var validatePassword = function validatePassword() {\n    return passwordMeter.getScore() > 50;\n  }; // Public Functions\n\n\n  return {\n    // public functions\n    init: function init() {\n      form = document.querySelector('#kt_new_password_form');\n      submitButton = document.querySelector('#kt_new_password_submit');\n      passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter=\"true\"]'));\n      handleForm();\n    }\n  };\n}(); // On document ready\n\n\nKTUtil.onDOMContentLoaded(function () {\n  KTPasswordResetNewPassword.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2V4dGVuZGVkL2pzL2N1c3RvbS9hdXRoZW50aWNhdGlvbi9wYXNzd29yZC1yZXNldC9uZXctcGFzc3dvcmQuanM/NmE4NyJdLCJuYW1lcyI6WyJLVFBhc3N3b3JkUmVzZXROZXdQYXNzd29yZCIsImZvcm0iLCJzdWJtaXRCdXR0b24iLCJ2YWxpZGF0b3IiLCJwYXNzd29yZE1ldGVyIiwiaGFuZGxlRm9ybSIsImUiLCJGb3JtVmFsaWRhdGlvbiIsImZvcm1WYWxpZGF0aW9uIiwiZmllbGRzIiwidmFsaWRhdG9ycyIsIm5vdEVtcHR5IiwibWVzc2FnZSIsImNhbGxiYWNrIiwiaW5wdXQiLCJ2YWx1ZSIsImxlbmd0aCIsInZhbGlkYXRlUGFzc3dvcmQiLCJpZGVudGljYWwiLCJjb21wYXJlIiwicXVlcnlTZWxlY3RvciIsInBsdWdpbnMiLCJ0cmlnZ2VyIiwiVHJpZ2dlciIsImV2ZW50IiwicGFzc3dvcmQiLCJib290c3RyYXAiLCJCb290c3RyYXA1Iiwicm93U2VsZWN0b3IiLCJlbGVJbnZhbGlkQ2xhc3MiLCJlbGVWYWxpZENsYXNzIiwiYWRkRXZlbnRMaXN0ZW5lciIsInByZXZlbnREZWZhdWx0IiwicmV2YWxpZGF0ZUZpZWxkIiwidmFsaWRhdGUiLCJ0aGVuIiwic3RhdHVzIiwic2V0QXR0cmlidXRlIiwiZGlzYWJsZWQiLCJheGlvcyIsInBvc3QiLCJjbG9zZXN0IiwiZ2V0QXR0cmlidXRlIiwiRm9ybURhdGEiLCJyZXNwb25zZSIsIlN3YWwiLCJmaXJlIiwidGV4dCIsImljb24iLCJidXR0b25zU3R5bGluZyIsImNvbmZpcm1CdXR0b25UZXh0IiwiY3VzdG9tQ2xhc3MiLCJjb25maXJtQnV0dG9uIiwicmVzdWx0IiwiaXNDb25maXJtZWQiLCJ3aW5kb3ciLCJsb2NhdGlvbiIsImhyZWYiLCJyZXNldCIsImVycm9yIiwiZGF0YU1lc3NhZ2UiLCJkYXRhIiwiZGF0YUVycm9ycyIsImVycm9ycyIsImVycm9yc0tleSIsImhhc093blByb3BlcnR5IiwicmVtb3ZlQXR0cmlidXRlIiwidXBkYXRlRmllbGRTdGF0dXMiLCJnZXRTY29yZSIsImluaXQiLCJkb2N1bWVudCIsIktUUGFzc3dvcmRNZXRlciIsImdldEluc3RhbmNlIiwiS1RVdGlsIiwib25ET01Db250ZW50TG9hZGVkIl0sIm1hcHBpbmdzIjoiQ0FFQTs7QUFDQSxJQUFJQSwwQkFBMEIsR0FBRyxZQUFZO0FBQ3pDO0FBQ0EsTUFBSUMsSUFBSjtBQUNBLE1BQUlDLFlBQUo7QUFDQSxNQUFJQyxTQUFKO0FBQ0EsTUFBSUMsYUFBSjs7QUFFQSxNQUFJQyxVQUFVLEdBQUcsU0FBYkEsVUFBYSxDQUFVQyxDQUFWLEVBQWE7QUFDMUI7QUFDQUgsYUFBUyxHQUFHSSxjQUFjLENBQUNDLGNBQWYsQ0FDUlAsSUFEUSxFQUVSO0FBQ0lRLFlBQU0sRUFBRTtBQUNKLG9CQUFZO0FBQ1JDLG9CQUFVLEVBQUU7QUFDUkMsb0JBQVEsRUFBRTtBQUNOQyxxQkFBTyxFQUFFO0FBREgsYUFERjtBQUlSQyxvQkFBUSxFQUFFO0FBQ05ELHFCQUFPLEVBQUUsNkJBREg7QUFFTkMsc0JBQVEsRUFBRSxrQkFBVUMsS0FBVixFQUFpQjtBQUN2QixvQkFBSUEsS0FBSyxDQUFDQyxLQUFOLENBQVlDLE1BQVosR0FBcUIsQ0FBekIsRUFBNEI7QUFDeEIseUJBQU9DLGdCQUFnQixFQUF2QjtBQUNIO0FBQ0o7QUFOSztBQUpGO0FBREosU0FEUjtBQWdCSiw0QkFBb0I7QUFDaEJQLG9CQUFVLEVBQUU7QUFDUkMsb0JBQVEsRUFBRTtBQUNOQyxxQkFBTyxFQUFFO0FBREgsYUFERjtBQUlSTSxxQkFBUyxFQUFFO0FBQ1BDLHFCQUFPLEVBQUUsbUJBQVk7QUFDakIsdUJBQU9sQixJQUFJLENBQUNtQixhQUFMLENBQW1CLG1CQUFuQixFQUF3Q0wsS0FBL0M7QUFDSCxlQUhNO0FBSVBILHFCQUFPLEVBQUU7QUFKRjtBQUpIO0FBREksU0FoQmhCO0FBNkJKLGVBQU87QUFDSEYsb0JBQVUsRUFB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Q0FBdUIseUJBQXZCLENBQWY7QUFDQWhCLG1CQUFhLEdBQUdtRSxlQUFlLENBQUNDLFdBQWhCLENBQTRCdkUsSUFBSSxDQUFDbUIsYUFBTCxDQUFtQixpQ0FBbkIsQ0FBNUIsQ0FBaEI7QUFFQWYsZ0JBQVU7QUFDYjtBQVJFLEdBQVA7QUFVSCxDQXJLZ0MsRUFBakMsQyxDQXVLQTs7O0FBQ0FvRSxNQUFNLENBQUNDLGtCQUFQLENBQTBCLFlBQVk7QUFDbEMxRSw0QkFBMEIsQ0FBQ3FFLElBQTNCO0FBQ0gsQ0FGRCIsImZpbGUiOiIuL3Jlc291cmNlcy9hc3NldHMvZXh0ZW5kZWQvanMvY3VzdG9tL2F1dGhlbnRpY2F0aW9uL3Bhc3N3b3JkLXJlc2V0L25ldy1wYXNzd29yZC5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xuXG4vLyBDbGFzcyBEZWZpbml0aW9uXG52YXIgS1RQYXNzd29yZFJlc2V0TmV3UGFzc3dvcmQgPSBmdW5jdGlvbiAoKSB7XG4gICAgLy8gRWxlbWVudHNcbiAgICB2YXIgZm9ybTtcbiAgICB2YXIgc3VibWl0QnV0dG9uO1xuICAgIHZhciB2YWxpZGF0b3I7XG4gICAgdmFyIHBhc3N3b3JkTWV0ZXI7XG5cbiAgICB2YXIgaGFuZGxlRm9ybSA9IGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIC8vIEluaXQgZm9ybSB2YWxpZGF0aW9uIHJ1bGVzLiBGb3IgbW9yZSBpbmZvIGNoZWNrIHRoZSBGb3JtVmFsaWRhdGlvbiBwbHVnaW4ncyBvZmZpY2lhbCBkb2N1bWVudGF0aW9uOmh0dHBzOi8vZm9ybXZhbGlkYXRpb24uaW8vXG4gICAgICAgIHZhbGlkYXRvciA9IEZvcm1WYWxpZGF0aW9uLmZvcm1WYWxpZGF0aW9uKFxuICAgICAgICAgICAgZm9ybSxcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBmaWVsZHM6IHtcbiAgICAgICAgICAgICAgICAgICAgJ3Bhc3N3b3JkJzoge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsaWRhdG9yczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vdEVtcHR5OiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2U6ICdUaGUgcGFzc3dvcmQgaXMgcmVxdWlyZWQnXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYWxsYmFjazoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBtZXNzYWdlOiAnUGxlYXNlIGVudGVyIHZhbGlkIHBhc3N3b3JkJyxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FsbGJhY2s6IGZ1bmN0aW9uIChpbnB1dCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKGlucHV0LnZhbHVlLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gdmFsaWRhdGVQYXNzd29yZCgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAnY29uZmlybS1wYXNzd29yZCc6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbGlkYXRvcnM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBub3RFbXB0eToge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBtZXNzYWdlOiAnVGhlIHBhc3N3b3JkIGNvbmZpcm1hdGlvbiBpcyByZXF1aXJlZCdcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlkZW50aWNhbDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb21wYXJlOiBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZm9ybS5xdWVyeVNlbGVjdG9yKCdbbmFtZT1cInBhc3N3b3JkXCJdJykudmFsdWU7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2U6ICdUaGUgcGFzc3dvcmQgYW5kIGl0cyBjb25maXJtIGFyZSBub3QgdGhlIHNhbWUnXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAndG9jJzoge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsaWRhdG9yczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vdEVtcHR5OiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2U6ICdZb3UgbXVzdCBhY2NlcHQgdGhlIHRlcm1zIGFuZCBjb25kaXRpb25zJ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgcGx1Z2luczoge1xuICAgICAgICAgICAgICAgICAgICB0cmlnZ2VyOiBuZXcgRm9ybVZhbGlkYXRpb24ucGx1Z2lucy5UcmlnZ2VyKHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGV2ZW50OiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgcGFzc3dvcmQ6IGZhbHNlXG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgICAgICAgICBib290c3RyYXA6IG5ldyBGb3JtVmFsaWRhdGlvbi5wbHVnaW5zLkJvb3RzdHJhcDUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgcm93U2VsZWN0b3I6ICcuZnYtcm93JyxcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsZUludmFsaWRDbGFzczogJycsXG4gICAgICAgICAgICAgICAgICAgICAgICBlbGVWYWxpZENsYXNzOiAnJ1xuICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgKTtcblxuICAgICAgICBzdWJtaXRCdXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgICAgICB2YWxpZGF0b3IucmV2YWxpZGF0ZUZpZWxkKCdwYXNzd29yZCcpO1xuXG4gICAgICAgICAgICB2YWxpZGF0b3IudmFsaWRhdGUoKS50aGVuKGZ1bmN0aW9uIChzdGF0dXMpIHtcbiAgICAgICAgICAgICAgICBpZiAoc3RhdHVzID09ICdWYWxpZCcpIHtcbiAgICAgICAgICAgICAgICAgICAgLy8gU2hvdyBsb2FkaW5nIGluZGljYXRpb25cbiAgICAgICAgICAgICAgICAgICAgc3VibWl0QnV0dG9uLnNldEF0dHJpYnV0ZSgnZGF0YS1rdC1pbmRpY2F0b3InLCAnb24nKTtcblxuICAgICAgICAgICAgICAgICAgICAvLyBEaXNhYmxlIGJ1dHRvbiB0byBhdm9pZCBtdWx0aXBsZSBjbGlja1xuICAgICAgICAgICAgICAgICAgICBzdWJtaXRCdXR0b24uZGlzYWJsZWQgPSB0cnVlO1xuXG4gICAgICAgICAgICAgICAgICAgIC8vIFNpbXVsYXRlIGFqYXggcmVxdWVzdFxuICAgICAgICAgICAgICAgICAgICBheGlvcy5wb3N0KHN1Ym1pdEJ1dHRvbi5jbG9zZXN0KCdmb3JtJykuZ2V0QXR0cmlidXRlKCdhY3Rpb24nKSwgbmV3IEZvcm1EYXRhKGZvcm0pKVxuICAgICAgICAgICAgICAgICAgICAgICAgLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gU2hvdyBtZXNzYWdlIHBvcHVwLiBGb3IgbW9yZSBpbmZvIGNoZWNrIHRoZSBwbHVnaW4ncyBvZmZpY2lhbCBkb2N1bWVudGF0aW9uOiBodHRwczovL3N3ZWV0YWxlcnQyLmdpdGh1Yi5pby9cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBTd2FsLmZpcmUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0ZXh0OiBcIllvdSBoYXZlIHN1Y2Nlc3NmdWxseSByZXNldCB5b3VyIHBhc3N3b3JkIVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpY29uOiBcInN1Y2Nlc3NcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYnV0dG9uc1N0eWxpbmc6IGZhbHNlLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uVGV4dDogXCJPaywgZ290IGl0IVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjdXN0b21DbGFzczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY29uZmlybUJ1dHRvbjogXCJidG4gYnRuLXByaW1hcnlcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSkudGhlbihmdW5jdGlvbiAocmVzdWx0KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChyZXN1bHQuaXNDb25maXJtZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gJy9sb2dpbic7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3JtLnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPVwiZW1haWxcIl0nKS52YWx1ZSA9IFwiXCI7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3JtLnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPVwicGFzc3dvcmRcIl0nKS52YWx1ZSA9IFwiXCI7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3JtLnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPVwiY29uZmlybS1wYXNzd29yZFwiXScpLnZhbHVlID0gXCJcIjtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHBhc3N3b3JkTWV0ZXIucmVzZXQoKTsgIC8vIHJlc2V0IHBhc3N3b3JkIG1ldGVyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAuY2F0Y2goZnVuY3Rpb24gKGVycm9yKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbGV0IGRhdGFNZXNzYWdlID0gZXJyb3IucmVzcG9uc2UuZGF0YS5tZXNzYWdlO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGxldCBkYXRhRXJyb3JzID0gZXJyb3IucmVzcG9uc2UuZGF0YS5lcnJvcnM7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3IgKGNvbnN0IGVycm9yc0tleSBpbiBkYXRhRXJyb3JzKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICghZGF0YUVycm9ycy5oYXNPd25Qcm9wZXJ0eShlcnJvcnNLZXkpKSBjb250aW51ZTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZGF0YU1lc3NhZ2UgKz0gXCJcXHJcXG5cIiArIGRhdGFFcnJvcnNbZXJyb3JzS2V5XTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoZXJyb3IucmVzcG9uc2UpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgU3dhbC5maXJlKHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHQ6IGRhdGFNZXNzYWdlLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWNvbjogXCJlcnJvclwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYnV0dG9uc1N0eWxpbmc6IGZhbHNlLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY29uZmlybUJ1dHRvblRleHQ6IFwiT2ssIGdvdCBpdCFcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGN1c3RvbUNsYXNzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY29uZmlybUJ1dHRvbjogXCJidG4gYnRuLXByaW1hcnlcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgICAgLnRoZW4oZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vIGFsd2F5cyBleGVjdXRlZFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vIEhpZGUgbG9hZGluZyBpbmRpY2F0aW9uXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc3VibWl0QnV0dG9uLnJlbW92ZUF0dHJpYnV0ZSgnZGF0YS1rdC1pbmRpY2F0b3InKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vIEVuYWJsZSBidXR0b25cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdWJtaXRCdXR0b24uZGlzYWJsZWQgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIC8vIFNob3cgZXJyb3IgcG9wdXAuIEZvciBtb3JlIGluZm8gY2hlY2sgdGhlIHBsdWdpbidzIG9mZmljaWFsIGRvY3VtZW50YXRpb246IGh0dHBzOi8vc3dlZXRhbGVydDIuZ2l0aHViLmlvL1xuICAgICAgICAgICAgICAgICAgICBTd2FsLmZpcmUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgdGV4dDogXCJTb3JyeSwgbG9va3MgbGlrZSB0aGVyZSBhcmUgc29tZSBlcnJvcnMgZGV0ZWN0ZWQsIHBsZWFzZSB0cnkgYWdhaW4uXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICBpY29uOiBcImVycm9yXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICBidXR0b25zU3R5bGluZzogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uVGV4dDogXCJPaywgZ290IGl0IVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgY3VzdG9tQ2xhc3M6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uOiBcImJ0biBidG4tcHJpbWFyeVwiXG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9KTtcblxuICAgICAgICBmb3JtLnF1ZXJ5U2VsZWN0b3IoJ2lucHV0W25hbWU9XCJwYXNzd29yZFwiXScpLmFkZEV2ZW50TGlzdGVuZXIoJ2lucHV0JywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgaWYgKHRoaXMudmFsdWUubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgICAgIHZhbGlkYXRvci51cGRhdGVGaWVsZFN0YXR1cygncGFzc3dvcmQnLCAnTm90VmFsaWRhdGVkJyk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIHZhciB2YWxpZGF0ZVBhc3N3b3JkID0gZnVuY3Rpb24gKCkge1xuICAgICAgICByZXR1cm4gKHBhc3N3b3JkTWV0ZXIuZ2V0U2NvcmUoKSA+IDUwKTtcbiAgICB9XG5cbiAgICAvLyBQdWJsaWMgRnVuY3Rpb25zXG4gICAgcmV0dXJuIHtcbiAgICAgICAgLy8gcHVibGljIGZ1bmN0aW9uc1xuICAgICAgICBpbml0OiBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBmb3JtID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2t0X25ld19wYXNzd29yZF9mb3JtJyk7XG4gICAgICAgICAgICBzdWJtaXRCdXR0b24gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcja3RfbmV3X3Bhc3N3b3JkX3N1Ym1pdCcpO1xuICAgICAgICAgICAgcGFzc3dvcmRNZXRlciA9IEtUUGFzc3dvcmRNZXRlci5nZXRJbnN0YW5jZShmb3JtLnF1ZXJ5U2VsZWN0b3IoJ1tkYXRhLWt0LXBhc3N3b3JkLW1ldGVyPVwidHJ1ZVwiXScpKTtcblxuICAgICAgICAgICAgaGFuZGxlRm9ybSgpO1xuICAgICAgICB9XG4gICAgfTtcbn0oKTtcblxuLy8gT24gZG9jdW1lbnQgcmVhZHlcbktUVXRpbC5vbkRPTUNvbnRlbnRMb2FkZWQoZnVuY3Rpb24gKCkge1xuICAgIEtUUGFzc3dvcmRSZXNldE5ld1Bhc3N3b3JkLmluaXQoKTtcbn0pO1xuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/assets/extended/js/custom/authentication/password-reset/new-password.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/extended/js/custom/authentication/password-reset/new-password.js"]();
/******/ 	
/******/ })()
;