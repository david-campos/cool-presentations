<?php
    include dirname(__FILE__).'/viewer_php_functions.php';
    $error = "";
    try {
        $presentation = get_presentation_info();
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