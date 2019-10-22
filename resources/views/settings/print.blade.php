<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>receipt</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
  <link rel="stylesheet" href="../paper.css">
  <style>
      body.receipt .sheet { width: 58mm; height: 100mm } /* change height as you like */
        @media print { body.receipt { width: 58mm } } /* this line is needed for fixing Chrome's bug */
      @page { size: 58mm 100mm }
  </style>
</head>

<body class="receipt">
  <section class="sheet padding-10mm">
   hello
  </section>
</body>
</html>