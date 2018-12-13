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
    <form class="form container <?= !empty($errors) ? 'form--invalid' : ''; ?>" action="login.php" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>
        <div class="form__item--invalid">
            <span class="form__error"><?= !empty($errors['wrong_pass']) ? $errors['wrong_pass'] : ''; ?></span>
        </div>
        <div class="form__item <?= !empty($errors['email']) ? 'form__item--invalid' : ''; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="email" name="email" placeholder="Введите e-mail" value="<?= !empty($user['email']) ? $user['email'] : ''; ?>">
            <span class="form__error"><?= !empty($errors['email']) ? $errors['email'] : ''; ?></span>
        </div>
        <div class="form__item form__item--last <?= !empty($errors['password']) ? 'form__item--invalid' : ''; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= !empty($user['password']) ? $user['password'] : ''; ?>">
            <span class="form__error"><?= !empty($errors['password']) ? $errors['password'] : ''; ?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
