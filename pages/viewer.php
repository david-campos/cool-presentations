<?php
    include dirname(__FILE__).'/viewer_php_functions.php';
    $error = "";
    try {
        $presentation = get_presentation_info();
        if ($presentation['access_code'] == NULL)
        {
            ?>
                <script type="text/javascript">
                    function send_pwd() {
                        var pass = $("input[name='pwd_field']").val()
                        alert(pass)
                    }

                    function return_pwd() {
                        location.replace(document.referrer)
                    }
                </script>

                <body onLoad="$('#passwordModal').modal('show');">
                <div id="passwordModal" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" data-show="true">
                    <div class="modal-dialog" role="document">
                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Password</h4>
                        </div>
                        <div class="modal-body">
                        <form class="form-horizontal" action="" method="post">             
                            <div class="form-group">
                            </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                    <input type="password" class="form-control" name="pwd_field" placeholder="Enter password">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default" name="send_pwd">Enviar</button> 
                            <button type="button" class="btn btn-default" onClick=return_pwd()>Cerrar</button>
                        </div>
                        </div>
                        </form>
                    </div>
                </div>
                </body>
            <?php
        }   
        if (isset($_POST['send_pwd'])) {
            $input = $_POST['pwd_field'];
            echo "Pass: " . $input;
        }
        $polls = get_polls_for_presentation($presentation['id_code']);
    } catch (NoPresentationCodeException $npce) {
        $presentation = null;
        $error = 'No presentation code given.';
    } catch (PresentationNotFoundException $pnfe) {
        $presentation = null;
        $error = 'Sorry, the presentation you are looking for couldn\'t be found.';
    } catch (Exception $e) {
        $presentation = null;
        $error = 'Sorry, an unknown error has ocurred: '.$e->getMessage();
    } finally {
        $mysqli->close();
    }
?>
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
        <div class="row">
            <button type="button" class="btn btn-success btn-block">Votar</button>
        </div>
      </form>
    </script>
    <!-- Survey answer template -->
    <script type="text/html" id="survey-answer-template">
            <li data-value="%%VALUE%%" class="list-group-item">%%TEXT%%</li>
    </script>
<?php endif; ?>

</main>