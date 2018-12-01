USE doingsdone;

INSERT INTO user (email, name, password)
VALUES  ('kons@tant.in','Константин', 'ilovemum'),
        ('nobodyusesrambler@rambler.ru','Александра', 'ilovedad'),
        ('pavel@mail.pl','Павел', 'ilovephp');

INSERT INTO project (name, user_id)
VALUES  ('Входящие', '1'), ('Учеба', '1'), ('Работа', '1'), ('Домашние дела', '1'), ('Авто', '1'),
        ('Работа', '2'), ('Спорт', '2'),
        ('Учеба', '3'), ('Стартап', '3');

INSERT INTO task (title, status, deadline_at, project_id, user_id)
VALUES  ('Собеседование в IT компании', false, '2018-11-24', '3', '1'),
        ('Выполнить тестовое задание', false, '2018-12-25', '3', '1'),
        ('Сделать задание первого раздела', true, '2018-12-21', '2', '1'),
        ('Встреча с другом', false, null, '3', '1'),
        ('Купить корм для кота', false, null, '4', '1'),
        ('Заказать пиццу', false, null, '4', '1'),
        ('Записаться на интенсив "Базовый PHP"', true, '2018-10-10', '2', '1');

-- получить список из всех проектов для одного пользователя
SELECT * FROM project WHERE user_id = 1;

-- получить список из всех задач для одного проекта
SELECT * FROM task WHERE project_id = 1;

-- пометить задачу как выполненную
UPDATE task SET status = true WHERE id = 5;

-- получить все задачи для завтрашнего дня
SELECT * FROM task WHERE deadline_at = NOW() + INTERVAL 1 DAY;

-- обновить название задачи по её идентификатору
UPDATE task SET title = 'Купить корм для кошки' WHERE id = 5;
