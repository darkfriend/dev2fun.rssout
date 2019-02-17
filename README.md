# Модуль RSS-лента для 1C-Битрикс (dev2fun.rssout)
Модуль содержит гибкий компонент вывода RSS-ленты для 1C-Битрикс.


## Преимущества модуля:
* множественный выбор инфоблоков
* множественный выбор разделов
* возможность кастомных модификаций перед выводом. Достигается при помощи событий

## Установка

###Способ 1

* Скачиваем репозиторий
* Переносим папку dev2fun.rssout в ```/bitrix/modules/```
* Устанавливаем модуль в битриксе (```/bitrix/admin/update_system_partner.php```)
* Заходим в визуальный редактор и сбрасываем кэш компонентов
* Компонент располагается по пути ```dev2fun->RSS->RSS новости (экспорт)```

###Способ 2

* Скачиваем репозиторий
* Заходим в ```dev2fun.rssout/install/components```
* Переносим папку dev2fun в ```/bitrix/components/```
* Заходим в визуальный редактор и сбрасываем кэш компонентов
* Компонент располагается по пути ```dev2fun->RSS->RSS новости (экспорт)```

## События

### OnBeforeRequestElements

_Вызывается перед запросом элементов._

**Параметры:**
* &$arSort - массив сортировки
* &$arFilter - массив фильтра
* &$limit
* &$arSelect


### OnBeforeOutputRss

_вызывается перед выводом RSS-ленты._

**Параметры:**
* &$arResult - массив результата в котором есть ITEMS.

### Пример использования событий

```php
\Bitrix\Main\EventManager::getInstance()->addEventHandler('dev2fun.rssout','OnBeforeOutputRss',function(&$arResult){
	$arResult['NAME'] = 'Название для RSS';
	if(empty($arResult['ITEMS'])) return;
	foreach ($arResult['ITEMS'] as &$arItem) {
		// ваш код
	}
	unset($arItem);
});
```

