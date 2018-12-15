<main>
<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $value):?>
            <li class="nav__item">
                <a href="pages/all-lots.html"><?=($value["category"])?></a>
            </li>
        <?php endforeach;?>
    </ul>
</nav>
<section class="lot-item container">
        <h2><?=xss($lot_info["lot_name"]);?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=xss($lot_info["image"]);?>" width="730" height="548" alt="Изображение">
            </div>
            <p class="lot-item__category">Категория: <span><?=xss($lot_info["category"]);?></span></p>
            <p class="lot-item__description"><?=xss($lot_info["specification"]);?>
            </p>
        </div>
        <div class="lot-item__right">
            <?php if($can_make_rate) : ?>
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?=$time_to_midnight;?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=number_form_rub(xss($lot_info["cost"]));?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?=xss($lot_info["step_up_value"]);?> р</span>
                        </div>
                    </div>
                    <?php if (!empty($user)) : ?>
                    <form class="lot-item__form" action="" method="post">
                        <p class="lot-item__form-item form__item <?= !empty($errors) ? 'form__item--invalid' : '';?>"><!--form__item--invalid-->
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?=xss($lot_info["min_rate"]);?> р" value="<?=$cost_try;?>">
                            <span class="form__error"><?=$errors['cost'];?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($lot_info['rates'])) : ?>
            <div class="history">
                <h3>История ставок (<span><?=count($lot_info['rates'])?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($lot_info['rates'] as $rate) : ?>
                    <tr class="history__item">
                        <td class="history__name"><?=$rate['username']?></td>
                        <td class="history__price"><?=$rate['cost']?> р</td>
                        <td class="history__time"><?=$rate['date_add']?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
</main>
