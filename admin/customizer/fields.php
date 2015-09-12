<?php 

$fields = [];

$fields['footer'] = [
	'title' => 'Footer',
	'priority' => 130,
	'sections' => [
		'copyright' => [
			'title' => 'Copyright',
			'settings' => [
				'copyright_text' => [
					'label' => 'Copyright Text',
					'type' => 'textarea'
				]
			]
		]
	]
];

$fields['advertisement'] = [
	'title' => 'Advertisement',
	'priority' => 130,
	'sections' => [
		'advertising' => [
			'title' => 'Advertisements',
			'settings' => [
				'background_ad' => [
					'label' => 'Background Image Ad',
					'type' => 'image',
				],
				'leaderboard_ad' => [
					'label' => 'Leaderboard Ad',
					'type' => 'textarea',
				]
			]
		]
	]
];

require 'customizer.php';
new TD_Customizer($fields);