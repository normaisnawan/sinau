/**
 * jQuery Form Validator Module: Toggle Disabled
 * ------------------------------------------
 * Created by Victor Jonsson <http://www.victorjonsson.se>
 *
 * This module will take care of disabling/enabling submit buttons
 * in forms, depending on if the inputs of the form is valid or not.
 *
 * @website http://formvalidator.net/
 * @license MIT
 */
(function($, window, undefined) {

  'use strict';

  // Function that can enable/disable form
  var toggleFormState = function($form, state) {
      if( state === 'disabled' ) {
        $form.find('*[type="submit"]')
          .addClass('disabled')
          .attr('disabled', 'disabled');
      } else {
        $form.find('*[type="submit"]')
          .removeClass('disabled')
          .removeAttr('disabled');
      }
    },
    isCheckingIfFormValid = false;

  $.formUtils.$win.bind('validatorsLoaded formValidationSetup', function(evt, $forms, conf) {

      var $formsToDisable = conf.disabledFormFilter ? $forms.filter(conf.disabledFormFilter) : $forms,
          showErrorDialogs = conf.showErrorDialogs === undefined || conf.showErrorDialogs,
          afterValidationCallback = function(evt, result, evtContext) {
            var $this = $(this);
            if (evtContext.indexOf('blur') > -1) {
              $this.unbind('afterValidation', afterValidationCallback);
            } else {
              if (result.isValid) {
                $this.unbind('afterValidation', afterValidationCallback);
              } else if (!$this.valAttr('have-been-blurred')) {
                result.shouldChangeDisplay = false;
              }
            }
          };

      // Toggle form state depending on if it has only valid inputs or not.
      $formsToDisable
        .addClass(showErrorDialogs ? 'disabled-with-errors' : 'disabled-without-errors')
        .on('reset', function() {
          toggleFormState($(this), 'disabled');
        })
        .find('*[data-validation]')
          .valAttr('event','keyup change')
          .on('validation', function(evt, valid) {
            if( !isCheckingIfFormValid ) {
              isCheckingIfFormValid = true;
              var $form = $(this).closest('form');
              if( valid && $form.isValid(conf.language, conf, false) ) {
                toggleFormState($form, 'enabled');
              } else {
                toggleFormState($form, 'disabled');
              }
              isCheckingIfFormValid = false;
            }
          })
          .on('afterValidation', afterValidationCallback)
          .on('blur', function() {
            $(this).valAttr('have-been-blurred', 1);
          });


      // Make all inputs validated on keyup, require validateOnEvent in validation config
      toggleFormState($formsToDisable, 'disabled');

      $formsToDisable.validateOnEvent(conf.language, conf);

  })
  .on('validationErrorDisplay', function(evt, $input, $elem) {
      if ( $input.closest('form').hasClass('disabled-without-errors') ) {
        $elem.hide();
      }
  });

})(jQuery, window);
