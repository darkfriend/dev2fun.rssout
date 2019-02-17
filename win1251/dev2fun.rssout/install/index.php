<?php
IncludeModuleLangFile(__FILE__);
/**
 * @author dev2fun (darkfriend)
 * @copyright darkfriend
 * @version 1.0.0
 */
if (class_exists("dev2fun_rssout")) return;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Config\Option;

class dev2fun_rssout extends CModule
{
	var $MODULE_ID = "dev2fun.rssout";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_GROUP_RIGHTS = "Y";

	public function dev2fun_rssout() {
		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path . "/version.php");
		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		} else {
			$this->MODULE_VERSION = '1.0.0';
			$this->MODULE_VERSION_DATE = '2019-02-18 15:00:00';
		}
		$this->MODULE_NAME = Loc::getMessage("DEV2FUN_MODULE_NAME_RSSOUT");
		$this->MODULE_DESCRIPTION = Loc::getMessage("DEV2FUN_MODULE_DESCRIPTION_RSSOUT");
		$this->PARTNER_NAME = "dev2fun";
		$this->PARTNER_URI = "http://dev2fun.com/";
	}

	public function DoInstall() {
		global $APPLICATION;
		if(!check_bitrix_sessid()) return;
		try {
			$this->installComponent();
			\Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
			$APPLICATION->IncludeAdminFile(Loc::getMessage("D2F_RSSOUT_STEP1"), __DIR__."/step1.php");
		} catch (Exception $e) {
			$APPLICATION->ThrowException($e->getMessage());
			return false;
		}
		return true;
	}

	public function installComponent() {
		if(!CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/{$this->MODULE_ID}/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true)) {
			throw new Exception(Loc::getMessage("ERRORS_INSTALL_COMPONENT"));
		}
	}

	public function DoUninstall() {
		global $APPLICATION;
		if(!check_bitrix_sessid()) return false;
		try {
			$this->unInstallComponent();
			\Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
			$APPLICATION->IncludeAdminFile(Loc::getMessage("D2F_RSSOUT_UNSTEP1"), __DIR__."/unstep1.php");
		} catch (Exception $e) {
			$APPLICATION->ThrowException($e->getMessage());
			return false;
		}
		return true;
	}

	public function unInstallComponent() {
		DeleteDirFilesEx("/bitrix/components/dev2fun/rss.out");
	}
}
