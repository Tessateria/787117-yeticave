
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $value):?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?=$value?></a>
            </li>
        <?php endforeach;?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($advertisement as $value):?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=xss($value["picture_url"]);?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=xss($value["categor"]);?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?=xss($value["name"]);?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?=xss($value["price"]);?></span>
                            <span class="lot__cost"><?=number_form_rub(xss($value["price"]))?></span>
                        </div>
                        <div class="lot__timer timer">
                              <?=$hours_to_midnight.":".$minutes_to_midnight;?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
</section>
