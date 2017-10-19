<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="validator.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist\css\signin.css" rel="stylesheet">
        
        <script src="jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="jquery.form.validator.min.js"></script>
        <script src="security.js"></script>
        <script src="file.js"></script>
        
    </head>

    <body>

   <div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">

      <div class="modal-header">
          <h1 class="text-center">USER LOGIN</h1>
      </div>

      <div class="modal-body">
      <form name="form" method="post" action="login.php" class="form-signin" >
        <div class="form-group">
         <label class="col-sm-2 control-label">Username</label>
          <input type="text" name="user" data-validation="required" class="form-control" placeholder="Username">
        </div>

        <div class="form-group">
         <label class="col-sm-2 control-label">Password</label>
          <input type="password" name="pass" data-validation="required" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-lg btn-primary btn-block">เข้าสู่ระบบ</button>
        </div>
      </form>
      </div>
      
  </div>
  </div>
</div>

        <script>
            $.validate({
                modules: 'security, file',
                onModulesLoaded: function () {
                    $('input[name="pass_confirmation"]').displayPasswordStrength();
                }
            });
        </script>
    </body>
</html>
