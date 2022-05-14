<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/core/prolog.php");
if ($_POST["ajax"] == true) {
    ini_set('max_execution_time', 600);
    $xml = new XE();
    $arResult = $xml->execute($_POST['url']);
    $arPrint['OK'] = array();
    $arPrint['TROUBLES'] = array();
    if ($arResult['status'] == "OK"){
        if (isset($arResult['sitemap']['INCLUDE'])) {
            foreach ($arResult['sitemap']['INCLUDE'] as $map) {
                $arPrint['TROUBLES'] = array_merge($arPrint['TROUBLES'], $map["TROUBLES"]);
                $arPrint['OK'] = array_merge($arPrint['OK'], $map["OK"]);
            }
        } else {
            $arPrint = $arResult['sitemap'];
        }
        if (count($arPrint['OK']) > 0){
            ?>
            <div class="xml-result-ok">
                <div class="xml-result-ok-title"><span>200 OK</span> Корректный статус ответа - <?=count($arPrint['OK'])?> стр.</div>
                <div class="xml-result-ok-list-title">Показать список страниц</div>
                <div class="xml-result-ok-list">
                    <? foreach($arPrint['OK'] as $link){?>
                        <a href="<?=$link?>" class="xml-result-ok-link"><?=$link?></a>
                    <?}?>
                </div>
            </div>
            <?php
        }
        if (count($arPrint['TROUBLES']) > 0){
            ?>
            <div class="xml-result-err">
                <div class="xml-result-err-title"><span>ERROR</span> Статус отличный от 200 ОК - <?=count($arPrint['TROUBLES'])?> стр.</div>
                <div class="xml-result-err-list-title">Показать список страниц со статусами</div>
                <div class="xml-result-err-list">
                    <? foreach($arPrint['TROUBLES'] as $link => $status){?>
                        <a href="<?=$link?>" class="xml-result-err-link"><?=$link?> - <?=$status?></a>
                    <?}?>
                </div>
            </div>
            <?php
        }
    }else{
        ?>
        <div class="error"><?=$arResult['message']?></div>
        <?php
    }
}
?>