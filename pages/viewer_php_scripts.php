<?php
    include dirname(__FILE__).'/../include/presentations.php';
    include dirname(__FILE__).'/../include/surveys.php';

    class NoPresentationCodeException extends Exception {}

    $error = "";
    try {
        if(!isset($_GET['id']) || preg_match('/^[0-9a-fA-F]{64}$/', $_GET['id'])!==1) {
            throw new NoPresentationCodeException('No identification code of the presentation or invalid one given.');
        }
        $presentationCode = $_GET['id'];
    
        $presentation = get_presentation_info($presentationCode);
        $polls = get_polls_for_presentation($presentationCode);
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