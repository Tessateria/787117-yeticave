<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $value): ?>
                <li class="nav__item">
                    <a href="pages/all-lots.html"><?= ($value["category"]) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form form--add-lot container <?= isset($errors) ? "form--invalid" : ""; ?>" action="add.php"
          method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?= isset($errors['lot_name']) ? "form__item--invalid" : ""; ?>">

                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot[lot_name]" placeholder="Введите наименование лота"
                       value="<?= isset($lot['lot_name']) ? $lot['lot_name'] : ""; ?>">
                <span class="form__error">Введите наименование лота</span>
            </div>
            <div class="form__item <?= isset($errors['category_id']) ? "form__item--invalid" : ""; ?>">
                <label for="category">Категория</label>
                <select id="category" name="lot[category_id]">
                    <option>Выберите категорию</option>
                    <?php foreach ($categories as $value): ?>
                        <option value="<?= ($value["id"]) ?>"><?= ($value["category"]) ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error">Выберите категорию</span>
            </div>
        </div>
        <div class="form__item form__item--wide <?= isset($errors['specification']) ? "form__item--invalid" : ""; ?>">
            <label for="message">Описание</label>
            <textarea id="message" name="lot[specification]"
                      placeholder="Напишите описание лота"><?= isset($lot['specification']) ? $lot['specification'] : ""; ?></textarea>
            <span class="form__error">Напишите описание лота</span>
        </div>
        <div class="form__item form__item--file <?= isset($errors['lot_image']) ? "form__item--invalid" : ""; ?>">

            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="lot_image" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <div class="form__container-three">
            <div
                class="form__item form__item--small <?= isset($errors['start_price']) ? "form__item--invalid" : ""; ?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot[start_price]" placeholder="0"
                       value="<?= isset($lot['start_price']) ? $lot['start_price'] : ""; ?>">
                <span class="form__error">Введите начальную цену</span>
            </div>
            <div
                class="form__item form__item--small <?= isset($errors['step_up_value']) ? "form__item--invalid" : ""; ?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot[step_up_value]" placeholder="0"
                       value="<?= isset($lot['step_up_value']) ? $lot['step_up_value'] : ""; ?>">
                <span class="form__error">Введите шаг ставки</span>
            </div>
            <div class="form__item <?= isset($errors['date_finish']) ? "form__item--invalid" : ""; ?>">
                <label for="lot-date">Дата окончания торгов</label>
                <input class="form__input-date" id="lot-date" type="date" name="lot[date_finish]"
                       value="<?= isset($lot['date_finish']) ? $lot['date_finish'] : ""; ?>">
                <span class="form__error">Введите дату завершения торгов</span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
