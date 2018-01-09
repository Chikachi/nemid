<?php
namespace Nodes\NemId\Sign\Data;

class HTMLSignData implements ISignData {
	/**
	 * Replace tags with allowed tags that have same effect
	 */
	const REPLACEMENT_TAGS = [
		'<strong>' => '<b>',
		'</strong>' => '</b>',
		'<em>' => '<i>',
		'</em>' => '</i>',
	];
	/**
	 * Allowed HTML tags
	 * Taken from the NemID OCES documentation - https://www.nets.eu/dk-da/kundeservice/nemid-tjenesteudbyder/NemID-tjenesteudbyderpakken/Documents/NemID%20Integration%20-%20OCES.pdf
	 */
	const ALLOWED_TAGS = [
		'<html>',
		'<body>',
		'<head>',
		'<style>',
		'<title>',
		'<p>',
		'<div>',
		'<ul>',
		'<ol>',
		'<li>',
		'<h1>',
		'<h2>',
		'<h3>',
		'<h4>',
		'<h5>',
		'<h6>',
		'<font>',
		'<table>',
		'<tr>',
		'<th>',
		'<td>',
		'<i>',
		'<b>',
		'<u>',
		'<center>',
		'<a>',
	];
	/**
	 * HTML content
	 *
	 * @var string|null
	 */
	private $html;

	/**
	 * HTMLSignData constructor.
	 *
	 * @param string $html
	 */
	public function __construct($html = null) {
		$this->setHtml($html);
	}

	/**
	 * Get the HTML content
	 *
	 * @return string|null
	 */
	public function getHtml() {
		return $this->html;
	}

	/**
	 * Sets and cleans up the HTML content
	 *
	 * @param string $html
	 *
	 * @return HTMLSignData
	 */
	public function setHtml($html) {
		$this->html = strip_tags(
			str_replace(
				array_keys(self::REPLACEMENT_TAGS),
				array_values(self::REPLACEMENT_TAGS),
				$html
			),
			implode(',', self::ALLOWED_TAGS)
		);

		return $this;
	}

	/**
	 * Check if HTML content is set
	 *
	 * @return bool
	 */
	public function isHtmlSet() {
		return $this->getHtml() !== null;
	}

	/**
	 * Get params for signing
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getParams() {
		if (!$this->isHtmlSet()) {
			throw new \Exception('Missing HTML');
		}

		return [
			'SIGNTEXT' => base64_encode($this->getHtml()),
			'SIGNTEXT_REMOTE_HASH' => base64_encode(hash('sha256', $this->getHtml())),
			'SIGNTEXT_FORMAT' => 'HTML',
		];
	}
}