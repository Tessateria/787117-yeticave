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
        <h2>403 Доступ запрещен</h2>
        <p>Войдите под своим именем.</p>
    </section>
</main>
