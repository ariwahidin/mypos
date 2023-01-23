// function number_with_commas(x) {
//     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
// }


// function number_without_commas(x) {
//     return x.replace(/,/g, '');
// }

// function isNumber(evt) {
//     evt = (evt) ? evt : window.event;
//     var charCode = (evt.which) ? evt.which : evt.keyCode;
//     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
//         return false;
//     }
//     return true;
// }

// function isMoney(elem) {
//     var is_float = parseFloat(number_without_commas(elem.value));
//     if (isNaN(is_float)) {
//         elem.value = 0;
//     } else {
//         elem.value = number_with_commas(is_float)
//     }
// }

// function is_number(x) {
//     return Math.round(parseFloat(x.replace(/,/g, '')));
// }




