$( function() {
    $( "#date_of_birth" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        yearRange: "1900:"
      });
} );