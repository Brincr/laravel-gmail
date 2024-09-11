<?php

namespace Dacastro4\LaravelGmail\Traits;

use Google_Service_Gmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

/**
 * Trait Configurable
 * @package Dacastro4\LaravelGmail\Traits
 */
trait Configurable
{

	protected $additionalScopes = [];
	private $_config;
	private $configObject;

	public function __construct($config)
	{
		$this->_config = $config;
	}

	public function setConfiguration($config)
	{
		$this->configObject = $config;
	}

	public function setState($state) {
		if ($state === null) {
			return;
		}
		$this->_config['gmail.state'] = $state;
	}

	public function config($string = null)
	{
		if ($this->configObject) {
			if ($string) {
				if (isset($this->configObject[$string])) {
					return $this->configObject[$string];
				}
			}
			return $this->configObject;
		}

		return null;
	}

	/**
	 * @return array
	 */
	public function getConfigs()
	{
		return [
			'client_secret' => $this->_config['gmail.client_secret'],
			'client_id' => $this->_config['gmail.client_id'],
			'redirect_uri' => url($this->_config['gmail.redirect_url']),
			'state' => isset($this->_config['gmail.state']) ? $this->_config['gmail.state'] : null,
		];
	}

	public function setAdditionalScopes(array $scopes)
	{
		$this->additionalScopes = $scopes;

		return $this;
	}

	private function configApi()
	{
		$type = $this->_config['gmail.access_type'];
		$approval_prompt = $this->_config['gmail.approval_prompt'];
		$prompt = $this->_config['gmail.prompt'];

		$this->setScopes($this->getUserScopes());

		$this->setAccessType($type);

		$this->setApprovalPrompt($approval_prompt);

		$this->setPrompt($prompt);
	}

	public abstract function setScopes($scopes);

	private function getUserScopes()
	{
		return $this->mapScopes();
	}

	private function mapScopes()
	{
		$scopes = array_merge($this->_config['gmail.scopes'] ?? [], $this->additionalScopes);
		$scopes = array_unique(array_filter($scopes));
		$mappedScopes = [];

		if (!empty($scopes)) {
			foreach ($scopes as $scope) {
				$mappedScopes[] = $this->scopeMap($scope);
			}
		}

		return array_merge($mappedScopes, $this->_config['gmail.additional_scopes'] ?? []);
	}

	private function scopeMap($scope)
	{
		$scopes = [
			'all' => Google_Service_Gmail::MAIL_GOOGLE_COM,
			'compose' => Google_Service_Gmail::GMAIL_COMPOSE,
			'insert' => Google_Service_Gmail::GMAIL_INSERT,
			'labels' => Google_Service_Gmail::GMAIL_LABELS,
			'metadata' => Google_Service_Gmail::GMAIL_METADATA,
			'modify' => Google_Service_Gmail::GMAIL_MODIFY,
			'readonly' => Google_Service_Gmail::GMAIL_READONLY,
			'send' => Google_Service_Gmail::GMAIL_SEND,
			'settings_basic' => Google_Service_Gmail::GMAIL_SETTINGS_BASIC,
			'settings_sharing' => Google_Service_Gmail::GMAIL_SETTINGS_SHARING,
		];

		return Arr::get($scopes, $scope);
	}

	public abstract function setAccessType($type);

	public abstract function setApprovalPrompt($approval);

	public abstract function setPrompt($prompt);
}
