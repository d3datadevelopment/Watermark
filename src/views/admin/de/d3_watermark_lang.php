<?php

/**
 * This Software is the property of Data Development and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * http://www.shopmodule.com
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development <support@shopmodule.com>
 * @link      http://www.oxidmodule.com
 */

$sLangName = "Deutsch";
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$aLang = array(
    'charset'                                     => 'UTF-8',
    //Navigation
    'd3mxwatermark'                               => "<i class='fas fa-images'></i> Wasserzeichen",
    'd3mxwatermark_settings'                      => 'Einstellungen',
    'd3tbclwatermark_main'                        => 'Stamm',
    'd3tbclwatermark_imagetypes'                  => 'Bildformate',
    'd3tbclwatermark_licence'                     => 'Support',
    // Tabinhalte Bildformate
    'D3_WATERMARK_FORMAT_GLOBAL'                  => 'globale Einstellungen',
    'D3_WATERMARK_FORMAT_ICON'                    => 'Icons',
    'D3_WATERMARK_FORMAT_CATEGORY_ICON'           => 'Kategorie-Icons',
    'D3_WATERMARK_FORMAT_MANUFACTURER_ICON'       => 'Marken-Icons',
    'D3_WATERMARK_FORMAT_VENDOR_ICON'             => 'Lieferanten-Icons',
    'D3_WATERMARK_FORMAT_CATEGORY_PROMO_ICON'     => 'Startseiten-Kategorie-Icons',
    'D3_WATERMARK_FORMAT_THUMB'                   => 'Thumbnails',
    'D3_WATERMARK_FORMAT_CATEGORY_THUMB'          => 'Kategorie-Thumbnails',
    'D3_WATERMARK_FORMAT_PIC1'                    => 'Picture 1',
    'D3_WATERMARK_FORMAT_PIC2'                    => 'Picture 2',
    'D3_WATERMARK_FORMAT_PIC3'                    => 'Picture 3',
    'D3_WATERMARK_FORMAT_PIC4'                    => 'Picture 4',
    'D3_WATERMARK_FORMAT_PIC5'                    => 'Picture 5',
    'D3_WATERMARK_FORMAT_PIC6'                    => 'Picture 6',
    'D3_WATERMARK_FORMAT_PIC7'                    => 'Picture 7',
    'D3_WATERMARK_FORMAT_PIC8'                    => 'Picture 8',
    'D3_WATERMARK_FORMAT_PIC9'                    => 'Picture 9',
    'D3_WATERMARK_FORMAT_PIC10'                   => 'Picture 10',
    'D3_WATERMARK_FORMAT_PIC11'                   => 'Picture 11',
    'D3_WATERMARK_FORMAT_PIC12'                   => 'Picture 12',
    'D3_WATERMARK_FORMAT_ZOOM1'                   => 'Zoom 1',
    'D3_WATERMARK_FORMAT_ZOOM2'                   => 'Zoom 2',
    'D3_WATERMARK_FORMAT_ZOOM3'                   => 'Zoom 3',
    'D3_WATERMARK_FORMAT_ZOOM4'                   => 'Zoom 4',
    'D3_WATERMARK_FORMAT_ZOOM5'                   => 'Zoom 5',
    'D3_WATERMARK_FORMAT_ZOOM6'                   => 'Zoom 6',
    'D3_WATERMARK_FORMAT_ZOOM7'                   => 'Zoom 7',
    'D3_WATERMARK_FORMAT_ZOOM8'                   => 'Zoom 8',
    'D3_WATERMARK_FORMAT_ZOOM9'                   => 'Zoom 9',
    'D3_WATERMARK_FORMAT_ZOOM10'                  => 'Zoom 10',
    'D3_WATERMARK_FORMAT_ZOOM11'                  => 'Zoom 11',
    'D3_WATERMARK_FORMAT_ZOOM12'                  => 'Zoom 12',
    'D3_WATERMARK_FORMAT_MASTER'                  => 'Picture (masterpicture)',
    'D3_WATERMARK_FORMAT_ZOOM'                    => 'Zoom',
    // Tabinhalte Stamm
    'D3_WATERMARK_MAIN_WMIMAGE'                   => 'Bildüberlagerung',
    'D3_WATERMARK_MAIN_WMTEXT'                    => 'Textüberlagerung',
    'D3_WATERMARK_MAIN_SETTINGS'                  => 'Einstellungen',
    'D3_WATERMARK_MAIN_FILEUPLOAD'                => 'Datei neu aufladen und Vorschau anzeigen',
    'D3_WATERMARK_MAIN_SUPPORTED_PICS_HELP'       => 'Aktuell werden folgende Bildformate unterstützt.<br> PNG, JPG, GIF',
    'D3_WATERMARK_DELETE_ALLGENPIX'               => 'Löschen',
    'D3_WATERMARK_DELETE_ALLGENPIX_MESSAGE'       => 'Wollen Sie die generierten Bilder entfernen?',
    'D3_WATERMARK_DELETE_ALLGENPIX_HELP'          => 'Mit dieser Option haben Sie die Möglichkeit, die vom Shop ' //
        . 'bereits generierten Bilder zu entfernen. <br><br>Dies ist bspw. dann notwendig, wenn Sie ein neues ' //
        . 'Wasserzeichenbild hochgeladen haben, Einstellungen geändert haben, oder im Shop vor Aktivierung des ' //
        . 'Moduls bereits generierte Bilder vorliegen.',
    'D3_WATERMARK_MAIN_IMG_REQUIRED'              => 'Laden Sie bitte zuerst ein Wasserzeichenbild auf.',
    'D3_WATERMARK_MAIN_PREVIEW'                   => 'Vorschau:',
    'D3_WATERMARK_MAIN_FITTRANSPARENCY'           => 'Bild ohne zusatzliche Transparenz verwenden',
    'D3_WATERMARK_MAIN_NEWTRANSPARENCY'           => 'folgende Transparenz anwenden',
    'D3_WATERMARK_MAIN_TRANSPARENCYDESC'          => 'Die Angabe erfolgt in % (Prozent). ' //
        . 'Der Wert entspricht dem Grad der Transparenz. '
        . 'Je höher der Wert, desto deckender das Wasserzeichen. <br>D.h. 0 = unsichtbar, 100 = deckend',
    'D3_WATERMARK_MAIN_FORMATSELECT'              => 'Bildformat auswählen:',
    'D3_WATERMARK_MAIN_FORMATACTIVE'              => 'Wasserzeichen einbetten',
    'D3_WATERMARK_MAIN_FORMATNOTICE'              => 'Stellen Sie bitte für jedes Bildformat ein, ob und wie dieses Wasserzeichen verwendet werden soll. Wechseln Sie dazu in den Tab "Bildformate".',
    'D3_WATERMARK_MAIN_DEMO'                      => 'Sie verwenden das Modul im Test-Modus. Darin wird als Wasserzeichen ein vorgegebenes Bild verwendet. Möchten Sie statt dessen Ihr eigenes Wasserzeichenbild verwenden, erwerben Sie bitte das Modul.',
    'D3_WATERMARK_MAIN_INSERTTYPE'                => 'Einpassung',
    'D3_WATERMARK_MAIN_INSERTTYPE_FULLSIZE'       => 'größtmöglich im Bild',
    'D3_WATERMARK_MAIN_INSERTTYPE_FITVERTICAL'    => 'vertikal',
    'D3_WATERMARK_MAIN_INSERTTYPE_FITHORIZONTAL'  => 'horizontal',
    'D3_WATERMARK_MAIN_INSERTTYPE_DIRECTPOS'      => 'direkt positionieren',
    'D3_WATERMARK_MAIN_INSERTTYPE_DIRECTPOS_SETS' => 'weitere Einstellungen (sofern notwendig)',
    'D3_WATERMARK_MAIN_INSERTPOS_CENTER'          => 'zentriert',
    'D3_WATERMARK_MAIN_INSERTPOS_TOP'             => 'oben zentriert',
    'D3_WATERMARK_MAIN_INSERTPOS_TOPRIGHT'        => 'oben rechts',
    'D3_WATERMARK_MAIN_INSERTPOS_RIGHT'           => 'rechts zentriert',
    'D3_WATERMARK_MAIN_INSERTPOS_BOTTOMRIGHT'     => 'unten rechts',
    'D3_WATERMARK_MAIN_INSERTPOS_BOTTOM'          => 'unten zentriert',
    'D3_WATERMARK_MAIN_INSERTPOS_BOTTOMLEFT'      => 'unten links',
    'D3_WATERMARK_MAIN_INSERTPOS_LEFT'            => 'links zentriert',
    'D3_WATERMARK_MAIN_INSERTPOS_TOPLEFT'         => 'oben links',
    'D3_WATERMARK_MAIN_INSERT_WIDTH'              => 'Breite:',
    'D3_WATERMARK_MAIN_INPUTTEXT'                 => 'Wasserzeichen-Text:',
    'D3_WATERMARK_MAIN_TEXTCOLOR'                 => 'Textfarbe',
    'D3_WATERMARK_MAIN_HELPLINK'                  => 'Fragen-zu-speziellen-Modulen/Wasserzeichen/',
    // Popup - Buttons / Text
    'D3_WATERMARK_NEW_WATERMARKPICTURE'           => 'Es wurde ein neues Bild für das Wasserzeichen hochgeladen. ' //
        . 'Für die Verwendung des neuen Wasserzeichens, müssen die bereits vorliegenden, generierten Bilder ' //
        . 'entfernt werden.',
    'D3_WATERMARK_NEW_WATERMARKSETTINGS'           => 'Es wurden neue Einstelungen gespeichert. ' //
        . 'Für die Aktualisierung des implementierten Wasserzeichens müssen die bereits vorliegenden, ' //
        . 'generierten Bilder entfernt werden.',
    'D3_WATERMARK_CLEAR_GENERATED_PICTURES'       => 'Soll dies nun durchgeführt werden?',
    'D3_WATERMARK_BUTTON_OK'                      => 'Jetzt durchführen',
    'D3_WATERMARK_BUTTON_NOT_YET'                 => 'Später manuell durchführen',
    // Fehlertexte
    'D3_WATERMARK_INACTIVE_NOTICE'                => 'Modul ist nicht aktiv. Aktivieren Sie dieses bitte unter: Modul-Connector -> Modulverwaltung',
    'D3_WATERMARK_FAILUPLOAD_11'                  => 'Bitte kontrollieren Sie das von Ihnen hochgeladene Dateiformat. ' //
        . 'Erlaubte Formate sind "gif", "jpg" und "png".',
    'D3_WATERMARK_CHANGED_HTACCESS'               => 'HINWEIS: Mit der Installation wurden Anpassungen an der Datei .htaccess des Shops vorgenommen.',
    // faeture
    'D3_WATERMARK_FORMAT_PRODUCTPIX'              => 'Produktbilder',
    'D3_WATERMARK_FORMAT_PRODUCTZOOMPIX'          => 'Produkt-Zoombilder',
    'D3_WATERMARK_FORMAT_OTHERPIX'                => 'andere Bilder',

    'D3_WATERMARK_CLRTMP_GENIMGS_SUCC'            => 'Die generierten Bilder wurden gelöscht.',
);

/*
[{oxmultilang ident="GENERAL_YOUWANTTODELETE"}]
*/
