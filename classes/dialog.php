<?php
class Dialog {
    public $Api;
    public $CallBack;
    public $User;

    function pars() {
        $this->User = new \User($this->CallBack->getPlatform(), $this->CallBack->getIdUser());
        $result = $this->User->loadUserData();
        if ($result == 1) {          
            $path = explode('/', stripslashes(htmlspecialchars(trim($this->User->path))));
            $perm = $this->User->getUserPermition();
            if (empty($path[0]) and ($perm == "normal" or $perm == "admin")) {
                if (empty($path[1])) {
                    if ($this->CallBack->getMessage() == '1 Корпус🏢') {
                        $this->Api->sendMessage($this->CallBack->getIdUser(), '1 Корпус🏢', $this->Api->keys->home);
                    }
                    elseif ($this->CallBack->getMessage() == '2 Корпус🏢') {
                        $this->Api->sendMessage($this->CallBack->getIdUser(), '2 Корпус🏢', $this->Api->keys->home);
                    }
                    elseif ($this->CallBack->getMessage() == 'Настройки') {
                        $this->User->setPath('setting/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Настройки', $this->Api->keys->setting);
                    }
                }
            }
            /*
            elseif ($path[0] == 'admin' and $perm == "admin") {
                
            }
            */
            elseif ($path[0] == 'setting' and ($perm == "normal" or $perm == "admin")) {
                if (empty($path[1])) {
                    if ($this->CallBack->getMessage() == 'Фон') {
                        $this->User->setPath('setting/bg');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Фон', $this->Api->keys->settingBg);
                    }
                    elseif ($this->CallBack->getMessage() == 'Подписка') {
                        $this->User->setPath('setting/type');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Подписка', $this->Api->keys->settingSub);
                    }
                    elseif ($this->CallBack->getMessage() == 'Пожертвовать') {
                        $this->User->setPath('/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Тут типо ссылка', $this->Api->keys->home);
                    }
                    elseif ($this->CallBack->getMessage() == 'Сбросить данные') {
                        $this->User->setPath('setting/dlt');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Сбросить данные', $this->Api->keys->settingdlt);
                    }
                    elseif ($this->CallBack->getMessage() == 'Отмена') {
                        $this->User->setPath('/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Отмена', $this->Api->keys->home);
                    }
                }
                elseif ($path[1] == 'bg') {
                    if($this->CallBack->getMessage() == 'Изменить') {
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Пришлите фотографию', $this->Api->keys->settingBg);
                    }
                    elseif ($this->CallBack->getMessage() == 'Отмена') {
                        $this->User->setPath('setting/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Отмена', $this->Api->keys->setting);
                    }
                }
                elseif ($path[1] == 'type') {
                    if ($this->CallBack->getMessage() == 'Студент') {
                        $this->User->setType('student');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Напиши название твоей группы', $this->Api->keys->close);
                        $this->User->setPath('setting/sub');
                    }
                    elseif ($this->CallBack->getMessage() == 'Преподаватель') {
                        $this->User->setType('prepod');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Напишите ваше имя', $this->Api->keys->close);
                        $this->User->setPath('setting/sub');
                    }
                    elseif ($this->CallBack->getMessage() == 'Отмена') {
                        $this->User->setPath('setting/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Отмена', $this->Api->keys->setting);
                    }
                }
                elseif ($path[1] == 'sub') {
                    $this->User->setSubscribe($this->CallBack->getMessage());
                    $this->User->setPath('/');
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Вы успешно подписались!', $this->Api->keys->setting);
                }
                elseif ($path[1] == 'dlt') {
                    if ($this->CallBack->getMessage() == 'Да') {
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Прощайте...', $this->Api->keys->close);
                        $this->User->dltUser();
                    }
                    elseif ($this->CallBack->getMessage() == 'Нет') {
                        $this->User->setPath('setting/');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Настройки', $this->Api->keys->close);
                    }

                }
            }
            elseif ($path[0] == 'start' and $perm == "guest") {
                if ($path[1] == 'type') {
                    if ($this->CallBack->getMessage() == 'Студент') {
                        $this->User->setType('student');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Напиши название твоей группы', $this->Api->keys->close);
                    }
                    elseif ($this->CallBack->getMessage() == 'Преподаватель') {
                        $this->User->setType('prepod');
                        $this->Api->sendMessage($this->CallBack->getIdUser(), 'Напишите ваше имя', $this->Api->keys->close);
                    }
                    $this->User->setPath('start/sub');
                }
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
            else {
                if ($perm == 'guest') {
                    $this->User->dltUser();
                    $this->User->crtNewUser();
                    $this->User->setPath('start/');
                }
                elseif ($perm == 'normal' or $perm == 'admin') {
                    $this->User->setPath('/');
                    $this->Api->sendMessage($this->CallBack->getIdUser(), 'Клавиатура открыта', $this->Api->keys->home);
                }
            }

            /*
            /start              guest
            /admin              admin
            /admin/mgs          admin
            /setting            normal admin
            /setting/setBg      normal admin
            /setting/setSub     normal admin guest
            /setting/dltUser    normal admin
            /setting/donate     normal admin
            */
        }
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
        elseif ($result > 1) {
            $this->User->dltUser();
        }
    }

}
?>