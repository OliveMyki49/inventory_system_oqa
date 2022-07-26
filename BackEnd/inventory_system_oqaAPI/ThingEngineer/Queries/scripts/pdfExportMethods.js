// START: browser print (native functionality, right-click >> Print (or Command + P))
function downloadPDFWithBrowserPrint() {
  window.print();
}
document.querySelector('#browserPrint').addEventListener('click', downloadPDFWithBrowserPrint);
// END: browser print
