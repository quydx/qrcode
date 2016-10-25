$(function() {
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  $(document).ready(function() {
    $(':file').on('fileselect', function(event, numFiles, label) {

      var input = $(this).parents('.input-group').find(':text'),
        log = numFiles > 1 ? numFiles + ' files selected' : label;

      if (input.length) {
        input.val(log);
      } else {
        if (log) alert(log);
      }
    });
  });
});

var QR = $("#QR")[0];
var qrcode = new QRCode(QR);

function makeQR() {
  var input = $("#input").val();
  if (!input) {
    alert("Input a text");
    return;
  }
  qrcode.makeCode(input);
}

function myFunction() {
  window.print();
}
