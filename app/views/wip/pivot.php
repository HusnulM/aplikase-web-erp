<link rel="stylesheet" href="<?= BASEURL; ?>/css/pivot.css" />

<?php

$filmsByActorAndGenre = PHPivot::create($data)
            ->setPivotRowFields(array('partnumber'))
            ->setPivotColumnFields('deskripsi')
            ->setPivotValueFields('quantity',PHPivot::PIVOT_VALUE_COUNT, PHPivot::DISPLAY_AS_VALUE_AND_PERC_ROW)
            ->addFilter('deskripsi','', PHPivot::COMPARE_NOT_EQUAL) //Filter out blanks/unknown genre
            ->setIgnoreBlankValues()
            ->generate();
        echo $filmsByActorAndGenre->toHtml();