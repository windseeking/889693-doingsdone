<h2 class="content__side-heading">Проекты</h2>

<nav class="main-navigation">
    <ul class="main-navigation__list">
        <?php foreach ($projects as $project): ?>
            <li class="main-navigation__list-item">
                <a class="main-navigation__list-item-link" href="<?= get_project_url($project['id']); ?>"><?= $project['name']; ?></a>
                <span class="main-navigation__list-item-count"><?= $project['task_amount']; ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<a class="button button--transparent button--plus content__side-button"
   href="pages/form-project.html" target="project_add">Добавить проект</a>
