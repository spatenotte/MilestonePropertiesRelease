
<!-- Modal -->
<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Sign up</h4>
          </div>
          <div class="modal-body">
            <form role="form" action="new_user_created.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <input type="email" name="user_email" class="form-control input-lg" placeholder="Enter email">
              </div>
              <div class="form-group">
                <input type="password" class="form-control input-lg" placeholder="Password">
              </div>
              <div class="form-group">
                <input type="password" name="user_password" class="form-control input-lg" placeholder="Confirm Password">
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="agree"> Agree to our <a href="#termsModal" data-toggle="modal" data-target="#termsModal">terms and conditions</a>
                </label>
              </div>
                <div class="modal-footer">
            <p>Already have account ? <a href="#logInModal" data-toggle="modal" data-target="#logInModal" data-dismiss="modal">Sign in here.</a></p>
            <input type="submit" name="submit" class="btn btn-primary btn-block btn-lg" value="Submit">
          </div>
            </form>
          </div>
          
        </div>
      </div>
</div>