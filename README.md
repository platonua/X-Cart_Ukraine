# Модуль X-Cart для Украины

## Установка:

* Распаковать архив в корень сайта.

* В админ панеле перейти Tools → Patch/Upgrade.

* В "Apply SQL patch" разделе выбрать “platon_xcart.sql” из архива, нажмите "Apply".

* Выбрать файл “platon_xcart.diff” из архива для “Apply patch” раздела.

* Или скопируйте файлы в соответствующую директорию из папки “xcart” в архиве.

* В админ панеле перейти Settings->Payment methods.

* Откройте вкладку "Payment Gateways", выберите "Platon" from the "Payment gateways" в выпадающем списке и нажмите кнопку "Add".

* Нажмите "Configure" в разделе "Platon" вкладки "Payment methods" .

* Введите ключ и пароль. Нажмите кнопку "Update".

* Вернитесь во вкладку "Payment methods", переключите в значение "On" и нажмите кнопку "Apply changes".

## Ссылка для коллбеков:
https://ВАШ_САЙТ/payment/cc_platon_response.php

## Тестирование:
В целях тестирования используйте наши тестовые реквизиты.

| Номер карты  | Месяц / Год | CVV2 | Описание результата |
| :---:  | :---:  | :---:  | --- |
| 4111  1111  1111  1111 | 02 / 2022 | Любые три цифры | Не успешная оплата без 3DS проверки |
| 4111  1111  1111  1111 | 06 / 2022 | Любые три цифры | Не успешная оплата с 3DS проверкой |
| 4111  1111  1111  1111 | 01 / 2022 | Любые три цифры | Успешная оплата без 3DS проверки |
| 4111  1111  1111  1111 | 05 / 2022 | Любые три цифры | Успешная оплата с 3DS проверкой |
