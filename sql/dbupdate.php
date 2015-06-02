<#1>
	<?php

	$fields = array(
		'id' => array(
			'type' => 'integer',
			'length' => 4,
			'notnull' => true
		),
		'is_online' => array(
			'type' => 'integer',
			'length' => 1,
			'notnull' => true
		),
		'latitude' => array(
			'type' => 'float',
		),
		'longitude' => array(
			'type' => 'float',
		),
		'elevation' => array(
			'type' => 'float',
		),
		'address' => array(
			'type' => 'text',
			'length' => 256,
			'notnull' => false
		),
		'init_mob_id' => array(
			'type' => 'integer',
			'length' => 4,
			'notnull' => false
		),
		'comment_mob_id' => array(
			'type' => 'integer',
			'length' => 4,
		),
		'container_id' => array(
			'type' => 'integer',
			'length' => 4,
		)
	);

	$ilDB->createTable("rep_robj_xlel_data", $fields);
	$ilDB->addPrimaryKey("rep_robj_xlel_data", array("id"));


	$fields = array(
		'id' => array(
			'type' => 'integer',
			'length' => 4,
			'notnull' => true
		),
		'ref_id' => array(
			'type' => 'integer',
			'length' => 4,
		),
		'parent_id' => array(
			'type' => 'integer',
			'length' => 4,
		),
		'user_id' => array(
			'type' => 'integer',
			'length' => 4,
		),
		'title' => array(
			'type' => 'text',
			'length' => 256,
		),
		'description' => array(
			'type' => 'text',
			'length' => 256,
		),
		'body' => array(
			'type' => 'clob'
		),
		'creation_date' => array(
			'type' => 'timestamp',
		),
		'media_id' => array(
			'type' => 'integer',
			'length' => 4,
		)
	);

	$ilDB->createTable("rep_robj_xlel_comments", $fields);
	$ilDB->addPrimaryKey("rep_robj_xlel_comments", array("id"));
	$ilDB->createSequence("rep_robj_xlel_comments");

	?>

<#2>
		<?php

		include_once('./Customizing/global/plugins/Services/Repository/RepositoryObject/LearnLoc/classes/class.ilLearnLocPlugin.php');

		$fields = array(
			ilLearnLocPlugin::_getType() . '_key' => array(
				'type' => 'text',
				'length' => 64,
			),
			ilLearnLocPlugin::_getType() . '_value' => array(
				'type' => 'text',
				'length' => 64,
			)
		);

		$ilDB->createTable('rep_robj_'.ilLearnLocPlugin::_getType().'_conf', $fields);
		$ilDB->addPrimaryKey('rep_robj_'.ilLearnLocPlugin::_getType().'_conf', array(ilLearnLocPlugin::_getType() . '_key'));
		?>
<#3>
	<?php

	$ilDB->addTableColumn("rep_robj_xlel_data", "export_kw", array("type" => "text", "length" => 1024));

	?>
<#4>
		<?php

		if(!$ilDB->tableExists('rep_robj_xlel_conf')) {
			$fields = array(
				'lel_key' => array(
					'type' => 'text',
					'length' => 64,
				),
				'lel_value' => array(
					'type' => 'text',
					'length' => 64,
				)
			);

			$ilDB->createTable("rep_robj_xlel_conf", $fields);
			$ilDB->addPrimaryKey("rep_robj_xlel_conf", array("lel_key"));
		}

		?>