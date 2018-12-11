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
    <form class="form container <?= !empty($errors) ? 'form--invalid' : ''; ?>" action="sign-up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?= !empty($errors['email']) ? 'form__item--invalid' : ''; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="email" name="email" placeholder="Введите e-mail" value="<?= !empty($user['email']) ? $user['email'] : ''; ?>">
            <span class="form__error"><?= !empty($errors['email']) ? $errors['email'] : ''; ?></span>
        </div>
        <div class="form__item <?= !empty($errors['password']) ? 'form__item--invalid' : ''; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= !empty($user['password']) ? $user['password'] : ''; ?>">
            <span class="form__error"><?= !empty($errors['password']) ? $errors['password'] : ''; ?></span>
        </div>
        <div class="form__item <?= !empty($errors['name']) ? 'form__item--invalid' : ''; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= !empty($user['name']) ? $user['name'] : ''; ?>">
            <span class="form__error"><?= !empty($errors['name']) ? $errors['name'] : ''; ?></span>
        </div>
        <div class="form__item <?= !empty($errors['message']) ? 'form__item--invalid' : ''; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= !empty($user['message']) ? $user['message'] : ''; ?></textarea>
            <span class="form__error"><?= !empty($errors['message']) ? $errors['message'] : ''; ?></span>
        </div>
        <div class="form__item form__item--file form__item--last">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" value="" name="user_image">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>
