<main class="container">
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $value):?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?=($value["category"])?></a>
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
                    <img src="<?=xss($value["image"]);?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=xss($value["category"]);?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$value["id"]?>"><?=xss($value["lot_name"]);?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?=xss($value["start_price"]);?></span>
                            <span class="lot__cost"><?=number_form_rub(xss($value["cost"]))?></span>
                        </div>
                        <div class="lot__timer timer">
                              <?=$value["time_to_end"];?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
</section>
</main>
