<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading" align="middle">
                    <h1 class="panel-title">You must change your password!</h1>
                    <h6>(Note: All passwords are securely stored as encrypted hashes and can't be read by humans)</h6>
                </div>
                <div class="panel-body">
                    <form role="form" name="changepasswordform" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="New password" name="password" type="password" minlength="8" pattern="(.*[0-9].*)" oninvalid="this.setCustomValidity('Password does not meet requirements')" oninput="setCustomValidity('')" required>
                            </div>

                            <input type="submit" name="hiddensubmit" style="display: none;" />

                            <input type="button" name="changepassword" class="btn btn-lg btn-success btn-block" value="Change password" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
