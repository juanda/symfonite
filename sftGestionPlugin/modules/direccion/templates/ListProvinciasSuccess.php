<?php echo $widgetProvincia->getRawValue()->render('provincia');  ?>
<script>
    $('#provincia').change(function(){
        jQuery.ajax({
            type:'POST',
            dataType:'html',
            data:{provincia:$('#provincia').val(), pais:$('#sft_direccion_pais').val()},
            success:function(data, textStatus){jQuery('#sf_list_localidades').html(data);},
            url: "<?php echo url_for('sftGestionPlugin_ListLocalidades') ?>"
        });
    });
</script>