<?php if($presentation !== null): ?>
    <?php
        $jsonPolls = json_encode($polls, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if($jsonPolls === false) {
            $jsonPolls = json_encode(array("jsonError", json_last_error_msg()));
        }
        $jsonPres = json_encode($presentation, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if($jsonPres === false) {
            $jsonPres = json_encode(array("jsonError", json_last_error_msg()));
        }
        
    ?>
    <script src="js/sha.js"></script>
    <script src="js/presentationControl.js"></script>
    <script language="JavaScript" type="text/javascript">
        const PRES = <?php echo $jsonPres; ?>;
        const SURVEYS = <?php echo $jsonPolls; ?>;
        const PRES_CODE = "<?php echo $presentation['id_code']; ?>";
    </script>
<?php endif; ?>