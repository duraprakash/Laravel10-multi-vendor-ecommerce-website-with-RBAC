/**
 * Custom pure written javascript for smooth fade-out
 */
// Call the function for each alert
animationWithAlertClose('success-alert');
// animationWithAlertClose('error-alert');
// animationWithAlertClose('warning-alert');
// animationWithAlertClose('info-alert');
// animationWithAlertClose('error-alert');


function animationWithAlertClose(alertId) {
 // fade animation
 window.onload = fadeout;

    function fadeout() {
     var fade = document.getElementById(alertId);

     var intervalID = setInterval(function() {

         if (!fade.style.opacity) {
             fade.style.opacity = 1;
         }

             if (fade.style.opacity > 0) {
             fade.style.opacity -= 0.1;
         } else {
                 clearInterval(intervalID);
         }
         }, 800); //ends
     }

     // close alert box
    document.addEventListener('DOMContentLoaded', function() {
     setTimeout(function() {
         var alert = document.getElementById(alertId);
         var errorAlert = document.getElementById('error-alert');
            // except error-alert close alert box for others automatically
            if (!errorAlert) {
             alert.classList.remove('show');
             var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
             }
         }, 5000);
     }); //ends
 }


/**
 * With the use of jQuery CDN
 */

// // For a smooth fade-out:
// $(document).ready(function() {
//     // $("#success-alert").fadeOut();
//     // $("#success-alert").fadeOut("slow");
//     // $("#success-alert").fadeOut(5000);
//     $("#success-alert").slideUp(5000, function() {
//         $("#success-alert").slideUp(500);
//     });
// });

// // For a smooth slide-up:
// $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
//     $("#success-alert").slideUp(500);
// });

// For a smooth fade-to and slide-up animation after a click:
// $(document).ready(function() {
//     $("#success-alert").hide();
//     $("#myWish").click(function showAlert() {
//         $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
//             $("#success-alert").slideUp(500);
//         });
//     });
// });