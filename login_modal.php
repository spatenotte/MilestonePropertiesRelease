<!-- Modal -->
<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Sign in</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="signin_success.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="emailAddress">Email address</label>
                        <input type="email" class="form-control input-lg" name="user_email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control input-lg" name="user_password" placeholder="Password">
                    </div>
                    <div class="modal-footer">
                        <p>Don't have account ? <a href="#signUpModal"  data-toggle="modal" data-target="#signUpModal" data-dismiss="modal">Sign up here.</a></p>
                        <p>Forgot your password ? <a href="login_forgot.php">Click here</a></p>
                        <input type="submit" name="submit" class="btn btn-primary btn-block btn-lg" value="Submit">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>