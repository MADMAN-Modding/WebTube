<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <title>Web YT-DLP</title>
    <link type="text/css" rel="stylesheet" href="css/index.css"/>

</head>
<body>
    <h1>Welcome to Web YT-DLP</h1>
    <!doctype html>
      <link rel="stylesheet" href="node_modules/xterm/css/xterm.css" />
      <script src="node_modules/xterm/lib/xterm.js"></script>
    </head>
    <body>
      <div id="terminal"></div>
      <script>
        var term = new Terminal();
        term.open(document.getElementById('terminal'));
        term.write('Hello from \x1B[1;3;31mxterm.js\x1B[0m $ ')
      </script>
    </body>
  </html>
