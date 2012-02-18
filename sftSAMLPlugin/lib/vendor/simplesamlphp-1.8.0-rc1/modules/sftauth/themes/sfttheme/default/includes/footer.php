

<?php

if(!empty($this->data['htmlinject']['htmlContentPost'])) {
	foreach($this->data['htmlinject']['htmlContentPost'] AS $c) {
		echo $c;
	}
}




?>
</div><!-- #wrapper -->

        <div class="foot">
        <hr />
        <?php 

            $includeLanguageBar = TRUE;
            if (!empty($_POST)) 
                    $includeLanguageBar = FALSE;
            if (isset($this->data['hideLanguageBar']) && $this->data['hideLanguageBar'] === TRUE) 
                    $includeLanguageBar = FALSE;

            if ($includeLanguageBar) {


                    echo '<div id="languagebar">';
                    $languages = $this->getLanguageList();
                    $langnames = array(
                                            'no' => 'Bokmål',
                                            'nn' => 'Nynorsk',
                                            'se' => 'Sámegiella',
                                            'sam' => 'Åarjelh-saemien giele',
                                            'da' => 'Dansk',
                                            'en' => 'English',
                                            'de' => 'Deutsch',
                                            'sv' => 'Svenska',
                                            'fi' => 'Suomeksi',
                                            'es' => 'Español',
                                            'fr' => 'Français',
                                            'it' => 'Italiano',
                                            'nl' => 'Nederlands',
                                            'lb' => 'Luxembourgish', 
                                            'cs' => 'Czech',
                                            'sl' => 'Slovenščina', // Slovensk
                                            'lt' => 'Lietuvių kalba', // Lithuanian
                                            'hr' => 'Hrvatski', // Croatian
                                            'hu' => 'Magyar', // Hungarian
                                            'pl' => 'Język polski', // Polish
                                            'pt' => 'Português', // Portuguese
                                            'pt-BR' => 'Português brasileiro', // Portuguese
                                            'tr' => 'Türkçe',
                                            'el' => 'ελληνικά',
                                            'ja' => '日本語',
                                            'zh-tw' => '中文',
                    );

                    $textarray = array();
                    foreach ($languages AS $lang => $current) {
                            if ($current) {
                                    $textarray[] = $langnames[$lang];
                            } else {
                                    $textarray[] = '<a href="' . htmlspecialchars(SimpleSAML_Utilities::addURLparameter(SimpleSAML_Utilities::selfURL(), array('language' => $lang))) . '">' .
                                            $langnames[$lang] . '</a>';
                            }
                    }
                    echo join(' | ', $textarray);
                    echo '</div>';

            }



            ?>





                <br style="clear: right;" />


        </div> <!--#foot-->
       
 </div><!-- #wrap -->

</body>
</html>