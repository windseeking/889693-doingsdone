<main class="content__main">
    <h2 class="content__main-heading">Регистрация аккаунта</h2>

    <form class="form" method="post">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>
            <?php $class = isset($errors['email']) ? 'form__input--error' : ''; $value = isset($user['email']) ? $user['email'] : ''; ?>
            <input class="form__input <?= $class; ?>" type="text" name="user[email]" id="email" value="<?= $value; ?>" placeholder="Введите e-mail">
            <?php if (isset($errors['email'])) : ?>
                <p class="form__message"><?= $errors['email']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>
            <?php $class = isset($errors['password']) ? 'form__input--error' : ''; $value = isset($user['password']) ? $user['password'] : ''; ?>
            <input class="form__input <?= $class; ?>" type="password" name="user[password]" id="password" value="<?= $value; ?>" placeholder="Введите пароль">
            <?php if (isset($errors['password'])) : ?>
                <p class="form__message"><?= $errors['password']; ?>ь</p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="name">Имя <sup>*</sup></label>
            <?php $class = isset($errors['name']) ? 'form__input--error' : ''; $value = isset($user['name']) ? $user['name'] : ''; ?>
            <input class="form__input <?= $class; ?>" type="text" name="user[name]" id="name" value="<?= $value; ?>" placeholder="Введите имя">
        <?php if (isset($errors['name'])) : ?>
            <p class="form__message"><?= $errors['name']; ?></p>
        <?php endif; ?>
        </div>

        <div class="form__row form__row--controls">

            <input class="button" type="submit" name="" value="Зарегистрироваться">
        </div>
    </form>
</main>
</div>
