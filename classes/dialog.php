<?php
class Dialog {
    public $Api;
    public $CallBack;
    public $User;

    function pars() {
        //создание объекта user
        $this->User = new \User($this->CallBack->getPlatform(), $this->CallBack->getIdUser());
        //Загрузка информации о юзере из базы данных
        $result = $this->User->loadUserData();

        if ($result == 1) {
            //получение пути
            $path = $this->User->getPath();
            //получение разрешений
            $perm = $this->User->getPerm();
            //Домашний раздел, к нему есть доступ у группы normal и  admin
            if (empty($path[0]) and ($perm == "normal" or $perm == "admin")) {
                //Показывает рассписание 1 корпуса
                if ($this->CallBack->getMessage() == '1 Корпус🏢') {
                    $this->Api->sendMessage($this->CallBack->getIdUser(), '1 Корпус🏢', $this->Api->keys->home);
                }
                //Показывает рассписание 2 корпуса
                elseif ($this->CallBack->getMessage() == '2 Корпус🏢') {
                    $this->Api->sendMessage($this->CallBack->getIdUser(), '2 Корпус🏢', $this->Api->keys->home);
                }
                //Переход на страницу настроек
                elseif ($this->CallBack->getMessage() == 'Настройки') {
                    $this->User->setPath('setting/');
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Настройки', $this->Api->keys->setting);
                }
                elseif ($this->CallBack->getMessage() == 'прима') {
                    if ($perm == "admin") {
                        $this->User->setPath('admin/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Админские примочки', $this->Api->keys->admin);
                    }
                }
                elseif ($this->CallBack->getMessage() == 'myid') {
                    $this->Api->sendMessage($this->CallBack->getIdUser(), "{$this->User->platform_id}");
                }
                /*
                //Ответчик на нецензурную брань пока убранно
                elseif (NULL!==(strpos(mb_strtolower($this->CallBack->getMessage()), "ху")) or NULL!==(strpos(mb_strtolower($this->CallBack->getMessage()), "еба")) or NULL!==(strpos(mb_strtolower($this->CallBack->getMessage()), "пидор"))) {
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'У нас тут блять не матерятся');
                }
                */
                //Пишет что действие недопустимо, и может вернуть клавиатуру при ошибке
                else {
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Недопустимое действие', $this->Api->keys->home);
                }
            }
            //Раздел Админа
            elseif ($path[0] == 'admin' and $perm == "admin") {
                if (empty($path[1])){
                    if ($this->CallBack->getMessage() == 'mgs') {
                        $this->User->setPath('admin/mgs');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Напишите массовое сообщение', $this->Api->keys->adminmgs);
                    }
                    elseif ($this->CallBack->getMessage() == 'Отмена') {
                        $this->User->setPath('/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Отмена', $this->Api->keys->home);
                    }
                }
                if ($path[1] == "mgs") {
                    if ($this->CallBack->getMessage() != 'Отмена') {

                    }
                    elseif ($this->CallBack->getMessage() == 'Отмена') {
                        $this->User->setPath('/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Отмена', $this->Api->keys->admin);
                    }
                }
                
            }
            
            //Раздел настроек, к нему есть доступ у группы normal и  admin
            elseif ($path[0] == 'setting' and ($perm == "normal" or $perm == "admin")) {
                //Корневая страница настроек
                if (empty($path[1])) {
                    //Переход к настройке Фона
                    if ($this->CallBack->getMessage() == 'Фон') {
                        $this->User->setPath('setting/bg');
                        if ($this->User->getBgId() == '0') {
                            $this->Api->sendMessage($this->CallBack->getIdUser(), 'У вас не установлен фон', $this->Api->keys->settingBg);
                        }
                        else {
                            $this->Api->sendMessage($this->CallBack->getIdUser(), 'Ваш фон', $this->Api->keys->settingBg);
                            sleep(1);
                            $this->Api->sendPhoto($this->CallBack->getIdUser(), $this->User->getBgId());
                        }
                    }
                    //Переход к настройке Подписки
                    elseif ($this->CallBack->getMessage() == 'Подписка') {
                        $this->User->setPath('setting/type');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Подписка', $this->Api->keys->settingSub);
                    }
                    //Получние информации для пожертвования
                    elseif ($this->CallBack->getMessage() == 'Пожертвовать') {
                        $this->User->setPath('/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Тут типо ссылка', $this->Api->keys->home);
                    }
                    //Сброс данных
                    elseif ($this->CallBack->getMessage() == 'Сбросить данные') {
                        $this->User->setPath('setting/dlt');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Сбросить данные', $this->Api->keys->settingdlt);
                    }
                    //Переход в домашний раздел
                    elseif ($this->CallBack->getMessage() == 'Отмена') {
                        $this->User->setPath('/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Отмена', $this->Api->keys->home);
                    }
                    else {
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Недопустимое действие', $this->Api->keys->setting);
                    }
                }
                //Страница настройки Фона
                elseif ($path[1] == 'bg') {
                    //Изменение Фона
                    if (empty($path[2])) {
                        if($this->CallBack->getMessage() == 'Изменить') {
                            $this->User->setPath('setting/bg/edit');
                            $this->Api->sendMessage($this->CallBack->getIdUser(), 'Пришлите фотографию с разрешением 2560x1810', $this->Api->keys->settingBg);
                        }
                        //Переход на корневую страницу настроек
                        elseif ($this->CallBack->getMessage() == 'Отмена') {
                            $this->User->setPath('setting/');
                            $this->Api->sendMessage($this->CallBack->getIdUser(), 'Отмена', $this->Api->keys->setting);
                        }
                    }
                    elseif ($path[2] == 'edit') {
                        if (empty($this->CallBack->getMessage())) {

                            if (!empty($this->CallBack->getAttPhoto())) {

                                $this->User->setBgId($this->CallBack->getAttPhoto());
                                $this->Api->sendMessage($this->CallBack->getIdUser(), 'Фон установлен', $this->Api->keys->setting);
                                $this->User->setPath('setting/');
                            }
                        }
                        elseif ($this->CallBack->getMessage() == 'Отмена') {
                            $this->User->setPath('setting/bg/');
                            $this->Api->sendMessage($this->CallBack->getIdUser(), 'Отмена', $this->Api->keys->settingBg);
                        }
                        else {
                            $this->Api->sendMessage($this->CallBack->getIdUser(), 'Недопустимое действие');
                        }
                        
                    }
                    
                }
                //Страница настройки Подписки
                elseif ($path[1] == 'type') {
                    //Выбор типа Студент
                    if ($this->CallBack->getMessage() == 'Студент') {
                        $this->User->setType('student');
                        $this->User->setPath('setting/sub');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Напиши название твоей группы', $this->Api->keys->close);
                    }
                    //Выбор типа Преподаватель
                    elseif ($this->CallBack->getMessage() == 'Преподаватель') {
                        $this->User->setType('prepod');
                        $this->User->setPath('setting/sub');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Напишите ваше имя', $this->Api->keys->close);
                    }
                    //Переход на корневую страницу настроек
                    elseif ($this->CallBack->getMessage() == 'Отмена') {
                        $this->User->setPath('setting/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Отмена', $this->Api->keys->setting);
                    }
                }
                elseif ($path[1] == 'sub') {
                    //Получение NAME Подписки
                    $this->User->setSubscribe($this->CallBack->getMessage());
                    $this->User->setPath('/');
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Вы успешно подписались!', $this->Api->keys->home);
                }
                //Страница удаления данных
                elseif ($path[1] == 'dlt') {
                    //Удалаются данные
                    if ($this->CallBack->getMessage() == 'Да') {
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Прощайте...', $this->Api->keys->close);
                        $this->User->dltUser();
                    }
                    //Переход на корневую страницу настроек
                    elseif ($this->CallBack->getMessage() == 'Нет') {
                        $this->User->setPath('setting/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Настройки', $this->Api->keys->close);
                    }
                }
            }
            //Раздел стартовой настройки, к нему есть доступ только у группы guest
            elseif ($path[0] == 'start' and $perm == "guest") {

                if ($path[1] == 'type') {
                    //Выбор типа Студент
                    if ($this->CallBack->getMessage() == 'Студент') {
                        $this->User->setType('student');
                        $this->User->setPath('start/sub');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Напиши название твоей группы', $this->Api->keys->close);
                    }
                    //Выбор типа Преподаватель
                    elseif ($this->CallBack->getMessage() == 'Преподаватель') {
                        $this->User->setType('prepod');
                        $this->User->setPath('start/sub');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Напишите ваше имя', $this->Api->keys->close);
                    }
                }
                //Получение NAME Подписки
                elseif ($path[1] == 'sub') {
                    $this->User->setSubscribe($this->CallBack->getMessage());
                    $this->User->setPerm('normal');
                    $this->User->setPath('/');
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Вы успешно подписались!', $this->Api->keys->close);
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Добро пожаловать в пятую версию бота! Пришло много изменений, которые
                    можете посмотреть по ссылочке! *Ссылка* <br> Бот стоит на платном сервере, так что можете
                    помочь денюшкой! *Ссылка*<br>Для использования бота откройте меню.', $this->Api->keys->close);
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Клавиатура открыта', $this->Api->keys->home);
                }
                else {
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Нажми Начать', $this->Api->keys->start);
                }
            }
            //Исправление ошибки неправильного
            else {
                //Для guest
                if ($perm == 'guest') {
                    $this->User->dltUser();
                    $this->User->crtNewUser();
                    $this->User->setPath('start/');
                }
                //Для normal и admin
                elseif ($perm == 'normal' or $perm == 'admin') {
                    $this->User->setPath('/');
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Клавиатура открыта', $this->Api->keys->home);
                }
            }
        }
        //Создаёт пользователя, если его нет
        elseif ($result < 1) {
            $this->User->crtNewUser();
            $this->Api->sendMessage($this->CallBack->getIdUser(), 'Приветствую тебя!', $this->Api->keys->close);
            sleep(1);
            $this->Api->sendMessage($this->CallBack->getIdUser(), 'Я бот для рассылки расписания.', $this->Api->keys->close);
            sleep(1);
            $this->Api->sendMessage($this->CallBack->getIdUser(), 'Давай проведём настройку!', $this->Api->keys->close);
            sleep(1);
            $this->User->setPath('start/type');
            $this->Api->sendMessage($this->CallBack->getIdUser(), 'Кто ты?', $this->Api->keys->settingSub);

        }
        //Исправление ошибки двойного юзера
        elseif ($result > 1) {
            $this->User->dltUser();
        }
    }

}
?>