<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" action="index.html" method="post">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>
        <?php $class = isset($errors['title']) ? 'form__input--error' : ''; $value = isset($task['title']) ? filter_tags($tasks['title']) : ''; ?>
        <input class="form__input <?= $class; ?>" type="text" name="task_title" id="name" value="<?= $value; ?>" placeholder="Введите название">
        <?php if (isset($errors['title'])): ?>
            <p class="form__message"><?= $errors['title']; ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>
        <?php $class = isset($errors['project']) ? 'form__input--error' : ''; $value = isset($task['project_id']) ? $projects['id'] : ''; ?>
        <select class="form__input form__input--select" name="task_project" id="project">
            <?php foreach ($projects as $project): ?>
                <option <?= $project['id'] == $value ? 'selected' : '' ?> value="<?= $project['id']; ?>"><?= filter_tags($project['name']); ?></option>
            <?php endforeach ?>
        </select>
        <?php if (isset($errors['project'])): ?>
            <p class="form__message"><?= $errors['project']; ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>
        <?php $class = isset($errors['deadline_at']) ? 'form__input--error' : ''; $value = isset($task['deadline_at']) ? $task['deadline_at'] : ''; ?>
        <input class="form__input form__input--date <?= $class ?>" type="date" name="task_date" id="date" value="<?= $value; ?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
        <?php if (isset($errors['deadline_at'])): ?>
            <p class="form__message"><?= $errors['deadline_at'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="preview">Файл</label>
        <div class="form__input-file">
            <?php $class = isset($errors['file_url']) ? 'form__input--error' : '' ;?>
            <input class="visually-hidden" type="file" name="task_file" id="preview" value="">
            <?php if (isset($errors['file_url'])): ?>
                <p class="form__message"><?= $errors['file_url'] ?></p>
            <?php endif; ?>
            <label class="button button--transparent" for="preview">
                <span>Выберите файл</span>
            </label>
        </div>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
