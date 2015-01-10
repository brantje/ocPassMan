<?php
/**
 * ownCloud - passman
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Sander Brand <brantje@gmail.com>
 * @copyright Sander Brand 2014
 */
namespace OCA\Passman;

class Activity implements \OCP\Activity\IExtension {
	const TYPE_ITEM_CREATED = 'passman_item_created';
	const TYPE_ITEM_EDITED = 'passman_item_edited';
	const TYPE_ITEM_APPLY_REV = 'passman_item_apply_revision';
	const TYPE_ITEM_DELETED = 'passman_item_deleted';
	const TYPE_ITEM_RECOVERED = 'passman_item_recovered';
	const TYPE_ITEM_DESTROYED = 'passman_item_destroyed';
	const TYPE_ITEM_EXPIRED = 'passman_item_expired';
	const TYPE_ITEM_SHARED = 'passman_item_shared';

	const SUBJECT_ITEM_CREATED = 'item_created';
	const SUBJECT_ITEM_EDITED = 'item_edited';
	const SUBJECT_APPLY_REV = 'item_apply_revision';
	const SUBJECT_ITEM_DELETED = 'item_deleted';
	const SUBJECT_ITEM_RECOVERED = 'item_recovered';
	const SUBJECT_ITEM_DESTROYED = 'item_destroyed';
	const SUBJECT_ITEM_EXPIRED = 'item_expired';
	const SUBJECT_ITEM_SHARED = 'item_shared';
	/*
	const SUBJECT_REMOTE_SHARE_ACCEPTED = 'remote_share_accepted';
	const SUBJECT_REMOTE_SHARE_DECLINED = 'remote_share_declined';
	const SUBJECT_REMOTE_SHARE_UNSHARED = 'remote_share_unshared';
	const SUBJECT_PUBLIC_SHARED_FILE_DOWNLOADED = 'public_shared_file_downloaded';
	const SUBJECT_PUBLIC_SHARED_FOLDER_DOWNLOADED = 'public_shared_folder_downloaded';
	/**
	 * The extension can return an array of additional notification types.
	 * If no additional types are to be added false is to be returned
	 *
	 * @param string $languageCode
	 * @return array|false
	 */
	public function getNotificationTypes($languageCode) {
		$l = \OC::$server->getL10N('passman', $languageCode);
		return array(
			self::TYPE_ITEM_CREATED => $l->t('[Passman] item creations'),
			self::TYPE_ITEM_EDITED => $l->t('[Passman] item edits'),
			self::TYPE_ITEM_APPLY_REV => $l->t('[Passman] Revert to a revision'),
			self::TYPE_ITEM_DELETED => $l->t('[Passman] Item deleted'),
			self::TYPE_ITEM_RECOVERED => $l->t('[Passman] Item recovered'),
			self::TYPE_ITEM_DESTROYED => $l->t('[Passman] Item destroyed'),
			self::TYPE_ITEM_EXPIRED => $l->t('[Passman] Item expires'),
			self::TYPE_ITEM_SHARED => $l->t('[Passman] Item is shared')
		);
	}
	/**
	 * The extension can filter the types based on the filter if required.
	 * In case no filter is to be applied false is to be returned unchanged.
	 *
	 * @param array $types
	 * @param string $filter
	 * @return array|false
	 */
	public function filterNotificationTypes($types, $filter) {
		return $types;
	}
	/**
	 * For a given method additional types to be displayed in the settings can be returned.
	 * In case no additional types are to be added false is to be returned.
	 *
	 * @param string $method
	 * @return array|false
	 */
	public function getDefaultTypes($method) {
		if ($method === 'stream') {
			return array(self::TYPE_ITEM_CREATED, self::TYPE_ITEM_EDITED, self::TYPE_ITEM_APPLY_REV,self::TYPE_ITEM_DELETED,self::TYPE_ITEM_RECOVERED,self::TYPE_ITEM_DESTROYED,self::TYPE_ITEM_EXPIRED,self::TYPE_ITEM_SHARED);
		}
		return false;
	}
	/**
	 * The extension can translate a given message to the requested languages.
	 * If no translation is available false is to be returned.
	 *
	 * @param string $app
	 * @param string $text
	 * @param array $params
	 * @param boolean $stripPath
	 * @param boolean $highlightParams
	 * @param string $languageCode
	 * @return string|false
	 */
	public function translate($app, $text, $params, $stripPath, $highlightParams, $languageCode) {
		$l = \OC::$server->getL10N('passman', $languageCode);
		if (!$text) {
			return '';
		}
		if ($app === 'passman') {
			switch ($text) {
				case self::SUBJECT_ITEM_CREATED:
					return $l->t('%1$s has been created by %2$s', $params)->__toString();
				case self::SUBJECT_ITEM_EDITED:
					return $l->t('%1$s has been updated by %2$s', $params)->__toString();
				case self::SUBJECT_APPLY_REV:
					return $l->t('%2$s has revised %1$s to revision %3$s', $params)->__toString();
				case self::SUBJECT_ITEM_DELETED:
					return $l->t('%1$s has been deleted by %2$s', $params)->__toString();
				case self::SUBJECT_ITEM_RECOVERED:
					return $l->t('%1$s has been recovered by %2$s', $params)->__toString();
				case self::SUBJECT_ITEM_DESTROYED:
					return $l->t('%1$s has been permanently deleted by %2$s', $params)->__toString();
				case self::SUBJECT_ITEM_EXPIRED:
					return $l->t('The password of %s is expired, renew it now.', $params)->__toString();
				case self::SUBJECT_ITEM_SHARED:
					return $l->t('%s has been shared', $params)->__toString();
			}
			return false;
		}
		return false;
	}
	/**
	 * The extension can define the type of parameters for translation
	 *
	 * Currently known types are:
	 * * file => will strip away the path of the file and add a tooltip with it
	 * * username => will add the avatar of the user
	 *
	 * @param string $app
	 * @param string $text
	 * @return array|false
	 */
	public function getSpecialParameterList($app, $text) {
		/*if ($app === 'files_sharing') {
			switch ($text) {
				case self::SUBJECT_REMOTE_SHARE_ACCEPTED:
				case self::SUBJECT_REMOTE_SHARE_DECLINED:
				case self::SUBJECT_REMOTE_SHARE_UNSHARED:
					return array(
						0 => '',// We can not use 'username' since the user is in a different ownCloud
						1 => 'file',
					);
				case self::SUBJECT_PUBLIC_SHARED_FOLDER_DOWNLOADED:
				case self::SUBJECT_PUBLIC_SHARED_FILE_DOWNLOADED:
					return array(
						0 => 'file',
					);
			}
		}*/
		return false;
	}
	/**
	 * A string naming the css class for the icon to be used can be returned.
	 * If no icon is known for the given type false is to be returned.
	 *
	 * @param string $type
	 * @return string|false
	 */
	public function getTypeIcon($type) {
		switch ($type) {
			case self::TYPE_ITEM_CREATED:
				return 'icon-lock';
			case self::TYPE_ITEM_APPLY_REV:
				return 'icon-lock';
			case self::TYPE_ITEM_DELETED:
				return 'icon-lock';
			case self::TYPE_ITEM_RECOVERED:
				return 'icon-lock';
			case self::TYPE_ITEM_DESTROYED:
				return 'icon-lock';
			case self::TYPE_ITEM_EXPIRED:
				return 'icon-lock';
			case self::TYPE_ITEM_SHARED:
				return 'icon-share';
			case self::TYPE_ITEM_EDITED:
				return 'icon-lock';
		}
		return false;
	}
	/**
	 * The extension can define the parameter grouping by returning the index as integer.
	 * In case no grouping is required false is to be returned.
	 *
	 * @param array $activity
	 * @return integer|false
	 */
	public function getGroupParameter($activity) {
		return false;
	}
	/**
	 * The extension can define additional navigation entries. The array returned has to contain two keys 'top'
	 * and 'apps' which hold arrays with the relevant entries.
	 * If no further entries are to be added false is no be returned.
	 *
	 * @return array|false
	 */
	public function getNavigation() {
		return false;
	}
	/**
	 * The extension can check if a customer filter (given by a query string like filter=abc) is valid or not.
	 *
	 * @param string $filterValue
	 * @return boolean
	 */
	public function isFilterValid($filterValue) {
		return false;
	}
	/**
	 * For a given filter the extension can specify the sql query conditions including parameters for that query.
	 * In case the extension does not know the filter false is to be returned.
	 * The query condition and the parameters are to be returned as array with two elements.
	 * E.g. return array('`app` = ? and `message` like ?', array('mail', 'ownCloud%'));
	 *
	 * @param string $filter
	 * @return array|false
	 */
	public function getQueryForFilter($filter) {
		if ($filter === 'passwords') {
			return array('`app` = ? and `type` = ?', array('passman', self::TYPE_ITEM_CREATED));
		}
		return false;
	}
}