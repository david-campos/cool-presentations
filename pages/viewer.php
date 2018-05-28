<main role="main" class="container-fluid" id='window'>

<?php if($presentation === null): ?>
    <div class="row justify-content-center">
        <div class="alert alert-danger col-lg-7 col-xl-5 col-xs-12">
            <?php echo $error ?>
        </div>
    </div>
<?php else: ?>
    <div class="row justify-content-center">
        <div id="over-slides"></div>
        <div class="col text-center">
            <canvas id="the-canvas"></canvas>
        </div>
    </div>

    <div class="row justify-content-center">
        <button class="btn-primary" id="prev">Previous</button> &nbsp;
        <button class="btn-primary" id="next">Next</button>
        &nbsp; &nbsp;
        <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
    </div>
    
    <div id="passwordModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Password</h4>
            </div>
            <div class="modal-body">
            <div class="alert alert-danger" style="display:none" id="pass_dialog_fail" role="alert">
                Incorrect code.
            </div>
            <div class="loader" style="margin: auto; display: none"></div>
            <form class="form-horizontal" id="pwd_form">             
                <div class="form-group">
                </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                        <input type="password" class="form-control" name="pwd_field" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger" name="back" href=".">Back</a>
                    <button type="button" class="btn btn-primary" name="send_pwd">Send</button> 
                </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Survey template -->
    <script type="text/html" id="survey-template">
      <form class="survey">
        <div class="row">
            <h4>%%QUESTION%%</h4>
        </div>
        <div class="row">
            <ul class="list-group">
                %%ANSWERS%%
            </ul>
        </div>
        <div class="row" id="vote-button">
            <button type="button" class="btn btn-success btn-block">Votar</button>
        </div>
      </form>
    </script>
    <!-- Survey answer template -->
    <script type="text/html" id="survey-answer-template">
            <li data-value="%%VALUE%%" class="list-group-item">%%TEXT%%</li>
    </script>
    <!-- Voted survey answer template -->
    <script type="text/html" id="voted-survey-answer-template">
            <li data-value="%%VALUE%%" class="list-group-item">
                %%TEXT%% <br>
                <span class="votes">%%VOTES%%</span> votes
                <div class="progress bg-dark">
                    <div class="progress-bar" role="progressbar" aria-valuenow="%%PERCENTAGE%%" aria-valuemin="0" aria-valuemax="100">%%PERCENTAGE%%%</div>
                </div>
            </li>
    </script>
<?php endif; ?>

</main>