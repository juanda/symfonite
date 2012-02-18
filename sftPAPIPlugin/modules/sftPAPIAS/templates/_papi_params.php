<!-- Parámetros PAPI -->
<?php foreach ($sf_request->getGetParameters() as $k => $v): ?>
    <input type="hidden" name="<?php echo $k ?>" value="<?php echo $v ?>" />
<?php endforeach; ?>
<!-- Fin Parámetros PAPI -->
