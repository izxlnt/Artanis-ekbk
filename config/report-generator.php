<?php

return [
    'flush' => false,
    'pdfLibrary' => 'dompdf' // snappy, dompdf — dompdf is pure-PHP (already used elsewhere in
    // this app for Borang PDFs) and needs no external binary, unlike snappy/wkhtmltopdf which
    // requires installing a separate binary on the server. Safer default for shared hosting.
];
