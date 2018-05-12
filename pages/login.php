<main role="main" class="container-fluid ">
  <div class="row justify-content-center pb-3 pt-5">
    <h3>
      Login
      <small class="text-muted">/registration</small>
    </h3>
    <br>
  </div>
  <div class="row justify-content-center ">
    <form class="col-lg-8 col-xl-6 col-xs-12" id="login">
      <div class="form-group row">
        <label class="col-sm-2 col-form-label col-form-label-lg" for="nick">Nickname:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control form-control-lg" id="nick" placeholder="e.g. Anastasio">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label col-form-label-lg">Password:</label>
        <div class="col-sm-10">
          <input type="password" class="form-control form-control-lg" id="pwd" placeholder="e.g. 1234 (no, please)">
        </div>
      </div>
      <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
          <div class="form-check">
            <label class="form-check-label">
              <input class="form-check-input bigCheckbox" type="checkbox" id="remember">
              <span class="bigCheckboxLabel">Remember me</span>
            </label>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-6 mb-1">
          <button type="submit" id="reg" class="btn btn-success btn-lg btn-block">Register</button>
        </div>
        <div class="col-sm-6">
          <button type="submit" id="log" class="btn btn-primary btn-lg btn-block">Login</button>
        </div>
      </div>
    </form>
  </div>
  <div class="row justify-content-center">
    <div class="loader" style="display: none"></div>
  </div>
  <div class="row justify-content-center">
    <div class="alert alert-danger col-lg-7 col-xl-5 col-xs-12" style="display: none" id="form-errors"></div>
  </div>
</main>