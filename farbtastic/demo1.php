
<html>
<head>
 <title>Farbtastic</title>
 <script type="text/javascript" src="jquery.js"></script>
 <script type="text/javascript" src="farbtastic.js"></script>
 <link rel="stylesheet" href="farbtastic.css" type="text/css" />
 <script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $('#demo').hide();
    $('#picker').farbtastic('#color');
  });
 </script>
</head>

<body>

<form action="" style="width: 400px;">
  <div class="form-item"><label for="color">Color:</label><input type="text" id="color" name="color" value="#123456" /></div><div id="picker"></div>
</form>

</body>
</html>
